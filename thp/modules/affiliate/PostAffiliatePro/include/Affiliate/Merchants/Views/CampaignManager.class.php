<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');

class Affiliate_Merchants_Views_CampaignManager extends QUnit_UI_ListPage
{
	var $blCampaign;
	var $blCampaignCategories;
	var $blRules;
	var $blSettings;
	var $blAffiliate;

    //--------------------------------------------------------------------------

	function Affiliate_Merchants_Views_CampaignManager()
	{
		$this->blCampaign =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Campaign');
		$this->blCampaignCategories =& QUnit_Global::newObj('Affiliate_Merchants_Bl_CampaignCategories');
		$this->blRules =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Rules');
		$this->blSettings =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Settings');
		$this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
	}

    //--------------------------------------------------------------------------

    function initPermissions()
    {
        $this->modulePermissions['addcampaign'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['edit'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['add'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['view_banner'] = 'aff_camp_banner_links_view';
        $this->modulePermissions['delete'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['view'] = 'aff_camp_product_categories_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        $this->assign('a_form_preffix', 'f_');
        $this->assign('a_form_name', 'FilterForm');
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_CAMPAIGNS,'index.php?md=Affiliate_Merchants_Views_CampaignManager');
        
        if(!empty($_REQUEST['commited']))
        {
            switch($_REQUEST['postaction'])
            {
                case 'addcampaign':
                    $this->navigationAddURL(L_G_ADDCAMPAIGN, '');
                    if($this->processAddCampaign()) {
                        return;
                    }
                    break;

                case 'edit':
                    $this->navigationAddURL(L_G_EDITCAMPAIGN, '');
                    if($this->processEditCampaign()) {
                        if (strlen($_REQUEST['gotobanners'])) {
                            header("Location: index.php?md=Affiliate_Merchants_Views_BannerManager&filtered=1&bs_campaign=" . $_POST['cid']);
                        }
                        return;
                    }
                    break;
            }

            switch($_REQUEST['massaction'])
            {
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
                case 'add':
                    $this->navigationAddURL(L_G_ADDCAMPAIGN, '');
                    if($this->drawFormAddCampaign())
                        return;
                    break;

                case 'edit':
                    $this->navigationAddURL(L_G_EDITCAMPAIGN, '');
                    if($this->drawFormEditCampaign())
                        return;
                    break;

				case 'delete':
                    if($this->processDeleteCampaign())
                        return;
                    break;

                case 'deleteRule':
                    if($this->processDeleteRule())
                        return;
					break;
					
			    case 'moveRule':
                    if($this->processMoveRule())
                        return;
					break;

			    case 'campdetails':
			        if($this->drawCampaignDetails())
                        return;
			        break;
			    
			    case 'savedefaultcampaign': 
			        $this->processSaveDefaultCampaign();
			        break;
            }
		}

		$this->showCampaigns();
    }

    //--------------------------------------------------------------------------

    function drawCampaignDetails()
    {
        if ($_GET['cid'] == "") {
            $this->assign('a_error', L_G_NOCAMPAIGNDEFINED);
            $this->addContent('camp_details');
            return true;
        }
        $campaignID = preg_replace('/[\'\"]/', '', $_REQUEST['cid']);

        $params = array('campaignid' => $campaignID);
        if( ($campdetails = $this->blCampaign->load($params)) == false ) {
            $this->assign('a_error', L_G_DBERROR);
            $this->addContent('camp_details');
            return true;
        }
        if( ($campcatdetails = $this->blCampaignCategories->loadDefaultCommissionCategory($campaignID)) == false ) {
            $this->assign('a_error', L_G_DBERROR);
            $this->addContent('camp_details');
            return true;
        }

        $details = array_merge($campdetails, $campcatdetails);
        $details['bannercount'] = $this->blCampaign->getBannersCount(array('CampaignID' => $campaignID));

        $campaignParams = $this->getParamsAsArray();
        $details['status'] = $campaignParams[$campaignID]['Aff_camp_status'];

        $this->assign('a_campdetails', $details);

        $this->addContent('camp_details');

    	return true;
    }

    //--------------------------------------------------------------------------

    function processDeleteCampaign()
    {
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['cid']);

        if(AFF_DEMO == 1 && $CampaignID == 3)
            return false;

        $params = array('campaignid' => $CampaignID);

        $ret = $this->blCampaign->delete($params);

        return false;
    }

    //--------------------------------------------------------------------------

    function processDelete()
    {
        if(($campIDs = $this->returnCIDs()) == false)
            return false;

        if (count($campIDs) < 1)
            return false;

        foreach ($campIDs as $CampaignID) {
            if(AFF_DEMO == 1 && $CampaignID == 3)
                return false;
                
            $params = array('campaignid' => $CampaignID);
            $ret = $this->blCampaign->delete($params);
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function returnCIDs()
    {
        if($_REQUEST['massaction'] != '')
        {
            $campIDs = $_REQUEST['itemschecked'];
        }
        else
        {
            $campIDs = array($_REQUEST['cid']);
        }

        return $campIDs;
    }

    //--------------------------------------------------------------------------

    function processDeleteRule()
    {
        $RuleID = preg_replace('/[\'\"]/', '', $_POST['rid']);

        if(AFF_DEMO == 1 && $CampaignID == 3)
            return false;

        $params = array('ruleid' => $RuleID,
                        'AccountID' => $GLOBALS['Auth']->getAccountID());

        $ret = $this->blRules->deleteRule($params);

        $this->redirect('Affiliate_Merchants_Views_CampaignManager&action=edit&campaign_tab_sheet=performance_rules&cid='.$_POST['cid']);

        return false;
    }
    
	//--------------------------------------------------------------------------

    function processMoveRule()
    {
        $RuleID = preg_replace('/[\'\"]/', '', $_POST['rid']);
        $CampaignID = preg_replace('/[\'\"]/', '', $_POST['cid']);
        $Direction = preg_replace('/[\'\"]/', '', $_POST['direction']);

        if(AFF_DEMO == 1 && $CampaignID == 3)
            return false;
        
        $params = array('RuleId' => $RuleID,
                        'CampaignID' => $CampaignID,
                        'direction' => $Direction,
                        'AccountID' => $GLOBALS['Auth']->getAccountID());

        $ret = $this->blRules->moveRule($params);

        $this->redirect('Affiliate_Merchants_Views_CampaignManager&action=edit&campaign_tab_sheet=performance_rules&cid='.$_POST['cid']);

        return false;
    }

	//------------------------------------------------------------------------

    function protectData()
    {

        // protect against script injection
        $data = array();

        $data['cname'] = preg_replace('/[\'\"]/', '', $_POST['cname']);
		$data['banner_url'] = preg_replace('/[\'\"]/', '', $_POST['banner_url']);
        $data['description'] = preg_replace('/[\'\"]/', '', $_POST['description']);
        $data['commtype'] = preg_replace('/[\'\"]/', '', $_POST['commtype']);
        $data['commtype2'] = preg_replace('/[\'\"]/', '', $_POST['commtype2']);
        $data['sheet'] = preg_replace('/[\'\"]/', '', $_POST['sheet']);
        $data['cid'] = preg_replace('/[\'\"]/', '', $_POST['cid']);
		$data['cookielifetime'] = preg_replace('/[^0-9]/', '', $_POST['cookielifetime']);
		$data['clickapproval'] = preg_replace('/[^0-9]/', '', $_POST['clickapproval']);
        $data['saleapproval'] = preg_replace('/[^0-9]/', '', $_POST['saleapproval']);
        $data['affapproval'] = preg_replace('/[^0-9]/', '', $_POST['affapproval']);
        $data['status'] = preg_replace('/[^0-9]/', '', $_POST['status']);
        $data['signup_bonus'] = preg_replace('/[\'\"]/', '', $_POST['signup_bonus']);
        $data['products'] = preg_replace('/[\'\"]/', '', $_POST['products']);
        $data['banner_url'] = preg_replace('/[\'\"]/', '', $_POST['banner_url']);
        $data['shortdescription'] = preg_replace('/[\'\"]/', '', $_POST['shortdescription']);
        $data['description'] = preg_replace('/[\'\"]/', '', $_POST['description']);
        $data['cond_action'] = preg_replace('/[\'\"]/', '', $_POST['cond_action']);
        $data['cond_action_value'] = preg_replace('/[\'\"]/', '', $_POST['cond_action_value']);
        $data['cond_when'] = preg_replace('/[^0-9]/', '', $_POST['cond_when']);
        $data['cond_in'] = preg_replace('/[^0-9]/', '', $_POST['cond_in']);
        $data['cond_is'] = preg_replace('/[^0-9]/', '', $_POST['cond_is']);
        $data['cond_is_type'] = preg_replace('/[^0-9]/', '', $_POST['cond_is_type']);
        $data['cond_value1'] = preg_replace('/[\'\"]/', '', $_POST['cond_value1']);
        $data['cond_value2'] = preg_replace('/[\'\"]/', '', $_POST['cond_value2']);
        $data['cond_value3'] = preg_replace('/[\'\"]/', '', $_POST['cond_value3']);
        $data['ruleid'] = preg_replace('/[\'\"]/', '', $_POST['rid']);
        $data['editrid'] = preg_replace('/[\'\"]/', '', $_POST['editrid']);
        $data['sheet'] = preg_replace('/[\'\"]/', '', $_POST['sheet']);
        $data['catname'] = preg_replace('/[\'\"]/', '', $_POST['catname']);
        $data['network_categories'] = preg_replace('/[\'\"]/', '', $_POST['network_categories']);

        return $data;
    }

    //--------------------------------------------------------------------------

    function processCampaign($data)
    {
        // check correctness of the fields
        checkCorrectness($_POST['cname'], $data['cname'], L_G_PCNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['banner_url'], $data['banner_url'], L_G_COMPLETE_URL_BANNERS_IMAGE, CHECK_ALLOWED);
        checkCorrectness($_POST['shortdescription'], $data['shortdescription'], L_G_DESCRIPTION, CHECK_ALLOWED);
        checkCorrectness($_POST['description'], $data['description'], L_G_DESCRIPTION, CHECK_ALLOWED);

        if(!preg_match('/^[a-zA-Z0-9\-_\;]*$/', $data['products'])) {
            QUnit_Messager::setErrorMessage(L_G_PRODUCTSINCORRECTFORMAT);
        }

        if ($data['cname'] != '' && $this->checkCampaignExists($data['cname'], $data['cid'])) {
            QUnit_Messager::setErrorMessage(L_G_CNAMEEXISTS);
        }

        if (!is_array($data['commtype']) || count($data['commtype']) < 1 ) {
            QUnit_Messager::setErrorMessage(L_G_COMMISSIONTYPEMUSTBECHOSEN);
        } else {
            $data['commtype'] = $this->convertCommtypeToArray2($data['commtype'], $data['commtype2']);
        }

        if(QUnit_Messager::getErrorMessage() == '') {
            return array(
                            'cname' => $data['cname'],
							'commtype' => $data['commtype'],
                            'campaignid' => $data['cid'],
                            'shortdescription' => $data['shortdescription'],
                            'description' => $data['description'],
                            'banner_url' => $data['banner_url'],
                            'products' => $data['products'],
                        );
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function convertCommtypeToArray2($oldcommtype, $commtype2)
    {
        $commtype = 0;
        foreach($oldcommtype as $ct)
        {
            if($ct != '_')
            {
                $commtype |= $ct;
            }
            else
            {
                $commtype |= $commtype2;
            }
        }

        return $commtype;
    }

    //--------------------------------------------------------------------------

    function processEditCampaignCommissions($data)
    {
        $_POST['catid'] = $this->blCampaignCategories->getDefaultCategoryID($data['cid']);
        if($_POST['catname'] == '')
            $_POST['catname'] = UNASSIGNED_USERS;

        return $this->blCampaignCategories->protectVars();
    }

    //--------------------------------------------------------------------------

    function processEditCampaignSpecialCommissions()
    {
        return true;
    }

    //--------------------------------------------------------------------------

    function processEditCampaignSettings($data)
	{
	    // check correctness of the fields
        checkCorrectness($_POST['cookielifetime'], $data['cookielifetime'], L_G_COOKIELIFETIME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['clickapproval'], $data['clickapproval'], L_G_TRANSCLICKAPPROVAL, CHECK_EMPTYALLOWED, CHECK_INARRAY, array(APPROVE_AUTOMATIC, APPROVE_MANUAL));
        checkCorrectness($_POST['saleapproval'], $data['saleapproval'], L_G_TRANSSALEAPPROVAL, CHECK_EMPTYALLOWED, CHECK_INARRAY, array(APPROVE_AUTOMATIC, APPROVE_MANUAL));

        $settings = QCore_Settings::_getSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountId());
	    $defaultCampaign = $settings['Aff_default_campaign'];
	    
        if ($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1' && $defaultCampaign == $data['cid'] && $data['status'] != AFF_CAMP_PUBLIC) {
            QUnit_Messager::setErrorMessage(L_G_DEFAULTCAMPAIGNMUSTBEPUBLIC);
            return false;
        }
        
        if ($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1') {
            checkCorrectness($_POST['affapproval'], $data['affapproval'], L_G_AFFILIATE_APPROVAL, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['status'], $data['status'], L_G_STATUS, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['signup_bonus'], $data['signup_bonus'], L_G_SIGNUP_BONUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        } else {
            $data['status'] = AFF_CAMP_PUBLIC;
            $data['affapproval'] = APPROVE_AUTOMATIC;
            $data['signup_bonus'] = 0;
        }

        if (QUnit_Messager::getErrorMessage() == '') {
            $params = array(
                            'cid' => $data['cid'],
                            'cookielifetime' => $data['cookielifetime'],
                            'clickapproval' => $data['clickapproval'],
                            'saleapproval' => $data['saleapproval'],
                            'affapproval' => $data['affapproval'],
                            'status' => $data['status'],
                            'signup_bonus' => $data['signup_bonus']
                           );
            return $params;
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function processEditCampaignPerformanceRules($data)
    {
        // check correctness of the fields
        checkCorrectness($_POST['cond_action'], $data['cond_action'], L_G_ACTION, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['cond_action_value'], $data['cond_action_value'], L_G_ACTION.' '.L_G_VALUE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['cond_when'], $data['cond_when'], L_G_WHEN, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['cond_in'], $data['cond_in'], L_G_IN.' '.L_G_VALUE, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['cond_is'], $data['cond_is'], L_G_IS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        if($_POST['cond_value1'] == '' && $_POST['cond_value2'] == '' && $_POST['cond_value3'] == '')
            return false;
        if($data['cond_is_type'] == RULE_IS_BETWEEN) {
            checkCorrectness($_POST['cond_value2'], $data['cond_value2'], L_G_VALUE, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['cond_value3'], $data['cond_value3'], L_G_VALUE, CHECK_EMPTYALLOWED);
        }
        else
        {
          checkCorrectness($_POST['cond_value1'], $data['cond_value1'], L_G_VALUE, CHECK_EMPTYALLOWED);
          $data['cond_value2'] = '';
        }

        if(QUnit_Messager::getErrorMessage() == '')
        {
            if($data['cond_is_type'] == RULE_IS_BETWEEN)
            {
                if($data['cond_value2'] > $data['cond_value3'])
                {
                  $data['cond_value1'] = $data['cond_value3'];
				}
                else
                {
                    $data['cond_value1'] = $data['cond_value2'];
                    $data['cond_value2'] = $data['cond_value3'];
                }
            }

			return array('cond_action' => $data['cond_action'],
                         'cond_action_value' => $data['cond_action_value'],
                         'cond_when' => $data['cond_when'],
                         'cond_in' => $data['cond_in'],
                         'cond_is' => $data['cond_is'],
                         'cond_is_type' => $data['cond_is_type'],
                         'cond_value1' => $data['cond_value1'],
                         'cond_value2' => $data['cond_value2'],
                         'ruleid' => $data['ruleid'],
                         'AccountID' => $GLOBALS['Auth']->getAccountID()
                        );
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function processEditCampaignNetworkCategories($data)
    {
        checkCorrectness($_POST['network_categories'], $data['network_categories'], L_G_PUT_CAMPAIGN_INTO_CATEGORY, CHECK_EMPTYALLOWED);

        if($_POST['network_categories'] == '-1')
            return true;

        if(is_array($_POST['network_categories']) && count($_POST['network_categories']) > $GLOBALS['Auth']->getSetting('Glob_max_merchant_categories'))
            QUnit_Messager::setErrorMessage(L_G_CATEGORIES_SELECTED_MORE_THAN_ALLOWED);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            $params = array(
                            'cid' => $data['cid'],
                            'network_categories' => $data['network_categories']
                           );

            return $params;
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function processCommtypeFromForm()
    {
        $ctArr = array();

        foreach($_POST['commtype'] as $commtype)
        {
            if($commtype != '_')
                $ctArr[] = $commtype;
            else
                $ctArr[] = $_POSt['commtype2'];
		}

        return $ctArr;
    }

    //--------------------------------------------------------------------------

    function processAddCampaign()
	{
        $data = $this->protectData();

        $campaignProcessedData = $this->processCampaign($data);
		$campaignCommissions = $this->processEditCampaignCommissions($data);
        $processedData = $this->processEditCampaignSettings($data);

        if (QUnit_Messager::getErrorMessage() == '') {
            $CampaignID = QCore_Sql_DBUnit::createUniqueID('wd_pa_campaigns', 'campaignid');
            $AffCategoryID = QCore_Sql_DBUnit::createUniqueID('wd_pa_campaigncategories', 'campcategoryid');

            $params = array_merge($processedData, $campaignProcessedData);
            $params['campaignid'] = $CampaignID;
            $params['affcategoryid'] = $AffCategoryID;

            $ret = $this->blCampaign->insert($params);

            if($campaignCommissions && $ret) {
                $campaignCommissions['CampaignID'] = $CampaignID;
                $campaignCommissions['CategoryID'] = $AffCategoryID;

                $ret = $this->blCampaignCategories->updateCategory($campaignCommissions);
            }

            if(!$ret) return false;

            QUnit_Messager::setOkMessage(L_G_CAMPAIGNADDED);

            $this->showCampaigns();

            return true;
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function processEditCampaign()
    {
        $data = $this->protectData();

        $campaignProcessedData = $this->processCampaign($data);
        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK) {
            $networkCategories = $this->processEditCampaignNetworkCategories($data);
        }

        $campaignCommission = false;
		$processedData = array();

//        switch($_POST['subact'])
//        {
//            case 'commissions': $campaignCommissions = $this->processEditCampaignCommissions($data); break;
//            case 'specialcommissions': $processedData = $this->processEditCampaignSpecialCommissions($data); break;
//            case 'campsettings': $processedData = $this->processEditCampaignSettings($data); break;
//            case 'performance_rules': $campaignRule = $this->processEditCampaignPerformanceRules($data); break;
//        }

        $campaignCommissions = $this->processEditCampaignCommissions($data);
        //$processedData = $this->processEditCampaignSpecialCommissions($data);
        $processedData = $this->processEditCampaignSettings($data);
        if ($_REQUEST['saveRule'] == '1') {
            $campaignRule = $this->processEditCampaignPerformanceRules($data);
        }

        if (!$processedData || !$campaignProcessedData || QUnit_Messager::getErrorMessage() != '') {
            if(QUnit_Messager::getErrorMessage() == '') {
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVECAMPAIGN);
            }
            // stay in the same page
            //$_REQUEST['sheet'] = $_POST['subact'];
            $this->drawFormEditCampaign();
        } else {
            // save change
            $ret = $this->blCampaign->updateCampaign($campaignProcessedData);

            if ($campaignCommissions != false) {
                // save commissions
                $ret = $this->blCampaignCategories->updateCategory($campaignCommissions);
            }

            if (is_array($processedData) && $ret) {
                $ret = $this->blCampaign->updateSettings($processedData);
            }

            if (is_array($campaignRule) && $ret) {
                $ret = $this->blRules->updateRule($campaignRule);
            }

            if ($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK && is_array($networkCategories) && $ret) {
                $objNetworkCateg =& QUnit_Global::newObj('Affiliate_Merchants_Bl_NetworkCategories');
                $ret = $objNetworkCateg->saveCategories($networkCategories);
            }

            if (!$ret) {
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);
            } else {
                QUnit_Messager::setOkMessage(L_G_SETTINGSSAVED);
            }

            $GLOBALS['Auth']->loadSettings();

            if ($data['psheet'] != '') {
                $_REQUEST['sheet'] = $data['psheet'];
            }

            $this->drawFormEditCampaign();
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function loadCampaignInfo()
    {
        $campaignid = preg_replace('/[\'\"]/', '', $_REQUEST['cid']);

        $params['campaignid'] = $campaignid;

        $data = $this->blCampaign->load($params);

        if(!$data) return false;

        $_POST['cid'] = $data['campaignid'];
        $_POST['cname'] = $data['name'];

        $this->convertCommtypeToArray($data['commtype']);

        $_POST['products'] = $data['products'];
        $_POST['description'] = $data['description'];
        $_POST['shortdescription'] = $data['shortdescription'];

        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK)
        {
			$network_categories = array();
            $params = array();
            $params['rootID'] = '';
            $params['tab'] = '';
            $params['tabLevel'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $params['maxLevel'] = 20;
            $params['table_name'] = 'wd_g_categories';
            $params['column_id'] = 'catid';
			$params['column_parentid'] = 'parentcatid';
            $params['getvalues'] = array('catid', 'name');
            $params['where'] = array('deleted' => '0', 'rstatus' => STATUS_ENABLED);
            $params['order'] = array('name');

            QCore_Bl_GlobalFuncs::getTree($network_categories, $params);
            $list_data = QUnit_Global::newObj('QCore_RecordSet');
            $list_data->setTemplateRS($network_categories);
            $this->assign('a_list_data', $list_data);

            $this->assign('a_numrows', count($network_categories));

            $params = array('CampaignID' => $_POST['cid']);

            $objNetworkCateg =& QUnit_Global::newObj('Affiliate_Merchants_Bl_NetworkCategories');
            $network_categories_selected = $objNetworkCateg->getCampaignCategories2Simple($params);
            $this->assign('a_network_categories_selected', (is_array($network_categories_selected[$_POST['cid']]) ? $network_categories_selected[$_POST['cid']] : array()));
        }

        $params['campaignid'] = $campaignid;
        $data = $this->blSettings->getCampaignInfo($params);

        $_POST['cookielifetime'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'cookielifetime'];
        $_POST['clickapproval'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'clickapproval'];
        $_POST['saleapproval'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'saleapproval'];
        $_POST['affapproval'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'affapproval'];
        $_POST['status'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'status'];
        $_POST['signup_bonus'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'signup_bonus'];
        $_POST['banner_url'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'banner_url'];

        // load settings of first commission category ('unassigned users')
        $data = $this->blCampaignCategories->loadDefaultCommissionCategory($campaignid);

        if(is_array($data) && count($data) > 0)
            foreach($data as $k => $v)
                $_POST[$k] = $v;

        return true;
    }

    //--------------------------------------------------------------------------

    function convertCommtypeToArray($rsCommType)
    {
        $allowedTypes = $GLOBALS['Auth']->getAllowedCommissionTypes();
        $commtype = array();

        $_POST['commtype'] = array();
        foreach($allowedTypes as $commType)
        {
            if((int)$commType & (int)$rsCommType)
            {
                if($commType == TRANSTYPE_LEAD || $commType == TRANSTYPE_SALE)
				{
                    $_POST['commtype'][] = '_';
                    $_POST['commtype2'] = $commType;
                }

                $_POST['commtype'][] = $commType;
            }
        }
	}

    //--------------------------------------------------------------------------

    function drawFormEditCampaign()
    {
        if($_REQUEST['campaign_tab_sheet'] == '')
            $_REQUEST['campaign_tab_sheet'] = 'commissions';

        if($_POST['commited'] != 'yes')
        {
            if(!$this->loadCampaignInfo())
                return false;
        }

        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'edit';

        $tabs = array(
            array('id'      => 'commissions',
                  'caption' => L_G_COMMISSIONS,
                  'content' => $this->drawFormEditCampaignCommissions(),
                  'icon' => 'icon_commissions.gif',
                  'description' => L_G_COMMISSIONS_DESCRIPTION),
            array('id' => 'specialcommissions',
                  'caption' => L_G_SPECIAL_COMMISSIONS,
                  'icon' => 'icon_comm_special.gif',
                  'content' => $this->drawFormEditCampaignSpecialCommissions(),
                  'description' => L_G_SPECIAL_COMMISSIONS_DESCRIPTION),
            array('id' => 'campsettings',
                  'caption' => L_G_CAMPSETTINGS,
                  'icon' => 'icon_settings.gif',
                  'content' => $this->drawFormEditCampaignAffSettings(),
                  'description' => L_G_CAMPSETTINGS_DESCRIPTION),
            array('id' => 'performance_rules',
                  'caption' => L_G_PERFORMANCE_RULES,
                  'icon' => 'icon_perfrules.gif',
                  'content' => $this->drawFormEditCampaignPerformanceRules(),
                  'description' => L_G_PERFORMANCE_RULES_DESCRIPTION)
        );

        $selectedTab = $_REQUEST['sheet'];

        $this->assign('a_tabs', $tabs);
        $this->assign('a_selectedTab', $selectedTab);

//        switch($_REQUEST['sheet'])
//        {
//            case 'commissions': return $this->drawFormEditCampaignCommissions();
//            case 'specialcommissions': return $this->drawFormEditCampaignSpecialCommissions();
//            case 'campsettings': return $this->drawFormEditCampaignAffSettings();
//            case 'performance_rules': return $this->drawFormEditCampaignPerformanceRules();
//        }
        $this->addContent('campaigns');
        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormEditCampaignCommissions()
    {
        $_POST['header'] = L_G_COMMISSIONS;

        // fetch template of sub section
        $this->initTemporaryTE();
        $content = $this->temporaryFetch('commissions');

        //$this->assign('a_tabcontent', $content);
        //$this->addContent('campaigns');

        return $content;
	}

    //--------------------------------------------------------------------------

    function drawFormEditCampaignSpecialCommissions()
    {
        $_POST['header'] = L_G_SPECIAL_COMMISSIONS;

		$objCategManager = QUnit_Global::newobj('Affiliate_Merchants_Views_CampCategoriesManager');
        $objCategManager->init();
        $objCategManager->showCategories($_POST['cid']);

        $content = $objCategManager->temp_content;
        // $this->assign('a_tabcontent', $content);
        // $this->clearTempContent();
        // $this->addContent('campaigns');

        return $content;
    }

    //--------------------------------------------------------------------------

    function drawFormEditCampaignAffSettings()
    {
        // fetch template of sub section
        $this->initTemporaryTE();
        $content = $this->temporaryFetch('camp_campsettings');

        //$this->assign('a_tabcontent', $content);

        $_POST['header'] = L_G_AFFSETTINGS;

        //$this->addContent('campaigns');

        return $content;
    }

    //--------------------------------------------------------------------------

    function drawFormEditCampaignPerformanceRules()
    {
        // fetch template of sub section
        $this->initTemporaryTE();

        $params = array('AccountID' => $GLOBALS['Auth']->getAccountID(),
                        'CampaignID' => $_POST['cid'],
                        'ruleid' => ($_POST['editrid'] != '' ? $_POST['editrid'] : $_POST['rid'])
                       );

        $this->blRules->loadRuleToPost($params);

        $camp_params = array('AccountID' => $GLOBALS['Auth']->getAccountID(),
                             'CampaignID' => $_POST['cid']
                            );

        $objCategManager = QUnit_Global::newobj('Affiliate_Merchants_Views_CampCategoriesManager');
        $special_campaigns = $objCategManager->getCampCategoriesForRulesAsArray($camp_params);
		$this->temporaryAssign('a_campaigns', $special_campaigns);

        $params = array('AccountID' => $GLOBALS['Auth']->getAccountID(),
                        'CampaignID' => $_POST['cid']
					   );

        $rules = $this->blRules->getRulesAsArray($params);

        if($rules === false) $rules = array();

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rules);
		$this->temporaryAssign('a_list_data', $list_data);

        $this->temporaryAssign('a_numrows', count($rules));

        $content = $this->temporaryFetch('cm_performance_rules');

        //$this->assign('a_tabcontent', $content);

        $_POST['header'] = L_G_PERFORMANCE_RULES;

        //$this->addContent('campaigns');

        return $content;
    }

    //--------------------------------------------------------------------------

    function drawFormAddCampaign()
    {
        if(!isset($_POST['action']))
        $_POST['action'] = 'add';

        $_POST['postaction'] = 'addcampaign';

        if(!isset($_POST['header']))
            $_POST['header'] = L_G_ADDCAMPAIGN;

        if(!isset($_POST['cookielifetime']))
            $_POST['cookielifetime'] = '0';

        if(!isset($_POST['signup_bonus']))
        	$_POST['signup_bonus'] = '0';

        /* tabbbbbs */

        $_REQUEST['campaign_tab_sheet'] = 'commissions';

        $tabs = array(
            array('id'      => 'commissions',
                  'caption' => L_G_COMMISSIONS,
                  'content' => $this->drawFormEditCampaignCommissions(),
                  'description' => L_G_COMMISSIONS_DESCRIPTION),
            array('id' => 'campsettings',
                  'caption' => L_G_CAMPSETTINGS,
                  'content' => $this->drawFormEditCampaignAffSettings(),
                  'description' => L_G_CAMPSETTINGS_DESCRIPTION)
        );

        $this->assign('a_tabs', $tabs);

        $this->addContent('campaigns');

        return true;
	}

	//--------------------------------------------------------------------------
	
	function processSaveDefaultCampaign() {
	    QCore_Settings::_update('Aff_default_campaign', $_REQUEST['default_campaign'], SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountId());
	    QUnit_Messager::setOkMessage(L_G_DEFAULTCAMPAIGNASVED);
	}
	
	//--------------------------------------------------------------------------

	function showCampaigns()
	{
        $settings = QCore_Settings::_getSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountId());
        $_REQUEST['default_campaign'] = $settings['Aff_default_campaign'];
	    
		$orderby = '';
		$a = array("name", "dateinserted", "commtype", "weburl", "campaignid");

		if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
		{
			$orderby = "order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
		}
		else
		{
			$orderby = "order by dateinserted desc";
		}

		$where = "where deleted=0 and accountid="._q($GLOBALS['Auth']->getAccountID());

		$_REQUEST['f_cname'] = preg_replace('/[\'\"]/', '', $_REQUEST['f_cname']);
		$_REQUEST['f_weburl'] = preg_replace('/[\'\"]/', '', $_REQUEST['f_weburl']);

		if($_REQUEST['f_cname'] != '')
		{
			$where .= " and (name like '%"._q_noendtags($_REQUEST['f_cname'])."%')";
		}
		if($_REQUEST['f_weburl'] != '')
		{
			$where .= " and (weburl like '%"._q_noendtags($_REQUEST['f_weburl'])."%')";
		}

		//--------------------------------------
        // clear checkboxes
        if (!isset($_REQUEST['f_transtype'])) $_REQUEST['f_transtype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();

        $transTypes = $_REQUEST['f_transtype'];

    	if(is_array($transTypes) && count($transTypes) > 0)
		{
		    $where .= " and (0 ";
			foreach($transTypes as $ctype) {
				$where .= "or commtype & ".$ctype." != 0 ";
			}
			$where .= ")";
		} else {
		    $where .= " and 0 ";
		}

		$sql = "select count(*) as count from wd_pa_campaigns ";
		$rs = QCore_Sql_DBUnit::execute($sql." ".$where, __FILE__, __LINE__);
		if(!$rs) {
			QUnit_Messager::setErrorMessage(L_G_DBERROR);
			return;
		}

        $limitOffset = initPaging($rs->fields[count]);

        $sql = "select * from wd_pa_campaigns ";
		$rs = QCore_Sql_DBUnit::selectLimit($sql." ".$where." ".$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
		if(!$rs) {
			QUnit_Messager::setErrorMessage(L_G_DBERROR);
			return;
		}

		$campaigns = $this->getCampaignsAsArray();
		$affiliates = $this->blAffiliate->getUsersAsArray();

		$list_data1 = QUnit_Global::newobj('QCore_RecordSet');
		$list_data1->setTemplateRS($campaigns);
		$this->assign('a_list_data1', $list_data1);

		//$this->addContent('cm_filter');

		$data = array();
		//$objBannerManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_BannerManager');
		$objBannerManager =& QUnit_Global::newObj('Affiliate_Affiliates_Views_AffBannerManager');
		$bannercount = $objBannerManager->getCountBannersAsArray();
		$campaignCommissions = $this->getCommissionsAsArray();
		$campaignParams = $this->getParamsAsArray();

		while(!$rs->EOF)
		{
			if($f_ctype_for_list != '' && !((int)$f_ctype_for_list & (int)$rs->fields['commtype']))
			{
				$rs->MoveNext();
				continue;
			}

			$temp = array();
			$temp['campaignid'] = $rs->fields['campaignid'];
			$temp['name'] = $rs->fields['name'];
			$temp['dateinserted'] = $rs->fields['dateinserted'];
			$temp['commtype'] = $rs->fields['commtype'];
			$temp['commtype2'] = $rs->fields['commtype'];

			$temp['userid'] = $rs->fields['campaignid '];
			$temp['cpmcommission'] = $campaignCommissions[$rs->fields['campaignid']]['cpmcommission'];
			$temp['clickcommission'] = $campaignCommissions[$rs->fields['campaignid']]['clickcommission'];
			$temp['salecommission'] = $campaignCommissions[$rs->fields['campaignid']]['salecommission'];
			$temp['salecommtype'] = $campaignCommissions[$rs->fields['campaignid']]['salecommtype'];
			$temp['recurringcommission'] = $campaignCommissions[$rs->fields['campaignid']]['recurringcommission'];
			$temp['recurringcommtype'] = $campaignCommissions[$rs->fields['campaignid']]['recurringcommtype'];
			$temp['recurringdatetype'] = $campaignCommissions[$rs->fields['campaignid']]['recurringdatetype'];
			$temp['status'] = $campaignParams[$rs->fields['campaignid']]['Aff_camp_status'];

			$temp['bannercount'] = ($bannercount[$rs->fields['campaignid']] != '' ? $bannercount[$rs->fields['campaignid']] : '0');
			$data[] = $temp;

			$rs->MoveNext();
		}

		$list_data = QUnit_Global::newobj('QCore_RecordSet');
		$list_data->setTemplateRS($data);

		$this->assign('a_list_data', $list_data);
		$this->assign('a_numrows', count($data));

		$temp_perm['add'] = $this->checkPermissions('add');
		$temp_perm['view_banner'] = $this->checkPermissions('view_banner');
		$temp_perm['edit'] = $this->checkPermissions('edit');
		$temp_perm['delete'] = $this->checkPermissions('delete');

		$this->assign('a_action_permission', $temp_perm);
		
		$this->assign('a_campaigns', $data);
		
		$this->initViews();
		$this->pageLimitsAssign();
		$this->addContent('cm_list');
	}


	//--------------------------------------------------------------------------

	function initViews()
	{
		// create default view
		$viewColumns = array(
			'campaignid',
			'name',
			'dateinserted',
			'commtype',
			'commtype2',
			'banners',
		);
        if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1') {
            $viewColumns[] = 'status';
        }

        $viewColumns[] = 'actions';

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

	function getListViewName()
	{
		return 'camp_list';
	}

	//--------------------------------------------------------------------------

	/** returns list of columns in list view */
	function getAvailableColumns()
	{
		$col = array(
			'campaignid' =>     array(L_G_ID, 'campaignid'),
			'name' =>          	array(L_G_CAMPAIGNNAME, 'name'),
			'dateinserted' =>	array(L_G_CREATED, 'dateinserted'),
			'commtype' =>   	array(L_G_CAMPAIGNTYPE, 'commtype'),
			'commtype2' =>      array(L_G_COMMISSIONS),
			'banners' =>        array(L_G_BANNERS),
		);

        if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1') {
            $col['status'] =       array(L_G_STATUS, '');
        }

        $col['actions'] =       array(L_G_ACTIONS, '');

		for ($i=1; $i<=5; $i++) {
			if($GLOBALS['Auth']->settings['Aff_signup_data'.$i] == '1') {
				$col['data'.$i] = array($GLOBALS['Auth']->settings['Aff_signup_data'.$i.'_name'], 'a.data'.$i);
			}
		}
		return $col;
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

		print "<tr name=\"row_".$row['campaignid']."\" id=\"row_".$row['campaignid']."\" class=listresult ".
                "onMouseover=\"this.className = (this.className == 'listresultSelected' ? 'listresultSelected' : 'listresultMouseOver');".
                              "var row = document.getElementById('row_".$row['campaignid']."');".
                              "row.className = (row.className == 'listresultSelected' ? 'listresultSelected' : 'listresultMouseOver');\"".
                "onMouseOut =\"this.className = (this.className == 'listresultSelected' ? 'listresultSelected' : 'listresult');".
                              "var row = document.getElementById('row_".$row['campaignid']."');".
                              "row.className = (row.className == 'listresultSelected' ? 'listresultSelected' : 'listresult');\">";

        print '<td valign=top class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['campaignid'].'"
                   onclick="javascript: document.getElementById(\'tr_'.$row['campaignid'].'\').className= (this.checked ? \'listresultSelected\' : \'listresult\');'.
                                       'document.getElementById(\'row_'.$row['campaignid'].'\').className= (this.checked ? \'listresultSelected\' : \'listresult\')"></td>';


		foreach($view->columns as $column)
		{
			switch($column)
			{

				case 'campaignid': print '<td class=listresult valign=top>&nbsp;'. $row['campaignid'].'&nbsp;</td>';
						break;

				case 'dateinserted': print '<td class=listresult nowrap valign=top>&nbsp;'.$row['dateinserted'].'&nbsp;</td>';
						break;
				case 'commtype': print '<td class=listresult nowrap valign=top>&nbsp;' . $GLOBALS['Auth']->getComposedCommissionTypeString($row['commtype']) .'&nbsp;</td>';
						break;
				case 'banners': print '<td class=listresult nowrap valign=top>&nbsp;'. $row['bannercount'] . '&nbsp;</td>';
						break;
				case 'name':
						print '<td class=listresultnocenter align=left nowrap valign=top>&nbsp;'.$row['name'].'&nbsp;</td>';
						break;

				case 'commtype2': print '<td class=listresultnocenter align=left nowrap valign=top>'. $this->getCommissionField($row) .'&nbsp;</td>';
						break;

				case 'status':
						print '<td class=listresultnocenter align=left nowrap valign=top>&nbsp;'.($row['status'] == AFF_CAMP_PUBLIC ? L_G_PUBLIC : L_G_PRIVATE).'&nbsp;</td>';
						break;

				case 'actions':
						$actions = array();
						$i = 0;
						if($this->checkPermissions('edit')) {
							$actions[$i++] = array('id'     => 'edit',
												   'img'    => 'icon_edit.gif',
												   'desc'   => L_G_EDIT,
												   'action' => "editCampaign('".$row['campaignid']."');" );
						}
						if($this->checkPermissions('view')) {
							$actions[$i++] = array('id'     => 'view',
												   'img'    => 'icon_view.gif',
												   'desc'   => L_G_VIEWBANNERS,
												   'action' => "viewBanners('".$row['campaignid']."');" );
						}
						if($this->checkPermissions('delete')) {
							$actions[$i++] = array('id'     => 'delete',
												   'img'    => 'icon_delete.gif',
												   'desc'   => L_G_DELETE,
												   'action' => "Delete('".$row['campaignid']."');" );
						}
						$this->initTemporaryTE();
						$this->temporaryAssign('a_actions', $actions);
						$this->temporaryAssign('a_action_count', $i);
						print '<td class=listresultnocenter align="left" valign=top>'.$this->temporaryFetch('actions_icon').'</td>';
						//print '<td class=listresultnocenter align="left">'.$this->temporaryFetch('actions_combo').'</td>';

						break;

				default:
						print '<td class=listresult>&nbsp;<font color="#ff0000">'.L_G_UNKNOWN.'</font>&nbsp;</td>';
						break;
			}
		}
	}


	//--------------------------------------------------------------------------

	function checkCampaignExists($name, $cid = '')
	{
		$sql = 'select * from wd_pa_campaigns '.
		'where deleted=0 and name='._q($name).
		'  and accountid='._q($GLOBALS['Auth']->getAccountID());
        if($cid != '') $sql .= ' and campaignid<>'._q($cid);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

		if($rs->EOF) return false;

        return true;
    }

    //--------------------------------------------------------------------------

    function campaignExists($camid)
	{
        $pcamid = preg_replace('/[\'\"]/', '', $camid);

        $sql = 'select * from wd_pa_campaigns '.
        'where deleted=0 and campaignid='._q($pcamid).
        '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF)
        return false;

        return true;
    }

    //--------------------------------------------------------------------------

    function getCampaignsAsArray()
    {
        $sql = 'select * from wd_pa_campaigns c where c.deleted=0 and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $camps = array();

        while(!$rs->EOF)
        {
            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['name'] = $rs->fields['name'];
            $temp['commtype'] = $rs->fields['commtype'];
            $camps[$rs->fields['campaignid']] = $temp;

            $rs->MoveNext();
        }

        return $camps;
    }

    //--------------------------------------------------------------------------

    function getCampaignInfo($campcategoryid)
    {
		$sql = 'select c.campaignid, c.name, c.commtype'.
        	   ' from wd_pa_campaigncategories cc, wd_pa_campaigns c'.
        	   ' where cc.campcategoryid='._q($campcategoryid).
        	   '   and cc.campaignid=c.campaignid'.
        	   '   and c.deleted=0'.
        	   '   and c.accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if(!$rs->EOF)
        {
            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['name'] = $rs->fields['name'];
            $temp['commtype'] = $rs->fields['commtype'];

            return $temp;
        }

        return false;
    }

    //--------------------------------------------------------------------------

	function getCommissionsAsArray()
    {
        $sql = 'select cc.* from wd_pa_campaigncategories cc, wd_pa_campaigns c '.
               'where c.deleted=0 and c.campaignid=cc.campaignid and cc.deleted=0 '.
               '  and c.accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and cc.name='._q(UNASSIGNED_USERS).
               ' order by cc.campaignid, cc.campcategoryid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $campaignCategories = array();
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['campcategoryid'] = $rs->fields['campcategoryid'];
            $temp['name'] = $rs->fields['name'];
            $temp['cpmcommission'] = $rs->fields['cpmcommission'];
            $temp['clickcommission'] = $rs->fields['clickcommission'];
            $temp['salecommission'] = $rs->fields['salecommission'];
            $temp['salecommtype'] = $rs->fields['salecommtype'];
            $temp['recurringcommission'] = $rs->fields['recurringcommission'];
            $temp['recurringcommtype'] = $rs->fields['recurringcommtype'];
            $temp['recurringdatetype'] = $rs->fields['recurringdatetype'];

            if(!isset($campaignCategories[$temp['campaignid']]))
            {
				$campaignCategories[$temp['campaignid']] = $temp;
            }

            $rs->MoveNext();
        }

        return $campaignCategories;
    }

    //--------------------------------------------------------------------------

    function getParamsAsArray()
    {
        $sql = 'select id1, code, value from wd_g_settings where rtype='.SETTINGTYPE_AFF_CAMP.
               ' and accountid='._q($GLOBALS['Auth']->getAccountID());

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $campaignParams = array();
        while(!$rs->EOF)
        {
            $campaignParams[$rs->fields['id1']][$rs->fields['code']] = $rs->fields['value'];

            $rs->MoveNext();
        }

        return $campaignParams;
    }

    //--------------------------------------------------------------------------

	function getCommissionField($data, $optionLike = false)
	{
		$strReturn = '';

		if($optionLike)
		{
			// draw commission category name
			$strReturn .= '&nbsp;'.($data['name'] == UNASSIGNED_USERS && defined($data['name']) ? constant($data['name']) : $data['name']).', ';
		}

        // draw commission type
        $somedrawn = false;
        if($data['commtype'] & TRANSTYPE_CPM)
        {
			$strReturn .= '&nbsp;<b>'.L_G_TYPECPM.'</b>: '.$this->blSettings->showCurrency(_rnd($data['cpmcommission']));
            $somedrawn = true;
        }

		$strReturn .= ($somedrawn ? '&nbsp;'.($optionLike ? ', ' : '<br>') : '');

        if($data['commtype'] & TRANSTYPE_CLICK)
        {
			$strReturn .= '&nbsp;<b>'.L_G_TYPECLICK.'</b>: ';

            if($data['clickcommission'] != '' && $data['clickcommission'] != '0')
			{
				$strReturn .= $this->blSettings->showCurrency(_rnd($data['clickcommission']));
			}
            else
            {
				$strReturn .= '-';
            }

            $somedrawn = true;
        }

		$strReturn .= ($somedrawn ? '&nbsp;'.($optionLike ? ', ' : '<br>') : '');

        if(($data['commtype'] & TRANSTYPE_SALE) || ($data['commtype'] & TRANSTYPE_LEAD))
        {
			$strReturn .= '&nbsp;<b>'.($data['commtype'] & TRANSTYPE_SALE ? L_G_TYPESALE : L_G_TYPELEAD).'</b>: ';

            if($data['salecommission'] != '' && $data['salecommission'] != '0')
            {
                // draw normal commissions
                if($data['salecommtype'] == '%')
                {
					$strReturn .= _rnd($data['salecommission']).' %';
                }
                else
                {
					$strReturn .= $this->blSettings->showCurrency(_rnd($data['salecommission']));
                }

				$strReturn .= ' / ';
                // draw recurring commissions
                if($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') == 1)
                {
                    if($data['recurringcommission'] != '' && $data['recurringcommission'] != '0')
                    {
                        if($data['recurringcommtype'] == '%')
                        {
							$strReturn .= _rnd($data['recurringcommission']).' %';
						}
                        else
                        {
							$strReturn .= $this->blSettings->showCurrency(_rnd($data['recurringcommission']));
                        }

						$strReturn .= ' '.L_G_SMALLRECURRING.' ';

                        switch($data['recurringdatetype'])
                        {
                            case RECURRINGTYPE_WEEKLY: $strReturn .= L_G_WEEKLY; break;
                            case RECURRINGTYPE_MONTHLY: $strReturn .= L_G_MONTHLY; break;
                            case RECURRINGTYPE_QUARTERLY: $strReturn .= L_G_QUARTERLY; break;
                            case RECURRINGTYPE_BIANNUALLY: $strReturn .= L_G_BIANNUALLY; break;
                            case RECURRINGTYPE_YEARLY: $strReturn .= L_G_YEARLY; break;
                        }
                    }
                    else
                    {
						$strReturn .= '-';
                    }
                }
            }
            else
            {
				$strReturn .= '-';
            }
            $somedrawn = true;
		}

		return $strReturn;
    }

    //--------------------------------------------------------------------------

	function getMultitierCommissionField($data)
	{

        $tierCount = $GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels');
        if ($tierCount < 2) return '';
		$strReturn = '<table>';

        if($data['commtype'] & TRANSTYPE_CLICK)
        {
			$strReturn .= '<tr><td valign="top">&nbsp;<b>'.L_G_TYPECLICK.'</b>:</td><td>';

			for ($i=2; $i<=$tierCount; $i++) {
			    $strReturn .= $i.' - tier: ';
                if($data['st'.$i.'clickcommission'] != '' && $data['st'.$i.'clickcommission'] != '0') {
				    $strReturn .= $this->blSettings->showCurrency(_rnd($data['st'.$i.'clickcommission']));
			    } else {
				    $strReturn .= '-';
                }
                $strReturn .= '<br>';
			}

            $strReturn .= '</td></tr>';
        }

        if(($data['commtype'] & TRANSTYPE_SALE) || ($data['commtype'] & TRANSTYPE_LEAD))
        {
            $strReturn .= '<tr><td valign="top">&nbsp;<b>'.($data['commtype'] & TRANSTYPE_SALE ? L_G_TYPESALE : L_G_TYPELEAD).'</b>:</td><td>';

   			for ($i=2; $i<=$tierCount; $i++) {
			    $strReturn .= $i.' - tier: ';
                if($data['st'.$i.'salecommission'] != '' && $data['st'.$i.'salecommission'] != '0') {
				    if($data['stsalecommtype'] == '%') {
					   $strReturn .= _rnd($data['st'.$i.'salecommission']).' %';
                    } else  {
					   $strReturn .= $this->blSettings->showCurrency(_rnd($data['st'.$i.'salecommission']));
                    }

				    $strReturn .= ' / ';
                    // draw recurring commissions
                    if($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') == 1)
                    {
                        if($data['st'.$i.'recurringcommission'] != '' && $data['st'.$i.'recurringcommission'] != '0')
                        {
                            if($data['strecurringcommtype'] == '%') {
							    $strReturn .= _rnd($data['st'.$i.'recurringcommission']).' %';
						    } else {
							    $strReturn .= $this->blSettings->showCurrency(_rnd($data['st'.$i.'recurringcommission']));
                            }
                        }
                        else {
						    $strReturn .= '-';
                        }
                    }
			    } else {
				    $strReturn .= '-';
                }
                $strReturn .= '<br>';
			}

			$strReturn .= '</td></tr>';
		}

		$strReturn .= '</table>';
        return $strReturn;
    }

    //--------------------------------------------------------------------------

	function drawCommissionOption($data)
    {
        $this->drawCommissionField($data, true);
    }

    function drawCommissionField($data, $optionlike = false) {
        print $this->getCommissionField($data, $optionlike);
    }

    function drawMultitierCommissionField($data) {
        print $this->getMultitierCommissionField($data);
    }

    //--------------------------------------------------------------------------

    function CommTypeToBitForm($commTypes)
    {
        $ctype_bit_form = '';

        if(is_array($commTypes) && count($commTypes) > 0)
        {
            foreach($commTypes as $ctype)
            {
                $ctype_bit_form = (int)$ctype_bit_form | (int)$ctype;
            }

            return $ctype_bit_form;
        }

        return false;
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
<?php       if($this->checkPermissions('delete')) { ?>
            <input class="formbutton" type="button" value="<?php echo L_G_DELETE?>"
              onclick="javascript:massDeleteCampaign();">
      <?php } ?>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <?php if($this->checkPermissions('add')) { ?>
            <input class="formbutton" type="button" value="<?php echo L_G_ADDCAMPAIGN?>"
              onclick="javascript:addCampaign();">
      <?php } ?>
<?php
    }

}
?>
