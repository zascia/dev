<?php
/**
*
*   @author Maros Fric, Ladislav Tamas
*   @copyright Copyright (c) webradev.com
*   All rights reserved
*
*   @package PostAffiliate Pro
*   @since Version 2.0
*
*   For support contact info@webradev.com
*/

QUnit_Global::includeClass('QCore_Auth');

class Affiliate_Merchants_Bl_MerchantDBAuth extends QCore_Auth
{
    function Affiliate_Merchants_Bl_MerchantDBAuth()
    {
        $this->sessionPrefix = 'merchauth';

        $this->init();
    }

    //------------------------------------------------------------------------

    function loadSettings()
    {
        if($this->accountID == '' && $this->userID == '') {
            return false;
        }

        $array_data1 = array();
        $array_data2 = array();

        if($this->accountID != '') {
            $array_data1 = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $this->accountID);
        }

        if($this->userID != '') {
            $array_data2 = QCore_Settings::getAdminSettings(SETTINGTYPE_ADMIN, $this->accountID, $this->userID);
        }

        $array_data3 = QCore_Settings::getGlobalSettings();

        $this->settings = array_merge($array_data1, $array_data2, $array_data3);

        $this->saveToSession();
    }
    
    //------------------------------------------------------------------------
    
    function getTransactionStatusString($status)
    {
        if($status == AFFSTATUS_NOTAPPROVED) return L_G_WAITINGAPPROVAL;
        else if($status == AFFSTATUS_APPROVED) return L_G_APPROVED;
        else if($status == AFFSTATUS_SUPPRESSED) return L_G_SUPPRESSED;
    }

    //------------------------------------------------------------------------

    function getCommissionTypeString($type)
    {
        if($type & TRANSTYPE_CPM) return L_G_TYPECPM;
        else if($type & TRANSTYPE_CLICK) return L_G_TYPECLICK;
        else if($type & TRANSTYPE_SALE) return L_G_TYPESALE;
        else if($type & TRANSTYPE_LEAD) return L_G_TYPELEAD;
        else if($type & TRANSTYPE_RECURRING) return L_G_TYPERECURRING;
        else if($type & TRANSTYPE_SIGNUP) return L_G_TYPESIGNUP;
        else if($type & TRANSTYPE_REFERRAL) return L_G_TYPEREFERRAL;
        else if($type & TRANSTYPE_REFUND) return L_G_REFUND;
        else if($type & TRANSTYPE_CHARGEBACK) return L_G_CHARGEBACK;

        return L_G_UNKNOWN;
    }

    //------------------------------------------------------------------------

    function getComposedCommissionTypeString($type)
    {
        $strtype = '';

        if($type & TRANSTYPE_CPM) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPECPM;
        if($type & TRANSTYPE_CLICK) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPECLICK;
        if($type & TRANSTYPE_SALE) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPESALE;
        if($type & TRANSTYPE_LEAD) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPELEAD;
        if($type & TRANSTYPE_RECURRING) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPERECURRING;
        if($type & TRANSTYPE_SIGNUP) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPESIGNUP;
        if($type & TRANSTYPE_REFERRAL) $strtype .= ($strtype != '' ? ' & ' : '').L_G_TYPEREFERRAL;
        if($type & TRANSTYPE_REFUND) $strtype .= ($strtype != '' ? ' & ' : '').L_G_REFUND;
        if($type & TRANSTYPE_CHARGEBACK) $strtype .= ($strtype != '' ? ' & ' : '').L_G_CHARGEBACK;

        if($strtype == '')
            $strtype = L_G_UNKNOWN;

        return $strtype;
    }

    //------------------------------------------------------------------------

    function getCommissionTypeSelect($selectName, $selected, $onlyStrict = true, $onlyReferer = false, $multiple = true, $refundChargeback = true, $recurring = true)
    {
        print '<select name="'.$selectName.'"'.(($multiple) ? " multiple" : "").'>';
        if(($GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions') == 1) && !$onlyReferer)
        {
            print '  <option value="'.TRANSTYPE_CPM.'" '.(is_array($selected) ? (in_array(TRANSTYPE_CPM, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_CPM ? 'selected' : '')).'>'.L_G_TYPECPM.'</option>';
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1)
        {
        print '  <option value="'.TRANSTYPE_CLICK.'" '.(is_array($selected) ? (in_array(TRANSTYPE_CLICK, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_CLICK ? 'selected' : '')).'>'.L_G_PERCLICK.'</option>';
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_lead_commissions') == 1)
        {
        print '  <option value="'.TRANSTYPE_LEAD.'" '.(is_array($selected) ? (in_array(TRANSTYPE_LEAD, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_LEAD ? 'selected' : '')).'>'.L_G_PERLEAD.'</option>';
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_sale_commissions') == 1)
        {
        print '  <option value="'.TRANSTYPE_SALE.'" '.(is_array($selected) ? (in_array(TRANSTYPE_SALE, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_SALE ? 'selected' : '')).'>'.L_G_PERSALE.'</option>';
        }

        if(!$onlyStrict)
        {
            if(($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') == 1)  && !$onlyReferer && $recurring)
            {
                print '  <option value="'.TRANSTYPE_RECURRING.'" '.(is_array($selected) ? (in_array(TRANSTYPE_RECURRING, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_RECURRING ? 'selected' : '')).'>'.L_G_RECURRINGCOMMISSIONS.'</option>';
            }

            if($GLOBALS['Auth']->getSetting('Aff_support_signup_commissions') == 1)
            {
                print '  <option value="'.TRANSTYPE_SIGNUP.'" '.(is_array($selected) ? (in_array(TRANSTYPE_SIGNUP, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_SIGNUP ? 'selected' : '')).'>'.L_G_SIGNUPBONUS.'</option>';
            }

            if($GLOBALS['Auth']->getSetting('Aff_support_referral_commissions') == 1)
            {
                print '  <option value="'.TRANSTYPE_REFERRAL.'" '.(is_array($selected) ? (in_array(TRANSTYPE_REFERRAL, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_REFERRAL ? 'selected' : '')).'>'.L_G_PERREFERRAL.'</option>';
            }

            if($refundChargeback) {
            	if($GLOBALS['Auth']->getSetting('Aff_support_refund_commissions') == 1)
            	{
	                print '  <option value="'.TRANSTYPE_REFUND.'" '.(is_array($selected) ? (in_array(TRANSTYPE_REFUND, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_REFUND ? 'selected' : '')).'>'.L_G_REFUND.'</option>';
            	}

            	if($GLOBALS['Auth']->getSetting('Aff_support_chargeback_commissions') == 1)
            	{
    	            print '  <option value="'.TRANSTYPE_CHARGEBACK.'" '.(is_array($selected) ? (in_array(TRANSTYPE_CHARGEBACK, $selected) ? 'selected' : '') : ($selected == TRANSTYPE_CHARGEBACK ? 'selected' : '')).'>'.L_G_CHARGEBACK.'</option>';
	            }
            }
        }

        print '</select>';
    }

    //------------------------------------------------------------------------

    function getSupportedCommissions($onlyStrict = true, $onlyReferer = false, $refundChargeback = true)
    {
        $data = array();
        if(($GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions') == 1) && !$onlyReferer) {
            $data[TRANSTYPE_CPM] = L_G_TYPECPM;
        }
        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1) {
            $data[TRANSTYPE_CLICK] = L_G_PERCLICK;
        }
        if($GLOBALS['Auth']->getSetting('Aff_support_lead_commissions') == 1) {
            $data[TRANSTYPE_LEAD] = L_G_PERLEAD;
        }
        if($GLOBALS['Auth']->getSetting('Aff_support_sale_commissions') == 1) {
            $data[TRANSTYPE_SALE] = L_G_PERSALE;
        }
        if(!$onlyStrict)
        {
            if(($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') == 1)  && !$onlyReferer) {
                $data[TRANSTYPE_RECURRING] = L_G_RECURRINGCOMMISSIONS;
            }
            if($GLOBALS['Auth']->getSetting('Aff_support_signup_commissions') == 1) {
                $data[TRANSTYPE_SIGNUP] = L_G_SIGNUPBONUS;
            }
            if($GLOBALS['Auth']->getSetting('Aff_support_referral_commissions') == 1) {
                $data[TRANSTYPE_REFERRAL] = L_G_PERREFERRAL;
            }
            if($refundChargeback) {
            	if($GLOBALS['Auth']->getSetting('Aff_support_refund_commissions') == 1) {
	                $data[TRANSTYPE_REFUND] = L_G_REFUND;
            	}
            	if($GLOBALS['Auth']->getSetting('Aff_support_chargeback_commissions') == 1) {
    	            $data[TRANSTYPE_CHARGEBACK] = L_G_CHARGEBACK;
	            }
            }
        }
        return $data;
    }

    //------------------------------------------------------------------------

    function getAllowedCommissionTypes($strict = false)
    {
        $arr = array();
        
        if($GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions') == 1) $arr[] = TRANSTYPE_CPM;
        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1) $arr[] = TRANSTYPE_CLICK;
        if($GLOBALS['Auth']->getSetting('Aff_support_lead_commissions') == 1) $arr[] = TRANSTYPE_LEAD;
        if($GLOBALS['Auth']->getSetting('Aff_support_sale_commissions') == 1) $arr[] = TRANSTYPE_SALE;
        
        if(!$strict)
        {
            if($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') == 1) $arr[] = TRANSTYPE_RECURRING;
            if($GLOBALS['Auth']->getSetting('Aff_support_signup_commissions') == 1) $arr[] = TRANSTYPE_SIGNUP;
            if($GLOBALS['Auth']->getSetting('Aff_support_referral_commissions') == 1) $arr[] = TRANSTYPE_REFERRAL;
        }
        
        return $arr;
    }
    
    //------------------------------------------------------------------------

    function getLiteAccountID()
    {
        if (GLOBAL_DB_ENABLED == 1) {
            if($_SESSION['m_lite_accountid'] != '') {
                return $_SESSION['m_lite_accountid'];
            }
            
            if($_SESSION['lid'] != '') {
                return $_SESSION['lid'];
            }
        }
            
        return $this->getSetting('AffPlanet_account_id');
    }    
}
?>
