<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabComissions extends Affiliate_Merchants_Views_TabSettings
{
//------------------------------------------------------------------------

    function process($data)
    {
        if (GLOBAL_DB_ENABLED == 1) {
            $data['support_cpm_commissions'] = '';
            $data['support_recurring_commissions'] = '';
        }
        checkCorrectness($_POST['fixed_cost'], $data['fixed_cost'], L_G_FIXED_COST, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['program_signup_bonus'], $data['program_signup_bonus'], L_G_PROGRAM_SIGNUP_BONUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['program_referral_commission'], $data['program_referral_commission'], L_G_REFERRAL_COMMISSION, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['program_referral_commission'], $data['program_referral_commission'], L_G_REFERRAL_COMMISSION, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        if(!empty($data['program_signup_bonus']))
            checkCorrectness($_POST['program_signup_bonus'], $data['program_signup_bonus'], L_G_PROGRAM_SIGNUP_BONUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);

        checkCorrectness($_POST['support_refund_commissions'], $data['support_refund_commissions'], L_G_REFUND.' '.strtolower(L_G_COMMISSION), CHECK_ALLOWED);
        checkCorrectness($_POST['support_chargeback_commissions'], $data['support_chargeback_commissions'], L_G_CHARGEBACK.' '.strtolower(L_G_COMMISSION), CHECK_ALLOWED);

        $temp_array = array();
        for($i=2; $i<=$GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels'); $i++) 
        {
            if(!empty($data['st'.$i.'userbonuscommission']))
            {
                checkCorrectness($_POST['st'.$i.'userbonuscommission'], $data['st'.$i.'userbonuscommission'], $i.' - '.L_G_TIER, CHECK_EMPTYALLOWED | CHECK_NUMBER);
            }
            $temp_array['Aff_program_signup_bonus_'.$i.'tr'] = $data['st'.$i.'userbonuscommission'];
        }

        if($data['dont_save_click_transaction'] != '1')
            $data['dont_display_click_transaction'] = '1';
        else
            $data['dont_display_click_transaction'] = '0';

        $comm_type_count = 0;
//        if($data['support_signup_commissions'] == '1') $comm_type_count++;
//        if($data['support_referral_commissions'] == '1') $comm_type_count++;
        if($data['support_cpm_commissions'] == '1') $comm_type_count++;
        if($data['support_click_commissions'] == '1') $comm_type_count++;
        if($data['support_sale_commissions'] == '1') $comm_type_count++;
        if($data['support_lead_commissions'] == '1') $comm_type_count++;
//        if($data['support_recurring_commissions'] == '1') $comm_type_count++;

        if($comm_type_count < 1) QUnit_Messager::setErrorMessage(L_G_ATLEASTONECOMMISSIONTYPEMUSTBECHOOSEN);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array_merge($temp_array, 
                       array(
                            'Aff_support_signup_commissions' => $data['support_signup_commissions'],
                            'Aff_support_referral_commissions' => $data['support_referral_commissions'],
                            'Aff_support_cpm_commissions' => $data['support_cpm_commissions'],
                            'Aff_support_click_commissions' => $data['support_click_commissions'],
                            'Aff_support_sale_commissions' => $data['support_sale_commissions'],
                            'Aff_support_lead_commissions' => $data['support_lead_commissions'],
                            'Aff_support_recurring_commissions' => $data['support_recurring_commissions'],
                            'Aff_support_refund_commissions' => $data['support_refund_commissions'],
                            'Aff_support_chargeback_commissions' => $data['support_chargeback_commissions'],
                            'Aff_forcecommfromproductid' => $data['forcecommfromproductid'],
                            'Aff_maxcommissionlevels' => $data['maxcommissionlevels'],
                            'Aff_apply_from_banner' => $data['apply_from_banner'],
                            'Aff_fixed_cost' => $data['fixed_cost'],
                            'Aff_fixed_cost_unit' => $data['fixed_cost_unit'],
                            'Aff_recurringrealcommissions' => $data['recurringrealcommissions'],
                            'Aff_program_signup_bonus' => $data['program_signup_bonus'],
                            'Aff_program_referral_commission' => $data['program_referral_commission'],
                            'Aff_dont_display_click_transaction' => $data['dont_display_click_transaction'],
                            'Aff_dont_save_click_transaction' => $data['dont_save_click_transaction']
                            ));
        }
        
        return false;            
    }
    
    //------------------------------------------------------------------------
    
	function demoProcess($data)
	{
		return array();
	}
   		
}

?>
