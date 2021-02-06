<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_Bl_Accounts');
QUnit_Global::includeClass('QCore_Bl_Users');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');
QUnit_Global::includeClass('Affiliate_Merchants_Views_AffiliateManager');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_TimerangeStatistics');
QUnit_Global::includeClass('QCore_Bl_Communications');
QUnit_Global::includeClass('QCore_EmailTemplates');
QUnit_Global::includeClass('QCore_Bl_Job');

class Affiliate_Scripts_Bl_MonthlyReports extends QCore_Bl_Job
{
	var $blTimerangeStatistics;
	var $blSaleStatistics;
	var $blEmailTemplates;
	
	function Affiliate_Scripts_Bl_MonthlyReports()
	{
		$this->blTimerangeStatistics = QUnit_Global::newObj('Affiliate_Scripts_Bl_TimerangeStatistics');
		$this->blSaleStatistics = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleStatistics');
		$this->blEmailTemplates =& QUnit_Global::newObj('QCore_EmailTemplates');        
	}
	
	//------------------------------------------------------------------------
	
    function process()
    {
	setLanguage(); // set language file                

    	$countGenerated = 0;
        $countSent = 0;

        $accounts = QCore_Bl_Accounts::getAccountsAsArray();
        $account_settings = QCore_Settings::getAccountsSettings();
                
        $today = getdate();
        $y = $today['year'];
        $m = $today['mon']-1;
        $d1 = 1;
        $d2 = date("j", mktime (0,0,0,$m + 1,0,$y)); // last day of month
        
        foreach($accounts as $account)
        {
            
            if (!$this->skip()) {
                if($account_settings[$account['accountid']]['Aff_email_merch_monthlyreport'] == 1)
                {
                    $data = $this->blTimerangeStatistics->getTimerangeStats('', '',
                                 $d1, $m, $y, $d2, $m, $y, $account['accountid'],
                                 $account_settings[$account['accountid']]);
        
                    // sales and leads list
                    $cond  =  array('CampaignID' => '',
        	          				'UserID' => '', 
					          		'Status' => '',
        				    	    'page' => 0,
            				    	'rowsPerPage' => 200,
                					'day1' => $d1,
                					'month1' => $m,
                	   		  		'year1' => $y,
                		  		  	'day2' => $d2,
            	       				'month2' => $m,
            			     		'year2' => $y);
		    //-----------------------------------------------
		    $cond['dateSelectMode'] = '1';
		    //----------------------------------------------
                	
                	// sales list
                	$cond['TransactionType'] = TRANSTYPE_SALE;
                    $data_sales = $this->blSaleStatistics->getTransactionsStats($cond, $account['accountid']);
    			    $data['sales_list'] = $this->formatTransactionList($data_sales['transactions'], $account_settings[$account['accountid']]);
                    // leads list
                    $cond['TransactionType'] = TRANSTYPE_LEAD;
                    $data_leads = $this->blSaleStatistics->getTransactionsStats($cond, $account['accountid']);
        			$data['leads_list'] = $this->formatTransactionList($data_leads['transactions'], $account_settings[$account['accountid']]);
				
		    //-----------------------------------------------
		    $cond['dateSelectMode'] = '2';
		    //sales_list_approved
		    $cond['TransactionType'] = TRANSTYPE_SALE;
		    $data_sales2 = $this->blSaleStatistics->getTransactionsStats($cond, $account['accountid']);
		    $data['sales_list_approved'] = $this->formatTransactionList($data_sales2['transactions'], $account_settings[$account['accountid']]);
		    //leads_list_approved
		    $cond['TransactionType'] = TRANSTYPE_LEAD;
		    $data_leads2 = $this->blSaleStatistics->getTransactionsStats($cond, $account['accountid']);
		    $data['leads_list_approved'] = $this->formatTransactionList($data_leads2['transactions'], $account_settings[$account['accountid']]);
		    //-----------------------------------------------
                    $countGenerated++;
		    
		    
                    if($this->sendMonthlyReportToMerchant($data,
                            $account_settings[$account['accountid']]['Aff_default_lang'],
                            $account_settings[$account['accountid']]['Aff_notifications_email'],
                            $account['accountid'], $account_settings[$account['accountid']]))
                        $countSent++;
                }
                
                if ($this->interrupt()) return;
            }

            $user_settings = QCore_Settings::getAccountUsersSettings($account['accountid']);
            $users = QCore_Bl_Users::getUsersUsernamesAsArray($account['accountid']);            
            foreach($user_settings as $userid => $userdata)
            {
                if($this->skip())
                    continue;
                    
                if(($userdata['Aff_email_affmonthlyreport'] == '1') &&
                   ($account_settings[$account['accountid']]['Aff_email_monthlyreport'] == 1))
                {
                    $countGenerated++;
                    
                    $data = $this->blTimerangeStatistics->getTimerangeStats(
                         $userid, '',
                         $d1, $m, $y, $d2, $m, $y, $account['accountid'],
                         $account_settings[$account['accountid']]);
                   
                    // sales and leads list
            		$cond  =  array('CampaignID' => '',
        							'UserID' => $userid, 
									'Status' => '',
        							'page' => 0,
        							'rowsPerPage' => 200,
        							'day1' => $d1,
        							'month1' => $m,
        							'year1' => $y,
        							'day2' => $d2,
        							'month2' => $m,
        							'year2' => $y);
			//-----------------------------------------
			$cond['dataSelectMode'] = '1';
			//-----------------------------------------
        	
		        	// sales list
        			$cond['TransactionType'] = TRANSTYPE_SALE;
            		$data_sales = $this->blSaleStatistics->getTransactionsStats($cond, $account['accountid']);
            		$data['sales_list'] = $this->formatTransactionList($data_sales['transactions'], $account_settings[$account['accountid']]);
            		// leads list
            		$cond['TransactionType'] = TRANSTYPE_LEAD;
            		$data_leads = $this->blSaleStatistics->getTransactionsStats($cond, $account['accountid']);
            		$data['leads_list'] = $this->formatTransactionList($data_leads['transactions'], $account_settings[$account['accountid']]);
			
			//-----------------------------------------------
			$cond['dataSelectMode'] = '2';
			$cond['TransactionType'] = TRANSTYPE_SALE;
			$data_sales2 = $this->blSaleStatistics->getTransactionsStats($cond, $account['accountid']);
			$data['sales_list_approved'] = $this->formatTransactionList($data_sales2['transactions'], $account_settings[$account['accountid']]);
			$cond['TransactionType'] = TRANSTYPE_LEAD;
			$data_leads2 = $this->blSaleStatistics->getTransactionsStats($cond, $account['accountid']);
			$data['leads_list_approved'] = $this->formatTransactionList($data_leads2['transactions'], $account_settings[$account['accountid']]);
			//-----------------------------------------------

	            $lang = $userdata['Aff_aff_notificationlang'];
                    if($lang == '')
                        $lang = $account_settings[$account['accountid']]['Aff_default_lang'];

                    if($this->sendMonthlyReportToUser($userid, $users[$account['accountid']][$userid]['username'],
                                                      $data, $lang, $account['accountid'], $account_settings[$account['accountid']]))
                    {
                        $countSent++;
                    }
                }
                
                if ($this->interrupt()) return;
            }
        }
        
        // log it
        LogMsg("Monthly reports - generated: $countGenerated reports, sent reports: $countSent, error sending reports: ".($countGenerated - $countSent), __FILE__, __LINE__);
        
        $this->finish();
        
        return $countGenerated;
    }
    
