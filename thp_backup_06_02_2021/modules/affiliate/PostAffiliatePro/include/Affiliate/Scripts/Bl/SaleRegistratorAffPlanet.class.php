<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleRegistrator');

class Affiliate_Scripts_Bl_SaleRegistratorAffPlanet extends Affiliate_Scripts_Bl_SaleRegistrator
{
    
    //--------------------------------------------------------------------------
    /** decodes data from cookie or other source, 
    * finds user id and campaign id 
    */
    function decodeData($value, $userID = '')
    {
        $data = false;

        $sql = "select affiliateid from wd_pa_transactions".
               " where transtype="._q(TRANSTYPE_LEAD).
               " and transkind="._q(TRANSKIND_NORMAL).
               " and data1="._q($value).
               " order by dateinserted desc";
               
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs || $rs->EOF) {
            $this->registratorLog(WLOG_DEBUG, "Sale/Lead registration: Can not find affiliate for account ".$value, __FILE__, __LINE__);
            return false;
        }
        
        $data = $this->getUsersCampaign($rs->fields['affiliateid']);
        $this->trackingMethod = SALE_TRACKING_REFERRED;

        if(!$data) return false;
        if(isset($data[2])) $this->extraData1 = $data[2];
        if(isset($data[3])) $this->extraData2 = $data[3];
        if(isset($data[4])) $this->extraData3 = $data[4];

        return $this->initData($data[0], $data[1]);
    }
    
}
?>
