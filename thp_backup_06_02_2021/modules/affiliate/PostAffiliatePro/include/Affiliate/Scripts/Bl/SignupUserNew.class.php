<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Scripts_Bl_Signup');

define('WD_PATTERN_DEFAULT', '/[^\'\"]*/');

class Affiliate_Scripts_Bl_SignupUserNew extends Affiliate_Scripts_Bl_Signup
{   
    function Affiliate_Scripts_Bl_SignupUserNew() {
        $this->user = QUnit_Global::newObj('Affiliate_Scripts_Bl_Affiliate');
        $this->blForcedMatrix =& QUnit_Global::newObj('Affiliate_Merchants_Bl_ForcedMatrix');        
        $this->blUsers =& QUnit_Global::newObj('QCore_Bl_Users');
        parent::Affiliate_Scripts_Bl_Signup();
    }
    
    //--------------------------------------------------------------------------

    function getErrorMessage() {
        return QUnit_Messager::getErrorMessage();
    }
    
    //--------------------------------------------------------------------------

    function addErrorMessage($msg) {
        QUnit_Messager::setErrorMessage($msg);
    }
    
    //--------------------------------------------------------------------------

    function checkForm() {
        $correct = true;        
        if($this->blUsers->checkUserExists('', $_POST['username']) === true) {
            $this->addErrorMessage(L_G_UNAMEEXISTS);
            $correct = false;
        }
        
        if($_POST['refid'] != preg_replace('/[^A-Za-z0-9\-\_]/', '', $_POST['refid'])) {
        	$this->addErrorMessage(L_G_REFERERID.' '.L_G_UNALLOWED);
        	$correct = false;
        }
        
        if(($_POST['refid'] != '') && ($this->checkRefidUnique($_POST['refid']) === false)) {
            $this->addErrorMessage(L_G_REFIDEXISTS);
            $correct = false;
        }
        
        if(($_POST['add_campaign_id'] != '') && ($this->checkCampaignId($_POST['add_campaign_id']) === false)) {
            $this->addErrorMessage(L_G_SELECTEDCAMPAIGNDOESNOTEXIST);
            $correct = false;
        }
        
        if($this->settings['Aff_signup_force_acceptance'] == "1") {
            if(!isset($_POST['tos']) || $_POST['tos'] !== "1") {
                $this->addErrorMessage(L_G_TOSAGREE); 
                $correct = false;
            }
        }

        if($this->user->check() == false) {
            $correct = false;
        }

        if($_POST['parentuserid'] != '' && $this->checkParentUser($_POST['parentuserid']) === false) {
            $this->addErrorMessage(L_G_PARENTAFFDOESNTEXISTS);
            $correct = false;
        }
                
//        if(!in_array($pcountry, $GLOBALS['countries'])) {
//            $this->addErrorMessage(L_G_COUNTRYNOTINLIST);
//            $correct = false;
//        }
        
        return $correct;
    }
        
