<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('Affiliate_Install_Bl_Scenario');

class Affiliate_Install_Bl_ScenarioUpgrade200 extends Affiliate_Install_Bl_Scenario 
{
    
    var $steps = array();
    
    function Affiliate_Install_Bl_ScenarioUpgrade200() {
        $this->init(); 
    }    
    
    function init() {
        parent::init(); 
        $this->addStep('Start', L_G_START);
        $this->addStep('Authorization', L_G_AUTHORIZATION);        
        $this->addStep('SettingsCheckout', L_G_SETTINGSCHECKOUT);      
        $this->addStep('DbConvert200', L_G_DBCONVERT);
        $this->addStep('FinishConvert', L_G_FINISHCONVERT);
    }
            
}
?>