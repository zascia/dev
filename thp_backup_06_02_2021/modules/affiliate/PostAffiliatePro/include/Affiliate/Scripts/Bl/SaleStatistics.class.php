<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
// 20041116 - IPI - Postgres added
//============================================================================

class Affiliate_Scripts_Bl_SaleStatistics
{
    function Affiliate_Scripts_Bl_SaleStatistics() {
        $this->blPayoutOptions =& QUnit_Global::newObj('Affiliate_Merchants_Bl_PayoutOptions');
    }

    function getTransactionsSummaries($conditions)
    {
        $CampaignID = $conditions['CampaignID'];
        $UserID = $conditions['UserID'];
        $TransactionType = $conditions['TransactionType'];
        $Status = $conditions['Status'];
        $denyStatus = $conditions['denyStatus'];
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
        $extrafilter = $conditions['extrafilter'];
        $virtual_affiliates = $conditions['virtual_affiliates'];
    //-----------------------------------------------------
    //added by AdAstra 
	$dateSelectMode = $conditions['dateSelectMode'];
    //-----------------------------------------------------
	
        $UserData = array();
        // initialize array
        $sql = "select * from wd_g_users where accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and rtype="._q(USERTYPE_USER);
        if($UserID != '' && $UserID != '_') {
            if(!is_array($UserID)) {
                $sql .= " and userid="._q($UserID);
            }
            else if(is_array($UserID) && count($UserID)>0) {
                $sql .= " and userid in ('".implode("','", $UserID)."')";
            }
        }
        
        if (!$virtual_affiliates) {
            $sql .= " and (flags!="._q(VIRTUAL_AFFILIATE)." or flags is null)";
        }

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $uSets = QCore_Settings::getAccountUsersSettings($GLOBALS['Auth']->getAccountID());
        $payout_methods = $this->blPayoutOptions->getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(),STATUS_ENABLED);
        $payout_fields = $this->blPayoutOptions->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(),STATUS_ENABLED);

        while(!$rs->EOF)
        {
            $UserData[$rs->fields['userid']]['minpayout'] = $uSets[$rs->fields['userid']]['Aff_min_payout'];
            $UserData[$rs->fields['userid']]['paid'] = 0;
            $UserData[$rs->fields['userid']]['pending'] = 0;
            $UserData[$rs->fields['userid']]['approved'] = 0;
            $UserData[$rs->fields['userid']]['reversed'] = 0;
            
            $UserData[$rs->fields['userid']]['userid'] = $rs->fields['userid'];
            $UserData[$rs->fields['userid']]['username'] = $rs->fields['username'];
            $UserData[$rs->fields['userid']]['name'] = $rs->fields['name'];
            $UserData[$rs->fields['userid']]['surname'] = $rs->fields['surname'];

            $UserData[$rs->fields['userid']]['address'] = $rs->fields['street'].' '.
                                                          $rs->fields['city'].' '.
                                                          $rs->fields['zipcode'].' '.
                                                          $rs->fields['country'].' '.
                                                          $rs->fields['state'];
            $UserData[$rs->fields['userid']]['tax_ssn'] = $rs->fields['tax_ssn'];
            $UserData[$rs->fields['userid']]['payout_type'] = $rs->fields['payoptid'];

            $UserData[$rs->fields['userid']]['payout_method_name'] = (defined($payout_methods[$rs->fields['payoptid']]['langid']) ? constant($payout_methods[$rs->fields['payoptid']]['langid']) : $payout_methods[$rs->fields['payoptid']]['name']) ;

            if(is_array($payout_fields[$rs->fields['payoptid']])) 
            {
                foreach($payout_fields[$rs->fields['payoptid']] as $field) 
                {
                    $UserData[$rs->fields['userid']]['payout_fields'][] =
                             array('name' => $field['name'],
                                   'value' => $uSets[$rs->fields['userid']]['Aff_payoptionfield_'.$field['payfieldid']],
                                   'payfieldid' => $field['payfieldid']);
                }
            }

            $rs->MoveNext(); 
        }

        if($CampaignID != '' && $CampaignID != '_') {
            $sql = "select a.userid, t.rstatus, t.payoutstatus, sum(t.commission) as commission, sum(t.totalcost) as totalcost ".
                   "from wd_pa_transactions t, wd_pa_campaigncategories cc, wd_g_users a";
               
            $where = " where t.campcategoryid=cc.campcategoryid and t.affiliateid=a.userid ".
                     "   and a.deleted=0 and a.rstatus=".AFFSTATUS_APPROVED.
                     "   and a.accountid="._q($GLOBALS['Auth']->getAccountID());
        }
        else {
            $sql = "select a.userid, t.rstatus, t.payoutstatus, sum(t.commission) as commission, sum(t.totalcost) as totalcost ".
                   "from wd_pa_transactions t, wd_g_users a";
               
            $where = " where t.affiliateid=a.userid ".
                     "   and a.deleted=0 and a.rstatus=".AFFSTATUS_APPROVED.
                     "   and a.accountid="._q($GLOBALS['Auth']->getAccountID());
        }
	
	//------------------------------------------------
	// added switch between date inserted and date approved, date inserted beeing default
	// order by statement also moved here..
	switch( $dateSelectMode ){
    	    case '2':
		if($d1 != '' && $m1 != '' && $y1 != '') {
	    	    $where .= " and (".sqlToDays('t.dateapproved')." >= ".sqlToDays("$y1-$m1-$d1").")".
    			      " and (".sqlToDays('t.dateapproved')." <= ".sqlToDays("$y2-$m2-$d2").")";
		}
		break;
	    default:
		if( $d1 != '' && $m1 != '' && $y1 != '' ){
		    $where .= " and (".sqlToDays('t.dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
			      " and (".sqlToDays('t.dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
		}
		break;
        }
	//-- end added 
	
        if($CampaignID != '' && $CampaignID != '_') {
            $where .= " and cc.campaignid="._q($CampaignID);
        }
        
        if($UserID != '' && $UserID != '_') {
            if(!is_array($UserID)) {
                $where .= " and a.userid="._q($UserID);
            }
            else if(is_array($UserID) && count($UserID)>0) {
                $where .= " and a.userid in ('".implode("','", $UserID)."')";
            }
        }
        
        if(is_array($TransactionType))
        {
            if(count($TransactionType) > 0)
            {
                $where .= " and t.transtype in (".implode(',', $TransactionType).")";
            } else {
                $where .= " and t.transtype is NULL";
            }
        }
        else
        {
            if($TransactionType != '' && $TransactionType != '_') {
                $where .= " and t.transtype="._q($TransactionType);
            }
        }
	
        if (is_array($denyStatus)) {
            $Status = $this->notDeniedStatus($Status, $denyStatus);
        }

        if(is_array($Status))
        {
            if(count($Status) > 0)
            {
                $where .= " and t.rstatus in (".implode(',', $Status).")";
            } else {
                $where .= " and t.rstatus is NULL";
            }
        }
        else
        {
            if($Status != '' && $Status != '_'){
                $where .= " and t.rstatus="._q($Status);;
            }
        }

        if (is_array($denyStatus) && count($denyStatus) > 0) {
            $where .= " and t.rstatus not in (".implode(',', $denyStatus).")";
        }
        
        if(count($extrafilter) > 0) {
            foreach ($extrafilter as $column => $value) {
                if (($value != '') && ($column != '')) {
            	   $where .= " and ".$column." like '%"._q_noendtags($value)."%'";
                }
            }
        }
        
        if($data1 != '') {
            $where .= " and t.data1 like '%".$data1."%'";
        }
        if($data2 != '') {
            $where .= " and t.data2 like '%".$data2."%'";
        }
        if($data3 != '') {
            $where .= " and t.data3 like '%".$data3."%'";
        }
        
        if (!$virtual_affiliates) {
            $where .= " and (a.flags!="._q(VIRTUAL_AFFILIATE)." or a.flags is null)";
        }
                
        $groupby .= " group by a.userid, t.rstatus, t.payoutstatus";

        if( $dateSelectMode == '2' ){
	    $orderby .= " order by t.dateapproved";
	}
	else{
	    $orderby .= " order by t.dateinserted";
	}
	    
        $rs = QCore_Sql_DBUnit::execute($sql.$where.$groupby.$orderby, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
	
        while(!$rs->EOF)
        {
            $commission = $rs->fields['commission'];

            $UserData[$rs->fields['userid']]['totalcost'] += $rs->fields['totalcost'];

            if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED)
            {
                if($rs->fields['payoutstatus'] == AFFSTATUS_SUPPRESSED || $rs->fields['payoutstatus'] == AFFSTATUS_NOTAPPROVED)
                    $UserData[$rs->fields['userid']]['reversed'] += $commission;
                else if($rs->fields['payoutstatus'] == AFFSTATUS_APPROVED)
                    $UserData[$rs->fields['userid']]['paid'] += $commission;        
            }
            else if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED)
            {
                $UserData[$rs->fields['userid']]['pending'] += $commission;
            }
            else if($rs->fields['rstatus'] == AFFSTATUS_APPROVED)
            {
                if($rs->fields['payoutstatus'] == AFFSTATUS_SUPPRESSED)
                    $UserData[$rs->fields['userid']]['reversed'] += $commission;
                else if($rs->fields['payoutstatus'] == AFFSTATUS_NOTAPPROVED)
                    $UserData[$rs->fields['userid']]['approved'] += $commission;
                else if($rs->fields['payoutstatus'] == AFFSTATUS_APPROVED)
                    $UserData[$rs->fields['userid']]['paid'] += $commission; 
            }
            
            $rs->MoveNext();
        }
        
        foreach($UserData as $userid => $userinfo)
        {
            if($userid == '')
                continue;

            $UserData[$userid]['paid'] = _rnd($UserData[$userid]['paid']);
            $UserData[$userid]['pending'] = _rnd($UserData[$userid]['pending']);
            $UserData[$userid]['approved'] = _rnd($UserData[$userid]['approved']);
            $UserData[$userid]['reversed'] = _rnd($UserData[$userid]['reversed']);
        }
        
        return $UserData;
    }

    //--------------------------------------------------------------------------

    function notDeniedStatus($statuses, $deniedStatuses) {
        
        $ret = array();
        
        if (!is_array($statuses)) {
            if(in_array($statuses, $deniedStatuses)) {
                $statuses = '';
            }
            return $statuses;
        }
        
        foreach ($statuses as $status) {
            if (!in_array($status, $deniedStatuses)) {
                $ret[] = $status;
            }
        }
        
        return $ret;
    }
    
    //--------------------------------------------------------------------------

    function getTransactionsStats($conditions, $AccountID = '')
    {
        $CampaignID = $conditions['CampaignID'];
        $UserID = $conditions['UserID'];
        $TransactionType = $conditions['TransactionType'];
        $Status = $conditions['Status'];
        $denyStatus = $conditions['denyStatus'];
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
        $extrafilter = $conditions['extrafilter'];
	
    //------------------------------------------------
    //added by AdAstra
	$dateSelectMode = $conditions['dateSelectMode'];
    //------------------------------------------------

        $UserData = array();
        $UserData['transactions'] = array();

        // condition
        if($CampaignID != '' && $CampaignID != '_') // filter by campaign
        {        
            $sql = "select a.userid, a.username, a.name, a.surname, a.weburl, t.transid, t.totalcost, t.orderid, t.dateinserted,".
                   " t.rstatus, t.transtype, t.transkind, t.payoutstatus, t.dateapproved,".
                   " t.commission, cc.salecommtype, t.ip, t.data1, t.data2, t.data3, t.countrycode, t.count ".
                   "from wd_pa_transactions t, wd_pa_campaigncategories cc, wd_g_users a ";

            $sqlCount = "select count(*) as count from wd_pa_transactions t, wd_pa_campaigncategories cc, wd_g_users a ";
            
            $where = " where t.campcategoryid=cc.campcategoryid".
                     "   and t.affiliateid=a.userid and a.deleted=0".
                     "   and a.rstatus=".AFFSTATUS_APPROVED;
            if($AccountID != '') $where .= "   and a.accountid="._q($AccountID);
        }
        else
        {
            $sql = "select a.userid, t.transid, t.totalcost, t.orderid, t.dateinserted,".
                   " t.rstatus, t.transtype, t.transkind, t.payoutstatus, t.dateapproved,".
                   " t.commission, t.ip, t.data1, t.data2, t.data3, t.countrycode, t.count ".
                   "from wd_pa_transactions t, wd_g_users a ";

            $sqlCount = "select count(*) as count from wd_pa_transactions t, wd_g_users a ";

            $where = " where t.affiliateid=a.userid and a.deleted=0".
                     "   and a.rstatus=".AFFSTATUS_APPROVED;
            if($AccountID != '') $where .= "   and a.accountid="._q($AccountID);
        }

                 
        $where2 = '';
	//-----------------------------------
	//added switch between dateinserted and dateapproved, date inserted is default
	switch( $dateSelectMode ){
	    case 2:
		if( $d1 != '' && $m1 != '' && $y1 != ''){
		    $where2 .= " and (".sqlToDays('t.dateapproved')." >= ".sqlToDays("$y1-$m1-$d1").")".
			    " and (".sqlToDays('t.dateapproved')." <= ".sqlToDays("$y2-$m2-$d2").")";
		}
//		$orderby = " order by t.dateapproved";
		break;
		
	    default:
    		if($d1 != '' && $m1 != '' && $y1 != '') //filter by date
    		{
        	    $where2 .= " and (".sqlToDays('t.dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
            		      " and (".sqlToDays('t.dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
    		}
//		$orderby = " order by t.dateinserted";
		break;
	}
        
        if($CampaignID != '' && $CampaignID != '_') // filter by campaign
        {
            $where2 .= " and cc.campaignid="._q($CampaignID);
        }
        
        if($UserID != '' && $UserID != '_')
        {
            $where2 .= " and a.userid="._q($UserID);
        }

        if(is_array($TransactionType))
        {
            if(count($TransactionType) > 0)
            {
                $where2 .= " and t.transtype in (".implode(',', $TransactionType).")";
            } else {
                $where2 .= " and t.transtype is NULL";
            }
        }
        else
        {
            if($TransactionType != '' && $TransactionType != '_') {
                $where2 .= " and t.transtype="._q($TransactionType);
            }
        }
        
        if (is_array($denyStatus)) {
            $Status = $this->notDeniedStatus($Status, $denyStatus);
        }

        if(is_array($Status))
        {
            if(count($Status) > 0)
            {
                $where2 .= " and t.rstatus in (".implode(',', $Status).")";
            } else {
                $where2 .= " and t.rstatus is NULL";
            }
        }
        else
        {
            if($Status != '' && $Status != '_'/*&& !in_array($Status, $this->denyStatus)*/){
                $where2 .= " and t.rstatus="._q($Status);
            }
        }
        
        if (is_array($denyStatus) && count($denyStatus) > 0) {
            $where2 .= " and t.rstatus not in (".implode(',', $denyStatus).")";
        }
        
        if(count($extrafilter) > 0) {
            foreach ($extrafilter as $column => $value) {
                if (($value != '') && ($column != '')) {
            	   $where2 .= " and ".$column." like '%"._q_noendtags($value)."%'";
                }
            }
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
	    
        if($page !== '' && $rowsPerPage !== '')
        {
            //------------------------------------------------
            // get total number of records
            $rs = QCore_Sql_DBUnit::execute($sqlCount.$where.$where2, __FILE__, __LINE__);
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
    //--------------------------------------------
    //changed orderby
    if( $dateSelectMode == '2' ){   
        $orderby .= " order by t.dateapproved";
    }
    else{
	$orderby .= " order by t.dateinserted";
    }
    //--------------------------------------------
    
    
        if($page !== '' && $rowsPerPage !== '') // paging
        {
            $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$where2.$orderby, $limitOffset, $rowsPerPage, __FILE__, __LINE__);
        }
        else // no paging
        {
            $rs = QCore_Sql_DBUnit::execute($sql.$where.$where2.$orderby, __FILE__, __LINE__);
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
            $temp['transid'] = $rs->fields['transid'];
            $temp['userid'] = $rs->fields['userid'];
            $temp['username'] = $rs->fields['username'];
            $temp['name'] = $rs->fields['name'];
            $temp['surname'] = $rs->fields['surname'];
            $temp['weburl'] = $rs->fields['weburl'];
            $temp['commission'] = $commission;
            $temp['datecreated'] = $rs->fields['dateinserted'];
            $temp['dateupdated'] = $rs->fields['dateapproved'];
            $temp['datepaid'] = $rs->fields['datepayout'];
            $temp['rstatus'] = $rs->fields['rstatus'];
            $temp['payoutstatus'] = $rs->fields['payoutstatus'];
            $temp['transtype'] = $rs->fields['transtype'];
            $temp['transkind'] = $rs->fields['transkind'];
            $temp['totalcost'] = $rs->fields['totalcost'];
            $temp['orderid'] = $rs->fields['orderid'];
            $temp['ip'] = $rs->fields['ip'];
            $temp['countrycode'] = $rs->fields['countrycode'];
            $temp['data1'] = $rs->fields['data1'];
            $temp['data2'] = $rs->fields['data2'];
            $temp['data3'] = $rs->fields['data3'];
            $temp['count'] = $rs->fields['count'];
            
            $UserData['transactions'][] = $temp;
            
            $rs->MoveNext();
        }
        
        return $UserData;
    }
    
    
    
    
    
    
    
    
    //--------------------------------------------------------------------------




    function getSignupStats($CampaignID, $d1 = '', $m1 = '', $y1 = '', $d2 = '', $m2 = '', $y2 = '')
    {
        $filterByDate = true;
        $filterByCampaign = true;    
        
        if($d1 == '' && $m1 == '' && $y1 == '')
            $filterByDate = false;
        if($CampaignID == '' || $CampaignID == '_')
            $filterByCampaign = false;

        $UserData['sales_approved'] = 0;

        $sql = "select userid from wd_g_users";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        while(!$rs->EOF)
        {
            $UserID = $rs->fields['userid'];
            
            $UserData[$UserID]['sales_approved'] = 0;

            $rs->MoveNext();
        }

        $sql = "select a.userid, t.rstatus, t.transtype, t.transkind, t.payoutstatus, sum(t.commission) as revenue ".
               "from wd_pa_transactions t, wd_g_users a ".
               "where t.campcategoryid is null and t.affiliateid=a.userid".
               "  and a.deleted=0 and a.rstatus="._q(AFFSTATUS_APPROVED).
               "  and t.accountid="._q($GLOBALS['Auth']->getAccountID());
               "  and t.rstatus="._q(AFFSTATUS_APPROVED).
               "  and t.transtype="._q(TRANSTYPE_SIGNUP);

        if($filterByDate)
            $sql .= " and (".sqlToDays('t.dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
                    " and (".sqlToDays('t.dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";

        $sql .= " group by a.userid"; //, t.transkind, t.payoutstatus
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        while(!$rs->EOF)
        {
            $UserID = $rs->fields['userid'];

            $UserData[$UserID]['sales_approved'] = $rs->fields['revenue'];

            $UserData['sales_approved'] += $rs->fields['revenue'];

            $rs->MoveNext();
        }

        return $UserData;
    }
    
    
    
    
    
    
    //------------------------------------------------------------------------
    
    
    
    
    
    
    function getBannerStats($UserID, $d1, $m1, $y1, $d2, $m2, $y2, $allowed_affiliatesSQL = '')
    {
        $data = array();
        
        // initialize
        $sql = "select bannerid from wd_pa_banners ";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        while(!$rs->EOF)
        {
            $data[$rs->fields['bannerid']]['unique_impressions_all'] = 0;
            $data[$rs->fields['bannerid']]['unique_impressions_period'] = 0;
            $data[$rs->fields['bannerid']]['impressions_all'] = 0;
            $data[$rs->fields['bannerid']]['impressions_period'] = 0;
            $data[$rs->fields['bannerid']]['clicks_all'] = 0;
            $data[$rs->fields['bannerid']]['clicks_period'] = 0;
            
            if($UserID != '' && $UserID != '_') {
                $data[$rs->fields['bannerid']][$UserID]['unique_impressions_all'] = 0;
                $data[$rs->fields['bannerid']][$UserID]['unique_impressions_period'] = 0;
                $data[$rs->fields['bannerid']][$UserID]['impressions_all'] = 0;
                $data[$rs->fields['bannerid']][$UserID]['impressions_period'] = 0;
                $data[$rs->fields['bannerid']][$UserID]['clicks_all'] = 0;
                $data[$rs->fields['bannerid']][$UserID]['clicks_period'] = 0;
            }
            
            $rs->MoveNext();
        }
        
        //------------------------------------------------
        // get all imps
        $sql = 'select affiliateid, bannerid, sum(all_imps_count) as all_imps,'.
               ' sum(unique_imps_count) as unique_imps '.
               'from wd_pa_impressions where 1=1 ';
        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK && strlen($allowed_affiliatesSQL) > 2)
            $sql .= ' and affiliateid in '.$allowed_affiliatesSQL;
        $sql .= ' group by affiliateid, bannerid';
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        while(!$rs->EOF)
        {
            $data[$rs->fields['bannerid']]['impressions_all'] += $rs->fields['all_imps'];
            $data[$rs->fields['bannerid']]['unique_impressions_all'] += $rs->fields['unique_imps'];
            
            if($UserID != '' && $UserID != '_' && $rs->fields['affiliateid'] == $UserID) {
                $data[$rs->fields['bannerid']][$UserID]['impressions_all'] += $rs->fields['all_imps'];
                $data[$rs->fields['bannerid']][$UserID]['unique_impressions_all'] += $rs->fields['unique_imps'];
            }
            
            $rs->MoveNext();
        }

        //------------------------------------------------
        // get imps in period
        $sql = "select affiliateid, bannerid, sum(all_imps_count) as today_imps, sum(unique_imps_count) as unique_imps ".
               "from wd_pa_impressions where ".
               " (".sqlToDays('dateimpression')." >= ".sqlToDays("$y1-$m1-$d1").")".
               " and (".sqlToDays('dateimpression')." <= ".sqlToDays("$y2-$m2-$d2").")";
        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK && strlen($allowed_affiliatesSQL) > 2)
            $sql .= " and affiliateid in ".$allowed_affiliatesSQL;
        $sql .= " group by affiliateid, bannerid";

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        while(!$rs->EOF)
        {
            $data[$rs->fields['bannerid']]['impressions_period'] += $rs->fields['today_imps'];
            $data[$rs->fields['bannerid']]['unique_impressions_period'] += $rs->fields['unique_imps'];
            
            if($UserID != '' && $UserID != '_' && $rs->fields['affiliateid'] == $UserID) {
                $data[$rs->fields['bannerid']][$UserID]['impressions_period'] += $rs->fields['today_imps'];
                $data[$rs->fields['bannerid']][$UserID]['unique_impressions_period'] += $rs->fields['unique_imps'];
            }
            
            $rs->MoveNext();
        }

        // get all clicks
        $sql = "select affiliateid, bannerid, sum(count) as all_clicks ".
               "from wd_pa_transactions where transtype=".TRANSTYPE_CLICK." and transkind=".TRANSKIND_NORMAL;
        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK && strlen($allowed_affiliatesSQL) > 2)
            $sql .= " and affiliateid in ".$allowed_affiliatesSQL;
        $sql .= " group by affiliateid, bannerid";

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        while(!$rs->EOF)
        {
            $data[$rs->fields['bannerid']]['clicks_all'] += $rs->fields['all_clicks'];
            
            if($UserID != '' && $UserID != '_' && $rs->fields['affiliateid'] == $UserID) {
                $data[$rs->fields['bannerid']][$UserID]['clicks_all'] = $rs->fields['all_clicks'];
            }

            $rs->MoveNext();
        }    
        
        // get clicks in period
        $sql = "select affiliateid, bannerid, sum(count) as today_clicks ".
               "from wd_pa_transactions where transtype=".TRANSTYPE_CLICK." and transkind=".TRANSKIND_NORMAL.
               " and (".sqlToDays('dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
               " and (".sqlToDays('dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK && strlen($allowed_affiliatesSQL) > 2)
            $sql .= " and affiliateid in ".$allowed_affiliatesSQL;
        $sql .= " group by affiliateid, bannerid";
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        while(!$rs->EOF)
        {
            $data[$rs->fields['bannerid']]['clicks_period'] += $rs->fields['today_clicks'];
            
            if($UserID != '' && $UserID != '_' && $rs->fields['affiliateid'] == $UserID) {
                $data[$rs->fields['bannerid']][$UserID]['clicks_period'] = $rs->fields['today_clicks'];
            }
            
            $rs->MoveNext();
        }

        //------------------------------------------
        // compute clickthrouh ratios
        foreach($data as $bannerID => $userData)
        {
            if($data[$bannerID]['unique_impressions_all'] == '') $data[$bannerID]['unique_impressions_all'] == 0;
            if($data[$bannerID]['unique_impressions_period'] == '') $data[$bannerID]['unique_impressions_period'] == 0;
            if($data[$bannerID]['impressions_all'] == '') $data[$bannerID]['impressions_all'] == 0;
            if($data[$bannerID]['impressions_period'] == '') $data[$bannerID]['impressions_period'] == 0;
            if($data[$bannerID]['clicks_all'] == '') $data[$bannerID]['clicks_all'] == 0;
            if($data[$bannerID]['clicks_period'] == '') $data[$bannerID]['clicks_period'] == 0;
            
            // CTR ratio for all
            if($data[$bannerID]['unique_impressions_all'] == 0 || $data[$bannerID]['clicks_all'] == 0) {
                $data[$bannerID]['ratio_all'] = '0.0';
            } else {
                $data[$bannerID]['ratio_all'] = _rnd(($data[$bannerID]['clicks_all']/$data[$bannerID]['unique_impressions_all'])*100.0); //round(($clicksAll/$impressionsAll)*100.0, 2);
            }
            
            $data[$bannerID]['ratio_all'] .= ' %';
            
            if($data[$bannerID]['unique_impressions_period'] == 0 || $data[$bannerID]['clicks_period'] == 0) {
                $data[$bannerID]['ratio_period'] = '0.0';
            } else {
                $data[$bannerID]['ratio_period'] = _rnd(($data[$bannerID]['clicks_period']/$data[$bannerID]['unique_impressions_period'])*100.0); //round(($clicksToday/$impressionsToday)*100.0, 2);
            }
            
            $data[$bannerID]['ratio_period'] .= ' %';

            if($UserID != '' && $UserID != '_') {
                // CTR ratio for user
                if($data[$bannerID][$UserID]['unique_impressions_all'] == 0 || $data[$bannerID][$UserID]['clicks_all'] == 0) {
                    $data[$bannerID][$UserID]['ratio_all'] = '0.0';
                } else {
                    $data[$bannerID][$UserID]['ratio_all'] = _rnd(($data[$bannerID][$UserID]['clicks_all']/$data[$bannerID][$UserID]['unique_impressions_all'])*100.0); //round(($clicksAll/$impressionsAll)*100.0, 2);
                }
                
                $data[$bannerID][$UserID]['ratio_all'] .= ' %';
                
                if($data[$bannerID][$UserID]['unique_impressions_period'] == 0 || $data[$bannerID][$UserID]['clicks_period'] == 0) {
                    $data[$bannerID][$UserID]['ratio_period'] = '0.0';
                } else {
                    $data[$bannerID][$UserID]['ratio_period'] = _rnd(($data[$bannerID][$UserID]['clicks_period']/$data[$bannerID][$UserID]['unique_impressions_period'])*100.0); //round(($clicksToday/$impressionsToday)*100.0, 2);
                }
                
                $data[$bannerID][$UserID]['ratio_period'] .= ' %';
            }
        }

        return $data;
    }    
    

    
    //--------------------------------------------------------------------------

    
    
    
    function getStatsForRules($params)
    {
        if($params['AccountID'] == '' || !is_array($params['users']) || count($params['users']) < 1) return false;

        $affiliateIDSql = "('".implode("','", $params['users'])."')";

        // year and month stats
        $sql = 'select count(transid) as numberofsales, sum(commission) as amountofcommissions, '.
               'sum(totalcost) as amountoftotalcost, '.
               sqlMonth('dateinserted').' as  rmonth, '.sqlYear('dateinserted').' as  ryear, '.
               'transtype, transkind, affiliateid '.
               'from wd_pa_transactions '.
               'where accountid='._q($params['AccountID']).
               '  and affiliateid in '.$affiliateIDSql.
               '  and rstatus='._q(AFFSTATUS_APPROVED).
               ' group by '.sqlMonth('dateinserted').','.sqlYear('dateinserted').',transtype,transkind,affiliateid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF) return false;

        $stats = array();
        
        while(!$rs->EOF)
        {
            if($rs->fields['transtype'] == TRANSTYPE_SALE && $rs->fields['transkind'] == TRANSKIND_NORMAL) {
                $stats[$rs->fields['affiliateid']]['month'][$rs->fields['rmonth']][$rs->fields['ryear']][RULE_NUMBER_OF_SALES] = $rs->fields['numberofsales'];
                $stats[$rs->fields['affiliateid']]['month'][$rs->fields['rmonth']][$rs->fields['ryear']][RULE_AMOUNT_OF_COMMISSIONS] += $rs->fields['amountofcommissions'];
                $stats[$rs->fields['affiliateid']]['month'][$rs->fields['rmonth']][$rs->fields['ryear']][RULE_AMOUNT_OF_TOTAL_COST] += $rs->fields['amountoftotalcost'];
                
                $stats[$rs->fields['affiliateid']]['year'][$rs->fields['ryear']][RULE_NUMBER_OF_SALES] += $rs->fields['numberofsales'];
                $stats[$rs->fields['affiliateid']]['year'][$rs->fields['ryear']][RULE_AMOUNT_OF_COMMISSIONS] += $rs->fields['amountofcommissions'];
                $stats[$rs->fields['affiliateid']]['year'][$rs->fields['ryear']][RULE_AMOUNT_OF_TOTAL_COST] += $rs->fields['amountoftotalcost'];
                
                $stats[$rs->fields['affiliateid']]['all'][RULE_NUMBER_OF_SALES] += $rs->fields['numberofsales'];
                $stats[$rs->fields['affiliateid']]['all'][RULE_AMOUNT_OF_COMMISSIONS] += $rs->fields['amountofcommissions'];
                $stats[$rs->fields['affiliateid']]['all'][RULE_AMOUNT_OF_TOTAL_COST] += $rs->fields['amountoftotalcost'];
            }
            
            $rs->MoveNext();
        }
        
        // week stats
        $sql = 'select count(transid) as numberofsales, sum(commission) as amountofcommissions, '.
               'sum(totalcost) as amountoftotalcost, '.
               sqlYearWeek('dateinserted').' as  ryearweek, '.
               'transtype, transkind, affiliateid '.
               'from wd_pa_transactions '.
               'where accountid='._q($params['AccountID']).
               '  and affiliateid in '.$affiliateIDSql.
               '  and rstatus='._q(AFFSTATUS_APPROVED).
               ' group by '.sqlYearWeek('dateinserted').',transtype,transkind,affiliateid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF) return false;

        while(!$rs->EOF)
        {
            if($rs->fields['transtype'] == TRANSTYPE_SALE && $rs->fields['transkind'] == TRANSKIND_NORMAL) {
                $stats[$rs->fields['affiliateid']]['yearweek'][$rs->fields['ryearweek']][RULE_NUMBER_OF_SALES] = $rs->fields['numberofsales'];
                $stats[$rs->fields['affiliateid']]['yearweek'][$rs->fields['ryearweek']][RULE_AMOUNT_OF_COMMISSIONS] += $rs->fields['amountofcommissions'];
                $stats[$rs->fields['affiliateid']]['yearweek'][$rs->fields['ryearweek']][RULE_AMOUNT_OF_TOTAL_COST] += $rs->fields['amountoftotalcost'];
            }

            $rs->MoveNext();
        }

        return $stats;
    }
    
    //------------------------------------------------------------------------------------------

    function getTransactionsSummariesForAffiliateManager()
    {

        $sql = "select a.userid, t.rstatus, t.payoutstatus, sum(t.commission) as commission, sum(t.totalcost) as totalcost ".
               "from wd_pa_transactions t, wd_g_users a";
               
        $where = " where t.affiliateid=a.userid ".
                 "   and a.deleted=0 and a.rstatus=".AFFSTATUS_APPROVED.
                 "   and a.accountid="._q($GLOBALS['Auth']->getAccountID());
                 
        $groupby .= " group by a.userid, t.rstatus, t.payoutstatus";
        $orderby .= " order by t.dateinserted";
        
        $rs = QCore_Sql_DBUnit::execute($sql.$where.$groupby.$orderby, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        $UserData = array();

        while(!$rs->EOF)
        {
            $commission = $rs->fields['commission'];

            $UserData[$rs->fields['userid']]['totalcost'] += $rs->fields['totalcost'];

            if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED)
            {
                if($rs->fields['payoutstatus'] == AFFSTATUS_SUPPRESSED || $rs->fields['payoutstatus'] == AFFSTATUS_NOTAPPROVED)
                    $UserData[$rs->fields['userid']]['reversed'] += $commission;
                else if($rs->fields['payoutstatus'] == AFFSTATUS_APPROVED)
                    $UserData[$rs->fields['userid']]['paid'] += $commission;        
            }
            else if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED)
            {
                $UserData[$rs->fields['userid']]['pending'] += $commission;
            }
            else if($rs->fields['rstatus'] == AFFSTATUS_APPROVED)
            {
                if($rs->fields['payoutstatus'] == AFFSTATUS_SUPPRESSED)
                    $UserData[$rs->fields['userid']]['reversed'] += $commission;
                else if($rs->fields['payoutstatus'] == AFFSTATUS_NOTAPPROVED)
                    $UserData[$rs->fields['userid']]['approved'] += $commission;
                else if($rs->fields['payoutstatus'] == AFFSTATUS_APPROVED)
                    $UserData[$rs->fields['userid']]['paid'] += $commission; 
            }
            
            $rs->MoveNext();
        }
        
        foreach($UserData as $userid => $userinfo)
        {
            if($userid == '')
                continue;

            $UserData[$userid]['paid'] = _rnd($UserData[$userid]['paid']);
            $UserData[$userid]['pending'] = _rnd($UserData[$userid]['pending']);
            $UserData[$userid]['approved'] = _rnd($UserData[$userid]['approved']);
            $UserData[$userid]['reversed'] = _rnd($UserData[$userid]['reversed']);
        }
        
        return $UserData;
    }
}
?>
