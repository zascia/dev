<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleRegistrator');

class Affiliate_Scripts_Bl_RecurringCommissions extends Affiliate_Scripts_Bl_SaleRegistrator
{
    var $maxCommissionLevels = '';
    var $account_settings = array();
    var $recurringCommissionsCounter = 0;
    var $test_date = '2000-1-1';
    var $ProductID;
    
    var $blEmailTemplates;
    var $blCommunications;
    var $blAccounts;
    var $blRules;
    
    var $blJob;
    
    function Affiliate_Scripts_Bl_RecurringCommissions()
    {
        $this->blEmailTemplates =& QUnit_Global::newObj('QCore_EmailTemplates');
        $this->blCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');
        $this->blAccounts =& QUnit_Global::newObj('QCore_Bl_Accounts');
        $this->blRules =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Rules');
        $this->blJob =& QUnit_Global::newObj('QCore_Bl_Job');
    }    
    //--------------------------------------------------------------------------
    
    function generateTransactions()
    {
//        $this->maxCommissionLevels = $GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels');
//        if($this->maxCommissionLevels == '')
//            $this->maxCommissionLevels = 1;
        
        $currentDate = $this->getCurrentDate();
        
        $accounts = $this->blAccounts->getAccountsAsArray();
        $account_settings = QCore_Settings::getAccountsSettings();

        foreach($accounts as $account)
        {
            $this->account_settings = $account_settings[$account['accountid']];
            $rs = $this->getDataForRecurringTransaction($currentDate, $account['accountid']);

            if(!$rs) {
                $this->finish();
                return false;
            }

            $count = 0;
            while(!$rs->EOF)
            {
                if($this->skip())
                    continue;
                    
                $currentPaymentDate = $this->getCurrentPaymentDate($rs->fields['dayofmonth'], $rs->fields['dayofweek'], $rs->fields['month'], $rs->fields['week'],$rs->fields['year'], $rs->fields['datetype']);

                if($currentDate == $currentPaymentDate)
                {
                    $params = rsfields2array($rs);
                
                    if(!$this->checkTodaysRecordExist($params, $currentDate))
                    {
                        $count++;
                        $this->insertRecurringTransaction($params);
                    }
                }
                
                if ($this->interrupt()) return;
            
                $rs->MoveNext();
            }
        
            //return $count;
        }
        
        $this->finish();
    }
    
    //--------------------------------------------------------------------------
    
    function getCurrentDate()
    {
        if($_REQUEST['day'] != '' && $_REQUEST['month'] != '' && $_REQUEST['year'] != '') {
            return $_REQUEST['year'].'-'.$_REQUEST['month'].'-'.$_REQUEST['day'];
        }
        
        if($GLOBALS['Test_mode'] == '1')
            return $this->test_date;
        else
            return date("Y").'-'.date("n").'-'.date("j");
    }
    
    //--------------------------------------------------------------------------
    
    function getDataForRecurringTransaction($currentDate, $accountid)
    {
        $sql = "select r.*, ".sqlDayOfMonth('r.dateinserted')." as dayofmonth,".
            " MONTH(r.dateinserted) as month, ".sqlWeek('r.dateinserted')." as week,".
            sqlDayOfWeek('r.dateinserted')." as dayofweek, YEAR(r.dateinserted) as year,".
            " t.orderid, t.totalcost, t.productid, s.value as saleapproval,s.accountid ".
            "from wd_pa_campaigns c, wd_pa_campaigncategories cc, ".
            "     wd_pa_recurringcommissions r, wd_pa_transactions t, wd_g_settings s ".
            "where r.originaltransid=t.transid and r.campcategoryid=cc.campcategoryid ".
            "  and cc.campaignid=c.campaignid and c.deleted=0 and r.deleted=0 ".
            "  and r.rstatus=".AFFSTATUS_APPROVED.
            "  and c.accountid="._q($accountid).
            "  and t.accountid="._q($accountid).
            "  and s.accountid="._q($accountid).
            "  and s.id1=c.campaignid ".
            "  and s.rtype="._q(SETTINGTYPE_AFF_CAMP).
            "  and s.code='Aff_camp_saleapproval' ".
            "  and ".sqlToDays('r.dateinserted')." <> ".sqlToDays($currentDate);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        return $rs;
    }

    //--------------------------------------------------------------------------

