<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_BannerManager extends QUnit_UI_TemplatePage
{
    var $blBanners;
    var $blAffiliate;

    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Views_BannerManager()
    {
        $this->blBanners =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Banners');
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blCategories =& QUnit_Global::newObj('Affiliate_Merchants_Bl_BannerCategories');

        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_BANNERS,'index.php?md=Affiliate_Merchants_Views_BannerManager');
   }

    //--------------------------------------------------------------------------

    function initPermissions()
    {
        $this->modulePermissions['addcategory'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['editcategory'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['deletecategory'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['addbanner'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['editbanner'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['add'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['edit'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['delete'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['view'] = 'aff_camp_banner_links_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'delete_bannercategory':
                    if($this->processDeleteBannerCategory())
                        return;
                    break;
                case 'delete':
                    if($this->processDeleteBanner())
                        return;
                    break;
            }
        }

        $this->showBanners();
    }

    //------------------------------------------------------------------------

    function processDeleteBanner()
    {
        $bannerid = preg_replace('/[\'\"]/', '', $_REQUEST['bid']);

        if(AFF_DEMO == 1 && $bannerid == '2')
            return false;

        $sql = 'update wd_pa_banners set deleted=1 where bannerid='._q($bannerid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return false;
    }

    function processDeleteBannerCategory() {
        $id = preg_replace('/[\'\"]/', '', $_REQUEST['bannercategoryid']);

        $sql = 'delete from wd_pa_bannercategories where bannercategoryid='._q($id);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return false;
    }

    //------------------------------------------------------------------------

    function showBanners()
    {

        $categories = $this->blCategories->getCategories();
        $this->assign('bannerCategories', $categories);
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
            if(strpos($k, 'bs_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }

        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['bs_userid'] == '') $_REQUEST['bs_userid'] = '_';
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

        //--------------------------------------
        // put settings into session
        $_SESSION['bs_userid'] = $_REQUEST['bs_userid'];
        $_SESSION['bs_sortby'] = $_REQUEST['bs_sortby'];
        $_SESSION['bs_sortorder'] = $_REQUEST['bs_sortorder'];
        $_SESSION['bs_campaign'] = $_REQUEST['bs_campaign'];
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
        $_SESSION['bs_bannercategoryid'] = $_REQUEST['bs_bannercategoryid'];

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
        $campaignid = preg_replace('/[\'\"]/', '', $_REQUEST['bs_campaign']);

        $sql = 'select b.*, c.name as campaignname '.
               'from wd_pa_banners b, wd_pa_campaigns c ';

        $where='where c.campaignid=b.campaignid and c.deleted=0 and b.deleted=0 '.
               '  and c.accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and b.bannertype in ('.implode(',', array(BANNERTYPE_TEXT, BANNERTYPE_HTML, BANNERTYPE_IMAGE, BANNERTYPE_POPUNDER, BANNERTYPE_POPUP, BANNERTYPE_ROTATOR)).')';

        if($campaignid != '' && $campaignid != '_') {
                $where .= ' and b.campaignid='._q($campaignid);
            }

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
                $where .= " and b.bannertype like ''";
            }
        }

        if($_REQUEST['bs_bannercategoryid'] != '_all') {
            if(isset($_REQUEST['bs_bannercategoryid']) && strlen($_REQUEST['bs_bannercategoryid']) && $_REQUEST['bs_bannercategoryid'] != '_') {
                $where .= ' and b.bannercategory = '._q($_REQUEST['bs_bannercategoryid']);
            } else {
                $where .= " and (b.bannercategory is null || b.bannercategory = '_' || b.bannercategory='') ";
            }
        }

        $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $data = array();
        while(!$rs->EOF) {
            $data[$rs->fields['bannerid']] = $rs->fields;
            $rs->MoveNext();
        }

        $this->assign('a_numrows', $rs->PO_RecordCount('wd_pa_banners b, wd_pa_campaigns c ', $where));

        $affowed_affiliatesSQL = '';
        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK)
        {
            $params = array(
                'AccountID' => $GLOBALS['Auth']->getAccountID()
            );
            $userIDs = Affiliate_Merchants_Bl_Campaign::getMerchantCampaignUsers($params);

            if($userIDs !== false && is_array($userIDs))
                $affowed_affiliatesSQL = '('.implode(',', $userIDs).')';
        }

        $objCampaignManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
        $campaigns = $objCampaignManager->getCampaignsAsArray();

        $objSaleStatistics =& QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleStatistics');
        $bannerStats = $objSaleStatistics->getBannerStats($_REQUEST['bs_userid'],
            $_REQUEST['bs_day1'], $_REQUEST['bs_month1'], $_REQUEST['bs_year1'],
            $_REQUEST['bs_day2'], $_REQUEST['bs_month2'], $_REQUEST['bs_year2'], $affowed_affiliatesSQL);

        $objAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $affiliates = $objAffiliate->getUsersAsArray();

        $aff_list = QUnit_Global::newobj('QCore_RecordSet');
        $aff_list->setTemplateRS($affiliates);
        $this->assign('a_aff_list', $aff_list);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($campaigns);
        $this->assign('a_list_campaigns', $list_data2);

        if (count($data) > 0) {
            foreach ($data as $bannerID => $bannerData) {
                $data[$bannerID] = array_merge($bannerData, $bannerStats[$bannerID]);
            }
            $sortOrder = $this->sortBanners($data, $_REQUEST['bs_sortby'], $_REQUEST['bs_sortorder']);
        }

        $this->assign('a_list_data', $sortOrder);
        $this->assign('a_bannerData', $data);
        $this->assign('a_campaignbanners', $campaignbanners);

        $temp_perm['add'] = $this->checkPermissions('add');
        $temp_perm['edit'] = $this->checkPermissions('edit');
        $temp_perm['delete'] = $this->checkPermissions('delete');
        $temp_perm['addcategory'] = $this->checkPermissions('addcategory');
        $temp_perm['editcategory'] = $this->checkPermissions('editcategory');
        $temp_perm['deletecategory'] = $this->checkPermissions('deletecategory');

        $this->assign('a_action_permission', $temp_perm);

        $this->assign('a_form_preffix', 'bs_');
        $this->assign('a_form_name', 'FilterForm');
        $this->assign('a_bannersizes', $this->getBannerSizes());
        $this->assign('a_affselect_caption', '<b>'.L_G_STATSFORAFFILIATE.'</b>');
        $this->getUsersForFilter();

        $this->addContent('banner_show');

    }

    //--------------------------------------------------------------------------

    function sortBanners($data, $sortby, $sortOrder) {
        if (!in_array($sortby, array('unique_impressions_period', 'unique_impressions_all',
                                     'clicks_period', 'clicks_all',
                                     'ratio_period', 'ratio_all',
                                     'campaignname', 'destinationurl',
                                     'bannertype', 'dateinserted',
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

    //------------------------------------------------------------------------

    function getUsersForFilter()
    {
        $usersRs = $this->blAffiliate->getUsersAsRs();
        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($usersRs);

        $this->assign('a_list_users', $list_data);
    }

    //------------------------------------------------------------------------

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

    //------------------------------------------------------------------------

    function parseBannerDescription($desc, $toPost = true)
    {
        $descArray = explode('_', $desc);

        $parsed = array();
        $parsed['display'] = $descArray[0];
        if($parsed['display'] == URL_EXIST)
        {
            $parsed['sourceurl'] = '';
        }
        else
        {
            $parsed['exist_banner'] = '';
        }

        $parsed['window_size_type'] = $descArray[1];
        if($parsed['window_size_type'] == WINDOWSIZE_OWN)
        {
            $parsed['rwidth'] = $descArray[2];
            $parsed['rheight'] = $descArray[3];
        }
        else
        {
            $parsed['window_size'] = $descArray[2].'_'.$descArray[3];
            $parsed['rwidth'] = $descArray[2];
            $parsed['rheight'] = $descArray[3];
        }

        $parsed['window_resizable'] = $descArray[4];
        $parsed['window_status'] = $descArray[5];
        $parsed['window_toolbar'] = $descArray[6];
        $parsed['window_location'] = $descArray[7];
        $parsed['window_directories'] = $descArray[8];
        $parsed['window_menubar'] = $descArray[9];
        $parsed['window_scrollbars'] = $descArray[10];

        if($toPost === true)
            $_POST = array_merge($_POST, $parsed);
        else
            return $parsed;
    }
}
?>
