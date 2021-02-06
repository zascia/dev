<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Settings');

class Affiliate_Merchants_Views_AffiliatePayments extends QUnit_UI_TemplatePage
{
    var $blAccounting;
    var $blAffiliate;
    
    //--------------------------------------------------------------------------
    
    function Affiliate_Merchants_Views_AffiliatePayments() {
        $this->blAccounting =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Accounting');
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_PAYOUT,'index.php?md=Affiliate_Merchants_Views_AffiliatePayments');
    }
    
    //--------------------------------------------------------------------------
    
    function initPermissions()
    {
        $this->modulePermissions['generateexport'] = 'aff_aff_pay_affiliates_modify';
        $this->modulePermissions['approvepayment'] = 'aff_aff_pay_affiliates_modify';
        $this->modulePermissions['denypayment'] = 'aff_aff_pay_affiliates_modify';
        $this->modulePermissions['view'] = 'aff_aff_pay_affiliates_view';
    }
    
    //--------------------------------------------------------------------------
    
    function process()
    {
        $this->assign('a_form_preffix', 'ap_');
        $this->assign('a_form_name', 'FilterForm');
        $this->assign('a_md', 'Affiliate_Merchants_Views_AffiliatePayments');

        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'generateexport':
                    if($this->processGenerateExport())
                        return;
                break;
                
                case 'approvepayment':
                    if($this->processApprovePayments())
                        return;
                break;
                
                case 'approvepayment_mailinvoices':
                    if($this->startApprovePaymentsAndSendMail())
                        return;
                break;
                
                case 'denypayment':
                    if($this->processDeclinePayments())
                        return;
                break;
                
                case 'view_selected_invoices':
                    if($this->prepareFormSelectedInvoices())
                        return;
                    break;
            }
        }
        
       if(!empty($_REQUEST['action'])) 
        {
            switch($_REQUEST['action'])
            {
                case 'manualpay':
                    if($this->drawFormManualPayment())
                        return;
                    break;
                    
                case 'view_invoice':
                    if($this->drawFormInvoice())
                        return;
                    break;
                    
              case 'view_selected_invoices':
                    if($this->drawFormSelectedInvoices())
                        return;
                    break;
                    
                case 'markandsend':
                    $this->processApprovePaymentsAndSendMail();
                    return;
            }
        }
        
        $this->showPayments();
    }
    
    //--------------------------------------------------------------------------
    
    function processDeclinePayments()
    {
        if(($userIDs = $this->returnUIDs()) == false)
            return false;
        
        $params = array();
        $params['userids'] = $userIDs;
        $params['date1'] = preg_replace('/[^0-9-]/', '', $_POST['date1']);
        $params['date2'] = preg_replace('/[^0-9-]/', '', $_POST['date2']);

        $this->blAccounting->decline($params);
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function processApprovePayments()
    {
        if(($userIDs = $this->returnUIDs()) == false)
            return false;

        $params = array();
        $params['userids'] = $userIDs;
        $params['accounting_note'] = $_REQUEST['accounting_note'];
        $params['y1'] = $_REQUEST['ap_year1'];
        $params['m1'] = $_REQUEST['ap_month1'];
        $params['d1'] = $_REQUEST['ap_day1'];
        $params['y2'] = $_REQUEST['ap_year2'];
        $params['m2'] = $_REQUEST['ap_month2'];
        $params['d2'] = $_REQUEST['ap_day2'];
        
        if($_REQUEST['mp_date1'] != '')
        {
            // parameters from manual payment form
            $params['date1'] = $_REQUEST['mp_date1'];
            $params['date2'] = $_REQUEST['mp_date2'];
        }
        else
        {
            $params['date1'] = $_REQUEST['ap_year1'].'-'.$_REQUEST['ap_month1'].'-'.$_REQUEST['ap_day1'];
            $params['date2'] = $_REQUEST['ap_year2'].'-'.$_REQUEST['ap_month2'].'-'.$_REQUEST['ap_day2'];
        }
        
        $this->blAccounting->markAsPaid($params);
        
        return false;
    }

    //--------------------------------------------------------------------------
    
    function processGenerateExport()
    {
        if(($userIDs = $this->returnUIDs()) == false)
        {
            QUnit_Messager::setErrorMessage(L_G_YOUHAVETOCHOOSESOMEUSER);
            return false;
        }
        
        $params = array();
        $params['userids'] = $userIDs;
        $params['accounting_note'] = $_REQUEST['accounting_note'];
        $params['y1'] = $_REQUEST['ap_year1'];
        $params['m1'] = $_REQUEST['ap_month1'];
        $params['d1'] = $_REQUEST['ap_day1'];
        $params['y2'] = $_REQUEST['ap_year2'];
        $params['m2'] = $_REQUEST['ap_month2'];
        $params['d2'] = $_REQUEST['ap_day2'];
        $params['date1'] = $_REQUEST['ap_year1'].'-'.$_REQUEST['ap_month1'].'-'.$_REQUEST['ap_day1'];
        $params['date2'] = $_REQUEST['ap_year2'].'-'.$_REQUEST['ap_month2'].'-'.$_REQUEST['ap_day2'];

        // check if all users do have the same payout option
        if(!$this->blAccounting->checkSamePayoutOption($params))
        {
            QUnit_Messager::setErrorMessage(L_G_USERSMUSTHAVETHESAMEPAYOUTOPTION);
            return false;
        }

        $exportFileName = $this->blAccounting->generateExportFile($params);

        if($exportFileName != false)
        {
            $_REQUEST['exportFileName'] = $exportFileName;
        }
        return false;
    }
    
    //--------------------------------------------------------------------------

    function returnUIDs()
    {
        $userIDs = $_POST['itemschecked'];
        
        return $userIDs;
    }
    
    //--------------------------------------------------------------------------

    function drawFormManualPayment()
    {
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v) {
            if(strpos($k, 'ap_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
            if($k == 'numrows' && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }

        //--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
        if($_REQUEST['ap_userid'] == '') $_REQUEST['ap_userid'] = '_';
        if($_REQUEST['ap_day1'] == '') $_REQUEST['ap_day1'] = 1;
        if($_REQUEST['ap_month1'] == '') $_REQUEST['ap_month1'] = 1;
        if($_REQUEST['ap_year1'] == '') $_REQUEST['ap_year1'] = PAP_STARTING_YEAR;
        if($_REQUEST['ap_day2'] == '') $_REQUEST['ap_day2'] = date("j");
        if($_REQUEST['ap_month2'] == '') $_REQUEST['ap_month2'] = date("n");
        if($_REQUEST['ap_year2'] == '') $_REQUEST['ap_year2'] = date("Y");
        if($_REQUEST['ap_showlist'] == '') $_REQUEST['ap_showlist'] = '0';

        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['ap_userid'] = $_REQUEST['ap_userid'];
        $_SESSION['ap_day1'] = $_REQUEST['ap_day1'];
        $_SESSION['ap_month1'] = $_REQUEST['ap_month1'];
        $_SESSION['ap_year1'] = $_REQUEST['ap_year1'];
        $_SESSION['ap_day2'] = $_REQUEST['ap_day2'];
        $_SESSION['ap_month2'] = $_REQUEST['ap_month2'];
        $_SESSION['ap_year2'] = $_REQUEST['ap_year2'];
        $_SESSION['ap_showlist'] = $_REQUEST['ap_showlist'];

        $userid = $_REQUEST['ap_userid'];
        $d1 = $_REQUEST['ap_day1'];
        $m1 = $_REQUEST['ap_month1'];
        $y1 = $_REQUEST['ap_year1'];
        $d2 = $_REQUEST['ap_day2'];
        $m2 = $_REQUEST['ap_month2'];
        $y2 = $_REQUEST['ap_year2'];
        
        // check payout option for this user
        $payoutData = $this->blAccounting->getPayoutOptionForUser($userid, $d1, $m1, $y1, $d2, $m2, $y2);
        if($payoutData == false)
        {
            QUnit_Messager::setErrorMessage(L_G_CANNOTGETPAYOUTOPTIONFORUSER);
            return false;
        }

        // draw paybutton        
        $this->assign('a_payoutData', $payoutData);

        $objPayoutOptions =& QUnit_Global::newObj('Affiliate_Merchants_Bl_PayoutOptions');
        $payout_methods = $objPayoutOptions->getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($payout_methods);
        $this->assign('a_list_data1', $list_data1);

        $payout_fields = $objPayoutOptions->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $this->assign('a_list_data2', $payout_fields);

        $this->addContent('manual_payout');

        if ($_REQUEST['ap_showlist'] == '1') {
            $orderby = " order by t.dateinserted desc";
            $where = " where affiliateid="._q($_REQUEST['ap_userid'])." and rstatus=".AFFSTATUS_APPROVED." and payoutstatus in (".AFFSTATUS_NOTAPPROVED.",".AFFSTATUS_SUPPRESSED.")".
                     " and (".sqlToDays('t.dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
                     " and (".sqlToDays('t.dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")".
                     " and (t.commission > 0)";
                     
            $sqlCount = "select count(*) as count from wd_pa_transactions t ";

            $sql = "select t.transid, t.totalcost, t.orderid,".
                   " t.productid, t.dateinserted as datecreated, t.rstatus, t.transtype,".
                   " t.transkind, t.payoutstatus, t.dateapproved, t.commission,".
                   " t.refererurl, t.ip, t.campcategoryid, t.data1, t.data2, t.data3 ".
                   "from wd_pa_transactions t";

            if(empty($_REQUEST['list_page']))
                $page = 0;
            else
                $page = $_REQUEST['list_page'];

            if($page !== '' && $rowsPerPage !== '')
            {
                //------------------------------------------------
                // get total number of records
                $rs = QCore_Sql_DBUnit::execute($sqlCount.$where, __FILE__, __LINE__);
                if (!$rs)
                {
                    QUnit_Messager::setErrorMessage(L_G_DBERROR);
                    return;
                }

                $rowsPerPage = $_REQUEST['numrows'];

                if(!is_numeric($rowsPerPage) || $rowsPerPage <= 0)
                    $rowsPerPage = 1000;

                //init paging
                $allcount = $rs->fields['count'];
                $_REQUEST['allcount'] = $allcount;

                if($allcount<$page*$rowsPerPage)
                    $page = 0;

                $_REQUEST['list_pages'] = (int) ceil($allcount/$rowsPerPage);
                $_REQUEST['list_page'] = $page;

                if($page == 0)
                    $limitOffset = 0;
                else
                    $limitOffset = ($page)*$rowsPerPage;
            }
            
            //------------------------------------------------
            // get records
            $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }

            $list_data = QUnit_Global::newobj('QCore_RecordSet');
            $list_data->setTemplateRS($rs);

            $this->assign('a_list_data', $list_data);
            $this->assign('a_md', 'Affiliate_Merchants_Views_AffiliatePayments');
            
            $this->pageLimitsAssign();

            $this->addContent('manual_payout_list');
        }

        return true;
    }
    
    //--------------------------------------------------------------------------

    function drawFormInvoice()
    {
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v) {
            if(strpos($k, 'ap_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }


        $userid = $_REQUEST['ap_userid'];

        //--------------------------------------
        // get default settings for unset variables
        if ($_REQUEST['ap_amount'] == '') {
            if($_REQUEST['ap_day1'] == '') $_REQUEST['ap_day1'] = 1;
            if($_REQUEST['ap_month1'] == '') $_REQUEST['ap_month1'] = 1;
            if($_REQUEST['ap_year1'] == '') $_REQUEST['ap_year1'] = PAP_STARTING_YEAR;
            if($_REQUEST['ap_day2'] == '') $_REQUEST['ap_day2'] = date("j");
            if($_REQUEST['ap_month2'] == '') $_REQUEST['ap_month2'] = date("n");
            if($_REQUEST['ap_year2'] == '') $_REQUEST['ap_year2'] = date("Y");
            $d1 = $_REQUEST['ap_day1'];
            $m1 = $_REQUEST['ap_month1'];
            $y1 = $_REQUEST['ap_year1'];
            $d2 = $_REQUEST['ap_day2'];
            $m2 = $_REQUEST['ap_month2'];
            $y2 = $_REQUEST['ap_year2'];
            $payoutData = $this->blAccounting->getPayoutOptionForUser($userid, $d1, $m1, $y1, $d2, $m2, $y2);
            if($payoutData == false)
            {
                QUnit_Messager::setErrorMessage(L_G_CANNOTGETPAYOUTOPTIONFORUSER);
                return false;
            }
            $_REQUEST['ap_amount'] = $payoutData['amount'];
        }
        
        $invoice = QUnit_Global::newObj('Affiliate_Merchants_Bl_Invoice');
        $this->assign('a_invoice', $invoice->getFilledInvoice($userid, $_REQUEST['ap_amount']));

        $this->addContent('payout_invoice');

        return true;
    }

    //--------------------------------------------------------------------------
    
    function showPayments()
    {
        $objPayoutOptions =& QUnit_Global::newObj('Affiliate_Merchants_Bl_PayoutOptions');
        $payout_methods = $objPayoutOptions->getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $this->assign('a_payout_methods', $payout_methods);
        
        //--------------------------------------
        // clear checkboxes
        if ($_REQUEST['filtered'] == '1') {
            if (!isset($_REQUEST['ap_reachedminpayout'])) $_REQUEST['ap_reachedminpayout'] = 'no';
        }

        if($_REQUEST['submited'] && !isset($_REQUEST['ap_virtual_affiliates'])) {
            $_REQUEST['ap_virtual_affiliates'] = 'no';
        }
        
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'ap_') === 0 && !isset($_REQUEST[$k]))
            $_REQUEST[$k] = $v;
        }
        
        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['ap_payout_type'] == '')
            foreach($payout_methods as $value) {
                $_REQUEST['ap_payout_type'][] = $value['payoptid'];
            }
        if($_REQUEST['ap_showtype'] == '') $_REQUEST['ap_showtype'] = 'allunpaid';
        if($_REQUEST['ap_day1'] == '') $_REQUEST['ap_day1'] = date("j");
        if($_REQUEST['ap_month1'] == '') $_REQUEST['ap_month1'] = date("n");
        if($_REQUEST['ap_year1'] == '') $_REQUEST['ap_year1'] = date("Y");
        if($_REQUEST['ap_day2'] == '') $_REQUEST['ap_day2'] = date("j");
        if($_REQUEST['ap_month2'] == '') $_REQUEST['ap_month2'] = date("n");
        if($_REQUEST['ap_year2'] == '') $_REQUEST['ap_year2'] = date("Y");
        if($_REQUEST['ap_reachedminpayout'] == '') $_REQUEST['ap_reachedminpayout'] = 'yes';
        
        $minyear = getMinYear(array('wd_pa_transactions' => 'dateinserted'));
        $maxyear = getMaxYear(array('wd_pa_transactions' => 'dateinserted'));
        $this->assign('a_minyear', $minyear);
        $this->assign('a_maxyear', $maxyear);

        if($_REQUEST['ap_showtype'] == 'allunpaid')
        {
            $_REQUEST['ap_day1'] = 1;
            $_REQUEST['ap_month1'] = 1;
            $_REQUEST['ap_year1'] = $minyear;
            $_REQUEST['ap_day2'] = 31;
            $_REQUEST['ap_month2'] = 12;
            $_REQUEST['ap_year2'] = $maxyear;
        }
        
        // process time filter
//dbg($_REQUEST);
        if(($_REQUEST['ap_showtype'] == 'daterange') && ($_REQUEST['ap_timeselect'] == TIME_PRESET)) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['ap_timepreset'], 'ap_'));
        }
        
        //--------------------------------------
        // put settings into session
        $_SESSION['ap_payout_type'] = $_REQUEST['ap_payout_type'];
        $_SESSION['ap_showtype'] = $_REQUEST['ap_showtype'];
        $_SESSION['ap_note'] = $_REQUEST['ap_note'];
        $_SESSION['ap_day1'] = $_REQUEST['ap_day1'];
        $_SESSION['ap_month1'] = $_REQUEST['ap_month1'];
        $_SESSION['ap_year1'] = $_REQUEST['ap_year1'];
        $_SESSION['ap_day2'] = $_REQUEST['ap_day2'];
        $_SESSION['ap_month2'] = $_REQUEST['ap_month2'];
        $_SESSION['ap_year2'] = $_REQUEST['ap_year2'];
        $_SESSION['ap_timepreset'] = $_REQUEST['ap_timepreset'];
        $_SESSION['ap_timeselect'] = $_REQUEST['ap_timeselect'];
        $_SESSION['ap_reachedminpayout'] = $_REQUEST['ap_reachedminpayout'];
        $_SESSION['ap_virtual_affiliates'] = $_REQUEST['ap_virtual_affiliates'];
        
        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK)
        {
            $params = array(
                'AccountID' => $GLOBALS['Auth']->getAccountID()
            );
            $objCampaign =& QUnit_Global::includeClass('Affiliate_Merchants_Bl_Campaign');
            $userIDs = $objCampaign->getMerchantCampaignUsers($params);
        
            if(!is_array($userIDs) || count($userIDs) < 1)
                $userIDs = '';
        }
        else $userIDs = '';
        
        
        
        $conditions = array(
            'CampaignID' => '',
            'UserID' => $userIDs,
            'TransactionType' => '',
            'Status' => '',
            'page' => '',
            'rowsPerPage' => '',
            'day1' => $_REQUEST['ap_day1'],
            'month1' => $_REQUEST['ap_month1'],
            'year1' => $_REQUEST['ap_year1'],
            'day2' => $_REQUEST['ap_day2'],
            'month2' => $_REQUEST['ap_month2'],
            'year2' => $_REQUEST['ap_year2'],
            'virtual_affiliates' => $_REQUEST['ap_virtual_affiliates'] == 'yes');
            
        if($_REQUEST['ap_showtype'] == 'allunpaid') {
            $conditions['day1']   =  1;
            $conditions['month1'] =  1;
            $conditions['year1']  =  $minyear;
            $conditions['day2']   =  31;
            $conditions['month2'] =  12;
            $conditions['year2']  =  $maxyear;
        }
        $objStatistics =& QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleStatistics');
        $transdata = $objStatistics->getTransactionsSummaries($conditions);
        
        $newTransdata = array();
        foreach($transdata as $data)
        {
            if($data['approved'] <= 0)
                continue;
                
            if ($data['payout_type'] == '') $data['payout_type'] = 'none';
                
            if($_REQUEST['ap_reachedminpayout'] == 'yes' && ($data['approved'] < $data['minpayout'] || $data['minpayout'] == ''))
                continue;
         
            if (count($_REQUEST['ap_payout_type']) == 0)
                continue;
            
            if (!in_array($data['payout_type'], $_REQUEST['ap_payout_type']))
                continue;
            

            $temp = $data;
            
            $temp['payment_data'] = '';
            
            if(is_array($data['payout_fields']) && count($data['payout_fields']) > 0 ) 
            {
                foreach($data['payout_fields'] as $field)
                {
                    $temp['payment_data'] .= ($temp['payment_data'] != '' ? ',' : '').$field['name'].': '.$field['value'].' ';
                }
            }
            else 
            {
                $temp['payment_data'] = '<font color=#ff0000>'.L_G_UNDEFINED.'</font>';
            }
            
            if($data['payout_method_name'] != '')
            {
                $temp['payment_type'] = $data['payout_method_name'];
            }
            else
            {
                //$temp['payment_type'] = '<font color=#ff0000>'.L_G_UNDEFINED.'</font>';
                $temp['payment_type'] = '-';
            }
            
            $temp['address'] = $data['address'];
            $temp['db_payout_type'] = $data['payout_type'];
            $temp['name'] = $temp['surname'].', '.$temp['name'];
            
            $newTransdata[] = $temp;
        }
        
        //sorting
        $sortby = '';
        switch ($_REQUEST['sortby']) {
            case 'name':
                $sortby = 'name';
                break;
                
            case 'amount':
                $sortby = 'approved';
                break;
        }

        // sorting, default by affiliate surname, name
        if (!empty($sortby)) {
            $GLOBALS['uasort_by'] = $sortby;
            $GLOBALS['uasort_order'] = $_REQUEST['sortorder'];
            usort($newTransdata, cmp_sort);
        }
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($newTransdata);
        $this->assign('a_list_data', $list_data);
        
        $this->assign('a_transdata', count($newTransdata));
        
        $this->assign('a_objMerchBlSettings', QUnit_Global::newobj('Affiliate_Merchants_Bl_Settings'));
        
        $this->addContent('ap_list');
    }
    
	//--------------------------------------------------------------------------
    
    function startApprovePaymentsAndSendMail()
    {
        if(($userIDs = $this->returnUIDs()) == false)
            return false;

        $params = array();
        $params['userids'] = $userIDs;
        $params['accounting_note'] = $_REQUEST['accounting_note'];
        $params['send_invoice_to'] = $_REQUEST['send_invoice_to'];
        $params['y1'] = $_REQUEST['ap_year1'];
        $params['m1'] = $_REQUEST['ap_month1'];
        $params['d1'] = $_REQUEST['ap_day1'];
        $params['y2'] = $_REQUEST['ap_year2'];
        $params['m2'] = $_REQUEST['ap_month2'];
        $params['d2'] = $_REQUEST['ap_day2'];
        
        if($_REQUEST['mp_date1'] != '')
        {
            // parameters from manual payment form
            $params['date1'] = $_REQUEST['mp_date1'];
            $params['date2'] = $_REQUEST['mp_date2'];
        }
        else
        {
            $params['date1'] = $_REQUEST['ap_year1'].'-'.$_REQUEST['ap_month1'].'-'.$_REQUEST['ap_day1'];
            $params['date2'] = $_REQUEST['ap_year2'].'-'.$_REQUEST['ap_month2'].'-'.$_REQUEST['ap_day2'];
        }
        
        $params['accountingID'] = $this->blAccounting->createAccountingRecord($params);
        $params['usersDone'] = 0;
        
     
        $_SESSION['approve_payment_params'] = $params;
        
        $this->assign('a_process_payments_url', 'index_popup.php?md=Affiliate_Merchants_Views_AffiliatePayments&action=markandsend');
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function processApprovePaymentsAndSendMail()
    {
        $params = $_SESSION['approve_payment_params'];
        
        $users = $params['userids'];
        $emailToSend = $params['usersDone'];
        $i = 0;
        $emailsSend = 0;
        $emailsCount = count($users);
        $maxTimeToRun = (ini_get('max_execution_time') == '') ? 20 : ini_get('max_execution_time') - 10;
        
        $maxTimeToRun = 1;

        foreach($users as $userid)
        {
            if($i++ < $emailToSend) {
                continue;
            }

            $this->blAccounting->markPaymentAsPaidAndSendInvoice($userid, $params);

            $emailsSend++;
            QUnit_Page::end_timer();
		    $timeRunning = QUnit_Page::getTimeGenerated();
		    // do we have time to send another email
		    if ($timeRunning + $timeRunning/$emailsSend > $maxTimeToRun) {
		        $params['usersDone'] = $emailToSend + $emailsSend; 
		        break;
		    }
        }
        
        $_SESSION['approve_payment_params'] = $params;

        if($emailToSend + $emailsSend < $emailsCount) {
            $this->assign('a_message', ($emailToSend + $emailsSend).' '.L_G_OF.' '.$emailsCount.' '.L_G_INVOICESSENT);
            Redirect_nomsg("index_popup.php?md=Affiliate_Merchants_Views_AffiliatePayments&action=markandsend", 0);
        } else {
            $this->assign('a_message', 'end');
        }
        
        $this->addContent('sendinvoice_progress');
    }
    
    //--------------------------------------------------------------------------
    
    function drawFormSelectedInvoices() {
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v) {
            if(strpos($k, 'ap_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }


        $userids = $_SESSION['invoice_userids'];

        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['ap_day1'] == '') $_REQUEST['ap_day1'] = 1;
        if($_REQUEST['ap_month1'] == '') $_REQUEST['ap_month1'] = 1;
        if($_REQUEST['ap_year1'] == '') $_REQUEST['ap_year1'] = PAP_STARTING_YEAR;
        if($_REQUEST['ap_day2'] == '') $_REQUEST['ap_day2'] = date("j");
        if($_REQUEST['ap_month2'] == '') $_REQUEST['ap_month2'] = date("n");
        if($_REQUEST['ap_year2'] == '') $_REQUEST['ap_year2'] = date("Y");
        $d1 = $_REQUEST['ap_day1'];
        $m1 = $_REQUEST['ap_month1'];
        $y1 = $_REQUEST['ap_year1'];
        $d2 = $_REQUEST['ap_day2'];
        $m2 = $_REQUEST['ap_month2'];
        $y2 = $_REQUEST['ap_year2'];
        
        $invoice = QUnit_Global::newObj('Affiliate_Merchants_Bl_Invoice');
        $invoiceTexts = array();
        
        foreach ($userids as $userid) {
            $payoutData = $this->blAccounting->getPayoutOptionForUser($userid, $d1, $m1, $y1, $d2, $m2, $y2);
            if($payoutData == false)
            {
                QUnit_Messager::setErrorMessage(L_G_CANNOTGETPAYOUTOPTIONFORUSER);
                return false;
            }
            $invoiceTexts[] = $invoice->getFilledInvoice($userid, $payoutData['amount']);
        }
        
        $this->assign('a_invoice_texts', $invoiceTexts);

        $this->addContent('payout_invoices');

        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function prepareFormSelectedInvoices() {
        if(($userIDs = $this->returnUIDs()) == false) {
            QUnit_Messager::setErrorMessage(L_G_NOAFFILIATESSELECTED);
            return false;
        }
        
        $_SESSION['invoice_userids'] = $userIDs;

        $this->assign('a_show_invoices_url', 'index_popup.php?md=Affiliate_Merchants_Views_AffiliatePayments&action=view_selected_invoices');
        
    }
}
?>
