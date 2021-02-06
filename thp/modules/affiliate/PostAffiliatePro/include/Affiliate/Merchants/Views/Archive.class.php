<?php
//============================================================================
// Copyright (c) webradev.com 2006
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Archive');

class Affiliate_Merchants_Views_Archive extends QUnit_UI_TemplatePage
{
    function Affiliate_Merchants_Views_Archive() {
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_TOOLS,'index.php?md=Affiliate_Merchants_Views_Tools');
        $this->navigationAddURL(L_G_MAINTENANCE,'index.php?md=Affiliate_Merchants_Views_Maintenance');
		$this->navigationAddURL(L_G_ARCHIVE, 'index.php?md=Affiliate_Merchants_Views_Archive');
    }
    
    //--------------------------------------------------------------------------

    function initPermissions()
    {
        
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
		if(!empty($_REQUEST['action'])) //!empty($_POST['commited'])
        {
            switch($_REQUEST['action'])
            {
                case 'archiveimps':
                    if($this->startArchiveImps())
                        return;
                    break;
                
                case 'archivetrans':
                    if($this->startArchiveTrans())
                        return;
                    break;
                
                case 'processarchive':
                    if($this->processArchive())
                        return;
                    break;
            }
        }
        
        $this->show();    
    }
    
    //------------------------------------------------------------------------

    function show()
    {
        if(AFF_DEMO == 1)
            QUnit_Messager::setErrorMessage(L_G_DISABLED_IN_DEMO);
        
        if($_REQUEST['art_aggregation'] == '') $_REQUEST['art_aggregation'] = AGGREGATION_DAY;
        
    	$this->assign('a_form_preffix', 'ar_');
    	$this->assign('a_form_name', 'ArchiveForm');
    	$this->addContent('archive');
    }
    
    //------------------------------------------------------------------------
    
    function startArchiveImps() {
    	if(AFF_DEMO == 1) return;
        
    	// process time filter
        if($_REQUEST['ar_timeselect'] == TIME_PRESET) {
             $_REQUEST = array_merge($_REQUEST, getTimeForPreset($_REQUEST['ar_timepreset'], 'ar_'));
        }
        
        $params = array('archive_date' => array('year'  => $_REQUEST['ar_year1'],
                                                'month' => $_REQUEST['ar_month1'],
                                                'day'   => $_REQUEST['ar_day1']),
    					'accountid'    => $GLOBALS['Auth']->getAccountID(),
    					'aggregation'  => AGGREGATION_DAY,
    					'table'        => 'wd_pa_impressions');
    	
    	$blArchive = QUnit_Global::newObj('Affiliate_Merchants_Bl_Archive');
    	if ($blArchive->initArchive($params)) {
    		$this->assign('a_start_archive', true);	
    	}
    }
    
    //------------------------------------------------------------------------
    
    function startArchiveTrans() {
    	if(AFF_DEMO == 1) return;
    	
    	// process time filter
        if($_REQUEST['art_timeselect'] == TIME_PRESET) {
             $_REQUEST = array_merge($_REQUEST, getTimeForPreset($_REQUEST['art_timepreset'], 'art_'));
        }
        
        $params = array('archive_date' => array('year'  => $_REQUEST['art_year1'],
                                                'month' => $_REQUEST['art_month1'],
                                                'day'   => $_REQUEST['art_day1']),
                        'aggregation'  => $_REQUEST['art_aggregation'],
    					'accountid'    => $GLOBALS['Auth']->getAccountID(),
    					'table'        => 'wd_pa_transactions');
    					
    	$blArchive = QUnit_Global::newObj('Affiliate_Merchants_Bl_Archive');
    	if ($blArchive->initArchive($params)) {
    		$this->assign('a_start_archive', true);	
    	}
    }
    
    //------------------------------------------------------------------------
    
    function processArchive() {
        if(AFF_DEMO == 1) return;
        
    	$blArchive = unserialize($_SESSION[SESSION_PREFIX.'archiveObject']);
    	
    	if($_REQUEST['start'] == 'yes') {
    	   $blArchive->startNextStep();
    	   $_SESSION[SESSION_PREFIX.'archiveObject'] = serialize($blArchive);
    	}
    	   
    	$maxTimeToRun = (ini_get('max_execution_time') == '') ? 30 : ini_get('max_execution_time');
    	$progress = $blArchive->getProgress();   
    	
    	if ($progress >= 2 && $progress <= 5) 
    	   Redirect_nomsg("index_popup.php?md=Affiliate_Merchants_Views_Archive&action=processarchive", $maxTimeToRun);
    	
    	$this->assign('a_progress', $progress);
    	   
    	if ($progress == 1) {
        	$archiveResult = $blArchive->archive();
        	$this->assign('a_archiveResult', $archiveResult);
        	$this->addContent('archive_progress');
    	} else {
    	    $this->addContent('archive_progress');
    	    $archiveResult = $blArchive->archive();
    	}
    	
    	return true;
    }
    


}
?>
