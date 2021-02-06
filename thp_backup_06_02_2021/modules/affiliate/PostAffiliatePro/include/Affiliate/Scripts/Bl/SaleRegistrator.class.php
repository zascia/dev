<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Scripts_Bl_Registrator');

class Affiliate_Scripts_Bl_SaleRegistrator extends Affiliate_Scripts_Bl_Registrator
{
    var $className = 'Affiliate_Scripts_Bl_SaleRegistrator';
    var $multiTierSaleCommissionsCounter = 0;
    var $multiTierSaleRecurCommissionsCounter = 0;
    var $blRules;
    var $blEmailTemplates;
    var $blCommunications;
    var $trackingMethod = 0;

    //--------------------------------------------------------------------------

    function Affiliate_Scripts_Bl_SaleRegistrator()
    {
        Affiliate_Scripts_Bl_Registrator::Affiliate_Scripts_Bl_Registrator();
        $this->blRules =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Rules');
        $this->blEmailTemplates =& QUnit_Global::newObj('QCore_EmailTemplates');
        $this->blCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');
        $this->registration_type = 'SaleRegistrator';
    }

    //--------------------------------------------------------------------------

    function setAccountID() {
        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_PRO
            || $GLOBALS['Auth']->getProgramType() == PROG_TYPE_ECOMMAGNET
            || $GLOBALS['Auth']->getProgramType() == PROG_TYPE_LITE)
        {
            $GLOBALS['Auth']->setAccountID(DEFAULT_ACCOUNT);
        } else {
            if($GLOBALS['Auth']->getAccountID() == '') {
                QCore_History::log(WLOG_ERROR, "Click registration: Cannot recognize account from domain '".getHostName()."'", __FILE__, __LINE__);
                return;
            }
        }

