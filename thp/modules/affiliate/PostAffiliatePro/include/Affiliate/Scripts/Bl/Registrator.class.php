<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_History');
QUnit_Global::includeClass('QCore_Logs');
QUnit_Global::includeClass('QCore_Settings');

class Affiliate_Scripts_Bl_Registrator
{
    var $className = 'Affiliate_Scripts_Bl_Registrator';
    var $CampaignCategoryID = '';
    var $cookieLifetime = '';
    var $cookieSetReturn = '';
    var $UserID = '';
    var $ParentUserID = '';  
    var $CampaignID = '';
    var $CampaignCommType = '';
    var $CampaignStatus = AFF_CAMP_PUBLIC;
    var $CPMCommission;
    var $ClickCommission = 0;
    var $SaleCommission = 0;
    var $STClickCommission = array();
    var $STSaleCommission = array();
    var $PerSaleCommType = '';
    var $STPerSaleCommType = '';
    var $RecurringCommission = 0;
    var $RecurringCommType = 0;
    var $RecurringCommDate = 0;
    var $RecurringDateType = 0;
    var $STRecurringCommission = array();
    var $STRecurringCommType = 0;
    var $ClickTransactionApproval = 0;
    var $SaleTransactionApproval = 0;
    var $BannerID = '';
    var $BannerType = '';
    var $destinationURL = '';
    var $uniqueUser = true;
    var $DeclineFrequentClicks;
    var $FrequentClicks;
    var $DeclineFrequentSales;
    var $FrequentSales;
    var $DeclineSameOrderId;
    var $ClickFrequency;
    var $SaleFrequency;
    var $SaleOrderIdFrequency;
    var $maxCommissionLevels;
    var $saleKind = TRANSKIND_NORMAL;
    var $saleType = '';
    var $AccountID = '';
    var $settings = array();
    var $extraData1 = '';
    var $extraData2 = '';
    var $extraData3 = '';
    var $countryCode = '';
    var $blSettings;
    var $registration_type = '';
    var $description = '';
    var $disableFraudProtection = false;
    
    function Affiliate_Scripts_Bl_Registrator()
    {
        $this->blSettings =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Settings');
    }    
    
    //--------------------------------------------------------------------------
    
    function checkUserExists($userID)
    {
        $userID = preg_replace('/[\'\"]/', '', $userID);
    
        if(trim($userID) == '') return false;
    
        $sql = 'select * from wd_g_users where deleted=0 '.
                ' and (userid='._q($userID).' or refid='._q($userID).')';
        if($this->AccountID != '' && $this->AccountID != DEFAULT_ACCOUNT)
            $sql .= ' and accountid='._q($this->AccountID);
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs || $rs->EOF) {
            return false;
        }
        
        $this->UserID = $rs->fields['userid'];
        $this->AccountID = $rs->fields['accountid'];

        if($rs->fields['parentuserid'] != '' && $rs->fields['parentuserid'] != '0')
            $this->ParentUserID = $rs->fields['parentuserid'];

        $this->settings = QCore_Settings::getUserSettings(SETTINGTYPE_USER, $this->AccountID, $this->UserID);
        $this->settings = array_merge($this->settings, QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $this->AccountID));
        $GLOBALS['Auth']->setAccountByUser($userID);
        
