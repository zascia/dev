<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_History');

class Affiliate_Merchants_Bl_Accounting
{
    function Affiliate_Merchants_Bl_Accounting() {
        $this->blSaleStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleStatistics');
        $this->blPayoutOptions =& QUnit_Global::newObj('Affiliate_Merchants_Bl_PayoutOptions');        
    }

    //--------------------------------------------------------------------------
    
    function decline($params)
    {
        $userIDs = $params['userids'];
        if(!is_array($userIDs) || count($userIDs) < 1)
            return false;

        $chunkedUserIDs = my_array_chunk($userIDs, WD_MAX_PROCESSED_IDS);
        
        foreach($chunkedUserIDs as $userIDsArray)
        {
            $userIDSql = "('".implode("','", $userIDsArray)."')";
            
            // update commissions to denied
            $sql =  "update wd_pa_transactions ".
                    "set payoutstatus=".AFFSTATUS_SUPPRESSED.",datepayout=".sqlNow().
                    " where rstatus=".AFFSTATUS_APPROVED.
                    "   and payoutstatus=".AFFSTATUS_NOTAPPROVED.
                    "   and affiliateid in ".$userIDSql.
                    "   and accountid="._q($GLOBALS['Auth']->getAccountID());
            
            $sql .= " and (".sqlToDays('dateinserted')." >= ".sqlToDays($params['date1']).")".
                    " and (".sqlToDays('dateinserted')." <= ".sqlToDays($params['date2']).")";
                   
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$ret)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        return true;
    }    
    
    //--------------------------------------------------------------------------

    function createAccountingRecord($params) {
        $AccountingID = QCore_Sql_DBUnit::createUniqueID('wd_pa_accounting', 'accountingid');
        $sql = "insert into wd_pa_accounting(".
            " accountingid, ".
            " dateinserted, ".
            " datefrom, ".
            " dateto, ".
            " note".
            ") values (".
            _q($AccountingID).",".
            sqlNow().",".
            _q($params['date1']).",".
            _q($params['date2']).",".
            _q($params['accounting_note']).")";
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        return $AccountingID;
    }
    
	//--------------------------------------------------------------------------

    function markUserCommissionsAsPaid($userID, $AccountingID, $params) {     
        // update commissions to approved or denyed
        $sql =  "update wd_pa_transactions ".
                "set payoutstatus=".AFFSTATUS_APPROVED.",datepayout=".sqlNow().
                "   ,accountingid="._q($AccountingID).
                " where rstatus=".AFFSTATUS_APPROVED.
                "   and payoutstatus=".AFFSTATUS_NOTAPPROVED.
                "   and affiliateid="._q($userID).
                "   and accountid="._q($GLOBALS['Auth']->getAccountID());
        $sql .= " and (".sqlToDays('dateinserted')." >= ".sqlToDays($params['date1']).")".
                " and (".sqlToDays('dateinserted')." <= ".sqlToDays($params['date2']).")";
                    
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        return true;
    }
    
    //--------------------------------------------------------------------------

    function getCommissionsAmount($userID, $AccountingID) {
        $sql =  "select sum(commission) as amount from wd_pa_transactions ".
                " where rstatus=".AFFSTATUS_APPROVED.
                "   and payoutstatus=".AFFSTATUS_APPROVED.
                "   and affiliateid="._q($userID).
                "   and accountingid="._q($AccountingID);
                "   and accountid="._q($GLOBALS['Auth']->getAccountID());
                    
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        return $rs->fields['amount'];     
    }
    
    
    //--------------------------------------------------------------------------
    
    function markPaymentAsPaidAndSendInvoice($userid, $params) {
        $this->markUserCommissionsAsPaid($userid, $params['accountingID'],$params);
        $amount = $this->getCommissionsAmount($userid, $params['accountingID']);
        
        $invoice = QUnit_Global::newObj('Affiliate_Merchants_Bl_Invoice');
        $invoice->sendInvoice($userid, $amount, $params['send_invoice_to']);
    }

    //--------------------------------------------------------------------------

