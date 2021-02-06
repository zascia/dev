<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Merchants_Bl_Invoice
{
    var $blAffiliate;
    var $blCommunications;
    
    var $userDetails;
    var $settings;
    var $invoiceNumber;

    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Bl_Invoice() {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');
        
        $this->settings = $GLOBALS['Auth']->getSettings();
    }
    
    
	//--------------------------------------------------------------------------

    function getFilledInvoice($userid, $amount) {
        if ($userid == '') return 'User ID not provided';
        if ($amount == '') return 'Amount not provided';

        $params = $this->blAffiliate->loadUserInfoAsArray($userid);
        $this->userDetails = $params;
        
        if ($this->settings['Aff_round_numbers'] != '' && $this->settings['Aff_round_numbers'] > 0) {
            $roundNumbers = $this->settings['Aff_round_numbers'];
        } else {
            $roundNumbers = 2;
        }
        $params['amount'] = round($amount, $roundNumbers);
        if ($params['vat_is_company'] == '1') {
            $invoice = $this->settings['Aff_payout_invoice_vat'];
            $subject = $this->settings['Aff_payout_invoice_subject_vat'];
            $params['amount_with_vat'] = round($amount, $roundNumbers);
            $params['amount_without_vat'] = round(($amount/(1+$params['vat_percentage']/100)), $roundNumbers);
            $params['amount_vat'] = round(($params['amount_with_vat'] - $params['amount_without_vat']), $roundNumbers);  
        } else {
            $invoice = $this->settings['Aff_payout_invoice'];
            $subject = $this->settings['Aff_payout_invoice_subject'];
        }
        
        return array('subject' => $this->replaceConstantsInInvoice($subject, $params),
                     'text'    => $this->replaceConstantsInInvoice($invoice, $params, false));
    }
    
    //--------------------------------------------------------------------------

    function replaceConstantsInInvoice($invoice, $params, $increaseInvoiceNumber = true) {
        $invoice = Qcore_Bl_Communications::replaceInNews($params, array($invoice));
        $invoice = $invoice[0];
        
        $invoice = str_replace('$Affiliate_vat_percentage',               $params['vat_percentage'], $invoice);
        $invoice = str_replace('$Affiliate_vat_number',                   $params['vat_number'], $invoice);
        $invoice = str_replace('$Affiliate_amount_of_registered_capital', $params['vat_amountofcapital'], $invoice);
        $invoice = str_replace('$Affiliate_vat_registration_number',      $params['vat_registrationnumber'], $invoice);
        
        if ($params['vat_invoicenumber'] == '') $params['vat_invoicenumber'] = 0;
        if ($increaseInvoiceNumber) {
            QCore_Settings::_update('Aff_vat_invoicenumber', $params['vat_invoicenumber']+1, SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), $params['userid']);
        }
        $invoice = str_replace('$Affiliate_invoice_number', $params['vat_invoicenumber'], $invoice);
        
        $invoice = str_replace('$Affiliate_amount_without_vat',  $params['amount_without_vat'], $invoice);
        $invoice = str_replace('$Affiliate_amount_with_vat',  $params['amount_with_vat'], $invoice);
        $invoice = str_replace('$Affiliate_amount_vat',  $params['amount_vat'], $invoice);
        $invoice = str_replace('$Affiliate_amount',  $params['amount'], $invoice);
        
        return $invoice;
    }
    
    //--------------------------------------------------------------------------

    function sendInvoice($userid, $amount, $sendto = SEND_TO_MERCHANT) {
        $invoice = $this->getFilledInvoice($userid, $amount);
        
        switch ($sendto) {
            case SEND_TO_MERCHANT:
                $this->sendInvoiceToMerchant($invoice);
                break;
                
            case SEND_TO_AFFILIATE:
                $this->sendInvoiceToAffiliate($invoice);
                break;
                
            case SEND_TO_MERCHANTANDAFFILIATE:
                $this->sendInvoiceToMerchant($invoice);
                $this->sendInvoiceToAffiliate($invoice);
                break;
        }
    }
    
    //--------------------------------------------------------------------------

    function sendInvoiceToMerchant($invoice) {
        $emailParams = array(
            'email' => $this->settings['Aff_notifications_email'],
            'subject' => $invoice['subject'],
            'text' => $invoice['text'],
            'returnpath' => $this->userDetails['username'],
            'returnpath_name' => $this->userDetails['name'].' '.$this->userDetails['surname'],
            'settings' => $GLOBALS['Auth']->getSettings());
                
        $emailParams['settings']['Aff_system_email_name'] = $this->userDetails['name'].' '.$this->userDetails['surname'];
        $emailParams['settings']['Aff_system_email'] = $this->userDetails['username'];
        
        $this->blCommunications->sendEmail($emailParams);
    }
    
	//--------------------------------------------------------------------------

    function sendInvoiceToAffiliate($invoiceText) {
        $emailParams = array(
            'email' => $this->userDetails['username'],
            'subject' => $invoice['subject'],
            'text' => $invoice['text']);
        $this->blCommunications->sendEmail($emailParams);
    }
}
?>
