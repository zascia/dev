<?php
//============================================================================
// Copyright (c) Ladislav Tamas, qualityunit.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================


class Affiliate_Scripts_Bl_Signup
{
    var $settings = array();
    var $accountid = '';
    var $blRules;
    var $blEmailTemplates;
    var $blCommunications;
    var $blRegistrator;
    
    function Affiliate_Scripts_Bl_Signup() {
        $this->blRules =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Rules');
        $this->blEmailTemplates =& QUnit_Global::newObj('QCore_EmailTemplates');
        $this->blCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');
        $this->blRegistrator =& QUnit_Global::newObj('Affiliate_Scripts_Bl_Registrator');        
    }
    
    //--------------------------------------------------------------------------
    
    function checkCookie()
    {
        if(isset($_COOKIE[COOKIE_NAME]) && $_COOKIE[COOKIE_NAME] != '')
            $cookieval = $_COOKIE[COOKIE_NAME];
        else
            return false;
        
        $arr = split ( '_', $cookieval);
        
        if(!is_array($arr))
        {
            QCore_History::DebugMsg(WLOG_ERROR, 'Signup user: cookie value is not array', __FILE__, __LINE__);
            return false; 
        }
        
        if(count($arr) != 2)
        {
            QCore_History::DebugMsg(WLOG_ERROR, 'Signup user: cookie value has not 2 elements', __FILE__, __LINE__);
            return false; 
        }
        
        if(!is_numeric($arr[0]) || !is_numeric($arr[1]))
        {
            QCore_History::DebugMsg(WLOG_ERROR, 'Signup user: cookie value is not numeric', __FILE__, __LINE__);
            return false; 
        }
        
        $userID = $arr[0];
        
        //------------------------------------------------------------------------
        // check user and campaign
        if(!QCore_Bl_Users::checkUserExists($userID))
        {
            QCore_History::DebugMsg(WLOG_ERROR, 'Signup user: User with ID '.$userID.' doesn\'t exist', __FILE__, __LINE__);
            return false;
        }
        
        return $userID;
    }
    
    //--------------------------------------------------------------------------
    
    function setLanguageFile($default_lang)
    {
        if($_POST['l'] != '')
        {
            if(file_exists($GLOBALS['RootPath'].LANG_PATH.$_POST['l'].'.php'))
            {
                $_SESSION[SESSION_PREFIX.'lang'] = $_POST['l'];
                include_once($GLOBALS['RootPath'].LANG_PATH.$_SESSION[SESSION_PREFIX.'lang'].'.php');
            }
        }
        if(empty($_SESSION[SESSION_PREFIX.'lang']) && $_POST['l'] != '')
            $_SESSION[SESSION_PREFIX.'lang'] = $default_lang;
        
        if(file_exists($GLOBALS['RootPath'].LANG_PATH.$_SESSION[SESSION_PREFIX.'lang'].'.php'))  
            include_once($GLOBALS['RootPath'].LANG_PATH.$_SESSION[SESSION_PREFIX.'lang'].'.php');
        else
        {
            $_SESSION[SESSION_PREFIX.'lang'] = $default_lang;

            if(file_exists($GLOBALS['RootPath'].LANG_PATH.$_SESSION[SESSION_PREFIX.'lang'].'.php'))  
                include_once($GLOBALS['RootPath'].LANG_PATH.$_SESSION[SESSION_PREFIX.'lang'].'.php');
            else
            {
                QUnit_Messager::setErrorMessage('LANGUAGE FILE '.$GLOBALS['RootPath'].LANG_PATH.$_SESSION[SESSION_PREFIX.'lang'].'.php NOT FOUND!');
                QCore_History::DebugMsg(WLOG_ERROR, 'Signup user: LANGUAGE FILE '.$GLOBALS['RootPath'].LANG_PATH.$_SESSION[SESSION_PREFIX.'lang'].'.php NOT FOUND!', __FILE__, __LINE__);
                return false;
            }
        }
        
        return true;
    }

    //--------------------------------------------------------------------------

