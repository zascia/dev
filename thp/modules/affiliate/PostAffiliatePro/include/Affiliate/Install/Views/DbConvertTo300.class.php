<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_DbConvertTo300 extends QUnit_UI_TemplatePage
{
    var $model;
    
    //------------------------------------------------------------------------
    
    function Affiliate_Install_Views_DbConvertTo300() {
        $this->init();        
    }    
    
    //------------------------------------------------------------------------
    
    function init() {
        parent::init();        
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }
    
    //------------------------------------------------------------------------
    
    function getName() {
        return 'DbConvertTo300';
    }    
    
    //------------------------------------------------------------------------
    
    function getContent() {
        if($this->convert()) {
            $this->assign('check', 'ok');            
        } else {
            $this->assign('check', 'failed');                        
        }
        $this->assign('action', 'DbConvertTo300');
        return $this->fetch('db_convert');        
    }
    
    //------------------------------------------------------------------------
    
    function process() { 
        if(isset($_POST['check']) && $_POST['check'] == 'ok') {
            return true;
        }
        return false;    
    }  
    
    //------------------------------------------------------------------------
    
    function convert() {
        if(!$this->model->executeSqlFile('./sql/affiliate/update_pap_200_300_mysql.sql')) {
            QUnit_Messager::setErrorMessage(L_G_CONVERTFAILED);
            return false;
        }
        return true;
    }    
        
}
?>