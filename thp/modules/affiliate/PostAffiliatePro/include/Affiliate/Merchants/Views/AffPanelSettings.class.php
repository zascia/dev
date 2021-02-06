<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_AffPanelSettings extends QUnit_UI_TemplatePage
{

    function Affiliate_Merchants_Views_AffPanelSettings() {
    }

    //--------------------------------------------------------------------------

    function process()
    {
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_TOPMENU_TOOLS,'index.php?md=Affiliate_Merchants_Views_Tools');
        $this->navigationAddURL(L_G_PANELSETTINGS,'index.php?md=Affiliate_Merchants_Views_AffPanelSettings');

        if ($_REQUEST['savesettings']) {
            $this->processSaveSettings();
        }

        if($_REQUEST['showpanel']) {
            $this->processShowPanel();
            return;
        }

        $this->showSettings();
    }

    //--------------------------------------------------------------------------

    function initPermissions()
    {
        $this->modulePermissions['edit'] = 'aff_tool_affpanelsettings_modify';
        $this->modulePermissions['view'] = 'aff_tool_affpanelsettings_view';
    }

    //--------------------------------------------------------------------------

    function showSettings() {

        $setting_links = array();

        $setting_links['mainpage'] = array('name' => L_G_MAINPAGE,
                                           'img' => 'ssh_main.gif',
                                           'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=mainpage',
                                           'desc' => L_G_MAINPAGESETTINGPANELDESC);

        $setting_links['affprofile'] = array('name' => L_G_AFFPROFILE,
                                            'img' => 'ssh_profile.gif',
                                             'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=affprofile',
                                             'desc' => L_G_AFFPROFILESETTINGPANELDESC);

        $setting_links['banners'] = array('name' => L_G_BANNERS,
                                          'img' => 'ssh_banners.gif',
                                          'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=banners',
                                          'desc' => L_G_BANNERSSETTINGPANELDESC);

        $setting_links['subaffsignup'] = array('name' => L_G_LINKTOSUBAFFSIGNUP,
                                             'img' => 'ssh_signupsubaffs.gif',
                                               'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=subaffsignup',
                                               'desc' => L_G_SUBAFFSIGNUPSETTINGPANELDESC);

        $setting_links['quick'] = array('name' => L_G_QUICK,
                                           'img' => 'ssh_quick.gif',
                                        'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=quick',
                                        'desc' => L_G_QUICKREPORTSETTINGPANELDESC);

        $setting_links['transactions'] = array('name' => L_G_TRANSACTIONS,
                                               'img' => 'ssh_trans.gif',
                                              'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=transactions',
                                              'desc' => L_G_TRANSACTIONREPORTSETTINGPANELDESC);

        $setting_links['traffic'] = array('name' => L_G_TRAFFIC,
                                           'img' => 'ssh_traffic.gif',
                                          'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=traffic',
                                          'desc' => L_G_TRAFFICANDSALESSETTINGPANELDESC);

        $setting_links['subaffiliates'] = array('name' => L_G_SUBAFFILIATES,
                                           'img' => 'ssh_subaffrep.gif',
                                          'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=subaffiliates',
                                          'desc' => L_G_SUBAFFILIATESSETTINGPANELDESC);

        $setting_links['afftopurls'] = array('name' => L_G_TOPREFERRINGURLS,
                                           'img' => 'ssh_toprefurl.gif',
                                             'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=afftopurls',
                                             'desc' => L_G_TOPREFERRINGURLSSETTINGPANELDESC);

        $setting_links['settings'] = array('name' => L_G_NOTIFICATIONS,
                                           'img' => 'ssh_notif.gif',
                                           'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=settings',
                                           'desc' => L_G_NOTIFICATIONSSETTINGPANELDESC);

        $setting_links['contactus'] = array('name' => L_G_CONTACTUS,
                                           'img' => 'ssh_notif.gif',
                                            'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=contactus',
                                            'desc' => L_G_CONTACTUSSETTINGPANELDESC);

        $setting_links['faq'] = array('name' => L_G_FAQ,
                                           'img' => 'ssh_faq.gif',
                                            'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=faq',
                                            'desc' => L_G_FAQSETTINGPANELDESC);

        //$setting_links['affdomains'] = array('name' => L_G_DOMAINS,
        //                                     'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings&showpanel=affdomains',
        //                                     'desc' => L_G_DOMAINSSETTINGPANELDESC);

        $this->assign('a_setting_links', $setting_links);
        $this->addContent('settings_affpanelmenu');
    }

    //--------------------------------------------------------------------------

    function processShowPanel() {

        $panel_name = '';
        $panel_type = '';

        switch ($_REQUEST['showpanel']) {

            //affiliate menu
            case 'mainpage':
                $panel_name = L_G_MAINPAGE;
                $panel_type = 'mainpage';
                $panel_desc = L_G_AFF_MAINPAGE_DESCRIPTION;
                $menu_item  = 'main';
                break;

            case 'affprofile':
                $panel_name = L_G_AFFPROFILE;
                $panel_type = 'affprofile';
                $panel_desc = L_G_AP_PROFILE_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_PROFILE_DESCRIPTION;
                $menu_item  = 'profile';
                break;

            //banners&media
            case 'banners':
                $panel_name = L_G_BANNERS;
                $panel_type = 'banners';
                $panel_desc = L_G_AP_BANNERS_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_BANNERS_DESCRIPTION;
                $menu_item  = 'banners';
                break;

            case 'subaffsignup':
                $panel_name = L_G_LINKTOSUBAFFSIGNUP;
                $panel_type = 'subaffsignup';
                $panel_desc = L_G_AP_SUBAFFSIGNUP_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_SUBAFFSIGNUP_DESCRIPTION;
                $menu_item  = 'subaffsignup';
                if(!isset($_REQUEST['signup_page_url'])) $_REQUEST['signup_page_url'] = $GLOBALS['Auth']->getSetting('Aff_settings_subaffsignup_url');
                break;

            //reports
            case 'quick':
                $panel_name = L_G_QUICK;
                $panel_type = 'quick';
                $panel_desc = L_G_AP_QUICKREPORT_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_QUICKREPORT_DESCRIPTION;
                $menu_item  = 'quick';
                break;

            case 'transactions':
                $panel_name = L_G_TRANSACTIONS;
                $panel_type = 'transactions';
                $panel_desc = L_G_AP_TRANSACTION_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_TRANSACTION_DESCRIPTION;
                $menu_item  = 'trans';
                break;

            case 'traffic':
                $panel_name = L_G_TRAFFIC;
                $panel_type = 'traffic';
                $panel_desc = L_G_AP_TRAFFICANDSALES_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_TRAFFICANDSALES_DESCRIPTION;
                $menu_item  = 'traffic';
                break;

            case 'subaffiliates':
                $panel_name = L_G_SUBAFFILIATES;
                $panel_type = 'subaffiliates';
                $panel_desc = L_G_AP_SUBAFFILIATES_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_SUBAFFILIATES_DESCRIPTION;
                $menu_item  = 'subaff';
                break;

            case 'subid':
                $panel_name = L_G_SUBID;
                $panel_type = 'subid';
                $panel_desc = L_G_AP_SUBID_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_SUBID_DESCRIPTION;
                $menu_item  = 'subid';
                break;

            case 'afftopurls':
                $panel_name = L_G_TOPREFERRINGURLS;
                $panel_type = 'afftopurls';
                $panel_desc = L_G_AP_TOPREFERRINGURLS_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_TOPREFERRINGURLS_DESCRIPTION;
                $menu_item  = 'topurls';
                break;

            case 'settings':
                $panel_name = L_G_NOTIFICATIONS;
                $panel_type = 'settings';
                $panel_desc = L_G_AP_NOTIFICATIONS_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_NOTIFICATIONS_DESCRIPTION;
                $menu_item  = 'notif';
                break;

            case 'contactus':
                $panel_name = L_G_CONTACTUS;
                $panel_type = 'contactus';
                $panel_desc = L_G_AP_CONTACTUS_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_CONTACTUS_DESCRIPTION;
                $menu_item  = 'contactus';
                break;

            case 'affdomains':
                $panel_name = L_G_DOMAINS;
                $panel_type = 'affdomains';
                $panel_desc = L_G_AP_DOMAINS_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_DOMAINS_DESCRIPTION;
                $menu_item  = 'domains';
                break;

            case 'faq':
                $panel_name = L_G_FAQ;
                $panel_type = 'faq';
                $panel_desc = L_G_AP_FAQ_DESCRIPTION;
                $panel_aff_desc = L_G_AFF_FAQ_DESCRIPTION;
                $menu_item  = 'faq';
                break;

            default:
                return;
        }

        if (!empty($panel_name)) {

            $this->navigationAddURL($panel_name, '');

            $this->assign('a_panel_name', $panel_name);
            $this->assign('a_panel_type', $panel_type);
            $this->assign('a_panel_desc', $panel_desc);
            $this->assign('a_panel_aff_desc', $panel_aff_desc);
            $this->assign('a_menu_item', $menu_item);

            if ($_REQUEST['showpanel'] == 'mainpage') {
                $this->addContent('settings_aff_mainpage_panel');
            } else if ($_REQUEST['showpanel'] == 'faq') {
                $this->addContent('settings_affpanel_faq');
            } else if ($_REQUEST['showpanel'] == 'subaffsignup') {
                $this->addContent('settings_affpanel_subaff_signup');
            } else {
                $this->addContent('settings_affpanel');
            }

        } else {

            $this->addContent('settings_affpanelmenu');
        }
    }

    //--------------------------------------------------------------------------

    function saveProcessData($processedData)
    {
        if(is_array($processedData) && count($processedData)>0)
        {
            // save change
            $error = false;
            foreach($processedData as $code => $value)
            {
                if(!QCore_Settings::_update($code, $value, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID()))
                    $error = true;
            }

            if($error)
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);
            else
                QUnit_Messager::setOkMessage(L_G_SETTINGSSAVED);

            $GLOBALS['Auth']->loadSettings();
        }
    }

    //--------------------------------------------------------------------------

    function processSaveSettings() {

        if (empty($_REQUEST['paneltype'])) {
            return false;
        }

        $panel_type = $_REQUEST['paneltype'];
        $menu_item  = $_REQUEST['menuitem'];

        $data = array();
        $data['Aff_settings_'.$panel_type.'_show_description']       = (empty($_REQUEST['showdescription']))? 'false' : 'true';
        $data['Aff_settings_'.$panel_type.'_show_customdescription'] = (empty($_REQUEST['showcustomdescription']))? 'false' : 'true';
        $data['Aff_settings_'.$panel_type.'_customdescription']      = stripslashes($_REQUEST['customdescription']);
        $data['Aff_menu_item_'.$menu_item.'_show']                   = (empty($_REQUEST['showsection']))? 'false' : 'true';

        if ($_REQUEST['paneltype'] == 'mainpage') {

            $data['Aff_login_display_welcome']    = preg_replace('/[^0-1]/', '', $_REQUEST['display_welcome']);
            $data['Aff_login_display_text_in_the_middle']    = preg_replace('/[^0-1]/', '', $_REQUEST['display_text_in_the_middle']);
            $data['Aff_login_display_statistics'] = preg_replace('/[^0-1]/', '', $_REQUEST['display_statistics']);
            $data['Aff_login_display_trendgraph'] = preg_replace('/[^0-1]/', '', $_REQUEST['display_trendgraph']);
            $data['Aff_login_display_manager']    = preg_replace('/[^0-1]/', '', $_REQUEST['display_manager']);
            $data['Aff_login_welcome_msg']        = stripslashes($_REQUEST['welcome_msg']);
            $data['Aff_login_text_in_the_middle_msg']        = stripslashes($_REQUEST['text_in_the_middle_msg']);
            $data['Aff_display_news']             = preg_replace('/[^0-1]/', '', $_REQUEST['display_news']);
            $data['Aff_display_resources']        = preg_replace('/[^0-1]/', '', $_REQUEST['display_resources']);
            $data['Aff_display_forum']            = preg_replace('/[^0-1]/', '', $_REQUEST['display_forum']);
        }

        if ($_REQUEST['paneltype'] == 'subaffsignup') {
            $data['Aff_settings_subaffsignup_url'] = preg_replace('/[\"\']/', '', $_POST['signup_page_url']);
            if ($data['Aff_menu_item_subaffsignup_show'] == 'true') {
                checkCorrectness($_REQUEST['signup_page_url'], $data['Aff_settings_subaffsignup_url'], L_G_SIGNUPURL, CHECK_EMPTYALLOWED);
            }
        }

        if (QUnit_Messager::getErrorMessage() != '') return false;

        $this->saveProcessData($data);
    }
}
?>