    function checkParentUser($pid, $userid = '')
    {
        if($pid != '')
        {
            $sql = "select userid from wd_g_users where refid="._q($pid)." and rtype = ".USERTYPE_USER." and deleted=0";
            if ($userid != '') $sql .= " and userid<>"._q($userid);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            if(!$rs->EOF) {
              return $rs->fields['userid'];
            }
            else
            {
                $sql = "select userid from wd_g_users where userid="._q($pid)." and rtype = ".USERTYPE_USER." and deleted=0";
                if ($userid != '') $sql .= " and userid<>"._q($userid);
                $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                if(!$rs)
                {
                    QUnit_Messager::setErrorMessage(L_G_DBERROR);
                    return false;
                }
                if(!$rs->EOF) {
                  return $rs->fields['userid'];
                }
            }
        }
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function getParentUser()
    {
        if($_POST['parentuserid'] != '')
            $pparentuserid = $this->checkParentUser($_POST['parentuserid']);

        if(($pparentuserid == '' || $pparentuserid === false) && $_POST['pid'] != '')
            $pparentuserid = $this->checkParentUser($_POST['pid']);

        if($pparentuserid == '' || $pparentuserid === false)
            $pparentuserid = $this->checkCookie();

        if($pparentuserid === false) $pparentuserid = '';

/*
        // if empty, set parent user by ID
        if($_POST['parentuserid'] == '')
        {
            $pparentuserid = $this->checkParentUser($_POST['pid']);
            if($pparentuserid === false)
                $pparentuserid = '';
        }
        else
            $pparentuserid = $_POST['parentuserid'];
        
        // if stillempty, set parent user according to clicked cookie
        if($pparentuserid == '') 
            $pparentuserid = $this->checkCookie();
        
        if(!$pparentuserid) $pparentuserid = '';
*/
        return $pparentuserid;
    }

    //--------------------------------------------------------------------------
    
    function redirect($url)
    {
        Redirect_nomsg($url);
        exit;
    }
    
    //--------------------------------------------------------------------------

    function addProgramSignupBonus($userID, $accountId, $status, $parentuserid)
    {
        $TransID = null;
        $ip = $_SERVER['REMOTE_ADDR'];
        $remoteAddr = $_SERVER['HTTP_REFERER'];
        
        if($this->settings['Aff_program_signup_bonus'] != '' && $this->settings['Aff_program_signup_bonus'] > 0)
        {
            $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
            $sql = 'insert into wd_pa_transactions (transid, accountid, rstatus,'.
                   'dateinserted, transtype, payoutstatus, transkind,'.
                   'refererurl, affiliateid, commission, ip)'.
                   ' values ('._q($TransID).','._q($accountId).','._q($status).
                   ','.sqlNow().','._q(TRANSTYPE_SIGNUP).','._q('1').
                   ','._q(TRANSKIND_NORMAL).','._q($remoteAddr).','._q($userID).
                   ','._q($this->settings['Aff_program_signup_bonus']).','._q($ip).')';
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$ret) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            
            if($status == AFFSTATUS_APPROVED)
            {
                $params = array('users' => array($userID),
                                'AccountID' => $accountId,
                                'cond_when' => RULE_AMOUNT_OF_COMMISSIONS,
                                'decimal_places' => $this->settings['Aff_round_numbers']
                               );

                if(($rules = $this->blRules->getRulesAsArray($params)) !== false)
                    $this->blRules->checkPerformanceRules($params, $rules);
            }
        }

        if($parentuserid != '' && $parentuserid != false && $this->settings['Aff_support_referral_commissions'] == '1')
        {
            if($this->settings['Aff_program_referral_commission'] != '' && $this->settings['Aff_program_referral_commission'] > 0)
            {
                $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
                $sql = 'insert into wd_pa_transactions (transid, accountid, rstatus,'.
                       'dateinserted, transtype, payoutstatus, transkind,'.
                       'refererurl, affiliateid, commission, ip, orderid)'.
                       ' values ('._q($TransID).','._q($accountId).','._q($status).
                       ','.sqlNow().','._q(TRANSTYPE_REFERRAL).','._q('1').
                       ','._q(TRANSKIND_NORMAL).','._q($remoteAddr).','._q($parentuserid).
                       ','._q($this->settings['Aff_program_referral_commission']).','._q($ip).','._q($userID).')';
                $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                if(!$ret) {
                    QUnit_Messager::setErrorMessage(L_G_DBERROR);
                    return false;
                }
            }

            if($status == AFFSTATUS_APPROVED)
            {
                $params = array('users' => array($parentuserid),
                                'AccountID' => $accountId,
                                'cond_when' => RULE_AMOUNT_OF_COMMISSIONS,
                                'decimal_places' => $this->settings['Aff_round_numbers']
                               );

                if(($rules = $this->blRules->getRulesAsArray($params)) !== false)
                    $this->blRules->checkPerformanceRules($params, $rules);
            }

            $this->setMultiTierSignupGlobals();

            if($this->maxCommissionLevels > 1)
                $this->registerMultiTierSignupCommission($accountId, $TransID, $remoteAddr, $ip, $status, $parentuserid, 2);
        }
        
        return true;        
    }
    
    //--------------------------------------------------------------------------
    
