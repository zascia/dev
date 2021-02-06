<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_FileImport');

class Affiliate_Merchants_Views_AffiliateImport extends Affiliate_Merchants_Views_FileImport
{   
    var $blAffiliate;
    var $blCampaignCategories;
    var $relationFile;
    
    //--------------------------------------------------------------------------
    
    function Affiliate_Merchants_Views_AffiliateImport() {
        $this->blAffiliate = QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blCampaignCategories = QUnit_Global::newObj('Affiliate_Merchants_Bl_CampaignCategories');
        
        $this->table = 'wd_g_users';
        $this->title = L_G_AFFILIATE_IMPORT;
        $this->description = L_G_AFFILIATE_IMPORT_DESCRIPTION;
        $this->progressDescription = L_G_AFFILIATE_IMPORT_PROGRESS_DESCRIPTION;
        $this->id = 'aff';
        $this->fieldsToDisplay = array('username', 'name', 'surname');
        
        $this->addColumn('userid',            L_G_AFFILIATEID);
        $this->addColumn('refid',             L_G_REFID);
        $this->addColumn('username',          L_G_USERNAME, FIELD_MANDATORY);
        $this->addColumn('rpassword',         L_G_PASSWORD);
        $this->addColumn('name',              L_G_NAME);
        $this->addColumn('surname',           L_G_SURNAME);
        $this->addColumn('dateinserted',      L_G_DATEINSERTED);
        $this->addColumn('dateapproved',      L_G_DATEAPPROVED);
        $this->addColumn('rstatus',           L_G_STATUS);
        $this->addColumn('parent_aff_name',   L_G_PARENT_AFFILIATE_NAME, FIELD_NOIMPORT);
        $this->addColumn('parent_aff_userid', L_G_PARENT_AFFILIATE_USERID, FIELD_NOIMPORT);
        $this->addColumn('parent_aff_refid',  L_G_PARENT_AFFILIATE_REFID, FIELD_NOIMPORT);
        $this->addColumn('company_name',      L_G_COMPANYNAME);
        $this->addColumn('weburl',            L_G_WEBURL);
        $this->addColumn('street',            L_G_STREET);
        $this->addColumn('city',              L_G_CITY);
        $this->addColumn('state',             L_G_STATE);
        $this->addColumn('country',           L_G_COUNTRY);
        $this->addColumn('zipcode',           L_G_ZIPCODE);
        $this->addColumn('phone',             L_G_PHONE);
        $this->addColumn('fax',               L_G_FAX);
        $this->addColumn('tax_ssn',           L_G_TAXSSN);
        $this->addColumn('data1',             L_G_DATA.'1');
        $this->addColumn('data2',             L_G_DATA.'2');
        $this->addColumn('data3',             L_G_DATA.'3');
        $this->addColumn('data4',             L_G_DATA.'4');
        $this->addColumn('data5',             L_G_DATA.'5');
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_TOPMENU_AFFILIATES,'index.php?md=Affiliate_Merchants_Views_AffiliateManager');
        $this->navigationAddURL(L_G_AFFILIATE_IMPORT,'index.php?md=Affiliate_Merchants_Views_AffiliateImport');
    }
    
    //--------------------------------------------------------------------------
    
    function process() {
        $this->assign('a_md', $this->md = 'Affiliate_Merchants_Views_AffiliateImport');
        
        if ($_REQUEST['action'] == "afterimport") {
            $this->importParentRelations();
            $this->addContent("file_import_affiliate");
            return true;
        }
        
        if ($_GET['start'] == '1') {
            $this->relationFile = @fopen($GLOBALS['Auth']->getSetting('Aff_export_dir').$_GET['filename']."_PARENT", "w");
        } else {
            $this->relationFile = @fopen($GLOBALS['Auth']->getSetting('Aff_export_dir').$_GET['filename']."_PARENT", "a");
        }
        
        parent::process();
        
        @fclose($this->relationFile);
    }
    
    //--------------------------------------------------------------------------
    
    function checkDuplicityAndMandatoryFields($data)
	{
	    parent::checkDuplicityAndMandatoryFields($data);
        
        // mandatory fields
        $affiliate = array();
        if (in_array('parent_aff_name', $this->selectedFields)) $affiliate[] = 'parent_aff_name';
        if (in_array('parent_aff_userid', $this->selectedFields)) $affiliate[] = 'parent_aff_userid';
        if (in_array('parent_aff_refid', $this->selectedFields)) $affiliate[] = 'parent_aff_refid';
        if (count($affiliate) > 1) {
            QUnit_Messager::setErrorMessage(L_G_YOUCANSELECTONLYONEOFTHISFIELDS.
                L_G_TRANS_AFFILIATE_NAME." ".L_G_TRANS_AFFILIATE_USERID." ".L_G_TRANS_AFFILIATE_REFID);
        }
	}
	
	//--------------------------------------------------------------------------
    
    function insertRow($data) {
        $importData = array();
        $importData['accountid'] = $GLOBALS['Auth']->getAccountId();
        $importData['rtype'] = USERTYPE_USER;
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
	                       return L_G_INVALIDAFFILIATESTATUS;
	               }
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
	            case 'userid':
	               if (($id = $this->blAffiliate->getUserId('', $value, '')) !== false)
	                   return L_G_AFFILIATEID." ".L_G_ALREADYEXITS;
	               $importData['userid'] = $value;
	               break;            
	            case 'refid':
	               if (($id = $this->blAffiliate->getUserId('', '', $value)) !== false)
	                   return L_G_REFID." ".L_G_ALREADYEXITS;
	               $importData['refid'] = $value;
	               break;            
	            case 'username':
	               if (($id = $this->blAffiliate->getUserId($value, '', '')) !== false)
	                   return L_G_USERNAME." ".L_G_ALREADYEXITS;
	               $importData['username'] = $value;
	               break;            
	            case 'parent_aff_name':
	               break;
	            case 'parent_aff_userid':
	               break;
	            case 'parent_aff_refid':
	               break;
	            default:
	               if ($value == "NULL") $value = "";
	               $importData[$name] = $data[$name];
	               break;
	        }
	    }
	    
	    if ($importData['userid'] == '') $importData['userid'] = QCore_Sql_DBUnit::createUniqueID($this->table, 'userid');
	    if ($importData['rstatus'] == '') $importData['rstatus'] = AFFSTATUS_NOTAPPROVED;

        $sql = "INSERT INTO ".$this->table." ".
               "(".implode(",", array_keys($importData)).") ".
               "VALUES ('".implode("','", array_values($importData))."')";
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs) {
            return L_G_DBERROR;
        } else {
            $parent = "";
            if (in_array('parent_aff_name', array_keys($data))) {
                $parent = "1,".$data['parent_aff_name'];
            } elseif (in_array('parent_aff_userid', array_keys($data))) {
	            $parent = "2,".$data['parent_aff_userid'];
            } elseif (in_array('parent_aff_refid', array_keys($data))) {
	            $parent = "2,".$data['parent_aff_refid'];
            }
            @fputs($this->relationFile, $importData['userid'].",".$parent."\n");
            
            return L_G_OK;
        }
    }
    
    //--------------------------------------------------------------------------
    
    function afterImportFunc() {
        $settings = $GLOBALS['Auth']->getSettings();
        for ($i = 0; $i < count($this->columns); $i++) {
        	if ( ($settings['Acct_'.$this->id.'_import_field'.$i.'_type'] != '___') && ($settings['Acct_'.$this->id.'_import_field'.$i.'_type'] != '') ) {
        	    $this->selectedFields[] = $settings['Acct_'.$this->id.'_import_field'.$i.'_type'];	    
        	}
        }
        if ( !in_array('parent_aff_name', $this->selectedFields) && !in_array('parent_aff_userid', $this->selectedFields) && !in_array('parent_aff_refid', $this->selectedFields) ) {
             return true;
        }
        $this->assign('a_line', 0);
        Redirect_nomsg("index_popup.php?md=".$this->md."&filename=".$_GET['filename']."&action=afterimport&aistart=1");
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function importParentRelations() {
        if (($this->relationFile = @fopen($GLOBALS['Auth']->getSetting('Aff_export_dir').$_GET['filename']."_PARENT", "r")) === false) {
            $this->assign('a_line', -1);
            return true;
        }
        $maxTimeToRun = (ini_get('max_execution_time') == '') ? 20 : ini_get('max_execution_time') - 10;
        
        if ($_GET['aistart'] == '1') {
            $_SESSION['ai_errorLines'] = "";
            $_SESSION['ai_line'] = 0;
            $_SESSION['ai_offset'] = 0;
        }
        
        fseek($this->relationFile, $_SESSION['ai_offset']);
        $i = $_SESSION['ai_line'];
        
        while((!feof($this->relationFile)) && (($line = fgets($this->relationFile)) !== false)) {
            QUnit_Page::end_timer();
			if (QUnit_Page::getTimeGenerated() > $maxTimeToRun) {
				$_SESSION['ai_line'] = $i;
				$this->assign('a_line', $i);
				Redirect_nomsg("index_popup.php?md=".$this->md."&action=afterimport&filename=".$_GET['filename']);
				fclose($this->relationFile);
				return;
			}
			$_SESSION['ai_offset'] = ftell($this->relationFile);
            $i++;
            
            $line = explode(",", $line);
            for($j=0; $j<3; $j++)
                $line[$j] = trim(trim($line[$j]), "\"'"); 
            
            if (($id = $this->blAffiliate->getUserId('', $line[0], '')) === false) {
                $_SESSION['ai_errorLines'] .= ($_SESSION['ai_errorLines'] == '' ? '' : ', ').$line[0];
                continue;
            }
            
            if($line[2] == '') {
                $_SESSION['ai_errorLines'] .= ($_SESSION['ai_errorLines'] == '' ? '' : ', ').$line[0];
                continue;
            }

            switch ($line[1]) {
                case '1':
                    $parentId = $this->blAffiliate->getUserId($line[2], '', '');
                    break;
                case '2':
                    $parentId = $this->blAffiliate->getUserId('', $line[2], '');
                    break;
                case '3':
                    $parentId = $this->blAffiliate->getUserId('', '', $line[2]);
                    break;
            }

            if ($parentId === false) {
                $_SESSION['ai_errorLines'] .= ($_SESSION['ai_errorLines'] == '' ? '' : ', ').$line[0];
                continue;
            }
            
            $sql = "UPDATE ".$this->table." ".
                   "   SET parentuserid="._q($parentId).
                   " WHERE userid="._q($id);

            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs) {
                $_SESSION['ai_errorLines'] .= ($_SESSION['ai_errorLines'] == '' ? '' : ', ').$line[0];
            }
        }
        
        $this->assign('a_line', -1);
        
        fclose($this->relationFile);
    }

}  
?>
