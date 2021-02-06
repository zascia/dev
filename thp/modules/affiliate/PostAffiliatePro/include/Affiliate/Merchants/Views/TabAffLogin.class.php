<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabAffLogin extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------
    
    function process($data) {
        if(QUnit_Messager::getErrorMessage() == '')
        {        
            return array(
                'Aff_use_custom_login'    => $data['use_custom_login'],
                'Aff_custom_login_header' => $data['custom_header'],
                'Aff_custom_login_footer' => $data['custom_footer'],
            );
        }
        return false;
    }
}

?>