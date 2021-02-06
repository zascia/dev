<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================


QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Affiliates_Views_Faq extends QUnit_UI_TemplatePage
{

    function Affiliate_Affiliates_Views_Faq() {
        $this->blCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');        
        
        $this->navigationAddURL(L_G_HOME, 'index.php?md=home');
        $this->navigationAddURL(L_G_FAQ, 'index.php?md=Affiliate_Affiliates_Views_Faq');
    }
    
    //------------------------------------------------------------------------
    
    function process()
    {   
        $this->drawFormFaq();    
    }
 
    //------------------------------------------------------------------------

    function drawFormFaq()
    {
        $panel_settings = QUnit_Global::newObj('Affiliate_Affiliates_Views_AffPanelSettings');
        $GLOBALS['Auth']->loadSettings();
        
        $this->assign('a_description', L_G_AFF_FAQ_DESCRIPTION);
        
        $a_panel_settings = $panel_settings->loadPanelSettings('faq');
        $a_panel_settings['show_customdescription'] = 'false';
        $this->assign('a_panel_settings', $a_panel_settings);
        
        $this->addContent('section_descriptions');
        $this->assign('header', L_G_FAQ);
        $this->addContent('faq');
        return true;
    }

    //------------------------------------------------------------------------
}
?>
