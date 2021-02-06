<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
// 20041116 - IPI - Postgres added
//============================================================================

class Affiliate_Scripts_Bl_RotatorStatistics
{
    
    function getStats($conditions, $data) {
        $data = $this->getImpressionStats($conditions, $data);
        $data = $this->getTransactionStats($conditions, $data);
        return $data;
    }
        
    function initData() {
        return array('clicks' => 0, 'all_imps_count' => 0, 'unique_imps_count' => 0);
    }
        
    function getImpressionStats($conditions, $data) {
        if(($BannerID = $conditions['BannerID']) == '') {
            return false;
        }
        $d1 = $conditions['day1'];
        $m1 = $conditions['month1'];
        $y1 = $conditions['year1'];
        $d2 = $conditions['day2'];
        $m2 = $conditions['month2'];
        $y2 = $conditions['year2'];

        $sql = "select rotatorid, bannerid, sum(all_imps_count) as all_imps_count, sum(unique_imps_count) as unique_imps_count".
               " from wd_pa_impressions where ";
        $sqlEnd = " group by bannerid, rotatorid order by rotatorid asc";

        $where = "(accountid = "._q($GLOBALS['Auth']->getAccountID()).") and ";
        if($d1 != '' && $m1 != '' && $y1 != '') //filter by date
        {
            $where .= "(".sqlToDays('dateimpression')." >= ".sqlToDays("$y1-$m1-$d1").")".
                      " and (".sqlToDays('dateimpression')." <= ".sqlToDays("$y2-$m2-$d2").")";
        }
        $where .= " and rotatorid in ('".implode("','", $BannerID)."')";
        
        $rs = QCore_Sql_DBUnit::execute($sql.$where.$sqlEnd, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        while(!$rs->EOF)
        {
            if ($data[$rs->fields['rotatorid']][$rs->fields['bannerid']] == '') {
                $rs->MoveNext();
                continue;
            }
            $data[$rs->fields['rotatorid']][$rs->fields['bannerid']]['all_imps_count'] = $rs->fields['all_imps_count'];
            $data[$rs->fields['rotatorid']][$rs->fields['bannerid']]['unique_imps_count'] = $rs->fields['unique_imps_count'];
            
            $rs->MoveNext();
        }
        
        return $data;
    }

    function getTransactionStats($conditions, $data) {
        if(($BannerID = $conditions['BannerID']) == '') {
            return false;
        }
        $d1 = $conditions['day1'];
        $m1 = $conditions['month1'];
        $y1 = $conditions['year1'];
        $d2 = $conditions['day2'];
        $m2 = $conditions['month2'];
        $y2 = $conditions['year2'];

        $sql = "select rotatorid, bannerid, count(*) as clicks".
               " from wd_pa_transactions where ";
        $sqlEnd = " group by bannerid, rotatorid order by rotatorid asc";

        $where = "(accountid = "._q($GLOBALS['Auth']->getAccountID()).") and ".
                 "(transtype = "._q(TRANSTYPE_CLICK).") and (transkind = "._q(TRANSKIND_NORMAL).") and ";
        if($d1 != '' && $m1 != '' && $y1 != '') //filter by date
        {
            $where .= "(".sqlToDays('dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
                      " and (".sqlToDays('dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
        }
        $where .= " and rotatorid in ('".implode("','", $BannerID)."')";
        $rs = QCore_Sql_DBUnit::execute($sql.$where.$sqlEnd, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        while(!$rs->EOF)
        {
            if ($data[$rs->fields['rotatorid']][$rs->fields['bannerid']] == '') {
                $rs->MoveNext();
                continue;
            }
            $data[$rs->fields['rotatorid']][$rs->fields['bannerid']]['clicks'] = $rs->fields['clicks'];
            
            $rs->MoveNext();
        }
        
        return $data;
    }

}
?>