    function setMultiTierSignupGlobals()
    {
        $this->maxCommissionLevels = $this->settings['Aff_maxcommissionlevels'];
        if($this->maxCommissionLevels == '')
            $this->maxCommissionLevels = 1;

        for($i=2; $i<=$this->maxCommissionLevels; $i++) {
            $this->STUserBonusCommission[$i] = $this->settings['Aff_program_signup_bonus_'.$i.'tr'];
        }
    }
    
    //--------------------------------------------------------------------------
    
    function registerMultiTierSignupCommission($accountId, $parentTransID, $remoteAddr, $ip, $status, $parentUserID, $tier, $maxRecursion = 50)
    {
        if($maxRecursion <= 0) return true;
        if($tier > $this->maxCommissionLevels) return true;

        //----------------------------------------
        // get parent user for this child
        $params = array('parentUserID' => $parentUserID, 'status' => $status);
        
        if(($params = $this->blRegistrator->getParentUser($params, $accountId)) === false) return false;
        
        $userID = $params['userID'];
        $status = $params['status'];

        $commission = $this->STUserBonusCommission[$tier];

        if($commission != 0 && $commission != '')
        {
            //----------------------------------------
            // register commission
            $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
            $sql = "insert into wd_pa_transactions ".
                   "(transid,parenttransid,affiliateid,dateinserted,transtype,".
                   "transkind,refererurl,ip,rstatus,commission,accountid)".
                   "values("._q($TransID).","._qOrNull($parentTransID).","._q($userID).
                   ",".sqlNow().",".TRANSTYPE_REFERRAL.",".(TRANSKIND_SECONDTIER+$tier).
                   ","._q($remoteAddr).","._q($ip).", "._q($status).
                   ","._q($commission).","._q($accountId).")";
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$ret)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            
            if($status == AFFSTATUS_APPROVED)
            {
                $params = array('users' => array($userID),
                                'AccountID' => $accountId,
                                'cond_when' => RULE_AMOUNT_OF_COMMISSIONS,
                                'decimal_places' => $this->settings['Aff_round_numbers']
                               );

                if(($rules = $this->blRules->getRulesAsArray($params)) !== false)
                    $this->blRules->checkPerformanceRules($params, $rules);
            }
        }
        