//        $this->settings = $GLOBALS['Auth']->getSettings();
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function checkCampaignExists($campaign = '')
    {
        if($campaign == '')
            $campaign = $this->CampaignID;
        
        $sql = 'select * from wd_pa_campaigns where deleted=0 and campaignid='._q($campaign);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
            return false;
        
        $this->CampaignID = $rs->fields['campaignid'];
        $this->CampaignCommType = $rs->fields['commtype'];

        $this->settings = array_merge($this->settings, $this->blSettings->getCampaignInfo(array('campaignid' => $this->CampaignID)));
        
        $this->cookieLifetime = $this->settings['Aff_camp_cookielifetime'];
        $this->ClickTransactionApproval = $this->settings['Aff_camp_clickapproval'];
        $this->SaleTransactionApproval = $this->settings['Aff_camp_saleapproval'];    
        
        $this->DeclineFrequentClicks = $this->settings['Aff_declinefrequentclicks'];
        $this->FrequentClicks = $this->settings['Aff_frequentclicks'];
        $this->DeclineFrequentSales = $this->settings['Aff_declinefrequentsales'];
        $this->FrequentSales = $this->settings['Aff_frequentsales'];
        $this->DeclineSameOrderId = $this->settings['Aff_declinesameorderid'];
        $this->ClickFrequency = (int) $this->settings['Aff_clickfrequency'];
        $this->SaleFrequency = (int) $this->settings['Aff_salefrequency'];
        $this->SaleOrderIdFrequency = (int) $this->settings['Aff_saleorderidfrequency'];
        $this->CampaignStatus = (int) $this->settings['Aff_camp_status'];
        
        return true;
    }    
    
    //--------------------------------------------------------------------------
    
    function checkBannerExists($bannerID, $getFirstCategoryIfNotExists = false)
    {
        if($bannerID == '' && $getFirstCategoryIfNotExists) {
            $this->CampaignID = $this->settings['Aff_default_campaign'];
            $this->BannerID = -1;
            
            if ($this->CampaignID == '_') {
                $this->registratorLog(WLOG_DEBUG, "Registrator: No default campaign", __FILE__, __LINE__);
                return false;
            } elseif ($this->CampaignID == '') { // for backwards compatibility
                $sql = 'select * from wd_pa_campaigns where deleted=0';
                $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                if (!$rs || $rs->EOF)
                    return false;

                $this->CampaignID = $rs->fields['campaignid'];
            }
        } else {
            $sql = 'select * from wd_pa_banners where deleted=0 and bannerid='._q($bannerID);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF) {
                $this->registratorLog(WLOG_DEBUG, "Registrator: Banner '$bannerID' doesn't exist", __FILE__, __LINE__);
                return false;
            }
            
            $this->BannerID = $bannerID;
            $this->BannerType = $rs->fields['bannertype'];
            $this->CampaignID = $rs->fields['campaignid'];
            $this->description = $rs->fields['description'];
            $this->destinationURL = $rs->fields['destinationurl'];
            
            if($this->destinationURL == '' && $this->BannerType != BANNERTYPE_ROTATOR) {
                $this->registratorLog(WLOG_DEBUG, "Registrator: DestinationURL for banner '$bannerID' is empty", __FILE__, __LINE__);
                return false;      
            }        
        }
        
        return true;
    }    
    
    //--------------------------------------------------------------------------
    
    function getBannerData($bannerID, $getFirstCategoryIfNotExists = false)
    {
        $sql = 'select * from wd_pa_banners where deleted=0 and bannerid='._q($bannerID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF) {
            $this->registratorLog(WLOG_DEBUG, "Registrator: Banner '$bannerID' doesn't exist", __FILE__, __LINE__);
            return false;
        }
        
        return $rs->fields;
    }    
    
    //--------------------------------------------------------------------------
    
    function checkUserInCampaign()
    {
        if($this->UserID == '')
        {
            $this->registratorLog(WLOG_DEBUG, "Registrator: UserID is empty", __FILE__, __LINE__);
            return false;      
        }
        if($this->CampaignID == '')
        {
            $this->registratorLog(WLOG_DEBUG, "Registrator: CampaignID is empty", __FILE__, __LINE__);
            return false;
        }
        
        $sql = 'select cc.* from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campaignid='._q($this->CampaignID).
               '  and cc.campcategoryid=ac.campcategoryid'.
               '  and ac.rstatus='._q(AFFSTATUS_APPROVED).
               '  and ac.affiliateid='._q($this->UserID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        if (($this->CampaignStatus == AFF_CAMP_PRIVATE) && ($rs->EOF)) {
            // check if user is in campaign anyway
            $sql = 'select ac.* from wd_pa_affiliatescampaigns ac '.
                    'where ac.campaignid='._q($this->CampaignID).
                    '  and ac.rstatus='._q(AFFSTATUS_APPROVED).
                    '  and ac.affiliateid='._q($this->UserID);
            $rs2 = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs2) {
                return false;
            }
            
            if($rs2->EOF) {
                $this->registratorLog(WLOG_DEBUG, "Registrator: User is not in private campaign ".$this->CampaignID, __FILE__, __LINE__);
                return false;
            }
        }
            
        if($rs->EOF)
        {
            // get basic commission category for this campaign
            $sql = 'select * from wd_pa_campaigncategories '.
                   'where deleted=0 and campaignid='._q($this->CampaignID).
                   ' and name='._q(UNASSIGNED_USERS);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
                return false;
        }

        $this->CampaignCategoryID = $rs->fields['campcategoryid'];
        $this->CPMCommission = $rs->fields['cpmcommission'];
        $this->ClickCommission = $rs->fields['clickcommission'];
        $this->SaleCommission = $rs->fields['salecommission'];

        $this->maxCommissionLevels = $this->settings['Aff_maxcommissionlevels'];
        if($this->maxCommissionLevels == '')
            $this->maxCommissionLevels = 1;
        
        $this->STClickCommission = array();
        $this->STSaleCommission = array();
        $this->STRecurringCommission = array();
        
        for($i=2; $i<=$this->maxCommissionLevels; $i++)
        {
            $this->STClickCommission[$i] = $rs->fields['st'.$i.'clickcommission'];
            $this->STSaleCommission[$i] = $rs->fields['st'.$i.'salecommission'];
            $this->STRecurringCommission[$i] = $rs->fields['st'.$i.'recurringcommission'];
        }
        
        $this->PerSaleCommType = $rs->fields['salecommtype'];
        $this->STPerSaleCommType = $rs->fields['stsalecommtype'];
        
        $this->RecurringCommission = $rs->fields['recurringcommission'];
        $this->RecurringCommType = $rs->fields['recurringcommtype'];
        $this->RecurringCommDate = $rs->fields['recurringcommdate'];
        $this->RecurringDateType = $rs->fields['recurringdatetype'];
        $this->STRecurringCommType = $rs->fields['strecurringcommtype'];
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function setP3PPolicy($load_settings = '1')
    {
        if($load_settings)
            $this->settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $this->AccountID);
        
        $policyRef = '';
        $cp = '';
        
        if($this->settings['Aff_p3p_xml'] != '')
            $policyRef = $this->settings['Aff_p3p_xml'];
        
        if($this->settings['Aff_p3p_compact'] != '')
            $cp = $this->settings['Aff_p3p_compact'];
        
        if($cp != '' || $policyRef != '')
        {
            $p3pPolicy = 'P3P: '.($policyRef == '' ? '' : 'policyref="'.$policyRef.'"').
                                ($cp != '' && $policyRef != '' ? ', ' : '').
                                ($cp == '' ? '' : 'CP="'.$cp.'"');
            header($p3pPolicy);
            
            $this->registratorLog(WLOG_DEBUG, "Registrator: P3P policy set to '$p3pPolicy'", __FILE__, __LINE__);
        }
    }

    //--------------------------------------------------------------------------

    function loadLanguage($lang = '')
    {
        if($lang == '')
            $lang = $this->settings['Aff_default_lang'];
    
        if($lang != '' && file_exists(LANG_PATH.$lang.'.php'))
        {
            include_once(LANG_PATH.$lang.'.php');
        }
        else
        {
            QUnit_Messager::setErrorMessage('LANGUAGE FILE '.LANG_PATH.$lang.'.php NOT FOUND!');
            $this->registratorLog(WLOG_ERROR, 'Sale registrator: LANGUAGE FILE '.LANG_PATH.$lang.'.php NOT FOUND!', __FILE__, __LINE__);
        }
    }

    //--------------------------------------------------------------------------
    
    function decodeValue($cookieval, $userID = '')
    {
        if($cookieval == '')
        {
            if($userID == '') {
                $this->registratorLog(WLOG_DEBUG, "Registrator: Data/Cookie is empty", __FILE__, __LINE__);            
                return false;
            }

            // get default campaign
            $sql = 'select * from wd_pa_campaigns where deleted=0';
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
                return false;
            
            $campaignID = $rs->fields['campaignid'];
            
            return array($userID, $campaignID);
        }
        
        $arr = split ('_', $cookieval);
        
        if(!is_array($arr))
        {
            $this->registratorLog(WLOG_DEBUG, "Registrator: data/cookie value is not array", __FILE__, __LINE__);            
            return false; 
        }
        
        if(count($arr) != 2)
        {
            $this->registratorLog(WLOG_DEBUG, "Registrator: data/cookie value has not 2 elements", __FILE__, __LINE__);            
            return false; 
        }
        
        if ($arr[0] == '' || $arr[1] == '') {
            $this->registratorLog(WLOG_DEBUG, "Registrator: Cookie value is empty", __FILE__, __LINE__);            
            return false;
        }
        
        $this->registratorLog(WLOG_DEBUG, "Registrator: Value recognized (User ID: ".$arr[0].", Product category ID: ".$arr[1].")", __FILE__, __LINE__);            
        
        return array($arr[0], $arr[1]);
    }
    
    //--------------------------------------------------------------------------
    
    function decodeFromIP($cookieval)
    {
       $params = array('status' => AFFSTATUS_APPROVED,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'ip_validity' => $this->settings['Aff_ip_validity'],
                        'ip_validity_type' => $this->settings['Aff_ip_validity_type'],
                        'currentDate' => date("Y-n-j H:i:s")
                       );
        if ($this->settings['Aff_track_by_browser'] == 1) {
            $browserIdentification = $_SERVER['HTTP_USER_AGENT'].$_SERVER['HTTP_ACCEPT_LANGUAGE'].$_SERVER['HTTP_ACCEPT'];
            $params['browserHash'] = substr(md5($browserIdentification), 0, 6);
        }

        // look for approved records
        $this->registratorLog(WLOG_DEBUG, "Registrator: Trying to get referrer by IP '".$_SERVER['REMOTE_ADDR']."' from approved transaction", __FILE__, __LINE__);
        $arr = $this->getAffiliateFromTransaction($params);

        if($arr == false)
        {
            // look for waiting for approval records
            $this->registratorLog(WLOG_DEBUG, "Registrator: Trying to get referrer by IP from waiting for approval transaction", __FILE__, __LINE__);
            $params['status'] = AFFSTATUS_NOTAPPROVED;
            $arr = $this->getAffiliateFromTransaction($params);
         }
        
        if($arr == false)
            return false;
        
        return $arr;
    }
    
    //--------------------------------------------------------------------------
    
    function getAffiliateFromTransaction($params)
    {
        $sql  = 'select t.affiliateid, cc.campaignid '.
                'from wd_pa_transactions t, wd_pa_campaigncategories cc '.
                'where t.transtype='.TRANSTYPE_CLICK.' and t.transkind='.TRANSKIND_NORMAL.
                '  and t.campcategoryid=cc.campcategoryid'. 
                '  and t.rstatus='._q($params['status']).' and t.IP='._q($params['ip']).
                '  and TO_DAYS('.sqlDateAdd('t.dateinserted', $params['ip_validity'], $params['ip_validity_type']).') >= TO_DAYS('._q($params['currentDate']).')';
        if ($params['browserHash'] != '') {
            $sql .= '  and t.browser='._q($params['browserHash']);
        }
        $sql .= ' order by t.dateinserted desc'.
                ' limit 0,1';
        
        $this->registratorLog(WLOG_DEBUG, "Registrator: Checking referrer from IP. Sql:".$sql, __FILE__, __LINE__);            
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            $this->registratorLog(WLOG_ERROR, "Registrator: Error checking referrer from IP. Sql:".$sql, __FILE__, __LINE__);            
            return false;
        }

        if($rs->EOF) return false;
        
        $this->registratorLog(WLOG_DEBUG, "Registrator: Get user from transaction. (User ID: ".$UserID.")", __FILE__, __LINE__);            
        
        return array($rs->fields['affiliateid'], $rs->fields['campaignid']);
    }
        
    //--------------------------------------------------------------------------
    
    function getUsersCampaign($UserID)
    {
        // take users first campaign
        $sql = 'select c.campaignid from wd_pa_campaigns c, wd_pa_affiliatescampaigns ac '.
               ' where c.deleted=0 '.
               '   and c.campaignid=ac.campaignid'.
               '   and ac.affiliateid='._q($UserID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            $this->registratorLog(WLOG_ERROR, "Registrator: Error getting campaign for user '$UserID'", __FILE__, __LINE__);            
            return false;
        }

        if(!$rs->EOF) {
            $this->registratorLog(WLOG_DEBUG, "Registrator: Found campaign '".$rs->fields['campaignid']."' for user '$UserID'", __FILE__, __LINE__);
            
            return array($UserID, $rs->fields['campaignid']);
        }

        // user does not have campaign. Take first campaign available
        $sql = 'select * from wd_pa_campaigns where deleted=0 and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs || $rs->EOF)
        {
            $this->registratorLog(WLOG_ERROR, "Registrator: Error getting first campaign, no campaigns available", __FILE__, __LINE__);            
            return false;
        }
        
        $this->registratorLog(WLOG_DEBUG, "Registrator: User has no campaign assigned. Used default campaign '".$rs->fields['campaignid']."' for user '$UserID'", __FILE__, __LINE__);
        
        return array($UserID, $rs->fields['campaignid']);
    }
    
    //--------------------------------------------------------------------------
    
    function getCampaignFromCampaignCategory($campCategoryID) {
        $sql = 'select campaignid from wd_pa_campaigncategories '.
               'where campcategoryid='._q($campCategoryID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF) {
            return false;
        }
        
        return $rs->fields['campaignid'];
    }
    
    //--------------------------------------------------------------------------
    
    function setAccountID($AccountID) {
        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_PRO) {
            $this->accountID = DEFAULT_ACCOUNT;
            return true;
        }
         
        QUnit_Global::includeClass('QCore_Bl_Accounts');

        if(!QCore_Bl_Accounts::checkAccountExists($AccountID)) return false;

        if($AccountID != '') {
            $this->AccountID = $AccountID;
            $GLOBALS['Auth']->setAccountID($AccountID);
            $GLOBALS['Auth']->loadSettings();
            
            return true;
        }

        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function getParentUser($params, $accountID = '')
    {
        if($params['parentUserID'] == '')
            return false;

        $sql = 'select * from wd_g_users u '.
               'where u.userid='._q($params['parentUserID']);
               
        if($accountID != '') {
            $sql .= '  and u.accountid='._q($accountID);
        } else {
            $sql .= '  and u.accountid='._q($this->AccountID);
        }
        
        $sql .= '  and u.parentuserid <> \'\'';

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            $this->registratorLog(WLOG_ERROR,  "Registrator: Error while getting parent user", __FILE__, __LINE__);
            return false;
        }

        if($rs->EOF) {
            $this->registratorLog(WLOG_DEBUG,  "Registrator: No parent user found for user '".$params['parentUserID']."'", __FILE__, __LINE__);
            return false;
        }

        //----------------------------------------
        // check status of user, if he is waiting for approval also transaction must have this status
        if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED && $params['status'] == AFFSTATUS_APPROVED)
            $params['status'] = AFFSTATUS_NOTAPPROVED;

        return array('userID' => $rs->fields['parentuserid'], 'status' => $params['status']);
    }
    
    //--------------------------------------------------------------------------
    
    function setExtraData($Data1, $Data2, $Data3)
    {
        $this->extraData1 = $Data1;
        $this->extraData2 = $Data2;
        $this->extraData3 = $Data3;
    }
    
    //--------------------------------------------------------------------------
    
    function setCountryData($countryCode)
    {
        $this->countryCode = $countryCode;
    }
    
    //--------------------------------------------------------------------------
    
    function checkInDomain()
    {
        $sql = 'select url from wd_g_domains '.
               'where userid='._q($this->UserID).
               '  and accountid='._q($this->AccountID).
               '  and rtype='._q(DOMAIN_USERS).
               '  and rstatus='._q(AFFSTATUS_APPROVED).
               '  and url like \'%'._q_noendtags($GLOBALS['HTTP_REFERER']).'%\'';

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs || $rs->EOF) {
            $this->registratorLog(WLOG_DEBUG,  "Registrator: Domain not allowed for user ID: ".$params['parentUserID']."'", __FILE__, __LINE__);
            return false;
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function registratorLog($logLevel, $message, $file, $line, $userType = '') {
        if($logLevel != WLOG_DEBUG) {
            return QCore_History::log($logLevel, $message, $file, $line, $userType);
        }
        
        if(($this->settings['Aff_debug_impressions'] == 1 && $this->registration_type == 'BannerViewer') 
            || ($this->settings['Aff_debug_clicks'] == 1 && $this->registration_type == 'ClickRegistrator')
            || ($this->settings['Aff_debug_sales'] == 1 && $this->registration_type == 'SaleRegistrator'))
            return QCore_History::log($logLevel, $message, $file, $line, $userType);
    }
    
    //--------------------------------------------------------------------------

    function registratorLogEmail($logLevel, $message, $file, $line, $userType = '') {
        if($logLevel != WLOG_DEBUG) {
            return QCore_History::log($logLevel, $message, $file, $line, $userType);
        }
        
        if($this->settings['Aff_debug_emails'] == 1)
            return QCore_History::log($logLevel, $message, $file, $line, $userType);
    }
    
    //--------------------------------------------------------------------------
    
    function updateTrafficForNewMonth() {
        $transMonth  = $this->settings['Acct_limit_month_count'];
        $transLimit  = $GLOBALS['trafficLimits'][$this->settings['AffPlanet_account_type']][$this->settings['AffPlanet_account_trafficlevel']]['soft'];
        $transBought = $this->settings['Acct_limit_bought_trans'];
        $transBonus  = $this->settings['Acct_limit_month_bonus'];
        $transDebet  = 0;
        
        if ($this->settings['Acct_limit_bonus_enabled'] != '1') {
            $transBonus = 0;
        }
        
        $logger =& QCore_Logs::getInstance();
        $params = array('transMonth'   => $transMonth,
                        'transBonus'   => $transBonus,
                        'transBought'  => $transBought,
                        'accountType'  => $this->settings['AffPlanet_account_type'],
                        'trafficLevel' => $this->settings['AffPlanet_account_trafficlevel'],
                        'limitSoft'    => $GLOBALS['trafficLimits'][$this->settings['AffPlanet_account_type']][$this->settings['AffPlanet_account_trafficlevel']]['soft'],
                        'limitHard'    => $GLOBALS['trafficLimits'][$this->settings['AffPlanet_account_type']][$this->settings['AffPlanet_account_trafficlevel']]['hard']
                        );
        $logger->writeMonthlyTrafficLog($params);
        
        if ($transMonth > ($transLimit + $transBonus)) {
            $transDebet = $transMonth - ($transLimit+$transBonus);
            $transBonus = 0;
            if ($transDebet < $transBought) {
                $transBought -= $transDebet;
                $transDebet   = 0;
            } else {
                $transDebet -= $transBought;
                $transBought = 0;
            }
        } elseif ($transMonth > $transLimit) {
            $transBonus = 0;
        } else {
            if ($this->settings['Acct_limit_bonus_enabled'] == '1') {
                $transBonus = $transLimit - $transMonth;
            } else {
                $transBonus = 0;
            }
        }
        
        $transMonth = $transDebet;
        
        QCore_Settings::_update('Acct_limit_month_count', $transMonth, SETTINGTYPE_GLOBAL);
        $this->settings['Acct_limit_month_count'] = $transMonth;
        
        QCore_Settings::_update('Acct_limit_bought_trans', $transBought, SETTINGTYPE_GLOBAL);
        $this->settings['Acct_limit_bought_trans'] = $transBought;
        
        QCore_Settings::_update('Acct_limit_month_bonus', $transBonus, SETTINGTYPE_GLOBAL);
        $this->settings['Acct_limit_month_bonus'] = $transBonus;
    }
    
    //--------------------------------------------------------------------------
    
    function updateTransactionLimit($transtype) {
        
        $this->settings = array_merge($this->settings, QCore_Settings::getGlobalSettings());
        
        if ($this->settings['Acct_limit_enabled'] != '1')
            return false;
            
        if ($this->settings['Acct_limit_month_cleared'] < mktime(0, 0, 0, date("n"), 1, date("Y"))) {
            QCore_Settings::_update('Acct_limit_month_cleared', mktime(0, 0, 0, date("n"), 1, date("Y")), SETTINGTYPE_GLOBAL);
            $this->updateTrafficForNewMonth();
        }
        
        $limitSoft = $GLOBALS['trafficLimits'][$this->settings['AffPlanet_account_type']][$this->settings['AffPlanet_account_trafficlevel']]['soft'];
        $limitHard = $GLOBALS['trafficLimits'][$this->settings['AffPlanet_account_type']][$this->settings['AffPlanet_account_trafficlevel']]['hard'];

        if ($this->settings['Acct_limit_month_count'] > 
                ($limitSoft                                 + $this->settings['Acct_limit_month_bonus'] +
                 $this->settings['Acct_limit_bought_trans'] + $limitHard)) {

            return true;
        }
        
        if (($transtype == TRANSTYPE_LEAD) || ($transtype == TRANSTYPE_SALE)) {
            if ($this->settings['Acct_limit_type'] && LIMIT_COUNT_SALES != 0) {
                QCore_Settings::_update('Acct_limit_month_count', $this->settings['Acct_limit_month_count']+1, SETTINGTYPE_GLOBAL);
                $this->settings['Acct_limit_month_count'] += 1;
            }
        } elseif ($transtype == TRANSTYPE_CLICK) {
            if ($this->settings['Acct_limit_type'] && LIMIT_COUNT_CLICKS != 0) {
                QCore_Settings::_update('Acct_limit_month_count', $this->settings['Acct_limit_month_count']+1, SETTINGTYPE_GLOBAL);
                $this->settings['Acct_limit_month_count'] += 1;
            }
        }
        
        return false;
    }
    
	//--------------------------------------------------------------------------
    
    function isUserDeleted($userID, $accountID = '')
    {
        if($userID == '')
            return true;

        $sql = 'select deleted from wd_g_users u '.
               'where u.userid='._q($userID);
               
        if($accountID != '') {
            $sql .= '  and u.accountid='._q($accountID);
        } else {
            $sql .= '  and u.accountid='._q($this->AccountID);
        }
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            $this->registratorLog(WLOG_ERROR,  "Registrator: Error while getting user status", __FILE__, __LINE__);
            return false;
        }

        if($rs->EOF) {
            $this->registratorLog(WLOG_DEBUG,  "Registrator: User not found '".$userID."'", __FILE__, __LINE__);
            return false;
        }

        return ($rs->fields['deleted'] == '1');
    }
    
    //--------------------------------------------------------------------------
    
    function disableFraudProtection() {
        $this->disableFraudProtection = true;
    }
    
	//--------------------------------------------------------------------------
    
    function enableFraudProtection() {
        $this->disableFraudProtection = false;
    }
    
}
?>
