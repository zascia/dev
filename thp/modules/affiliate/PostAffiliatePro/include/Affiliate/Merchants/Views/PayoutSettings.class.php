<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

//require_once 'Services/PayPal.php';
//require_once 'Services/PayPal/Profile/API.php';
//require_once 'Services/PayPal/Profile/Handler.php';
//require_once 'lib/functions.inc.php';

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
  
class Affiliate_Merchants_Views_PayoutSettings extends QUnit_UI_TemplatePage
{
    var $blAffiliate;
    var $blPayoutOpts;
    
    //--------------------------------------------------------------------------
    
    function Affiliate_Merchants_Views_PayoutSettings() {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blPayoutOpts =& QUnit_Global::newObj('Affiliate_Merchants_Bl_PayoutOptions');
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_PAYOUTSETTINGS,'index.php?md=Affiliate_Merchants_Views_PayoutSettings');
    }
    
    //--------------------------------------------------------------------------    

    function initPermissions()
    {
        $this->modulePermissions['edit'] = 'aff_aff_accountingsettings_modify';
        $this->modulePermissions['view'] = 'aff_aff_accountingsettings_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['postaction']))
        {
            switch($_POST['postaction'])
            {
                case 'insert_payout_method':
                    if($this->processInsertPayoutMethod())
                        return;
                    break;

                case 'update_payout_method':
                    if($this->processUpdatePayoutMethod())
                        return;
                    break;

                case 'insert_payout_field':
                    if($this->processInsertPayoutField())
                        return;
                    break;

                case 'update_payout_field':
                    if($this->processUpdatePayoutField())
                        return;
                    break;
            }
        }

        if(!empty($_REQUEST['action'])) //!empty($_POST['commited'])
        {
            switch($_REQUEST['action'])
            {
                case 'default_invoice':
                    $this->loadDefaultInvoice();
                    break;
                    
                case 'edit':
                    if($this->saveSettings())
                        return;
                    break;

                case 'add_new_payout_method':
                    if($this->drawFormAddPayoutMethod())
                        return;
                    break;

                case 'edit_payout_method':
                    if($this->drawFormEditPayoutMethod())
                        return;
                    break;

                case 'delete_payout_methods':
                    if($this->processDeletePayoutMethods())
                        return;
                    break;

                case 'add_new_payout_field':
                    if($this->drawFormAddPayoutField())
                        return;
                    break;

                case 'edit_payout_field':
                    if($this->drawFormEditPayoutField())
                        return;
                    break;

                case 'delete_payout_fields':
                    if($this->processDeletePayoutFields())
                        return;
                    break;
            }
        }

        $this->show();
    }

    //--------------------------------------------------------------------------
    
    function loadDefaultInvoice() {
        $_POST['payout_invoice'] = L_G_DEFAULTINVOICE_TEXT;
        $_POST['payout_invoice_vat'] = L_G_DEFAULTINVOICE_TEXT;
        
        $_POST['payout_invoice_subject'] = L_G_DEFAULTINVOICESUBJECT_TEXT;
        $_POST['payout_invoice_subject_vat'] = L_G_DEFAULTINVOICESUBJECT_TEXT;
    }
    
    //--------------------------------------------------------------------------

    function drawFormEditPayoutMethod()
    {
        if($_POST['commited'] != 'yes')
        {
            $this->blPayoutOpts->loadPayoutOptionsInfo($_REQUEST['pid'], $GLOBALS['Auth']->getAccountID());
        }
        else
        {
            if(get_magic_quotes_gpc())
            {
                $_POST['exportformat'] = stripslashes($_POST['exportformat']);
                $_POST['buttonformat'] = stripslashes($_POST['buttonformat']);
            }
        }

        $_POST['header'] = L_G_EDIT_PAYOUT_METHOD;
        $_POST['action'] = 'edit_payout_method';
        $_POST['postaction'] = 'update_payout_method';

        $this->drawFormAddPayoutMethod();

        return true;
    }

    //------------------------------------------------------------------------

    function drawFormAddPayoutMethod()
    {
        if(!isset($_POST['action']))
            $_POST['action'] = 'add_new_payout_method';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'insert_payout_method';

        if(!isset($_POST['header']))
            $_POST['header'] = L_G_ADD_PAYOUT_METHOD;

        $this->addContent('payoutmethods_edit');

        return true;
    }

    //------------------------------------------------------------------------

    function drawFormEditPayoutField()
    {
        if($_POST['commited'] != 'yes')
        {
            $this->blPayoutOpts->loadPayoutFieldsInfo($_REQUEST['fid'], $GLOBALS['Auth']->getAccountID());
        }

        $_POST['header'] = L_G_EDIT_PAYOUT_FIELD;
        $_POST['action'] = 'edit_payout_field';
        $_POST['postaction'] = 'update_payout_field';

        $this->drawFormAddPayoutField();

        return true;
    }

    //------------------------------------------------------------------------

    function drawFormAddPayoutField()
    {
        if(!isset($_POST['action']))
            $_POST['action'] = 'add_new_payout_field';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'insert_payout_field';

        if($_POST['pid'] == '') $_POST['pid'] = $_REQUEST['pid'];

        if(!isset($_POST['header']))
            $_POST['header'] = L_G_ADD_PAYOUT_FIELD;

        $this->addContent('payoutfields_edit');

        return true;
    }

    //------------------------------------------------------------------------

    function saveSettings()
    {
        if(is_array($GLOBALS['Auth']->permissions) && count($GLOBALS['Auth']->permissions) > 0)
        {
            if(!in_array('aff_aff_accountingsettings_modify', $GLOBALS['Auth']->permissions))
            {
                $this->show(true);
                return true;
            }
        }

        $data = $this->protectData();

        $processedData = $this->processData($data);
        
        if($processedData === false || QUnit_Messager::getErrorMessage() != '')
        {
            if(QUnit_Messager::getErrorMessage() == '')
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);

            $this->show();
        }
        else
        {
            if(AFF_DEMO == 1) {
            	$processedData = $this->demoProcessData($data);
            }

            $this->saveProcessData($processedData);
            $this->show(true);
        }

        return true;
    }

    //------------------------------------------------------------------------

    function show($reload = false)
    {
        if ($reload || $_POST['commited'] != 'yes')
        {
            // get settings from Auth
            $this->loadSettings();
        }
        
        if(get_magic_quotes_gpc())
        {
            $_POST['payout_invoice'] = stripslashes($_POST['payout_invoice']);
            $_POST['payout_invoice_vat'] = stripslashes($_POST['payout_invoice_vat']);
            
            $_POST['payout_invoice_subject'] = stripslashes($_POST['payout_invoice_subject']);
            $_POST['payout_invoice_subject_vat'] = stripslashes($_POST['payout_invoice_subject_vat']);
        }
        
    		$this->loadPayoutMethods();
    		if ($_POST['pp_periodicity'] == PERIODICITY_WEEKLY) {
    		    $_POST['pp_weekdayofpay'] == $_POST['pp_dayofpay'];
    		} else {
    		    $tmp = explode(";", $_POST['pp_dayofpay']);
    		    for ($i = 1; $i <= 4; $i++) {
    		        $_POST['pp_monthdayofpay'.$i] = ($tmp[$i-1] == '') ? 0 : $tmp[$i-1];
    		    }
    		}
        $this->addContent('settings_payoutmethods');

        return true;
    }
    
    //------------------------------------------------------------------------

    function processDeletePayoutMethods()
    {
        $pid = preg_replace('/[\'\"]/', '', $_REQUEST['pid']);

        if(AFF_DEMO == 1 && in_array($pid, array('paypal01', 'moneyboo', 'check001', 'wiretran'))) {

        } else {
            $this->blPayoutOpts->deletePayoutMethod($pid, $GLOBALS['Auth']->getAccountID());
        }

//        $this->redirect('Affiliate_Merchants_Views_PayoutSettings');
    }

    //------------------------------------------------------------------------

    function processDeletePayoutFields()
    {
        $fid = preg_replace('/[\'\"]/', '', $_REQUEST['fid']);

        if(AFF_DEMO == 1 && in_array($fid, array('paypal01', 'moneybo1', 'check001', 'wiretra1', 'wiretra2', 'wiretra3', 'wiretra4', 'wiretra5', 'wiretra6'))) {

        } else {
            $this->blPayoutOpts->deletePayoutFields($fid);
        }

//        $this->redirect('Affiliate_Merchants_Views_PayoutSettings');
    }

    //------------------------------------------------------------------------

    function processInsertPayoutMethod()
    {
        // protect against script injection
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $plangid = preg_replace('/[\'\"]/', '', $_POST['langid']);
        $pexporttype = preg_replace('/[\'\"]/', '', $_POST['exporttype']);
        $pexportformat = $_POST['exportformat'];
        $pbuttonformat = $_POST['buttonformat'];
        $pdisabled = preg_replace('/[^0-9]/', '', $_POST['disabled']);
        $prorder = preg_replace('/[^0-9]/', '', $_POST['rorder']);
        $PayoptID = QCore_Sql_DBUnit::createUniqueID('wd_pa_payoutoptions', 'payoptid');

        // check correctness of the fields
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_EMPTYALLOWED);

        if($_POST['name'] != '' && !$this->blPayoutOpts->checkPayoutMethodExists($GLOBALS['Auth']->getAccountID(),$_POST['name']))
            QUnit_Messager::setErrorMessage(L_G_NAMEEXISTS);

        checkCorrectness($_POST['langid'], $plangid, L_G_LANGUAGE_CODE, CHECK_EMPTYALLOWED);
        //checkCorrectness($_POST['exporttype'], $pexporttype, L_G_EXPORTTYPE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['exportformat'], $pexportformat, L_G_EXPORTFORMAT, CHECK_ALLOWED);
        checkCorrectness($_POST['buttonformat'], $pbuttonformat, L_G_BUTTONFORMAT, CHECK_ALLOWED);
        checkCorrectness($_POST['disabled'], $pdisabled, L_G_STATUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['rorder'], $prorder, L_G_ORDERID, CHECK_EMPTYALLOWED | CHECK_NUMBER);

        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }
        else
        {
            $params = array('name' => $pname,
                            'langid' => $plangid,
                            'exporttype' => $pexporttype,
                            'exportformat' => $pexportformat,
                            'paybuttonformat' => $pbuttonformat,
                            'status' => $pdisabled,
                            'rorder' => $prorder,
                            'accountid' => $GLOBALS['Auth']->getAccountID(),
                            'payoptid' => $PayoptID);

            if($this->blPayoutOpts->insertPayoutMethod($params) == false) return false;

            QUnit_Messager::setOkMessage(L_G_PAYOUT_METHOD_ADDED);

            $this->closeWindow('Affiliate_Merchants_Views_PayoutSettings');
            $this->addContent('closewindow');

            return true;
        }
    }

    //------------------------------------------------------------------------

    function processInsertPayoutField()
    {
        // protect against script injection
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $plangid = preg_replace('/[\'\"]/', '', $_POST['langid']);
        $prtype = preg_replace('/[^0-9]/', '', $_POST['rtype']);
        $pmandatory = preg_replace('/[^0-9]/', '', $_POST['mandatory']);
        $pavailablevalues = preg_replace('/[\'\"]/', '', $_POST['availablevalues']);
        $prorder = preg_replace('/[^0-9]/', '', $_POST['rorder']);
        $pcode = preg_replace('/[^A-Za-z0-9_]/', '', $_POST['code']);
        $pvisible = preg_replace('/[^0-9]/', '', $_POST['visible']);
        $pvalue = preg_replace('/[\'\"]/', '', $_POST['value']);
        $PayoptID = preg_replace('/[\'\"]/', '', $_POST['pid']);
        $PayfieldID = QCore_Sql_DBUnit::createUniqueID('wd_pa_payoutfields', 'payfieldid');

        // check correctness of the fields
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_EMPTYALLOWED);
        if($_POST['name'] != '' && !$this->blPayoutOpts->checkPayoutFieldExistsInPayoutMethod($_POST['name'],$PayoptID))
            QUnit_Messager::setErrorMessage(L_G_NAMEEXISTSINTHISPAYOUTMETHOD);

        checkCorrectness($_POST['langid'], $plangid, L_G_LANGUAGE_CODE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['rtype'], $prtype, L_G_TYPE, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['mandatory'], $pmandatory, L_G_STATUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['rorder'], $prorder, L_G_ORDERID, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['availablevalues'], $pavailablevalues, L_G_AVAILABLE_VALUES, CHECK_ALLOWED);
        checkCorrectness($_POST['code'], $pcode, L_G_CODE_FOR_EXPORTFORMAT, CHECK_EMPTYALLOWED);
        //checkCorrectness($_POST['visible'], $pvisible, L_G_VISIBILITY, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['value'], $pvalue, L_G_VALUE_FOR_EXPORTFORMAT, CHECK_ALLOWED);

        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }
        else
        {
            $params = array('name' => $pname,
                            'langid' => $plangid,
                            'rtype' => $prtype,
                            'mandatory' => $pmandatory,
                            'rorder' => $prorder,
                            'availablevalues' => $pavailablevalues,
                            'code' => $pcode,
                            'visible' => $pvisible,
                            'value' => $pvalue,
                            'payoptid' => $PayoptID,
                            'payfieldid' => $PayfieldID);

            if($this->blPayoutOpts->insertPayoutField($params) == false) return false;

            QUnit_Messager::setOkMessage(L_G_PAYOUT_FIELD_ADDED);

            $this->closeWindow('Affiliate_Merchants_Views_PayoutSettings');
            $this->addContent('closewindow');

            return true;
        }
    }

    //------------------------------------------------------------------------

    function processUpdatePayoutMethod()
    {
        // protect against script injection
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $plangid = preg_replace('/[\'\"]/', '', $_POST['langid']);
        $pexporttype = preg_replace('/[\'\"]/', '', $_POST['exporttype']);
        $pexportformat = $_POST['exportformat'];
        $pbuttonformat = $_POST['buttonformat'];
        $pdisabled = preg_replace('/[^0-9]/', '', $_POST['disabled']);
        $prorder = preg_replace('/[^0-9]/', '', $_POST['rorder']);
        $PayoptID = preg_replace('/[\'\"]/', '', $_POST['pid']);

        // check correctness of the fields
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_EMPTYALLOWED);

        if($_POST['name'] != '' && !$this->blPayoutOpts->checkPayoutMethodExists($GLOBALS['Auth']->getAccountID(),$_POST['name'],$PayoptID,false))
            QUnit_Messager::setErrorMessage(L_G_NAMEEXISTS);

        if ($pexporttype == '') $pexporttype = 0;
            
        checkCorrectness($_POST['langid'], $plangid, L_G_LANGUAGE_CODE, CHECK_EMPTYALLOWED);
        //checkCorrectness($_POST['exporttype'], $pexporttype, L_G_EXPORTTYPE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['exportformat'], $pexportformat, L_G_EXPORTFORMAT, CHECK_ALLOWED);
        checkCorrectness($_POST['buttonformat'], $pbuttonformat, L_G_BUTTONFORMAT, CHECK_ALLOWED);
        checkCorrectness($_POST['disabled'], $pdisabled, L_G_STATUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['rorder'], $prorder, L_G_ORDERID, CHECK_EMPTYALLOWED | CHECK_NUMBER);

        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }
        else
        {
            $params = array('name' => $pname,
                            'langid' => $plangid,
                            'exporttype' => $pexporttype,
                            'exportformat' => $pexportformat,
                            'paybuttonformat' => $pbuttonformat,
                            'status' => $pdisabled,
                            'rorder' => $prorder,
                            'accountid' => $GLOBALS['Auth']->getAccountID(),
                            'payoptid' => $PayoptID);

            if($this->blPayoutOpts->updatePayoutMethod($params) == false) return false;

            QUnit_Messager::setOkMessage(L_G_PAYOUT_METHOD_EDITED);

            $this->closeWindow('Affiliate_Merchants_Views_PayoutSettings');
            $this->addContent('closewindow');

            return true;
        }
    }

    //------------------------------------------------------------------------

    function processUpdatePayoutField()
    {
        // protect against script injection
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $plangid = preg_replace('/[\'\"]/', '', $_POST['langid']);
        $prtype = preg_replace('/[^0-9]/', '', $_POST['rtype']);
        $pmandatory = preg_replace('/[^0-9]/', '', $_POST['mandatory']);
        $pavailablevalues = preg_replace('/[\'\"]/', '', $_POST['availablevalues']);
        $prorder = preg_replace('/[^0-9]/', '', $_POST['rorder']);
        $pcode = preg_replace('/[^A-Za-z0-9_]/', '', $_POST['code']);
        $pvisible = preg_replace('/[^0-9]/', '', $_POST['visible']);
        $pvalue = preg_replace('/[\'\"]/', '', $_POST['value']);
        $PayoptID = preg_replace('/[\'\"]/', '', $_POST['pid']);
        $PayfieldID = preg_replace('/[\'\"]/', '', $_POST['fid']);

        // check correctness of the fields
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_EMPTYALLOWED);
        if($_POST['name'] != '' && !$this->blPayoutOpts->checkPayoutFieldExistsInPayoutMethod($_POST['name'],$PayoptID,$PayfieldID))
            QUnit_Messager::setErrorMessage(L_G_NAMEEXISTSINTHISPAYOUTMETHOD);

        checkCorrectness($_POST['langid'], $plangid, L_G_LANGUAGE_CODE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['rtype'], $prtype, L_G_TYPE, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['mandatory'], $pmandatory, L_G_STATUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['rorder'], $prorder, L_G_ORDERID, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['availablevalues'], $pavailablevalues, L_G_AVAILABLE_VALUES, CHECK_ALLOWED);
        checkCorrectness($_POST['code'], $pcode, L_G_CODE_FOR_EXPORTFORMAT, CHECK_EMPTYALLOWED);
        //checkCorrectness($_POST['visible'], $pvisible, L_G_VISIBILITY, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['value'], $pvalue, L_G_VALUE_FOR_EXPORTFORMAT, CHECK_ALLOWED);

        if($pvisible == '') $pvisible = 0;
        
        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }
        else
        {
            $params = array('name' => $pname,
                            'langid' => $plangid,
                            'rtype' => $prtype,
                            'mandatory' => $pmandatory,
                            'rorder' => $prorder,
                            'availablevalues' => $pavailablevalues,
                            'code' => $pcode,
                            'visible' => $pvisible,
                            'value' => $pvalue,
                            'payoptid' => $PayoptID,
                            'payfieldid' => $PayfieldID);

            if(AFF_DEMO == 1 && in_array($PayfieldID, array('paypal01', 'moneybo1', 'check001', 'wiretra1', 'wiretra2', 'wiretra3', 'wiretra4', 'wiretra5', 'wiretra6'))) {

            } else {
                if($this->blPayoutOpts->updatePayoutField($params) == false) return false;
            }

            QUnit_Messager::setOkMessage(L_G_PAYOUT_FIELD_EDITED);

            $this->closeWindow('Affiliate_Merchants_Views_PayoutSettings');
            $this->addContent('closewindow');

            return true;
        }
    }

    //------------------------------------------------------------------------

    function loadPayoutMethods()
    {
        $payout_methods = $this->blPayoutOpts->getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID());
        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($payout_methods);
        $this->assign('a_list_data1', $list_data1);

        $payout_fields = $this->blPayoutOpts->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID());
        $this->assign('a_list_data2', $payout_fields);
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

    function loadSettings()
    {
        $settings = $GLOBALS['Auth']->getSettings();

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
        $_POST['system_currency'] = $settings['Aff_system_currency'];
        $_POST['default_lang'] = $settings['Aff_default_lang'];
        $_POST['allow_choose_lang'] = $settings['Aff_allow_choose_lang'];
        $_POST['login_protection_retries'] = $settings['Aff_login_protection_retries'];
        $_POST['login_protection_delay'] = $settings['Aff_login_protection_delay'];
        $_POST['min_payout_options'] = $settings['Aff_min_payout_options'];
        $_POST['initial_min_payout'] = $settings['Aff_initial_min_payout'];
        $_POST['payout_invoice'] = $settings['Aff_payout_invoice'];
        $_POST['payout_invoice_vat'] = $settings['Aff_payout_invoice_vat'];
        $_POST['payout_invoice_subject'] = $settings['Aff_payout_invoice_subject'];
        $_POST['payout_invoice_subject_vat'] = $settings['Aff_payout_invoice_subject_vat'];
        $_POST['declinefrequentclicks'] = $settings['Aff_declinefrequentclicks'];
        $_POST['frequentclicks'] = $settings['Aff_frequentclicks'];
        $_POST['declinefrequentsales'] = $settings['Aff_declinefrequentsales'];
        $_POST['frequentsales'] = $settings['Aff_frequentsales'];
        $_POST['declinesameorderid'] = $settings['Aff_declinesameorderid'];
        $_POST['clickfrequency'] = $settings['Aff_clickfrequency'];
        $_POST['salefrequency'] = $settings['Aff_salefrequency'];
        $_POST['link_style'] = $settings['Aff_link_style'];
        $_POST['email_onaffsignup'] = $settings['Aff_email_onaffsignup'];
        $_POST['email_onsale'] = $settings['Aff_email_onsale'];
        $_POST['email_dailyreport'] = $settings['Aff_email_dailyreport'];
        $_POST['email_monthlyreport'] = $settings['Aff_email_monthlyreport'];
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
        $_POST['ip_validity'] = $settings['Aff_ip_validity'];
        $_POST['ip_validity_type'] = $settings['Aff_ip_validity_type'];
        $_POST['track_by_session'] = $settings['Aff_track_by_session'];
        $_POST['apply_from_banner'] = $settings['Aff_apply_from_banner'];
        $_POST['fixed_cost'] = $settings['Aff_fixed_cost'];
        $_POST['log_level'] = $settings['Aff_log_level'];
        $_POST['debug_emails'] = $settings['Aff_debug_emails'];
        $_POST['debug_impressions'] = $settings['Aff_debug_impressions'];
        $_POST['debug_clicks'] = $settings['Aff_debug_clicks'];
        $_POST['debug_sales'] = $settings['Aff_debug_sales'];
        $_POST['join_campaign'] = $settings['Aff_join_campaign'];
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
        $_POST['smtp_server'] = $settings['Aff_smtp_server'];
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
        $_POST['enable_vat_invoicing'] = $settings['Aff_enable_vat_invoicing'];
    }
    
    //------------------------------------------------------------------------

    function protectData()
    {
        // protect against script injection

        $data = array();

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
        $data['system_currency'] = preg_replace('/[\"\']/', '', $_POST['system_currency']);
        $data['default_lang'] = preg_replace('/[\"\']/', '', $_POST['default_lang']);
        $data['allow_choose_lang'] = preg_replace('/[\"\']/', '', $_POST['allow_choose_lang']);
        $data['login_protection_retries'] = preg_replace('/[^0-9]/', '', $_POST['login_protection_retries']);
        $data['login_protection_delay'] = preg_replace('/[^0-9]/', '', $_POST['login_protection_delay']);
        $data['min_payout_options'] = preg_replace('/[^0-9\; ]/', '', $_POST['min_payout_options']);
        $data['initial_min_payout'] = preg_replace('/[^0-9]/', '', $_POST['initial_min_payout']);
        $data['payout_invoice'] = $_POST['payout_invoice'];
        $data['payout_invoice_vat'] = $_POST['payout_invoice_vat'];
        $data['payout_invoice_subject'] = $_POST['payout_invoice_subject'];
        $data['payout_invoice_subject_vat'] = $_POST['payout_invoice_subject_vat'];
        $data['declinefrequentclicks'] = preg_replace('/[^0-1]/', '', $_POST['declinefrequentclicks']);
        $data['frequentclicks'] = preg_replace('/[^0-2]/', '', $_POST['frequentclicks']);
        $data['declinefrequentsales'] = preg_replace('/[^0-1]/', '', $_POST['declinefrequentsales']);
        $data['frequentsales'] = preg_replace('/[^0-2]/', '', $_POST['frequentsales']);
        $data['declinesameorderid'] = preg_replace('/[^0-1]/', '', $_POST['declinesameorderid']);
        $data['clickfrequency'] = preg_replace('/[^0-9]/', '', $_POST['clickfrequency']);
        $data['salefrequency'] = preg_replace('/[^0-9]/', '', $_POST['salefrequency']);
        $data['link_style'] = preg_replace('/[^0-9]/', '', $_POST['link_style']);
        $data['email_onaffsignup'] = preg_replace('/[^0-9]/', '', $_POST['email_onaffsignup']);
        $data['email_onsale'] = preg_replace('/[^0-9]/', '', $_POST['email_onsale']);
        $data['email_dailyreport'] = preg_replace('/[^0-9]/', '', $_POST['email_dailyreport']);
        $data['email_monthlyreport'] = preg_replace('/[^0-9]/', '', $_POST['email_monthlyreport']);
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
        $data['ip_validity'] = preg_replace('/[^0-9]/', '', $_POST['ip_validity']);
        $data['ip_validity_type'] = preg_replace('/[\"\']/', '', $_POST['ip_validity_type']);
        $data['track_by_session'] = preg_replace('/[^0-1]/', '', $_POST['track_by_session']);
        $data['apply_from_banner'] = preg_replace('/[^0-1]/', '', $_POST['apply_from_banner']);
        $data['fixed_cost'] = preg_replace('/[\'\"]/', '', $_POST['fixed_cost']);
        $data['log_level_element'] = preg_replace('/[\'\"]/', '', $_POST['log_level_element']);
        $data['debug_emails'] = preg_replace('/[^0-1]/', '', $_POST['debug_emails']);
        $data['debug_impressions'] = preg_replace('/[^0-1]/', '', $_POST['debug_impressions']);
        $data['debug_clicks'] = preg_replace('/[^0-1]/', '', $_POST['debug_clicks']);
        $data['debug_sales'] = preg_replace('/[^0-1]/', '', $_POST['debug_sales']);
        $data['join_campaign'] = preg_replace('/[^0-1]/', '', $_POST['join_campaign']);
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
        $data['smtp_username'] = preg_replace('/[\'\"]/', '', $_POST['smtp_username']);
        $data['smtp_password'] = preg_replace('/[\'\"]/', '', $_POST['smtp_password']);
        $data['signup_terms_conditions'] = preg_replace('/[\'\"]/', '', $_POST['signup_terms_conditions']);
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
        $data['bannerformat_textformat'] = preg_replace('/[\'\"]/', '', $_POST['bannerformat_textformat']);
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
        $data['enable_vat_invoicing'] = preg_replace('/[^0-1]/', '', $_POST['enable_vat_invoicing']);
        

        return $data;
    }

	//------------------------------------------------------------------------

    function processData($data)
    {
        $parts = explode(';', $data['min_payout_options']);
        $count = 0;
        $isOneOf = false;
        foreach($parts as $part)
        {
            $part = trim($part);
            if(is_numeric($part) && $part>0)
                $count++;

            if($data['initial_min_payout'] != '')
                if($data['initial_min_payout'] == $part)
                    $isOneOf = true;
        }

        checkCorrectness($_POST['min_payout_options'], $data['min_payout_options'], L_G_MINPAYOUTOPTIONS, CHECK_ALLOWED);
        checkCorrectness($_POST['initial_min_payout'], $data['initial_min_payout'], L_G_INITIALMINPAYOUT, CHECK_ALLOWED);
        checkCorrectness($_POST['payout_invoice'], $data['payout_invoice'], L_G_PAYOUTINVOICE, CHECK_ALLOWED);
        checkCorrectness($_POST['payout_invoice_vat'], $data['payout_invoice_vat'], L_G_VATPAYOUTINVOICE, CHECK_ALLOWED);
        checkCorrectness($_POST['payout_invoice_subject'], $data['payout_invoice_subject'], L_G_PAYOUTINVOICESUBJECT, CHECK_ALLOWED);
        checkCorrectness($_POST['payout_invoice_subject_vat'], $data['payout_invoice_subject_vat'], L_G_VATPAYOUTINVOICESUBJECT, CHECK_ALLOWED);
        checkCorrectness($_POST['pp_username'], $data['pp_username'], L_G_PAYPALUSERNAME, CHECK_ALLOWED);
        checkCorrectness($_POST['pp_password'], $data['pp_password'], L_G_PAYPALPASSWORD, CHECK_ALLOWED);
        checkCorrectness($_POST['pp_password'], $data['pp_password'], L_G_PAYPALPASSWORD, CHECK_ALLOWED);
        checkCorrectness($_POST['pp_currency'], $data['pp_currency'], L_G_PAYPALCURRENCY1, CHECK_ALLOWED);
        checkCorrectness($_POST['pp_emailsubject'], $data['pp_emailsubject'], L_G_PAYPALEMAILSUBJECT, CHECK_ALLOWED);
        //checkCorrectness($_POST['pp_dayofpay'], $data['pp_dayofpay'], L_G_DAYOFPAYMENT, CHECK_NUMBER);

        if ($data['pp_periodicity'] == PERIODICITY_WEEKLY) {
            $data['pp_dayofpay'] = $data['pp_weekdayofpay'];
        } else {
            $data['pp_dayofpay'] = $data['pp_monthdayofpay1'].';'.
                                   $data['pp_monthdayofpay2'].';'.
                                   $data['pp_monthdayofpay3'].';'.
                                   $data['pp_monthdayofpay4'];
        }

        if($data['initial_min_payout'] != '' && !$isOneOf)
            QUnit_Messager::setErrorMessage(L_G_INITIALPAYOUTMUSTBEFROMTHELIST);

        // import certificate
        $params = array('username'       => $data['pp_username'],
                        'password'       => $data['pp_password'],
                        'cert_save_path' => $GLOBALS['PROJECT_ROOT_PATH']."/exports/",
                        'cert_file'      => 'cert_'.$GLOBALS['Auth']->getAccountID().'.cert');

        if ($this->processCertificate($params) === true) {
            $this->createAPIProfile($params);
        }

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_apply_from_banner' => $data['apply_from_banner'],
                            'Aff_min_payout_options' => $data['min_payout_options'],
                            'Aff_initial_min_payout' => $data['initial_min_payout'],
                            'Aff_payout_invoice' => $data['payout_invoice'],
                            'Aff_payout_invoice_vat' => $data['payout_invoice_vat'],
                            'Aff_payout_invoice_subject' => $data['payout_invoice_subject'],
                            'Aff_payout_invoice_subject_vat' => $data['payout_invoice_subject_vat'],
                            'Aff_pp_username' => $data['pp_username'],
                            'Aff_pp_password' => $data['pp_password'],
                            'Aff_pp_periodicity' => $data['pp_periodicity'],
                            'Aff_pp_dayofpay' => $data['pp_dayofpay'],
                            'Aff_pp_currency' => $data['pp_currency'],
                            'Aff_pp_emailsubject' => $data['pp_emailsubject'],
                            'Aff_enable_vat_invoicing' => $data['enable_vat_invoicing'],
                            );
        }

        return false;
    }

    //------------------------------------------------------------------------

	function demoProcessData($data)
	{
		return array();
	}

	//------------------------------------------------------------------------

	function processCertificate($params) {
	    $dir = $params['cert_save_path'];
        $file = $params['cert_file'];
        $uploadfile = $dir.$file;

	    if(is_uploaded_file($_FILES['pp_certificate']['tmp_name'])) {
	        $oUpload = QUnit_Global::newObj('QUnit_Net_FileUpload',  $dir, $_FILES['pp_certificate'], $file);

            $oUpload->setAllowedTypes($GLOBALS['UPLOAD_ALLOWED_FILE_TYPES']);

            if($oUpload->handleUpload() === false) {
                return false;
            }
            
            QUnit_Messager::setOkMessage(L_G_FILESUCCESSFULLYUPLOADED.": ".$_FILES['pp_certificate']['name']);

	        return true;
        }
        
        return false;
	}

	//------------------------------------------------------------------------

	function createAPIProfile($params) {
	    $error = '';
	    $cert_save_path = $params['cert_save_path'];
	    $cert_file = $params['cert_file'];

	    $handlerinst =& _getHandlerInstance('File', array('path' => $cert_save_path));

	    if(!Services_PayPal::isError($handlerinst))
	    {
	        $pid = ProfileHandler::generateID();

	        $profile = new APIProfile($pid, $handlerinst);

	        $profile->setAPIUsername($params['username']);
            $profile->setSubject($params['subject']);
            $profile->setEnvironment('live');

	        $profile->setCertificateFile($cert_save_path.$cert_file);

	        $result = $profile->save();

	        if(Services_PayPal::isError($result)) {
	            $error = L_G_COULDNOTCREATEPAYPALPROFILE.": ".$result->getMessage();
	        } else {
	            @unlink($cert_save_path.'cert_'.$GLOBALS['Auth']->getAccountID().'.ppd');
	            @rename($cert_save_path.$result.'.ppd', $cert_save_path.'cert_'.$GLOBALS['Auth']->getAccountID().'.ppd');
	            @unlink($cert_save_path.$result.'.ppd');
	        }
	    }
	    else
	    {
	        $error = L_G_COULDNOTCREATEPAYPALPROFILEHANDLER.": ".$handlerinst->getMessage();
	    }

	    if ($error != '') {
	        QUnit_Messager::setErrorMessage($error);
	    } else {
	        QUnit_Messager::setOkMessage(L_G_PAYPALPROFILECREATED);
	    }
	}

}

?>
