<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabFraudProtection extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------

    function process($data)
    {
        if($_POST['declinefrequentclicks'] == '')
            $_POST['declinefrequentclicks'] = '0';
        if($_POST['declinefrequentsales'] == '')
            $_POST['declinefrequentsales'] = '0';
        if($_POST['declinesameorderid'] == '')
            $_POST['declinesameorderid'] = '0';
        if($_POST['blockimps_time'] == '')
            $_POST['blockimps_time'] = '0';

        if($data['declinefrequentclicks'] == '')
            $data['declinefrequentclicks'] = '0';
        if($data['declinefrequentsales'] == '')
            $data['declinefrequentsales'] = '0';
        if($data['declinesameorderid'] == '')
            $data['declinesameorderid'] = '0';
        if($data['blockimps_time'] == '')
            $data['blockimps_time'] = '0';
            
        // check correctness of the fields
        checkCorrectness($_POST['frequentclicks'], $data['frequentclicks'], L_G_WHATTODO_REPEATING_CLICKS, CHECK_ALLOWED);
        checkCorrectness($_POST['declinefrequentclicks'], $data['declinefrequentclicks'], L_G_DECLINEFREQUENTCLICKS, CHECK_ALLOWED);
        if($data['declinefrequentclicks'] == 1)
            checkCorrectness($_POST['clickfrequency'], $data['clickfrequency'], L_G_SECONDSFIELD, CHECK_EMPTYALLOWED);
        else
        {
            $_POST['clickfrequency'] = 0;
            $data['clickfrequency'] = 0;
        }
        
        checkCorrectness($_POST['frequentsales'], $data['frequentsales'], L_G_WHATTODO_REPEATING_SALES, CHECK_ALLOWED);
        checkCorrectness($_POST['declinefrequentsales'], $data['declinefrequentsales'], L_G_DECLINEFREQUENTSALES, CHECK_ALLOWED);
        if($data['declinefrequentsales'] == 1)
            checkCorrectness($_POST['salefrequency'], $data['salefrequency'], L_G_SECONDSFIELD, CHECK_EMPTYALLOWED);
        else
        {
            $_POST['salefrequency'] = 0;
            $data['salefrequency'] = 0;
        }
            
        checkCorrectness($_POST['declinesameorderid'], $data['declinesameorderid'], L_G_DECLINESALESSAMEORDERID, CHECK_ALLOWED);
        if($data['declinesameorderid']) {
            checkCorrectness($_POST['saleorderidfrequency'], $data['saleorderidfrequency'], L_G_HOURSFIELD, CHECK_EMPTYALLOWED);
        } else {
            $_POST['saleorderidfrequency'] = 0;
            $data['saleorderidfrequency'] = 0;
        }
        
        checkCorrectness($_POST['login_protection_retries'], $data['login_protection_retries'], L_G_LOGINPROTECTIONRETRIES, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['login_protection_delay'], $data['login_protection_delay'], L_G_LOGINPROTECTIONDELAY, CHECK_EMPTYALLOWED);

        checkCorrectness($_POST['blockimps'], $data['blockimps'], L_G_DECLINESALESSAMEORDERID, CHECK_ALLOWED);
        
        
        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_login_protection_retries' => $data['login_protection_retries'],
                            'Aff_login_protection_delay' => $data['login_protection_delay'],
                            'Aff_declinefrequentclicks' => $data['declinefrequentclicks'],
                            'Aff_frequentclicks' => $data['frequentclicks'],
                            'Aff_declinefrequentsales' => $data['declinefrequentsales'],
                            'Aff_frequentsales' => $data['frequentsales'],
                            'Aff_declinesameorderid' => $data['declinesameorderid'],
                            'Aff_clickfrequency' => $data['clickfrequency'],
                            'Aff_salefrequency' => $data['salefrequency'],
                            'Aff_saleorderidfrequency' => $data['saleorderidfrequency'],
                            'Aff_blockimps' => $data['blockimps'],
                            'Aff_blockimps_time' => $data['blockimps_time'],
                            'Aff_blockimps_timeunit' => $data['blockimps_timeunit'],
                        );
        }

        return false;
    }
}

?>