    function dayOfWeek($day="",$month="",$year="")
    {
        if($month > 2) {
            $month -= 2;
        } else {
            $month += 10;
            $year--;
        }
        
        $day =     ( floor((13 * $month - 1) / 5) +
                $day + ($year % 100) +
                floor(($year % 100) / 4) +
                floor(($year / 100) / 4) - 2 *
                floor($year / 100) + 77);
        
        $weekday_number = (($day - 7 * floor($day / 7)));
        
        return $weekday_number;
    }
    
    //--------------------------------------------------------------------------
    
    function getCurrentPaymentDate($orderDay, $orderDayOfWeek, $orderMonth, $orderWeek, $orderYear, $datetype)
    {
        if($_REQUEST['day'] != '' && $_REQUEST['month'] != '' && $_REQUEST['year'] != '') {
            $days = computeDateToDays($_REQUEST['day'], $_REQUEST['month'], $_REQUEST['year']);
        } else {
            $days = computeDateToDays(date('j'), date("n"), date("Y"));
        }
        $days--;
        
        computeDaysToDate($days, $dayofmonth, $month, $year);
        
        if($_REQUEST['day'] != '' && $_REQUEST['month'] != '' && $_REQUEST['year'] != '') {
            $dayofweek = Affiliate_Scripts_Bl_RecurringCommissions::dayOfWeek($_REQUEST['day'], $_REQUEST['month'], $_REQUEST['year']) - 1;
        } else {
            $dayofweek = date('w') - 1;
        }
        if($dayofweek < 0)
            $dayofweek = 6;
        $dayofweek++; // set it to MySql format (1-Sunday, .., 7-Saturday)
        
        if($datetype == RECURRINGTYPE_WEEKLY)
        {
            $daysNow = computeDateToDays($dayofmonth, $month, $year);
            
            if($orderDayOfWeek > $dayofweek)
            {
                computeDaysToDate($daysNow + ($orderDayOfWeek - $dayofweek), $nextDay, $nextMonth, $nextYear);
            }
            else
            {
                // it is next week
                computeDaysToDate($daysNow + 7 - ($dayofweek - $orderDayOfWeek), $nextDay, $nextMonth, $nextYear);
            }
        }
        else if($datetype == RECURRINGTYPE_MONTHLY)
        {
            $nextYear = $year;
            $nextMonth = $month;
            
            if($nextMonth == $orderMonth && $year == $orderYear)
            {
                // it is this month's order, increment month
                $nextMonth++;
            }
            
            if($nextMonth>12)
            {
                $nextYear++;
                $nextMonth = 1;
            }
            
            $nextDay = $orderDay;
            $daysInMonth = getDaysInMonth($nextMonth, $nextYear);
            if($nextDay > $daysInMonth)
                $nextDay = $daysInMonth;
        }
        else if($datetype == RECURRINGTYPE_QUARTERLY)
        {
            $daysInQuarter = 91;
            
            $nowTotalDays = computeDateToDays($dayofmonth, $month, $year);
            $orderTotalDays = computeDateToDays($orderDay, $orderMonth, $orderYear);
            
            if($nowTotalDays - $orderTotalDays < $daysInQuarter)
            {
                $newOrderDays = $orderTotalDays + $daysInQuarter;
            }
            else
            {
                $newOrderDays = $nowTotalDays + ($daysInQuarter - (($nowTotalDays - $orderTotalDays)%$daysInQuarter));
            }
            
            $nexOrderDays += floor(($nowTotalDays - $orderTotalDays)/365);
            computeDaysToDate($newOrderDays, $nextDay, $nextMonth, $nextYear);
            
        }
        else if($datetype == RECURRINGTYPE_BIANNUALLY)
        {
            $daysInHalfYear = 182;
            
            $nowTotalDays = computeDateToDays($dayofmonth, $month, $year);
            $orderTotalDays = computeDateToDays($orderDay, $orderMonth, $orderYear);
            
            if($nowTotalDays - $orderTotalDays < $daysInHalfYear)
            {
                $newOrderDays = $orderTotalDays + $daysInHalfYear;
            }
            else
            {
                $newOrderDays = $nowTotalDays + ($daysInHalfYear - (($nowTotalDays - $orderTotalDays)%$daysInHalfYear));
            }
            
            $nexOrderDays += floor(($nowTotalDays - $orderTotalDays)/365);
            computeDaysToDate($newOrderDays, $nextDay, $nextMonth, $nextYear);
        }
        else if($datetype == RECURRINGTYPE_YEARLY)
        {
            if($year == $orderYear)
                $nextYear = $year + 1;
            else
                $nextYear = $year;
            
            $nextMonth = $orderMonth;
            $nextDay = $orderDay;

            $daysInMonth = getDaysInMonth($nextMonth, $nextYear);
            if($nextDay > $daysInMonth)
                $nextDay = $daysInMonth;
        }
        else
            return "undefined";

        return "$nextYear-$nextMonth-$nextDay";
    }
    
