<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabLangsCurrencies extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------

    function process($data)
    {
        checkCorrectness($_POST['default_lang'], $data['default_lang'], L_G_SYSTEMLANGUAGE, CHECK_EMPTYALLOWED);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_system_currency' => $data['system_currency'],
                            'Aff_show_minihelp' => $data['show_minihelp'], 
                            'Aff_default_lang' => $data['default_lang'],
                            'Aff_allow_choose_lang' => $data['allow_choose_lang'],
                            'Aff_round_numbers' => $data['round_numbers'],
                            'Aff_currency_left_position' => $data['currency_left_position']
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