    //------------------------------------------------------------------------
    
    function sendMonthlyReportToMerchant(&$data, $default_lang, $notifications_email, $accountID, $settings)
    {
        QUnit_Global::includeClass('QCore_EmailTemplates');
	
        $emaildata = $this->blEmailTemplates->getFilledEmailMessage('', $accountID, 'AFF_EMAIL_MONTH_REP', $default_lang, $data);

        if($emaildata != false)
        {
            $params = array('accountid' => $accountID,
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => '',
                            'email' => $notifications_email,
                            'settings' => $settings
            );

            if(!QCore_Bl_Communications::sendEmail($params)) {
                $errorMsg = "Monthly report: There was a problem sending monthly report email to merchant '".$notifications_email."'";
                LogError($errorMsg, __FILE__, __LINE__);
            } else {
                LogMsg("Monthly report was succesfully generated and sent to merchant '".$notifications_email."'", __FILE__, __LINE__);
                return true;
            }
        }
        else
        {
          $errorMsg = "Monthly report:  There was a problem generating merchant monthly report email from template";
          LogError($errorMsg, __FILE__, __LINE__);
        }

        return false;
    }

    //------------------------------------------------------------------------
    
    function sendMonthlyReportToUser($userID, $email, &$data, $lang, $accountID, $settings)
    {
        QUnit_Global::includeClass('QCore_EmailTemplates');

        $emaildata = $this->blEmailTemplates->getFilledEmailMessage($userID, $accountID, 'AFF_EMAIL_AF_ML_REP', $lang, $data);

        if($emaildata != false)
        {
            $params = array('accountid' => $accountID,
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => $userID,
                            'email' => $email,
                            'settings' => $settings
            );

            if(!QCore_Bl_Communications::sendEmail($params)) {
                $errorMsg = "Monthly report: There was a problem sending monthly report email to user '$email'";
                LogError($errorMsg, __FILE__, __LINE__);
            } else {
                LogMsg("Monthly report was succesfully generated and sent to user '$email'", __FILE__, __LINE__);
                return true;
            }
        }
        else
        {
          $errorMsg = "Monthly report:  There was a problem generating user monthly report email from template";
          LogError($errorMsg, __FILE__, __LINE__);
        }

        return false;
    }
    
    //------------------------------------------------------------------------
    
    function formatTransactionList($transList, $settings)
    {
    	$data = L_G_CREATED."\t\t\t".L_G_CAMOUNT."\t".L_G_TOTALCOST."\t".L_G_ORDERID."\t".L_G_STATUS."\n";
		foreach ($transList as $trans) {
        	$data .= $trans['datecreated']."\t".
            		 $this->showCurrency($trans['commission'], $settings)."\t\t".
            		 $this->showCurrency($trans['totalcost'], $settings)."\t".
            		 $trans['orderid']."\t\t";
            if ($trans['payoutstatus'] == AFFSTATUS_APPROVED) {
                $txt = L_G_PAID;
            } else {
                switch ($trans['rstatus']) {
                    case AFFSTATUS_NOTAPPROVED: $txt = L_G_WAITINGAPPROVAL; break;
                    case AFFSTATUS_APPROVED:    $txt = L_G_APPROVED; break;
                    case AFFSTATUS_SUPPRESSED:  $txt = L_G_SUPPRESSED; break;
                }
            }
            $data .= $txt."\n";
		}
		return $data;
    }
    
    //------------------------------------------------------------------------
    
    function showCurrency($value, $settings) {    	
        return ($settings['Aff_currency_left_position'] == '1' ? 
                        $settings['Aff_system_currency'].' '._rnd($value) :
                        _rnd($value).' '.$settings['Aff_system_currency']);
    }
}
?>