    //--------------------------------------------------------------------------
    
    function insertRecurringTransaction($params)
    {
        // get actual commission category for this user
        $this->ProductID = $params['productid'];
        
        $sale_comm_params = array('affiliateid' => $params['affiliateid'],
            'campcategoryid' => $params['campcategoryid'],
            'commtype' => $params['commtype'],
            'commission' => $params['commission']
        );
        
        if($this->getSaleCommission($sale_comm_params) == false)
            return false;
        
        $commission = $this->computeCommission($params['totalcost'], $this->PerSaleCommType, $this->SaleCommission);
        if($commission == 0)
            return false;
        
        // get approval status from campaigns
        if($params['saleapproval'] == APPROVE_MANUAL)
            $status = AFFSTATUS_NOTAPPROVED;
        else
            $status = AFFSTATUS_APPROVED;
        
        $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
        $sql = "insert into wd_pa_transactions(".
            "transid, affiliateid,".
            "accountid,".
            "campcategoryid, dateinserted, ".
            "transtype, transkind, ".
            "orderid, ".            
            "productid, ".            
            "recurringcommid, ".
            "commission, rstatus)".
            "values(".
            _q($TransID).","._q($params['affiliateid']).",".
            _q($params['accountid']).",".
            _q($params['campcategoryid']).",".sqlNow().",".
            TRANSTYPE_RECURRING.",".TRANSKIND_RECURRING.",".
            myquotes($params['orderid']).",".            
            myquotes($params['productid']).",".            
            myquotes($params['recurringcommid']).",".
            myquotes($commission).",".myquotes($status).")";
        
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            $errorMsg = "Recurring Commissions: Error saving transaction";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }

        if($status == AFFSTATUS_APPROVED)
        {
            $rule_params = array('users' => array($params['affiliateid']),
                                 'AccountID' => $params['accountid'],
                                 'decimal_places' => $this->settings['Aff_round_numbers']
                                );

            if(($rules = $this->blRules->getRulesAsArray($rule_params)) !== false)
                $this->blRules->checkPerformanceRules($rule_params, $rules);
        }
        
        //----------------------------------------
        // send notifications
        $email_params = array();
        $email_params['id'] = $TransID;
        $email_params['commission'] = $commission;
        $email_params['orderid'] = $params['orderid'];
        $email_params['userid'] = $params['affiliateid'];
        $email_params['status'] = $status;
        $email_params['recurringcommid'] = $params['recurringcommid'];
        $email_params['accountid'] = $params['accountid'];
        
        $this->sendNotificationToMerchant($TransID, $email_params);
        
