<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_AffLoginSettings extends QUnit_UI_TemplatePage
{
    function Affiliate_Merchants_Views_AffLoginSettings() {
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_TOPMENU_TOOLS,'index.php?md=Affiliate_Merchants_Views_Tools');
        $this->navigationAddURL(L_G_LOGINSCREENSETTINGS,'index.php?md=Affiliate_Merchants_Views_AffLoginSettings');
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if($_REQUEST['commited'] == "yes") {
            $this->processSaveSettings();
        } else {
            $this->loadSettings();
        }
    
        $this->showSettings();
    }
    
    //--------------------------------------------------------------------------
    
    function showSettings() {
        
        $this->addContent('settings_afflogin');
    }
    
    //--------------------------------------------------------------------------
    
    function loadSettings() {
        $settings = $GLOBALS['Auth']->getSettings();
        
        $_POST['display_welcome']    = $settings['Aff_login_display_welcome'];
        $_POST['display_statistics'] = $settings['Aff_login_display_statistics'];
        $_POST['display_trendgraph'] = $settings['Aff_login_display_trendgraph'];
        $_POST['display_manager']    = $settings['Aff_login_display_manager'];
        $_POST['welcome_msg']        = $settings['Aff_login_welcome_msg'];
        $_POST['display_news']       = $settings['Aff_display_news'];
        $_POST['display_resources']  = $settings['Aff_display_resources'];
        $_POST['display_forum']      = $settings['Aff_display_forum'];
    }
    
    //--------------------------------------------------------------------------
    
    function processSaveSettings() {
        $data['display_welcome'] = preg_replace('/[^0-1]/', '', $_POST['display_welcome']);
        $data['display_statistics'] = preg_replace('/[^0-1]/', '', $_POST['display_statistics']);
        $data['display_trendgraph'] = preg_replace('/[^0-1]/', '', $_POST['display_trendgraph']);
        $data['display_manager'] = preg_replace('/[^0-1]/', '', $_POST['display_manager']);
        $data['display_news'] = preg_replace('/[^0-1]/', '', $_POST['display_news']);
        $data['display_resources'] = preg_replace('/[^0-1]/', '', $_POST['display_resources']);
        $data['display_forum'] = preg_replace('/[^0-1]/', '', $_POST['display_forum']);
        $_POST['welcome_msg'] = $data['welcome_msg'] = stripslashes($_POST['welcome_msg']);

        if(QUnit_Messager::getErrorMessage() != '') {
            return false;   
        }
        
        $processedData =  array(
                         'Aff_login_display_welcome'    => $data['display_welcome'],
                         'Aff_login_display_statistics' => $data['display_statistics'],
                         'Aff_login_display_trendgraph' => $data['display_trendgraph'],
                         'Aff_login_display_manager'    => $data['display_manager'],
                         'Aff_login_welcome_msg'        => $data['welcome_msg'],
                         'Aff_display_news'             => $data['display_news'],
                         'Aff_display_resources'        => $data['display_resources'],
                         'Aff_display_forum'            => $data['display_forum']);
        
        if(is_array($processedData) && count($processedData)>0) {
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
}
?>
