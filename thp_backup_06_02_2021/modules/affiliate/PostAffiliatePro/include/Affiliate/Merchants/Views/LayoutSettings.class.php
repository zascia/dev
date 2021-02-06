<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QCore_Settings');

class Affiliate_Merchants_Views_LayoutSettings extends QUnit_UI_TemplatePage
{
    function Affiliate_Merchants_Views_LayoutSettings() {
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_TOPMENU_TOOLS,'index.php?md=Affiliate_Merchants_Views_Tools');
        $this->navigationAddURL(L_G_LAYOUTSETTINGS,'index.php?md=Affiliate_Merchants_Views_LayoutSettings');
        $this->colors = QUnit_Global::newObj('QUnit_UI_ColorScheme');
    }

    //--------------------------------------------------------------------------

    function initPermissions()
    {
        $this->modulePermissions['edit'] = 'aff_tool_afflayoutsettings_modify';
        //$this->modulePermissions['view'] = 'aff_tool_afflayoutsettings_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if($_REQUEST['showstyles'] == '1') {
            $this->showStyles();
            return;
        }

        if($_REQUEST['commited'] == "yes") {
            $this->processSaveSettings();
        } else {
            $this->loadSettings();
        }

        $this->showSettings();
    }

    //--------------------------------------------------------------------------

    function showStyles() {
        $settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, 'default1');

        foreach ($settings as $key => $value) {
            if ( (strstr($key, 'Aff_style_') !== false) && ($value != '')) {
                $this->colors->setColor(substr($key, 12), $value);
            }
        }

        $this->assign('a_colors', $this->colors);
        $this->addContent('styles-'.DEFAULT_STYLE);
    }

    //--------------------------------------------------------------------------

    function showSettings() {
        $settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, 'default1');
        if(!isset($settings['Aff_style_current_color_scheme'])) {
            $settings['Aff_style_current_color_scheme'] = 'Blue';
        }

        $this->assign('a_current_scheme', $settings['Aff_style_current_color_scheme']);
        $this->assign('a_colors', $this->colors);
        $this->addContent('settings_layout');
    }

    //--------------------------------------------------------------------------

    function loadSettings() {
        $settings = $GLOBALS['Auth']->getSettings();
        foreach ($settings as $key => $value) {
            if (strstr($key, 'Aff_style_') !== false) {
                $_POST[substr($key, 10)] = $value;
            }
        }
    }

    //--------------------------------------------------------------------------

    function processSaveSettings() {
        foreach ($_POST as $key => $value) {
            if (strstr($key, 'c_') === false)
                continue;
            $data[$key] = preg_replace('/[\'\"]/', $key, $_POST[$key]);
        }

        $data['merchant_skin'] = preg_replace('/[\'\"]/', '', $_POST['merchant_skin']);
        $data['affiliate_skin'] = preg_replace('/[\'\"]/', '', $_POST['affiliate_skin']);
        $data['logo_url'] = preg_replace('/[\'\"]/', '', $_POST['logo_url']);
        $data['page_position'] = preg_replace('/[\'\"]/', '', $_POST['page_position']);
        $data['current_color_scheme'] = preg_replace('/[\'\"]/', '', $_POST['current_color_scheme']);

        if (!in_array($data['merchant_skin'], array("default", "blueStyle")))
            QUnit_Messager::setErrorMessage(L_G_INVALIDAFFILIATESKIN);
        if (!in_array($data['affiliate_skin'], array("default", "blueStyle")))
            QUnit_Messager::setErrorMessage(L_G_INVALIDAFFILIATESKIN);

        // process file upload
        if ( ($logo = $this->processLogoUpload()) != false ) {
            $_POST['logo_url'] = $data['logo_url'] = $logo;
        }

        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }

        $processedData = array();
        foreach ($data as $key => $value) {
            $processedData['Aff_style_'.$key] = $value;
        }

        if(is_array($processedData) && count($processedData)>0) {
            // save change
            $error = false;
            foreach($processedData as $code => $value)
            {
                if(!QCore_Settings::_update($code, $value, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID()))
                    $error = true;
            }

            if($error) {
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);
            } else {
                QUnit_Messager::setOkMessage(L_G_SETTINGSSAVED);
                Redirect_nomsg("index.php?md=Affiliate_Merchants_Views_LayoutSettings");
            }

            $GLOBALS['Auth']->loadSettings();
        }
    }

    //--------------------------------------------------------------------------

    function processLogoUpload() {
        // check file upload
        if($_FILES['logo_file']['name'] != '') {
                $fileName = '_x2g68t_logo_'.$GLOBALS['Auth']->getAccountID().'.'.substr(strrchr($_FILES['logo_file']['name'], '.'), 1);
                $oUpload = QUnit_Global::newObj('QUnit_Net_FileUpload',  $GLOBALS['Auth']->getSetting('Aff_banners_dir'), $_FILES['logo_file'], $fileName);

                $oUpload->setAllowedTypes($GLOBALS['UPLOAD_ALLOWED_FILE_TYPES']);

                if($oUpload->handleUpload() === false) {
                    return false;
                }
                return $GLOBALS['Auth']->getSetting('Aff_banners_url').$fileName;
        }
        return false;
    }

}
?>
