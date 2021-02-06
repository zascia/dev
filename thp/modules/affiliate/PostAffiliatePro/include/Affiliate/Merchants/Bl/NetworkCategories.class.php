<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Messager');

class Affiliate_Merchants_Bl_NetworkCategories
{
    function getCampaignCategories2Simple($params)
    {
        if($params['CampaignID'] == '') return false;
    
        $sql = 'select c.catid, c.name from wd_pa_campcat2 cc2, wd_g_categories c '.
               'where cc2.campaignid='._q($params['CampaignID']).
               '  and cc2.catid=c.catid'.
               '  and deleted='._q('0').
               ' order by c.name';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
        
        $cc2data = array();
        
        while(!$rs->EOF)
        {
            $cc2data[$params['CampaignID']][] = $rs->fields['catid'];
        
            $rs->MoveNext();
        }

        return $cc2data;
    }
    
    //--------------------------------------------------------------------------
    
    function saveCategories($categories)
    {
        if($categories['cid'] == '') return false;
    
        $sql = 'delete from wd_pa_campcat2 where campaignid='._q($categories['cid']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }

        if(is_array($categories['network_categories']) && count($categories['network_categories']) > 0)
        {
            foreach($categories['network_categories'] as $catid)
            {
                $campcat2id = QCore_Sql_DBUnit::createUniqueID('wd_pa_campcat2', 'campcat2id');
                $sql = 'insert into wd_pa_campcat2 (campcat2id, campaignid, catid, rstatus) values '.
                       '('._q($campcat2id).','._q($categories['cid']).
                       ','._q($catid).','._q(AFFSTATUS_APPROVED).')';
                $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                if(!$rs) {
                  QUnit_Messager::setErrorMessage(L_G_DBERROR);
                  return false;
                }
            }
        }
        
        return true;
    }
}
?>
