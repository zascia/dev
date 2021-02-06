<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabCookiesTracking extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------
    
    function process($data)
    {
        if($data['track_by_ip'] == 1)
            checkCorrectness($_POST['ip_validity'], $data['ip_validity'], L_G_IPADDRESSVALIDITY, CHECK_EMPTYALLOWED);
            
        $ret = array(       'Aff_link_style' => $data['link_style'],
                            'Aff_p3p_xml' => $data['p3p_xml'],
                            'Aff_p3p_compact' => $data['p3p_compact'],
                            'Aff_track_by_ip' => $data['track_by_ip'],
                            'Aff_track_by_browser' => $data['track_by_browser'],
                            'Aff_ip_validity' => $data['ip_validity'],
                            'Aff_ip_validity_type' => $data['ip_validity_type'],
                            'Aff_track_by_session' => $data['track_by_session'],
                            'Aff_overwrite_cookie' => $data['overwrite_cookie'],
                            'Aff_delete_cookie' => $data['delete_cookie'],
                            'Aff_permanent_redirect' => $data['permanent_redirect'],
                            'Aff_referred_affiliate_allow' => $data['referred_affiliate_allow'],
                            'Aff_referred_affiliate' => $data['referred_affiliate'],
                            'Aff_dynamic_link_domains' => $data['dynamic_link_domains']
                        );
            
        if($data['link_style'] == LINK_STYLE_NEW) {
            checkCorrectness($_POST['main_site_url'], $data['main_site_url'], L_G_URL_TO_MAIN_SITE, CHECK_EMPTYALLOWED);
            $ret['Aff_main_site_url'] = $data['main_site_url'];
        }
        
        if(QUnit_Messager::getErrorMessage() == '')
        {
            return $ret;
        }
        
        return false;
    }
    
	//------------------------------------------------------------------------
    
    function show($parent)
	{
		$users = $parent->blAffiliate->getUsersAsArray();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($users);
        $parent->temporaryAssign('a_list_data', $list_data);
		
		return parent::show($parent);
	}
}

?>