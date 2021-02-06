<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_Bl_GlobalFuncs');
QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QUnit_UI_ListPage');

class Affiliate_Merchants_Views_AffiliateManager extends QUnit_UI_ListPage
{
	var $blAffiliate;
	var $blPayoutOptions;
	var $blCampCategories;
	var $blSettings;
	var $blTimeStat;
	var $redirectClassName;

	//--------------------------------------------------------------------------

	function Affiliate_Merchants_Views_AffiliateManager() {
		$this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
		$this->blPayoutOptions =& QUnit_Global::newObj('Affiliate_Merchants_Bl_PayoutOptions');
		$this->blCampCategories =& QUnit_Global::newObj('Affiliate_Merchants_Bl_CampaignCategories');
		$this->blSettings =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Settings');
		$this->blTimeStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TimerangeStatistics');
		$this->redirectClassName = 'Affiliate_Merchants_Views_AffiliateManager';

		$this->navigationAddURL(L_G_HOME,'index.php?md=home');
		$this->navigationAddURL(L_G_TOPMENU_AFFILIATES,'index.php?md=Affiliate_Merchants_Views_AffiliateManager');
	}

	//--------------------------------------------------------------------------

	function initPermissions()
	{
		$this->modulePermissions['adduser'] = 'aff_aff_affiliates_modify';
		$this->modulePermissions['edituser'] = 'aff_aff_affiliates_modify';
		$this->modulePermissions['changecommcat'] = 'aff_aff_affiliates_modify';
		$this->modulePermissions['swapuser'] = 'aff_aff_affiliates_modify';
		$this->modulePermissions['suppress'] = 'aff_aff_affiliates_modify';
		$this->modulePermissions['approve'] = 'aff_aff_affiliates_modify';
		$this->modulePermissions['delete'] = 'aff_aff_affiliates_modify';
		$this->modulePermissions['add'] = 'aff_aff_affiliates_modify';
		$this->modulePermissions['view'] = 'aff_aff_affiliates_view';
		$this->modulePermissions['edit'] = 'aff_aff_affiliates_modify';
		$this->modulePermissions['changecommcat'] = 'aff_aff_affiliates_modify';
		$this->modulePermissions['accounting'] = 'aff_aff_affiliates_view';
		$this->modulePermissions['showtree'] = 'aff_aff_affiliates_view';
		$this->modulePermissions['swap'] = 'aff_aff_affiliates_modify';
		$this->modulePermissions['sendmail'] = 'aff_comm_broadcast_email_use';
	}

	//--------------------------------------------------------------------------

	function process()
	{
        $this->assign('a_form_preffix', 'um_');
        $this->assign('a_form_name', 'FilterForm');
        
		if(!empty($_POST['commited']))
		{
			switch($_POST['postaction'])
			{
				case 'adduser':
					if($this->processAddUser())
						return;
				break;

				case 'edituser':
				    $this->navigationAddURL(L_G_EDIT,'index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=edit');
					if($this->processEditUser())
						return;
				break;

				case 'changecommcat':
					if($this->processChangeCommCat())
						return;
				break;

				case 'swapuser':
					if($this->processSwapUser())
						return;
				break;

				case 'inviteaffiliate':
					if($this->processInviteAffiliate())
						return;
				break;
			}

			switch($_REQUEST['massaction'])
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

				case 'invite':
					if($this->drawInviteAffiliate())
						return;
				break;

				case 'sendmail':
					if($this->processSendMailToAffiliates())
						return;
				break;
			}
		}

		if(!empty($_REQUEST['action']))
		{
			switch($_REQUEST['action'])
			{
				case 'add':
					$this->navigationAddURL(L_G_CREATEAFFILIATE,'index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=add');
					if($this->drawFormAddUser())
						return;
				break;

				case 'view':
					$this->navigationAddURL(L_G_VIEW,'index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=view');
					if($this->drawFormViewUser())
						return;
				break;

				case 'affdetails':
					if($this->drawUserDetails())
						return;
				break;

				case 'affalldetails':
					if($this->drawAllUserDetails())
						return;
				break;

				case 'edit':
					$this->navigationAddURL(L_G_EDIT,'index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=edit');
					if($this->drawFormEditUser())
						return;
				break;

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

				case 'changecommcat':
					if($this->drawFormChangeCommCat())
						return;
				break;

				case 'accounting':
					$this->navigationAddURL(L_G_ACCOUNTINGDETAILS,'index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=accounting');
					if($this->drawFormAccounting())
						return;
				break;

				case 'showtree':
					$this->navigationAddURL(L_G_TREEOFAFFILIATES,'index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=showtree');
					if($this->drawTree())
						return;
				break;

				case 'swap':
					if($this->drawSwap())
						return;
				break;

				case 'invite':
					if($this->drawInviteAffiliate())
						return;
				break;
				
				case 'showaffstats':
				    $this->showAffiliateStats();
				return;
			}
		}

		if($_REQUEST['showtree'] == 1) {
			$this->navigationAddURL(L_G_TREEOFAFFILIATES,'index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=showtree');
			if($this->drawTree())
				return;
		}
        
