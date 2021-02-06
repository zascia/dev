<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabAffSignup extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------

    function process($data) {
        if ($data['newsletter_signup_enabled'] == '1') {
            checkCorrectness($_POST['newsletter_signup_email'], $data['newsletter_signup_email'], L_G_NEWSLETTEREMAIL, CHECK_EMPTYALLOWED);
        }
        
        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                'Aff_newsletter_signup_enabled' => $data['newsletter_signup_enabled'],
                'Aff_newsletter_signup_email' => $data['newsletter_signup_email'],
                'Aff_affpostsignupurl' => $data['affpostsignupurl'],
                'Aff_signup_terms_conditions' => $data['signup_terms_conditions'],
                'Aff_signup_display_terms' => $data['signup_display_terms'],
                'Aff_signup_force_acceptance' => $data['signup_force_acceptance'],
                'Aff_signup_affect_editing' => $data['signup_affect_editing'],

                'Aff_signup_username' => "1",
                'Aff_signup_username_mandatory' => 'true',

                'Aff_signup_name' => "1",
                'Aff_signup_name_mandatory' => 'true',

                'Aff_signup_surname' => "1",
                'Aff_signup_surname_mandatory' => 'true',

                'Aff_signup_street' => ($data['signup_street_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_street_mandatory' => $data['signup_street_mandatory'],

                'Aff_signup_city' => ($data['signup_city_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_city_mandatory' => $data['signup_city_mandatory'],

                'Aff_signup_company_name' => ($data['signup_company_name_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_company_name_mandatory' => $data['signup_company_name_mandatory'],

                'Aff_signup_state' => ($data['signup_state_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_state_mandatory' => $data['signup_state_mandatory'],

                'Aff_signup_zipcode' => ($data['signup_zipcode_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_zipcode_mandatory' => $data['signup_zipcode_mandatory'],

                'Aff_signup_weburl' => ($data['signup_weburl_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_weburl_mandatory' => $data['signup_weburl_mandatory'],

                'Aff_signup_phone' => ($data['signup_phone_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_phone_mandatory' => $data['signup_phone_mandatory'],

                'Aff_signup_fax' => ($data['signup_fax_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_fax_mandatory' => $data['signup_fax_mandatory'],

                'Aff_signup_tax_ssn' => ($data['signup_tax_ssn_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_tax_ssn_mandatory' => $data['signup_tax_ssn_mandatory'],

                'Aff_signup_country' => ($data['signup_country_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_country_mandatory' => $data['signup_country_mandatory'],

                'Aff_signup_data1' => ($data['signup_data1_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_data1_mandatory' => $data['signup_data1_mandatory'],
                'Aff_signup_data1_name' => $data['signup_data1_name'],

                'Aff_signup_data2' => ($data['signup_data2_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_data2_mandatory' => $data['signup_data2_mandatory'],
                'Aff_signup_data2_name' => $data['signup_data2_name'],

                'Aff_signup_data3' => ($data['signup_data3_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_data3_mandatory' => $data['signup_data3_mandatory'],
                'Aff_signup_data3_name' => $data['signup_data3_name'],

                'Aff_signup_data4' => ($data['signup_data4_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_data4_mandatory' => $data['signup_data4_mandatory'],
                'Aff_signup_data4_name' => $data['signup_data4_name'],

                'Aff_signup_data5' => ($data['signup_data5_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_data5_mandatory' => $data['signup_data5_mandatory'],
                'Aff_signup_data5_name' => $data['signup_data5_name'],

                'Aff_signup_refid' => ($data['signup_refid_mandatory'] == 'hide') ? 0 : 1,
                'Aff_signup_refid_mandatory' => $data['signup_refid_mandatory'],

                'Aff_signup_automatic_form' => $data['signup_automatic_form'],
                'Aff_signup_description' => $data['signup_description'],
                'Aff_signup_display_description' => $data['signup_display_description'],
            );
        }
        return false;
    }
}

?>