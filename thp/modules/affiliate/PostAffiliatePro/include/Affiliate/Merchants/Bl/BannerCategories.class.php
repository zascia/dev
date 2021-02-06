<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Messager');

class Affiliate_Merchants_Bl_BannerCategories
{
    var $allowedCampaigns;
    
    function Affiliate_Merchants_Bl_BannerCategories()
    {
        $this->allowedCampaigns = '_';
    }

    //--------------------------------------------------------------------------

    function getRows() {
        $sql = 'select * '.
               'from wd_pa_bannercategories ';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        return $rs;
    }

    //--------------------------------------------------------------------------

    function getCategories($showHidden = true)
    {
        $rs = $this->getRows();
        $categories = array();
        while($row = $rs->FetchRow()) {
            $num = $this->getCategoryCount($row['bannercategoryid'], $showHidden);
            $categories[$row['bannercategoryid']]['name'] = $row['name'];
            $categories[$row['bannercategoryid']]['num'] = $num;
        }

        return $categories;
    }

    //--------------------------------------------------------------------------

    function getCategoryCount($catId, $showHidden = true) {
        $sql = "select count(*) as num from wd_pa_banners b, wd_pa_campaigns c ".
            "where b.bannercategory = '".$catId."' and b.deleted = 0". 
            "  and b.campaignid=c.campaignid and c.deleted=0".
            "  and b.bannertype in (".implode(',', array(BANNERTYPE_TEXT, BANNERTYPE_HTML, BANNERTYPE_IMAGE, BANNERTYPE_POPUNDER, BANNERTYPE_POPUP, BANNERTYPE_ROTATOR)).")".
            $this->getAllowedCampaignsCondition();
        if(!$showHidden) {
            $sql .= " and hidden = 0";
        }        
        $rs =& QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        return $rs->fields['num'];
    }

    //--------------------------------------------------------------------------

    function getAllCategoryCount($showHidden = true) {
        $sql = "select count(*) as num from wd_pa_banners b, wd_pa_campaigns c ".
            "where b.deleted = 0 and b.campaignid=c.campaignid and c.deleted=0".
            "  and b.bannertype in (".implode(',', array(BANNERTYPE_TEXT, BANNERTYPE_HTML, BANNERTYPE_IMAGE, BANNERTYPE_POPUNDER, BANNERTYPE_POPUP, BANNERTYPE_ROTATOR)).")".
            $this->getAllowedCampaignsCondition();
        if(!$showHidden) {
            $sql .= " and hidden = 0";
        }
        $rs =& QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        return $rs->fields['num'];
    }

    //--------------------------------------------------------------------------

    function insert($pvars)
    {
        $id = QCore_Sql_DBUnit::createUniqueID('wd_pa_bannercategories', 'bannercategoryid');
        $sql = 'insert into wd_pa_bannercategories '.
               '(bannercategoryid, name) '.
               'values('._q($id).','._q($pvars['pname']).')';
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        QUnit_Messager::setOkMessage(L_G_BANNERADDED);

        return $id;
    }

    //--------------------------------------------------------------------------

    function update($pvars)
    {
        $sql = 'update wd_pa_bannercategories '.
               'set name='._q($pvars['pname']).
               ' where bannercategoryid='._q($pvars['pid']);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        QUnit_Messager::setOkMessage(L_G_BANNEREDITED);

        return true;
    }
    
    //--------------------------------------------------------------------------

    function setAllowedCampaigns($campaigns) {
        $this->allowedCampaigns = $campaigns;
    }
    
    //--------------------------------------------------------------------------

    function getAllowedCampaignsCondition() {
        if ($this->allowedCampaigns == '' || $this->allowedCampaigns == '_') return '';
        
        if ($this->allowedCampaigns == false) return ' and 1=0 ';
        
        if (!is_array($this->allowedCampaigns) || count($this->allowedCampaigns) < 1) return ' and 1=0 ';
        
        $campaignIDs = '';
        foreach($this->allowedCampaigns as $key => $value)
            $campaignIDs .= '\''.$key.'\',';
        $campaignIDs = substr($campaignIDs, 0, -1);
        if($campaignIDs != '')
            return '   and b.campaignid in ('.$campaignIDs.')';
        
        return '';
    }

}
?>
