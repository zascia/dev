<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TopReferringUrls');

class Affiliate_Affiliates_Views_AffTopUrls extends Affiliate_Merchants_Views_TopReferringUrls
{
    function process()
    {
        $panel_settings = QUnit_Global::newObj('Affiliate_Affiliates_Views_AffPanelSettings');
        $this->assign('a_description', L_G_AFF_TOPREFERRINGURLS_DESCRIPTION);
        $this->assign('a_panel_settings', $panel_settings->loadPanelSettings('afftopurls'));
        $this->addContent('section_descriptions');
        
    	if(parent::show(true))
          return;
    }
}

?>
