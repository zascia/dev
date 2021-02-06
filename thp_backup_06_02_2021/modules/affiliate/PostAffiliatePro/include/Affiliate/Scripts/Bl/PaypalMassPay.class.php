<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

require_once 'Services/PayPal.php';
require_once 'Services/PayPal/Profile/Handler/File.php';
require_once 'Services/PayPal/Profile/API.php';
QUnit_Global::includeClass('QCore_History');

class Affiliate_Scripts_Bl_PaypalMassPay
{
    var $blAccounting;
    
    //--------------------------------------------------------------------------

    function Affiliate_Scripts_Bl_PaypalMassPay() {
        $this->blAccounting =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Accounting');
    }
    
    //--------------------------------------------------------------------------

    function process($params) {
        if (!$this->isTimeToRun()) {
            return false;
        }
                
        $this->processMassPay();
    }
    
    //--------------------------------------------------------------------------
    
    function isTimeToRun() {
        $account_settings = QCore_Settings::getAccountsSettings();
        $account_settings = $account_settings[$GLOBALS['Auth']->getAccountID()];
        if ($account_settings['Aff_pp_periodicity'] == PERIODICITY_WEEKLY) {
            return (date('w') == $account_settings['Aff_pp_dayofpay']);
        }
        if ($account_settings['Aff_pp_periodicity'] == PERIODICITY_MONTHLY) {
            $days = explode(";", $account_settings['Aff_pp_dayofpay']);
            $daysInMonth = date("t");
            foreach ($days as $i => $day) {
                if ($day > $daysInMonth) {
                    $days[$i] = $daysInMonth;
                }
            }
            $days = array_unique($days);
            if (in_array(date('j'), $days)) {
                return true;
            }
        }
        
        return false;
    }
    
    //--------------------------------------------------------------------------
     
    function getPaymentData() {
        $conditions = array(
            'CampaignID' => '',
            'UserID' => '',
            'TransactionType' => '',
            'Status' => '',
            'page' => '',
            'rowsPerPage' => '',
            'day1'   => 1,
            'month1' => 1,
            'year1'  => getMinYear(array('wd_pa_transactions' => 'dateinserted')),
            'day2'   => date("j"),
            'month2' => date("n"),
            'year2'  => date("Y")
        );

        $objStatistics =& QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleStatistics');
        $transdata  = $objStatistics->getTransactionsSummaries($conditions);
        $paypaldata = array();
        
        foreach ($transdata as $userid => $userdata) {
            if(strstr($userdata['payout_type'], 'paypal') == false) {
                continue;
            }
            if($userdata['approved'] < $userdata['minpayout']) {
                continue;
            }
            $paypaldata[$userid] = array('email' => $userdata['username'],
                                         'topay' => $userdata['approved']);
        }
        
        return $paypaldata;
    }
    
    //--------------------------------------------------------------------------
    
    function markAsPaid($userIDs) {
        $params = array();
        $params['userids'] = $userIDs;
        $params['accounting_note'] = '';
        $params['y1'] = 1990;
        $params['m1'] = 1;
        $params['d1'] = 1;
        $params['y2'] = date("Y");
        $params['m2'] = date("n");
        $params['d2'] = date("j");
        $params['date1'] = $params['y1'].'-'.$params['m1'].'-'.$params['d1'];
        $params['date2'] = $params['y2'].'-'.$params['m2'].'-'.$params['d2'];
        
        $this->blAccounting->markAsPaid($params, false);
    }
    
    //--------------------------------------------------------------------------
    
    function processMassPay() {
        $account_settings = QCore_Settings::getAccountsSettings();
        $account_settings = $account_settings[$GLOBALS['Auth']->getAccountID()];
        $settings = array('username' => $account_settings['Aff_pp_username'],
                          'password' => $account_settings['Aff_pp_password'],
                          'currency' => $account_settings['Aff_pp_currency'],
                          'subject'  => $account_settings['Aff_pp_emailsubject'],
                          'certpath' => $GLOBALS['PROJECT_ROOT_PATH'].'/exports/',
                          'certfile' => 'cert_'.$GLOBALS['Auth']->getAccountID());
        
        $all_data = $this->getPaymentData();
        $all_data = array_chunk($all_data, 250, true);
        
        foreach ($all_data as $data) {
            if (count($data) != 0) {
                $this->sendMassPayRequest($data, $settings);
            }
        }
    }
    
    //--------------------------------------------------------------------------
    
