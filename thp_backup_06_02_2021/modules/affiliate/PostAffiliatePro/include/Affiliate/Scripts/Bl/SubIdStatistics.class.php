<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
// 20041116 - IPI - Postgres added
//============================================================================

class Affiliate_Scripts_Bl_SubIdStatistics
{

    function Affiliate_Scripts_Bl_SubIdStatistics() {
    }

    //--------------------------------------------------------------------------

    function getStats($conditions, $AccountID = '')
    {
        $CampaignID = $conditions['CampaignID'];
        $UserID = $conditions['UserID'];
        $page = $conditions['page'];
        $rowsPerPage = $conditions['rowsPerPage'];
        $d1 = $conditions['day1'];
        $m1 = $conditions['month1'];
        $y1 = $conditions['year1'];
        $d2 = $conditions['day2'];
        $m2 = $conditions['month2'];
        $y2 = $conditions['year2'];
        $data1 = $conditions['data1'];
        $data2 = $conditions['data2'];
        $data3 = $conditions['data3'];

        $UserData = array();
        $UserData['transactions'] = array();

        $sql = "select a.userid, t.data1, t.data2, t.data3 ";
        $sqlCount = "select count(*) as count ";
        
        // condition
        if($CampaignID != '' && $CampaignID != '_') // filter by campaign
        {        
            $from =       "from wd_pa_transactions t, wd_pa_campaigncategories cc, wd_g_users a ";
            $where = " where t.campcategoryid=cc.campcategoryid".
                     "   and t.affiliateid=a.userid and a.deleted=0".
                     "   and a.rstatus=".AFFSTATUS_APPROVED;
            if($AccountID != '') $where .= "   and a.accountid="._q($AccountID);
        }
        else
        {
            $from = "from wd_pa_transactions t, wd_g_users a ";
            $where = " where t.affiliateid=a.userid and a.deleted=0".
                     "   and a.rstatus=".AFFSTATUS_APPROVED;
            if($AccountID != '') $where .= "   and a.accountid="._q($AccountID);
        }

                 
        $where2 = '';
        if($d1 != '' && $m1 != '' && $y1 != '') //filter by date
        {
            $where2 .= " and (".sqlToDays('t.dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
                      " and (".sqlToDays('t.dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
        }
                
        if($CampaignID != '' && $CampaignID != '_') // filter by campaign
        {
            $where2 .= " and cc.campaignid="._q($CampaignID);
        }
        
        if($UserID != '' && $UserID != '_')
        {
            $where2 .= " and a.userid="._q($UserID);
        }
                        
        if($data1 != '') {
            $where2 .= " and t.data1 like '%".$data1."%'";
        }
        if($data2 != '') {
            $where2 .= " and t.data2 like '%".$data2."%'";
        }
        if($data3 != '') {
            $where2 .= " and t.data3 like '%".$data3."%'";
        }
                
        $orderby .= " order by t.data1, t.data2, t.data3";
        $groupby = " group by t.data1, t.data2, t.data3";
        
        if($page !== '' && $rowsPerPage !== '')
        {
            //------------------------------------------------
            // get total number of records
            $rs = QCore_Sql_DBUnit::execute($sqlCount.$from.$where.$where2.$groupby, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }
            
            if(!is_numeric($rowsPerPage) || $rowsPerPage <= 0)
                $rowsPerPage = 1000;
                
            //init paging
            $allcount = $rs->fields['count'];
            $_REQUEST['allcount'] = $allcount;
            
            if($allcount<$page*$rowsPerPage)
                $page = 0;          
            
            $_REQUEST['list_pages'] = (int) ceil($allcount/$rowsPerPage);
            $_REQUEST['list_page'] = $page;
    
            if($page == 0)
                $limitOffset = 0;
            else
                $limitOffset = ($page)*$rowsPerPage;
        }
        
        if($page !== '' && $rowsPerPage !== '') // paging
        {
            $rs = QCore_Sql_DBUnit::selectLimit($sql.$from.$where.$where2.$groupby.$orderby, $limitOffset, $rowsPerPage, __FILE__, __LINE__);
        }
        else // no paging
        {
            $rs = QCore_Sql_DBUnit::execute($sql.$from.$where.$where2.$groupby.$orderby, __FILE__, __LINE__);
        }

        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        while(!$rs->EOF)
        {
            $commission = $rs->fields['commission'];
            
            $temp = array();
            $temp['userid'] = $rs->fields['userid'];
            $temp['data1'] = $rs->fields['data1'];
            $temp['data2'] = $rs->fields['data2'];
            $temp['data3'] = $rs->fields['data3'];
            $temp['clicks'] = $this->getSummary(1, $rs->fields['data1'], $rs->fields['data2'],$rs->fields['data3'], $from, $where.$where2);
            $temp['sales'] = $this->getSummary(4, $rs->fields['data1'], $rs->fields['data2'],$rs->fields['data3'], $from, $where.$where2);
            $temp['leads'] = $this->getSummary(2, $rs->fields['data1'], $rs->fields['data2'],$rs->fields['data3'], $from, $where.$where2);
            if($temp['clicks'] != 0) {
                $temp['leadsclicks'] = $temp['leads']/$temp['clicks'];
                $temp['salesclicks'] = $temp['sales']/$temp['clicks'];
            } else {
                $temp['leadsclicks'] = 0;
                $temp['salesclicks'] = 0;            
            }
            //$temp['impressions'] = $this->getImpressionsSummary($rs->fields['data1'], $rs->fields['data2'],$rs->fields['data3'], $conditions, $AccountID);            
            
            $data[] = $temp;
            
            $rs->MoveNext();
        }
        
        return $data;
    }
    
    //--------------------------------------------------------------------------

    function getSummary($transtype, $data1, $data2, $data3, $from, $where) {
        $sql = "select count(*) as count ".$from.$where.
                " and t.transtype = ".$transtype.
                " and t.data1 = "._q($data1).
                " and t.data2 = "._q($data2).
                " and t.data3 = "._q($data3);
        //$sql .= " group by t.data1, t.data2, t.data3";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        return $rs->fields('count');        
    }

    //--------------------------------------------------------------------------

    function getImpressionsSummary($data1, $data2, $data3, $conditions, $accountId = '') {
        $sql = "select count(*) as count ";
        if($conditions['CampaignID'] != '' && $conditions['CampaignID'] != '_') // filter by campaign
        {        
            $sql  .=       "from wd_pa_impressions t, wd_pa_campaigncategories cc, wd_g_users a ";
            $sql .= " where t.campcategoryid=cc.campcategoryid".
                     "   and t.affiliateid=a.userid and a.deleted=0".
                     "   and a.rstatus=".AFFSTATUS_APPROVED.
                   " and cc.campaignid="._q($conditions['CampaignID']);
            if($accountId != '') $where .= "   and a.accountid="._q($accountId);
        }
        else
        {
            $sql .= "from wd_pa_impressions t, wd_g_users a ";
            $sql .= " where t.affiliateid=a.userid and a.deleted=0".
                     "   and a.rstatus=".AFFSTATUS_APPROVED;
            if($accountId != '') $where .= "   and a.accountid="._q($accountId);
        }
                
        if($conditions['UserID'] != '' && $conditions['UserID'] != '_')
        {
            $sql .= " and a.userid="._q($conditions['UserID']);
        }
        
        if($conditions['day1'] != '' && $conditions['month1'] != '' 
            && $conditions['year1'] != '') //filter by date
        {
            $sql .= " and (".sqlToDays('t.dateimpression')." >= ".sqlToDays($conditions['year1']."-".$conditions['month1']."-".$conditions['day1']).")".
                      " and (".sqlToDays('t.dateimpression')." <= ".sqlToDays($conditions['year2']."-".$conditions['month2']."-".$conditions['day2']).")";
        }        
                                       
        $sql .= " and t.data1 = "._q($data1).
                " and t.data2 = "._q($data2).
                " and t.data3 = "._q($data3);
        echo $sql;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        return $rs->fields('count');        
    }
}
?>
