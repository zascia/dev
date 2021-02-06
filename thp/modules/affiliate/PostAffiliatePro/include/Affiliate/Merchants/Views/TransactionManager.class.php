<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');

class Affiliate_Merchants_Views_TransactionManager extends QUnit_UI_ListPage
{
    var $campCategory;
    var $blAffiliate;
    var $blTransactions;
    var $viewCampManager;
    var $viewCampCategManager;
    var $blRules;
    var $blCommunications;
    var $blTimeStat;
    var $blCampaign;
    var $countryInfo;

    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Views_TransactionManager()
    {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blTransactions =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Transactions');
        $this->viewCampManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
        $this->viewCampCategManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampCategoriesManager');
        $this->blRules =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Rules');
        $this->blSettings =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Settings');
        $this->blCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');
        $this->blEmailTemplates =& QUnit_Global::newObj('QCore_EmailTemplates');
        $this->blTimeStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TimerangeStatistics');
        $this->blCampaign =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Campaign');

        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_CTRSALES,'index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all');
    }

    //--------------------------------------------------------------------------

    function initPermissions()
    {
        $this->modulePermissions['approvetrans'] = 'aff_trans_transactions_approvedecline';
        $this->modulePermissions['denytrans'] = 'aff_trans_transactions_approvedecline';
        $this->modulePermissions['create'] = 'aff_trans_transactions_modify';
        $this->modulePermissions['edit'] = 'aff_trans_transactions_modify';
        $this->modulePermissions['suppress'] = 'aff_trans_transactions_approvedecline';
        $this->modulePermissions['approve'] = 'aff_trans_transactions_approvedecline';
        $this->modulePermissions['delete'] = 'aff_trans_transactions_modify';
        $this->modulePermissions['view'] = 'aff_trans_transactions_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        $this->assign('a_filterColumns', $this->getAvailableFilterColumns());
        $this->assign('a_form_preffix', 'tm_');
        $this->assign('a_form_name', 'FilterForm');

        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'approvetrans':
                    if($this->processChangeState(AFFSTATUS_APPROVED))
                        return;
                    break;

                case 'denytrans':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED))
                        return;
                    break;

                case 'create':
                    if($this->processCreateTransaction())
                        return;
                    break;

                case 'update':
                    if($this->processUpdateTransaction())
                        return;
                    break;
            }

            switch($_POST['massaction'])
            {
                case 'suppress':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED))
                        return;
                break;

                case 'approve':
                    if($this->processChangeState(AFFSTATUS_APPROVED))
                        return;
                break;

                case 'pending':
                    if($this->processChangeState(AFFSTATUS_NOTAPPROVED))
                        return;
                break;

                case 'delete':
                    if($this->processDelete())
                        return;
                break;
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'delete':
                    if($this->processDelete())
                        return;
                    break;

                case 'suppress':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED))
                        return;
                    break;

                case 'approve':
                    if($this->processChangeState(AFFSTATUS_APPROVED))
                        return;
                    break;

                case 'pending':
                    if($this->processChangeState(AFFSTATUS_NOTAPPROVED))
                        return;
                    break;

                case 'create':
                    $this->navigationAddURL(L_G_CREATETRANSACTION,'index.php?md=Affiliate_Merchants_Views_TransactionManager&action=create');
                    if($this->drawFormCreateTransaction())
                        return;
                    break;

                case 'createrefundchargeback':
	               	if($this->drawFormCreateRefundChargebackTransaction())
                		return;
                	break;

                case 'ipinfo':
	               	if($this->drawFormIpInfo())
                		return;
                	break;

                case 'transdetails':
	               	if($this->drawTransactionDetails())
                		return;
                	break;

                case 'edit':
                    if($this->drawFormEditTransaction())
                        return;
                    break;
                case 'exporttoapprove':
                    $this->processExportToApprove();
                    break;
                case 'importtoapprove':
                    $this->processImportToApprove();
                    break;
                                        
                case 'showtransactionstats':
                    $this->showTransactionsStats();
                    return;
            }
        }

        if($_REQUEST['action'] == 'exportcsv')
            $this->showTransactions(true);
        else
            $this->showTransactions(false);
    }

    //--------------------------------------------------------------------------

    function drawFormEditTransaction()
    {
        if($_POST['commited'] != 'yes')
        {
            $params = array('AccountID' => $GLOBALS['Auth']->getAccountID());

            $this->blTransactions->loadTransactionInfo($params);
        }

        $_POST['header'] = L_G_EDIT_TRANSACTION;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'update';

        $users = $this->blAffiliate->getUsersAsArray();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($users);
        $this->assign('a_list_users', $list_data);

        $this->addContent('transactions_edit');

        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormCreateTransaction()
    {
        $_POST['commtype'] = TRANSTYPE_CLICKPERSALE;

        $campaigns = $this->viewCampManager->getCampaignsAsArray();
        $campaigns[0] = array('campaignid' => 0,
            				  'name' => L_G_NOCAMPAIGN,
            				  'commtype' => TRANSTYPE_REFUND | TRANSTYPE_CHARGEBACK);
        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $users = $this->blAffiliate->getUsersAsArray();
        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($users);
        $this->assign('a_list_data2', $list_data2);

        $this->getUsersForFilter();

        $this->assign('a_affselecet_all_disabled', '1');

        $this->addContent('trans_create');

        return true;
    }


    //--------------------------------------------------------------------------

    function drawFormCreateRefundChargebackTransaction()
    {
        if($_REQUEST['tid'] == '')
        	return false;

        if($_REQUEST['loaddata'] == 1) {
        	$params = array('AccountID' => $GLOBALS['Auth']->getAccountID());
        	$this->blTransactions->loadTransactionInfo($params, 'tm_');
        	$_POST['tm_totalcost'] *= -1;
        	$_POST['tm_commission'] *= -1;
        	$_POST['tm_userid'] = $_POST['tm_affiliate'];

	        $affiliate = $this->blAffiliate->getUserInfoShort($_POST['tm_affiliate']);
        	$_POST['affiliatename'] = $affiliate['name']." ".$affiliate['surname'];

        	if(($_POST['tm_transtype'] == TRANSTYPE_SIGNUP) || ($_POST['tm_transtype'] == TRANSTYPE_REFERRAL)) {
        		$_POST['tm_campaignname'] = L_G_NOCAMPAIGN;
        		$_POST['tm_campaignid'] = 0;
        	} else {
        		$campaign = $this->viewCampManager->getCampaignInfo($_POST['tm_campcategoryid']);
        		$_POST['tm_campaignname'] = $campaign['name'];
        		$_POST['tm_campaignid'] = $campaign['campaignid'];
        	}
        }

		$this->addContent('trans_create_refund_chargeback');
        return true;
    }

    //--------------------------------------------------------------------------

    function processUpdateTransaction()
    {
        // protect against script injection
        $rstatus = preg_replace('/[^0-9]/', '', $_POST['rstatus']);
        $transtype = preg_replace('/[^0-9]/', '', $_POST['transtype']);
        $transkind = preg_replace('/[^0-9]/', '', $_POST['transkind']);
        $payoutstatus = preg_replace('/[^0-9]/', '', $_POST['payoutstatus']);
        $totalcost = preg_replace('/[\'\"]/', '', $_POST['totalcost']);
        $refererurl = preg_replace('/[\'\"]/', '', $_POST['refererurl']);
        $affiliate = preg_replace('/[\'\"]/', '', $_POST['affiliate']);
        $parenttrans = preg_replace('/[\'\"]/', '', $_POST['parenttrans']);
        $commission = preg_replace('/[\'\"]/', '', $_POST['commission']);
        $ip = preg_replace('/[\'\"]/', '', $_POST['ip']);
        $productid = preg_replace('/[\'\"]/', '', $_POST['productid']);
        $data1 = preg_replace('/[\'\"]/', '', $_POST['data1']);
        $data2 = preg_replace('/[\'\"]/', '', $_POST['data2']);
        $data3 = preg_replace('/[\'\"]/', '', $_POST['data3']);
        $TransID = preg_replace('/[\'\"]/', '', $_POST['tid']);

        // check correctness of the fields
        checkCorrectness($_POST['rstatus'], $rstatus, L_G_STATUS, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['transtype'], $transtype, L_G_TRANSTYPE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['transkind'], $transkind, L_G_TRANSKIND, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['payoutstatus'], $payoutstatus, L_G_PAYOUT_STATUS, CHECK_ALLOWED, CHECK_NUMBER);
        checkCorrectness($_POST['totalcost'], $totalcost, L_G_TOTAL_COST, CHECK_ALLOWED);
        checkCorrectness($_POST['refererurl'], $refererurl, L_G_REFERRER_URL, CHECK_ALLOWED);
        checkCorrectness($_POST['affiliate'], $affiliate, L_G_AFFILIATE, CHECK_EMPTYALLOWED);

        checkCorrectness($_POST['parenttrans'], $parenttrans, L_G_PARENTTRANS, CHECK_ALLOWED);
        if($parenttrans != '')
        {
            if($transkind <= TRANSKIND_SECONDTIER)
                QUnit_Messager::setErrorMessage(L_G_CANNOTCHOOSEPARENTTRANS);
            else if($this->blTransactions->checkTransactionExists($parenttrans, $GLOBALS['Auth']->getAccountID()))
                QUnit_Messager::setErrorMessage(L_G_TRANSACTIONDOESNOTEXISTS);
        }

        checkCorrectness($_POST['commission'], $commission, L_G_COMMISSIONS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['ip'], $ip, L_G_IP, CHECK_ALLOWED);
        checkCorrectness($_POST['productid'], $productid, L_G_PRODUCTID, CHECK_ALLOWED);
        checkCorrectness($_POST['data1'].' '.$_POST['data2'].' '.$_POST['data3'], $data1.' '.$data2.' '.$data3, L_G_EXTRA_FIELD, CHECK_ALLOWED);

        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
            $params = array('rstatus' => $rstatus,
                            'transtype' => $transtype,
                            'transkind' => $transkind,
                            'payoutstatus' => $payoutstatus,
                            'totalcost' => $totalcost,
                            'refererurl' => $refererurl,
                            'affiliate' => $affiliate,
                            'parenttrans' => $parenttrans,
                            'commission' => $commission,
                            'ip' => $ip,
                            'productid' => $productid,
                            'data1' => $data1,
                            'data2' => $data2,
                            'data3' => $data3,
                            'TransID' => $TransID,
                            'AccountID' => $GLOBALS['Auth']->getAccountID()
                           );

            if($this->blTransactions->updateTransaction($params))
                QUnit_Messager::setOkMessage(L_G_TRANSACTION_EDITED);

            $this->redirect('Affiliate_Merchants_Views_TransactionManager&type=all');
//            $this->closeWindow('Affiliate_Merchants_Views_TransactionManager&type=all');
//            $this->addContent('closewindow');

            return true;
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function processExportToApprove() {
        $sql =  "select transid, orderid, productid, totalcost ".
                "from wd_pa_transactions ".
                "where rstatus = ".AFFSTATUS_NOTAPPROVED.
                " and accountid = "._q($GLOBALS['Auth']->getAccountID());
        if($_REQUEST['tm_userid'] != '' && $_REQUEST['tm_userid'] != '_') {
            $sql .= " and affiliateid = "._q($_REQUEST['tm_userid']);
        }
        if(is_array($_REQUEST['tm_transtype']) && count($_REQUEST['tm_transtype'])>0) {
            $sql .= " and transtype in (".implode(',', $_REQUEST['tm_transtype']).")";
        }
        if($_REQUEST['tm_orderid'] != '') {
            $sql .= " and orderid like '%"._q_noendtags($_REQUEST['tm_orderid'])."%'";
        }

            $sql .= " and (".sqlToDays('dateinserted')." >= ".sqlToDays($_REQUEST['tm_year1']."-".$_REQUEST['tm_month1']."-".$_REQUEST['tm_day1']).")".
                      " and (".sqlToDays('dateinserted')." <= ".sqlToDays($_REQUEST['tm_year2']."-".$_REQUEST['tm_month2']."-".$_REQUEST['tm_day2']).")";

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) return false;

        while($row = $rs->FetchRow()) {
            $sql = "select transid from wd_pa_trans_approve where transid = '".$row['transid']."'";
            $rs3 = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if($rs3->RecordCount() == 0) {
                $sql =  "insert into wd_pa_trans_approve set ".
                        "transid = '".$row['transid']."', ".
                        "orderid = '".$row['orderid']."', ".
                        "productid = '".$row['productid']."', ".
                        "totalcost = '".$row['totalcost']."', ".
                        "rstatus = 0";
                $rs2 = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                if(!$rs2) return false;
            }
        }
        QUnit_Messager::setOkMessage(L_G_EXPORTSUCCESSFULL);
        return true;

    }

    //--------------------------------------------------------------------------

    function processImportToApprove()
    {
        $sql =  "select transid, orderid, productid, totalcost, rstatus ".
                "from wd_pa_trans_approve";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) return false;

        while($row = $rs->FetchRow())
        {
            if($row['rstatus'] == 2 || $row['rstatus'] == 3)
            {
                $params = array();
                $params['transids'] = array($row['transid']);
                if($row['rstatus'] == 2) {
                    $params['state'] = AFFSTATUS_APPROVED;
                } else {
                    $params['state'] = AFFSTATUS_SUPPRESSED;
                }

                if($this->blTransactions->changeState($params) == true) {
                    $sql = "delete from wd_pa_trans_approve where transid = '".$row['transid']."'";
                    $rs2 = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                }
            }
            else {
                $sql = "delete from wd_pa_trans_approve where transid = '".$row['transid']."'";
                $rs2 = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            }
        }
        QUnit_Messager::setOkMessage(L_G_IMPORTSUCCESSFULL);
        return true;
    }

    //--------------------------------------------------------------------------

    function processCreateTransaction()
    {
        // protect against script injection
        $tid = preg_replace('/[\'\"]/', '', $_POST['tid']);
        $userid = preg_replace('/[\'\"]/', '', $_POST['tm_userid']);
        $campaignid = preg_replace('/[\'\"]/', '', $_POST['tm_campaignid']);
        $transtype = preg_replace('/[\'\"]/', '', $_POST['tm_transtype']);
        $status = preg_replace('/[^0-9]/', '', $_POST['tm_rstatus']);
        if(!in_array($transtype, array(TRANSTYPE_REFUND, TRANSTYPE_CHARGEBACK))) {
        	$totalcost = preg_replace('/[^0-9\.]/', '', $_POST['tm_totalcost']);
        } else {
        	$totalcost = preg_replace('/[\'\"]/', '', $_POST['tm_totalcost']);
        }
        $orderid = preg_replace('/[\'\"]/', '', $_POST['tm_orderid']);
        $productid = preg_replace('/[\'\"]/', '', $_POST['tm_productid']);
        $commission = preg_replace('/[\'\"]/', '', $_POST['tm_commission']);
        $createtype = preg_replace('/[\'\"]/', '', $_POST['tm_createtype']);
        $data1 = preg_replace('/[\'\"]/', '', $_POST['tm_data1']);
        $data2 = preg_replace('/[\'\"]/', '', $_POST['tm_data2']);
        $data3 = preg_replace('/[\'\"]/', '', $_POST['tm_data3']);

        // check correctness of the fields
        checkCorrectness($_POST['tm_userid'], $userid, L_G_AFFILIATE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['tm_campaignid'], $campaignid, L_G_CAMPAIGN, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['tm_transtype'], $transtype, L_G_TYPE, CHECK_EMPTYALLOWED);
        if(!in_array($transtype, array(TRANSTYPE_REFUND, TRANSTYPE_CHARGEBACK)))
        	checkCorrectness($_POST['tm_totalcost'], $totalcost, L_G_TOTALCOST, CHECK_ALLOWED, CHECK_NUMBER);
        checkCorrectness($_POST['tm_createtype'], $createtype, L_G_TYPEOFCREATECOMMISSION, CHECK_EMPTYALLOWED);

        // do not save product category for per signup and per referral
        if ( ($campaignid != '0') && (in_array($transtype, array(TRANSTYPE_SIGNUP, TRANSTYPE_REFERRAL)) == 1) )
        {
        	QUnit_Messager::setErrorMessage(L_G_NOCATEGORYFORSIGNUPANDREFERRAL);
        	return;
        }
        // for other transaction types category has to be selected
        if ( (in_array($transtype, array(TRANSTYPE_SIGNUP, TRANSTYPE_REFERRAL, TRANSTYPE_REFUND, TRANSTYPE_CHARGEBACK)) != 1) && ($campaignid == '0') )
        {
        	QUnit_Messager::setErrorMessage(L_G_CATEGORYHASTOBESELECTED);
        	return;
        }

        if (($campaignid != '0') && (!$this->isTransTypeSupportedByCampaign($campaignid, $transtype))) {
        	QUnit_Messager::setErrorMessage(L_G_TRANSTYPENOTSUPPORTEDBYCAMPAIGN);
        	return;
        }

        // check totalcost and commision by refund and chargeback
        if (in_array($transtype, array(TRANSTYPE_REFUND, TRANSTYPE_CHARGEBACK)) == 1) {
        	$params = array('AccountID' => $GLOBALS['Auth']->getAccountID());
        	$parentTrans = $this->blTransactions->getTransactionInfo($tid ,$params);
        	if($totalcost > 0) {
        		QUnit_Messager::setErrorMessage(L_G_TOTALCOSTHAVETOBENEGATIVEORZERO);
        	}
        	if($commission > 0) {
        		QUnit_Messager::setErrorMessage(L_G_COMMISSIONHAVETOBENEGATIVEORZERO);
        	}
        	if(abs($totalcost) > $parentTrans['totalcost']) {
        		QUnit_Messager::setErrorMessage(L_G_TOTALCOSTBIGGERTHANPARENTTOTALCOST);
        	}
        	if(abs($commission) > $parentTrans['commission']) {
        		QUnit_Messager::setErrorMessage(L_G_COMMISSIONTBIGGERTHANPARENTCOMISSION);
        	}
        }

        if($createtype == 'manual')
        {
            checkCorrectness($_POST['tm_rstatus'], $status, L_G_STATUS, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['tm_commission'], $commission, L_G_COMMISSION, CHECK_EMPTYALLOWED, CHECK_NUMBER);
        }
         if(QUnit_Messager::getErrorMessage() != '')
        {
            return;
        }
        else
        {
            if($createtype == 'manual')
                $ret = $this->createManualCommission($userid, $campaignid, $transtype, $totalcost, $orderid, $productid, $status, $commission, $data1, $data2, $data3, $tid);
            else
                $ret = $this->createAutomaticCommission($userid, $campaignid, $transtype, $totalcost, $orderid, $productid, $data1, $data2, $data3);

            if($ret) {
                QUnit_Messager::setOkMessage(L_G_COMMISSIONCREATED);
            } else {
                QUnit_Messager::setErrorMessage(L_G_ERROR);
                return false;
            }

            $this->redirect('Affiliate_Merchants_Views_TransactionManager&type=all');

            return true;
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function isTransTypeSupportedByCampaign($campaignid, $transtype)
    {
    	if ( ($transtype == TRANSTYPE_REFUND) || ($transtype == TRANSTYPE_CHARGEBACK) )
    		return true;
    	if ($campaignid != '0') {
    		$sql = 'select * from wd_pa_campaigns c where c.deleted=0 and campaignid='._q($campaignid).' and accountid='._q($GLOBALS['Auth']->getAccountID());
        	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        	if (!$rs || $rs->EOF)
        	{
	            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            	return false;
        	}
        	return ((intval($rs->fields['commtype']) & intval($transtype)) != 0);
    	}
    	return true;
    }

    //--------------------------------------------------------------------------

    function getCommisionCategoryForUser($userid, $campaignid)
    {
    	//---------------------------------------
        // check commission category for this user
        $sql = 'select cc.* '.
               'from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campaignid='._q($campaignid).
               '  and cc.campcategoryid=ac.campcategoryid '.
               '  and affiliateid='._q($userid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        return false;

        if($rs->EOF)
        {
            // get basic commission category for this campaign
            $sql = 'select * from wd_pa_campaigncategories '.
                   'where deleted=0 and campaignid='._q($campaignid).
                   '  and name='._q(UNASSIGNED_USERS);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
            	return false;
        }

        return $rs;
    }

    //--------------------------------------------------------------------------

    function insertTransaction($userid, $campaignid, $campcategoryid, $transtype, $totalcost, $orderid, $productid, $status, $commission, $data1, $data2, $data3, $parenttransid = '')
    {
        $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
        $sql = "insert into wd_pa_transactions(transid, affiliateid, accountid, campcategoryid, dateinserted, orderid, productid, totalcost, transtype, transkind, rstatus, commission, data1, data2, data3".(($parenttransid == '') ? '' : ', parenttransid').")".
        "values("._q($TransID).","._q($userid).","._q($GLOBALS['Auth']->getAccountID()).","._q($campcategoryid).",".sqlNow().", ".myquotes($orderid).", ".myquotes($productid).",".myquotes($totalcost).","._q($transtype).",".TRANSKIND_NORMAL.","._q($status).",".myquotes($commission).",".myquotes($data1).",".myquotes($data2).",".myquotes($data3).(($parenttransid == '') ? '' : ', '.myquotes($parenttransid)).")";
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret) return false;
        else return $TransID;
    }

    //--------------------------------------------------------------------------

    function createManualCommission($userid, $campaignid, $transtype, $totalcost, $orderid, $productid, $status, $commission, $data1, $data2, $data3, $parenttransid='')
    {
        if ($campaignid != '0') {
    		if(($rs = $this->getCommisionCategoryForUser($userid, $campaignid)) == false)
        		return false;
        	$campcategoryid = $rs->fields['campcategoryid'];
        } else {
        	$campcategoryid = '';
        }

        if (($TransID=$this->insertTransaction($userid, $campaignid, $campcategoryid, $transtype, $totalcost, $orderid, $productid, $status, $commission, $data1, $data2, $data3, $parenttransid)) == false)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        else
        {
            if($status == AFFSTATUS_APPROVED)
            {
                $params = array('users' => array($userid),
                                'AccountID' => $GLOBALS['Auth']->getAccountID(),
                                'decimal_places' => $GLOBALS['Auth']->getSetting('Aff_round_numbers')
                               );

                if(($rules = $this->blRules->getRulesAsArray($params)) !== false)
                    $this->blRules->checkPerformanceRules($params, $rules);
            }

            $ntfSettings = QCore_Settings::getUserSettings(SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(), $userid);

            // check whether to send notification email to user
            if(($transtype == TRANSTYPE_SALE || $transtype == TRANSTYPE_LEAD) && ($ntfSettings['Aff_email_affonsale'] == 1))
            {
                $params = array();
                $params['id'] = $TransID;
                $params['commission'] = $commission;
                $params['totalcost'] = $totalcost;
                $params['orderid'] = $orderid;
                $params['productid'] = $productid;
                $params['date'] = date("Y-m-d H:i:s");
                $params['userid'] = $userid;
                $params['rstatus'] = $status;
                $params['ip'] = '';
                $params['referrer'] = '';
                $params['data1'] = $data1;
                $params['data2'] = $data2;
                $params['data3'] = $data3;

                $lang = $ntfSettings['Aff_aff_notificationlang'];

                $emaildata = $this->blEmailTemplates->getFilledEmailMessage($params['id'], $GLOBALS['Auth']->getAccountId(), 'AFF_EMAIL_AF_NTF_SLE', $lang, $params);
                if($emaildata != false)
                {
                    $email = $GLOBALS['Auth']->getUsernameForUser($userid, $GLOBALS['Auth']->getAccountID());

                    $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => $userid,
                            'email' => $email,
                            'settings' => $GLOBALS['Auth']->getSettings()
                    );

                    if(!$this->blCommunications->sendEmail($params)) {
                        $tempErrorMsg = "Sale registration: There was a problem sending affiliate notification email about sale transaction ID '".$params['id']."'";
                        QCore_History::DebugMsg(WLOG_ERROR, $tempErrorMsg, __FILE__, __LINE__);
                        QUnit_Messager::setErrorMessage($tempErrorMsg);
                    }
                    else {
                        QCore_History::DebugMsg(WLOG_ERROR, "Sale registration affiliate notification email about sale transaction ID '".$params['id']."' was succesfully generated and sent to '$email'", __FILE__, __LINE__);
                    }
                }
                else
                {
                    QCore_History::DebugMsg(WLOG_ERROR, "Sale registration:  There was a problem generating affiliate notification email about sale transaction ID '".$params['id']."' from template", __FILE__, __LINE__);
                    QUnit_Messager::setErrorMessage(L_G_EMAILTEMPERR);
                }
            }
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function createAutomaticCommission($userid, $campaignid, $transtype, $totalcost, $orderid, $productid, $data1, $data2, $data3)
    {
    	switch ($transtype) {
        	case TRANSTYPE_CLICK :
	            $clickReg =& QUnit_Global::newObj('Affiliate_Scripts_Bl_ClickRegistrator');
	            $clickReg->disableFraudProtection();

            	// check if this user and campaign exist
            	if(!$clickReg->checkUserExists($userid))
            	{
	                QCore_History::DebugMsg(WLOG_ERROR, "Click registration: Affiliate with ID: $userid doesn't exist", __FILE__, __LINE__);
                	return;
            	}

            	$clickReg->BannerID = '0';
            	$clickReg->CampaignID = $campaignid;

            	if(!$clickReg->checkCampaignExists())
            	{
	                QCore_History::DebugMsg(WLOG_ERROR, "Click registration: Campaign with ID: $campaignid doesn't exist", __FILE__, __LINE__);
                	return;
            	}

            	if(!$clickReg->checkUserInCampaign())
            	{
	                QCore_History::DebugMsg(WLOG_ERROR, "Click registration: Affiliate ID: $userid doesn't belong to the campaign ID: $campaignid", __FILE__, __LINE__);
                	return;
            	}

            	// saving transaction to DB
                $clickReg->setExtraData($data1, $data2, $data3);
            	return $clickReg->saveClick();
	        case TRANSTYPE_SALE :
    	        $saleReg =& QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');
    	        $saleReg->disableFraudProtection();
                $saleReg->setExtraData($data1, $data2, $data3);
        	    $saleReg->initData($userid, $campaignid);

	            return $saleReg->registerSale($totalcost, $orderid, $productid);
			case TRANSTYPE_LEAD :
				if(($rs = $this->getCommisionCategoryForUser($userid, $campaignid)) == false)
        			return false;
        		$c_settings = QCore_Settings::_getSettings(6, $GLOBALS['Auth']->getAccountID(), '', $rs->fields['campaignid']);
        		if ($this->insertTransaction($userid, $campaignid, $rs->fields['campcategoryid'], $transtype, $totalcost, $orderid, $productid, $c_settings['Aff_camp_saleapproval'], $rs->fields['salecommission'], $data1, $data2, $data3) == false) {
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		}
        		return true;
			case TRANSTYPE_RECURRING :
				if(($rs = $this->getCommisionCategoryForUser($userid, $campaignid)) == false)
        			return false;
        		if ($this->insertTransaction($userid, $campaignid, $rs->fields['campcategoryid'], $transtype, $totalcost, $orderid, $productid, AFFSTATUS_APPROVED, $rs->fields['recurringcommission'], $data1, $data2, $data3) == false) {
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		}
				return true;
			case TRANSTYPE_SIGNUP :
				$settings = $GLOBALS['Auth']->getSettings();
        		if ($this->insertTransaction($userid, '', '', $transtype, $totalcost, $orderid, $productid, AFFSTATUS_APPROVED, $settings['Aff_program_signup_bonus'], $data1, $data2, $data3) == false) {
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		}
				return true;
			case TRANSTYPE_CPM :
				if(($rs = $this->getCommisionCategoryForUser($userid, $campaignid)) == false)
        			return false;
        		if ($this->insertTransaction($userid, $campaignid, $rs->fields['campcategoryid'], $transtype, $totalcost, $orderid, $productid, AFFSTATUS_APPROVED, $rs->fields['cpmcommission'], $data1, $data2, $data3) == false) {
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		}
				return true;
			case TRANSTYPE_REFERRAL :
				$settings = $GLOBALS['Auth']->getSettings();
        		if ($this->insertTransaction($userid, '', '', $transtype, $totalcost, $orderid, $productid, AFFSTATUS_APPROVED, $settings['Aff_program_referral_commission'], $data1, $data2, $data3) == false) {
            		QUnit_Messager::setErrorMessage(L_G_DBERROR);
            		return false;
        		}
				return true;
    	}

    }

    //--------------------------------------------------------------------------

    function processDelete()
    {
        if(($transIDs = $this->returnUIDs()) == false)
            return false;

        $params = array();
        $params['transids'] = $transIDs;

        $this->blTransactions->delete($params);
        return false;

        $transid = preg_replace('/[\'\"]/', '', $_REQUEST['tid']);
        $sql = 'delete from wd_pa_transactions '.
               'where transid='._q($transid).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        // delete also possible recurring commissions
        $sql = 'update wd_pa_recurringcommissions set deleted=1 where originaltransid='._q($transid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        return false;
    }

    //--------------------------------------------------------------------------

    function returnUIDs()
    {
        if($_POST['massaction'] != '')
        {
            $transIDs = $_POST['itemschecked'];
        }
        else
        {
            $transIDs = array($_REQUEST['tid']);
        }

        return $transIDs;
    }

    //--------------------------------------------------------------------------

    function processChangeState($state)
    {
        if(($transIDs = $this->returnUIDs()) == false)
            return false;

        $params = array();
        $params['transids'] = $transIDs;
        $params['state'] = $state;

        $this->blTransactions->changeState($params);

        return false;
    }

    //--------------------------------------------------------------------------

    function showTransactions($exportToCsv)
    {
        $temp_perm['view'] = $this->checkPermissions('view');
        $temp_perm['create'] = $this->checkPermissions('create');

        $this->assign('a_action_permission', $temp_perm);

        $this->createWhereOrderBy($orderby, $where);

        $this->getUsersForFilter();
        $this->campCategory = $this->viewCampCategManager->getCampCategoriesAsArray();

        $campaigns = $this->viewCampManager->getCampaignsAsArray();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($campaigns);
        $this->assign('a_list_campaigns', $list_data);

        if($exportToCsv)
        {
            // prepare export file first
            $this->prepareExportFile($orderby, $where);
        }

        if($GLOBALS['Auth']->getSetting('Glob_acct_geo_allowed') == '1') {
            $blIpCountry = QUnit_Global::newObj('QCore_Bl_IpCountry');
            $this->countryInfo = $blIpCountry->getCountriesAsArray();
        }

        $recs = $this->getRecords($orderby, $where);
        $this->initViews();

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($recs);

        $this->assign('a_list_data', $list_data);
        $this->assign('a_curyear', date("Y"));

        $this->pageLimitsAssign();

        $this->addContent('tm_list');
    }

    //--------------------------------------------------------------------------

    function getUsersForFilter()
    {
        $usersRs = $this->blAffiliate->getUsersAsRs();
        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($usersRs);

        $this->assign('a_list_users', $list_data);
    }

    //--------------------------------------------------------------------------

    function createWhereOrderBy(&$orderby, &$where)
    {
        $orderby = '';
        $where = '';

        $a = array(
            'transid',
            'commission',
            'totalcost',
            'orderid',
            'productid',
            'dateinserted',
            'transtype',
            'transkind',
            'userid',
            'rstatus',
            'payoutstatus',
            'refererurl',
            'ip'
        );

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
        {
            $orderby = " order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
        }
        else
        {
            $orderby = " order by t.dateinserted desc";
        }

        if($_REQUEST['fromprofile'] == 1) {
            // it is called from profile
            $showAllPending = true;

            // it was called from main profile, display all pending transactions
            if($_REQUEST['tm_userid'] == '') $_REQUEST['tm_userid'] = '_';
            $_REQUEST['tm_custom1'] = '';
            $_REQUEST['tm_custom1data'] = '';
            $_REQUEST['tm_custom2'] = '';
            $_REQUEST['tm_custom2data'] = '';
            $_REQUEST['tm_timeselect'] = TIME_PRESET;
            $_REQUEST['tm_timepreset'] = TIME_ALL;
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset(TIME_ALL, 'tm_'));
            $_REQUEST['tm_advanced_filter_show'] = '1';
            $_REQUEST['tm_transtype'] = $trans = $GLOBALS['Auth']->getAllowedCommissionTypes();
            if ($_REQUEST['tmprof_status'] != '') {
                $_REQUEST['tm_status'] = $states = array($_REQUEST['tmprof_status']);
            } else {
                $_REQUEST['tm_status'] = $states = array(AFFSTATUS_APPROVED, AFFSTATUS_NOTAPPROVED, AFFSTATUS_SUPPRESSED);
            }
        } else {
            //--------------------------------------
            // try to load settings from session
            foreach($_SESSION as $k => $v) {
                if(strstr($k, 'tm_status') !== false && ($_REQUEST['status_comitted'] == '1')) {
                    continue;
                }
                if(strstr($k, 'tm_transtype') !== false && ($_REQUEST['transtype_comitted'] == '1')) {
                    continue;
                }
                if(strpos($k, 'tm_') === 0 && !isset($_REQUEST[$k])) {
                    $_REQUEST[$k] = $v;
                }
                if($k == 'numrows' && $_REQUEST[$k] == '') {
                    $_REQUEST[$k] = $v;
                }
            }

            //--------------------------------------
            // clear checkboxes
            if ($_REQUEST['filtered'] == '1') {
                if (!isset($_REQUEST['tm_status'])) $_REQUEST['tm_status'] = array();
                if (!isset($_REQUEST['tm_transtype'])) $_REQUEST['tm_transtype'] = array();
            }

            //--------------------------------------
            // get default settings for unset variables
            if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
            if($_REQUEST['tm_timeselect'] == '') $_REQUEST['tm_timeselect'] = TIME_PRESET;
            if($_REQUEST['tm_timepreset'] == '') $_REQUEST['tm_timepreset'] = TIME_TODAY;
            if($_REQUEST['tm_day1'] == '') $_REQUEST['tm_day1'] = date("j");
            if($_REQUEST['tm_month1'] == '') $_REQUEST['tm_month1'] = date("n");
            if($_REQUEST['tm_year1'] == '') $_REQUEST['tm_year1'] = date("Y");
            if($_REQUEST['tm_day2'] == '') $_REQUEST['tm_day2'] = date("j");
            if($_REQUEST['tm_month2'] == '') $_REQUEST['tm_month2'] = date("n");
            if($_REQUEST['tm_year2'] == '') $_REQUEST['tm_year2'] = date("Y");
            if($_REQUEST['tm_userid'] == '') $_REQUEST['tm_userid'] = '_';
            if($_REQUEST['tm_transtype'] == '') $_REQUEST['tm_transtype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();
            if($_REQUEST['tm_status'] == '') $_REQUEST['tm_status'] = array(AFFSTATUS_APPROVED, AFFSTATUS_NOTAPPROVED, AFFSTATUS_SUPPRESSED);

            // process time filter
            if($_REQUEST['tm_timeselect'] == TIME_PRESET) {
                $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['tm_timepreset'], 'tm_'));
            }
            // process transtype select
            $trans = $_REQUEST['tm_transtype'];
            $states = $_REQUEST['tm_status'];

            //--------------------------------------
            // put settings into session
            $_SESSION['numrows'] = $_REQUEST['numrows'];
            foreach ($_REQUEST as $key => $value) {
                if (substr($key, 0, 3) == 'tm_') {
                    $_SESSION[$key] = $value;
                }
            }
        }

        $puserid = preg_replace('/[\'\"]/', '', $_REQUEST['tm_userid']);
        $porderid = preg_replace('/[\'\"]/', '', $_REQUEST['tm_orderid']);
        $pstatus = preg_replace('/[^0-9]/', '', $_REQUEST['tm_status']);
        $custom1data = preg_replace('/[\'\"]/', '', $_REQUEST['tm_custom1data']);
        $custom2data = preg_replace('/[\'\"]/', '', $_REQUEST['tm_custom2data']);

        $where = " where t.affiliateid=a.userid and a.accountid="._q($GLOBALS['Auth']->getAccountID())." and a.deleted=0 and a.rstatus in (".AFFSTATUS_APPROVED.",".AFFSTATUS_NOTAPPROVED.") ";
        if ($_REQUEST['tm_campaign'] != '' && $_REQUEST['tm_campaign'] != '_') {
            $where .= " and cc.campaignid="._q($_REQUEST['tm_campaign']);
        }

        if($_REQUEST['fromprofile'] != 1) {
            $where .= " and (".sqlToDays('t.dateinserted')." >= ".sqlToDays($_REQUEST['tm_year1']."-".$_REQUEST['tm_month1']."-".$_REQUEST['tm_day1']).")".
                      " and (".sqlToDays('t.dateinserted')." <= ".sqlToDays($_REQUEST['tm_year2']."-".$_REQUEST['tm_month2']."-".$_REQUEST['tm_day2']).")";
        }

        if ($_REQUEST['tm_advanced_filter_show'] != '1') {
            $trans = $GLOBALS['Auth']->getAllowedCommissionTypes();
            if(is_array($trans)&& count($trans)>0) {
                $where .= " and transtype in (".implode(',', $trans).")";
            } else {
                $where .= " and transtype like ''";
            }
            return true;
        }
        
        if($puserid != '_' && $puserid != '') {
            $where .= " and t.affiliateid="._q($puserid);
        }

        if($porderid != '') {
            $where .= " and orderid like '%"._q_noendtags($porderid)."%'";
        }

        if(is_array($trans)&& count($trans)>0) {
            $where .= " and transtype in (".implode(',', $trans).")";
        } else {
            $where .= " and transtype like ''";
        }

        if(is_array($states)&& count($states)>0) {
            $where .= " and t.rstatus in (".implode(',', $states).")";
        } else {
            $where .= " and t.rstatus like ''";
        }

        if($custom1data != '') {
            $where .= ' and ('.$_REQUEST['tm_custom1'].' like \'%'._q_noendtags($custom1data).'%\')';
        }
        if($custom2data != '') {
            $where .= ' and ('.$_REQUEST['tm_custom2'].' like \'%'._q_noendtags($custom2data).'%\')';
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function prepareExportFile($orderby, $where)
    {
        // prepare file for export
        $fname = 't_'.date("Y_m_d").'_'.substr(md5(uniqid(rand(),1)), 0, 6).'.csv';
        $fdirname = $GLOBALS['Auth']->getSetting('Aff_export_dir').$fname;

        $exportFile = @fopen($fdirname, "wb");
        if($exportFile == FALSE)
        {
            showMsg(L_G_CANNOTWRITETOEXPORTDIR, 'error');
            return false;
        }

        $str = csvFormat(L_G_TRANSID);
        $str .= ';'.csvFormat(L_G_CAMOUNT);
        $str .= ';'.csvFormat(L_G_TOTALCOST);
        $str .= ';'.csvFormat(L_G_ORDERID);
        $str .= ';'.csvFormat(L_G_PRODUCTID);
        $str .= ';'.csvFormat(L_G_CREATED);
        $str .= ';'.csvFormat(L_G_DATEAPPROVED);
        $str .= ';'.csvFormat(L_G_PCNAME);
        $str .= ';'.csvFormat(L_G_TYPE);
        $str .= ';'.csvFormat(L_G_AFFILIATE);
        $str .= ';'.csvFormat(L_G_STATUS);
        $str .= ';'.csvFormat(L_G_PAID);
        $str .= ';'.csvFormat(L_G_DATEPAYOUT);
        $str .= ';'.csvFormat(L_G_IP);
        $str .= ';'.csvFormat(L_G_REFERER);
        $str .= ';'.csvFormat(L_G_DATA1);
        $str .= ';'.csvFormat(L_G_DATA2);
        $str .= ';'.csvFormat(L_G_DATA3);

        fwrite($exportFile, $str."\r\n");

        $sql = "select a.userid, a.name, a.surname, a.weburl, a.username, ".
               " t.transid, t.totalcost, t.orderid,".
               " t.productid, t.dateinserted, t.rstatus, t.transtype,".
               " t.transkind, t.payoutstatus, t.dateapproved, t.commission,".
               " t.refererurl, t.ip, t.campcategoryid, t.data1, t.data2, t.data3,".
               " t.datepayout, t.countrycode, t.count ".
               "from wd_pa_transactions t left join wd_pa_campaigncategories cc on t.campcategoryid=cc.campcategoryid, wd_g_users a ";
               
        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);

        while(!$rs->EOF)
        {
            $str = csvFormat($rs->fields['transid']);
            $str .= ';'.csvFormat($rs->fields['commission']);
            $str .= ';'.csvFormat($rs->fields['totalcost']);
            $str .= ';'.csvFormat($rs->fields['orderid']);
            $str .= ';'.csvFormat($rs->fields['productid']);
            $str .= ';'.csvFormat($rs->fields['dateinserted']);
            $str .= ';'.csvFormat($rs->fields['dateapproved']);
            $str .= ';'.csvFormat($this->campCategory[$rs->fields['campcategoryid']]);

            $transtype = '';
            if($rs->fields['transkind'] > TRANSKIND_SECONDTIER)
                $transtype = ($rs->fields['transkind'] - TRANSKIND_SECONDTIER).' - '.L_G_TIER.' ';

            $transtype .= $GLOBALS['Auth']->getCommissionTypeString($rs->fields['transtype']);
            $str .= ';'.csvFormat($transtype);


            $str .= ';'.csvFormat($rs->fields['name'].' '.$rs->fields['surname']);

            if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $rstatus = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $rstatus = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $rstatus = L_G_SUPPRESSED;

            $str .= ';'.csvFormat($rstatus);


            $str .= ';'.csvFormat(($rs->fields['payoutstatus'] == AFFSTATUS_APPROVED ? L_G_YES : L_G_NO));
            $str .= ';'.csvFormat($rs->fields['datepayout']);
            $str .= ';'.csvFormat($rs->fields['ip']);
            $str .= ';'.csvFormat($rs->fields['refererurl']);
            $str .= ';'.csvFormat($rs->fields['data1']);
            $str .= ';'.csvFormat($rs->fields['data2']);
            $str .= ';'.csvFormat($rs->fields['data3']);

            fwrite($exportFile, $str."\r\n");

            $rs->MoveNext();
        }
        fclose($exportFile);

        $this->assign('a_exportFileName', $fname);

        return true;

    }

    //--------------------------------------------------------------------------

    function getRecords($orderby, $where)
    {
        //------------------------------------------------
        // init paging
        $sql = 'select count(*) as count from wd_pa_transactions t left join wd_pa_campaigncategories cc on t.campcategoryid=cc.campcategoryid, wd_g_users a ';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

        //------------------------------------------------
        // get records
        $sql = "select a.userid, a.name, a.surname, a.weburl, a.username, ".
               " t.transid, t.totalcost, t.orderid,".
               " t.productid, t.dateinserted, t.rstatus, t.transtype,".
               " t.transkind, t.payoutstatus, t.dateapproved, t.commission,".
               " t.refererurl, t.ip, t.campcategoryid, t.data1, t.data2, t.data3,".
               " t.datepayout, t.countrycode, t.count ".
               "from wd_pa_transactions t left join wd_pa_campaigncategories cc on t.campcategoryid=cc.campcategoryid, wd_g_users a ";

        $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        return $rs;
    }

    //--------------------------------------------------------------------------

    /** returns list of columns in list view */
    function getAvailableColumns()
    {
        return array(
            'transid' =>            array(L_G_TRANSID, 'transid'),
            'commission' =>         array(L_G_CAMOUNT, 'commission'),
            'totalcost' =>          array(L_G_TOTALCOST, 'totalcost'),
            'orderid' =>            array(L_G_ORDERID, 'orderid'),
            'productid' =>          array(L_G_PRODUCTID, 'productid'),
            'dateinserted' =>       array(L_G_CREATED, 't.dateinserted'),
            'dateapproved' =>       array(L_G_DATEAPPROVED, 't.dateapproved'),
            'campcategoryid' =>     array(L_G_PCNAME, ''),
            'transtype' =>          array(L_G_TYPE, 'transtype'),
            'userid' =>             array(L_G_AFFILIATE, 'userid'),
            'rstatus' =>            array(L_G_STATUS, 't.rstatus'),
            'payoutstatus' =>       array(L_G_PAID, 't.payoutstatus'),
            'datepayout' =>         array(L_G_DATEPAYOUT, 't.datepayout'),
            'ip' =>                 array(L_G_IP, 'ip'),
            'refererurl' =>         array(L_G_REFERER, 'refererurl'),
            'data1' =>              array(L_G_DATA1, 'data1'),
            'data2' =>              array(L_G_DATA2, 'data2'),
            'data3' =>              array(L_G_DATA3, 'data3'),
            'actions' =>            array(L_G_ACTIONS, ''),
        );
    }

    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'trans_list';
    }

    //--------------------------------------------------------------------------

    function initViews()
    {
        // create default view
        $viewColumns = array(
            'transid',
            'commission',
            'totalcost',
            'orderid',
            'productid',
            'dateinserted',
            'campcategoryid',
            'transtype',
            'userid',
            'rstatus',
            'payoutstatus',
            'actions',
            'ip',
            'refererurl',
        );

        $this->createDefaultView($viewColumns);

        $this->loadAvailableViews();

        $tplAvailableViews = array();
        foreach($this->availableViews as $objView)
        {
            $tplAvailableViews[$objView->dbid] = $objView->getName();
        }

        $this->assign('a_list_views', $this->tplAvailableViews);

        $this->applyView();
    }

    //------------------------------------------------------------------------
    function drawFormIpInfo()
    {
    	if ($_REQUEST['ip'] == '') {
    		QUnit_Messager::setErrorMessage(L_G_NOIP);
    		return true;
    	}

    	$this->assign('a_data', array(ip => $_REQUEST['ip']));
       	$blIpCountry = QUnit_Global::newObj('QCore_Bl_IpCountry');
       	$this->assign('a_geo_columns',$blIpCountry->getAvalaibleColumns());
       	$this->assign('a_geo_data',   $blIpCountry->getCountryForIp($_REQUEST['ip']));

    	$this->addContent('tmp_ip_info');
    	return true;
    }

    //------------------------------------------------------------------------
    function drawTransactionDetails()
    {
        if ($_GET['tid'] == "") {
            $this->assign('a_error', L_G_NOTTRANSACTIONIDDEFINED);
            $this->addContent('trans_details');
            return true;
        }

        if( ($transdetails = $this->blTransactions->getTransactionDetails($_GET['tid'], $GLOBALS['Auth']->getAccountID())) == false ) {
            $this->assign('a_error', L_G_DBERROR);
            $this->addContent('trans_details');
            return true;
        }

        $this->assign('a_transdetails', $transdetails);

        $this->addContent('trans_details');

    	return true;
    }

   //--------------------------------------------------------------------------

    function printListRow($row)
    {
        $view = $this->getView();
        if($view == false || $view == null)
        {
            print '<td><font color="ff0000">no view given</font></td>';
            return false;
        }

        print "<tr name=\"tr_".$row['transid']."\" id=\"tr_".$row['transid']."\" class=listresult ".
                "onMouseover=\"this.className = (this.className == 'listresultSelected' ? 'listresultSelected' : 'listresultMouseOver');".
                              "var row = document.getElementById('row_".$row['transid']."');".
                              "row.className = (row.className == 'listresultSelected' ? 'listresultSelected' : 'listresultMouseOver');\"".
                "onMouseOut =\"this.className = (this.className == 'listresultSelected' ? 'listresultSelected' : 'listresult');".
                              "var row = document.getElementById('row_".$row['transid']."');".
                              "row.className = (row.className == 'listresultSelected' ? 'listresultSelected' : 'listresult');\">";

        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['transid'].'"
                   onclick="javascript: document.getElementById(\'tr_'.$row['transid'].'\').className= (this.checked ? \'listresultSelected\' : \'listresult\');'.
                                       'document.getElementById(\'row_'.$row['transid'].'\').className= (this.checked ? \'listresultSelected\' : \'listresult\')"></td>';

        foreach($view->columns as $column)
        {
            switch($column)
            {
                case 'transid': print '<td class=listresult nowrap>&nbsp;'.$row['transid'].'&nbsp;';
                        showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_TransactionManager&action=transdetails&tid=".$row['transid'], 300);
                        print '</td>';
                        break;

                case 'commission': print '<td class="listresultnocenter'.($row['commission'] < 0 ? ' minusCost' : '').'" align="right" nowrap>&nbsp;'.($row['commission'] != '' ? $this->blSettings->showCurrency($row['commission']) : '').'&nbsp;</td>';
                        break;

                case 'totalcost': print '<td class="listresultnocenter'.($row['totalcost'] < 0 ? ' minusCost' : '').'" align="right" nowrap>&nbsp;'.($row['totalcost'] != '' ? $this->blSettings->showCurrency($row['totalcost']) : '').'&nbsp;</td>';
                        break;

                case 'orderid': print '<td class=listresult nowrap>&nbsp;'.$row['orderid'].'&nbsp;</td>';
                        break;

                case 'productid': print '<td class=listresult align=right nowrap>&nbsp;'.$row['productid'].'&nbsp;</td>';
                        break;

                case 'dateinserted': print '<td class=listresult align=right nowrap>&nbsp;'.$row['dateinserted'].'&nbsp;</td>';
                        break;

                case 'dateapproved': print '<td class=listresult align=right nowrap>&nbsp;'.$row['dateapproved'].'&nbsp;</td>';
                        break;

                case 'datepayout': print '<td class=listresult align=right nowrap>&nbsp;'.$row['datepayout'].'&nbsp;</td>';
                        break;

                case 'productid': print '<td class=listresult align=right nowrap>&nbsp;'.$row['productid'].'&nbsp;</td>';
                        break;

                case 'campcategoryid': print '<td class=listresult align=right nowrap>&nbsp;'.$this->campCategory[$row['campcategoryid']].'&nbsp;</td>';
                        break;

                case 'transtype':
                        print '<td class=listresult align=right nowrap>&nbsp;';

                        if($row['transkind'] > TRANSKIND_SECONDTIER)
                            print ($row['transkind'] - TRANSKIND_SECONDTIER).' - '.L_G_TIER.' ';

                        print $GLOBALS['Auth']->getCommissionTypeString($row['transtype']);
                        if ($row['count'] > 1) print " * ".$row['count'];
                        print '&nbsp;</td>';
                        break;


                case 'rstatus':
                        print '<td class=listresultnocenter align=left nowrap>&nbsp;';

                        if($row['rstatus'] == AFFSTATUS_NOTAPPROVED) print '<img src="'.$this->getImage('sphore_pending.png').'" title="'.L_G_WAITINGAPPROVAL.'" alt="'.L_G_WAITINGAPPROVAL.'"> '.L_G_WAITINGAPPROVAL;
                        else if($row['rstatus'] == AFFSTATUS_APPROVED) print '<img src="'.$this->getImage('sphore_active.png').'" title="'.L_G_APPROVED.'" alt="'.L_G_APPROVED.'"> '.L_G_APPROVED;
                        else if($row['rstatus'] == AFFSTATUS_SUPPRESSED) print '<img src="'.$this->getImage('sphore_declined.png').'" title="'.L_G_SUPPRESSED.'" alt="'.L_G_SUPPRESSED.'"> '.L_G_SUPPRESSED;

                        print '&nbsp;</td>';
                        break;

                case 'payoutstatus': print '<td class=listresult nowrap>&nbsp;'.($row['payoutstatus'] == AFFSTATUS_APPROVED ? L_G_YES : L_G_NO).'&nbsp;</td>';
                        break;

                case 'ip':
                		if($GLOBALS['Auth']->getSetting('Glob_acct_geo_allowed') == '1') {
                			print '<td class=listresult nowrap>&nbsp;<a href="javascript:ViewIPInfo('._q($row['ip']).');">'.$row['ip'].'</a>';
                			print '&nbsp;&nbsp;('.(($this->countryInfo[$row['countrycode']] == '') ? L_G_UNKNOWN : $this->countryInfo[$row['countrycode']]['countryname']).')&nbsp;</td>';
                		} else {
                			print '<td class=listresult nowrap>&nbsp;'.$row['ip'].'&nbsp;</td>';
                		}
                        break;

                case 'refererurl':
                        print '<td class=listresultnocenter align=left nowrap>&nbsp;';
                        if (strlen($row['refererurl']) > 30) {
                            print substr($row['refererurl'], 0, 25)."&nbsp;&nbsp;".
                                  "<a name=\"row_".$row['transid']."_caption\" id=\"c1\" title=\"more\"".
                                  "href=\"javascript: showInfoRow('c1', 'row_".$row['transid']."', '&nbsp;<b>".L_G_REFERER.":</b> <a href=".$row['refererurl'].">".$row['refererurl']."</a>',
                                          '<img src=".$this->getImage('icon_more.gif').">', '<img src=".$this->getImage('icon_less.gif').">');\"><img src=".$this->getImage('icon_more.gif')."></a>";
                        } else {
                            print $row['refererurl'];
                        }
                        print '&nbsp;</td>';
                        break;

                case 'userid':
                        print '<td class=listresult nowrap>&nbsp;'.$row['userid'].': '.$row['name'].' '.$row['surname'].'&nbsp;';
                        /*$msg =  '<table cellpadding=2 cellspacing=0 border=0 width=100%>'.
                                '<tr><td><b>'.L_G_USERNAME.'</b></td><td><a href=index.php?md=Affiliate_Merchants_Views_BroadcastMessage&action=sendmsg&userid='.$row['userid'].'>'.$row['username'].'</a></td></tr>'.
                                '<tr><td><b>'.L_G_NAME.'</b></td><td>'.$row['name'].' '.$row['surname'].'</td></tr>'.
                                '<tr><td><b>'.L_G_WEBURL.'</b></td><td><a href='.$row['weburl'].' target=new>'.$row['weburl'].'</a></td></tr>'.
                                '<tr><td align=left><a class=SimpleLink href=index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=view&aid='.$row['userid'].'><b>'.L_G_VIEWPROFILE.'</b></a></td>'.
                                    '<td align=right><a class=SimpleLink href=index.php?md=Affiliate_Merchants_Views_BroadcastMessage&userid='.$row['userid'].'><b>'.L_G_SENDEMAIL .'</b></a></td></tr>'.
                                '</table>';
                        showQuickInfo($msg);*/
                        showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affdetails&aid=".$row['userid'], 300);
                        print '</td>';
                        break;

                case 'data1': print '<td class=listresult>&nbsp;'.$row['data1'].'&nbsp;</td>';
                        break;

                case 'data2': print '<td class=listresult>&nbsp;'.$row['data2'].'&nbsp;</td>';
                        break;

                case 'data3': print '<td class=listresult>&nbsp;'.$row['data3'].'&nbsp;</td>';
                        break;

                case 'actions':
                        $actions = array();
                        $i = 0;
                        if($this->checkPermissions('edit')) {
                            $actions[$i++] = array('id'     => 'edit',
                                                   'img'    => 'icon_edit.gif',
                                                   'desc'   => L_G_EDIT,
                                                   'action' => "editTransaction('".$row['transid']."');" );
                        }
                        if($this->checkPermissions('approve')) {
                            if (!in_array($row['transtype'], array(TRANSTYPE_REFUND, TRANSTYPE_CHARGEBACK))) {
                                if($row['rstatus'] != AFFSTATUS_APPROVED) {
                                    $actions[$i] = array('id'     => 'approve',
                                                         'img'    => 'icon_approve.gif',
                                                         'desc'   => L_G_APPROVE,
                                                         'action' => "ChangeState('".$row['transid']."','approve');");
                                }
                                if($row['rstatus'] != AFFSTATUS_SUPPRESSED) {
                                    $actions[$i+1] = array('id'     => 'suppress',
                                                           'img'    => 'icon_suppress.gif',
                                                           'desc'   => L_G_SUPPRESS,
                                                           'action' => "ChangeState('".$row['transid']."','suppress');");
                                }
                                if($row['rstatus'] != AFFSTATUS_NOTAPPROVED) {
                                    $actions[$i+2] = array('id'     => 'pending',
                                                           'img'    => 'icon_pending.gif',
                                                           'desc'   => L_G_PENDING,
                                                           'action' => "ChangeState('".$row['transid']."','pending');");
                                }
                            }
                            $i += 3;
                        }
                        if($this->checkPermissions('delete')) {
                            $actions[$i++] = array('id'     => 'delete',
                                                   'img'    => 'icon_delete.gif',
                                                   'desc'   => L_G_DELETE,
                                                   'action' => "Delete('".$row['transid']."');" );
                        }
                        if($this->checkPermissions('create')) {
                            if ($GLOBALS['Auth']->getSetting('Aff_support_refund_commissions') == 1) {
                                if(($row['transtype'] != TRANSTYPE_REFUND) && ($row['transtype'] != TRANSTYPE_CHARGEBACK) && ($row['commission'] != 0)) {
                                    $actions[$i]   = array('id'     => 'refund',
                                                           'img'    => 'icon_refund.gif',
                                                           'desc'   => L_G_AREFUND,
                                                           'action' => "createRefundTransaction('".$row['transid']."');");
                                }
                                $i++;
                            }
                            if ($GLOBALS['Auth']->getSetting('Aff_support_chargeback_commissions') == 1) {
                                if(($row['transtype'] != TRANSTYPE_REFUND) && ($row['transtype'] != TRANSTYPE_CHARGEBACK) && ($row['commission'] != 0)) {
                                    $actions[$i] = array('id'     => 'chargeback',
                                                         'img'    => 'icon_chargeback.gif',
                                                         'desc'   => L_G_ACHARGEBACK,
                                                         'action' => "createChargebackTransaction('".$row['transid']."');");
                                }
                                $i++;
                            }
                        }
                        $this->initTemporaryTE();
                        $this->temporaryAssign('a_actions', $actions);
                        $this->temporaryAssign('a_action_count', $i);
                        print '<td class=listresultnocenter align="left">'.$this->temporaryFetch('actions_icon').'</td>';
                        //print '<td class=listresultnocenter align="left">'.$this->temporaryFetch('actions_combo').'</td>';

                        break;

                default:
                        print '<td class=listresult>&nbsp;<font color="#ff0000">'.L_G_UNKNOWN.' '.$column.'</font>&nbsp;</td>';
                        break;
            }
        }

        print "</tr>";
        print "<tr id=\"row_".$row['transid']."\" style=\"display: none;\" ".
                "onMouseover=\"this.className = (this.className == 'listresultSelected' ? 'listresultSelected' : 'listresultMouseOver');".
                              "var row = document.getElementById('tr_".$row['transid']."');".
                              "row.className = (row.className == 'listresultSelected' ? 'listresultSelected' : 'listresultMouseOver');\"".
                "onMouseOut =\"this.className = (this.className == 'listresultSelected' ? 'listresultSelected' : 'listresult');".
                              "var row = document.getElementById('tr_".$row['transid']."');".
                              "row.className = (row.className == 'listresultSelected' ? 'listresultSelected' : 'listresult');\">".
              "<td class=listresult>-</td>".
              "<td id=\"row_".$row['transid']."_td\" class=\"listresultnocenter\" colspan=\"".(count($view->columns))."\" align=\"right\"></td></tr>";
    }

    //--------------------------------------------------------------------------

    function printNoRecords()
    {
        $view = $this->getView();
        if($view == false || $view == null) {
            return false;
        }
        print '<td class="listresult" colspan="'.(count($view->columns)+1).'"><b>'.L_G_NORECORDSFOUND.'</b></td>';

    }

    //--------------------------------------------------------------------------

    function printMassAction($cssClass = '', $hideHidden = false)
    {
        $view = $this->getView();
        $colspan = count($view->columns)+1;
?>
      <td align=left colspan="<?php echo $colspan?>" <?php echo ($cssClass != '') ? 'class="'.$cssClass.'"' : ''?>>&nbsp;&nbsp;&nbsp;<?php echo L_G_SELECTED;?>&nbsp;
<?php    if (!$hideHidden) { ?>
      <input type="hidden" name="massaction" id="massaction">
<?php    } ?>
      <?php if($this->checkPermissions('approve')) { ?>
           <input type="submit" value="<?php echo L_G_SUPPRESS?>"
              onclick="javascript:document.getElementById('massaction').value='suppress'">
      <?php }
         if($this->checkPermissions('approve')) { ?>
            <input type="submit" value="<?php echo L_G_APPROVE?>"
              onclick="javascript:document.getElementById('massaction').value='approve'">
      <?php }
         if($this->checkPermissions('approve')) { ?>
            <input type="submit" value="<?php echo L_G_PENDING?>"
              onclick="javascript:document.getElementById('massaction').value='pending'">
      <?php }
         if($this->checkPermissions('delete')) { ?>
            <input type="button" value="<?php echo L_G_DELETE?>"
              onclick="javascript:massDeleteTransaction()">
      <?php } ?>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <?php if($this->checkPermissions('create')) { ?>
            <input type="button" value="<?php echo L_G_CREATETRANSACTION?>"
              onclick="javascript:addTransaction();">
      <?php } ?>
      <?php if($this->checkPermissions('view')) { ?>
            <input type="button" value="<?php echo L_G_EXPORTTOCSV?>"
              onclick="javascript:FilterForm.action.value='exportcsv'; FilterForm.submit();">
      <?php } ?>
      <?php if($this->checkPermissions('create')) { ?>
            <input type="button" value="<?php echo L_G_IMPORTFROMFILE?>"
              onclick="document.location.href='index.php?md=Affiliate_Merchants_Views_TransactionImport'">
      <?php } ?>
      </td>
<?php
    }

    //------------------------------------------------------------------------------

    function showTransactionsStats() {
        $campaignID = $this->actualCampaignID;

        $d1 = date("j");
        $m1 = date("n");
        $y1 = date("Y");
        $d2 = date("j");
        $m2 = date("n");
        $y2 = date("Y");

        $dataToday = $this->blTimeStat->getTimerangeStats(
                    '', $campaignID, $d1, $m1, $y1, $d2, $m2, $y2,
                    $GLOBALS['Auth']->getAccountID()
                    );

        $dataAll = $this->blTimeStat->getTimerangeStats(
                    '', $campaignID, 1, 1, 1990, $d2, $m2, $y2,
                    $GLOBALS['Auth']->getAccountID()
                    );


        $values = '';
        // approved transactions today
        $values .= $dataToday['cpm_approved'] + $dataToday['clicks_approved'] + $dataToday['sales_approved'] +
                   $dataToday['leads_approved'] + $dataToday['recurring_approved'] + $dataToday['referral_approved'] +
                   $dataToday['signup_approved'] +
                   $dataToday['st_cpm_approved'] + $dataToday['st_clicks_approved'] + $dataToday['st_sales_approved'] +
                   $dataToday['st_leads_approved'] + $dataToday['st_recurring_approved'] + $dataToday['st_referral_approved'] +
                   $dataToday['st_signup_approved'];

        $values .= ';';

        // approved transactions all
        $values .= $dataAll['cpm_approved'] + $dataAll['clicks_approved'] + $dataAll['sales_approved'] +
                   $dataAll['leads_approved'] + $dataAll['recurring_approved'] + $dataAll['referral_approved'] +
                   $dataAll['signup_approved'] +
                   $dataAll['st_cpm_approved'] + $dataAll['st_clicks_approved'] + $dataAll['st_sales_approved'] +
                   $dataAll['st_leads_approved'] + $dataAll['st_recurring_approved'] + $dataAll['st_referral_approved'] +
                   $dataAll['st_signup_approved'];

        $values .= ',';

        // pending transactions today
        $values .= $dataToday['cpm_waitingapproval'] + $dataToday['clicks_waitingapproval'] + $dataToday['sales_waitingapproval'] +
                   $dataToday['leads_waitingapproval'] + $dataToday['recurring_waitingapproval'] + $dataToday['referral_waitingapproval'] +
                   $dataToday['signup_waitingapproval'] +
                   $dataToday['st_cpm_waitingapproval'] + $dataToday['st_clicks_waitingapproval'] + $dataToday['st_sales_waitingapproval'] +
                   $dataToday['st_leads_waitingapproval'] + $dataToday['st_recurring_waitingapproval'] + $dataToday['st_referral_waitingapproval'] +
                   $dataToday['st_signup_waitingapproval'];
        $values .= ';';
        // pending transactions all
        $values .= $dataAll['cpm_waitingapproval'] + $dataAll['clicks_waitingapproval'] + $dataAll['sales_waitingapproval'] +
                   $dataAll['leads_waitingapproval'] + $dataAll['recurring_waitingapproval'] + $dataAll['referral_waitingapproval'] +
                   $dataAll['signup_waitingapproval'] +
                   $dataAll['st_cpm_waitingapproval'] + $dataAll['st_clicks_waitingapproval'] + $dataAll['st_sales_waitingapproval'] +
                   $dataAll['st_leads_waitingapproval'] + $dataAll['st_recurring_waitingapproval'] + $dataAll['st_referral_waitingapproval'] +
                   $dataAll['st_signup_waitingapproval'];

        $values .= ',';

        // declined transactions today
        $values .= $dataToday['cpm_declined'] + $dataToday['clicks_declined'] + $dataToday['sales_declined'] +
                   $dataToday['leads_declined'] + $dataToday['recurring_declined'] + $dataToday['referral_declined'] +
                   $dataToday['signup_declined'] +
                   $dataToday['st_cpm_declined'] + $dataToday['st_clicks_declined'] + $dataToday['st_sales_declined'] +
                   $dataToday['st_leads_declined'] + $dataToday['st_recurring_declined'] + $dataToday['st_referral_declined'] +
                   $dataToday['st_signup_declined'];
        $values .= ';';
        // declined transactions all
        $values .= $dataAll['cpm_declined'] + $dataAll['clicks_declined'] + $dataAll['sales_declined'] +
                   $dataAll['leads_declined'] + $dataAll['recurring_declined'] + $dataAll['referral_declined'] +
                   $dataAll['signup_declined'] +
                   $dataAll['st_cpm_declined'] + $dataAll['st_clicks_declined'] + $dataAll['st_sales_declined'] +
                   $dataAll['st_leads_declined'] + $dataAll['st_recurring_declined'] + $dataAll['st_referral_declined'] +
                   $dataAll['st_signup_declined'];

        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');

        $labels = "<img src='".$this->getImage('sphore_active.png')."' border=0>&nbsp;<a class=textlink href='index.php?md=Affiliate_Merchants_Views_TransactionManager&fromprofile=1&tmprof_status=".AFFSTATUS_APPROVED."'>".L_G_APPROVED."</a>,";
        $labels .= "<img src='".$this->getImage('sphore_pending.png')."' border=0>&nbsp;<a class=textlink href='index.php?md=Affiliate_Merchants_Views_TransactionManager&fromprofile=1&tmprof_status=".AFFSTATUS_NOTAPPROVED."'>".L_G_WAITINGAPPROVAL."</a>,";
        $labels .= "<img src='".$this->getImage('sphore_declined.png')."' border=0>&nbsp;<a class=textlink href='index.php?md=Affiliate_Merchants_Views_TransactionManager&fromprofile=1&tmprof_status=".AFFSTATUS_SUPPRESSED."'>".L_G_SUPPRESSED."</a>";
        $graph->labels = $labels;
        $graph->values = $values;
        $graph->legend = L_G_TODAY.','.L_G_ALL;
        $graph->barColor = '#486B8F,#AEC4D2';
        $graph->barLength = 0.5;
        $graph->percValuesSize = 10;
        $graph->absValuesSize = 10;
        $graph->showValues = 1;
        $gdata = $graph->create();


        //------------------------------------------------
        // transactions by type
        $allowedCommissionsTypes = $GLOBALS['Auth']->getAllowedCommissionTypes();
        $labels = '';
        $values = '';

        if($GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions') == 1) {
            $labels .= ($labels != '' ? ',' : '').L_G_TYPECPM;
            $values .= ($values != '' ? ',' : '').($dataToday['cpm'] + $dataToday['st_cpm']).';'.($dataAll['cpm'] + $dataAll['st_cpm']);
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1) {
            $labels .= ($labels != '' ? ',' : '').L_G_PERCLICK;
            $values .= ($values != '' ? ',' : '').($dataToday['clicks'] + $dataToday['st_clicks']).';'.($dataAll['clicks'] + $dataAll['st_clicks']);
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_lead_commissions') == 1) {
            $labels .= ($labels != '' ? ',' : '').L_G_PERLEAD;
            $values .= ($values != '' ? ',' : '').($dataToday['leads'] + $dataToday['st_leads']).';'.($dataAll['leads'] + $dataAll['st_leads']);
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_sale_commissions') == 1) {
            $labels .= ($labels != '' ? ',' : '').L_G_PERSALE;
            $values .= ($values != '' ? ',' : '').($dataToday['sales'] + $dataToday['st_sales']).';'.($dataAll['sales'] + $dataAll['st_sales']);
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') == 1) {
            $labels .= ($labels != '' ? ',' : '').L_G_RECURRINGCOMMISSIONS;
            $values .= ($values != '' ? ',' : '').($dataToday['recurring'] + $dataToday['st_recurring']).';'.($dataAll['recurring'] + $dataAll['st_recurring']);
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_signup_commissions') == 1) {
            $labels .= ($labels != '' ? ',' : '').L_G_SIGNUPBONUS;
            $values .= ($values != '' ? ',' : '').($dataToday['signup'] + $dataToday['st_signup']).';'.($dataAll['signup'] + $dataAll['st_signup']);
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_referral_commissions') == 1) {
            $labels .= ($labels != '' ? ',' : '').L_G_PERREFERRAL;
            $values .= ($values != '' ? ',' : '').($dataToday['referral'] + $dataToday['st_referral']).';'.($dataAll['referral'] + $dataAll['st_referral']);
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_refund_commissions') == 1 || $GLOBALS['Auth']->getSetting('Aff_support_chargeback_commissions') == 1) {
            $tmp = '';
            if($GLOBALS['Auth']->getSetting('Aff_support_refund_commissions') == 1) {
                $tmp = L_G_REFUND;
            }
            if($GLOBALS['Auth']->getSetting('Aff_support_chargeback_commissions') == 1) {
                $tmp = ($tmp != '' ? '/' : '').L_G_CHARGEBACK;
            }

            $labels .= ($labels != '' ? ',' : '').$tmp;

            $values .= ($values != '' ? ',' : '').($dataToday['refund'] + $dataToday['st_refund'] + $dataToday['chargeback'] + $dataToday['st_chargeback']).';'.($dataAll['refund'] + $dataAll['st_refund'] + $dataAll['chargeback'] + $dataAll['st_chargeback']);
        }

        $this->assign('a_transstats_bystatus_graph', $gdata);

        $labels = $labels;
        $graph->labels = $labels;
        $graph->values = $values;
        $graph->legend = L_G_TODAY.','.L_G_ALL;
        $graph->barColor = '#486B8F,#AEC4D2';
        $graph->barLength = 0.5;
        $graph->percValuesSize = 10;
        $graph->absValuesSize = 10;
        $graph->showValues = 1;
        $gdata = $graph->create();

        $this->assign('a_transstats_bytype_graph', $gdata);
        
        $this->addContent('tm_stats');
    }

    //-------------------------------------------------------------------------------

    function getAvailableFilterColumns()
    {
        return array(
            'productid' =>        L_G_PRODUCTID,
            'refererurl' =>       L_G_REFERER,
            't.data1' =>            L_G_DATA1,
            't.data2' =>            L_G_DATA2,
            't.data3' =>            L_G_DATA3,
        );
    }


}
?>
