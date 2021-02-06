<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_Settings extends QUnit_UI_TemplatePage
{
    var $blAffiliate;
    var $blPayoutOpts;
    var $tabs;

    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Views_Settings() {
		$this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blPayoutOpts =& QUnit_Global::newObj('Affiliate_Merchants_Bl_PayoutOptions');

        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_TOOLS,'index.php?md=Affiliate_Merchants_Views_Tools');
		$this->navigationAddURL(L_G_SETTINGS,'index.php?md=Affiliate_Merchants_Views_Settings');

		// create all tabs
        $this->tabs['langandcur'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabLangsCurrencies');
		$this->tabs['langandcur']->setAttributes('langandcur', L_G_LANGANDCUR, 'settings_langandcur', 'img_langandcur.gif');

		if (GLOBAL_DB_ENABLED != 1) {
		    $this->tabs['urlanddir'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabUrlsDirs');
		    $this->tabs['urlanddir']->setAttributes('urlanddir', L_G_URLSANDDIRS, 'settings_urlanddir', 'icon_urlanddir.gif');
		}

		$this->tabs['emailnotifications'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabEmailNotifications');
        $this->tabs['emailnotifications']->setAttributes('emailnotifications', L_G_EMAILNOTIFICATIONS, 'settings_emailnotifications', 'icon_emailnotifications.gif');

        $this->tabs['commissions'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabComissions');
        $this->tabs['commissions']->setAttributes('commissions' , L_G_COMMISSIONS, 'settings_commissions', 'icon_commissions.gif');

        $this->tabs['communications'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabCommunications');
        $this->tabs['communications']->setAttributes('communications', L_G_COMMUNICATION, 'settings_communications', 'icon_communications.gif');

        $this->tabs['troubleshooting'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabTroubleshooting');
        $this->tabs['troubleshooting']->setAttributes('troubleshooting', L_G_TROUBLESHOOTING, 'settings_troubleshooting', 'icon_troubleshooting.gif');

        $this->tabs['fraudprotection'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabFraudProtection');
        $this->tabs['fraudprotection']->setAttributes('fraudprotection', L_G_FRAUDPROTECTION, 'settings_fraudprotection', 'icon_fraudprotection.gif');

        $this->tabs['affsettings'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabAffSettings');
        $this->tabs['affsettings']->setAttributes('affsettings', L_G_EDITCUSTOMIZATION, 'settings_affsettings', 'icon_affsettings.gif');

        $this->tabs['cookiestracking'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabCookiesTracking');
        $this->tabs['cookiestracking']->setAttributes('cookiestracking', L_G_COOKIESANDTRACKING, 'settings_cookiestracking', 'icon_cookiestracking.gif');

        $this->tabs['bannerformat'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabBannerFormat');
        $this->tabs['bannerformat']->setAttributes('bannerformat', L_G_BANNERFORMAT, 'settings_bannerformat', 'icon_bannerformat.gif');
        
        $this->tabs['sitereplication'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabSiteReplication');
        $this->tabs['sitereplication']->setAttributes('sitereplication', L_G_SITEREPLICATION, 'settings_sitereplication', 'icon_sitereplication.gif');

		if($GLOBALS['Auth']->getSetting('Glob_acct_geo_allowed') == '1') {
        	$this->tabs['geoip'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabGeoIP');
        	$this->tabs['geoip']->setAttributes('geoip', L_G_GEOIPSETTINGS, 'settings_geoip', 'icon_geoip.gif');
		}
    }

    //--------------------------------------------------------------------------

    function initPermissions()
    {
        $this->modulePermissions['insert_payout_method'] = 'aff_tool_settings_modify';
        $this->modulePermissions['update_payout_method'] = 'aff_tool_settings_modify';
        $this->modulePermissions['insert_payout_field'] = 'aff_tool_settings_modify';
        $this->modulePermissions['update_payout_field'] = 'aff_tool_settings_modify';
        $this->modulePermissions['add_new_payout_method'] = 'aff_tool_settings_modify';
        $this->modulePermissions['edit_payout_method'] = 'aff_tool_settings_modify';
        $this->modulePermissions['delete_payout_methods'] = 'aff_tool_settings_modify';
        $this->modulePermissions['add_new_payout_field'] = 'aff_tool_settings_modify';
        $this->modulePermissions['edit_payout_field'] = 'aff_tool_settings_modify';
        $this->modulePermissions['delete_payout_fields'] = 'aff_tool_settings_modify';
        $this->modulePermissions['view'] = 'aff_tool_settings_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
		if(!empty($_REQUEST['action'])) //!empty($_POST['commited'])
        {
            switch($_REQUEST['action'])
            {
                case 'edit':
                    if($this->saveSettings())
                        return;
                    break;

                case 'testmsg':
                    $this->send_test_message();
                    break;
                    
                case 'sitereplication':
                    if ($this->saveSettings()) {
                        $this->replicatePages();
                        $_POST['action'] = $_GET['action'] = $_REQUEST['action'] = 'edit';
                        return;
                    }
                    break;
            }
        }

        $this->showSettings();
    }

    //------------------------------------------------------------------------

    function saveSettings()
    {
        if(is_array($GLOBALS['Auth']->permissions) && count($GLOBALS['Auth']->permissions) > 0)
        {
            if(!in_array('aff_tool_settings_modify', $GLOBALS['Auth']->permissions))
            {
                $this->showSettings(true);
                return true;
            }
        }

        $data = $this->protectData();
        $errorTabs = array();
        $errorMessages = array();

        $processedData = array();
        foreach ($this->tabs as $tab) {
            QUnit_Messager::resetMessages();
            $newData = $tab->process($data);
            $errorMessages = array_merge($errorMessages, QUnit_Messager::getErrorMessages());
            if($newData === false)
            {
                if(QUnit_Messager::getErrorMessage() == '')
                    QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);

                $errorTabs[] = $tab->name;
            }
            if (!is_array($newData)) $newData = array();
        	$processedData = array_merge($processedData, $newData);
        }

        QUnit_Messager::resetMessages();
        foreach ($errorMessages as $msg) {
            QUnit_Messager::setErrorMessage($msg);
        }

        if(count($errorTabs) != 0) {
            $_REQUEST['setting_tab_sheet'] = $errorTabs[0];
            $this->showSettings(false, $errorTabs);
            return true;
        }

        if($processedData === false || QUnit_Messager::getErrorMessage() != '')
        {
            if(QUnit_Messager::getErrorMessage() == '')
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);

            $this->showSettings(false, $errorTabs);
        }
        else
        {
//             if(AFF_DEMO == 1) {
//                 $processedData = array();
//                 foreach ($this->tabs as $tab) {
//             	   $processedData = array_merge($processedData, $tab->demoProcess($data));
//                 }
//             }

            $this->saveProcessData($processedData);

            $this->showSettings(true);
        }

        return true;
    }

    //------------------------------------------------------------------------

    function saveProcessData($processedData)
    {
        if(is_array($processedData) && count($processedData)>0)
        {
            // save change
            $error = false;
            foreach($processedData as $code => $value)
            {
                if(!QCore_Settings::_update($code, $value, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID()))
                    $error = true;
            }

            if($error)
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);
            else
                QUnit_Messager::setOkMessage(L_G_SETTINGSSAVED);

            $GLOBALS['Auth']->loadSettings();
        }
    }

    //------------------------------------------------------------------------

    function showSettings($reload = false, $errorTabs = array())
    {
        if($reload == true || $_POST['commited'] != 'yes') {
            // get settings from Auth
            $this->loadSettings();
        }

        if($_REQUEST['setting_tab_sheet'] == '')
            $_REQUEST['setting_tab_sheet'] = 'langandcur';
        if($_REQUEST['action'] == '')
            $_REQUEST['action'] = 'edit';

        $this->initTemporaryTE();
        $p_tabs = array();
        foreach ($this->tabs as $tab) {
        	$p_tabs[] = array('id'      => $tab->name,
        	                  'caption' => $tab->link,
        	                  'content' => $tab->show($this),
        	                  'error'   => (in_array($tab->name, $errorTabs) ? '1' : '0'),
        	                  'icon'    => $tab->icon);
        }

        $this->assign('a_tabs', $p_tabs);

        $this->addContent('settings_main');

        return true;
    }


    //------------------------------------------------------------------------

    function loadSettings()
    {
        $settings = $GLOBALS['Auth']->getSettings();

        $_POST['tiers_visible_to_user'] = $settings['Aff_tiers_visible_to_user'];
        $_POST['newsletter_signup_enabled'] = $settings['Aff_newsletter_signup_enabled'];
        $_POST['newsletter_signup_email'] = $settings['Aff_newsletter_signup_email'];
        $_POST['show_minihelp'] = $settings['Aff_show_minihelp'];
        $_POST['support_signup_commissions'] = $settings['Aff_support_signup_commissions'];
        $_POST['support_referral_commissions'] = $settings['Aff_support_referral_commissions'];
        $_POST['support_cpm_commissions'] = $settings['Aff_support_cpm_commissions'];
        $_POST['support_click_commissions'] = $settings['Aff_support_click_commissions'];
        $_POST['support_sale_commissions'] = $settings['Aff_support_sale_commissions'];
        $_POST['support_lead_commissions'] = $settings['Aff_support_lead_commissions'];
        $_POST['support_recurring_commissions'] = $settings['Aff_support_recurring_commissions'];
        $_POST['support_refund_commissions'] = $settings['Aff_support_refund_commissions'];
        $_POST['support_chargeback_commissions'] = $settings['Aff_support_chargeback_commissions'];
        $_POST['main_site_url'] = $settings['Aff_main_site_url'];
        $_POST['resources_dir'] = myslashes($settings['Aff_resources_dir']);
        $_POST['export_dir'] = myslashes($settings['Aff_export_dir']);
        $_POST['export_url'] = $settings['Aff_export_url'];
        $_POST['banners_dir'] = myslashes($settings['Aff_banners_dir']);
        $_POST['banners_url'] = $settings['Aff_banners_url'];
        $_POST['scripts_url'] = $settings['Aff_scripts_url'];
        $_POST['signup_url'] = $settings['Aff_signup_url'];
        $_POST['system_email'] = $settings['Aff_system_email'];
        $_POST['system_email_name'] = $settings['Aff_system_email_name'];
        $_POST['system_currency'] = $settings['Aff_system_currency'];
        $_POST['default_lang'] = $settings['Aff_default_lang'];
        $_POST['allow_choose_lang'] = $settings['Aff_allow_choose_lang'];
        $_POST['login_protection_retries'] = $settings['Aff_login_protection_retries'];
        $_POST['login_protection_delay'] = $settings['Aff_login_protection_delay'];
        $_POST['min_payout_options'] = $settings['Aff_min_payout_options'];
        $_POST['initial_min_payout'] = $settings['Aff_initial_min_payout'];
        $_POST['declinefrequentclicks'] = $settings['Aff_declinefrequentclicks'];
        $_POST['frequentclicks'] = $settings['Aff_frequentclicks'];
        $_POST['declinefrequentsales'] = $settings['Aff_declinefrequentsales'];
        $_POST['frequentsales'] = $settings['Aff_frequentsales'];
        $_POST['declinesameorderid'] = $settings['Aff_declinesameorderid'];
        $_POST['clickfrequency'] = $settings['Aff_clickfrequency'];
        $_POST['salefrequency'] = $settings['Aff_salefrequency'];
        $_POST['saleorderidfrequency'] = $settings['Aff_saleorderidfrequency'];
        $_POST['link_style'] = $settings['Aff_link_style'];
        $_POST['email_onaffsignup'] = $settings['Aff_email_onaffsignup'];
        $_POST['email_onsale'] = $settings['Aff_email_onsale'];
        $_POST['email_dailyreport'] = $settings['Aff_email_dailyreport'];
        $_POST['email_merch_dailyreport'] = $settings['Aff_email_merch_dailyreport'];
        $_POST['email_weeklyreport'] = $settings['Aff_email_weeklyreport'];
        $_POST['email_merch_weeklyreport'] = $settings['Aff_email_merch_weeklyreport'];
        $_POST['email_weekstarts'] = $settings['Aff_email_weekstarts'];
        $_POST['email_weeklysendday'] = $settings['Aff_email_weeklysendday'];
        $_POST['email_monthlyreport'] = $settings['Aff_email_monthlyreport'];
        $_POST['email_merch_monthlyreport'] = $settings['Aff_email_merch_monthlyreport'];
        $_POST['email_monthlysendday'] = $settings['Aff_email_monthlysendday'];
        $_POST['email_recurringtrangenerated'] = $settings['Aff_email_recurringtrangenerated'];
        $_POST['notifications_email'] = $settings['Aff_notifications_email'];
        $_POST['forcecommfromproductid'] = $settings['Aff_forcecommfromproductid'];
        $_POST['maxcommissionlevels'] = $settings['Aff_maxcommissionlevels'];
        $_POST['affiliateapproval'] = $settings['Aff_affiliateapproval'];
        $_POST['afflogouturl'] = $settings['Aff_afflogouturl'];
        $_POST['affpostsignupurl'] = $settings['Aff_affpostsignupurl'];
        $_POST['debug_trans'] = $settings['Aff_debug_trans'];
        $_POST['p3p_xml'] = $settings['Aff_p3p_xml'];
        $_POST['p3p_compact'] = $settings['Aff_p3p_compact'];
        $_POST['track_by_ip'] = $settings['Aff_track_by_ip'];
        $_POST['track_by_browser'] = $settings['Aff_track_by_browser'];
        $_POST['ip_validity'] = $settings['Aff_ip_validity'];
        $_POST['ip_validity_type'] = $settings['Aff_ip_validity_type'];
        $_POST['track_by_session'] = $settings['Aff_track_by_session'];
        $_POST['apply_from_banner'] = $settings['Aff_apply_from_banner'];
        $_POST['fixed_cost'] = $settings['Aff_fixed_cost'];
        $_POST['fixed_cost_unit'] = $settings['Aff_fixed_cost_unit'];
        $_POST['log_level'] = $settings['Aff_log_level'];
        $_POST['debug_emails'] = $settings['Aff_debug_emails'];
        $_POST['debug_impressions'] = $settings['Aff_debug_impressions'];
        $_POST['debug_clicks'] = $settings['Aff_debug_clicks'];
        $_POST['debug_sales'] = $settings['Aff_debug_sales'];
        $_POST['join_campaign'] = $settings['Aff_join_campaign'];
        $_POST['nonreferred_signup'] = $settings['Aff_nonreferred_signup'];
        $_POST['display_news'] = $settings['Aff_display_news'];
        $_POST['display_resources'] = $settings['Aff_display_resources'];
        $_POST['display_forum'] = $settings['Aff_display_forum'];
        $_POST['display_banner_stats_all'] = $settings['Aff_display_banner_stats_all'];
        $_POST['matrix_height'] = $settings['Aff_matrix_height'];
        $_POST['matrix_width'] = $settings['Aff_matrix_width'];
        $_POST['use_forced_matrix'] = $settings['Aff_use_forced_matrix'];
        $_POST['matrix_forced_user'] = $settings['Aff_matrix_forced_user'];
        $_POST['round_numbers'] = $settings['Aff_round_numbers'];
        $_POST['currency_left_position'] = $settings['Aff_currency_left_position'];
        $_POST['program_signup_bonus'] = $settings['Aff_program_signup_bonus'];
        $_POST['program_referral_commission'] = $settings['Aff_program_referral_commission'];
        $_POST['overwrite_cookie'] = $settings['Aff_overwrite_cookie'];
        $_POST['delete_cookie'] = $settings['Aff_delete_cookie'];
        $_POST['referred_affiliate_allow'] = $settings['Aff_referred_affiliate_allow'];
        $_POST['referred_affiliate'] = $settings['Aff_referred_affiliate'];
        $_POST['dont_display_click_transaction'] = $settings['Aff_dont_display_click_transaction'];
        $_POST['dont_save_click_transaction'] = $settings['Aff_dont_save_click_transaction'];
        $_POST['permanent_redirect'] = $settings['Aff_permanent_redirect'];
        $_POST['st2userbonuscommission'] = $settings['Aff_program_signup_bonus_2tr'];
        $_POST['st3userbonuscommission'] = $settings['Aff_program_signup_bonus_3tr'];
        $_POST['st4userbonuscommission'] = $settings['Aff_program_signup_bonus_4tr'];
        $_POST['st5userbonuscommission'] = $settings['Aff_program_signup_bonus_5tr'];
        $_POST['st6userbonuscommission'] = $settings['Aff_program_signup_bonus_6tr'];
        $_POST['st7userbonuscommission'] = $settings['Aff_program_signup_bonus_7tr'];
        $_POST['st8userbonuscommission'] = $settings['Aff_program_signup_bonus_8tr'];
        $_POST['st9userbonuscommission'] = $settings['Aff_program_signup_bonus_9tr'];
        $_POST['st10userbonuscommission'] = $settings['Aff_program_signup_bonus_10tr'];
        $_POST['mail_send_type'] = $settings['Aff_mail_send_type'];
        if($_POST['mail_send_type'] == '') $_POST['mail_send_type'] = EMAILBY_MAIL;
        $_POST['mail_type'] = $settings['Aff_mail_type'];
        if($_POST['mail_type'] == '') $_POST['mail_type'] = MAIL_TEXT;
        $_POST['mail_charset'] = $settings['Aff_mail_charset'];
        $_POST['mail_charset_other'] = $settings['Aff_mail_charset_other'];
        $_POST['smtp_server'] = $settings['Aff_smtp_server'];
        $_POST['smtp_server_port'] = $settings['Aff_smtp_server_port'];
        $_POST['smtp_server_tls'] = $settings['Aff_smtp_server_tls'];
        $_POST['smtp_username'] = $settings['Aff_smtp_username'];
        $_POST['smtp_password'] = $settings['Aff_smtp_password'];
        $_POST['signup_terms_conditions'] = $settings['Aff_signup_terms_conditions'];
        $_POST['signup_force_acceptance'] = $settings['Aff_signup_force_acceptance'];
        $_POST['signup_affect_editing'] = $settings['Aff_signup_affect_editing'];
        $_POST['signup_display_terms'] = $settings['Aff_signup_display_terms'];
        $_POST['signup_username'] = $settings['Aff_signup_username'];
        $_POST['signup_name'] = $settings['Aff_signup_name'];
        $_POST['signup_surname'] = $settings['Aff_signup_surname'];
        $_POST['signup_street'] = $settings['Aff_signup_street'];
        $_POST['signup_street_mandatory'] = $settings['Aff_signup_street_mandatory'];
        $_POST['signup_city'] = $settings['Aff_signup_city'];
        $_POST['signup_city_mandatory'] = $settings['Aff_signup_city_mandatory'];
        $_POST['signup_country'] = $settings['Aff_signup_country'];
        $_POST['signup_country_mandatory'] = $settings['Aff_signup_country_mandatory'];
        $_POST['signup_company_name'] = $settings['Aff_signup_company_name'];
        $_POST['signup_company_name_mandatory'] = $settings['Aff_signup_company_name_mandatory'];
        $_POST['signup_state'] = $settings['Aff_signup_state'];
        $_POST['signup_state_mandatory'] = $settings['Aff_signup_state_mandatory'];
        $_POST['signup_zipcode'] = $settings['Aff_signup_zipcode'];
        $_POST['signup_zipcode_mandatory'] = $settings['Aff_signup_zipcode_mandatory'];
        $_POST['signup_weburl'] = $settings['Aff_signup_weburl'];
        $_POST['signup_weburl_mandatory'] = $settings['Aff_signup_weburl_mandatory'];
        $_POST['signup_phone'] = $settings['Aff_signup_phone'];
        $_POST['signup_phone_mandatory'] = $settings['Aff_signup_phone_mandatory'];
        $_POST['signup_fax'] = $settings['Aff_signup_fax'];
        $_POST['signup_fax_mandatory'] = $settings['Aff_signup_fax_mandatory'];
        $_POST['signup_tax_ssn'] = $settings['Aff_signup_tax_ssn'];
        $_POST['signup_tax_ssn_mandatory'] = $settings['Aff_signup_tax_ssn_mandatory'];
        $_POST['signup_data1'] = $settings['Aff_signup_data1'];
        $_POST['signup_data1_mandatory'] = $settings['Aff_signup_data1_mandatory'];
        $_POST['signup_data1_name'] = $settings['Aff_signup_data1_name'];
        $_POST['signup_data2'] = $settings['Aff_signup_data2'];
        $_POST['signup_data2_mandatory'] = $settings['Aff_signup_data2_mandatory'];
        $_POST['signup_data2_name'] = $settings['Aff_signup_data2_name'];
        $_POST['signup_data3'] = $settings['Aff_signup_data3'];
        $_POST['signup_data3_mandatory'] = $settings['Aff_signup_data3_mandatory'];
        $_POST['signup_data3_name'] = $settings['Aff_signup_data3_name'];
        $_POST['signup_data4'] = $settings['Aff_signup_data4'];
        $_POST['signup_data4_mandatory'] = $settings['Aff_signup_data4_mandatory'];
        $_POST['signup_data4_name'] = $settings['Aff_signup_data4_name'];
        $_POST['signup_data5'] = $settings['Aff_signup_data5'];
        $_POST['signup_data5_mandatory'] = $settings['Aff_signup_data5_mandatory'];
        $_POST['signup_data5_name'] = $settings['Aff_signup_data5_name'];
        $_POST['signup_refid'] = $settings['Aff_signup_refid'];
        $_POST['signup_refid_mandatory'] = $settings['Aff_signup_refid_mandatory'];
        $_POST['bannerformat_textformat'] = $settings['Aff_bannerformat_textformat'];
        $_POST['bannerformat_graphicsformat'] = $settings['Aff_bannerformat_graphicformat'];
        $_POST['blockimps'] = $settings['Aff_blockimps'];
        $_POST['blockimps_time'] = $settings['Aff_blockimps_time'];
        $_POST['blockimps_timeunit'] = $settings['Aff_blockimps_timeunit'];
        $_POST['signup_automatic_form'] = $settings['Aff_signup_automatic_form'];
        $_POST['pp_username'] = $settings['Aff_pp_username'];
        $_POST['pp_password'] = $settings['Aff_pp_password'];
        $_POST['pp_periodicity'] = $settings['Aff_pp_periodicity'];
        $_POST['pp_dayofpay'] = $settings['Aff_pp_dayofpay'];
        $_POST['pp_currency'] = $settings['Aff_pp_currency'];
        $_POST['pp_emailsubject'] = $settings['Aff_pp_emailsubject'];
        $_POST['mail_encode_subject'] = $settings['Aff_mail_encode_subject'];
        $_POST['signup_description'] = $settings['Aff_signup_description'];
        $_POST['signup_display_description'] = $settings['Aff_signup_display_description'];
        $_POST['recurringrealcommissions'] = $settings['Aff_recurringrealcommissions'];

        $_POST['use_custom_login'] = $settings['Aff_use_custom_login'];
        $_POST['custom_header'] = $settings['Aff_custom_login_header'];
        $_POST['custom_footer'] = $settings['Aff_custom_login_footer'];
        $_POST['dynamic_link_domains'] = $settings['Aff_dynamic_link_domains'];
        
        $_POST['sr_enable'] = $settings['Aff_replication_enable'];
        $_POST['sr_directory'] = $settings['Aff_replication_dir'];
        $_POST['sr_directoryurl'] = $settings['Aff_replication_url'];
        $_POST['sr_template'] = $settings['Aff_replication_template'];
    }

    //------------------------------------------------------------------------

    function protectData()
    {
        // protect against script injection

        $data = array();

        $data['tiers_visible_to_user'] = preg_replace('/[^0-9]/', '', $_POST['tiers_visible_to_user']);
        $data['newsletter_signup_enabled'] = preg_replace('/[^0-1]/', '', $_POST['newsletter_signup_enabled']);
        $data['newsletter_signup_email'] = preg_replace('/[\"\']/', '', $_POST['newsletter_signup_email']);
        $data['show_minihelp'] = preg_replace('/[^0-1]/', '', $_POST['show_minihelp']);
        $data['support_signup_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_signup_commissions']);
        $data['support_referral_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_referral_commissions']);
        $data['support_cpm_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_cpm_commissions']);
        $data['support_click_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_click_commissions']);
        $data['support_sale_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_sale_commissions']);
        $data['support_lead_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_lead_commissions']);
        $data['support_recurring_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_recurring_commissions']);
        $data['support_refund_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_refund_commissions']);
        $data['support_chargeback_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_chargeback_commissions']);
        $data['main_site_url'] = preg_replace('/[\"\']/', '', $_POST['main_site_url']);
        $data['resources_dir'] = preg_replace('/[\"\']/', '', $_POST['resources_dir']);
        $data['export_dir'] = preg_replace('/[\"\']/', '', $_POST['export_dir']);
        $data['export_url'] = preg_replace('/[\"\']/', '', $_POST['export_url']);
        $data['banners_dir'] = preg_replace('/[\"\']/', '', $_POST['banners_dir']);
        $data['banners_url'] = preg_replace('/[\"\']/', '', $_POST['banners_url']);
        $data['scripts_url'] = preg_replace('/[\"\']/', '', $_POST['scripts_url']);
        $data['signup_url'] = preg_replace('/[\"\']/', '', $_POST['signup_url']);
        $data['system_email'] = preg_replace('/[\"\']/', '', $_POST['system_email']);
        $data['system_email_name'] = preg_replace('/[\"\']/', '', $_POST['system_email_name']);
        $data['system_currency'] = preg_replace('/[\"\']/', '', $_POST['system_currency']);
        $data['default_lang'] = preg_replace('/[\"\']/', '', $_POST['default_lang']);
        $data['allow_choose_lang'] = preg_replace('/[\"\']/', '', $_POST['allow_choose_lang']);
        $data['login_protection_retries'] = preg_replace('/[^0-9]/', '', $_POST['login_protection_retries']);
        $data['login_protection_delay'] = preg_replace('/[^0-9]/', '', $_POST['login_protection_delay']);
        $data['min_payout_options'] = preg_replace('/[^0-9\; ]/', '', $_POST['min_payout_options']);
        $data['initial_min_payout'] = preg_replace('/[^0-9]/', '', $_POST['initial_min_payout']);
        $data['declinefrequentclicks'] = preg_replace('/[^0-1]/', '', $_POST['declinefrequentclicks']);
        $data['frequentclicks'] = preg_replace('/[^0-2]/', '', $_POST['frequentclicks']);
        $data['declinefrequentsales'] = preg_replace('/[^0-1]/', '', $_POST['declinefrequentsales']);
        $data['frequentsales'] = preg_replace('/[^0-2]/', '', $_POST['frequentsales']);
        $data['declinesameorderid'] = preg_replace('/[^0-1]/', '', $_POST['declinesameorderid']);
        $data['clickfrequency'] = preg_replace('/[^0-9]/', '', $_POST['clickfrequency']);
        $data['salefrequency'] = preg_replace('/[^0-9]/', '', $_POST['salefrequency']);
        $data['saleorderidfrequency'] = preg_replace('/[^0-9]/', '', $_POST['saleorderidfrequency']);
        $data['link_style'] = preg_replace('/[^0-9]/', '', $_POST['link_style']);
        $data['email_onaffsignup'] = preg_replace('/[^0-9]/', '', $_POST['email_onaffsignup']);
        $data['email_onsale'] = preg_replace('/[^0-9]/', '', $_POST['email_onsale']);
        $data['email_dailyreport'] = preg_replace('/[^0-9]/', '', $_POST['email_dailyreport']);
        $data['email_merch_dailyreport'] = preg_replace('/[^0-9]/', '', $_POST['email_merch_dailyreport']);
        $data['email_weeklyreport'] = preg_replace('/[^0-9]/', '', $_POST['email_weeklyreport']);
        $data['email_merch_weeklyreport'] = preg_replace('/[^0-9]/', '', $_POST['email_merch_weeklyreport']);
        $data['email_weekstarts'] = preg_replace('/[^0-9]/', '', $_POST['email_weekstarts']);
        $data['email_weeklysendday'] = preg_replace('/[^0-9]/', '', $_POST['email_weeklysendday']);
        $data['email_monthlyreport'] = preg_replace('/[^0-9]/', '', $_POST['email_monthlyreport']);
        $data['email_merch_monthlyreport'] = preg_replace('/[^0-9]/', '', $_POST['email_merch_monthlyreport']);
        $data['email_monthlysendday'] = preg_replace('/[^0-9]/', '', $_POST['email_monthlysendday']);
        $data['email_recurringtrangenerated'] = preg_replace('/[^0-9]/', '', $_POST['email_recurringtrangenerated']);
        $data['notifications_email'] = preg_replace('/[\"\']/', '', $_POST['notifications_email']);
        $data['forcecommfromproductid'] = preg_replace('/[\"\']/', '', $_POST['forcecommfromproductid']);
        $data['maxcommissionlevels'] = preg_replace('/[^0-9]/', '', $_POST['maxcommissionlevels']);
        $data['affiliateapproval'] = preg_replace('/[^0-9]/', '', $_POST['affiliateapproval']);
        $data['afflogouturl'] = preg_replace('/[\"\']/', '', $_POST['afflogouturl']);
        $data['affpostsignupurl'] = preg_replace('/[\"\']/', '', $_POST['affpostsignupurl']);
        $data['p3p_xml'] = preg_replace('/[\"\']/', '', $_POST['p3p_xml']);
        $data['p3p_compact'] = preg_replace('/[\"\']/', '', $_POST['p3p_compact']);
        $data['track_by_ip'] = preg_replace('/[^0-1]/', '', $_POST['track_by_ip']);
        $data['track_by_browser'] = preg_replace('/[^0-1]/', '', $_POST['track_by_browser']);
        $data['ip_validity'] = preg_replace('/[^0-9]/', '', $_POST['ip_validity']);
        $data['ip_validity_type'] = preg_replace('/[\"\']/', '', $_POST['ip_validity_type']);
        $data['track_by_session'] = preg_replace('/[^0-1]/', '', $_POST['track_by_session']);
        $data['apply_from_banner'] = preg_replace('/[^0-1]/', '', $_POST['apply_from_banner']);
        $data['fixed_cost'] = preg_replace('/[\'\"]/', '', $_POST['fixed_cost']);
        $data['fixed_cost_unit'] = preg_replace('/[\'\"]/', '', $_POST['fixed_cost_unit']);
        $data['log_level_element'] = preg_replace('/[\'\"]/', '', $_POST['log_level_element']);
        $data['debug_emails'] = preg_replace('/[^0-1]/', '', $_POST['debug_emails']);
        $data['debug_impressions'] = preg_replace('/[^0-1]/', '', $_POST['debug_impressions']);
        $data['debug_clicks'] = preg_replace('/[^0-1]/', '', $_POST['debug_clicks']);
        $data['debug_sales'] = preg_replace('/[^0-1]/', '', $_POST['debug_sales']);
        $data['join_campaign'] = preg_replace('/[^0-1]/', '', $_POST['join_campaign']);
        $data['nonreferred_signup'] = preg_replace('/[\'\"]/', '', $_POST['nonreferred_signup']);
        $data['display_news'] = preg_replace('/[^0-1]/', '', $_POST['display_news']);
        $data['display_resources'] = preg_replace('/[^0-1]/', '', $_POST['display_resources']);
		$data['display_forum'] = preg_replace('/[^0-1]/', '', $_POST['display_forum']);
        $data['display_banner_stats_all'] = preg_replace('/[^0-1]/', '', $_POST['display_banner_stats_all']);
        $data['matrix_height'] = preg_replace('/[^0-9]/', '', $_POST['matrix_height']);
        $data['matrix_width'] = preg_replace('/[^0-9]/', '', $_POST['matrix_width']);
        $data['matrix_width'] = preg_replace('/[^0-9]/', '', $_POST['matrix_width']);
        $data['use_forced_matrix'] = preg_replace('/[^0-1]/', '', $_POST['use_forced_matrix']);
        $data['matrix_forced_user'] = preg_replace('/[\'\"]/', '', $_POST['matrix_forced_user']);
        $data['round_numbers'] = preg_replace('/[^0-9]/', '', $_POST['round_numbers']);
        $data['currency_left_position'] = preg_replace('/[^0-9]/', '', $_POST['currency_left_position']);
        $data['program_signup_bonus'] = preg_replace('/[\'\"]/', '', $_POST['program_signup_bonus']);
        $data['program_referral_commission'] = preg_replace('/[\'\"]/', '', $_POST['program_referral_commission']);
        $data['recurringrealcommissions'] = preg_replace('/[\'\"]/', '', $_POST['recurringrealcommissions']);
        $data['psheet'] = preg_replace('/[\'\"]/', '', $_POST['sheet']);
        $data['overwrite_cookie'] = preg_replace('/[^0-1]/', '', $_POST['overwrite_cookie']);
        $data['delete_cookie'] = preg_replace('/[^0-1]/', '', $_POST['delete_cookie']);
        $data['referred_affiliate_allow'] = preg_replace('/[^0-1]/', '', $_POST['referred_affiliate_allow']);
        $data['referred_affiliate'] = preg_replace('/[\'\"]/', '', $_POST['referred_affiliate']);
        $data['dont_display_click_transaction'] = preg_replace('/[^0-9]/', '', $_POST['dont_display_click_transaction']);
        $data['dont_save_click_transaction'] = preg_replace('/[^0-9]/', '', $_POST['dont_save_click_transaction']);
        $data['permanent_redirect'] = preg_replace('/[\'\"]/', '', $_POST['permanent_redirect']);
        $data['st2userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st2userbonuscommission']);
        $data['st3userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st3userbonuscommission']);
        $data['st4userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st4userbonuscommission']);
        $data['st5userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st5userbonuscommission']);
        $data['st6userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st6userbonuscommission']);
        $data['st7userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st7userbonuscommission']);
        $data['st8userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st8userbonuscommission']);
        $data['st9userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st9userbonuscommission']);
        $data['st10userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st10userbonuscommission']);
        $data['mail_send_type'] = preg_replace('/[^0-9]/', '', $_POST['mail_send_type']);
        $data['mail_type'] = preg_replace('/[^0-9]/', '', $_POST['mail_type']);
        $data['mail_charset'] = preg_replace('/[\'\"]/', '', $_POST['mail_charset']);
        $data['mail_charset_other'] = preg_replace('/[\'\"]/', '', $_POST['mail_charset_other']);
        $data['smtp_server'] = preg_replace('/[\'\"]/', '', $_POST['smtp_server']);
        $data['smtp_server_port'] = preg_replace('/[\'\"]/', '', $_POST['smtp_server_port']);
        $data['smtp_server_tls'] = preg_replace('/[\'\"]/', '', $_POST['smtp_server_tls']);
        $data['smtp_username'] = preg_replace('/[\'\"]/', '', $_POST['smtp_username']);
        $data['smtp_password'] = preg_replace('/[\'\"]/', '', $_POST['smtp_password']);
        $data['signup_terms_conditions'] = stripslashes($_POST['signup_terms_conditions']);
        $data['signup_display_terms'] = preg_replace('/[^0-1]/', '', $_POST['signup_display_terms']);
        $data['signup_force_acceptance'] = preg_replace('/[^0-1]/', '', $_POST['signup_force_acceptance']);
        $data['signup_affect_editing'] = preg_replace('/[^0-1]/', '', $_POST['signup_affect_editing']);
        $data['signup_username'] = preg_replace('/[^0-1]/', '', $_POST['signup_username']);
        $data['signup_name'] = preg_replace('/[^0-1]/', '', $_POST['signup_name']);
        $data['signup_surname'] = preg_replace('/[^0-1]/', '', $_POST['signup_surname']);
        $data['signup_street'] = preg_replace('/[^0-1]/', '', $_POST['signup_street']);
        $data['signup_street_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_street_mandatory']);
        $data['signup_city'] = preg_replace('/[^0-1]/', '', $_POST['signup_city']);
        $data['signup_city_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_city_mandatory']);
        $data['signup_country'] = preg_replace('/[^0-1]/', '', $_POST['signup_country']);
        $data['signup_country_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_country_mandatory']);
        $data['signup_company_name'] = preg_replace('/[\'\"]/', '', $_POST['signup_company_name']);
        $data['signup_company_name_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_company_name_mandatory']);
        $data['signup_state'] = preg_replace('/[^0-1]/', '', $_POST['signup_state']);
        $data['signup_state_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_state_mandatory']);
        $data['signup_zipcode'] = preg_replace('/[^0-1]/', '', $_POST['signup_zipcode']);
        $data['signup_zipcode_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_zipcode_mandatory']);
        $data['signup_weburl'] = preg_replace('/[^0-1]/', '', $_POST['signup_weburl']);
        $data['signup_weburl_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_weburl_mandatory']);
        $data['signup_phone'] = preg_replace('/[^0-1]/', '', $_POST['signup_phone']);
        $data['signup_phone_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_phone_mandatory']);
        $data['signup_fax'] = preg_replace('/[^0-1]/', '', $_POST['signup_fax']);
        $data['signup_fax_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_fax_mandatory']);
        $data['signup_tax_ssn'] = preg_replace('/[^0-1]/', '', $_POST['signup_tax_ssn']);
        $data['signup_tax_ssn_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_tax_ssn_mandatory']);
        $data['signup_data1'] = preg_replace('/[^0-1]/', '', $_POST['signup_data1']);
        $data['signup_data1_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_data1_mandatory']);
        $data['signup_data1_name'] = preg_replace('/[\'\"]/', '', $_POST['signup_data1_name']);
        $data['signup_data2'] = preg_replace('/[^0-1]/', '', $_POST['signup_data2']);
        $data['signup_data2_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_data2_mandatory']);
        $data['signup_data2_name'] = preg_replace('/[\'\"]/', '', $_POST['signup_data2_name']);
        $data['signup_data3'] = preg_replace('/[^0-1]/', '', $_POST['signup_data3']);
        $data['signup_data3_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_data3_mandatory']);
        $data['signup_data3_name'] = preg_replace('/[\'\"]/', '', $_POST['signup_data3_name']);
        $data['signup_data4'] = preg_replace('/[^0-1]/', '', $_POST['signup_data4']);
        $data['signup_data4_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_data4_mandatory']);
        $data['signup_data4_name'] = preg_replace('/[\'\"]/', '', $_POST['signup_data4_name']);
        $data['signup_data5'] = preg_replace('/[^0-1]/', '', $_POST['signup_data5']);
        $data['signup_data5_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_data5_mandatory']);
        $data['signup_data5_name'] = preg_replace('/[\'\"]/', '', $_POST['signup_data5_name']);
        $data['signup_refid'] = preg_replace('/[^0-1]/', '', $_POST['signup_refid']);
        $data['signup_refid_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_refid_mandatory']);
        $data['bannerformat_textformat'] = preg_replace('/[\'\"]/', '"', $_POST['bannerformat_textformat']);
        $data['bannerformat_graphicsformat'] = preg_replace('/[\'\"]/', '"', $_POST['bannerformat_graphicsformat']);
        $data['blockimps'] = preg_replace('/[^0-1]/', '', $_POST['blockimps']);
        $data['blockimps_time'] = preg_replace('/[^0-9]/', '', $_POST['blockimps_time']);
        $data['blockimps_timeunit'] = preg_replace('/[^0-9]/', '', $_POST['blockimps_timeunit']);
        $data['signup_automatic_form'] = preg_replace('/[^0-9]/', '', $_POST['signup_automatic_form']);
        $data['pp_username'] = preg_replace('/[\'\"]/', '', $_POST['pp_username']);
        $data['pp_password'] = preg_replace('/[\'\"]/', '', $_POST['pp_password']);
        $data['pp_periodicity'] = preg_replace('/[^0-9]/', '', $_POST['pp_periodicity']);
        $data['pp_weekdayofpay'] = preg_replace('/[^0-9]/', '', $_POST['pp_weekdayofpay']);
        $data['pp_monthdayofpay1'] = preg_replace('/[^0-9]/', '', $_POST['pp_monthdayofpay1']);
        $data['pp_monthdayofpay2'] = preg_replace('/[^0-9]/', '', $_POST['pp_monthdayofpay2']);
        $data['pp_monthdayofpay3'] = preg_replace('/[^0-9]/', '', $_POST['pp_monthdayofpay3']);
        $data['pp_monthdayofpay4'] = preg_replace('/[^0-9]/', '', $_POST['pp_monthdayofpay4']);
        $data['pp_currency'] = preg_replace('/[\'\"]/', '', $_POST['pp_currency']);
        $data['pp_emailsubject'] = preg_replace('/[\'\"]/', '', $_POST['pp_emailsubject']);
        $data['mail_encode_subject'] = preg_replace('/[^0-9]/', '', $_POST['mail_encode_subject']);
        $data['signup_description'] = stripslashes($_POST['signup_description']);
        $data['signup_display_description'] = preg_replace('/[^0-1]/', '', $_POST['signup_display_description']);
        $data['use_custom_login'] = preg_replace('/[^0-1]/', '', $_POST['use_custom_login']);
        $data['custom_header'] = stripslashes($_POST['custom_header']);
        $data['custom_footer'] = stripslashes($_POST['custom_footer']);
        $data['dynamic_link_domains'] = preg_replace('/[\'\"]/', '', $_POST['dynamic_link_domains']);
        
        $data['sr_enable'] = preg_replace('/[^0-1]/', '', $_POST['sr_enable']);
        $data['sr_directory'] = preg_replace('/[\"\']/', '', $_POST['sr_directory']);
        $data['sr_directoryurl'] = preg_replace('/[\"\']/', '', $_POST['sr_directoryurl']);
        $data['sr_template'] = stripslashes($_POST['sr_template']);

        return $data;
    }

    //------------------------------------------------------------------------

    function send_test_message() {
        unset($_REQUEST['action']);
        $_REQUEST['test_msg'] = true;;

        $objUsers =& QUnit_Global::newObj('QCore_Bl_Users');
        if (($user = $objUsers->getUserData($GLOBALS['Auth']->userID)) == false) {
            return false;
        }

        $params['accountid']    = $GLOBALS['Auth']->getAccountID();
        $params['subject']      = L_G_SMTPTESTMSGSUBJECT;
        $params['text']         = L_G_SMTPTESTMSGTEXT;
        $params['message_type'] = MESSAGETYPE_EMAIL;
        $params['userid']       = $GLOBALS['Auth']->userID;
        $params['email']        = $_REQUEST['system_email'];
        $params['settings']     = $GLOBALS['Auth']->getSettings();

        $params['default_smtp_server'] = false;

        $params['settings']['Aff_mail_encode_subject'] = $_REQUEST['mail_encode_subject'];

        $params['settings']['Aff_smtp_server_port'] = $_REQUEST['smtp_server_port'];
        $params['settings']['Aff_smtp_server_tls']  = $_REQUEST['smtp_server_tls'];
        $params['settings']['Aff_smtp_server']      = $_REQUEST['smtp_server'];
        $params['settings']['Aff_smtp_username']    = $_REQUEST['smtp_username'];
        if (strlen(str_replace("_", "", $_REQUEST['smtp_password'])) > 0) {
            $params['settings']['Aff_smtp_password']    = $_REQUEST['smtp_password'];
        }
        $params['settings']['Aff_mail_type']        = $_REQUEST['mail_type'];
        $params['settings']['Aff_mail_send_type']   = EMAILBY_SMTP;
        $params['settings']['Aff_mail_charset']     = $_REQUEST['mail_charset'];
        $params['settings']['Aff_system_email']     = $_REQUEST['system_email'];
        $params['settings']['Aff_system_email_name']     = $_REQUEST['system_email_name'];
        $mail =& QUnit_Global::newObj('QCore_Bl_Communications');
        $sent = $mail->sendEmailDirect($params);

        if ($sent) {
            QUnit_Messager::setOkMessage(L_G_SMTPTESTMSGSENT);
        } else {
            QUnit_Messager::setErrorMessage(L_G_SMTPTESTMSGERROR);
        }
    }
    
    //------------------------------------------------------------------------
    
    function replicatePages() {     
        $blReplicatedSite = QUnit_Global::newObj('Affiliate_Scripts_Bl_ReplicatedSite');
        if ($blReplicatedSite->createAllFiles()) {
            QUnit_Messager::setOkMessage(L_G_SITEREPLICATIONSUCCESSFUL);
        } else {
            QUnit_Messager::setErrorMessage(L_G_SITEREPLICATIONFAILED);
        }
    }
}
?>
