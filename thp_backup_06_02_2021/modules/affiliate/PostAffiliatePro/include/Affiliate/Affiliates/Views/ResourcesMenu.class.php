<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_Menu');

class Affiliate_Affiliates_Views_ResourcesMenu extends QUnit_UI_Menu {

	//--------------------------------------------------------------------------
	
	function Affiliate_Affiliates_Views_ResourcesMenu() {
        parent::QUnit_UI_Menu();
        $finder =& QUnit_Global::newObj('QUnit_Io_PathFinder');
        $path = $finder->getTemplatePath('menu_left.txt');
        //$this->setMenuFile($path.'/menu_left.txt');
        //$this->addMenuFromFile();
        $this->setMenuFile($this->getResourcesDir().'/menu_left.txt');
        $this->addMenuFromFile();
    }
    
    //--------------------------------------------------------------------------

    function show()
    {
        if(!($GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels') > 1)) {
            $this->hideMenuItem('campaigns', 'subaff');
            $this->hideMenuItem('reports', 'subaff');
        }
        if($GLOBALS['Auth']->getSetting('Aff_display_resources') != 1) {
            $this->hideMenuItem('resources', 'resources');
        }
        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK) {
            $this->hideMenuItem('campaigns', 'campaigns');
        }
        else {
            $this->hideMenuItem('campaigns', 'campaignsnetwork');
            $this->hideMenuItem('campaigns', 'browser');
        }
        
        if($GLOBALS['Auth']->getSetting('Aff_force_aff_domains_approval') != 1) {
            $this->hideMenuItem('tools', 'domains');
        }

        parent::show();
    }
    
    //--------------------------------------------------------------------------
    function getResourcesDir() {
        if (AFF_PROGRAM_TYPE == PROG_TYPE_PRO) {
        	return $GLOBALS['PROJECT_ROOT_PATH'].'/affiliates/'.ltrim($GLOBALS['Auth']->getSetting('Aff_resources_dir'), '/').'/'.$_SESSION[SESSION_PREFIX.'lang'];
    	} else {
    		return $GLOBALS['PROJECT_ROOT_PATH'].'/'.$this->getAccountDir().'/resources/'.$_SESSION[SESSION_PREFIX.'lang'];
    	}
    }
    
    
}
?>
