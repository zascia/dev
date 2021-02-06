<?php
//============================================================================
// Copyright (c) webradev.com 2006
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Merchants_Bl_Archive
{
	var $archive_date;
	var $accountid;
	var $aggregation;
	var $progress;
	var $table;
	
    //------------------------------------------------------------------------
    
    function Affiliate_Merchants_Bl_Archive() {
    }
    
    //------------------------------------------------------------------------
    
    function initArchive($params) {
    	if (($params['archive_date']['year'] == '') ||
    	    ($params['archive_date']['month'] == '') ||
    	    ($params['archive_date']['day'] == '')) 
    	    return false;
    	if ($params['accountid'] == '') 
    	    return false;
    	if (!in_array($params['aggregation'], array(AGGREGATION_HOUR, AGGREGATION_DAY))) 
    	    return false;
    	    
        $this->archive_date = $params['archive_date']['year'].'-';
        if ($params['archive_date']['month'] < 10) $this->archive_date .= '0';
    	$this->archive_date .= $params['archive_date']['month'].'-';
    	if ($params['archive_date']['day'] < 10) $this->archive_date .= '0';
    	$this->archive_date .= $params['archive_date']['day'];

        $this->accountid = $params['accountid'];
        $this->aggregation = $params['aggregation'];
        $this->table = $params['table'];
        $this->progress = 1;
        
        $_SESSION[SESSION_PREFIX.'archiveObject'] = serialize($this);
        
        return true;
    }
    
    //------------------------------------------------------------------------
    function getProgress() {
        return $this->progress;
    }
    
    //------------------------------------------------------------------------
    function startNextStep() {
        $this->progress++;
    }
    
    //------------------------------------------------------------------------
    function getSql($substep = 1) {
        if ($this->table == 'wd_pa_transactions') {
            $dateColumn = 'dateinserted';
        } elseif ($this->table == 'wd_pa_impressions') {
            $dateColumn = 'dateimpression';
        }
            
        if ($this->aggregation == AGGREGATION_HOUR) {
            $dateGroup = "DATE_FORMAT(".$dateColumn.", '%Y-%m-%d %H:00:00')";
        } else {
            $dateGroup = "DATE_FORMAT(".$dateColumn.", '%Y-%m-%d 00:00:00')";
        }
        
        $sql = '';
        
        switch ($this->progress) {
            case 1:
                switch ($substep) {
                    case 1:
                        $sql = 'delete from '.$this->table.'_tmp;';
                        return $sql;
                    case 2:
                        if ($this->table == 'wd_pa_transactions') {
                            $sql = 'insert into wd_pa_transactions_tmp ('.
                                   'transid, accountid, rstatus, dateinserted, dateapproved, transtype, payoutstatus, datepayout, '.
                 	               ' cookiestatus, orderid, totalcost, bannerid, rotatorid, transkind, refererurl, affiliateid, '.
                 	               ' campcategoryid, parenttransid, commission, '.
   	                               ' ip, countrycode, recurringcommid, accountingid, '.
   	                               ' productid, data1, data2, data3, browser, count)'.
   	                               ' select transid, '._q($this->accountid).' as accountid, rstatus, '.
   	                               ' '.$dateGroup.' as dateinserted, null as dateapproved, '.
   	                               ' '._q(TRANSTYPE_CLICK).' as transtype, payoutstatus, null as datepayout, '.
                 	               ' null as cookiestatus, null as orderid, sum(totalcost) as totalcost,'.
   	                               ' bannerid, rotatorid, transkind, null as refererurl, affiliateid, '.
                 	               ' campcategoryid, null as parenttransid, sum(commission) as commission, '.
   	                               ' null as ip, countrycode, null as recurringcommid, accountingid, '.
   	                               ' null as productid, null as data1, null as data2, null as data3, '.
   	                               ' null as browser, sum(count) as count'.
   	                               ' from wd_pa_transactions'.
                                   ' where transtype=1'.
        		                   ' and accountid='._q($this->accountid).
        		                   ' and dateinserted  < '._q($this->archive_date).
                                   ' group by '.$dateGroup.', rstatus, bannerid, rotatorid, affiliateid,'.
        		                   ' campcategoryid, accountingid, transkind, payoutstatus, countrycode'.
        		                   ' order by dateinserted asc;';
                        } elseif ($this->table == 'wd_pa_impressions') {
                            $sql = 'insert into wd_pa_impressions_tmp (impressionid, accountid, dateimpression, bannerid, rotatorid, '.
                                   ' affiliateid, all_imps_count, unique_imps_count, commissiongiven, data1, country)'.
                                   'select impressionid, '._q($this->accountid).' as accountid, '.
                                   ' '.$dateGroup.' as dateimpression, bannerid, rotatorid, affiliateid, '.
                                   ' sum(all_imps_count) as all_imps_count, sum(unique_imps_count) as unique_imps_count, '.
                                   ' commissiongiven, null as data1, country'.
                                   ' from wd_pa_impressions'.
                                   ' where accountid='._q($this->accountid).
        		                   ' and dateimpression < '._q($this->archive_date).
                                   ' group by '.$dateGroup.', bannerid, affiliateid, '.
                                   ' commissiongiven, rotatorid, country '.
                                   ' order by dateimpression asc'; 
                        }
                        return $sql;
                        break;
                    case 3:
                        if ($this->table == 'wd_pa_transactions') {
                            $sql = 'select count(*) as count from '.$this->table.
                                   ' where transtype=1'.
        		                   ' and accountid='._q($this->accountid).
        		                   ' and dateinserted  < '._q($this->archive_date);
                        } elseif ($this->table == 'wd_pa_impressions') {
                            $sql = 'select count(*) as count from '.$this->table.
                                   ' where accountid='._q($this->accountid).
        		                   ' and dateimpression < '._q($this->archive_date);
                        }
                        return $sql;
                    case 4:
                        $sql = 'select count(*) as count from '.$this->table.'_tmp';
                        return $sql;
                }
                break;
            case 2:
                if ($this->table == 'wd_pa_transactions') {
                    $sql = 'ALTER TABLE wd_pa_transactions DROP KEY IDX_pa_transactions_3, '.
                           'DROP KEY IDX_pa_transactions_4, DROP KEY IDX_wd_pa_transactions4, '.
                           'DROP KEY IDX_wd_pa_transactions5, DROP KEY IDX_wd_pa_transactions6, '.
                           'DROP KEY IDX_wd_pa_transactions7, DROP KEY IDX_wd_pa_transactions8, '.
                           'DROP KEY IDX_wd_pa_transactions9, DROP KEY IDX_wd_pa_transactions10;';
                } elseif ($this->table == 'wd_pa_impressions') {
                      $sql = 'ALTER TABLE wd_pa_impressions DROP KEY IDX_pa_impressions_3, '.
                             'DROP KEY IDX_wd_pa_impressions2, DROP KEY IDX_wd_pa_impressions3, '.
                             'DROP KEY IDX_wd_pa_impressions4;';
                }
                return $sql;
                break;
            case 3:
                if ($this->table == 'wd_pa_transactions') {
                    $sql = 'delete from wd_pa_transactions '.
                           'where dateinserted < '._q($this->archive_date).
                           ' and transtype='._q(TRANSTYPE_CLICK).
                           ' and accountid='._q($this->accountid);
                } elseif ($this->table == 'wd_pa_impressions') {
                    $sql = 'delete from wd_pa_impressions '.
                           ' where accountid='._q($this->accountid).
        		           ' and dateimpression < '._q($this->archive_date);
                }
                return $sql;
                break;
            case 4:
                        if ($this->table == 'wd_pa_transactions') {
                            $sql = 'insert into wd_pa_transactions (transid, accountid, rstatus, '.
   	                               ' dateinserted, transtype, payoutstatus, totalcost,'.
   	                               ' bannerid, rotatorid, transkind, affiliateid, '.
                 	               ' campcategoryid, commission, accountingid, count) '.
                                   
   	                               ' select transid, accountid, rstatus, '.
   	                               ' dateinserted, transtype, payoutstatus, totalcost,'.
   	                               ' bannerid, rotatorid, transkind, affiliateid, '.
                 	               ' campcategoryid, commission, accountingid, count'.
   	                               ' from wd_pa_transactions_tmp';
                        } elseif ($this->table == 'wd_pa_impressions') {
                            $sql = 'insert into wd_pa_impressions (impressionid, accountid, dateimpression, bannerid, rotatorid, '.
   	                               ' affiliateid, all_imps_count, unique_imps_count, commissiongiven, data1, country) '.
                                   
   	                               ' select impressionid, accountid, dateimpression, bannerid, rotatorid,  '.
   	                               ' affiliateid, all_imps_count, unique_imps_count, commissiongiven, data1, country'.
   	                               ' from wd_pa_impressions_tmp';                            
                        }
                return $sql;
                break;
            case 5:
                if ($substep == 1) {
                    if ($this->table == 'wd_pa_transactions') {
                        $sql = 'ALTER TABLE wd_pa_transactions ADD KEY IDX_pa_transactions_3(transkind, transtype, rstatus), '.
                               'ADD KEY IDX_pa_transactions_4(campcategoryid), ADD KEY IDX_wd_pa_transactions4(bannerid), '.
                               'ADD KEY IDX_wd_pa_transactions5(affiliateid), ADD KEY IDX_wd_pa_transactions6(parenttransid), '.
                               'ADD UNIQUE KEY IDX_wd_pa_transactions7(transid), ADD KEY IDX_wd_pa_transactions8(recurringcommid), '.
                               'ADD KEY IDX_wd_pa_transactions9(accountingid), ADD KEY IDX_wd_pa_transactions10(accountid);';
                    } elseif ($this->table == 'wd_pa_impressions') {
                        $sql = 'ALTER TABLE wd_pa_impressions ADD KEY IDX_pa_impressions_3(bannerid, affiliateid, dateimpression), '.
                               'ADD KEY IDX_wd_pa_impressions2(bannerid), ADD KEY IDX_wd_pa_impressions3(affiliateid), '.
                               'ADD KEY IDX_wd_pa_impressions4(accountid)';
                    }
                } else {
                    $sql = 'delete from '.$this->table."_tmp;";
                }
                return $sql;
                break;
        }
    }
    
    //------------------------------------------------------------------------
    
    function processExport() {
        $sql = $this->getSql(1);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret) {
         	QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $sql = $this->getSql(2);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret) {
         	QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $rowCounts = array();
        $sql = $this->getSql(3);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF) {
         	QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        $rowCounts['unoptimizedCount'] = $rs->fields['count'];
        
        $sql = $this->getSql(4);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF) {
         	QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        $rowCounts['optimizedCount'] = $rs->fields['count'];
        
        return $rowCounts;
    }
    
    //------------------------------------------------------------------------
    
    function processPrepare() {
        $sql = $this->getSql();
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret) {
         	QUnit_Messager::setOkMessage(L_G_PREVIOUSARCHIVEDIDNOTFINISHOK);
        }
        
        $this->startNextStep();
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function processDelete() {
        $sql = $this->getSql();
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret) {
         	QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $this->startNextStep();
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function processInsert() {
        $sql = $this->getSql();
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        $this->startNextStep();
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function processFinish() {
        $sql = $this->getSql(1);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        $sql = $this->getSql(2);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret) {
         	QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $this->startNextStep();
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function archive() {
        $ret = '';
        switch($this->progress) {
            case 1:
                $ret = $this->processExport();
                break;
            case 2:
                $ret = $this->processPrepare();
                break;
            case 3:
                $ret = $this->processDelete();
                break;
            case 4:
                $ret = $this->processInsert();
                break;
            case 5:
                $ret = $this->processFinish();
                break;
        }
        
        $_SESSION[SESSION_PREFIX.'archiveObject'] = serialize($this);
        return $ret;
    }
    
}
?>
