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

QUnit_Global::includeClass('Affiliate_Merchants_Bl_MerchantDBAuth');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Settings');

class Affiliate_Affiliates_Bl_AffiliateDBAuth extends Affiliate_Merchants_Bl_MerchantDBAuth
{
    function Affiliate_Affiliates_Bl_AffiliateDBAuth()
    {
        $this->sessionPrefix = 'affauth';
        
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
            $array_data2 = QCore_Settings::getUserSettings(SETTINGTYPE_USER, $this->accountID, $this->userID);
        }

        $this->settings = array_merge($array_data1, $array_data2);

        $this->saveToSession();
    }
    
    //------------------------------------------------------------------------

    function getLiteAccountID()
    {
        if (GLOBAL_DB_ENABLED == 1) {
            if($_SESSION['a_lite_accountid'] != '') {
                return $_SESSION['a_lite_accountid'];
            }
            
            if($_SESSION['lid'] != '') {
                return $_SESSION['lid'];
            }
        }
            
        return $this->getSetting('AffPlanet_account_id');
    }    
    
    //------------------------------------------------------------------------
    
    function getEarned() {
        $conditions = array(
            'CampaignID' => '',
            'UserID' => $GLOBALS['Auth']->getUserID(),
            'TransactionType' => '',
            'Status' => '',
            'page' => '',
            'rowsPerPage' => '',
            'day1' => 1,
            'month1' => 1,
            'year1' => 1980,
            'day2' => 1,
            'month2' => 1,
            'year2' => 2020
        );
        $saleStats =& QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleStatistics');
        $transdata = $saleStats->getTransactionsSummaries($conditions);
        if($transdata != false) {
            return $transdata[$GLOBALS['Auth']->getUserID()]['approved'];
        } else {
            return 0;
        }
    }
    
	//------------------------------------------------------------------------
    
    function getEarnedCommissions() {
        $conditions = array(
            'CampaignID' => '',
            'UserID' => $GLOBALS['Auth']->getUserID(),
            'TransactionType' => '',
            'Status' => '',
            'page' => '',
            'rowsPerPage' => '',
            'day1' => 1,
            'month1' => 1,
            'year1' => 1980,
            'day2' => 1,
            'month2' => 1,
            'year2' => 2020,
            'virtual_affiliates' => true
        );
        $saleStats =& QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleStatistics');
        $transdata = $saleStats->getTransactionsSummaries($conditions);
        if($transdata != false) {
            return $transdata[$GLOBALS['Auth']->getUserID()];
        } else {
            return false;
        }
    }
}
?>