        //------------------------------------------
        // register multi tier sale commissions
        $this->registerMultiTierRecurringCommission($params, $status, 2);
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function getSaleCommission($params)
    {
        if($this->account_settings['Aff_recurringrealcommissions'] == '1')
        {
            $this->UserID = $params['affiliateid'];
            $this->CampaignID = $this->getCampaignFromCampaignCategory($params['campcategoryid']);
            
            //------------------------------------------------------------------------
            // check whether to force product_id - based lookup for commission category
            if($this->account_settings['Aff_forcecommfromproductid'] == 'yes')
            {
                if(!$this->lookupForProductCategory($this->ProductID))
                {
                    if($result == false && $this->account_settings['Aff_apply_from_banner'] != '1')
                    {
                        $errorMsg = "Recurring Commissions: No product category for ProductID '$this->ProductID' found for transaction '$OrderID'";
                        LogError($errorMsg, __FILE__, __LINE__);
                        return false;
                    }                  
                }
            }

            if($this->getRecurringSaleCommission() == false) return false;
        }
        else
        {
            $this->PerSaleCommType = $params['commtype'];
            $this->SaleCommission = $params['commission'];
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function getRecurringSaleCommission($tier = '')
    {
        //---------------------------------------
        // check if this user is not assigned in some special user commission category for this product category
        $sql = 'select cc.* from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campaignid='._q($this->CampaignID).
               '  and cc.campcategoryid=ac.campcategoryid '.
               '  and affiliateid='._q($this->UserID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
            return false;

        if(!$rs->EOF)
        {
            if($this->CampaignCategoryID != $rs->fields['campcategoryid'])
            {
                // user is in different commission category, get the commission level
                if($tier == '')
                {
                    $this->SaleCommission = $rs->fields['recurringcommission'];
                    $this->PerSaleCommType = $rs->fields['recurringcommtype'];
                }
                else
                {
                    return array('STRecurringCommType' => $rs->fields['strecurringcommtype'],
                                 'recurringCommission' => $rs->fields['st'.$tier.'recurringcommission']);
                }
            }
        }
        else
        {
            // get commission from default commission category
            $sql = 'select * from wd_pa_campaigncategories '.
                   'where deleted=0 and campaignid='._q($this->CampaignID).
                   '  and name='._q(UNASSIGNED_USERS);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs || $rs->EOF)
                return false;  
            
            if($tier == '')
            {
                $this->SaleCommission = $rs->fields['recurringcommission'];
                $this->PerSaleCommType = $rs->fields['recurringcommtype'];
            }
            else
            {
                return array('STRecurringCommType' => $rs->fields['strecurringcommtype'],
                             'recurringCommission' => $rs->fields['st'.$tier.'recurringcommission']);
            }
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function checkTodaysRecordExist($params, $currentDate)
    {
        $sql = "select * from wd_pa_transactions ".
            "where transkind=".TRANSKIND_RECURRING.
            "  and accountid="._q($params['accountid']).
            "  and recurringcommid="._q($params['recurringcommid']).
            "  and ".sqlToDays('dateinserted')." = ".sqlToDays($currentDate);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs || $rs->EOF)
            return false;
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function cancelRecurring($OrderID)
    {
        if($OrderID == '')
            return false;
        
        $sql = "select r.recurringcommid, t.orderid ".
               "from wd_pa_recurringcommissions r, wd_pa_transactions t ".
               "where r.originaltransid=t.transid and r.deleted=0".
               "  and r.rstatus=".AFFSTATUS_APPROVED." and t.orderid="._q($OrderID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs || $rs->EOF)
            return false;
        
        while(!$rs->EOF)
        {
            $sql = 'update wd_pa_recurringcommissions '.
                   'set rstatus='._q(AFFSTATUS_SUPPRESSED).
                   ' where recurringcommid='._q($rs->fields['recurringcommid']);
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            
            if(!$ret)
            {
                $errorMsg = "Recurring Commissions: Error cancelling recurring commission with OrderID='$OrderID'";
                LogError($errorMsg, __FILE__, __LINE__);
            }

            $rs->MoveNext();
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function sendNotificationToMerchant($TransID, $params)
    {
        //----------------------------------------
        // check whether to send notification email to mechant
        if($this->account_settings['Aff_email_recurringtrangenerated'] != 1)
            return false;
            
        $this->loadLanguage($this->account_settings['Aff_default_lang']);

        QUnit_Global::includeClass('QCore_EmailTemplates');
        
        $emaildata = $this->blEmailTemplates->getFilledEmailMessage($TransID, $params['accountid'], 'AFF_EMAIL_NOTIFY_RC', $this->account_settings['Aff_default_lang'], $params);

        if($emaildata != false)
        {
            $systemEmail = $this->account_settings['Aff_notifications_email'];

            $params = array('accountid' => $params['accountid'],
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => '',
                            'email' => $systemEmail,
                            'settings' => $this->account_settings
            );

            if(!$this->blCommunications->sendEmail($params))
                LogError("Recurring commission: There was a problem sending notification email about recurring commission (Transaction ID '$TransID')", __FILE__, __LINE__);
            else
            {
                LogMsg("Recurring commission: Notification email was succesfully generated and sent to '$systemEmail'", __FILE__, __LINE__);
                return true;
            }
        }
        else
        {
            LogError("Recurring commission: There was a problem generating notification email about recurring commission (Transaction ID '$TransID') from template", __FILE__, __LINE__);
        }        
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function registerMultiTierRecurringCommission($params, $status, $tier, $maxRecursion = 50)
    {
        if($maxRecursion <= 0)
            return false;
        
        if($tier > ($this->account_settings['Aff_maxcommissionlevels'] == '' ? 1 : $this->account_settings['Aff_maxcommissionlevels']))
            return false;
        
        //----------------------------------------
        // get user for this tier
        $userID = $params['st'.$tier.'affiliateid'];
        if($userID === 0 || $userID == '')
            return false;
        
        if($this->account_settings['Aff_recurringrealcommissions'] == 1)
        {
            if(($rsc_data = $this->getRecurringSaleCommission($tier)) === false) return false;
            
            $STRecurringCommType = $rsc_data['STRecurringCommType'];
            $recurringCommission = $rsc_data['recurringCommission'];
            
            //----------------------------------------
            // compute commission
            $recurringCommission = $this->computeCommission($params['totalcost'], $STRecurringCommType, $recurringCommission);
        }
        else
        {
            //----------------------------------------
            // check if commission in this tier is nonzero
            $recurringCommission = $params['st'.$tier.'commission'];
        }
        
        //----------------------------------------
        // check status of user, if he is waiting for approval also transaction must have this status
        $sql = 'select * from wd_g_users where deleted=0 and userid='._q($userID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
            return false;
        
        if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED && $status == AFFSTATUS_APPROVED)
            $status = AFFSTATUS_NOTAPPROVED;
        
        //----------------------------------------
        // compute commission
        $commission = $recurringCommission; 
        if($commission != 0)
        {
            //----------------------------------------
            // register commission
            $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
            $sql = "insert into wd_pa_transactions(".
                "transid, accountid, ".
                "affiliateid, campcategoryid, ".
                "dateinserted, transtype, transkind, ".
                "orderid, recurringcommid, ".
                "commission, rstatus)".
                "values(".
                _q($TransID).","._q($params['accountid']).",".
                _q($userID).","._q($params['campcategoryid']).",".
                sqlNow().",".TRANSTYPE_RECURRING.",".(TRANSKIND_SECONDTIER+$tier).",".
                _q($params['orderid']).","._q($params['recurringcommid']).",".
                _q($commission).","._q($status).")";
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            
            if (!$ret)
            {
                $errorMsg = "Recurring commission: Error saving $tier - tier recurring commission";
                LogError($errorMsg, __FILE__, __LINE__);
                return false;
            }
            
            if($status == AFFSTATUS_APPROVED)
            {
                $emailParams = array('users' => array($userID),
                                     'AccountID' => $params['accountid'],
                                     'decimal_places' => $this->settings['Aff_round_numbers']
                                    );

                if(($rules = $this->blRules->getRulesAsArray($emailParams)) !== false)
                    $this->blRules->checkPerformanceRules($emailParams, $rules);
            }
            
            $this->recurringCommissionsCounter++;
        }
        
        //----------------------------------------
        // go recursively to the next tier
        if($tier < ($this->account_settings['Aff_maxcommissionlevels'] == '' ? 1 : $this->account_settings['Aff_maxcommissionlevels']))
        {
            $this->registerMultiTierRecurringCommission($params, $status, $tier + 1, $maxRecursion - 1);
        }
    }
    
    //--------------------------------------------------------------------------
    // 'extend' from QCore_Bl_Jobs
    //--------------------------------------------------------------------------
    
    function createJob($jobtype)
    {
        return $this->blJob->createJob($jobtype);
    }
    
    //--------------------------------------------------------------------------
    
    function loadJob($jobid, $jobscheduler)
    {
        return $this->blJob->loadJob($jobid, $jobscheduler);
    }
    
    //--------------------------------------------------------------------------
    
    function start()
    {
        return $this->blJob->start();
    }
    
    //--------------------------------------------------------------------------
    
    function updateJob() {
        return $this->blJob->updateJob();
    }
    
    //--------------------------------------------------------------------------
    
    function interrupt() {
        return $this->blJob->interrupt();
    }
    
    //--------------------------------------------------------------------------
    
    function skip() {
        return $this->blJob->skip();
    }
    
    //--------------------------------------------------------------------------
    
    function finish() {
        return $this->blJob->finish();
    }
    
    //--------------------------------------------------------------------------
    function process() {
        $this->generateTransactions();
    }
    
}
?>