		if($_REQUEST['action'] == 'exportcsv') {
			$this->navigationAddURL(L_G_EXPORTTOCSV,'');
			$this->showUsers(true);
		} else {
			$this->showUsers(false);
		}
	}

	//--------------------------------------------------------------------------

	function processDelete()
	{
		if(($userIDs = $this->returnUIDs()) == false)
			return false;

		$params = array();
		$params['userids'] = $userIDs;

		$this->blAffiliate->delete($params);
		return false;
	}

	//--------------------------------------------------------------------------

	function returnUIDs()
	{
		if($_POST['massaction'] != '')
		{
			$userIDs = $_POST['itemschecked'];
		}
		else
		{
			$userIDs = array($_REQUEST['aid']);
		}

		if(AFF_DEMO == 1)
		{
			$userIDs = removeFromArray($userIDs, 2);

			if(count($userIDs) <1)
				return false;
		}

		return $userIDs;
	}

	//--------------------------------------------------------------------------

	function processSendMailToAffiliates()
	{
		if(($userIDs = $this->returnUIDs()) == false)
			return false;

		$_SESSION['bm_userids'] = $userIDs;
		Redirect_nomsg("index.php?md=Affiliate_Merchants_Views_BroadcastMessage&fromsession=1");
	}

	//--------------------------------------------------------------------------

	function processChangeState($state)
	{
		if(($userIDs = $this->returnUIDs()) == false)
			return false;

		$params = array();
		$params['userids'] = $userIDs;
		$params['settings'] = $GLOBALS['Auth']->getSettings();

		if($state == AFFSTATUS_APPROVED)
			$this->blAffiliate->approve($params);
		elseif($state == AFFSTATUS_SUPPRESSED)
			$this->blAffiliate->decline($params);
	    else
	       $this->blAffiliate->pending($params);

		if (!empty($_REQUEST['prevwnd']) && ($_REQUEST['prevwnd'] == 'view')) {
			$this->drawFormViewUser();
			return true;
		} else
			return false;
	}

	//--------------------------------------------------------------------------

	function processEditUser()
	{
		$settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
		$settings = array_merge($settings, QCore_Settings::getGlobalSettings());
		if($settings['Aff_signup_affect_editing'] == "1") {
			$obj = QUnit_Global::newObj('Affiliate_Merchants_Bl_AffiliateEditNew');
			if(!$obj->process(true)) {
				return false;
			}
			QUnit_Messager::setOkMessage(L_G_AFFILIATEEDITED);

			$this->drawFormEditUser();
			return true;
		} else {
            $params = array();
			$params['type'] = 'edit';
			$protectedParams = $this->blAffiliate->checkData($params);
            $protectedParams['notifymail'] = $_POST['notifymail'];

			if(QUnit_Messager::getErrorMessage() != '')
			{
				return false;
			}
			else
			{
				if($this->blAffiliate->update($protectedParams))
					QUnit_Messager::setOkMessage(L_G_AFFILIATEEDITED);

				$this->drawFormEditUser();

				return true;
			}
		}

		return false;
	}

	//--------------------------------------------------------------------------

	function processAddUser()
	{
		$settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
		$settings = array_merge($settings, QCore_Settings::getGlobalSettings());

		$params = array();
		$params['type'] = 'edit';

		$protectedParams = $this->blAffiliate->checkData($params, false);
		$protectedParams['settings'] = $GLOBALS['Auth']->getSettings();
		$protectedParams['notifymail'] = $_POST['notifymail'];
        
		if(QUnit_Messager::getErrorMessage() != '')
		{
			return false;
		}
		else
		{
			if($this->blAffiliate->insert($protectedParams))
			QUnit_Messager::setOkMessage(L_G_AFFILIATEADDED);

			$this->drawFormAddUser();
		}

		return true;
	}

	//--------------------------------------------------------------------------

	function processChangeCommCat()
	{
		// protect against script injection
		$UserID = preg_replace('/[\'\"]/', '', $_POST['aid']);

		$sql = 'select campaignid from wd_pa_affiliatescampaigns '.
			   'where affiliateid='._q($UserID);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if(!$rs) {
			QUnit_Messager::setErrorMessage(L_G_DBERROR);
			return false;
		}

		$aff_categories = array();
		while(!$rs->EOF)
		{
			$aff_categories[] = $rs->fields['campaignid'];

			$rs->MoveNext();
		}

		/*$sql = 'delete from wd_pa_affiliatescampaigns '.
			   'where affiliateid='._q($UserID);
		$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if(!$ret) {
			QUnit_Messager::setErrorMessage(L_G_DBERROR);
			return;
		} */

		foreach($_POST as $key => $value)
		{
			if(strpos($key, 'affcategoryid') === false) continue;

			$CampaignID = substr($key, 13, 8);
			$CampCategoryID = $value;

			if($value == '') continue;

			// delete
			$sql = 'delete from wd_pa_affiliatescampaigns '.
				   'where affiliateid='._q($UserID).
				   '  and campaignid='._q($CampaignID);
			$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			if(!$ret) {
				QUnit_Messager::setErrorMessage(L_G_DBERROR);
				return;
			}

			// insert
			$AffiliateCampaignID = QCore_Sql_DBUnit::createUniqueID('wd_pa_affiliatescampaigns', 'affcampid');
			$sql = 'insert into wd_pa_affiliatescampaigns '.
				   '(affcampid, affiliateid, campcategoryid, campaignid, rstatus) '.
				   'values('._q($AffiliateCampaignID).','._q($UserID).
				   ','._q($CampCategoryID).','._q($CampaignID).','._q(AFFSTATUS_APPROVED).')';
			$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

			if(!$ret) {
				QUnit_Messager::setErrorMessage(L_G_DBERROR);
				return false;
			}
		}

		$this->redirect($this->redirectClassName);

		return true;
	}

	//------------------------------------------------------------------------

	function processSwapUser()
	{
		$UserID1 = preg_replace('/[\'\"]/', '', $_POST['u1']);
		$UserID2 = preg_replace('/[\'\"]/', '', $_POST['u2']);

		if(QCore_Bl_GlobalFuncs::checkCrossLink($UserID1, array($UserID1, $UserID2), 'userid', 'parentuserid', 'wd_g_users', 1, 1))
		{
			QUnit_Messager::setErrorMessage(L_G_CANNOT_SWAP_DIRECT_CHILD);
			QUnit_Messager::setErrorMessage(L_G_SWAP_FAILED);
		}
		else if(QCore_Bl_GlobalFuncs::checkCrossLink($UserID2, array($UserID1, $UserID2), 'userid', 'parentuserid', 'wd_g_users', 1, 1))
		{
			QUnit_Messager::setErrorMessage(L_G_CANNOT_SWAP_DIRECT_CHILD);
			QUnit_Messager::setErrorMessage(L_G_SWAP_FAILED);
		}
		else
		{
			$objForcedMatrix =& QUnit_Global::newObj('Affiliate_Merchants_Bl_ForcedMatrix');
			if($objForcedMatrix->swapUsersParent($UserID1, $UserID2))
			{
				QUnit_Messager::setOkMessage(L_G_SWAP_OK);

				$this->closeWindow($this->redirectClassName.'&action=showtree');
				$this->addContent('closewindow');

				return true;
			}
			else
				QUnit_Messager::setErrorMessage(L_G_SWAP_FAILED);
		}

		return false;
	}

	//------------------------------------------------------------------------

	function processInviteAffiliate()
	{
		if($_POST['do_nothing'] == '1' || $GLOBALS['Auth']->getSetting('Aff_join_campaign') != 1)
		{
			$this->redirect($this->redirectClassName);
		}

		if($_POST['campaigncategories'] == '') {
		    QUnit_Messager::setErrorMessage(L_G_YOUHAVETOCHOOSECAMPAIGN);
		    return false;
		}

		if(is_array($_POST['campaigncategories']) && count($_POST['campaigncategories']) < 1) {
		    QUnit_Messager::setErrorMessage(L_G_YOUHAVETOCHOOSECAMPAIGN);
			return false;
		}

		$userIDs = unserialize(str_replace('\\','', $_POST['uids']));

		$params = array();
		$params['userIDs'] = $userIDs;
		$params['campaignIDs'] = $_POST['campaigncategories'];

		$ret = $this->blAffiliate->insertAffiliatesCampaigns($params);

		if($ret) QUnit_Messager::setOkMessage(L_G_INVITE_AFFILIATES_OK);
		else QUnit_Messager::setErrorMessage(L_G_INVITE_AFFILIATES_FAILED);

		$this->showUsers(false);	
		return true;
		
		//$this->closeWindow($this->redirectClassName);
		//$this->addContent('backbutton');

		//return true;
	}

	//------------------------------------------------------------------------

	function drawFormAccounting()
	{
		$this->loadUserInfo();

		$list_data1 = QUnit_Global::newobj('QCore_RecordSet');
		$list_data1->setTemplateRS($this->loadUserAccounting());

		$this->assign('a_list_data1', $list_data1);

		$payout_methods = $this->blPayoutOptions->getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
		$list_data2 = QUnit_Global::newobj('QCore_RecordSet');
		$list_data2->setTemplateRS($payout_methods);
		$this->assign('a_list_data2', $list_data2);

		$payout_fields = $this->blPayoutOptions->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
		$this->assign('a_list_data3', $payout_fields);

		$this->addContent('user_accounting');

		return true;
	}

	//--------------------------------------------------------------------------

	function loadUserAccounting()
	{
		$userid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);
		$sql = 'select accountingid, sum(commission) as commission '.
			   'from wd_pa_transactions '.
			   'where rstatus='.AFFSTATUS_APPROVED.
			   '  and payoutstatus='.AFFSTATUS_APPROVED.
			   '  and affiliateid='._q($userid);
		if($GLOBALS['Auth']->getProgramType() != PROG_TYPE_NETWORK)
			$sql .= ' and accountid='._q($GLOBALS['Auth']->getAccountID());
		$sql .=' group by accountingid';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if(!$rs)
		{
			QUnit_Messager::setErrorMessage(L_G_DBERROR);
			return false;
		}

		$data = array();
		$objAccounting =& QUnit_Global::newObj('Affiliate_Merchants_Views_Accounting');
		$accounting = $objAccounting->getAccountingAsArray();
		while(!$rs->EOF)
		{
			$temp = array();
			$temp['accountingid'] = $rs->fields['accountingid'];
			$temp['commission'] = $rs->fields['commission'];
			$temp['dateinserted'] = $accounting[$rs->fields['accountingid']]['dateinserted'];
			$temp['datefrom'] = $accounting[$rs->fields['accountingid']]['datefrom'];
			$temp['dateto'] = $accounting[$rs->fields['accountingid']]['dateto'];
			$temp['note'] = $accounting[$rs->fields['accountingid']]['note'];
			if($accounting[$rs->fields['accountingid']]['paypalfile'] != '')
				$temp['paypalfile'] = true;
			else
				$temp['paypalfile'] = false;

			if($accounting[$rs->fields['accountingid']]['mbfile'] != '')
				$temp['mbfile'] = true;
			else
				$temp['mbfile'] = false;

			if($accounting[$rs->fields['accountingid']]['wirefile'] != '')
				$temp['wirefile'] = true;
			else
				$temp['wirefile'] = false;
			$data[] = $temp;

			$rs->MoveNext();
		}

		return $data;
	}

	//--------------------------------------------------------------------------

	function loadUserInfo()
	{
		$userid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);

		$this->blAffiliate->loadUserInfoToPost($userid);
	}

	//--------------------------------------------------------------------------

	function getTransactionsStats()
	{
		$result[0] = $this->blTimeStat->getTimerangeStats(
						$_POST['aid'], '_', date('j'), date('n'), date('Y'), date('j'), date('n'), date('Y'));
		$result[1] = $this->blTimeStat->getTimerangeStats(
						$_POST['aid'], '_', 1, date('n'), date('Y'), getDaysInMonth(date('n'), date('Y')), date('n'), date('Y'));
		$result[2] = $this->blTimeStat->getTimerangeStats(
						$_POST['aid'], '_');

		return $result;
	}

	//--------------------------------------------------------------------------

	function drawFormViewUser()
	{
		$this->loadUserInfo();

		$payout_methods = $this->blPayoutOptions->getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
		$list_data1 = QUnit_Global::newobj('QCore_RecordSet');
		$list_data1->setTemplateRS($payout_methods);
		$this->assign('a_list_data1', $list_data1);

		$payout_fields = $this->blPayoutOptions->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
		$this->assign('a_list_data2', $payout_fields);

		$settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
		$settings = array_merge($settings, QCore_Settings::getGlobalSettings());
		$fieldRow = QUnit_Global::newobj('QUnit_UI_FieldRow');

		$fieldRow->initialize(true, $settings);
		$this->assign('fieldRow', $fieldRow);

		$stats = $this->getTransactionsStats();
		$this->assign('stats', $stats);

		$objSaleStatistics =& QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleStatistics');
		$transData = $objSaleStatistics->getTransactionsSummaries(array('UserID' => $_POST['aid']));
		$this->assign('transData', $transData);

		$this->addContent('user_view');

		return true;
	}

	//--------------------------------------------------------------------------

	function drawUserDetails()
	{
		$this->loadUserInfo();

		$this->addContent('user_view_details');

		return true;
	}

	//--------------------------------------------------------------------------

	function drawAllUserDetails()
	{
		$this->loadUserInfo();

		$settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
		$settings = array_merge($settings, QCore_Settings::getGlobalSettings());
		$fieldRow = QUnit_Global::newobj('QUnit_UI_FieldRow');
		$fieldRow->initialize(true, $settings);
		$this->assign('fieldRow', $fieldRow);

		$this->addContent('user_view_all_details');

		return true;
	}

	//--------------------------------------------------------------------------

	function drawFormEditUser()
	{
		if($_POST['commited'] != 'yes') {
			$this->loadUserInfo();
		}

		$_POST['header'] = L_G_EDITAFFILIATE;
		$_POST['action'] = 'edit';
		$_POST['postaction'] = 'edituser';

		$this->drawFormAddUser();

		return true;
	}

	//--------------------------------------------------------------------------

	function drawFormAddUser()
	{
		$settings = $GLOBALS['Auth']->getSettings();
		$this->assign('a_settings', $settings);

		if(!isset($_POST['action']))
			$_POST['action'] = 'add';
		if(!isset($_POST['postaction']))
			$_POST['postaction'] = 'adduser';

		if(!isset($_POST['header']))
			$_POST['header'] = L_G_ADDAFFILIATE;

		if ($settings['Aff_affiliateapproval'] == APPROVE_AUTOMATIC) {
			if($_POST['notifymail'] == '' && $_REQUEST['commited']) {
				$_POST['notifymail'] = 'no';
			}
			if (!isset($_SESSION['notifymail'])) {
				$_SESSION['notifymail'] = 'yes';
			}
			if ($_POST['notifymail'] == '') {
				$_POST['notifymail'] = $_SESSION['notifymail'];
			}
			$_SESSION['notifymail'] = $_POST['notifymail'];
		}

		$list_data = QUnit_Global::newobj('QCore_RecordSet');
		$list_data->setTemplateRS($GLOBALS['countries']);
		$this->assign('a_list_data', $list_data);

		$list_data2 = QUnit_Global::newobj('QCore_RecordSet');
		$list_data2->setTemplateRS(QCore_Settings::getMinPayoutsAsArray());
		$this->assign('a_list_data2', $list_data2);

		$users = $this->blAffiliate->getUsersAsArray();
		$list_data3 = QUnit_Global::newobj('QCore_RecordSet');
		$list_data3->setTemplateRS($users);
		$this->assign('a_list_data3', $list_data3);

		$payout_methods = $this->blPayoutOptions->getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
		$list_data4 = QUnit_Global::newobj('QCore_RecordSet');
		$list_data4->setTemplateRS($payout_methods);
		$this->assign('a_list_data4', $list_data4);

		$payout_fields = $this->blPayoutOptions->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
		$this->assign('a_list_data5', $payout_fields);

		$settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
		$settings = array_merge($settings, QCore_Settings::getGlobalSettings());
		$fieldRow = QUnit_Global::newobj('QUnit_UI_FieldRow');
		$fieldRow->initialize(false, $settings, true);
		
		$viewCampManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
        $campaigns = $viewCampManager->getCampaignsAsArray();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($campaigns);
        $this->assign('a_list_campaigns', $list_data);

		$this->assign('fieldRow', $fieldRow);

		if(!isset($_POST['minpayout']))
			$_POST['minpayout'] = $settings['Aff_initial_min_payout'];

		if ($_POST['action'] == 'edit') {
//            $stats = $this->getTransactionsStats();
//            $this->assign('stats', $stats);
		}

		$this->addContent('user_edit');

		return true;
	}

	//--------------------------------------------------------------------------

	function drawFormChangeCommCat()
	{
		if(!isset($_POST['action']))
		{
			$_POST['action'] = 'changecommcat';
		}
		if(!isset($_POST['postaction']))
		{
			$_POST['postaction'] = 'changecommcat';
		}

		$this->loadUserInfo();

		$UserID = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);

		$objCampaignManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
		$campcategs = $objCampaignManager->getCampaignsAsArray();
		$this->blCampCategories->getCategoriesAsArray($UserID, $campaignCategories, $AffiliateCategories);

		if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1')
		{
			$params = array('accountid' => $GLOBALS['Auth']->getAccountID(USERTYPE_USER));
			$objSettings =& QUnit_Global::newObj('Affiliate_Affiliates_Bl_Settings');
			$aff_campaign_settings = $objSettings->getAffCampaignSettings($params);
			$this->assign('a_CampaignData', $aff_campaign_settings);
		}

		$list_data = QUnit_Global::newobj('QCore_RecordSet');
		$list_data->setTemplateRS($campcategs);
		$this->assign('a_list_data', $list_data);

		$this->assign('a_campaignCategories', $campaignCategories);
		$this->assign('a_AffiliateCategories', $AffiliateCategories);

        $this->navigationAddURL(L_G_TOPMENU_AFFILIATES,'index.php?md=Affiliate_Merchants_Views_AffiliateManager');
		$this->addContent('user_commcat');

		return true;
	}

	//--------------------------------------------------------------------------

	function drawInviteAffiliate()
	{
		if($GLOBALS['Auth']->getSetting('Aff_join_campaign') != 1)
			return false;

		if($_POST['uids'] == '') {
			if(($userIDs = $this->returnUIDs()) == false)
				return false;

			$_POST['uids'] = serialize($userIDs);
		}

		$params = array('AccountID' => $GLOBALS['Auth']->getAccountID());

		$privateCampCategories = $this->blCampCategories->getPrivateCategoriesShortAsArray($params);

		$list_data = QUnit_Global::newobj('QCore_RecordSet');
		$list_data->setTemplateRS($privateCampCategories);
		$this->assign('a_list_data', $list_data);

		$this->assign('a_count', (is_array($privateCampCategories) ? count($privateCampCategories) : 0));

		$_POST['header'] = L_G_INVITEAFFILIATE;
		$_POST['action'] = 'invite';
		$_POST['postaction'] = 'inviteaffiliate';

		$this->addContent('user_invite');

		return true;
	}

	//--------------------------------------------------------------------------

	function showUsers($exportToCsv)
	{
		$temp_perm['add'] = $this->checkPermissions('add');
		$temp_perm['view'] = $this->checkPermissions('view');

		$this->assign('a_action_permission', $temp_perm);
		
		$this->initViews();

		$this->createWhereOrderBy($orderby, $where);

		$objSaleStatistics =& QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleStatistics');
		$view =& $this->getView();
		
		if ($view->isColumnUsed('paid') || $view->isColumnUsed('pending') || 
		    $view->isColumnUsed('approved') || $view->isColumnUsed('reversed')) {
		      $transdata = $objSaleStatistics->getTransactionsSummariesForAffiliateManager();
		}
		
		if ($view->isColumnUsed('payoptid')) {
		    $userInfo = $this->blSettings->getAccountUsersSettings($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
		}

		if($exportToCsv)
		{
			// prepare export file first
			$this->prepareExportFile($orderby, $where, $transdata, $userInfo);
		}

		$UserData = $this->getRecords($orderby, $where, $transdata, $userInfo);

		

		$list_data = QUnit_Global::newobj('QCore_RecordSet');
		$list_data->setTemplateRS($UserData);
		$this->assign('a_list_data', $list_data);

		$this->pageLimitsAssign();

		
		$this->assign('a_filterColumns', $this->getAvailableFilterColumns());

		$this->addContent('um_list');
	}

	//--------------------------------------------------------------------------

	function getAvailableFilterColumns()
	{
	    $col = array(
	        'a.refid' =>          L_G_REFID,
	        'a.company_name' =>   L_G_COMPANYNAME,
	        'a.weburl' =>         L_G_WEBURL,
	        'a.street' =>         L_G_STREET,
	        'a.city' =>           L_G_CITY,
	        'a.state' =>          L_G_STATE,
	        'a.country' =>        L_G_COUNTRY,
	        'a.zipcode' =>        L_G_ZIPCODE,
	        'a.phone' =>          L_G_PHONE,
	        'a.fax' =>            L_G_FAX,
	    );

		for ($i=1; $i<=5; $i++) {
			if($GLOBALS['Auth']->settings['Aff_signup_data'.$i] == '1') {
				$col['a.data'.$i] = $GLOBALS['Auth']->settings['Aff_signup_data'.$i.'_name'];
			}
		}
		return $col;
	}

	//--------------------------------------------------------------------------

	function getRecords($orderby, $where, $transdata, $userInfo)
	{
		//------------------------------------------------
		// init paging
		$sql = 'select count(*) as count from wd_g_users a';
		$limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

		//------------------------------------------------
		// get records
		$sql = 'select a.*, '.sqlShortDate('a.dateinserted').' as joined from wd_g_users a ';
		
		$rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);

		if(!$rs)
		{
			QUnit_Messager::setErrorMessage(L_G_DBERROR);
			return false;
		}

		$UserData = array();

		// prepare the data
		while(!$rs->EOF)
		{
			$UserData[$rs->fields['userid']]['userid'] = $rs->fields['userid'];
			$UserData[$rs->fields['userid']]['refid'] = $rs->fields['refid'];
			$UserData[$rs->fields['userid']]['joined'] = $rs->fields['joined'];
			$UserData[$rs->fields['userid']]['username'] = $rs->fields['username'];
			$UserData[$rs->fields['userid']]['name'] = $rs->fields['name'];
			$UserData[$rs->fields['userid']]['surname'] = $rs->fields['surname'];
			$UserData[$rs->fields['userid']]['paid'] = $transdata[$rs->fields['userid']]['paid'];
			$UserData[$rs->fields['userid']]['pending'] = $transdata[$rs->fields['userid']]['pending'];
			$UserData[$rs->fields['userid']]['approved'] = $transdata[$rs->fields['userid']]['approved'];
			$UserData[$rs->fields['userid']]['reversed'] = $transdata[$rs->fields['userid']]['reversed'];
			$UserData[$rs->fields['userid']]['parentuserid'] = $rs->fields['parentuserid'];
			$UserData[$rs->fields['userid']]['company_name'] = $rs->fields['company_name'];
			$UserData[$rs->fields['userid']]['weburl'] = $rs->fields['weburl'];
			$UserData[$rs->fields['userid']]['street'] = $rs->fields['street'];
			$UserData[$rs->fields['userid']]['city'] = $rs->fields['city'];
			$UserData[$rs->fields['userid']]['state'] = $rs->fields['state'];
			$UserData[$rs->fields['userid']]['country'] = $rs->fields['country'];
			$UserData[$rs->fields['userid']]['zipcode'] = $rs->fields['zipcode'];
			$UserData[$rs->fields['userid']]['phone'] = $rs->fields['phone'];
			$UserData[$rs->fields['userid']]['fax'] = $rs->fields['fax'];
			$UserData[$rs->fields['userid']]['tax_ssn'] = $rs->fields['tax_ssn'];
			$UserData[$rs->fields['userid']]['payoptid'] = $rs->fields['payoptid'];
			$UserData[$rs->fields['userid']]['actions'] = $rs->fields['actions'];
			$UserData[$rs->fields['userid']]['rstatus_numeric'] = $rs->fields['rstatus'];
			$UserData[$rs->fields['userid']]['data1'] = $rs->fields['data1'];
			$UserData[$rs->fields['userid']]['data2'] = $rs->fields['data2'];
			$UserData[$rs->fields['userid']]['data3'] = $rs->fields['data3'];
			$UserData[$rs->fields['userid']]['data4'] = $rs->fields['data4'];
			$UserData[$rs->fields['userid']]['data5'] = $rs->fields['data5'];

			if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $UserData[$rs->fields['userid']]['rstatus'] = L_G_APPROVED;
			else if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $UserData[$rs->fields['userid']]['rstatus'] = L_G_WAITINGAPPROVAL;
			else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $UserData[$rs->fields['userid']]['rstatus'] = L_G_SUPPRESSED;

			$rs->MoveNext();
		}

		// fill parent affiliate name, fill payout option name
		$usersObj =& QUnit_Global::newObj('QCore_Bl_Users');
		$UserDataShort = $usersObj->getUsersShort($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
		$PayOpt = $this->blPayoutOptions->getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID());

		if(is_array($UserData))
		{
			foreach($UserData as $user)
			{
				if($user['parentuserid'] == '' || $user['parentuserid'] == '0')
					$UserData[$user['userid']]['parentuserid'] = L_G_NONE2;
				else
					$UserData[$user['userid']]['parentuserid'] .= ': '.$UserDataShort[$UserData[$user['userid']]['parentuserid']]['name'].' '.$UserDataShort[$UserData[$user['userid']]['parentuserid']]['surname'];

				if($user['payoptid'] == '' || $user['payoptid'] == '0')
					$UserData[$user['userid']]['payoptid'] = L_G_NONE2;
				else
				{
					$UserData[$user['userid']]['payoptid'] =
							(defined($PayOpt[$UserData[$user['userid']]['payoptid']]['langid']) ?
							constant($PayOpt[$UserData[$user['userid']]['payoptid']]['langid']) :
							$PayOpt[$UserData[$user['userid']]['payoptid']]['name']);
				}
			}
		}

		//------------------------------------------------
		// get other user's data
		$UserData = $this->getOtherUserData($UserData);

		if($_REQUEST['sortby'] != '' &&  in_array($_REQUEST['sortby'], array('paid', 'pending', 'approved', 'reversed')))
		{
			if($_REQUEST['sortorder'] == '' || !in_array($_REQUEST['sortorder'], array('asc','desc')))
				$_REQUEST['sortorder'] = 'asc';

			$GLOBALS['uasort_by'] = $_REQUEST['sortby'];
			$GLOBALS['uasort_order'] = $_REQUEST['sortorder'];

			uasort($UserData, 'cmp_sort');
		}

		return $UserData;
	}

	//--------------------------------------------------------------------------

	function getOtherUserData($UserData)
	{
		$loadSettings = array(
			'Aff_user_ip'
			);

		$sql = 'select userid, code, value from wd_g_settings '.
			   'where rtype='._q(SETTINGTYPE_USER).
			   '  and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER)).
			   '  and rtype='.SETTINGTYPE_USER.
			   '  and code in (\''.implode('\',\'', $loadSettings).'\')'.
			   ' order by userid';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		while(!$rs->EOF)
		{
			if(isset($UserData[$rs->fields['userid']]))
			{
				$UserData[$rs->fields['userid']][$rs->fields['code']] = $rs->fields['value'];
			}

			$rs->MoveNext();
		}

		return $UserData;
	}

	//--------------------------------------------------------------------------

	function prepareExportFile($orderby, $where, $transdata, $userInfo)
	{
		$payout_fields_temp = $this->blPayoutOptions->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(),STATUS_ENABLED);

		// prepare file for export
		$fname = 'a_'.date('Y_m_d').'_'.substr(md5(uniqid(rand(),1)), 0, 6).'.csv';
		$fdirname = $GLOBALS['Auth']->getSetting('Aff_export_dir').$fname;

		$exportFile = @fopen($fdirname, "wb");
		if($exportFile == FALSE)
		{
			QUnit_Messager::setErrorMessage(L_G_CANNOTWRITETOEXPORTDIR.$GLOBALS['Auth']->getSetting('Aff_export_dir'));
			return false;
		}

		// write header
		$str = csvFormat(L_G_AFFILIATEID);
		$str .= ';'.csvFormat(L_G_REFID);
		$str .= ';'.csvFormat(L_G_PARENTID);
		$str .= ';'.csvFormat(L_G_NAME);
		$str .= ';'.csvFormat(L_G_COMPANYNAME);
		$str .= ';'.csvFormat(L_G_EMAIL);
		$str .= ';'.csvFormat(L_G_WEBURL);
		$str .= ';'.csvFormat(L_G_STREET);
		$str .= ';'.csvFormat(L_G_CITY);
		$str .= ';'.csvFormat(L_G_STATE);
		$str .= ';'.csvFormat(L_G_COUNTRY);
		$str .= ';'.csvFormat(L_G_ZIPCODE);
		$str .= ';'.csvFormat(L_G_PHONE);
		$str .= ';'.csvFormat(L_G_FAX);

		$str .= ';'.csvFormat(L_G_TAXSSN);
		$str .= ';'.csvFormat(L_G_PAID);
		$str .= ';'.csvFormat(L_G_PENDING);
		$str .= ';'.csvFormat(L_G_APPROVED);
		$str .= ';'.csvFormat(L_G_REVERSED);
		$str .= ';'.csvFormat(L_G_STATUS);

		$payout_fields = $payout_fields_temp;
		if(is_array($payout_fields)) {
			foreach($payout_fields as $fields) {
				if(is_array($fields)) {
					foreach($fields as $field) {
						$str .= ';'.csvFormat((defined($field['langid']) ? constant($field['langid']) : $field['name']));
					}
				}
			}
		}

		//$str = utf2ascii($str);
		fwrite($exportFile, $str."\r\n");

		// write data
		$sql = 'select a.*, '.sqlShortDate('a.dateinserted').' as joined from wd_g_users a ';
		$rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);

		while(!$rs->EOF)
		{
			$str = csvFormat($rs->fields['userid']);
			$str .= ';'.csvFormat($rs->fields['refid']);
			$str .= ';'.csvFormat($rs->fields['parentuserid']);
			$str .= ';'.csvFormat($rs->fields['name'].' '.$rs->fields['surname']);
			$str .= ';'.csvFormat($rs->fields['company_name']);
			$str .= ';'.csvFormat($rs->fields['username']);
			$str .= ';'.csvFormat($rs->fields['weburl']);
			$str .= ';'.csvFormat($rs->fields['street']);
			$str .= ';'.csvFormat($rs->fields['city']);
			$str .= ';'.csvFormat($rs->fields['state']);
			$str .= ';'.csvFormat($rs->fields['country']);
			$str .= ';'.csvFormat($rs->fields['zipcode']);
			$str .= ';'.csvFormat($rs->fields['phone']);
			$str .= ';'.csvFormat($rs->fields['fax']);

			$str .= ';'.csvFormat($rs->fields['tax_ssn']);

			$str .= ";".$transdata[$rs->fields['userid']]['paid'];
			$str .= ";".$transdata[$rs->fields['userid']]['pending'];
			$str .= ";".$transdata[$rs->fields['userid']]['approved'];
			$str .= ";".$transdata[$rs->fields['userid']]['reversed'];

			if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $status = L_G_APPROVED;
			else if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $status = L_G_WAITINGAPPROVAL;
			else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $status = L_G_SUPPRESSED;

			$str .= ";".$status;

			$payout_fields = $payout_fields_temp;
			if(is_array($payout_fields)) {
				foreach($payout_fields as $fields) {
					if(is_array($fields)) {
						foreach($fields as $field) {
							$str .= ';'.csvFormat($userInfo[$rs->fields['userid']]['Aff_payoptionfield_'.$field['payfieldid']]);
						}
					}
				}
			}


			//$str = utf2ascii($str);
			fwrite($exportFile, $str."\r\n");

			$rs->MoveNext();
		}

		fclose($exportFile);
		$this->assign('a_exportFileName', $fname);

		return true;
	}

	//--------------------------------------------------------------------------

	/** returns list of columns in list view */
	function getAvailableColumns()
	{
		$col = array(
			'userid' =>         array(L_G_AFFILIATEID, 'a.userid'),
			'refid' =>          array(L_G_REFID, 'a.refid'),
			'username' =>       array(L_G_USERNAME, 'a.username'),
			'dateinserted' =>   array(L_G_JOINED, 'a.dateinserted'),
			'name' =>           array(L_G_NAME2, 'a.surname'),
			'paid' =>           array(L_G_PAID, 'paid'),
			'pending' =>        array(L_G_PENDING, 'pending'),
			'approved' =>       array(L_G_APPROVED, 'approved'),
			'reversed' =>       array(L_G_REVERSED, 'reversed'),
			'parentuserid' =>   array(L_G_PARENT, 'a.parentuserid'),
			'rstatus' =>        array(L_G_STATUS, 'a.rstatus'),
			'company_name' =>   array(L_G_COMPANYNAME, 'a.company_name'),
			'weburl' =>         array(L_G_WEBURL, 'a.weburl'),
			'street' =>         array(L_G_STREET, 'a.street'),
			'city' =>           array(L_G_CITY, 'a.city'),
			'state' =>          array(L_G_STATE, 'a.state'),
			'country' =>        array(L_G_COUNTRY, 'a.country'),
			'zipcode' =>        array(L_G_ZIPCODE, 'a.zipcode'),
			'phone' =>          array(L_G_PHONE, 'a.phone'),
			'fax' =>            array(L_G_FAX, 'a.fax'),
			'tax_ssn' =>        array(L_G_TAXSSN, 'a.tax_ssn'),
			'payoptid' =>       array(L_G_PAYOUTMETHOD, ''),
			'ip' =>             array(L_G_IP, ''),
			'actions' =>        array(L_G_ACTIONS, ''),
		);

	    for ($i=1; $i<=5; $i++) {
			if($GLOBALS['Auth']->settings['Aff_signup_data'.$i] == '1') {
	            $col['data'.$i] = array($GLOBALS['Auth']->settings['Aff_signup_data'.$i.'_name'], 'a.data'.$i);
	        }
	    }
		return $col;
	}

	//--------------------------------------------------------------------------

	function getListViewName()
	{
		return 'aff_list';
	}

	//--------------------------------------------------------------------------

	function initViews()
	{
		// create default view
		$viewColumns = array(
			'userid',
			'dateinserted',
			'name',
			'paid',
			'pending',
			'approved',
			'reversed',
			'parentuserid',
			'rstatus',
			'actions',
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

	//--------------------------------------------------------------------------


	function createWhereOrderBy(&$orderby, &$where)
	{
	    $orderby = '';
	    $where = '';

	    $a = array(
	        'a.username',
	        'a.name',
	        'a.surname',
	        'a.dateinserted',
	        'a.userid',
	        'a.refid',
	        'a.rstatus',
	        'a.parentuserid',
	        'a.company_name',
	        'a.weburl',
	        'a.street',
	        'a.city',
	        'a.state',
	        'a.country',
	        'a.zipcode',
	        'a.phone',
	        'a.fax',
	        'a.tax_ssn',
	        'a.data1',
	        'a.data2',
	        'a.data3',
	        'a.data4',
	        'a.data5'

	    );

	    if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a)) {
	        $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
	    }
	    else {
	        $orderby = ' order by a.dateinserted desc';
	    }

	    $where = ' where a.deleted=0 '.
				 '   and a.rtype='._q(USERTYPE_USER).
	             '   and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));

	    if($_REQUEST['fromprofile'] == 1) {
	        // it is called from profile
	        $_REQUEST['um_advanced_filter_show'] = 1;
	        $_REQUEST['um_name'] = '';
	        $_REQUEST['um_surname'] = '';
	        $_REQUEST['um_username'] = '';
	        $_REQUEST['um_custom1'] = '';
	        $_REQUEST['um_custom1data'] = '';
	        $_REQUEST['um_custom2'] = '';
	        $_REQUEST['um_custom2data'] = '';
	        $_REQUEST['um_custom3'] = '';
	        $_REQUEST['um_custom3data'] = '';
	        $_REQUEST['um_aid'] = '';
	        if ($_REQUEST['umprof_status'] != '') {
	           $_REQUEST['um_status'] = array($_REQUEST['umprof_status']);
	        } else {
	           $_REQUEST['um_status'] = array(AFFSTATUS_APPROVED, AFFSTATUS_NOTAPPROVED, AFFSTATUS_SUPPRESSED);
	        }
	        $_REQUEST['um_timeselect'] = TIME_PRESET;
	        $_REQUEST['um_timepreset'] = TIME_ALL;
	        $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset(TIME_ALL, 'um_'));
	    } else {
	        //--------------------------------------
	        // try to load settings from session
	        foreach($_SESSION as $k => $v) {
	            if(strstr($k, 'um_status') !== false && ($_REQUEST['status_comitted'] == '1')) {
	                continue;
	            }
	            if(strpos($k, 'um_') === 0 && !isset($_REQUEST[$k]))
	            $_REQUEST[$k] = $v;
	        }

	        //--------------------------------------
	        // get default settings for unset variables
	        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
	        if($_REQUEST['um_status'] == '') $_REQUEST['um_status'] = '_';

	        //--------------------------------------
	        // put settings into session
	        $_SESSION['numrows'] = $_REQUEST['numrows'];
	        $_SESSION['um_name'] = $_REQUEST['um_name'];
	        $_SESSION['um_surname'] = $_REQUEST['um_surname'];
	        $_SESSION['um_aid'] = $_REQUEST['um_aid'];
	        $_SESSION['um_status'] = $_REQUEST['um_status'];
	        $_SESSION['um_username'] = $_REQUEST['um_username'];
	        $_SESSION['um_custom1'] = $_REQUEST['um_custom1'];
	        $_SESSION['um_custom1data'] = $_REQUEST['um_custom1data'];
	        $_SESSION['um_custom2'] = $_REQUEST['um_custom2'];
	        $_SESSION['um_custom2data'] = $_REQUEST['um_custom2data'];
	        $_SESSION['um_custom3'] = $_REQUEST['um_custom3'];
	        $_SESSION['um_custom3data'] = $_REQUEST['um_custom3data'];

	        // process time filter
	        if($_REQUEST['um_timeselect'] == TIME_PRESET) {
	            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['um_timepreset'], 'um_'));
	        }
	    }

	    $name = preg_replace('/[\'\"]/', '', $_REQUEST['um_name']);
	    $surname = preg_replace('/[\'\"]/', '', $_REQUEST['um_surname']);
	    $username = preg_replace('/[\'\"]/', '', $_REQUEST['um_username']);
	    $aid = preg_replace('/[\'\"]/', '', $_REQUEST['um_aid']);
	    $states = $_REQUEST['um_status'];
	    $custom1data = preg_replace('/[\'\"]/', '', $_REQUEST['um_custom1data']);
	    $custom2data = preg_replace('/[\'\"]/', '', $_REQUEST['um_custom2data']);
	    $custom3data = preg_replace('/[\'\"]/', '', $_REQUEST['um_custom3data']);

	    if($name != '') {
	        $where .= ' and (a.name like \'%'._q_noendtags($name).'%\')';
	    }
	    if($surname != '') {
	        $where .= ' and (a.surname like \'%'._q_noendtags($surname).'%\')';
	    }
	    if ($_REQUEST['um_advanced_filter_show'] != '1') {
	        return true;
	    }
	    $where .= " and (".sqlToDays('a.dateinserted')." >= ".sqlToDays($_REQUEST['um_year1']."-".$_REQUEST['um_month1']."-".$_REQUEST['um_day1']).")".
	              " and (".sqlToDays('a.dateinserted')." <= ".sqlToDays($_REQUEST['um_year2']."-".$_REQUEST['um_month2']."-".$_REQUEST['um_day2']).")";
	    if($aid != '') {
	        $where .= ' and (a.userid like \'%'._q_noendtags($aid).'%\')';
	    }
	    if(is_array($states)&& count($states)>0) {
	        $where .= " and a.rstatus in (".implode(',', $states).")";
	    } else {
	        $where .= " and a.rstatus like ''";
	    }
	    if($username != '') {
	        $where .= ' and (a.username like \'%'._q_noendtags($username).'%\')';
	    }
	    if($custom1data != '') {
	        $where .= ' and ('.$_REQUEST['um_custom1'].' like \'%'._q_noendtags($custom1data).'%\')';
	    }
	    if($custom2data != '') {
	        $where .= ' and ('.$_REQUEST['um_custom2'].' like \'%'._q_noendtags($custom2data).'%\')';
	    }
	    if($custom3data != '') {
	        $where .= ' and ('.$_REQUEST['um_custom3'].' like \'%'._q_noendtags($custom3data).'%\')';
	    }

	    return true;
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

	function printListRow($row)
	{
		$view = $this->getView();
		if($view == false || $view == null)
		{
			print '<td><font color="ff0000">no view given</fonr></td>';
			return false;
		}

		print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['userid'].'"></td>';

		foreach($view->columns as $column)
		{
			switch($column)
			{
				case 'userid': print '<td class=listresult nowrap>&nbsp;'.$row['userid'].'&nbsp;';
						showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affalldetails&aid=".$row['userid'], 300);
						print '</td>';
						break;

				case 'refid': print '<td class=listresult>&nbsp;'.$row['refid'].'&nbsp;</td>';
						break;

				case 'username': print '<td class=listresult>&nbsp;'.$row['username'].'&nbsp;</td>';
						break;

				case 'dateinserted': print '<td class=listresult nowrap>&nbsp;'.$row['joined'].'&nbsp;</td>';
						break;

				case 'name':
						//print '<td class=listresultnocenter align=left nowrap>&nbsp;<font color="#0000ff">'.$row['surname'].', '.$row['name'].'</font>&nbsp;</td>';
						print '<td class=listresultnocenter align=left nowrap>&nbsp;<font color="#0000ff">'.$row['name'].' '.$row['surname'].'</font>&nbsp;';
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
						break;

				case 'paid': print '<td class=listresultnocenter align=right nowrap>&nbsp;'.$this->blSettings->showCurrency($row['paid']).'&nbsp;</td>';
						break;

				case 'pending': print '<td class=listresultnocenter align=right nowrap>&nbsp;'.$this->blSettings->showCurrency($row['pending']).'&nbsp;</td>';
						break;

				case 'approved': print '<td class=listresultnocenter align=right nowrap>&nbsp;'.$this->blSettings->showCurrency($row['approved']).'&nbsp;</td>';
						break;

				case 'reversed': print '<td class=listresultnocenter align=right nowrap>&nbsp;'.$this->blSettings->showCurrency($row['reversed']).'&nbsp;</td>';
						break;

				case 'parentuserid': print '<td class=listresult nowrap>&nbsp;'.$row['parentuserid'].'&nbsp;</td>';
						break;

				case 'rstatus': print '<td class=listresultnocenter align=left nowrap>&nbsp;';
								if($row['rstatus_numeric'] == AFFSTATUS_NOTAPPROVED) {
									print '<img src="'.$this->getImage('sphore_pending.png').'" border=0>';
								} else if($row['rstatus_numeric'] == AFFSTATUS_APPROVED) {
									print '<img src="'.$this->getImage('sphore_active.png').'" border=0>';
								} else if($row['rstatus_numeric'] == AFFSTATUS_SUPPRESSED) {
									print '<img src="'.$this->getImage('sphore_declined.png').'" border=0>';
								}

								print '&nbsp;'.$row['rstatus'].'&nbsp;</td>';
						break;

				case 'company_name': print '<td class=listresult nowrap>&nbsp;'.$row['company_name'].'&nbsp;</td>';
						break;

				case 'weburl': print '<td class=listresult nowrap>&nbsp;'.$row['weburl'].'&nbsp;</td>';
						break;

				case 'street': print '<td class=listresult nowrap>&nbsp;'.$row['street'].'&nbsp;</td>';
						break;

				case 'city': print '<td class=listresult nowrap>&nbsp;'.$row['city'].'&nbsp;</td>';
						break;

				case 'state': print '<td class=listresult nowrap>&nbsp;'.$row['state'].'&nbsp;</td>';
						break;

				case 'country': print '<td class=listresult nowrap>&nbsp;'.$row['country'].'&nbsp;</td>';
						break;

				case 'zipcode': print '<td class=listresult nowrap>&nbsp;'.$row['zipcode'].'&nbsp;</td>';
						break;

				case 'phone': print '<td class=listresult nowrap>&nbsp;'.$row['phone'].'&nbsp;</td>';
						break;

				case 'fax': print '<td class=listresult nowrap>&nbsp;'.$row['fax'].'&nbsp;</td>';
						break;

				case 'tax_ssn': print '<td class=listresult nowrap>&nbsp;'.$row['tax_ssn'].'&nbsp;</td>';
						break;

				case 'payoptid': print '<td class=listresult nowrap>&nbsp;'.$row['payoptid'].'&nbsp;</td>';
						break;

				case 'data1': print '<td class=listresult nowrap>&nbsp;'.$row['data1'].'&nbsp;</td>';
						break;

				case 'data2': print '<td class=listresult nowrap>&nbsp;'.$row['data2'].'&nbsp;</td>';
						break;

				case 'data3': print '<td class=listresult nowrap>&nbsp;'.$row['data3'].'&nbsp;</td>';
						break;

				case 'data4': print '<td class=listresult nowrap>&nbsp;'.$row['data4'].'&nbsp;</td>';
						break;

				case 'data5': print '<td class=listresult nowrap>&nbsp;'.$row['data5'].'&nbsp;</td>';
						break;

				case 'ip': print '<td class=listresult nowrap>&nbsp;'.$row['Aff_user_ip'].'&nbsp;</td>';
						break;

				case 'actions':
						$actions = array();
						$i = 0;
						if($this->checkPermissions('view')) {
							$actions[$i++] = array('id'     => 'edit',
												   'img'    => 'icon_view.gif',
												   'desc'   => L_G_VIEWPROFILE,
												   'action' => "viewUser('".$row['userid']."');" );
						}
						if($this->checkPermissions('edit')) {
							$actions[$i++] = array('id'     => 'edit',
												   'img'    => 'icon_edit.gif',
												   'desc'   => L_G_EDIT,
												   'action' => "editUser('".$row['userid']."');" );
						}
						if($this->checkPermissions('edit')) {
							$actions[$i++] = array('id'     => 'accounting',
												   'img'    => 'icon_repair.gif',
												   'desc'   => L_G_ACCOUNTINGDETAILS,
												   'action' => "accountingDetails('".$row['userid']."');" );
						}
						if($this->checkPermissions('approve')) {
							if($row['rstatus_numeric'] != AFFSTATUS_APPROVED) {
								$actions[$i] = array('id'     => 'approve',
													 'img'    => 'icon_approve.gif',
													 'desc'   => L_G_APPROVE,
													 'action' => "ChangeState('".$row['userid']."','approve');");
							}
							if($row['rstatus_numeric'] != AFFSTATUS_SUPPRESSED) {
								$actions[$i+1] = array('id'     => 'suppress',
													   'img'    => 'icon_suppress.gif',
													   'desc'   => L_G_SUPPRESS,
													   'action' => "ChangeState('".$row['userid']."','suppress');");
							}
							if($row['rstatus_numeric'] != AFFSTATUS_NOTAPPROVED) {
								$actions[$i+2] = array('id'     => 'pending',
													   'img'    => 'icon_pending.gif',
													   'desc'   => L_G_PENDING,
													   'action' => "ChangeState('".$row['userid']."','pending');");
							}
							$i += 3;
						}
						if($this->checkPermissions('delete')) {
							$actions[$i++] = array('id'     => 'delete',
												   'img'    => 'icon_delete.gif',
												   'desc'   => L_G_DELETE,
												   'action' => "Delete('".$row['userid']."');" );
						}
                        if($this->checkPermissions('edit')) {
                            $actions[$i++] = array('id'     => 'changecommcat',
                                                   'img'    => 'icon_commissions-16x16.png',
                                                   'desc'   => L_G_CHANGECOMMCATEGORY,
                                                   'action' => "changeCommCat('".$row['userid']."');" );
                        }

						if($this->checkPermissions('add') && $GLOBALS['Auth']->getSetting('Aff_join_campaign') == 1)  {
						    $actions[$i++] = array('id'     => 'invite',
												   'img'    => 'icon_invite.gif',
												   'desc'   => L_G_INVITE,
												   'action' => "InviteIntoCampaign('".$row['userid']."');" );
						}
						$this->initTemporaryTE();
						$this->temporaryAssign('a_actions', $actions);
						$this->temporaryAssign('a_action_count', $i);
						print '<td class=listresultnocenter align="left">'.$this->temporaryFetch('actions_icon').'</td>';
						//print '<td class=listresultnocenter align="left">'.$this->temporaryFetch('actions_combo').'</td>';

						break;

				default:
						print '<td class=listresult>&nbsp;<font color="#ff0000">'.L_G_UNKNOWN.'</font>&nbsp;</td>';
						break;
			}
		}
	}


	//--------------------------------------------------------------------------


	function printMassAction()
	{
		$view = $this->getView();
		$colspan = count($view->columns)+1;
?>
<script>
function massDeleteAffiliate() {
    if(confirm("<?php echo L_G_CONFIRMMASSDELETEAFF?>")) {
        document.getElementById('massaction').value='delete';
        document.getElementById('ListForm').submit();
    }
}
</script>

      <td align=left colspan="<?php echo $colspan?>" <?php echo ($cssClass != '') ? 'class="'.$cssClass.'"' : ''?>>&nbsp;&nbsp;&nbsp;<?php echo L_G_SELECTED;?>&nbsp;

      <?php if($this->checkPermissions('approve')) { ?>
           <input type="submit" class="formbutton" value="<?php echo L_G_SUPPRESS?>"
              onclick="javascript: document.getElementById('massaction').value='suppress';">
      <?php }
         if($this->checkPermissions('approve')) { ?>
            <input type="submit" class="formbutton" value="<?php echo L_G_APPROVE?>"
              onclick="javascript:document.getElementById('massaction').value='approve'">
      <?php }
         if($this->checkPermissions('approve')) { ?>
            <input type="submit" class="formbutton" value="<?php echo L_G_PENDING?>"
              onclick="javascript:document.getElementById('massaction').value='pending'">
      <?php }
         if($this->checkPermissions('delete')) { ?>
            <input type="button" class="formbutton" value="<?php echo L_G_DELETE?>"
              onclick="javascript:massDeleteAffiliate();">
      <?php }
         if($this->checkPermissions('sendmail')) { ?>
            <input type="submit" class="formbutton" value="<?php echo L_G_SENDEMAIL?>"
              onclick="javascript:document.getElementById('massaction').value='sendmail'">
      <?php } 
         if($this->checkPermissions('add') && $GLOBALS['Auth']->getSetting('Aff_join_campaign') == 1) { ?>
            <input type="submit" class="formbutton" value="<?php echo L_G_INVITE?>"
              onclick="javascript:document.getElementById('massaction').value='invite'">
      <?php } ?>
            <input type="button" class="formbutton" value="<?php echo L_G_EXPORTTOCSV?>"
              onclick="javascript:document.getElementById('action').value='exportcsv'; document.getElementById('FilterForm').submit();">
      </td>
<?php	}

	//--------------------------------------------------------------------------

	function drawTree()
	{
		$treeData = array();
		$params = array();
		$params['rootID'] = '';
		$params['tab'] = '';
		$params['tabLevel'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$params['maxLevel'] = 20;
		$params['table_name'] = 'wd_g_users';
		$params['column_id'] = 'userid';
		$params['column_parentid'] = 'parentuserid';
		$params['getvalues'] = array('userid', 'name', 'surname', 'username','weburl', 'rstatus');
        $params['where'] = array('deleted' => '0', /*'rstatus' => AFFSTATUS_APPROVED,*/ 'rtype' => USERTYPE_USER);
        $params['order'] = array('name');

		QCore_Bl_GlobalFuncs::getTree($treeData, $params);

		$list_data = QUnit_Global::newObj('QCore_RecordSet');
		$list_data->setTemplateRS($treeData);
		$this->assign('a_list_data', $list_data);

		$this->addContent('um_tree');

		return true;
	}

	//--------------------------------------------------------------------------

	function drawSwap()
	{
		$_POST['u1'] = preg_replace('/[\'\"]/', '', $_REQUEST['u1']);

		$_POST['header'] = L_G_SWAP_USER;
		$_POST['action'] = 'swap';
		$_POST['postaction'] = 'swapuser';

		$users = $this->blAffiliate->getUsersAsArray();

		$this->assign('a_contact_user_data', $users[$_POST['u1']]['userid'].' : '.$users[$_POST['u1']]['name'].' '.$users[$_POST['u1']]['surname']);

		$list_data = QUnit_Global::newobj('QCore_RecordSet');
		$list_data->setTemplateRS($users);
		$this->assign('a_list_data', $list_data);

		$this->addContent('um_swap');

		return true;
	}

    //--------------------------------------------------------------------------

	function showAffiliateStats()
	{
	    $sql = 'select count(*) as rcount, rstatus from wd_g_users '.
	           'where rtype='._q(USERTYPE_USER).
	           '  and accountid='._q($GLOBALS['Auth']->getAccountID()).
	           '  and deleted=0'.
	           ' group by rstatus';

	    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

	    if (!$rs) // ||  || $rs->EOF
	    {
	        QUnit_Messager::setErrorMessage(L_G_DBERROR);
	        return false;
	    }

	    $approved = 0;
	    $waiting = 0;
	    $declined = 0;
	    $all = 0;

	    while(!$rs->EOF)
	    {
	        $status = $rs->fields['rstatus'];

	        if($status == AFFSTATUS_APPROVED)
	        {
	            $approved = $rs->fields['rcount'];
	        }
	        else if($status == AFFSTATUS_NOTAPPROVED)
	        {
	            $waiting = $rs->fields['rcount'];
	        }
	        else if($status == AFFSTATUS_SUPPRESSED)
	        {
	            $declined = $rs->fields['rcount'];
	        }

	        $rs->MoveNext();
	    }

	    $all = $approved + $waiting + $declined;

	    $this->assign('a_aff_all', $all);
	    $this->assign('a_aff_waiting', $waiting);

		$graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
		$labels = "<img src='".$this->getImage('sphore_active.png')."' border=0>&nbsp;<a class=textlink href='index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1&umprof_status=".AFFSTATUS_APPROVED."'>".L_G_APPROVED."</a>,";
		$labels .= "<img src='".$this->getImage('sphore_pending.png')."' border=0>&nbsp;<a class=textlink href='index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1&umprof_status=".AFFSTATUS_NOTAPPROVED."'>".L_G_WAITINGAPPROVAL."</a>,";
		$labels .= "<img src='".$this->getImage('sphore_declined.png')."' border=0>&nbsp;<a class=textlink href='index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1&umprof_status=".AFFSTATUS_SUPPRESSED."'>".L_G_SUPPRESSED."</a>";
		$graph->labels = $labels;
		$graph->values = $approved.','.$waiting.','.$declined;
		$graph->barColor = '#486B8F';
		$graph->barLength = 0.5;
		$gdata = $graph->create();

	    $this->assign('a_affstats_graph', $gdata);
	    
	    $this->addContent('um_stats');
	}
}
?>
