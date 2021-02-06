<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabAffSettings extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------

    function process($data)
    {
        checkCorrectness($_POST['affpostsignupurl'], $data['affpostsignupurl'], L_G_POSTSIGNUPURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['nonreferred_signup'], $data['nonreferred_signup'], L_G_SEND_NONREFERREDAFF_TO, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['join_campaign'], $data['join_campaign'], L_G_JOIN_CAMPAIGN, CHECK_ALLOWED);
        checkCorrectness($_POST['display_banner_stats_all'], $data['display_banner_stats_all'], L_G_DISPLAY_BANNER_STATISTICS_ALL, CHECK_ALLOWED);
        checkCorrectness($_POST['matrix_height'], $data['matrix_height'], L_G_MATRIX_HEIGHT, CHECK_ALLOWED);
        checkCorrectness($_POST['matrix_width'], $data['matrix_width'], L_G_MATRIX_WIDTH, CHECK_ALLOWED);
        checkCorrectness($_POST['use_forced_matrix'], $data['use_forced_matrix'], L_G_USE_FORCED_MATRIX, CHECK_ALLOWED);
        checkCorrectness($_POST['matrix_forced_user'], $data['matrix_forced_user'], L_G_CHOOSE_FORCED_AFFILIATE, CHECK_ALLOWED);
        checkCorrectness($_POST['tiers_visible_to_user'], $data['tiers_visible_to_user'], L_G_TIERS_VISIBLE_TO_AFFILIATE, CHECK_ALLOWED);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_affiliateapproval' => $data['affiliateapproval'],
                            'Aff_afflogouturl' => $data['afflogouturl'],
                            'Aff_affpostsignupurl' => $data['affpostsignupurl'],
                            'Aff_nonreferred_signup' => $data['nonreferred_signup'],
                            'Aff_join_campaign' => $data['join_campaign'],
                            'Aff_display_news' => $data['display_news'],
                            'Aff_display_resources' => $data['display_resources'],
                            'Aff_display_banner_stats_all' => $data['display_banner_stats_all'],
                            'Aff_matrix_height' => $data['matrix_height'],
                            'Aff_matrix_width' => $data['matrix_width'],
                            'Aff_use_forced_matrix' => $data['use_forced_matrix'],
                            'Aff_matrix_forced_user' => $data['matrix_forced_user'],
                            'Aff_tiers_visible_to_user' => $data['tiers_visible_to_user']
                            );
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
        $parent->temporaryAssign('a_list_data1', $list_data);
        
        
        $parent->temporaryAssign('a_forum_installed', $GLOBALS['Auth']->getSetting('Glob_acct_phpbb_installed'));
		
		return parent::show($parent);
	}
}

?>