    //--------------------------------------------------------------------------
    function loadSettings($accountId) {
        $this->settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $accountId);
        $this->settings = array_merge($this->settings, QCore_Settings::getGlobalSettings());        
        //$default_lang = ($this->settings['Aff_default_lang'] != '' ? $this->settings['Aff_default_lang'] : $this->settings['Glob_default_lang']);        
    }

    //--------------------------------------------------------------------------    
    
    function setMandatoryFields() {
        $columns = $this->user->getColumns();
        foreach($columns as $key => $val) {
            if($this->settings['Aff_signup_'.$key.'_mandatory'] === "true") {
                $this->user->setNeeded($key, true);
            } else {
               $this->user->setNeeded($key, false); 
            }
        }        
    }
    
    //--------------------------------------------------------------------------

    function getStatus() {
        $approval = $this->settings['Aff_affiliateapproval'];        
        if($approval == APPROVE_AUTOMATIC) {
            $status = AFFSTATUS_APPROVED;
            $this->user->setColumn('dateapproved', strftime('%y-%m-%d %H:%M:%S', time()));
        } else if($approval == APPROVE_MANUAL) {
            $status = AFFSTATUS_NOTAPPROVED;
        } else {
            $status = AFFSTATUS_NOTAPPROVED;
        }
        return $status;        
    }
    
    //--------------------------------------------------------------------------

    function getParentUserId($userId) {
        $parentuserid =  $this->getParentUser();
        $this->user->setColumn('originalparentid', $parentuserid);
        
        if($parentuserid == '' && $this->settings['Aff_nonreferred_signup'] != '' && $this->settings['Aff_nonreferred_signup'] != '_') {
            $parentuserid = $this->settings['Aff_nonreferred_signup'];
        }
        
        if($this->settings['Aff_matrix_width'] > 0 && $this->settings['Aff_matrix_height'] > 0 
                && $this->settings['Aff_use_forced_matrix'] == '1') {
            if( ($temp_parentuserid = $this->blForcedMatrix->useForcedMatrix($userID, 
                $parentuserid, $this->settings)) != false)
                $parentuserid = $temp_parentuserid;
        }
        return $parentuserid;
    }
    
    function setDataFieldsCaption() {
        for($i=1;$i<=5;$i++) {
            $this->user->setCaption("data$i", $this->settings["Aff_signup_data{$i}_name"]);
        }
    }
    
    function fill() {
        $this->user->fillColumnsFromArray($_POST);
        $this->user->setColumn('rtype', USERTYPE_USER);
        $this->user->setColumn('dateinserted', strftime('%y-%m-%d %H:%M:%S', time()));
        $this->user->setColumn('deleted', '0');
        $this->user->setColumn('product', PRODUCT_AFFILIATE);
        
        $aid = $this->getAccountId();
        $this->user->setColumn('accountid', $aid);
        
        $this->loadSettings($aid);
                
        $this->setMandatoryFields();
        $this->setDataFieldsCaption();
        
        $pwd = substr(uniqid(rand(),1), 0, 5);
        $this->user->setColumn('rpassword', $pwd);
        $userId = QCore_Sql_DBUnit::createUniqueID('wd_g_users', 'userid');
        $this->user->setColumn('userid', $userId);
        
        if($this->user->getColumn('refid') == '') $this->user->setColumn('refid', $userId);
        
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
        
        if($this->save() == false) {
            return false;
        }

        $this->addUserToCampaign($this->user->getColumn('userid'), $_POST['add_campaign_id'], $_POST['add_campaign_category_id']);

        $this->addProgramSignupBonus($this->user->getColumn('userid'), $this->user->getColumn('accountid'), $this->user->getColumn('rstatus'), $this->user->getColumn('parentuserid'));
        
        $this->saveSettings();
        $this->sendMail();
        $this->signupToNewsletter();
           
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function save() {
        return $this->user->insertUser();
    }
    
    //--------------------------------------------------------------------------
    
    function saveSettings() {
        QCore_Settings::_update('Aff_min_payout', $_POST['minpayout'], SETTINGTYPE_USER, $this->user->getColumn('accountid'), $this->user->getColumn('userid'));
        QCore_Settings::_update('Aff_user_ip', $_SERVER['REMOTE_ADDR'], SETTINGTYPE_USER, $this->user->getColumn('accountid'), $this->user->getColumn('userid'));           
    }
    
    //--------------------------------------------------------------------------
    
    function sendMail() {
        $this->sendMailToMerchant($this->user->getColumn('userid'), $this->user->getColumn('accountid'));
        
        if(!$this->sendMailToUser($this->user->getColumn('userid'), $this->user->getColumn('accountid'), $this->user->getColumn('username'), $this->user->getColumn('rpassword'), $this->user->getColumn('rstatus') == AFFSTATUS_APPROVED)) {
            return false;
        }
        
        if($this->sendMailToParentUser($this->user->getColumn('userid'), $this->user->getColumn('parentuserid'), $this->user->getColumn('accountid'))) {
            return false;
        }
            
        return true;
    }  

    //--------------------------------------------------------------------------
    
    function signupToNewsletter() {
        if ($this->settings['Aff_newsletter_signup_enabled'] != '1')
            return false;
         
        $emaildata = $this->blEmailTemplates->getFilledEmailMessage($this->user->getColumn('userid'), $this->accountid, 'AFF_EMAIL_AFF_NL_SGN', '', '');
        if ($emaildata == false) {
            $emaildata = array('subject' => '', 'email' => '');
        }
        
        $params = array('email' => $this->settings['Aff_newsletter_signup_email'],
                        'text' => $emaildata['email'],
                        'subject' => $emaildata['subject'],
                        'settings' => $this->settings,
                        'returnpath' => $this->user->getColumn('username'),
                        'returnpath_name' => $this->user->getColumn('name').' '.$this->user->getColumn('surname'));
                        
        $params['settings']['Aff_system_email_name'] = $this->user->getColumn('name').' '.$this->user->getColumn('surname');
        $params['settings']['Aff_system_email'] = $this->user->getColumn('username');
        
        return $this->blCommunications->sendEmailDirect($params);
    }
}
?>
