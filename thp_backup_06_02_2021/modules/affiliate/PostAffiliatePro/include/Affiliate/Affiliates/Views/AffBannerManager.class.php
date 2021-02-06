<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Affiliates_Views_AffBannerManager extends QUnit_UI_TemplatePage
{
    var $blAffiliate;
    var $blSaleStat;

    //--------------------------------------------------------------------------

    function Affiliate_Affiliates_Views_AffBannerManager()
    {
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_CAMPAIGNS,'');

        $this->blCampaign =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Campaign');
        $this->blCampaignCategories =& QUnit_Global::newObj('Affiliate_Merchants_Bl_CampaignCategories');
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Affiliates_Bl_Affiliate');
        $this->blSaleStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleStatistics');
        $this->blCategories =& QUnit_Global::newObj('Affiliate_Merchants_Bl_BannerCategories');
        $this->blSettings =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Settings');
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'gendynamiclink':
                if($this->generateDynamicLink())
                    return;
                break;

                case 'gencustdynamiclink':
                if($this->generateCustomDynamicLink())
                    return;
                break;

                case 'dynamiclink':
                if($this->drawDynamicLinkForm())
                    return;
                break;

                case 'custdynamiclink':
                if($this->drawCustomDynamicLinkForm())
                    return;
                break;

                case 'subaffsignup':
                if($this->drawSubAffSignup())
                    return;
                break;
            }
        }
        $this->assign('a_form_preffix', 'bs_');
        $this->assign('a_form_name', 'FilterForm');

        $panel_settings = QUnit_Global::newObj('Affiliate_Affiliates_Views_AffPanelSettings');
        $this->assign('a_description', L_G_AFF_BANNERS_DESCRIPTION);
        $this->assign('a_panel_settings', $panel_settings->loadPanelSettings('banners'));
        $this->addContent('section_descriptions');

        $this->showBanners();
    }

    //--------------------------------------------------------------------------

    function getAllowedDomainsForDynamicLink()
    {
        $domains = trim($GLOBALS['Auth']->getSetting('Aff_dynamic_link_domains'));

        if ($domains == '') return false;

        $domains = explode("\n", $domains);

        if (count($domains) < 1) return false;

        foreach ($domains as $i => $d) {
            if (trim($d) == '') unset($domains[$i]);
        }

        return $domains;
    }

    //--------------------------------------------------------------------------

    function checkDynamicLink($destUrl)
    {
        if (($domains = $this->getAllowedDomainsForDynamicLink()) == false) return true;

        if(($pos = strpos($destUrl, "://")) !== false) $destUrl = substr($destUrl, $pos + 3);

        foreach ($domains as $domain) {
            if(($pos = strpos($domain, "://")) !== false) $domain = substr($domain, $pos + 3);
            $domain = trim($domain);

            if (strncmp($domain, $destUrl, min(strlen($domain), strlen($destUrl))) == 0) return true;
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function drawDynamicLinkForm()
    {
        $this->assign('a_allowed_domains', $this->getAllowedDomainsForDynamicLink());

        $this->addContent('dyn_link');

        return true;
    }

    //--------------------------------------------------------------------------

    function drawCustomDynamicLinkForm()
    {
        $this->assign('a_allowed_domains', $this->getAllowedDomainsForDynamicLink());

        $this->addContent('dyn_link_c');

        return true;
    }

    //--------------------------------------------------------------------------

    function generateDynamicLink()
    {
        // protect against script injection
        $specialDestUrl = preg_replace('/[\'\"]/', '', $_POST['desturl']);

        // check correctness of the fields
        checkCorrectness($_POST['desturl'], $specialDestUrl, L_G_DESTURL, CHECK_EMPTYALLOWED);

        if ($this->checkDynamicLink($specialDestUrl) == false) {
            QUnit_Messager::setErrorMessage(L_G_DYNAMICLINKCANPOINTTOALLOWEDDOMAINSONLY);
        }

        if (QUnit_Messager::getErrorMessage() != '') {
            $this->drawDynamicLinkForm();
            return true;
        }

        // get affiliate data first
        $sql = 'select * from wd_g_users '.
                'where userid='._q($GLOBALS['Auth']->userID).
                '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            $this->addErrorMessage(L_G_DBERROR);
            return false;
        }

        $specialDestUrl = $_REQUEST['desturl'];

        $params = array();
        $params['Affiliate_id'] = urlencode($rs->fields['userid']);
        $params['Affiliate_refid'] = urlencode($rs->fields['refid']);
        $params['Affiliate_name'] = urlencode($rs->fields['name'].' '.$rs->fields['surname']);
        $params['Affiliate_username'] = urlencode($rs->fields['username']);
        $params['DynamicLink'] = true;

        $sql = 'select * from wd_pa_banners where bannerid='._q($_REQUEST['bid']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            $this->addErrorMessage(L_G_DBERROR);
            return false;
        }

        $clickUrlOnly = $this->getClickUrl($rs->fields['destinationurl'], $params);

        $banner = $this->showBannerAndGetCode($clickUrlOnly, $rs->fields['bannertype'], $rs->fields['bannerid'], $rs->fields['sourceurl'], $rs->fields['description'], $params, $specialDestUrl);

        $this->assign('a_bannerCode', $banner['bannerCode']);
        $this->assign('a_bannerTitleDescription', $banner['titleDescription']);

        $this->addContent('gen_dyn_link');

        return true;
    }

    //--------------------------------------------------------------------------

    function generateCustomDynamicLink()
    {
        // protect against script injection
        $pdesturl = preg_replace('/[\'\"]/', '', $_POST['desturl']);
        $psourceurl = preg_replace('/[\'\"]/', '', $_POST['sourceurl']);
        $pdesc = $_POST['desc'];

        // check correctness of the fields
        checkCorrectness($_POST['desturl'], $pdesturl, L_G_DESTURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['sourceurl'], $psourceurl, L_G_TITLE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['desc'], $pdesc, L_G_DESCRIPTION, CHECK_ALLOWED);

         if ($this->checkDynamicLink($pdesturl) == false) {
            QUnit_Messager::setErrorMessage(L_G_DYNAMICLINKCANPOINTTOALLOWEDDOMAINSONLY);
        }

        if(QUnit_Messager::getErrorMessage() != '')
        {
            $this->drawCustomDynamicLinkForm();
        }
        else
        {
            // get affiliate data first
            $sql = 'select * from wd_g_users '.
            'where userid='._q($GLOBALS['Auth']->userID).
            '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
            {
                $this->addErrorMessage(L_G_DBERROR);
                return false;
            }

            $specialDestUrl = $_REQUEST['desturl'];

            $params = array();
            $params['Affiliate_id'] = urlencode($rs->fields['userid']);
            $params['Affiliate_refid'] = urlencode($rs->fields['refid']);
            $params['Affiliate_name'] = urlencode($rs->fields['name'].' '.$rs->fields['surname']);
            $params['Affiliate_username'] = urlencode($rs->fields['username']);
            $params['DynamicLink'] = true;

            $clickUrlOnly = $this->getClickUrl($specialDestUrl, $params);

            $banner = $this->showBannerAndGetCode($clickUrlOnly, BANNERTYPE_TEXT, '', $psourceurl, $pdesc, $params, $specialDestUrl);

            $this->assign('a_bannerCode', $banner['bannerCode']);
            $this->assign('a_bannerTitleDescription', $banner['titleDescription']);

            $this->addContent('gen_dyn_link_c');
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function showBanners()
    {
        if (isset($_REQUEST['show_campaign_banners']) && ($_REQUEST['show_campaign_banners'] != '')) {
            $_REQUEST['bs_campaign'] = $_REQUEST['show_campaign_banners'];
            $_REQUEST['bs_advanced_filter_show'] = '1';
            $_REQUEST['bs_bannercategoryid'] = '_all';
            $_REQUEST['bs_bannertype'] = array(BANNERTYPE_HTML, BANNERTYPE_IMAGE, BANNERTYPE_POPUNDER,
                                               BANNERTYPE_POPUP, BANNERTYPE_ROTATOR, BANNERTYPE_TEXT);
        }

        if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == 1)
        {
            // get affiliates campaigns
            $params = array('userID' => $GLOBALS['Auth']->getUserID(),
                'accountID' => $GLOBALS['Auth']->getAccountID()
            );

            $campaigns = $this->blAffiliate->getAffiliatesCampaigns($params);
        }
        else
        {
            $viewCampManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
            $campaigns = $viewCampManager->getCampaignsAsArray();
        }

        $this->blCategories->setAllowedCampaigns($campaigns);
        $rs = $this->blCategories->getCategories(false);
        $this->assign('bannerCategories', $rs);
        $this->assign('noCategoryCount', $this->blCategories->getCategoryCount('_'));
        $this->assign('allCategoryCount', $this->blCategories->getAllCategoryCount());

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strstr($k, 'bs_bannertype') !== false && ($_REQUEST['bannertype_comitted'] == '1')) {
                continue;
            }
            if(strstr($k, 'bs_name') !== false && ($_REQUEST['bannertype_comitted'] == '1')) {
                continue;
            }
            if(strstr($k, 'bs_show_stats') !== false && ($_REQUEST['bannertype_comitted'] == '1')) {
                continue;
            }
            if(strpos($k, 'bs_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }

        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['bs_sortby'] == '') $_REQUEST['bs_sortby'] = 'campaign';
        if($_REQUEST['bs_sortorder'] == '') $_REQUEST['bs_sortorder'] = 'sort_asc';
        if($_REQUEST['bs_campaign'] == '') $_REQUEST['bs_campaign'] = '_';
        if($_REQUEST['bs_reporttype'] == '') $_REQUEST['bs_reporttype'] = 'today';
        if($_REQUEST['bs_day1'] == '') $_REQUEST['bs_day1'] = date("j");
        if($_REQUEST['bs_month1'] == '') $_REQUEST['bs_month1'] = date("n");
        if($_REQUEST['bs_year1'] == '') $_REQUEST['bs_year1'] = date("Y");
        if($_REQUEST['bs_day2'] == '') $_REQUEST['bs_day2'] = date("j");
        if($_REQUEST['bs_month2'] == '') $_REQUEST['bs_month2'] = date("n");
        if($_REQUEST['bs_year2'] == '') $_REQUEST['bs_year2'] = date("Y");
        if($_REQUEST['bs_created_timeselect'] == '') {
            $_REQUEST['bs_created_timeselect'] = TIME_PRESET;
            $_REQUEST['bs_created_timepreset'] = TIME_ALL;
        }
        if($_REQUEST['bs_created_day1'] == '') $_REQUEST['bs_day1'] = date("j");
        if($_REQUEST['bs_created_month1'] == '') $_REQUEST['bs_month1'] = date("n");
        if($_REQUEST['bs_created_year1'] == '') $_REQUEST['bs_year1'] = date("Y");
        if($_REQUEST['bs_created_day2'] == '') $_REQUEST['bs_day2'] = date("j");
        if($_REQUEST['bs_created_month2'] == '') $_REQUEST['bs_month2'] = date("n");
        if($_REQUEST['bs_created_year2'] == '') $_REQUEST['bs_year2'] = date("Y");
        if($_REQUEST['bs_window_size'] == '') $_REQUEST['bs_window_size'] = '_';
        if($_REQUEST['bs_bannertype'] == '') $_REQUEST['bs_bannertype'] = array();
        if($_REQUEST['bs_bannercategoryid'] == '') $_REQUEST['bs_bannercategoryid'] = '_';
        //if($_REQUEST['bs_show_stats'] == '') $_REQUEST['bs_show_stats'] = '_';

        //--------------------------------------
        // put settings into session
        $_SESSION['bs_sortby'] = $_REQUEST['bs_sortby'];
        $_SESSION['bs_sortorder'] = $_REQUEST['bs_sortorder'];
        $_SESSION['bs_campaign'] = $_REQUEST['bs_campaign'];
        $_SESSION['bs_bannercategoryid'] = $_REQUEST['bs_bannercategoryid'];
        $_SESSION['bs_reporttype'] = $_REQUEST['bs_reporttype'];
        $_SESSION['bs_day1'] = $_REQUEST['bs_day1'];
        $_SESSION['bs_month1'] = $_REQUEST['bs_month1'];
        $_SESSION['bs_year1'] = $_REQUEST['bs_year1'];
        $_SESSION['bs_day2'] = $_REQUEST['bs_day2'];
        $_SESSION['bs_month2'] = $_REQUEST['bs_month2'];
        $_SESSION['bs_year2'] = $_REQUEST['bs_year2'];
        $_SESSION['bs_timeselect'] = $_REQUEST['bs_timeselect'];
        $_SESSION['bs_timepreset'] = $_REQUEST['bs_timepreset'];

        $_SESSION['bs_created_day1'] = $_REQUEST['bs_day1'];
        $_SESSION['bs_created_month1'] = $_REQUEST['bs_month1'];
        $_SESSION['bs_created_year1'] = $_REQUEST['bs_year1'];
        $_SESSION['bs_created_day2'] = $_REQUEST['bs_day2'];
        $_SESSION['bs_created_month2'] = $_REQUEST['bs_month2'];
        $_SESSION['bs_created_year2'] = $_REQUEST['bs_year2'];
        $_SESSION['bs_created_timeselect'] = $_REQUEST['bs_created_timeselect'];
        $_SESSION['bs_created_timepreset'] = $_REQUEST['bs_created_timepreset'];

        $_SESSION['bs_window_size'] = $_REQUEST['bs_window_size'];
        $_SESSION['bs_name'] = $_REQUEST['bs_name'];
        $_SESSION['bs_bannertype'] = $_REQUEST['bs_bannertype'];
        $_SESSION['bs_show_stats'] = $_REQUEST['bs_show_stats'];

        // process time filter for statistics
        if($_REQUEST['bs_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['bs_timepreset'], 'bs_'));
        }

        // process time filter for date created
        if($_REQUEST['bs_created_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['bs_created_timepreset'], 'bs_created_'));
        }

        $bannertypes = $_REQUEST['bs_bannertype'];
        $this->assign('a_curyear', date("Y"));

        // get affiliate data first
        $sql = 'select * from wd_g_users '.
                'where userid='._q($GLOBALS['Auth']->getUserID()).
                '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            $this->addErrorMessage(L_G_DBERROR);
            return false;
        }

        $params = array();
        $params['Affiliate_id'] = urlencode($rs->fields['userid']);
        $params['Affiliate_refid'] = urlencode(($rs->fields['refid'] != '' ? $rs->fields['refid'] : $rs->fields['userid']));
        $params['Affiliate_name'] = urlencode($rs->fields['name'].' '.$rs->fields['surname']);
        $params['Affiliate_username'] = urlencode($rs->fields['username']);

        $this->assign('a_params', $params);

        $campaignid = preg_replace('/[\'\"]/', '', $_REQUEST['bs_campaign']);

        $sql = 'select b.*, c.name as campaignname '.
                'from wd_pa_banners b, wd_pa_campaigns c';

        $where = ' where c.campaignid=b.campaignid and c.deleted=0 and b.deleted=0 '.
                 '   and c.accountid='._q($GLOBALS['Auth']->getAccountID()).
                 '   and b.hidden='._q(0).
                 '   and b.bannertype in ('.implode(',', array(BANNERTYPE_TEXT, BANNERTYPE_HTML, BANNERTYPE_IMAGE, BANNERTYPE_POPUNDER, BANNERTYPE_POPUP, BANNERTYPE_ROTATOR)).')';
                 
        if ($_REQUEST['bs_advanced_filter_show'] == '1') {
            $where .= " and (".sqlToDays('b.dateinserted')." >= ".sqlToDays($_REQUEST['bs_created_year1']."-".$_REQUEST['bs_created_month1']."-".$_REQUEST['bs_created_day1']).")".
                      " and (".sqlToDays('b.dateinserted')." <= ".sqlToDays($_REQUEST['bs_created_year2']."-".$_REQUEST['bs_created_month2']."-".$_REQUEST['bs_created_day2']).")";

            if ($_REQUEST['bs_name'] != '' && $_REQUEST['bs_name'] != '_') {
                $where .= " and b.name like '%"._q_noendtags($_REQUEST['bs_name'])."%'";
            }

            if ($_REQUEST['bs_window_size'] == 'n') {
                $where .= ' and (b.size is null or b.size='._q('').')';
            } elseif ($_REQUEST['bs_window_size'] != '' && $_REQUEST['bs_window_size'] != '_') {
                $where .= ' and b.size like '._q('%'.$_REQUEST['bs_window_size']);
            }

            if(is_array($bannertypes)&& count($bannertypes)>0) {
                $where .= " and b.bannertype in (".implode(',', $bannertypes).")";
            } else {
//                $where .= " and b.bannertype like ''";
            }

            if($campaignid != '_' && $campaignid != '') {
                $where .= '   and b.campaignid='._q($campaignid);
            }
        }

        if(is_array($campaigns) && count($campaigns) > 0)
        {
            $campaignIDs = '';
            foreach($campaigns as $key => $value)
                $campaignIDs .= '\''.$key.'\',';
            $campaignIDs = substr($campaignIDs, 0, -1);
            if($campaignIDs != '')
                $where .= '   and b.campaignid in ('.$campaignIDs.')';
        } elseif ($campaigns == false) {
            $where .= ' and 1=0';
        }


        if($_REQUEST['bs_bannercategoryid'] != '_all') {
            if(isset($_REQUEST['bs_bannercategoryid']) && strlen($_REQUEST['bs_bannercategoryid']) && $_REQUEST['bs_bannercategoryid'] != '_') {
                $where .= ' and b.bannercategory = '._q($_REQUEST['bs_bannercategoryid']);
            } else {
                $where .= " and (b.bannercategory is null || b.bannercategory = '_' || b.bannercategory ='') ";
            }
        }

        $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);
        if(!$rs) {
            $this->addErrorMessage(L_G_DBERROR);
            return;
        }

        $data = array();
        while(!$rs->EOF) {
            $data[$rs->fields['bannerid']] = $rs->fields;
            $rs->MoveNext();
        }

        $bannerStats = $this->blSaleStat->getBannerStats($GLOBALS['Auth']->getUserID(),
            $_REQUEST['bs_day1'], $_REQUEST['bs_month1'], $_REQUEST['bs_year1'],
            $_REQUEST['bs_day2'], $_REQUEST['bs_month2'], $_REQUEST['bs_year2']);
        $this->assign('a_bannerStats', $bannerStats);

        $userid = $GLOBALS['Auth']->getUserID();
        if (count($data) > 0) {
            foreach ($data as $bannerID => $bannerData) {
                $data[$bannerID] = array_merge($bannerData, $bannerStats[$bannerID]);
                $data[$bannerID][$userid] = $bannerStats[$bannerID][$userid];
            }
            $sortOrder = $this->sortBanners($data, $_REQUEST['bs_sortby'], $_REQUEST['bs_sortorder']);
        }

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_campaigns', $list_data1);

        $this->assign('a_list_data', $sortOrder);
        $this->assign('a_bannerData', $data);

        $this->assign('a_numrows', $rs->PO_RecordCount('wd_pa_banners b, wd_pa_campaigns c', $where));
        $this->assign('a_bannersizes', $this->getBannerSizes());

        $this->assign('a_campaignInfo', $this->loadCampaignInfo());
        
        $this->assign('a_hide_dynamic_link', $GLOBALS['Auth']->getSetting('Aff_default_campaign') == '_');

        $this->addContent('banners_show');
    }

    //--------------------------------------------------------------------------

    function getBannerSizes() {
        $sql = 'select distinct SUBSTRING(size, 3) as size from wd_pa_banners'.
               ' where size is not null and size != '._q('').' and deleted='._q(0);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $widths = array();
        $heights = array();
        while(!$rs->EOF)
        {
            $s = explode('_', $rs->fields['size']);
            $widths[] = $s[0];
            $heights[] = $s[1];
            $rs->MoveNext();
        }

        if (count($widths) < 1) {
            return array();
        }

        array_multisort($heights, SORT_ASC, SORT_NUMERIC, $widths);
        array_multisort($widths,  SORT_ASC, SORT_NUMERIC, $heights);

        $sizes = array();
        foreach ($heights as $i => $value) {
            $sizes[] = $widths[$i].'_'.$heights[$i];
        }

        return $sizes;
    }

    //--------------------------------------------------------------------------

    function loadCampaignInfo()
    {
        $campaignID = DEFAULT_CAMPAIGN;
        if(!$campaignID) {
            return false;
        }

        $info = array();

        $params['campaignid'] = $campaignID;
        $data = $this->blCampaign->load($params);
        if(!$data) {
            return false;
        }

        $info['cid'] = $data['campaignid'];
        $info['cname'] = $data['name'];

        $info['commtype'] = $data['commtype'];

        $info['products'] = $data['products'];
        $info['description'] = $data['description'];
        $info['shortdescription'] = $data['shortdescription'];

        $params['campaignid'] = $campaignID;
        $data = $this->blSettings->getCampaignInfo($params);

        $info['cookielifetime'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'cookielifetime'];
        $info['clickapproval'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'clickapproval'];
        $info['saleapproval'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'saleapproval'];
        $info['affapproval'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'affapproval'];
        $info['status'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'status'];
        $info['signup_bonus'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'signup_bonus'];
        $info['banner_url'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'banner_url'];

        // load settings of first commission category ('unassigned users')
        $data = $this->blCampaignCategories->loadDefaultCommissionCategory($campaignID);

        if(is_array($data) && count($data) > 0)
            foreach($data as $k => $v)
                $info[$k] = $v;

        return $info;
    }

    //--------------------------------------------------------------------------

    function getClickUrl($destinationUrl, $params)
    {
        if($params['Affiliate_refid'] == '') {
            $params['Affiliate_refid'] = $params['Affiliate_id'];
        }

        if(($GLOBALS['Auth']->getSetting('Aff_link_style') == LINK_STYLE_NEW) && ($params['DynamicLink'] !== true))
        {
            $destUrl = $destinationUrl;
            if(strpos($destUrl, '?') === false)
                $char = '?';
            else
                $char = '&';

            $destUrl = str_replace('$Affiliate_id', $params['Affiliate_id'], $destUrl);
            $destUrl = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $destUrl);
            $destUrl = str_replace('$Affiliate_name', $params['Affiliate_name'], $destUrl);
            $destUrl = str_replace('$Affiliate_username', $params['Affiliate_username'], $destUrl);

            if (GLOBAL_DB_ENABLED == 1) {
                $clickUrlOnly = $destUrl.$char."lid=".$GLOBALS['Auth']->getLiteAccountID()."&".PARAM_A_AID."=".$params['Affiliate_refid'];
            } else {
                $clickUrlOnly = $destUrl.$char.PARAM_A_AID."=".$params['Affiliate_refid'];
            }
        }
        else
        {
            if (GLOBAL_DB_ENABLED == 1) {
                $clickUrlOnly = $GLOBALS['Auth']->getSetting('Aff_scripts_url')."t.php?lid=".$GLOBALS['Auth']->getLiteAccountID()."&".PARAM_A_AID."=".$params['Affiliate_refid'];
            } else {
                $clickUrlOnly = $GLOBALS['Auth']->getSetting('Aff_scripts_url')."t.php?".PARAM_A_AID."=".$params['Affiliate_refid'];
            }
        }

        return $clickUrlOnly;
    }

    //--------------------------------------------------------------------------

    function showBannerAndGetCode($clickUrlOnly, $bannerType, $bannerID, $sourceUrl, $description, $params, $specialDestUrl = '')
    {
        if($params['Affiliate_refid'] == '') {
            $params['Affiliate_refid'] = $params['Affiliate_id'];
        }

        if($bannerType == BANNERTYPE_TEXT)
        {
            $title = $sourceUrl;
            $title = str_replace('$Affiliate_id', $params['Affiliate_id'], $title);
            $title = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $title);
            $title = str_replace('$Affiliate_name', $params['Affiliate_name'], $title);
            $title = str_replace('$Affiliate_username', $params['Affiliate_username'], $title);

            $description = str_replace('$Affiliate_id', $params['Affiliate_id'], $description);
            $description = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $description);
            $description = str_replace('$Affiliate_name', $params['Affiliate_name'], $description);
            $description = str_replace('$Affiliate_username', $params['Affiliate_username'], $description);

            $settings = $GLOBALS['Auth']->getSettings();
            if(isset($settings['Aff_bannerformat_textformat']) && trim($settings['Aff_bannerformat_textformat']) != '') {
                $code = $settings['Aff_bannerformat_textformat'];
            } else {
                $code = DEFAULT_BANNER_FORMAT;
            }

            $code = str_replace('$TITLE', $title, $code);
            $code = str_replace('$DESCRIPTION', $description, $code);
            $code = str_replace('$DESTINATION', "'".$clickUrlOnly."&amp;".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&amp;'.PARAM_DESTURL.'='.urlencode($specialDestUrl) : '')."'", $code);

            $banner['titleDescription'] = str_replace('$IMPRESSION_TRACK', "", $code);

            if (GLOBAL_DB_ENABLED == 1) {
                $code = str_replace('$IMPRESSION_TRACK', "<IMG SRC='".$GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?lid=".$GLOBALS['Auth']->getLiteAccountID()."&amp;".PARAM_A_AID."=".$params['Affiliate_refid']."&amp;".PARAM_A_BID."=".$bannerID."' WIDTH=1 HEIGHT=1 BORDER=0>", $code);
            } else {
                $code = str_replace('$IMPRESSION_TRACK', "<IMG SRC='".$GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?".PARAM_A_AID."=".$params['Affiliate_refid']."&amp;".PARAM_A_BID."=".$bannerID."' WIDTH=1 HEIGHT=1 BORDER=0>", $code);
            }

            $banner['bannerCode'] = $code;

            return $banner;
        }
        else if($bannerType == BANNERTYPE_HTML)
        {
            $description = str_replace('$Affiliate_id', $params['Affiliate_id'], $description);
            $description = str_replace('$Affiliate_name', $params['Affiliate_name'], $description);
            $description = str_replace('$Affiliate_username', $params['Affiliate_username'], $description);

            $banner['titleDescription'] = str_replace('$CLICKURL_NOTENCODED', $clickUrlOnly, $description);
            $banner['titleDescription'] = str_replace('$CLICKURL', urlencode($clickUrlOnly), $banner['titleDescription']);
            if (GLOBAL_DB_ENABLED == 1) {
                $code = "<IMG SRC=\"".$GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?lid=".$GLOBALS['Auth']->getLiteAccountID()."&amp;".PARAM_A_AID."=".$params['Affiliate_refid']."&amp;".PARAM_A_BID."=".$bannerID."\" WIDTH=\"1\" HEIGHT=\"1\" BORDER=\"0\">";
            } else {
                $code = "<IMG SRC=\"".$GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?".PARAM_A_AID."=".$params['Affiliate_refid']."&amp;".PARAM_A_BID."=".$bannerID."\" WIDTH=\"1\" HEIGHT=\"1\" BORDER=\"0\" ALT=\"\" >";
            }
            $html = str_replace('$CLICKURL_NOTENCODED', $clickUrlOnly."&amp;".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&amp;'.PARAM_DESTURL.'='.$specialDestUrl : ''), $description);
            $html = str_replace('$CLICKURL', urlencode($clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&'.PARAM_DESTURL.'='.urlencode($specialDestUrl) : '')), $html);
            $code .= $html;

            $banner['bannerCode'] = $code;

            return $banner;
        }
        else if($bannerType == BANNERTYPE_IMAGE)
        {
            $settings = $GLOBALS['Auth']->getSettings();
            if(isset($settings['Aff_bannerformat_graphicformat']) && trim($settings['Aff_bannerformat_graphicformat']) != '') {
                $code = $settings['Aff_bannerformat_graphicformat'];
            } else {
                $code = DEFAULT_GRAPHICS_BANNER_FORMAT;
            }

            $code = str_replace('$ALT', $description, $code);
            $code = str_replace('$DESTINATION', "'".$clickUrlOnly."&amp;".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&amp;'.PARAM_DESTURL.'='.urlencode($specialDestUrl) : '')."'", $code);

            if (GLOBAL_DB_ENABLED == 1) {
                $image_src = $GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?lid=".$GLOBALS['Auth']->getLiteAccountID()."&amp;".PARAM_A_AID."=".$params['Affiliate_refid']."&amp;".PARAM_A_BID."=".$bannerID;
            } else {
                $image_src = $GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?".PARAM_A_AID."=".$params['Affiliate_refid']."&amp;".PARAM_A_BID."=".$bannerID;
            }

            $banner['titleDescription'] = str_replace('$IMAGE_SRC', "'".$sourceUrl."'", $code);

            $code = str_replace('$IMAGE_SRC', "'".$image_src."'", $code);

            $banner['bannerCode'] = $code;

            return $banner;
        }
        else if($bannerType == BANNERTYPE_POPUP || $bannerType == BANNERTYPE_POPUNDER)
        {
            $viewMerchBannerManager = QUnit_Global::newObj('Affiliate_Merchants_Views_BannerManager');
            $banner_details = $viewMerchBannerManager->parseBannerDescription($description, false);

            $banner_content = '';
            if($banner_details['display'] == URL_EXIST)
            {
                $blBanners =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Banners');
                $original_banner = $blBanners->getBannerInfo(array('bannerid' => $sourceUrl));

                $bannerData = $original_banner[$sourceUrl];

                if($bannerData['bannertype'] == BANNERTYPE_TEXT)
                {
                    $title = $bannerData['sourceurl'];
                    $title = str_replace('$Affiliate_id', $params['Affiliate_id'], $title);
                    $title = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $title);
                    $title = str_replace('$Affiliate_name', $params['Affiliate_name'], $title);
                    $title = str_replace('$Affiliate_username', $params['Affiliate_username'], $title);

                    $bannerData['description'] = str_replace('$Affiliate_id', $params['Affiliate_id'], $bannerData['description']);
                    $bannerData['description'] = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $bannerData['description']);
                    $bannerData['description'] = str_replace('$Affiliate_name', $params['Affiliate_name'], $bannerData['description']);
                    $bannerData['description'] = str_replace('$Affiliate_username', $params['Affiliate_username'], $bannerData['description']);

                    $settings = $GLOBALS['Auth']->getSettings();
                    if(isset($settings['Aff_bannerformat_textformat'])) {
                        $banner_content = $settings['Aff_bannerformat_textformat'];
                    } else {
                        $banner_content = DEFAULT_BANNER_FORMAT;
                    }

                    $banner_content = str_replace('$TITLE', $title, $banner_content);
                    $banner_content = str_replace('$DESCRIPTION', $bannerData['description'], $banner_content);
                    $banner_content = str_replace('$DESTINATION', $clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&'.PARAM_DESTURL.'='.urlencode($specialDestUrl) : ''), $banner_content);
                    $banner_content = str_replace('$IMPRESSION_TRACK', "", $banner_content);
                }
                else if($bannerData['bannertype'] == BANNERTYPE_HTML)
                {
                    $bannerData['description'] = str_replace('$Affiliate_id', $params['Affiliate_id'], $bannerData['description']);
                    $bannerData['description'] = str_replace('$Affiliate_name', $params['Affiliate_name'], $bannerData['description']);
                    $bannerData['description'] = str_replace('$Affiliate_username', $params['Affiliate_username'], $bannerData['description']);

                    $banner_content = str_replace('$CLICKURL_NOTENCODED', $clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&'.PARAM_DESTURL.'='.$specialDestUrl : ''), $bannerData['description']);
                    $banner_content = str_replace('$CLICKURL', urlencode($clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&'.PARAM_DESTURL.'='.urlencode($specialDestUrl) : '')), $banner_content);
                }
                else if($bannerData['bannertype'] == BANNERTYPE_IMAGE)
                {
                    $settings = $GLOBALS['Auth']->getSettings();
                    if(isset($settings['Aff_bannerformat_graphicformat']) && trim($settings['Aff_bannerformat_graphicformat']) != '') {
                        $banner_content = $settings['Aff_bannerformat_graphicformat'];
                    } else {
                        $banner_content = DEFAULT_GRAPHICS_BANNER_FORMAT;
                    }

                    $banner_content = str_replace('$ALT', $bannerData['description'], $banner_content);
                    $banner_content = str_replace('$DESTINATION', "'".$clickUrlOnly."&amp;".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&amp;'.PARAM_DESTURL.'='.urlencode($specialDestUrl) : '')."'", $banner_content);
                    $banner_content = str_replace('$IMAGE_SRC', "'".$bannerData['sourceurl']."'", $banner_content);
                }
            }
            else
            {
                //$banner_content = '<iframe src='.$sourceUrl.' scrolling=no frameborder=0 marginwidth=0 marginheight=0 width='.$banner_details['rwidth'].' height='.$banner_details['rheight'].'></iframe>';
                $banner_content = $sourceUrl;
                $clickurl_link = '&clickurl='.urlencode($clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&'.PARAM_DESTURL.'='.urlencode($specialDestUrl) : '')).'&special=1';
            }

            $banner['titleDescription'] = '<input class=formbutton type="button" VALUE="'.L_G_TEST.' '.
                            ($bannerType == BANNERTYPE_POPUNDER ? L_G_POPUNDER : L_G_POPUP).
                            '" onClick="showPopupPopunder(\''.urlencode($banner_content).'\',\''.$bannerType.'\',\''.$banner_details['rwidth'].'\',\''.$banner_details['rheight'].'\')">';

            if (GLOBAL_DB_ENABLED == 1) {
                $impression_content = $GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?lid=".$GLOBALS['Auth']->getLiteAccountID()."&".PARAM_A_AID."=".$params['Affiliate_refid']."&".PARAM_A_BID."=".$bannerID;
            } else {
                $impression_content = $GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?".PARAM_A_AID."=".$params['Affiliate_refid']."&".PARAM_A_BID."=".$bannerID;
            }

            $code = '<script language="JavaScript">';
            $code .= 'var TheNewWindow = window.open("'.$GLOBALS['Auth']->getSetting('Aff_scripts_url').'showPop.php?banner_content='.urlencode($banner_content).'&impression_content='.urlencode($impression_content).$clickurl_link.'",\'ThePop\',';
            $code .= '\'top=0,left=0,width='.$banner_details['rwidth'].',height='.$banner_details['rheight'].',toolbar='.$banner_details['window_toolbar'].',location='.$banner_details['window_location'];
            $code .= ',directories='.$banner_details['window_directories'].',status='.$banner_details['window_status'].',menubar='.$banner_details['window_menubar'].',scrollbars='.$banner_details['window_scrollbars'].',resizable='.$banner_details['window_resizable'].'\');';
            if($bannerType == BANNERTYPE_POPUNDER) $code .= ' TheNewWindow.blur();';
            else $code .= ' TheNewWindow.focus();';
            $code .= '</script>';

            $banner['bannerCode'] = $code;

            return $banner;
        } else if($bannerType == BANNERTYPE_ROTATOR) {
            $banner['titleDescription'] = L_G_ROTATORBANNER;

            if (GLOBAL_DB_ENABLED == 1) {
                $code = "<script type=\"text/javascript\" src=\"".$GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?lid=".$GLOBALS['Auth']->getLiteAccountID()."&amp;".PARAM_A_AID."=".$params['Affiliate_refid']."&amp;".PARAM_A_BID."=".$bannerID."\"></script>";
            } else {
                $code = "<script type=\"text/javascript\" src=\"".$GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?".PARAM_A_AID."=".$params['Affiliate_refid']."&amp;".PARAM_A_BID."=".$bannerID."\"></script>";
            }

            $banner['bannerCode'] = $code;

            return $banner;
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function drawSubAffSignup()
    {
        $this->navigationClearAll();
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_LINKTOSUBAFFSIGNUP,'Affiliate_Affiliates_Views_AffBannerManager&action=subaffsignup');

        $panel_settings = QUnit_Global::newObj('Affiliate_Affiliates_Views_AffPanelSettings');
        $this->assign('a_description', L_G_AFF_SUBAFFSIGNUP_DESCRIPTION);
        if(GLOBAL_DB_ENABLED == 1) {
            $this->assign('a_signuplink', AFFPLANET_HOSTED_WEB_SITE.'s/signup.php?lid='.$GLOBALS['Auth']->getLiteAccountID().'&pid='.$GLOBALS['Auth']->getUserID());
        } else {
            $this->assign('a_signuplink', (($url = $GLOBALS['Auth']->getSetting('Aff_settings_subaffsignup_url')) ? $url : $GLOBALS['Auth']->getSetting('Aff_signup_url') ).'?pid='.$GLOBALS['Auth']->getUserID());
        }

        $this->assign('a_panel_settings', $panel_settings->loadPanelSettings('subaffsignup'));
        $this->addContent('section_descriptions');

        $this->addContent('sub_aff_signup');

        return true;
    }

    //--------------------------------------------------------------------------

    function getCountBannersAsArray()
    {
        $sql = 'select campaignid, count(bannerid) as countbanners from wd_pa_banners where deleted=0 group by campaignid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs)
        {
            $this->addErrorMessage(L_G_DBERROR);
            return false;
        }

        $countbanners = array();

        while(!$rs->EOF)
        {
            $countbanners[$rs->fields['campaignid']] = $rs->fields['countbanners'];

            $rs->MoveNext();
        }

        return $countbanners;
    }

    //--------------------------------------------------------------------------

    function getBannerUrlsAsArray()
    {
        $sql = 'select id1, value from wd_g_settings '.
        'where accountid='._q($GLOBALS['Auth']->getAccountID()).
        '  and code = \''.SETTINGTYPEPREFIX_AFF_CAMP.'banner_url\'';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs)
        {
            $this->addErrorMessage(L_G_DBERROR);
            return false;
        }

        $banner_urls = array();

        while(!$rs->EOF)
        {
            $banner_urls[$rs->fields['id1']] = $rs->fields['value'];

            $rs->MoveNext();
        }

        return $banner_urls;
    }

   //--------------------------------------------------------------------------

    function sortBanners($data, $sortby, $sortOrder) {
        if (!in_array($sortby, array('unique_impressions_period', 'unique_impressions_all',
                                     'clicks_period', 'clicks_all',
                                     'ratio_period', 'ratio_all',
                                     'campaignname', 'destinationurl', 'bannertype',
                                     'name', 'bannerid', 'bannercategory'))) {
            return $data;
        }

        $sortData = array();
        foreach ($data as $bannerID => $bannerData) {
            $sortData[$bannerID] = strtolower($bannerData[$sortby]);
        }

        if ($sortOrder == 'sort_asc') {
            asort($sortData);
        } else {
            arsort($sortData);
        }


        return $sortData;
    }
}
?>
