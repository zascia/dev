<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_Tools extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['view'] = true;
        $this->modulePermissions['settings'] = 'aff_tool_settings_view';
        $this->modulePermissions['integration'] = 'aff_tool_integration_view';
        $this->modulePermissions['history'] = 'aff_tool_history_view';
        $this->modulePermissions['maintenance'] = 'aff_tool_db_maintenance_backup';
        $this->modulePermissions['tpleditor'] = 'aff_tool_template_modify';
        $this->modulePermissions['resources'] = 'aff_tool_resource_modify';
        $this->modulePermissions['affsignup'] = 'aff_tool_signupsettings_view';
        $this->modulePermissions['login'] = 'aff_tool_loginsettings_view';
        $this->modulePermissions['affpanel'] = 'aff_tool_affloginsettings_view';
        $this->modulePermissions['afflogin'] = 'aff_tool_affloginsettings_view';
        $this->modulePermissions['layout'] = 'aff_tool_afflayoutsettings_view';
        $this->modulePermissions['integwizard'] = 'aff_tool_integration_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
       $this->navigationAddURL(L_G_HOME,'index.php?md=home');
       $this->navigationAddURL(L_G_TOOLS,'index.php?md=Affiliate_Merchants_Views_Tools');
       
       $this->showListOfTools();
    }

    //------------------------------------------------------------------------

    function showListOfTools()
    {
        $reports = array();
		
		
		if ($this->checkPermissions('settings')) {
			$reports['settings'] =
				array('name' => L_G_SETTINGS,
					  'url'  => 'index.php?md=Affiliate_Merchants_Views_Settings',
					  'desc' => L_G_SETTINGS_DESCRIPTION_SHORT);
		}

		if ($this->checkPermissions('integwizard')) {
			$reports['integwizard'] =
				array('name' => L_G_INTEGRATIONWIZARD,
					  'url'  => 'index.php?md=Affiliate_Merchants_Views_IntegrationWizard',
					  'desc' => L_G_INTEGRATIONWIZARD_DESCRIPTION_SHORT);
		}
        
        if ($this->checkPermissions('history')) {
            $reports['history'] = 
                array('name' => L_G_HISTORY,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_History',
                      'desc' => L_G_HISTORY_DESCRIPTION_SHORT);
        }
    
/*        if ($this->checkPermissions('maintenance')) {
            $reports['maintenance'] = 
                array('name' => L_G_MAINTENANCE,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_Maintenance',
                      'desc' => L_G_MAINTENANCE_DESCRIPTION_SHORT);
        }
*/        
        if ($this->checkPermissions('affsignup')) {
            $reports['affsignup'] = 
                array('name' => L_G_AFFSIGNUPSETTINGS,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_SignupSettings',
                      'desc' => L_G_AFFSIGNUPSETTINGS_DESCRIPTION_SHORT);
        }
        
        if ($this->checkPermissions('login') && ($GLOBALS['Auth']->getSetting('AffPlanet_account_type') > ACCOUNT_FREE)) {
            $reports['login'] = 
                array('name' => L_G_AFFLOGINSETTINGS,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_LoginSettings',
                      'desc' => L_G_AFFLOGINSETTINGS_DESCRIPTION_SHORT);
        }
    
        if ($this->checkPermissions('affpanel')) {
            $reports['affpanel'] = 
                array('name' => L_G_PANELSETTINGS,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_AffPanelSettings',
                      'desc' => L_G_AFFPANELSETTINGS_DESCRIPTION_SHORT);
        }

        if ($this->checkPermissions('layout')) {
            $reports['layout'] =
                array('name' => L_G_LAYOUTSETTINGS,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_LayoutSettings',
                      'desc' => L_G_LAYOUTSETTINGS_DESCRIPTION_SHORT);
        }
        
        if ($this->checkPermissions('integwizard')) {
            $reports['integwizard'] =
                array('name' => L_G_INTEGRATIONWIZARD,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_IntegrationWizard',
                      'desc' => L_G_INTEGRATIONWIZARD_DESCRIPTION_SHORT);
        }
        
        $this->assign('a_reports', $reports);
        $this->assign('a_main_description', L_G_TOOLS_DESCRIPTION);
        
        $this->addContent('rep_list');
    }
    
}
?>