    function sendMassPayRequest($data, $settings) {
        $handler =& ProfileHandler_File::getInstance(array ('path' => $settings['certpath'], 'charset' => 'iso-8859-1',));

        if (Services_PayPal::isError($handler)) {
            var_dump($handler->getMessage());
            exit;
        }

        $profile =& APIProfile::getInstance($settings['certfile'], $handler);

        if (Services_PayPal::isError($profile)) {
            QCore_History::log(WLOG_ERROR, $this->my_var_dump($profile->getMessage()), __FILE__, __LINE__);
            exit;
        }

        $profile->setAPIPassword($settings['password']);

        $caller =& Services_PayPal::getCallerServices($profile);

        if (Services_PayPal::isError($caller)) {
            QCore_History::log(WLOG_ERROR, $this->my_var_dump($caller->getMessage()), __FILE__, __LINE__);
            exit;
        }

        // Item 0 - this does nothing
        $Amount =& Services_PayPal::getType('BasicAmountType');
        if (Services_PayPal::isError($Amount)) {
            QCore_History::log(WLOG_ERROR, $this->my_var_dump($Amount), __FILE__, __LINE__);
            exit;
        }
        $Amount->setattr('currencyID', 'USD');
        $Amount->setval('1', 'iso-8859-1');
        $MassPayItem =& Services_PayPal::getType('MassPayRequestItemType');
        if (Services_PayPal::isError($MassPayItem)) {
            QCore_History::log(WLOG_ERROR, $this->my_var_dump($MassPayItem), __FILE__, __LINE__);
            exit;
        }
        $MassPayItem->setAmount($Amount);
        $MassPayItem->setReceiverEmail('tmp@tmp.tmp', 'iso-8859-1');
        
        // Send MassPay
        $GLOBALS['mySoapData'] = $this->generateRequest($data, $settings);
        
        $MassPay =& Services_PayPal::getType('MassPayRequestType');

        if (Services_PayPal::isError($MassPay)) {
            QCore_History::log(WLOG_ERROR, $this->my_var_dump($MassPay), __FILE__, __LINE__);
            exit;
        }

        $MassPay->setEmailSubject("Email subject");
        $MassPay->setMassPayItem($MassPayItem);
        
        $result = $caller->MassPay($MassPay);

        if (Services_PayPal::isError($result)) { 
            QCore_History::log(WLOG_ERROR, $this->my_var_dump($result), __FILE__, __LINE__);
        } else {
            // Success
            if ($result->Ack == 'Success') {
                $this->markAsPaid(array_keys($data));
                QCore_History::log(WLOG_DEBUG, 'PayPal API: MassPay success', __FILE__, __LINE__);
            } else {
                $errormsg = '';
                if (is_array($result->Errors)) {
                    foreach ($result->Errors as $error) {
                        $errormsg .= $error->LongMessage.($errormsg == '' ? '' : ",");
                    }
                } else {
                    $errormsg = $result->Errors->LongMessage;
                }
                QCore_History::log(WLOG_ERROR, 'PayPal API: '.$errormsg, __FILE__, __LINE__);
            }
        }
        
    }
    
    //--------------------------------------------------------------------------
    
    function generateRequest($data, $settings) {
        $header = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
            '<SOAP-ENV:Envelope  xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"'."\n".
            ' xmlns:xsd="http://www.w3.org/2001/XMLSchema"'."\n".
            ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'."\n".
            ' xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"'."\n".
            ' xmlns:ns4="urn:ebay:apis:eBLBaseComponents"'."\n".
            ' SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">'."\n".
            '<SOAP-ENV:Header>'."\n".
            '<RequesterCredentials xmlns="urn:ebay:api:PayPalAPI" SOAP-ENV:actor="http://schemas.xmlsoap.org/soap/actor/next" SOAP-ENV:mustUnderstand="1">'."\n".
            '<ns4:Credentials xmlns:ebl="urn:ebay:apis:eBLBaseComponents">'."\n".
            '<ns4:Username xsi:type="xsd:string">'.$settings['username'].'</ns4:Username>'."\n".
            '<ns4:Password xsi:type="xsd:string">'.$settings['password'].'</ns4:Password>'."\n".
            '<ns4:Subject xsi:type="xsd:string"></ns4:Subject></ns4:Credentials></RequesterCredentials>'."\n".
            '</SOAP-ENV:Header>'."\n".
            '<SOAP-ENV:Body>'."\n".
            ''."\n".
            '<MassPayReq xmlns="urn:ebay:api:PayPalAPI">'."\n".
            '<MassPayRequest>'."\n".
            '<ns4:Version xsi:type="xsd:string">1</ns4:Version>'."\n".
            '<EmailSubject xsi:type="xsd:string">'.$settings['subject'].'</EmailSubject>'."\n";

        $items = '';
        foreach($data as $userid => $itemdata) {
            $items .= '<MassPayItem>'."\n".
                '<ReceiverEmail>'.$itemdata['email'].'</ReceiverEmail>'."\n".
                '<Amount xsi:type="xsd:string" currencyID="'.$settings['currency'].'">'.$itemdata['topay'].'</Amount>'."\n".
                '</MassPayItem>'."\n";
        }
        
        $footer = '</MassPayRequest>'."\n".
            '</MassPayReq>'."\n".
            '</SOAP-ENV:Body>'."\n".
            '</SOAP-ENV:Envelope>'."\n";
            
        return $header.$items.$footer;
    }
    
    //--------------------------------------------------------------------------
    
    function my_var_dump($var) {
        ob_start();
        var_dump($var);
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }
}
?>
