<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabTroubleshooting extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------
    
    function process($data)
    {
        checkCorrectness($_POST['log_level_element'], $data['log_level_element'], L_G_LOG_LEVEL, CHECK_ALLOWED);

        $log_level = 0;
        if(is_array($data['log_level_element']) && count($data['log_level_element']) > 0)
        {
            foreach($data['log_level_element'] as $value)
            {
                $log_level += (int)$value;
            }
        }

        $_POST['log_level'] = $log_level;
        
        if ($log_level < WLOG_DEBUG) {
            $data['debug_emails'] = '';
            $data['debug_impressions'] = '';
            $data['debug_clicks'] = '';
            $data['debug_sales'] = '';
        }

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                         'Aff_debug_emails' => $data['debug_emails'],
                         'Aff_debug_impressions' => $data['debug_impressions'],
                         'Aff_debug_clicks' => $data['debug_clicks'],
                         'Aff_debug_sales' => $data['debug_sales'],
                         'Aff_log_level' => $log_level,
                        );
        }

        return false;
    }

}

?>
