<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Messager');


class Affiliate_Merchants_Bl_Campaign
{
    var $blSettings;

    function Affiliate_Merchants_Bl_Campaign() {
        $this->blSettings =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Settings');
    }
    
    //--------------------------------------------------------------------------

    function load($params)
    {
        $sql = 'select * from wd_pa_campaigns '.
               'where deleted=0 and campaignid='._q($params['campaignid']).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID());
              
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }

        if($rs->EOF)
            return array();
            
        return $rs->fields;
    }

    //--------------------------------------------------------------------------

    function updateSettings($params)
    {
        $setting_params = array('cookielifetime' => $params['cookielifetime'],
                                'clickapproval' => $params['clickapproval'],
                                'saleapproval' => $params['saleapproval'],
                                'affapproval' => $params['affapproval']
                               );

        if($params['status'] != '')
            $setting_params = array_merge($setting_params, array('status' => $params['status']));

        if($params['signup_bonus'] != '')
            $setting_params = array_merge($setting_params, array('signup_bonus' => $params['signup_bonus']));

        $this->blSettings->updateCampaignInfo($params['cid'], $setting_params);

        return true;
    }

    //--------------------------------------------------------------------------

    function updateCampaign($params)
    {
        $sql = 'update wd_pa_campaigns '.
               'set campaignid=campaignid';

        if(isset($params['cname'])) {               
            $sql .= ', name='._q($params['cname']);
        }
        if(isset($params['shortdescription'])) {               
            $sql .= ', shortdescription='._q($params['shortdescription']);
        }
        if($GLOBALS['Auth']->getSetting('Aff_forcecommfromproductid') == 'yes' && isset($params['products'])) {               
            $sql .= ', products='._q($params['products']);
        }
        
        $sql .='   ,commtype='._q($params['commtype']).
               '   ,description='._q($params['description']);
        $sql .= ' where campaignid='._q($params['campaignid']).
               '   and accountid='._q($GLOBALS['Auth']->getAccountID());

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if(isset($params['banner_url'])) { 
            $setting_params = array('banner_url' => $params['banner_url']);

            $this->blSettings->updateCampaignInfo($params['campaignid'], $setting_params);
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function insert($params)
    {
        $sql = 'insert into wd_pa_campaigns(campaignid, accountid, name';
        if($GLOBALS['Auth']->getSetting('Aff_forcecommfromproductid') == 'yes')
            $sql.=',products';
        $sql.= ' ,dateinserted, commtype, description, shortdescription) values'.
               '('._q($params['campaignid']).','._q($GLOBALS['Auth']->getAccountID()).
               ','._q($params['cname']);
        if($GLOBALS['Auth']->getSetting('Aff_forcecommfromproductid') == 'yes')
            $sql.=','._q($params['products']);
        $sql.=','.sqlNow().','._q($params['commtype']).','._q($params['description']).
              ','._q($params['shortdescription']).')';

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }    

        $setting_params = array('cookielifetime' => $params['cookielifetime'],
                                'clickapproval' => $params['clickapproval'],
                                'saleapproval' => $params['saleapproval'],
                                'affapproval' => $params['affapproval'],
                                'status' => $params['status'],
                                'signup_bonus' => $params['signup_bonus'],
                                'banner_url' => $params['banner_url']
                               );

        $this->blSettings->updateCampaignInfo($params['campaignid'], $setting_params);

        // add commission to first unassigned category
        $sql = 'insert into wd_pa_campaigncategories(campcategoryid, campaignid, name)'.
               'values('._q($params['affcategoryid']).','._q($params['campaignid']).
               ','._q(UNASSIGNED_USERS).')';

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$ret)
        {
            $sql = 'delete from wd_pa_campaigns '.
                   'where campaignid='._q($params['campaignid']).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            $this->blSettings->deleteCampaignInfo($params['campaignid']);

            QUnit_Messager::setErrorMessage(L_G_DBERROR);

            return false;
        }

        return true;            
    }

    //--------------------------------------------------------------------------

    function delete($params)
    {
        $settings = QCore_Settings::_getSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountId());
	    $defaultCampaign = $settings['Aff_default_campaign'];
	    
        if ($defaultCampaign == $params['campaignid']) {
            QUnit_Messager::setErrorMessage(L_G_DEFAULTCAMPAIGNCANNOTBEDELETED);
            return false;
        }
	    
        $sql = 'update wd_pa_campaigns set deleted=1 '.
               'where campaignid='._q($params['campaignid']).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $ret = $this->blSettings->deleteCampaignInfo($params['campaignid']);

        return $ret;
    }
    
    //--------------------------------------------------------------------------
    
    function getMerchantCampaignUsers($params)
    {
        if($params['AccountID'] == '') return false;
        
        $sql = 'select distinct ac.affiliateid from wd_pa_affiliatescampaigns ac, wd_pa_campaigns c '.
               'where ac.campaignid=c.campaignid'.
               '  and c.accountid='._q($params['AccountID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $users = array();
        
        while(!$rs->EOF)
        {
        	$users[] = $rs->fields['affiliateid'];
            
            $rs->MoveNext();
        }

        return $users;
    }
    
    //--------------------------------------------------------------------------
    
    function getCampaignSettings($params) {
    	if($params['AccountID'] == '') return false;
    	if($params['CampaignID'] == '') return false;
    	
        $sql = 'select code, value from wd_g_settings '.
               'where rtype='._q(SETTINGTYPE_AFF_CAMP).
               '  and id1='._q($params['CampaignID']).
               '  and accountid='._q($params['AccountID']);
                      
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $campsettings = array();
        
        while(!$rs->EOF)
        {
        	$campsettings[$rs->fields['code']] = $rs->fields['value'];
            $rs->MoveNext();
        }

        return $campsettings;
    }
    
    //--------------------------------------------------------------------------
    
    function getFirstCampaignID() {
        $sql = 'select campaignid from wd_pa_campaigns '.
               'where accountid='._q($GLOBALS['Auth']->getAccountID()).
               ' order by campaignid';

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF) {
            return false;
        }
        return $rs->fields['campaignid'];
    }
    
    //--------------------------------------------------------------------------

    function getBannersCount($params)
    {
        if($params['CampaignID'] == '') return false;
        
        $sql = 'select count(*) as countbanners from wd_pa_banners where deleted=0 and campaignid='._q($params['CampaignID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF) return 0;

        return $rs->fields['countbanners'];
    }
    
	//--------------------------------------------------------------------------

    function getDefaultCampaignCategoryId($campaignId)
    {
        if($campaignId == '') return false;
        
        $sql = "select campcategoryid from wd_pa_campaigncategories ".
               " where deleted=0".
               "   and campaignid="._q($campaignId).
               "   and name='L_G_UNASSIGNED_USERS'";
               

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF) return false;

        return $rs->fields['campcategoryid'];
    }
    
	//--------------------------------------------------------------------------

    function checkCampaignCategoryExists($campaignId, $campCategoryId)
    {
        if($campaignId == '') return false;
        
        $sql = "select campcategoryid from wd_pa_campaigncategories ".
               " where deleted=0".
               "   and campaignid="._q($campaignId).
               "   and campcategoryid="._q($campCategoryId);
               
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF) return false;

        return true;
    }
    
    
}
?>
