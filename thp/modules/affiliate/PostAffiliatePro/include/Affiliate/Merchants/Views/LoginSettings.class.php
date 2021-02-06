<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');

class Affiliate_Merchants_Views_LoginSettings extends Affiliate_Merchants_Views_Settings
{
    function Affiliate_Merchants_Views_LoginSettings() {
        // create all tabs
        $this->tabs['afflogin'] = QUnit_Global::newObj('Affiliate_Merchants_Views_TabAffLogin');
        $this->tabs['afflogin']->setAttributes('afflogin', "<a href=\"javascript:changeSheet('edit', 'afflogin');\">".L_G_AFFLOGINSETTINGS."</a>", 'settings_login');
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_TOPMENU_TOOLS,'index.php?md=Affiliate_Merchants_Views_Tools');
        $this->navigationAddURL(L_G_AFFLOGINSETTINGS,'index.php?md=Affiliate_Merchants_Views_LoginSettings');
    }
    
    //------------------------------------------------------------------------

    function showSettings($reload = false)
    {
        if($reload == true || $_POST['commited'] != 'yes')
        {
            // get settings from Auth
            $this->loadSettings();
        }

        $_REQUEST['sheet'] = 'afflogin';
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
        $this->addContent('loginsettings_main');

        return true;
    }
        
    //------------------------------------------------------------------------
}
?>
