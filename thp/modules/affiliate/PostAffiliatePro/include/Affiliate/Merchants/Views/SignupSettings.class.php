<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');

class Affiliate_Merchants_Views_SignupSettings extends Affiliate_Merchants_Views_Settings
{
    function Affiliate_Merchants_Views_SignupSettings() {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blPayoutOpts =& QUnit_Global::newObj('Affiliate_Merchants_Bl_PayoutOptions');
        
        // create all tabs
        $this->tabs['affsignup'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabAffSignup');
        $this->tabs['affsignup']->setAttributes('affsignup', "<a href=\"javascript:changeSheet('edit', 'affsignup');\">".L_G_AFFSIGNUPFORMAT."</a>", 'settings_affsignup');
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_TOPMENU_TOOLS,'index.php?md=Affiliate_Merchants_Views_Tools');
        $this->navigationAddURL(L_G_AFFSIGNUPSETTINGS,'index.php?md=Affiliate_Merchants_Views_SignupSettings');
    }
    
    //--------------------------------------------------------------------------
    
    function initPermissions()
    {
        $this->modulePermissions['edit'] = 'aff_tool_signupsettings_modify';
        $this->modulePermissions['view'] = 'aff_tool_signupsettings_view';
    }
    
    //------------------------------------------------------------------------

    function showSettings($reload = false)
    {
        if($reload == true || $_POST['commited'] != 'yes')
        {
            // get settings from Auth
            $this->loadSettings();
        }

        $_REQUEST['sheet'] = 'affsignup';
        $_REQUEST['action'] = 'edit';
        
        $p_tabs = array();
        foreach ($this->tabs as $tab)
        	$p_tabs[] = array($tab->name, $tab->link);
        
        $selectedTab = $_REQUEST['sheet'];
        
        $this->assign('a_tabs', $p_tabs);
        $this->assign('a_selectedTab', $selectedTab);
        
        $this->initTemporaryTE();
        
        $tabContent = $this->tabs[$_REQUEST['sheet']]->show($this);
        
        $this->assign('a_tabcontent', $tabContent);
        $this->addContent('signupsettings_main');

        return true;
    }
        
    //------------------------------------------------------------------------
}
?>
