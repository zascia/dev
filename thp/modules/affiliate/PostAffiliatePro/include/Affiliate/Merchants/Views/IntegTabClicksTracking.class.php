<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_IntegTabClicksTracking extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------
    
    function process($data)
    {
        if ($data['link_style'] == LINK_STYLE_NEW) {
            checkCorrectness($_POST['main_site_url'], $data['main_site_url'], L_G_URL_TO_MAIN_SITE, CHECK_EMPTYALLOWED);
        } else {
            checkCorrectness($_POST['main_site_url'], $data['main_site_url'], L_G_URL_TO_MAIN_SITE, CHECK_ALLOWED);
        }
        
        if (!preg_match('/\/$/', $_POST['main_site_url'])) {
            $_POST['main_site_url'] = $_POST['main_site_url'] . '/';
        }

        if ((QUICK_IMPRESSION_ENABLED == 1) && ($data['link_style'] != $GLOBALS['Auth']->getSetting('Aff_link_style'))) {
            $blBanners = QUnit_Global::newObj('Affiliate_Merchants_Bl_Banners');
            $blBanners->createBannerCacheFile();
        }
        
        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_link_style' => $data['link_style'],
                            'Aff_main_site_url' => $data['main_site_url'],
                        );
        }
        
        return false;
    }
    
	//------------------------------------------------------------------------
    
    function show($parent)
	{
	    $_POST['link_style'] = $GLOBALS['Auth']->getSetting('Aff_link_style');
	    $_POST['main_site_url'] = $GLOBALS['Auth']->getSetting('Aff_main_site_url');
	    
		return parent::show($parent);
	}
}

?>