        $this->settings['Aff_debug_sales'] = $GLOBALS['Auth']->getSettingForScripts('Aff_debug_sales');
        $GLOBALS['Auth']->setUserType(USERTYPE_ADMIN);
    }

    //--------------------------------------------------------------------------

    function setdefaultAccountID() {
        $this->AccountID = DEFAULT_ACCOUNT;
    }

    //--------------------------------------------------------------------------

    function findPaymentBySubscriptionID($orderID)
    {
        if(trim($orderID) == '')
            return false;

        // search transactions if we'll find sale with this order ID
        $sql = "select * from wd_pa_transactions where transtype in ('".TRANSTYPE_SALE."', '".TRANSTYPE_LEAD."') and transkind=".TRANSKIND_NORMAL.
               " and orderid="._q(trim($orderID))." and accountid="._q($this->AccountID);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration:  Error checking for initial subscription payment for transaction '$orderID'", __FILE__, __LINE__);
            return false;
        }

        if($rs->EOF) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration:  No initial subscription payment for transaction '$orderID' found.", __FILE__, __LINE__);
            return false;
        }

        $userID = $rs->fields['affiliateid'];

        // find campaign
        $sql = 'select * from wd_pa_campaigncategories '.
               'where deleted=0 and campcategoryid='._q($rs->fields['campcategoryid']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration:  Error checking for campaign of initial subscription payment for transaction '$orderID'", __FILE__, __LINE__);
            return false;
        }

        if($rs->EOF) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration:  No campaign for initial subscription payment for transaction '$orderID' found.", __FILE__, __LINE__);
            return false;
        }

        $campaignID = $rs->fields['campaignid'];

        if(!$this->initData($userID, $campaignID)) {
            return false;
        } else {
            // put recurring comissions instead of sale commissions, so that
            // recurring subscriptions use the correct commission
            $this->SaleCommission = $this->RecurringCommission;

            for($i=2; $i<=$this->maxCommissionLevels; $i++)
            {
                $this->STSaleCommission[$i] = $this->STRecurringCommission[$i];
            }

            return true;
        }
    }

    //--------------------------------------------------------------------------

    function setSaleTypeAndKind($type, $kind)
    {
        if(in_array($type, array(TRANSTYPE_CLICK, TRANSTYPE_SALE, TRANSTYPE_RECURRING))) {
            $this->saleType = $type;
        }

        if(in_array($kind, array(TRANSKIND_NORMAL, TRANSKIND_SECONDTIER, TRANSKIND_RECURRING))) {
            $this->saleKind = $kind;
        }

        return true;
    }

    //--------------------------------------------------------------------------
    /** decodes data from cookie or other source,
    * finds user id and campaign id
    */
    function decodeData($value, $userID = '')
    {
        $data = false;

        // decode from userid
        if ($userID != '') {
            if ($this->checkUserExists($userID)) {
                $data = $this->getUsersCampaign($this->UserID);
                $this->trackingMethod = SALE_TRACKING_AFFILIATEID;
            }
        }

        if(!$data && isset($_REQUEST['fsc']) && $_REQUEST['fsc'] != '') {
            // decode from 1st party cookie
            $data = $this->decodeValue($_REQUEST['fsc']);
            if($data != false) {
                $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Tracking referrer from 1st party cookie", __FILE__, __LINE__);
                if (isset($_REQUEST['trackingMethod']) && ($_REQUEST['trackingMethod'] == SALE_TRACKING_FLASH)) {
                    $this->trackingMethod = SALE_TRACKING_FLASH;
                } else {
                    $this->trackingMethod = SALE_TRACKING_1STPARTY_COOKIE;
                }

                // load extra data
                if($_REQUEST['data1'] != '') $this->extraData1 = $_REQUEST['data1'];
                if($_REQUEST['data2'] != '') $this->extraData2 = $_REQUEST['data2'];
                if($_REQUEST['data3'] != '') $this->extraData3 = $_REQUEST['data3'];

                // check if the value is correct
                if($this->initData($data[0], $data[1])) {
                    return true;//$this->correctRecurringCommissions(true);
                } else {
                    $data = false;
                }
            }
        }

        // decode from cookie
        if(!$data) {
            $data = $this->decodeValue($value, $userID);
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Tracking referrer from 3rd party cookie", __FILE__, __LINE__);
            $this->trackingMethod = SALE_TRACKING_COOKIE;
        }

        $this->settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $this->AccountID);

        // decode from session
        if(!$data && $this->settings['Aff_track_by_session'] == 1) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Tracking referrer from session", __FILE__, __LINE__);
            $data = $this->decodeValue($_SESSION[COOKIE_NAME]);
            $this->trackingMethod = SALE_TRACKING_SESSION;
        }

        // decode from IP
        if(!$data && $this->settings['Aff_track_by_ip'] == 1) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Tracking referrer from IP", __FILE__, __LINE__);
            $data = $this->decodeFromIP($value);
            $this->trackingMethod = SALE_TRACKING_IP;
        }

        // use referred affiliate
        if(!$data && $this->settings['Aff_referred_affiliate_allow'] == 1) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Using default affiliate to save transaction", __FILE__, __LINE__);
            $data = $this->getUsersCampaign($this->settings['Aff_referred_affiliate']);
            $this->trackingMethod = SALE_TRACKING_REFERRED;
        }

        if(!$data) return false;
        if(isset($data[2])) $this->extraData1 = $data[2];
        if(isset($data[3])) $this->extraData2 = $data[3];
        if(isset($data[4])) $this->extraData3 = $data[4];

        return $this->initData($data[0], $data[1]);
    }

    //--------------------------------------------------------------------------

    function correctRecurringCommissions($retval)
    {
        if(!$retval) {
            return false;
        }

        $this->SaleCommission = $this->RecurringCommission;
        $this->PerSaleCommType = $this->RecurringCommType;
        $this->STPerSaleCommType = $this->STRecurringCommType;

        $this->maxCommissionLevels = $this->settings['Aff_maxcommissionlevels'];
        if($this->maxCommissionLevels == '')
            $this->maxCommissionLevels = 1;

        $this->STSaleCommission = array();

        for($i=2; $i<=$this->maxCommissionLevels; $i++)
        {
            $this->STSaleCommission[$i] = $this->STRecurringCommission[$i];
        }
        return true;
    }

    //--------------------------------------------------------------------------

    function initData($userID, $campaignID)
    {
        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Referer recognized (User ID: $userID, Product category ID: $campaignID)", __FILE__, __LINE__);

        //------------------------------------------------------------------------
        // check user and campaign

        if(!$this->checkUserExists($userID)) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration:  User with ID '$userID' doesn't exist", __FILE__, __LINE__);
            return false;
        }
        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration:  After checking that user '$userID' exists, OK", __FILE__, __LINE__);

        if(!$this->checkCampaignExists($campaignID)) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration:  Campaign with ID '$campaignID' doesn't exist", __FILE__, __LINE__);
            return false;
        }
        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration:  After checking that campaign '$campaignID' exists, OK", __FILE__, __LINE__);

        if(!$this->checkUserInCampaign())
        {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration:  User ID '$userID' doesn't belong to the campaign ID '$campaignID'", __FILE__, __LINE__);
            return false;
        }
        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration:  After checking that user exists in campaign, OK", __FILE__, __LINE__);

        return true;
    }

    //--------------------------------------------------------------------------
    /** if it's subscription payment, disable IP fraud protection, because there 
    is no problem with this
    */
    function registerSale($totalCost, $OrderID, $ProductID, $isSubscription = false)
    {
        $this->loadLanguage();

        $original_totalCost = $totalCost;
      	$fixedCost = $this->settings['Aff_fixed_cost'];

        if ($this->settings['Aff_fixed_cost_unit'] == '%') {
        	$totalCost = $totalCost - $totalCost*($fixedCost/100.0);
        } else {
        	$totalCost = $totalCost - $fixedCost;
        }

        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Compute total cost = total cost - fixed cost: ".$totalCost."=".$totalCost."-".$fixedCost, __FILE__, __LINE__);

        if($this->CampaignCommType == TRANSTYPE_CLICK) {
            // we dont need to save click transactions
            // as they are registered already
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: It is only per click product category", __FILE__, __LINE__);
            return true;
        }

        $remoteAddr = $_SERVER['HTTP_REFERER'];
        $ip = $_SERVER['REMOTE_ADDR'];

        if($this->SaleTransactionApproval == APPROVE_MANUAL) {
            $status = AFFSTATUS_NOTAPPROVED;
        } else {
            $status = AFFSTATUS_APPROVED;
        }

        if(!is_numeric($totalCost)) {
            $totalCost = 0;
        }

        if(!is_numeric($original_totalCost) || $original_totalCost < 0) {
            $original_totalCost = 0;
        }

        //------------------------------------------------------------------------
        // check whether to force product_id-based lookup for commission category
        if($ProductID != '' && $this->settings['Aff_forcecommfromproductid'] == 'yes') {
            $result = $this->lookupForProductCategory($ProductID);

            if($result == false && $this->settings['Aff_apply_from_banner'] != '1') {
                $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: No category for ProductID '$ProductID' found for transaction '$OrderID'", __FILE__, __LINE__);
                return false;
            }
        }

        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: After lookup for product category, OK", __FILE__, __LINE__);

        //------------------------------------------------------------------------
        // check fraud protection
        if(!$this->applyFraudProtection($ip, $status, $OrderID, $isSubscription)) {
            return false;
        }

        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: After fraud protection, OK", __FILE__, __LINE__);

        //------------------------------------------------------------------------
        // check geoip protection
        $country = array('countrycode' => '__', 'countryname' => 'Unknown');
        $isAllowedCountry = true;

        if($this->settings['Glob_acct_geo_allowed'] == '1') {
            $blIpCountry = QUnit_Global::newObj('QCore_Bl_IpCountry');
            $country = $blIpCountry->getCountryForIp($ip);
            if(!$blIpCountry->isAllowedCountry($country, $this->settings) && $this->settings['Glob_acct_geo_dont_register_sale'] == '1') {
                $this->registratorLog(WLOG_DEBUG, "Sale registration: Country from IP '$ip' is not in list of allowed countries", __FILE__, __LINE__);
                return false;
            }
        }

        //------------------------------------------------------------------------
        // compute commission
        if(!($this->CampaignCommType & TRANSTYPE_SALE) && !($this->CampaignCommType & TRANSTYPE_LEAD)) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Campaign category is not sale or lead", __FILE__, __LINE__);
            return true;
        }

        $commission = $this->computeCommission($totalCost, $this->PerSaleCommType, $this->SaleCommission);

        if($commission == 0) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Commission is zero", __FILE__, __LINE__);
        }

        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: After computing commission, OK", __FILE__, __LINE__);

        $this->setSaleKindAndTypeByCommType();

        if ($this->updateTransactionLimit(TRANSTYPE_SALE))
            return true;

        //------------------------------------------------------------------------
        // insert sale
        $params = array('OrderID' => $OrderID,
                        'ProductID' => $ProductID,
                        'original_totalCost' => $original_totalCost,
                        'remoteAddr' => $remoteAddr,
                        'ip' => $ip,
                        'countrycode' => $country['countrycode'],
                        'status' => $status,
                        'commission' => $commission
                       );
        if(($TransID = $this->insertSale($params)) == false) return false;
        
        $this->saveSaleSettings($TransID);

        QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rules');

        $params = array('UserID' => $this->UserID,
                        'AccountID' => $this->AccountID,
                        'decimal_places' => $this->settings['Aff_round_numbers']
                       );

        if(($rules = $this->blRules->getRulesAsArray($params)) !== false) {
            $this->blRules->checkPerformanceRules($params, $rules);
        }

        //----------------------------------------
        // send notifications
        $params = array();
        $params['id'] = $TransID;
        $params['commission'] = $commission;
        $params['totalcost'] = $totalCost;
        $params['orderid'] = $OrderID;
        $params['productid'] = $ProductID;
        $params['date'] = date("Y-m-d H:i:s");
        $params['userid'] = $this->UserID;
        $params['status'] = $status;
        $params['ip'] = $ip;
        $params['referrer'] = $remoteAddr;
        $params['data1'] = $this->extraData1;
        $params['data2'] = $this->extraData2;
        $params['data3'] = $this->extraData3;

        if($status != AFFSTATUS_SUPPRESSED) {
            $this->sendNotificationToMerchant($params);
        }

        if($status != AFFSTATUS_SUPPRESSED) {
            $this->sendNotificationToUser($params);
        }
        
        if($status != AFFSTATUS_SUPPRESSED) {
            $this->sendNotificationToParent($params);
        }
        
        if($this->settings['Aff_delete_cookie'] == 1) {
            $this->deleteCookies();
        }
        
        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: After sending notifications, OK", __FILE__, __LINE__);
        
        if($commission != 0) {
            // dont save multi tier when commission is zero
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Start registering multi tier commissions", __FILE__, __LINE__);

            //------------------------------------------
            // register multi tier sale commissions
            $this->registerMultiTierSaleCommission($TransID, $OrderID, $ProductID, $totalCost, $remoteAddr, $ip, $status, $this->UserID, 2);

            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: After registering multi tier commissions", __FILE__, __LINE__);
        }

        //------------------------------------------------------------------------
        // insert recurring commission
        if($this->settings['Aff_support_recurring_commissions'] != 1 || $this->RecurringCommission == '' || $this->RecurringCommission == '0') {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: No recurring commissions found", __FILE__, __LINE__);

            return true;
        }

        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Start registering recurring commissions", __FILE__, __LINE__);

        $commission = $this->computeCommission($totalCost, $this->RecurringCommType, $this->RecurringCommission);
        
        $params = array('status' => $status,
                        'TransID' => $TransID
                       );

        if(($RecurringCommissionID = $this->insertRecurringCommission($params)) === false) return false;

        //------------------------------------------
        // register multi tier recurring commissions
        $this->registerMultiTierRecurringCommission($RecurringCommissionID, $totalCost, $this->UserID, 2);

        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: After registering recurring commissions", __FILE__, __LINE__);

        return true;
    }

    //--------------------------------------------------------------------------

    function saveSaleSettings($TransID) {
        if (isset($_REQUEST['fstc']) && ($_REQUEST['fstc'] != '') && ($this->trackingMethod != SALE_TRACKING_COOKIE)) {
            $data = $_REQUEST['fstc'];
        } else {
            $data = $_COOKIE[TIME_COOKIE_NAME];
        }
        $arr = explode("_", $data);

        if ($arr[0] == "") $arr[0] = "NULL";
        if ($arr[1] == "") $arr[1] = "NULL";
        if (($arr[2] == "") || (!is_numeric($arr[2]))) $arr[2] = "NULL";

        if (isset($_REQUEST['forc']) && ($_REQUEST['forc'] != '') && ($this->trackingMethod != SALE_TRACKING_COOKIE)) {
            $data = $_REQUEST['forc'];
        } else {
            $data = $_COOKIE[REF_COOKIE_NAME];
        }

        $ref = explode("_", $data, 2);

        if ($ref[0] == "") $ref[0] = "NULL";

        $saleSetting = $this->trackingMethod."_".$arr[0]."_".$arr[1]."_".$arr[2]."_".$ref[0]."_".$ref[1];
        QCore_Settings::_update('Sale_information', $saleSetting, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountId(), '', $TransID);
    }

    //--------------------------------------------------------------------------

    function lookupForProductCategory($ProductID)
    {
        // check if there exist some product category that contains this product
        $ProductID = preg_replace('/[\'\"]/', '', $ProductID);

        $sql = "select * from wd_pa_campaigns where deleted=0 and products like'%"._q_noendtags($ProductID)."%'";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration:   Error saving 2nd tier recurring commission", __FILE__, __LINE__);
            return false;
        }

        while(!$rs->EOF) {
            $products = $rs->fields['products'];

            $parts = explode(';', $products);

            foreach($parts as $product_id) {
                $product_id = trim($product_id);

                if($product_id == $ProductID) {
                    if($this->affiliateHasAccessToTheCampaign($rs->fields['campaignid'])) {
                        // we found it
                        if($this->setNewProductCategory($rs->fields['campaignid']) === true) {
                            $this->CampaignCommType = $rs->fields['commtype'];

                            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Commission from new product category applied (according to Product ID '$ProductID')", __FILE__, __LINE__);
                            return true;
                        }
                    }
                }
            }

            $rs->MoveNext();
        }

        return false;
    }
    
    //--------------------------------------------------------------------------

    function affiliateHasAccessToTheCampaign($campaignID) {
        QUnit_Global::includeClass('Affiliate_Affiliates_Bl_Settings');
        $params = array('accountid' => 'default1');
        $affs_camp = Affiliate_Affiliates_Bl_Settings::getAffCampaignSettings($params);
        
        $params = array('userID' => $this->UserID);
        QUnit_Global::includeClass('Affiliate_Affiliates_Bl_Affiliate');
        $affcamps = Affiliate_Affiliates_Bl_Affiliate::getAffiliateCampaignsStatus($params);
        
        if($affs_camp[$campaignID][SETTINGTYPEPREFIX_AFF_CAMP.'status'] == AFF_CAMP_PRIVATE
           && $affcamps[$campaignID] != AFFSTATUS_APPROVED)
        {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Affiliate does not belong to the private campaign '$campaignID' found by Product ID '$ProductID'", __FILE__, __LINE__);
            return false;
        } else {
            return true;
        }
    }

    //--------------------------------------------------------------------------

    function setNewProductCategory($campaignID)
    {
        // check in which comm. category user is & set the correct commissions
        $sql = 'select cc.* from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campaignid='._q($campaignID).
               '  and cc.campcategoryid=ac.campcategoryid'.
               '  and cc.deleted=0 and affiliateid='._q($this->UserID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;

        if($rs->EOF)
        {
            // get basic commission category for this campaign
            $sql = 'select * from wd_pa_campaigncategories '.
                   'where deleted=0 and campaignid='._q($campaignID).
                   '  and name='._q(UNASSIGNED_USERS);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
                return false;
        }

        $this->CampaignID = $rs->fields['campaignid'];
        $this->CampaignCategoryID = $rs->fields['campcategoryid'];
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
    /** if it is subscription, disable check for duplicated sales by IP, because
    * it doesn't work in this situation 
    */
    function applyFraudProtection($ip, &$status, $OrderID, $isSubscription = false)
    {
        if ($this->disableFraudProtection) return true;
        
        if(!$isSubscription && $this->DeclineFrequentSales == 1)
        {
            // find initial click (first non-declined within this day)
            $sql = "select dateinserted as aa from wd_pa_transactions ".
                "where transtype in (".TRANSTYPE_SALE.",".TRANSTYPE_LEAD.")".
                "  and transkind=".TRANSKIND_NORMAL." and ip="._q($ip).
                "  and rstatus<>".AFFSTATUS_SUPPRESSED.
                "  and (".sqlTimeToSec(sqlNow())." - ".sqlTimeToSec('dateinserted')."<".$this->SaleFrequency.")";
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$ret) {
                $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: (fraud protection): Error saving transaction 1", __FILE__, __LINE__);
                return false;
            }

            if(!$ret->EOF) {
                if($this->FrequentSales == 2) {
                    return false;
                }

                // decline the transaction
                $status = AFFSTATUS_SUPPRESSED;
            }
        }

        if($OrderID != '' && $this->DeclineSameOrderId == 1) {
            // find initial click with same OrderID
            $sql = "select orderid as aa from wd_pa_transactions ".
                "where transtype in (".TRANSTYPE_SALE.",".TRANSTYPE_LEAD.")".
                "  and transkind=".TRANSKIND_NORMAL.
                "  and ip="._q($ip)." and rstatus<>".AFFSTATUS_SUPPRESSED.
                "  and OrderID="._q($OrderID).
                "  and AccountID="._q($this->AccountID);
            if ($this->SaleOrderIdFrequency > 0) {
                $sql .= "  and (".sqlTimeToSec(sqlNow())." - ".sqlTimeToSec('dateinserted')."<".($this->SaleOrderIdFrequency*3600).")";
            }
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            if (!$ret) {
                $this->registratorLog(WLOG_ERROR, "Sale/Lead registration: (fraud protection) Error saving transaction 2", __FILE__, __LINE__);
                return false;
            }

            if(!$ret->EOF)
            {
                // decline the transaction
                $status = AFFSTATUS_SUPPRESSED;
            }
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function computeCommission($totalCost, $commType, $saleCommission)
    {
        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: total cost: $totalCost, comm type: $commType, sale commision: $saleCommission", __FILE__, __LINE__);
        $commission = 0;
        if($totalCost == '' || !is_numeric($totalCost))
            $totalCost = 0;

        // compute commission
        if($commType == '%')
        {
            if($totalCost == '')
            $totalCost = 0;
            
            if ($this->settings['Aff_round_numbers'] != '' && $this->settings['Aff_round_numbers'] > 0) {
                $roundNumbers = $this->settings['Aff_round_numbers'];
            } else {
                $roundNumbers = 2;
            }

            $commission = round(($totalCost * $saleCommission)/100, $roundNumbers);
        }
        else
            $commission = $saleCommission;

        if($commission == '')
            $commission = 0;

        return $commission;
    }

    //--------------------------------------------------------------------------

    function setSaleKindAndTypeByCommType()
    {
        if($this->saleKind == '') $this->saleKind = TRANSKIND_NORMAL;

        if($this->saleType == '' && ($this->CampaignCommType & TRANSTYPE_SALE))
        {
            $this->saleType = TRANSTYPE_SALE;
        }
        if($this->saleType == '' && ($this->CampaignCommType & TRANSTYPE_LEAD))
        {
            $this->saleType = TRANSTYPE_LEAD;
        }
    }

    //--------------------------------------------------------------------------

    function insertSale($params)
    {
        $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');

        $sql = "insert into wd_pa_transactions(".
            "transid,accountid,affiliateid,campcategoryid,dateinserted,orderid,".
            "productid,totalcost,transtype,transkind,refererurl,ip,countrycode,".
            "rstatus,commission,data1,data2,data3)".
            "values("._q($TransID).","._q($this->AccountID).
            ","._q($this->UserID).","._q($this->CampaignCategoryID).",".sqlNow().
            ","._q($params['OrderID']).","._q($params['ProductID']).","._q($params['original_totalCost']).
            ",".$this->saleType.",".$this->saleKind.","._q($params['remoteAddr']).
            ","._q($params['ip']).","._q($params['countrycode']).
            ",".$params['status'].","._q($params['commission']).
            ","._q($this->extraData1).","._q($this->extraData2).","._q($this->extraData3).")";

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret) {
            $this->registratorLog(WLOG_ERROR, "Sale/Lead registration: Error saving sale", __FILE__, __LINE__);
            return false;
        }

        $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: After inserting sale (ID: $TransID)", __FILE__, __LINE__);

        if($params['status'] == AFFSTATUS_APPROVED)
        {
            $params = array('users' => array($this->UserID),
                            'AccountID' => $this->AccountID,
                            'decimal_places' => $this->settings['Aff_round_numbers']
                           );

            if(($rules = $this->blRules->getRulesAsArray($params)) !== false)
                $this->blRules->checkPerformanceRules($params, $rules);
        }

        return $TransID;
    }

    //--------------------------------------------------------------------------

    function sendNotificationToMerchant($params)
    {
        if($this->settings['Aff_email_onsale'] != 1) {
            $this->registratorLogEmail(WLOG_DEBUG, "Sale/Lead registration: Merchant has not set on-sale email notifications", __FILE__, __LINE__);
            return false;
        }

        $emaildata = $this->blEmailTemplates->getFilledEmailMessage($params['id'], $this->AccountID, 'AFF_EMAIL_NTF_SALE', $this->settings['Aff_default_lang'], $params);

        if($emaildata != false)
        {
            $systemEmail = $this->settings['Aff_notifications_email'];

            $email_params = array('accountid' => $this->AccountID,
                                  'subject' => $emaildata['subject'],
                                  'text' => $emaildata['text'],
                                  'message_type' => MESSAGETYPE_EMAIL,
                                  'userid' => '',
                                  'email' => $systemEmail,
                                  'settings' => $this->settings
            );

            if(!$this->blCommunications->sendEmail($email_params)) {
                $this->registratorLogEmail(WLOG_ERROR, "Sale/Lead registration: There was a problem sending merchant notification email about sale transaction ID '".$params['id']."' to '$systemEmail'", __FILE__, __LINE__);
                showMsg(L_G_EMAILSEND, __FILE__, __LINE__);
            } else {
                $this->registratorLogEmail(WLOG_DEBUG, "Sale/Lead registration: Sale registration merchant notification email about sale transaction ID '".$params['id']."' was succesfully generated and sent to '$systemEmail'", __FILE__, __LINE__);
                return true;
            }
        }
        else {
            $this->registratorLogEmail(WLOG_ERROR, "Sale/Lead registration: There was a problem generating merchant notification email about sale transaction ID '".$params['id']."' from template", __FILE__, __LINE__);
            showMsg(L_G_EMAILTEMPERR, __FILE__, __LINE__);
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function sendNotificationToUser($params)
    {
        $ntfSettings = QCore_Settings::getUserSettings(SETTINGTYPE_USER, $this->AccountID, $this->UserID);

        // check whether to send notification email to user
        if($ntfSettings['Aff_email_affonsale'] != 1) {
            $this->registratorLogEmail(WLOG_DEBUG, "Sale/Lead registration: Affiliate has not set on-sale email notifications", __FILE__, __LINE__);
            return;
        }

        $lang = $ntfSettings['Aff_aff_notificationlang'];

        $emaildata = $this->blEmailTemplates->getFilledEmailMessage($params['id'], $this->AccountID, 'AFF_EMAIL_AF_NTF_SLE', $lang, $params);

        if($emaildata != false)
        {
            $email = QCore_Auth::getUsernameForUser($this->UserID, $this->AccountID);

            $email_params = array('accountid' => $this->AccountID,
                                  'subject' => $emaildata['subject'],
                                  'text' => $emaildata['text'],
                                  'message_type' => MESSAGETYPE_EMAIL,
                                  'userid' => $this->UserID,
                                  'email' => $email,
                                  'settings' => $this->settings
            );

            if(!$this->blCommunications->sendEmail($email_params)) {
                $this->registratorLogEmail(WLOG_ERROR, "Sale/Lead registration: There was a problem sending user notification email about sale transaction ID '".$params['id']."' to '$email'", __FILE__, __LINE__);
                showMsg(L_G_EMAILSEND, __FILE__, __LINE__);
            } else {
                $this->registratorLogEmail(WLOG_DEBUG, "Sale/Lead registration: Sale registration user notification email about sale transaction ID '".$params['id']."' was succesfully generated and sent to '$email'", __FILE__, __LINE__);
                return true;
            }
        }
        else {
            $this->registratorLogEmail(WLOG_DEBUG, "Sale/Lead registration: There was a problem generating user notification email about sale transaction ID '".$params['id']."' from template", __FILE__, __LINE__);
            showMsg(L_G_EMAILTEMPERR, __FILE__, __LINE__);
        }

        return false;
    }
    
    //--------------------------------------------------------------------------

    function sendNotificationToParent($params)
    {
        if ($this->ParentUserID == '' || $this->ParentUserID == 0)
            return;   
            
        $ntfSettings = QCore_Settings::getUserSettings(SETTINGTYPE_USER, $this->AccountID, $this->ParentUserID);

        // check whether to send notification email to parent user
        if($ntfSettings['Aff_email_paraffonsale'] != 1) {
            $this->registratorLogEmail(WLOG_DEBUG, "Sale/Lead registration: Affiliate has not set on-sale email notifications", __FILE__, __LINE__);
            return;
        }

        $lang = $ntfSettings['Aff_aff_notificationlang'];

        $emaildata = $this->blEmailTemplates->getFilledEmailMessage($params['id'], $this->AccountID, 'AFF_EMAIL_AF_PAR_SLE', $lang, $params);

        if($emaildata != false)
        {
            $email = QCore_Auth::getUsernameForUser($this->ParentUserID, $this->AccountID);

            $email_params = array('accountid' => $this->AccountID,
                                  'subject' => $emaildata['subject'],
                                  'text' => $emaildata['text'],
                                  'message_type' => MESSAGETYPE_EMAIL,
                                  'userid' => $this->ParentUserID,
                                  'email' => $email,
                                  'settings' => $this->settings
            );

            if(!$this->blCommunications->sendEmail($email_params)) {
                $this->registratorLogEmail(WLOG_ERROR, "Sale/Lead registration: There was a problem sending parent user notification email about sale transaction ID '".$params['id']."' to '$email'", __FILE__, __LINE__);
                showMsg(L_G_EMAILSEND, __FILE__, __LINE__);
            } else {
                $this->registratorLogEmail(WLOG_DEBUG, "Sale/Lead registration: Sale registration parent user notification email about sale transaction ID '".$params['id']."' was succesfully generated and sent to '$email'", __FILE__, __LINE__);
                return true;
            }
        }
        else {
            $this->registratorLogEmail(WLOG_DEBUG, "Sale/Lead registration: There was a problem generating parent user notification email about sale transaction ID '".$params['id']."' from template", __FILE__, __LINE__);
            showMsg(L_G_EMAILTEMPERR, __FILE__, __LINE__);
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function registerMultiTierSaleCommission($parentTransID, $OrderID, $ProductID, $totalCost, $remoteAddr, $ip, $status, $parentUserID, $tier, $maxRecursion = 50)
    {
        if($maxRecursion <= 0) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Maximum recursion reached", __FILE__, __LINE__);
            return false;
        }

        if($tier > $this->maxCommissionLevels) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Maximum tier levels reached", __FILE__, __LINE__);
            return false;
        }

        //----------------------------------------
        // get parent user for this child
        $params = array('parentUserID' => $parentUserID, 'status' => $status);

        if(($params = $this->getParentUser($params)) == false) return false;

        $userID = $params['userID'];
        $status = $params['status'];
        $deleted = $this->isUserDeleted($userID);
        
        if ($deleted == false) {
            //---------------------------------------
            // check if this user is not assigned in some special user commission category for this product category
            $params = array('userID' => $userID, 'tier' => $tier);

            if($this->checkSpecialComm($params) === false) return false;

            //----------------------------------------
            // compute commission in this tier
            if(!($this->CampaignCommType & TRANSTYPE_SALE) && !($this->CampaignCommType & TRANSTYPE_LEAD)) {
                $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Campaign type is not per sale/lead", __FILE__, __LINE__);
                return false;
            }

            // compute commission
            $commission = $this->computeCommission($totalCost, $this->STPerSaleCommType, $this->STSaleCommission[$tier]);

            if($commission != 0)
            {
                //----------------------------------------
                // register commission

                if ($this->updateTransactionLimit(TRANSTYPE_SALE))
                    return true;

                $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
                $sql = "insert into wd_pa_transactions(".
                        "transid,accountid,parenttransid,affiliateid,campcategoryid,".
                        "dateinserted,orderid,productid,totalcost,transtype,transkind,".
                        "refererurl,ip,rstatus,commission,
                        data1,data2,data3)".
                        "values("._q($TransID).","._q($this->AccountID).
                        ","._qOrNull($parentTransID).","._q($userID).
                        ","._q($this->CampaignCategoryID).",".sqlNow().", "._q($OrderID).
                        ","._q($ProductID).",0,".$this->saleType.
                        ",".(TRANSKIND_SECONDTIER+$tier).","._q($remoteAddr).","._q($ip).
                        ",$status,"._q($commission).","._q($this->extraData1).
                        ","._q($this->extraData2).","._q($this->extraData3).")";
                $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                if(!$ret) {
                    $this->registratorLog(WLOG_ERROR, "Sale/Lead registration: Error saving $tier - tier sale commission", __FILE__, __LINE__);
                    return false;
                }

                $this->multiTierSaleCommissionsCounter++;
    
                if($status == AFFSTATUS_APPROVED)
                {
                    $params = array('users' => array($userID),
                                    'AccountID' => $this->AccountID,
                                    'decimal_places' => $this->settings['Aff_round_numbers']
                                   );

                    if(($rules = $this->blRules->getRulesAsArray($params)) !== false) {
                        $this->blRules->checkPerformanceRules($params, $rules);
                    }
                }
            }
        }

        //----------------------------------------
        // go recursively to the next tier
        if($tier < $this->maxCommissionLevels)
        {
            $this->registerMultiTierSaleCommission($TransID, $OrderID, $ProductID, $totalCost, $remoteAddr, $ip, $status, $userID, $tier + 1, $maxRecursion - 1);
        }
    }

    //--------------------------------------------------------------------------

    function insertRecurringCommission($params)
    {
        if ($this->RecurringCommDate == '') $this->RecurringCommDate = 0;
        $RecurringCommissionID = QCore_Sql_DBUnit::createUniqueID('wd_pa_recurringcommissions', 'recurringcommid');
        $sql = "insert into wd_pa_recurringcommissions ".
            "(recurringcommid,originaltransid,affiliateid,campcategoryid,".
            "dateinserted,commission,commtype,commdate,datetype,rstatus)".
            "values("._q($RecurringCommissionID).","._q($params['TransID']).
            ","._q($this->UserID).","._q($this->CampaignCategoryID).",".sqlNow().
            ","._q($this->RecurringCommission).","._q($this->RecurringCommType).
            ","._q($this->RecurringCommDate).","._q($this->RecurringDateType).
            ","._q($params['status']).")";
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$ret)
        {
            $this->registratorLog(WLOG_ERROR, "Sale/Lead registration: Error saving recurring commission", __FILE__, __LINE__);
            return false;
        }

        return $RecurringCommissionID;
    }

    //--------------------------------------------------------------------------

    function registerMultiTierRecurringCommission($parentTransID, $totalCost, $parentUserID, $tier, $maxRecursion = 50)
    {
        if($maxRecursion <= 0) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Maximum recursion reached", __FILE__, __LINE__);
            return;
        }

        if($tier > $this->maxCommissionLevels) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Maximum tier levels reached", __FILE__, __LINE__);
            return;
        }

        //----------------------------------------
        // get parent user for this child
        $params = array('parentUserID' => $parentUserID, 'status' => $status);

        if(($params = $this->getParentUser($params)) === false) return false;

        $userID = $params['userID'];
        $status = $params['status'];
        $deleted = $this->isUserDeleted($userID);
        
        if ($deleted == false) {
            //---------------------------------------
            // check if this user is not assigned in some special user commission category for this product category
            $params = array('userID' => $userID, 'tier' => $tier);
    
            if($this->checkRecurSpecialComm($params) === false) return false;

            //----------------------------------------
            // compute commission
            $commission = $this->computeCommission($totalCost, $this->STRecurringCommType, $this->STRecurringCommission[$tier]);

            //----------------------------------------
            // register commission
            $sql = "update wd_pa_recurringcommissions ".
                "set st".$tier."commission="._q($commission).",".
                "    stcommtype="._q($this->STRecurringCommType).",".
                "    st".$tier."affiliateid="._q($userID).
                " where recurringcommid="._q($parentTransID);
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$ret) {
                $this->registratorLog(WLOG_ERROR, "Sale/Lead registration: Error saving $tier - tier recurring commission", __FILE__, __LINE__);
                return false;
            }
        
            $this->multiTierSaleRecurCommissionsCounter++;
        }

        //----------------------------------------
        // go recursively to the next tier
        if($tier < $this->maxCommissionLevels) {
            $this->registerMultiTierRecurringCommission($parentTransID, $totalCost, $userID, $tier + 1, $maxRecursion -1);
        }
    }

    //--------------------------------------------------------------------------

    function checkSpecialComm($params)
    {
        $sql = 'select cc.* from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campaignid='._q($this->CampaignID).
               '  and cc.campcategoryid=ac.campcategoryid'.
               '  and affiliateid='._q($params['userID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Error get special commission", __FILE__, __LINE__);
            return false;
        }

        if(!$rs->EOF) {
            if($this->CampaignCategoryID != $rs->fields['campcategoryid']) {
                // user is in different commission category, get the commission level
                $this->STSaleCommission[$params['tier']] = $rs->fields['st'.$params['tier'].'salecommission'];
            }
        } else {
            // get commission from default commission category
            $sql = 'select * from wd_pa_campaigncategories '.
                   'where deleted=0 and campaignid='._q($this->CampaignID).
                   '  and name='._q(UNASSIGNED_USERS);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF) {
                $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Can not get basic category for campaign with ID:".$this->CampaignID, __FILE__, __LINE__);
                return false;
            }

            $this->STSaleCommission[$params['tier']] = $rs->fields['st'.$params['tier'].'salecommission'];
        }
    }

    //--------------------------------------------------------------------------

    function checkRecurSpecialComm($params)
    {
        $sql = 'select cc.* from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campaignid='._q($this->CampaignID).
               '  and cc.campcategoryid=ac.campcategoryid'.
               '  and affiliateid='._q($params['userID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Error get recurring special commission", __FILE__, __LINE__);
            return false;
        }

        if(!$rs->EOF)
        {
            if($this->CampaignCategoryID != $rs->fields['campcategoryid'])
            {
                // user is in different commission category, get the commission level
                $this->STRecurringCommission[$params['tier']] = $rs->fields['st'.$params['tier'].'recurringcommission'];
            }
        }
        else
        {
            // get commission from default commission category
            $sql = 'select * from wd_pa_campaigncategories '.
                   'where deleted=0 and campaignid='._q($this->CampaignID).
                   '  and name='._q(UNASSIGNED_USERS);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
            {
                $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Can not get basic category for campaign with ID:".$this->CampaignID, __FILE__, __LINE__);
                return false;
            }

            $this->STRecurringCommission[$params['tier']] = $rs->fields['st'.$params['tier'].'recurringcommission'];
        }
    }
    
    //--------------------------------------------------------------------------
    
    function getClickId()
    {
        if ($_REQUEST['fscc'] != '')
            return preg_replace('/[\"\']/', '', $_REQUEST['fscc']);
            
        if ($_COOKIE[CLICK_COOKIE_NAME] != '')
            return preg_replace('/[\"\']/', '', $_COOKIE[CLICK_COOKIE_NAME]);
            
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function getClickExtraData($clickId)
    {
        $blTransaction = QUnit_Global::newObj('Affiliate_Merchants_Bl_Transactions');
        $trans = $blTransaction->getTransactionInfo($clickId, array("AccountID" => 'default1'));
        return $trans;
    }
    
    //--------------------------------------------------------------------------
    
    function setExtraData($Data1, $Data2, $Data3)
    {
        $this->extraData1 = $Data1;
        $this->extraData2 = $Data2;
        $this->extraData3 = $Data3;
       
        if ($Data1 != '' && $Data2 != '' && $Data3 != '')  return;
        if (($clickId = $this->getClickId()) == false)     return;
        if (($extraData = $this->getClickExtraData($clickId)) == false) return;
        
        if ($this->extraData1 == '') $this->extraData1 = $extraData['data1'];
        if ($this->extraData2 == '') $this->extraData2 = $extraData['data2'];
        if ($this->extraData3 == '') $this->extraData3 = $extraData['data3'];
    }

    //--------------------------------------------------------------------------
    
    function deleteCookies() {
        //setcookie(COOKIE_NAME, NULL, mktime() - 3600, "/");
    }
}
?>
