<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabEmailNotifications extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------

    function process($data)
    {
        checkCorrectness($_POST['notifications_email'], $data['notifications_email'], L_G_EMAILFORSENDINGNOTIFICATIONS, CHECK_EMPTYALLOWED);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_email_onaffsignup' => $data['email_onaffsignup'],
                            'Aff_email_onsale' => $data['email_onsale'],
                            'Aff_email_dailyreport' => $data['email_dailyreport'],
                            'Aff_email_merch_dailyreport' => $data['email_merch_dailyreport'],
                            'Aff_email_weeklyreport' => $data['email_weeklyreport'],
                            'Aff_email_merch_weeklyreport' => $data['email_merch_weeklyreport'],
                            'Aff_email_weekstarts' => $data['email_weekstarts'],
                            'Aff_email_weeklysendday' => $data['email_weeklysendday'],
                            'Aff_email_monthlyreport' => $data['email_monthlyreport'],
                            'Aff_email_merch_monthlyreport' => $data['email_merch_monthlyreport'],
                            'Aff_email_monthlysendday' => $data['email_monthlysendday'],
                            'Aff_email_recurringtrangenerated' => $data['email_recurringtrangenerated'],
                            'Aff_notifications_email' => $data['notifications_email'],
                            );
        }

        return false;
    }
    
}

?>