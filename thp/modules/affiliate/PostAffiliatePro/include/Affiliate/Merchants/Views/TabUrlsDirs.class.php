<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabUrlsDirs extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------

    function process($data)
    {
        checkCorrectness($_POST['main_site_url'], $data['main_site_url'], L_G_URL_TO_MAIN_SITE, CHECK_ALLOWED);
        checkCorrectness($_POST['export_dir'], $data['export_dir'], L_G_EXPORTDIR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['banners_dir'], $data['banners_dir'], L_G_BANNERSDIR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['banners_url'], $data['banners_url'], L_G_BANNERSURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['scripts_url'], $data['scripts_url'], L_G_URLTOSCRIPTSDIR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['signup_url'], $data['signup_url'], L_G_SIGNUPURL, CHECK_EMPTYALLOWED);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_scripts_url' => $data['scripts_url'], 
                            'Aff_signup_url' => $data['signup_url'],
                            'Aff_main_site_url' => $data['main_site_url'],
                            'Aff_resources_dir' => $data['resources_dir'],
                            'Aff_export_dir' => $data['export_dir'],
                            'Aff_export_url' => $data['export_url'],
                            'Aff_banners_dir' => $data['banners_dir'],
                            'Aff_banners_url' => $data['banners_url']
                            );
        }
        
        return false;
    }	
    
    //------------------------------------------------------------------------
    
	function demoProcess($data)
	{
		return array();
	}
	
	//------------------------------------------------------------------------
	
	function show($parent)
	{
		$list_data = QUnit_Global::newobj('QCore_RecordSet');
		$list_data->setTemplateRS(QCore_Settings::getAvailableLangs());
        $parent->temporaryAssign('a_list_data', $list_data);
		return $parent->temporaryFetch($this->template);
	}
}

?>