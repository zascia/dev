<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_Menu');

class Affiliate_Affiliates_Views_Menu extends QUnit_UI_Menu {

    function Affiliate_Affiliates_Views_Menu() {
        parent::QUnit_UI_Menu();
        $finder =& QUnit_Global::newObj('QUnit_Io_PathFinder');
        $path = $finder->getTemplatePath('menu_left.txt');
        if ($GLOBALS['resourcesLeftMenu'] == true && $GLOBALS['default_template'] == "default") {
            foreach ($GLOBALS['leftMenuResources'] as $header => $submenu) {
                $this->createMenuHeader('header_'.$header, '');
                foreach ($submenu as $itemID => $item) {
                    if($item[0] == 'header') {
                        $this->menu['header_'.$header]['caption'] = $item[1];
                    } else {
                        $this->createMenuItem('item_'.$header.'_'.$itemID, '', $item[1], '');
                    }
                }

            }
        } else {
        	$this->setMenuFile($path.'/menu_left.txt');
        	$this->addMenuFromFile();
        }
    }

    //--------------------------------------------------------------------------

    function addMenuRow($row, $classLink = '') {
        $parts = explode('|', $row);
        $type = array_shift($parts);
        switch($type) {
            case 'header':
                if(count($parts) <= 2) {
                    // old header menu style
                    list($name, $caption, $permission) = $parts;
                    $this->createMenuHeader($name, $caption);
                } else {
                    // old header menu style
                    list($name, $link, $caption, $permission, $image) = $parts;
                    if ($classLink != '') {
                        $link = 'index_res.php?md='.$classLink.'&p='.$link;
                    }

                    $this->createMenuHeaderNewStyle($name, $link, $caption, $permission, $image);
                }
                break;
            case 'item':
                list($name, $link, $caption, $permission) = $parts;
                if ($classLink != '') {
                	$link = 'index_res.php?md='.$classLink.'&p='.$link;
                }
                $settings =& $GLOBALS['Auth']->getSettings();
                if ($settings['Aff_menu_item_'.$name.'_show'] != 'false') {
                    $this->createMenuItem($name, $link, $caption, $permission);
                }

                break;
        }
    }

    //--------------------------------------------------------------------------

    function show()
    {
    	if( ($GLOBALS['Auth']->getSetting('Glob_acct_phpbb_installed') != 1) || ($GLOBALS['Auth']->getSetting('Aff_display_forum') != 1) ) {
    		$this->hideMenuItem('resources', 'forum');
    	}
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

        //hide sections according to settings
    	if($GLOBALS['Auth']->getSetting('Aff_menu_item_affprofile_show') != 'true') {
    		$this->hideMenuItem('begin', 'profile');
    	}
    	if($GLOBALS['Auth']->getSetting('Aff_menu_item_banners_show') != 'true') {
    		$this->hideMenuItem('campaigns', 'banners');
    	}
    	if($GLOBALS['Auth']->getSetting('Aff_menu_item_subaffsignup_show') != 'true') {
    		$this->hideMenuItem('campaigns', 'subaffsignup');
    	}
    	if($GLOBALS['Auth']->getSetting('Aff_menu_item_quick_show') != 'true') {
    		$this->hideMenuItem('reports', 'quick');
    	}
    	if($GLOBALS['Auth']->getSetting('Aff_menu_item_show') != 'true') {
    		$this->hideMenuItem('reports', 'trans');
    	}
    	if($GLOBALS['Auth']->getSetting('Aff_menu_item_traffic_show') != 'true') {
    		$this->hideMenuItem('reports', 'traffic');
    	}
    	if( ($GLOBALS['Auth']->getSetting('Aff_menu_item_subaffiliates_show') != 'true') ||
    	    ($GLOBALS['Auth']->hasSubaffiliates() == false)) {
    		$this->hideMenuItem('reports', 'subaff');
    	}
    	if($GLOBALS['Auth']->getSetting('Aff_menu_item_subid_show') != 'true') {
    		$this->hideMenuItem('reports', 'subid');
    	}
    	if($GLOBALS['Auth']->getSetting('Aff_menu_item_afftopurls_show') != 'true') {
    		$this->hideMenuItem('reports', 'topurls');
    	}
    	if($GLOBALS['Auth']->getSetting('Aff_menu_item_settings_show') != 'true') {
    		$this->hideMenuItem('tools', 'notif');
    	}
    	if($GLOBALS['Auth']->getSetting('Aff_menu_item_contactus_show') != 'true') {
    		$this->hideMenuItem('tools', 'contactus');
    	}
    	if($GLOBALS['Auth']->getSetting('Aff_menu_item_faq_show') != 'true') {
    		$this->hideMenuItem('tools', 'faq');
    	}

    	if($GLOBALS['Auth']->getSetting('Aff_display_resources') != '1') {
    	   $this->hideMenuItem('resources', 'res');
    	}
    	
        if($GLOBALS['Auth']->getSetting('Aff_default_campaign') == '_') {
    	   $this->hideMenuItem('banners', 'dynlink');
    	}

        parent::show();
    }

    //--------------------------------------------------------------------------

    function getAccountDir() {
        $settings = QCore_Settings::getGlobalSettings();
        if(!isset($settings['Glob_accounts_dir']) || $settings['Glob_accounts_dir'] == '') {
            QUnit_Messager::setErrorMessage(L_G_ACCOUNTSDIRNOTCONFIGURED);
            return false;
        }
        return $settings['Glob_accounts_dir'].'/'.$GLOBALS['Auth']->getAccountID();
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
