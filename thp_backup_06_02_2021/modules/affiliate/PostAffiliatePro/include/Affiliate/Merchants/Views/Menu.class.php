<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_Menu');

class Affiliate_Merchants_Views_Menu extends QUnit_UI_Menu {

    function Affiliate_Merchants_Views_Menu() {
		parent::QUnit_UI_Menu();
        $finder =& QUnit_Global::newObj('QUnit_Io_PathFinder');
        $path = $finder->getTemplatePath('menu_left.txt');
	//print dirname($_SERVER['PHP_SELF']); ///svn/affiliate/trunk/merchants
	if (AFF_PROGRAM_TYPE != PROG_TYPE_PRO)
	{
		$pth = realpath('../') . '/merchants/templates/afflite/default/menu_left.txt';
		//$this->setMenuFile($this->getResourcesDir().'/menu_left.txt');
		$this->setMenuFile($pth);
	}
	else
		$this->setMenuFile($path.'/menu_left.txt');
        	
        $this->addMenuFromFile();
    }

    //--------------------------------------------------------------------------

    function show() {
        if($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') != '1')  {
            $this->hideMenuItem('transactions', 'rc');
        }
        if($GLOBALS['Auth']->getSetting('Aff_join_campaign') != 1) {
            $this->hideMenuItem('affiliates', 'applied');
        }

        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK) {
            $this->hideMenuItem('affiliates', 'view');
        } else {
            $this->hideMenuItem('affiliates', 'viewnetwork');
        }

        if($GLOBALS['Auth']->getSetting('Aff_force_aff_domains_approval') != 1) {
            $this->hideMenuItem('affiliates', 'domains');
        }

        if($GLOBALS['Auth']->getSetting('Glob_acct_geo_allowed') != '1') {
            $this->hideMenuItem('reports', 'geostats');
        }
        
        if(GLOBAL_DB_ENABLED == '1' && $GLOBALS['Auth']->getSetting('AffPlanet_account_type') == ACCOUNT_FREE) {
            $this->hideMenuItem('tools', 'login');
        }
		
        parent::show();
    }
}
?>