        //----------------------------------------
        // go recursively to the next tier
        if($tier < $this->maxCommissionLevels)
        {
            $this->registerMultiTierSignupCommission($accountId, $TransID, $remoteAddr, $ip, $status, $userID, $tier + 1, $maxRecursion -1);          
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function sendMailToUser($userId, $accountId, $userName, $pwd, $approved = true) 
    {
        //----------------------------------------
        // send password by email
        $params = array();
        $params['pwd'] = $pwd;

        if ($approved) {
            $emaildata = $this->blEmailTemplates->getFilledEmailMessage($userId, $accountId, 'AFF_EMAIL_SIGNUP', $_SESSION[SESSION_PREFIX.'lang'], $params);
        } else {
            $emaildata = $this->blEmailTemplates->getFilledEmailMessage($userId, $accountId, 'AFF_EMAIL_ONSIGN', $_SESSION[SESSION_PREFIX.'lang'], $params);
        }
        
        if($emaildata != false)
        {
            $params = array('accountid' => $accountId,
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => $userId,
                            'email' => $userName,
                            'settings' => $this->settings,
                            'users' => $userId
                           );

            if(!$this->blCommunications->sendEmail($params)) {
                QUnit_Messager::setErrorMessage(L_G_EMAILSEND);
                QCore_History::DebugMsg(WLOG_ERROR, 'Signup user: There was a problem sending confirmation email to \''.$userName.'\'', __FILE__, __LINE__);
                return false;
            }
            return true;
        }
        else
        {
            QUnit_Messager::setErrorMessage(L_G_EMAILTEMPERR);
            QCore_History::DebugMsg(WLOG_ERROR, 'Signup user:  There was a problem generating confirmation email from template for \''.$userName.'\'', __FILE__, __LINE__);
            return false;
        }
    }    
    
    //--------------------------------------------------------------------------

    function sendMailToMerchant($userId, $accountId) 
    {
        // check whether to send notification email to mechant
        if($this->settings['Aff_email_onaffsignup'] == 1)
        {
            $params = array();
            
            $emaildata = $this->blEmailTemplates->getFilledEmailMessage($userId, $accountId, 'AFF_EMAIL_NTF_SIGNUP', $this->settings['Aff_default_lang'], $params);
            
            if($emaildata != false)
            {
                $systemEmail = $this->settings['Aff_notifications_email'];

                $params = array('accountid' => $accountId,
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => '',
                            'email' => $systemEmail,
                            'settings' => $this->settings
                );
                
                if(!$this->blCommunications->sendEmail($params)) {
                    QCore_History::DebugMsg(WLOG_ERROR, 'Signup user: There was a problem sending merchant notification email about user \''.$systemEmail.'\' to \''.$systemEmail.'\'', __FILE__, __LINE__);
                    return false;
                } else {
                    QCore_History::DebugMsg(WLOG_ACTION, 'Signup user merchant notification email was succesfully generated and sent to \''.$systemEmail.'\'', __FILE__, __LINE__);
                    return true;
                }
            }
            else
            {
                QCore_History::DebugMsg(WLOG_ERROR, 'Signup user:  There was a problem generating merchant notification email from template about user \''.$systemEmail.'\' to \''.$systemEmail.'\'', __FILE__, __LINE__);
                return false;
            }
        }
        return true;
    }
    
    //--------------------------------------------------------------------------

    function sendMailToParentUser($UserID, $parentUserId, $accountId) 
    {
        // check whether to send notification email to parent user
        if($parentUserId != '')
        {
            $aff_settings = QCore_Settings::getUserSettings(SETTINGTYPE_USER,'',$parentUserId);

            if($aff_settings['Aff_email_affonaffsignup'] == 1)
            {
                $params = array();
                $lang = $aff_settings['Aff_aff_notificationlang'];

                $emaildata = $this->blEmailTemplates->getFilledEmailMessage($UserID, $accountId, 'AFF_EMAIL_AF_NTF_SGN', $lang, $params);

                if($emaildata != false)
                {
                    $email = QCore_Auth::getUsernameForUser($parentUserId);

                    $params = array('accountid' => $accountId,
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => $_POST['parentuserid'],
                            'email' => $email,
                            'settings' => $this->settings
                    );

                    if(!$this->blCommunications->sendEmail($params)) {
                        QCore_History::DebugMsg(WLOG_ERROR, 'Signup user: There was a problem sending user notification email about user \''.$email.'\' to \''.$email.'\'', __FILE__, __LINE__);
                    } else {
                        QCore_History::DebugMsg(WLOG_ACTION, 'Signup user user notification email was succesfully generated and sent to \''.$email.'\'', __FILE__, __LINE__);
                    }    
                }
                else
                {
                    QCore_History::DebugMsg(WLOG_ERROR, 'Signup user:  There was a problem generating user notification email from template about user \''.$email.'\' to \''.$email.'\'', __FILE__, __LINE__);
                }
            }
        }
    }
    
    //--------------------------------------------------------------------------

    function getAccountId()
    {
        if(isset($_REQUEST['aid']) && $_REQUEST['aid'] != '') {
            $aid = $_REQUEST['aid'];
        }
        else {
            if($GLOBALS['Auth']->getProgramType() != PROG_TYPE_ENTERPRISE) {
                $aid = DEFAULT_ACCOUNT;
            }
        }
        
        $this->accountid = $aid;
        
        return $aid;        
    }
    
    //--------------------------------------------------------------------------
    
    function checkRefidUnique($refID, $withoutUserID = '') {
        if ($refID == '') return true;
    	$sql = 'select refid from wd_g_users where refid='._q($refID).
    		   ' and deleted=0 and rtype='._q(USERTYPE_USER);
        if ($withoutUserID != '') {
            $sql .= ' and userid<>'._q($withoutUserID);
        }
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs->EOF) {
        	return false;
        }
        return true;
    }
    
	//--------------------------------------------------------------------------
    
    function checkCampaignId($campaignID) {
        if ($campaignID == '') return false;
        
        $campaignManager = QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
        
        $campaigns = $campaignManager->getCampaignsAsArray();
        
        if ($campaigns[$campaignID] == '') return false;
        
        $params = $campaignManager->getParamsAsArray();
        
        if ($params[$campaignID]['Aff_camp_status'] == AFF_CAMP_PRIVATE ||
            $params[$campaignID]['Aff_camp_status'] == '') return false;
        
        return true;
    }
    
	//--------------------------------------------------------------------------
	
    function addUserToCampaign($userId, $campaignId, $campaignCategoryId) {
        if ($campaignId == '' || $campaignId == '_') return false;
        
        $blAffiliate = QUnit_Global::newObj('Affiliate_Affiliates_Bl_Affiliate');
        $params = array('userID' => $userId,
                        'CampaignID' => $campaignId,
                        'CampaignCategoryID' => $campaignCategoryId
                       );

        if (!$blAffiliate->insertAffCamp($params)) {
            QUnit_Messager::setErrorMessage(L_G_CANNOTADDAFFILIATETOCAMPAIGN);
            return false;
        }
        
        return true;
    }
    
}
?>
