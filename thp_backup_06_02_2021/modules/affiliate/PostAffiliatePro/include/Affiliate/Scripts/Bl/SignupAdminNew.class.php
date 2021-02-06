<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Scripts_Bl_SignupUserNew');

class Affiliate_Scripts_Bl_SignupAdminNew extends Affiliate_Scripts_Bl_SignupUserNew
{

    function Affiliate_Scripts_Bl_SignupUserNew() {
        $this->user = QUnit_Global::newObj('Affiliate_Scripts_Bl_Affiliate');
    }
    
        

    function fill() {
        $this->user->fillColumnsFromArray($_POST);
        $this->user->setColumn('originalparentid', $_POST['parentuserid']);
        $this->user->setColumn('rtype', USERTYPE_USER);
        $this->user->setColumn('dateinserted', strftime('%y-%m-%d %H:%M:%S', time()));
        $this->user->setColumn('deleted', '0');
        $this->user->setColumn('product', PRODUCT_AFFILIATE);
        $this->user->setColumn('userprofileid', $REQUEST['upid']);
        
        $aid = $this->getAccountId();
        $this->user->setColumn('accountid', $aid);
        
        $this->loadSettings($aid);
                
        $this->setMandatoryFields();
        $this->setDataFieldsCaption();
        
        $pwd = substr(uniqid(rand(),1), 0, 5);
        $this->user->setColumn('rpassword', $pwd);
        $userId = QCore_Sql_DBUnit::createUniqueID('wd_g_users', 'userid');
        $this->user->setColumn('userid', $userId);
        $this->user->setColumn('refid', $userId);
        
        $initial_min_payout = $this->settings['Aff_initial_min_payout'];
        
        $status = $this->getStatus();
        $this->user->setColumn('rstatus', $status);
        
        $parentuserid = $this->getParentUserId($userId);                
        $this->user->setColumn('parentuserid', $parentuserid);         
    }
        
    //--------------------------------------------------------------------------
    
    function processSignup()
    {        
        $this->fill();
        
        if($this->checkForm() == false) {
            return false;
        }
        if($this-save() == false) {
            return false;
        }

        $this->addProgramSignupBonus($this->user->getColumn('userid'), $this->user->getColumn('accountid'), $this->user->getColumn('rstatus'), $this->user->getColumn('parentuserid'));
        
        $this->saveSettings();
        if($this->sendMail() == false) {
            return false;
        }
             
        return true;
    }
    
    function save() {
        return $this->user->insertUser();
    }
    
    function saveSettings() {
        QCore_Settings::_update('Aff_min_payout', $_POST['minpayout'], SETTINGTYPE_USER, $this->user->getColumn('accountid'), $this->user->getColumn('userid'));
        QCore_Settings::_update('Aff_user_ip', $_SERVER['REMOTE_ADDR'], SETTINGTYPE_USER, $this->user->getColumn('accountid'), $this->user->getColumn('userid'));           
    }
    
    function sendMail() {
        if($this->user->getColumn('rstatus') == AFFSTATUS_APPROVED)
        {
            if(!$this->sendMailToUser($this->user->getColumn('userid'), $this->user->getColumn('accountid'), $this->user->getColumn('username'), $this->user->getColumn('rpassword'))) {
                return false;
            }
        }
        
        if(!$this->sendMailToMerchant($this->user->getColumn('userid'), $this->user->getColumn('accountid'))) {
            return false;
        }        
        if($this->sendMailToParentUser($this->user->getColumn('parentuserid'), $this->user->getColumn('accountid'))) {
            return false;
        }    
        return true;
    }    
}
?>