    function markAsPaid($params, $checkpayout_type = true)
    {
        $userIDs = $params['userids'];
        if(!is_array($userIDs) || count($userIDs) < 1)
        {
            return false;
        }
        
        $userIDs2 = array();
        
        foreach($userIDs as $userID)
        {
            if($_POST['payout_type_'.$userID] == '' && $checkpayout_type)
            {
                continue;
            }
                
            $userIDs2[] = $userID;
        }
        
        $userIDs = $userIDs2;
        if(!is_array($userIDs) || count($userIDs) < 1)
        {
            return false;
        }
        
        if (($AccountingID = $this->createAccountingRecord($params)) == false) {
            return false;
        }
        
        foreach($userIDs as $userID)
        {
            $this->markUserCommissionsAsPaid($userID, $AccountingID, $params);
        }
        
        return true;
    }

    //--------------------------------------------------------------------------
    
   /** checks that all selected users use the same payout option (to be able to 
    * generate export file
    */
    function checkSamePayoutOption($params)
    {
        $userIDs = $params['userids'];
        if(!is_array($userIDs) || count($userIDs) < 1)
        {
            return false;
        }
        
        $userIDs2 = array();
        
        $payoutOption = '';
        foreach($userIDs as $userID)
        {
            if($payoutOption == '')
            {
                $payoutOption = $_POST['payout_type_'.$userID];
            }
            else if($payoutOption != $_POST['payout_type_'.$userID])
            {
                return false;
            }
        }

        if($payoutOption == '')
        {
            return false;
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------

    function generateExportFile($params)
    {
        $userIDs = $params['userids'];
        if(!is_array($userIDs) || count($userIDs) < 1)
        {
            return false;
        }
        
        $payoutOption = $_POST['payout_type_'.$userIDs[0]];

        if($payoutOption == '')
        {
            QUnit_Messager::setErrorMessage(L_G_USERSMUSTHAVETHESAMEPAYOUTOPTION);
        }
        
        // get export format for this payout option
        $exportFormat = $this->blPayoutOptions->getExportFormat($payoutOption);
        
        if(!$exportFormat || $exportFormat == '')
        {
            QUnit_Messager::setErrorMessage(L_G_EXPORTFORMATNOTDEFINED);
            return false;
        }

        $payoutFields = $this->blPayoutOptions->getPayoutFieldsForOption($payoutOption);

        // prepare file for export
        $fileName = 'export'.date("Y_m_d").'_'.substr(md5(uniqid(rand(),1)), 0, 4).'.csv';
        $fullName = QUnit_GlobalFuncs::makePath($GLOBALS['Auth']->getSetting('Aff_export_dir'), $fileName);

        $exportFile = @fopen($fullName, "wb");
        if($exportFile == FALSE) 
        {
            QUnit_Messager::setErrorMessage(L_G_CANNOTWRITETOEXPORTDIR.$GLOBALS['Auth']->getSetting('Aff_export_dir'));
            return false;
        }

        // export users data
        $chunkedUserIDs = my_array_chunk($userIDs, WD_MAX_PROCESSED_IDS);
        
        $conditions = array(
                'CampaignID' => '',
                'UserID' => '',
                'TransactionType' => '',
                'Status' => '',
                'page' => '',
                'rowsPerPage' => '',
                'day1' => $_REQUEST['ap_day1'],
                'month1' => $_REQUEST['ap_month1'],
                'year1' => $_REQUEST['ap_year1'],
                'day2' => $_REQUEST['ap_day2'],
                'month2' => $_REQUEST['ap_month2'],
                'year2' => $_REQUEST['ap_year2']
        );

        foreach($chunkedUserIDs as $userIDsArray)
        {
            $userIDSql = "('".implode("','", $userIDsArray)."')";
            
            // select payout fields values for these users
            $payoutFieldsData = QCore_Settings::_getSettingsForMultipleUsers(SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(), $userIDsArray);

            $conditions['UserID'] = $userIDsArray;
            $transdata = $this->blSaleStat->getTransactionsSummaries($conditions);

            // select user data
            $sql =  "select * from wd_g_users ".
                    "  where userid in ".$userIDSql.
                    "   and accountid="._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            
            while(!$rs->EOF)
            {
                $pfForUser = $payoutFieldsData[$rs->fields['userid']];
                
                // replace payout fields in export format
                $line = $exportFormat;

                if(is_array($payoutFields) && count($payoutFields) > 0)
                {
                    foreach($payoutFields as $field)
                    {
                        $id = $field['payfieldid'];
                        $code = $field['code'];
                        
                        // get value for this field (from settings)
                        $value = $pfForUser['Aff_payoptionfield_'.$id];
                        
                        // replace code with value in export format
                        $line = str_replace($code, $value, $line);
                    }
                }

                // replace user data in export format
                $line = $this->replaceUserDataInExportFormat($line, $rs->fields);
                
                $line = str_replace('$Affiliate_amount', str_replace(".", ",", sprintf("%.2f", $transdata[$rs->fields['userid']]['approved'])), $line);

                $line = str_replace('\t', "\t", $line);
                $line = str_replace('\r', "\r", $line);
                $line = str_replace('\n', "\n", $line);
                
                fwrite($exportFile, $line);
                
                $rs->MoveNext();
            }
        }
        
        fclose($exportFile);
        
        return $fileName;
    }
    
    //--------------------------------------------------------------------------

    function replaceUserDataInExportFormat($text, $data)
    {
        $text = str_replace('$Date', date("Y m d"), $text);
        $text = str_replace('$Date_nospaces', date("Y_m_d"), $text);
        $text = str_replace('$Time', date("H i s"), $text);
        $text = str_replace('$Time_nospaces', date("H_i_s"), $text);
        $text = str_replace('$Affiliate_name', $data['name'].' '.$data['surname'], $text);
        $text = str_replace('$Affiliate_name', $data['name'].' '.$data['surname'], $text);
        $text = str_replace('$Affiliate_firstname', $data['name'], $text);
        $text = str_replace('$Affiliate_surname', $data['surname'], $text);
        $text = str_replace('$Affiliate_username', $data['username'], $text);
        $text = str_replace('$Affiliate_company_name', $data['company_name'], $text);
        $text = str_replace('$Affiliate_weburl', $data['weburl'], $text);
        $text = str_replace('$Affiliate_street', $data['street'], $text);
        $text = str_replace('$Affiliate_city', $data['city'], $text);
        $text = str_replace('$Affiliate_state', $data['state'], $text);
        $text = str_replace('$Affiliate_country', $data['country'], $text);
        $text = str_replace('$Affiliate_zipcode', $data['zipcode'], $text);
        $text = str_replace('$Affiliate_phone', $data['phone'], $text);
        $text = str_replace('$Affiliate_fax', $data['fax'], $text);
        $text = str_replace('$Affiliate_tax_ssn', $data['tax_ssn'], $text);
        $text = str_replace('$Affiliate_data1', $data['data1'], $text);
        $text = str_replace('$Affiliate_data2', $data['data2'], $text);
        $text = str_replace('$Affiliate_data3', $data['data3'], $text);
        $text = str_replace('$Affiliate_data4', $data['data4'], $text);
        $text = str_replace('$Affiliate_data5', $data['data5'], $text);
        
        return $text;
    }
    
    //--------------------------------------------------------------------------
    
    function getPayoutOptionForUser($userID, $day1 = '', $month1 = '', $year1 = '', $day2 = '', $month2 = '', $year2 = '')
    {
        $sql =  "select u.*, po.paybuttonformat from wd_g_users u, wd_pa_payoutoptions po ".
                "  where u.userid="._q($userID).
                "  and u.accountid="._q($GLOBALS['Auth']->getAccountID()).
                "  and po.payoptid=u.payoptid";

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        if($rs->EOF)
        {
            return false;
        }
        
        $payButton = $rs->fields['paybuttonformat'];

        $payButton = $this->replaceUserDataInExportFormat($payButton, $rs->fields);
        
        $conditions = array(
            'CampaignID' => '',
            'UserID' => $userID,
            'TransactionType' => '',
            'Status' => '',
            'page' => '',
            'rowsPerPage' => '',
            'day1' => $day1,
            'month1' => $month1,
            'year1' => $year1,
            'day2' => $day2,
            'month2' => $month2,
            'year2' => $year2
        );

        $transdata = $this->blSaleStat->getTransactionsSummaries($conditions);

        $payButton = str_replace('$Affiliate_amount', sprintf("%.2f", $transdata[$userID]['approved']), $payButton);
        
        $data = array();
        $data['userid'] = $userID;
        $data['paybuttonformat'] = $payButton;
        $data['transdata'] = $transdata[$userID];
        $data['amount'] = $transdata[$userID]['approved'];
        $data['name'] = $rs->fields['name'];
        $data['surname'] = $rs->fields['surname'];
        $data['username'] = $rs->fields['username'];
        $data['company_name'] = $rs->fields['company_name'];
        $data['weburl'] = $rs->fields['weburl'];
        $data['street'] = $rs->fields['street'];
        $data['city'] = $rs->fields['city'];
        $data['state'] = $rs->fields['state'];
        $data['country'] = $rs->fields['country'];
        $data['zipcode'] = $rs->fields['zipcode'];
        $data['phone'] = $rs->fields['phone'];
        $data['fax'] = $rs->fields['fax'];
        $data['tax_ssn'] = $rs->fields['tax_ssn'];
        $data['data1'] = $rs->fields['data1'];
        $data['data2'] = $rs->fields['data2'];
        $data['data3'] = $rs->fields['data3'];
        $data['data4'] = $rs->fields['data4'];
        $data['data5'] = $rs->fields['data5'];
        $data['payoptid'] = $rs->fields['payoptid'];
        
        $payout_fields = $this->blPayoutOptions->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED, $rs->fields['payoptid']);
        $userData = QCore_Settings::getUserSettings(SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(), $userID);
        
        $data['minpayout'] = $userData['Aff_min_payout'];

        if(is_array($payout_fields[$rs->fields['payoptid']])) 
        {
            foreach($payout_fields[$rs->fields['payoptid']] as $field)
            {
                $data['field'.$field['payfieldid']] = $userData['Aff_payoptionfield_'.$field['payfieldid']];
            }
        }
        
        $minMaxTransactionDates = $this->getMinMaxTransactionDates($userID);
        
        $data['date1'] = $minMaxTransactionDates['minInserted'];
        $data['date2'] = $minMaxTransactionDates['maxInserted'];
        
        // select payout fields values for these users
        $payoutFieldsData = QCore_Settings::_getSettings(SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(), $userID);
        
        foreach($payout_fields as $field2) {
            foreach($field2 as $field) {
                $id = $field['payfieldid'];
                $code = $field['code'];

                // get value for this field (from settings)
                $value = $payoutFieldsData['Aff_payoptionfield_'.$id];

                // replace code with value in export format
                $data['paybuttonformat'] = str_replace($code, $value, $data['paybuttonformat']);
            }
        }
        
        if ($day1 != '' && $month1 != '' && $year1 != '' && $day2 != '' && $month2 != '' && $year2 != '') {
            $data['seldate1'] = $year1.'-'.$month1.'-'.$day1;
            $data['seldate2'] = $year2.'-'.$month2.'-'.$day2;
        } else {
            $data['seldate1'] = $data['date1'];
            $data['seldate2'] = $data['date2'];
        }
        
        return $data;
    }

    //--------------------------------------------------------------------------
    
    function getMinMaxTransactionDates($userID)
    {
        $sql =  "select min(dateinserted) as mindateinserted, max(dateinserted) as maxdateinserted ".
                " from wd_pa_transactions ".
                " where payoutstatus=".AFFSTATUS_NOTAPPROVED.
                " and affiliateid="._q($userID).
                " and accountid="._q($GLOBALS['Auth']->getAccountID());
                
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $minInserted = $rs->fields['mindateinserted'];
        $maxInserted = $rs->fields['maxdateinserted'];
        $arr = array('minInserted' => $minInserted, 'maxInserted' => $maxInserted);
        
        if($minInserted == '')
        {
            $minInserted = date("Y-m-d");
            $maxInserted = date("Y-m-d");
        }
        else
        {
            $minInserted = substr($minInserted, 0, 10);
            $maxInserted = substr($maxInserted, 0, 10);
            
        }
        
        $arr = array('minInserted' => $minInserted, 'maxInserted' => $maxInserted);
        
        return $arr;
    }
    
    //--------------------------------------------------------------------------

    function generateMassPayData($params)
    {
        $userIDs = $params['userids'];
        if(!is_array($userIDs) || count($userIDs) < 1)
        {
            return false;
        }
        
        $payoutOption = $_POST['payout_type_'.$userIDs[0]];

        if($payoutOption == '')
        {
            QUnit_Messager::setErrorMessage(L_G_USERSMUSTHAVETHESAMEPAYOUTOPTION);
        }
        
        // get export format for this payout option
        $exportFormat = $this->blPayoutOptions->getExportFormat($payoutOption);
        
        if(!$exportFormat || $exportFormat == '')
        {
            QUnit_Messager::setErrorMessage(L_G_EXPORTFORMATNOTDEFINED);
            return false;
        }

        $payoutFields = $this->blPayoutOptions->getPayoutFieldsForOption($payoutOption);

        // prepare file for export
        $fileName = 'export'.date("Y_m_d").'_'.substr(md5(uniqid(rand(),1)), 0, 4).'.csv';
        $fullName = QUnit_GlobalFuncs::makePath($GLOBALS['Auth']->getSetting('Aff_export_dir'), $fileName);

        $exportFile = @fopen($fullName, "wb");
        if($exportFile == FALSE) 
        {
            QUnit_Messager::setErrorMessage(L_G_CANNOTWRITETOEXPORTDIR.$GLOBALS['Auth']->getSetting('Aff_export_dir'));
            return false;
        }

        // export users data
        $chunkedUserIDs = my_array_chunk($userIDs, WD_MAX_PROCESSED_IDS);
        
        $conditions = array(
                'CampaignID' => '',
                'UserID' => '',
                'TransactionType' => '',
                'Status' => '',
                'page' => '',
                'rowsPerPage' => '',
                'day1' => $_REQUEST['ap_day1'],
                'month1' => $_REQUEST['ap_month1'],
                'year1' => $_REQUEST['ap_year1'],
                'day2' => $_REQUEST['ap_day2'],
                'month2' => $_REQUEST['ap_month2'],
                'year2' => $_REQUEST['ap_year2']
        );

        foreach($chunkedUserIDs as $userIDsArray)
        {
            $userIDSql = "('".implode("','", $userIDsArray)."')";
            
            // select payout fields values for these users
            $payoutFieldsData = QCore_Settings::_getSettingsForMultipleUsers(SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(), $userIDsArray);

            $conditions['UserID'] = $userIDsArray;
            $transdata = $this->blSaleStat->getTransactionsSummaries($conditions);

            // select user data
            $sql =  "select * from wd_g_users ".
                    "  where userid in ".$userIDSql.
                    "   and accountid="._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            
            while(!$rs->EOF)
            {
                $pfForUser = $payoutFieldsData[$rs->fields['userid']];
                
                // replace payout fields in export format
                $line = $exportFormat;

                if(is_array($payoutFields) && count($payoutFields) > 0)
                {
                    foreach($payoutFields as $field)
                    {
                        $id = $field['payfieldid'];
                        $code = $field['code'];
                        
                        // get value for this field (from settings)
                        $value = $pfForUser['Aff_payoptionfield_'.$id];
                        
                        // replace code with value in export format
                        $line = str_replace($code, $value, $line);
                    }
                }

                // replace user data in export format
                $line = $this->replaceUserDataInExportFormat($line, $rs->fields);
                
                $line = str_replace('$Affiliate_amount', sprintf("%.2f", $transdata[$rs->fields['userid']]['approved']), $line);

                $line = str_replace('\t', "\t", $line);
                $line = str_replace('\r', "\r", $line);
                $line = str_replace('\n', "\n", $line);
                
                fwrite($exportFile, $line);
                
                $rs->MoveNext();
            }
        }
        
        fclose($exportFile);
        
        return $fileName;
    }
}

?>
