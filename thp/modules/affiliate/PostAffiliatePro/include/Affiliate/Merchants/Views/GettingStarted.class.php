<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QCore_Bl_GlobalDb');

class Affiliate_Merchants_Views_GettingStarted extends QUnit_UI_TemplatePage
{
    function Affiliate_Merchants_Views_GettingStarted() {
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_GETTINGSTARTED,'index.php?md=Affiliate_Merchants_Views_GettingStarted');
    }
    
    //--------------------------------------------------------------------------

    function initPermissions() {
    }
    
    //--------------------------------------------------------------------------

    function process() {
        $this->showAboutInfo();
    }
    
    //--------------------------------------------------------------------------

    function showAboutInfo() {
        $this->assign('a_settings', QCore_Settings::getGlobalSettings());
        
        $this->addContent('getting_started');
    }
}

?>
