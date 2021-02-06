<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_Banner extends QUnit_UI_TemplatePage
{
    var $blBanners;

    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Views_Banner()
    {
        $this->blBanners =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Banners');
        $this->blCategories =& QUnit_Global::newObj('Affiliate_Merchants_Bl_BannerCategories');

        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_BANNERS,'index.php?md=Affiliate_Merchants_Views_BannerManager');
    }

    //--------------------------------------------------------------------------

    function initPermissions()
    {
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
        if( ($_REQUEST['action'] == "edit") && ($_REQUEST['commited'] != "yes") ) {
           	$this->loadBannerInfo();
        }

        if($_REQUEST['commited'] == "yes") {
            $this->processSaveBanner();
        }

        $this->showBanner();
    }

    //------------------------------------------------------------------------

    function protectVariables()
    {
        $pvars = array();
        $pvars['pdesturl'] = preg_replace('/[\'\"]/', '', $_POST['desturl']);
        $pvars['psourceurl'] = preg_replace('/[\'\"]/', '', $_POST['sourceurl']);
        $pvars['pname'] = preg_replace('/[\'\"]/', '', $_POST['name']);
        $pvars['phidden'] = preg_replace('/[^0-9]/', '', $_POST['hidden']);
        if ($pvars['phidden'] == '') $pvars['phidden'] = 0;
        $pvars['pdesc'] = $_POST['desc'];
        $pvars['BannerID'] = preg_replace('/[\'\"]/', '', $_POST['bid']);
        $pvars['CampaignID'] = preg_replace('/[\'\"]/', '', $_POST['campaign']);
        $pvars['BannerCategoryID'] = preg_replace('/[\'\"]/', '', $_POST['bannercategory']);

        $pvars['pwindow_size_type'] = preg_replace('/[^0-9]/', '', $_POST['window_size_type']);
        $pvars['pwindow_size'] = preg_replace('/[^0-9_]/', '', $_POST['window_size']);
        $pvars['prwidth'] = preg_replace('/[^0-9]/', '', $_POST['rwidth']);
        $pvars['prheight'] = preg_replace('/[^0-9]/', '', $_POST['rheight']);

        return $pvars;
    }

    //------------------------------------------------------------------------

    function checkCorrectness($pvars) {

        //if (!preg_match('/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}((:[0-9]{1,5})?\/.*)?$/i', $_POST['desturl'])) {
        //    QUnit_Messager::setErrorMessage(L_G_INVALIDURL);
        //}

        checkCorrectness($_POST['desturl'], $pvars['pdesturl'], L_G_DESTURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['name'], $pvars['pname'], L_G_BANNERNAME, CHECK_ALLOWED);
        checkCorrectness($_POST['campaign'], $pvars['CampaignID'], L_G_PCNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['bannercategory'], $pvars['BannerCategoryID'], L_G_BANNERCATEGORY, CHECK_EMPTYALLOWED);

        checkCorrectness($_POST['window_size_type'], $pvars['pwindow_size_type'], L_G_BANNERSIZE.' '.strtolower(L_G_TYPE), CHECK_EMPTYALLOWED);

        if($pvars['pwindow_size_type'] == WINDOWSIZE_PREDEFINED)
        {
            checkCorrectness($_POST['window_size'], $pvars['pwindow_size'], L_G_BANNERSIZE, CHECK_EMPTYALLOWED);
            $pvars['psize'] = $pvars['pwindow_size_type'].'_'.$pvars['pwindow_size'];
        }
        else if($pvars['pwindow_size_type'] == WINDOWSIZE_OWN)
        {
            checkCorrectness($_POST['rwidth'], $pvars['prwidth'], L_G_WIDTH, CHECK_EMPTYALLOWED | CHECK_NUMBER);
            checkCorrectness($_POST['rheight'], $pvars['prheight'], L_G_HEIGHT, CHECK_EMPTYALLOWED | CHECK_NUMBER);
            $pvars['psize'] = $pvars['pwindow_size_type'].'_'.$pvars['prwidth'].'_'.$pvars['prheight'];
        }

        return $pvars;
    }

    //------------------------------------------------------------------------

    function processSaveBanner() {
        $pvars = $this->protectVariables();
        $pvars = $this->checkCorrectness($pvars);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            if ($_REQUEST['action'] == "edit") {
                if ($this->blBanners->update($pvars) === true) {
                    QUnit_UI_TemplatePage::redirect('Affiliate_Merchants_Views_BannerManager');
                }
            } else {
                // save banner to db
                if(($bannerID = $this->blBanners->insert($pvars)) !== false) {
                    $_POST['action'] = '';
                    QUnit_UI_TemplatePage::redirect('Affiliate_Merchants_Views_BannerManager');
                }
            }
        }

        return false;
    }

    //------------------------------------------------------------------------

    function showBanner() {
        if ($_POST['header'] == '') {
            $_POST['header'] = L_G_ADDBANNER;
        }

        $objCampaignManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
        $campaigns = $objCampaignManager->getCampaignsAsArray();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($campaigns);
        $this->assign('a_list_campaigns', $list_data);

        $categories = $this->blCategories->getRows();
        $this->assign('bannerCategories', $categories);

        $this->addContent('banner_edit');
    }

    //------------------------------------------------------------------------

    function loadBannerInfo() {
        $bannerid = preg_replace('/[\'\"]/', '', $_REQUEST['bid']);
        $sql = 'select * from wd_pa_banners where deleted=0 and bannerid='._q($bannerid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        $_POST['bid'] = $rs->fields['bannerid'];
        $_POST['desturl'] = $rs->fields['destinationurl'];
        $_POST['name'] = $rs->fields['name'];
        $_POST['sourceurl'] = $rs->fields['sourceurl'];
        $_POST['desc'] = $rs->fields['description'];
        $_POST['campaign'] = $rs->fields['campaignid'];
        $_POST['hidden'] = $rs->fields['hidden'];

        $_REQUEST['campaign'] = $rs->fields['campaignid'];
        $_REQUEST['bannercategory'] = $rs->fields['bannercategory'];
        $_REQUEST['type'] = $rs->fields['bannertype'];

        $bannerSize = explode('_', $rs->fields['size']);
        $_POST['window_size_type'] = $bannerSize[0];
        switch ($bannerSize[0]) {
            case WINDOWSIZE_PREDEFINED:
                $_POST['window_size'] = $bannerSize[1].'_'.$bannerSize[2];
                break;
            case WINDOWSIZE_OWN:
                $_POST['rwidth']  = $bannerSize[1];
                $_POST['rheight'] = $bannerSize[2];
                break;
        }

        $_POST['header'] = L_G_EDITBANNER;

        return $rs->fields;
    }

    //------------------------------------------------------------------------

    function checkBannerExists($catname, $cid = '')
    {
        $sql = 'select * from wd_g_linkcategories where deleted=0 and campaignid='._q($_SESSION[SESSION_PREFIX.'campaignchosen']).' and bannername='._q($catname);
        if($cid != '')
            $sql .= ' and linkbannerid<>'._q($cid);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF)
            return false;

        return true;
    }
}
?>
