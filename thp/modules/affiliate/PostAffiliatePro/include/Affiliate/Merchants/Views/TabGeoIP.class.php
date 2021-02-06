<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabGeoIP extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------
    
    function process($data) {
    	$data['geo_selectedcountries'] = preg_replace('/[\'\"]/', '', $_POST['geo_selectedcountries']);
        $data['geo_allow_ban_trafic'] = preg_replace('/[\'\"]/', '', $_POST['geo_allow_ban_trafic']);
        $data['geo_dont_register_imp'] = preg_replace('/[\'\"]/', '', $_POST['geo_dont_register_imp']);
        $data['geo_dont_register_click'] = preg_replace('/[\'\"]/', '', $_POST['geo_dont_register_click']);
        $data['geo_dont_register_sale'] = preg_replace('/[\'\"]/', '', $_POST['geo_dont_register_sale']);
		$data['geo_after_click_action'] = preg_replace('/[\'\"]/', '', $_POST['geo_after_click_action']);
		$data['geo_custom_dest'] = preg_replace('/[\'\"]/', '', $_POST['geo_custom_dest']);
		
    	if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Glob_acct_geo_allow_ban_trafic' => $data['geo_allow_ban_trafic'],
                            'Glob_acct_geo_dont_register_imp' => $data['geo_dont_register_imp'],
                            'Glob_acct_geo_dont_register_click' => $data['geo_dont_register_click'],
                            'Glob_acct_geo_dont_register_sale' => $data['geo_dont_register_sale'],
                            'Glob_acct_geo_after_click_action' => $data['geo_after_click_action'],
                            'Glob_acct_geo_custom_dest' => $data['geo_custom_dest'],
                            'Glob_acct_geo_selectedcountries' => $data['geo_selectedcountries'],
                            );
        }

        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function show($parent)
	{
		$settings = $GLOBALS['Auth']->getSettings();		
		$_POST['geo_allow_ban_trafic'] = $settings['Glob_acct_geo_allow_ban_trafic'];
		$_POST['geo_dont_register_imp'] = $settings['Glob_acct_geo_dont_register_imp'];
		$_POST['geo_dont_register_click'] = $settings['Glob_acct_geo_dont_register_click'];
		$_POST['geo_dont_register_sale'] = $settings['Glob_acct_geo_dont_register_sale'];
		$_POST['geo_after_click_action'] = $settings['Glob_acct_geo_after_click_action'];
		$_POST['geo_custom_dest'] = $settings['Glob_acct_geo_custom_dest'];
		$_POST['geo_selectedcountries'] = $settings['Glob_acct_geo_selectedcountries'];

		$this->blIpCountry = QUnit_Global::newObj('QCore_Bl_IpCountry');
		$allcountries = $this->blIpCountry->getCountriesAsArray();
		$selectedcountries = explode(",", $settings['Glob_acct_geo_selectedcountries']);
		
		$list_all = array();
		$list_sel = array();
		
		foreach ($allcountries as $key => $value) {
			if (in_array($key, $selectedcountries)) {
				$list_sel[$key] = $value;
			} else {
				$list_all[$key] = $value;
			}
		}
		
		$list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($list_all);
        $parent->temporaryAssign('a_list_data1', $list_data1);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($list_sel);
        $parent->temporaryAssign('a_list_data2', $list_data2);
        
	return parent::show($parent);
	}
}

?>
