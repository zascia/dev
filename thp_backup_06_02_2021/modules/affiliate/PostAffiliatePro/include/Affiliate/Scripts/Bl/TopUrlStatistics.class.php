<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
// 20041116 - IPI - Postgres added
//============================================================================

class Affiliate_Scripts_Bl_TopUrlStatistics
{

    function getTopUrlStats($conditions)
    {
        $AffiliateID = $conditions['AffiliateID'];
        $TransactionType = $conditions['TransactionType'];
        $page = $conditions['page'];
        $rowsPerPage = $conditions['rowsPerPage'];
        $d1 = $conditions['day1'];
        $m1 = $conditions['month1'];
        $y1 = $conditions['year1'];
        $d2 = $conditions['day2'];
        $m2 = $conditions['month2'];
        $y2 = $conditions['year2'];

        $UserData = array();

        $sql = "SELECT refererurl, COUNT(*) as count FROM wd_pa_transactions WHERE ";
        $sqlCount = "SELECT COUNT(DISTINCT refererurl) AS count FROM wd_pa_transactions WHERE ";
        $sqlEnd = " GROUP BY refererurl ORDER BY count DESC";

        $where = "(accountid = "._q($GLOBALS['Auth']->getAccountID()).") and ";
        if($d1 != '' && $m1 != '' && $y1 != '') //filter by date
        {
            $where .= "(".sqlToDays('dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
                      " and (".sqlToDays('dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
        }

        if($AffiliateID != '' && $AffiliateID != '_') //filter by AffiliateID
        {
            $where .= " and affiliateid="._q($AffiliateID);
        }

        if(is_array($TransactionType))
        {
            if(count($TransactionType) > 0)
            {
                $where .= " and transtype in (".implode(',', $TransactionType).")";
            } else {
                $where .= " and transtype is NULL";
            }
        }
        else
        {
            if($TransactionType != '' && $TransactionType != '_') {
                $where .= " and transtype="._q($TransactionType);
            }
        }

        QCore_Sql_DBUnit::execute("UPDATE wd_pa_transactions SET refererurl = '' WHERE refererurl is NULL", __FILE__, __LINE__);

        if($page !== '' && $rowsPerPage !== '')
        {
            //------------------------------------------------
            // get total number of records

            $rs = QCore_Sql_DBUnit::execute($sqlCount.$where, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }

            if(!is_numeric($rowsPerPage) || $rowsPerPage <= 0)
                $rowsPerPage = 20;

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
            $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$sqlEnd, $limitOffset, $rowsPerPage, __FILE__, __LINE__);
        }
        else // no paging
        {
            $rs = QCore_Sql_DBUnit::execute($sql.$where.$sqlEnd, __FILE__, __LINE__);
        }

        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        while(!$rs->EOF)
        {
            $temp = array();
            $temp['refererurl'] = $rs->fields['refererurl'];
            $temp['count'] = $rs->fields['count'];

            $UserData[] = $temp;

            $rs->MoveNext();
        }
        
        return $UserData;
    }

}
?>
