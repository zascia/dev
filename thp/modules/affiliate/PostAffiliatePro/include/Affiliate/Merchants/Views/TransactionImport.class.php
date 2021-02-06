<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_FileImport');

class Affiliate_Merchants_Views_TransactionImport extends Affiliate_Merchants_Views_FileImport
{   
    var $blAffiliate;
    var $blCampaignCategories;
    
    //--------------------------------------------------------------------------
    
    function Affiliate_Merchants_Views_TransactionImport() {
        $this->blAffiliate = QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blCampaignCategories = QUnit_Global::newObj('Affiliate_Merchants_Bl_CampaignCategories');
        
        $this->table = 'wd_pa_transactions';
        $this->title = L_G_TRANSACTION_IMPORT;
        $this->description = L_G_TRANSACTION_IMPORT_DESCRIPTION;
        $this->progressDescription = L_G_TRANSACTION_IMPORT_PROGRESS_DESCRIPTION;
        $this->id = 'trans';
        $this->fieldsToDisplay = array('totalcost', 'commission');
        
        $this->addColumn('rstatus',          L_G_TRANS_STATUS);
        $this->addColumn('transkind',        L_G_TRANSKIND, FIELD_PROCESS);
        $this->addColumn('dateinserted',     L_G_DATEINSERTED);
        $this->addColumn('dateapproved',     L_G_DATEAPPROVED);
        $this->addColumn('payoutstatus',     L_G_TRANS_PAYOUTSTATUS);
        $this->addColumn('datepayout',       L_G_DATEPAYOUT);
        $this->addColumn('totalcost',        L_G_TOTAL_COST);
        $this->addColumn('commission',       L_G_COMMISSION);
        $this->addColumn('affiliate_name',   L_G_TRANS_AFFILIATE_NAME, FIELD_NOIMPORT);
        $this->addColumn('affiliate_userid', L_G_TRANS_AFFILIATE_USERID, FIELD_NOIMPORT);
        $this->addColumn('affiliate_refid',  L_G_TRANS_AFFILIATE_REFID, FIELD_NOIMPORT);
        $this->addColumn('campaign_id',      L_G_CAMPAIGNID, FIELD_MANDATORY);
        $this->addColumn('refererurl',       L_G_REFERERURL);
        $this->addColumn('ip',               L_G_IP);
        $this->addColumn('orderid',          L_G_ORDERID);
        $this->addColumn('productid',        L_G_PRODUCTID);
        $this->addColumn('data1',            L_G_DATA1);
        $this->addColumn('data2',            L_G_DATA2);
        $this->addColumn('data3',            L_G_DATA3);
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_CTRSALES,'index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all');
        $this->navigationAddURL(L_G_TRANSACTION_IMPORT,'index.php?md=Affiliate_Merchants_Views_TransactionImport');
    }
    
    //--------------------------------------------------------------------------
    
    function process() {
        $this->assign('a_md', $this->md = 'Affiliate_Merchants_Views_TransactionImport');
        $this->assign('a_showTranstype', '1');
        parent::process();
    }
    
    //--------------------------------------------------------------------------
    
    function checkDuplicityAndMandatoryFields($data)
	{
	    parent::checkDuplicityAndMandatoryFields($data);
        
        // mandatory fields
        $affiliate = array();
        if (in_array('affiliate_name', $this->selectedFields)) $affiliate[] = 'affiliate_name';
        if (in_array('affiliate_userid', $this->selectedFields)) $affiliate[] = 'affiliate_userid';
        if (in_array('affiliate_refid', $this->selectedFields)) $affiliate[] = 'affiliate_refid';
        if (count($affiliate) != 1) {
            QUnit_Messager::setErrorMessage(L_G_YOUHAVETOSELECTONEOFTHISFIELDS.
                L_G_TRANS_AFFILIATE_NAME." ".L_G_TRANS_AFFILIATE_USERID." ".L_G_TRANS_AFFILIATE_REFID);
        }
	}
	
	//--------------------------------------------------------------------------

    function processSaveSettings() {
        $_SESSION['import_transtype'] = $_POST['transtype'];
        $pMatchBy = preg_replace('/[\"\']/', '', $_POST['match_by']);
        if ($pMatchBy != '_' && in_array($pMatchBy, array("orderid"))) {
            $_SESSION['match_by'] = $pMatchBy;
        } else {
            $_SESSION['match_by'] = false;
        }
        $_SESSION['transaction_status'] = preg_replace('/[\"\']/', '', $_POST['import_status']);
        
        return parent::processSaveSettings();
    }
	
	//--------------------------------------------------------------------------
    
    function insertRow($data) {
        $importData = array();
        $importData['accountid'] = $GLOBALS['Auth']->getAccountId();
        $importData['transid'] = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
        $importData['transtype'] = $_SESSION['import_transtype'];
        foreach ($data as $name => $value) {
	        switch ($name) {
	            case 'rstatus':
	               switch ($value) {
	                   case 'approved':
	                       $importData['rstatus'] = AFFSTATUS_APPROVED;
	                       break;
	                   case 'declined':
	                       $importData['rstatus'] = AFFSTATUS_SUPPRESSED;
	                       break;
	                   case 'pending':
	                       $importData['rstatus'] = AFFSTATUS_NOTAPPROVED;
	                       break;
	                   default:
	                       return L_G_INVALIDSTATUS;
	               }
	               break;
	            case 'payoutstatus':
	               switch ($value) {
	                   case 'paid':
	                       $importData['payoutstatus'] = AFFSTATUS_APPROVED;
	                       break;
	                   case 'unpaid':
	                       $importData['payoutstatus'] = AFFSTATUS_NOTAPPROVED;
	                       break;
	                   default:
	                       return L_G_INVALIDPAYOUTSTATUS;
	               }
	               break;
	            case 'transkind':
	               if ($value == "NULL") $value = 1;
	               if ((!is_numeric($value)) || ($value < 1) || ($value > $GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels')))
	                   return L_G_TRANSKIND." ".L_G_MUSTBEININTERVAL." 1 ".L_G_TO." ".$GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels');
                   $importData['transkind'] = ($value == 1) ? 1 : $value+9;
	               break;
	            case 'dateinserted':
	               if ($value == "NULL") $value = "";
	               if (($t = strtotime($value)) == -1) return L_G_INVALID_DATEINSERTED;
	               $importData['dateinserted'] = date("Y-m-d H:i:s", $t);
	               break;
	            case 'dateapproved':
	               if ($value == "NULL") $value = "";
	               if (($t = strtotime($value)) == -1) return L_G_INVALID_DATEAPPROVED;
	               $importData['dateapproved'] = date("Y-m-d H:i:s", $t);
	               break;
	            case 'datepayout':
	               if ($value == "NULL") $value = "";
	               if (($t = strtotime($value)) == -1) return L_G_INVALID_DATEPAYOUT;
	               $importData['datepayout'] = date("Y-m-d H:i:s", $t);
	               break;
	            case 'totalcost':
	               if ($value == "NULL") $value = 0;
	               if (!is_numeric($value)) return L_G_TOTAL_COST." ".L_G_MUSTBENUMBER;
	               $importData['totalcost'] = $data['totalcost'];
	               break;
	            case 'commission':
	               if ($value == "NULL") $value = 0;
	               if (!is_numeric($value)) return L_G_COMMISSION." ".L_G_MUSTBENUMBER;
	               $importData['commission'] = $data['commission'];
	               break;
	            case 'affiliate_name':
	               if (($id = $this->blAffiliate->getUserId($value, '', '')) === false)
	                   return L_G_AFFILIATEDOESNOTEXIST;
	               $importData['affiliateid'] = $id;
	               break;
	            case 'affiliate_userid':
	               if (($id = $this->blAffiliate->getUserId('', $value, '')) === false)
	                   return L_G_AFFILIATEDOESNOTEXIST;
	               $importData['affiliateid'] = $id;
	               break;
	            case 'affiliate_refid':
	               if (($id = $this->blAffiliate->getUserId('', '', $value)) === false)
	                   return L_G_AFFILIATEDOESNOTEXIST;
	               $importData['affiliateid'] = $id;
	               break;
	            case 'campaign_id':
	               if (($id = $this->blCampaignCategories->getDefaultCategoryID($value)) === false)
	                   return L_G_CAMPAIGNDOESNOTEXIST;
	               $importData['campcategoryid'] = $id;
	               break;
	            default:
	               if ($value == "NULL") $value = "";
	               $importData[$name] = $data[$name];
	               break;
	        }
	    }
	    
	    switch ($_SESSION['transaction_status']) {
	        case IMPORTSTATUS_FROMFILE:
	            if ($importData['rstatus'] == '') $importData['rstatus'] = AFFSTATUS_NOTAPPROVED;
	            break; 
	        case IMPORTSTATUS_PAID:
	            $importData['payoutstatus'] = AFFSTATUS_APPROVED;
	            break;
	        default:
	            $importData['rstatus'] = $_SESSION['transaction_status'];
	            break;
	    }
	    if ($importData['payoutstatus'] == '') $importData['payoutstatus'] = AFFSTATUS_NOTAPPROVED;
	    if ($importData['transkind'] == '') $importData['transkind'] = TRANSKIND_NORMAL;
	    if ($importData['commission'] == '') $importData['commission'] = 0;

        if (!$this->insertOrUpdateRow($importData)) {
            return L_G_DBERROR;
        } else {
            return L_G_OK;
        }
    }
    
    //--------------------------------------------------------------------------
    
    function insertOrUpdateRow($importData) {
        if ($_SESSION['match_by'] == false) {
            return $this->_insertRow($importData);
        } else {
            if ($rowId = ($this->_getRow($_SESSION['match_by'], $importData[$_SESSION['match_by']]))) {
                return $this->_updateRow($importData, $rowId);
            } else {
                return $this->_insertRow($importData);
            }
        }
    }
    
	//--------------------------------------------------------------------------
    
    function _getSetStatement($importData) {
        $sql = '';
        foreach ($importData as $key => $value) {
            $sql .= ($sql == '') ? '' : ',';
            $sql .= $key."="._q($value);
        }
        return $sql;
    }
    
	//--------------------------------------------------------------------------
    
    function _insertRow($importData) {
        $sql = "INSERT INTO ".$this->table." SET ".
               $this->_getSetStatement($importData);
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs) return false;
        
        return true;
    }
    
	//--------------------------------------------------------------------------
    
    function _updateRow($importData, $rowId) {
        unset($importData['transid']);
        $sql = "UPDATE ".$this->table." SET ".
               $this->_getSetStatement($importData).
               " WHERE transid="._q($rowId);
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs) return false;
        
        return true;
    }
    
	//--------------------------------------------------------------------------
    
    function _getRow($key, $value) {
        if ($value == '') return false;
        
        $sql = "SELECT transid FROM wd_pa_transactions WHERE ".$key."="._q($value);
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs || $rs->EOF) {
            return false;
        } 
        
        return $rs->fields['transid'];
    }
    
	//--------------------------------------------------------------------------

    function showImportForm()
    {
        $this->assign('a_additionalSettingsTemplate', 'transaction_import.tpl.php');
        
        parent::showImportForm();
    }
}  
?>
