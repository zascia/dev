<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_Banner');

class Affiliate_Merchants_Views_BannerPopup extends Affiliate_Merchants_Views_Banner
{
    //------------------------------------------------------------------------

    function showBanner() {
        $this->assign('a_bannertemplate', 'banner_edit_popup.tpl.php');
        $this->assign('a_md', 'Affiliate_Merchants_Views_BannerPopup');
        $this->assign('a_hide_banner_size', '1');
        $this->assign('a_type_text', L_G_BANNERTYPE_POPUP.' / '.L_G_BANNERTYPE_POPUNDER);
        $this->assign('a_hlp', L_G_POPUPBANNERHELP);

        $params = array(
            'AccountID' => $GLOBALS['Auth']->getAccountID(),
            'notIn' => array(BANNERTYPE_POPUP, BANNERTYPE_POPUNDER, BANNERTYPE_ROTATOR)
        );

        $banners = $this->blBanners->getBannersAsArray($params);    
        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($banners);
        $this->assign('a_list_data2', $list_data);
        
        $this->navigationAddURL(L_G_POPUPBANNER,'index.php?md=Affiliate_Merchants_Views_BannerPopup');
        
        parent::showBanner();
    }
    
    //------------------------------------------------------------------------

    function loadBannerInfo() {
        $data = parent::loadBannerInfo();
    
        $_REQUEST['type'] = 'popup';
        $_POST['rtype'] = $data['bannertype'];
        $_POST['exist_banner'] = $data['sourceurl'];
        $this->parseBannerDescription($data['description']);
    }
    
    //------------------------------------------------------------------------

    function protectVariables()
    {
        $pvars = parent::protectVariables();
        
        $pvars['prtype'] = preg_replace('/[^0-9]/', '', $_POST['rtype']);
        $pvars['psourceurl'] = preg_replace('/[\'\"]/', '', $_POST['sourceurl']);
        $pvars['pdisplay'] = preg_replace('/[^0-9]/', '', $_POST['display']);
        $pvars['psourceurl'] = preg_replace('/[\'\"]/', '', $_POST['sourceurl']);
        $pvars['pexist_banner'] = preg_replace('/[\'\"]/', '', $_POST['exist_banner']);
        $pvars['pwindow_size_type'] = preg_replace('/[^0-9]/', '', $_POST['window_size_type']);
        $pvars['pwindow_size'] = preg_replace('/[^0-9_]/', '', $_POST['window_size']);
        $pvars['prwidth'] = preg_replace('/[^0-9]/', '', $_POST['rwidth']);
        $pvars['prheight'] = preg_replace('/[^0-9]/', '', $_POST['rheight']);
        $pvars['pwindow_resizable'] = preg_replace('/[^0-9]/', '', $_POST['window_resizable']);
        $pvars['pwindow_status'] = preg_replace('/[^0-9]/', '', $_POST['window_status']);
        $pvars['pwindow_toolbar'] = preg_replace('/[^0-9]/', '', $_POST['window_toolbar']);
        $pvars['pwindow_location'] = preg_replace('/[^0-9]/', '', $_POST['window_location']);
        $pvars['pwindow_directories'] = preg_replace('/[^0-9]/', '', $_POST['window_directories']);
        $pvars['pwindow_menubar'] = preg_replace('/[^0-9]/', '', $_POST['window_menubar']);
        $pvars['pwindow_scrollbars'] = preg_replace('/[^0-9]/', '', $_POST['window_scrollbars']);
        
        return $pvars;
    }
    
    //------------------------------------------------------------------------        
    
    function checkCorrectness($pvars)
    {
        $pvars = parent::checkCorrectness($pvars);
        
        checkCorrectness($_POST['rtype'], $pvars['prtype'], L_G_BANNER.' '.strtolower(L_G_TYPE), CHECK_EMPTYALLOWED);
        
        $pvars['ptype'] = $pvars['prtype'];
        
        checkCorrectness($_POST['display'], $pvars['pdisplay'], L_G_DISPLAY.' '.strtolower(L_G_TYPE), CHECK_EMPTYALLOWED);

        if($pvars['pdisplay'] == URL_OWN)
        {
            checkCorrectness($_POST['sourceurl'], $pvars['psourceurl'], L_G_LINK_TO_YOUR_OWN_URL, CHECK_EMPTYALLOWED);
        }
        else if($pvars['pdisplay'] == URL_EXIST)
        {
            checkCorrectness($_POST['exist_banner'], $pvars['pexist_banner'], L_G_EXISTING_BANNER_LINK, CHECK_EMPTYALLOWED);
            $pvars['psourceurl'] = $pvars['pexist_banner'];
        }

        checkCorrectness($_POST['window_size_type'], $pvars['pwindow_size_type'], L_G_WINDOW_SIZE.' '.strtolower(L_G_TYPE), CHECK_EMPTYALLOWED);
        
        $pvars['pdesc'] = $pvars['pdisplay'].'_'.$pvars['pwindow_size_type'];
        
        if($pvars['pwindow_size_type'] == WINDOWSIZE_PREDEFINED)
        {
            checkCorrectness($_POST['window_size'], $pvars['pwindow_size'], L_G_WINDOW_SIZE, CHECK_EMPTYALLOWED);
            $pvars['pdesc'] = $pvars['pdesc'].'_'.$pvars['pwindow_size'];
        }
        else if($pvars['pwindow_size_type'] == WINDOWSIZE_OWN)
        {
            checkCorrectness($_POST['rwidth'], $pvars['prwidth'], L_G_WIDTH, CHECK_EMPTYALLOWED | CHECK_NUMBER);
            checkCorrectness($_POST['rheight'], $pvars['prheight'], L_G_HEIGHT, CHECK_EMPTYALLOWED | CHECK_NUMBER);
            $pvars['pdesc'] = $pvars['pdesc'].'_'.$pvars['prwidth'].'_'.$pvars['prheight'];
        }
        
        checkCorrectness($_POST['window_resizable'], $pvars['pwindow_resizable'], L_G_WINDOW_RESIZABLE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['window_status'], $pvars['pwindow_status'], L_G_WINDOW_STATUS_FIELD, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['window_toolbar'], $pvars['pwindow_toolbar'], L_G_WINDOW_TOOLBAR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['window_location'], $pvars['pwindow_location'], L_G_WINDOW_LOCATION, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['window_directories'], $pvars['pwindow_directories'], L_G_WINDOW_DIRECTORIES, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['window_menubar'], $pvars['pwindow_menubar'], L_G_WINDOW_MENUBAR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['window_scrollbars'], $pvars['pwindow_scrollbars'], L_G_WINDOW_SCROLLBARS, CHECK_EMPTYALLOWED);
        
        $pvars['pdesc'] .= '_'.$pvars['pwindow_resizable'].'_'.$pvars['pwindow_status'].
                           '_'.$pvars['pwindow_toolbar'].'_'.$pvars['pwindow_location'].
                           '_'.$pvars['pwindow_directories'].'_'.$pvars['pwindow_menubar'].
                           '_'.$pvars['pwindow_scrollbars'];
        
        // format values: display type, window size type, width & height of banner,
        //                resizable, status field, toolbar, location, directories,
        //                menubar, scrollbars
        
        if(QUnit_Messager::getErrorMessage() == '')
        {
            if(!preg_match_all("/_/", $pvars['pdesc'], $matches) || !is_array($matches[0]) || count($matches[0]) != 10)
                QUnit_Messager::setErrorMessage(L_G_BUILD_DESCRIPTION_FAILED);
        }
        
        return $pvars;
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
