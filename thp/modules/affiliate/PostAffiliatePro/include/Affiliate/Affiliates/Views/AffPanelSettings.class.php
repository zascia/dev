<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Affiliates_Views_AffPanelSettings extends QUnit_UI_TemplatePage
{
    function loadPanelSettings($panel_type) {
        
        $settings =& $GLOBALS['Auth']->getSettings();
        $panel_settings = array();
        
        $panel_settings['show_description']       = $settings['Aff_settings_'.$panel_type.'_show_description'];
        $panel_settings['show_customdescription'] = $settings['Aff_settings_'.$panel_type.'_show_customdescription'];
        $panel_settings['customdescription']      = $settings['Aff_settings_'.$panel_type.'_customdescription'];
        
        return $panel_settings;
    }
    
    //-------------------------------------------------------------------------- 
}
?>
