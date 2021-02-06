<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_Bl_GlobalDb');

class Affiliate_Merchants_Bl_Affiliate
{
    var $blCampCategories;
    var $blCommunications;
    var $blEmailTemplates;
    var $blPayoutOptions;

    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Bl_Affiliate() {
        $this->blCampCategories =& QUnit_Global::newObj('Affiliate_Merchants_Bl_CampaignCategories');
        $this->blCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');
        $this->blEmailTemplates =& QUnit_Global::newObj('QCore_EmailTemplates');
        $this->blPayoutOptions =& QUnit_Global::newObj('Affiliate_Merchants_Bl_PayoutOptions');
    }

    //--------------------------------------------------------------------------

    function decline($params)
    {
        $userIDs = $params['userids'];
        if(!is_array($userIDs) || count($userIDs) < 1)
            return false;

        $chunkedUserIDs = my_array_chunk($userIDs, WD_MAX_PROCESSED_IDS);

        foreach($chunkedUserIDs as $userIDsArray)
        {
            $userIDSql = "('".implode("','", $userIDsArray)."')";

            $sql = 'update wd_g_users set rstatus='._q(AFFSTATUS_SUPPRESSED).
                   ' where userid in '.$userIDSql.
                   '   and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        $globalDb =& QCore_Bl_GlobalDb::getInstance();
        $params = array('userids' => $userIDs,
                        'liteaccountid' => $GLOBALS['Auth']->getLiteAccountId(),
                        'status' => AFFSTATUS_SUPPRESSED);
        $globalDb->changeUserStatus($params);
        
        $siteReplication = QUnit_Global::newObj('Affiliate_Scripts_Bl_ReplicatedSite');
        foreach ($userIDs as $UserID) {
            $siteReplication->userStatusChanged($UserID);
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function pending($params)
    {
        $userIDs = $params['userids'];
        if(!is_array($userIDs) || count($userIDs) < 1)
            return false;

        $chunkedUserIDs = my_array_chunk($userIDs, WD_MAX_PROCESSED_IDS);

        foreach($chunkedUserIDs as $userIDsArray)
        {
            $userIDSql = "('".implode("','", $userIDsArray)."')";

            $sql = 'update wd_g_users set rstatus='._q(AFFSTATUS_NOTAPPROVED).
                   ' where userid in '.$userIDSql.
                   '   and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        $globalDb =& QCore_Bl_GlobalDb::getInstance();
        $params = array('userids' => $userIDs,
                        'liteaccountid' => $GLOBALS['Auth']->getLiteAccountId(),
                        'status' => AFFSTATUS_NOTAPPROVED);
        $globalDb->changeUserStatus($params);
        
        $siteReplication = QUnit_Global::newObj('Affiliate_Scripts_Bl_ReplicatedSite');
        foreach ($userIDs as $UserID) {
            $siteReplication->userStatusChanged($UserID);
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function approve($params)
    {
        $settings = $params['settings'];

        $userIDs = $params['userids'];
        if(!is_array($userIDs) || count($userIDs) < 1)
            return false;

        $chunkedUserIDs = my_array_chunk($userIDs, WD_MAX_PROCESSED_IDS);
        foreach($chunkedUserIDs as $userIDsArray)
        {
            $userIDSql = "('".implode("','", $userIDsArray)."')";

            // first send confirmation emails
            // check what was the last state
            $sql = 'select userid, username, rstatus, rpassword from wd_g_users '.
                   'where userid in '.$userIDSql.
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }

            while(!$rs->EOF)
            {
                if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED)
                {
                    // send email to affiliate about the approval
                    $params = array();
                    $params['pwd'] = $rs->fields['rpassword'];

                    $emaildata = $this->blEmailTemplates->getFilledEmailMessage($rs->fields['userid'], $GLOBALS['Auth']->getAccountID(USERTYPE_USER), 'AFF_EMAIL_SIGNUP', $_SESSION[SESSION_PREFIX.'lang'], $params);
                    $password_sent = false;
                    if($emaildata != false)
                    {
                        $params = array('accountid' => $GLOBALS['Auth']->getAccountID(USERTYPE_USER),
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => $rs->fields['userid'],
                            'email' => $rs->fields['username'],
                            'settings' => $settings,
                            'users' => $rs->fields['userid'],
                           );

                        if(!$this->blCommunications->sendEmail($params)) {
                            QCore_History::DebugMsg(WLOG_DBERROR, L_G_EMAILSEND, __FILE__, __LINE__);
                        }
                    }
                    else {
                        QCore_History::DebugMsg(WLOG_ACTIONS, L_G_EMAILTEMPERR, __FILE__, __LINE__);
                    }
                }

                $rs->MoveNext();
            }

            // now change status
            $sql = 'update wd_g_users set rstatus='._q(AFFSTATUS_APPROVED).
                   ' where userid in '.$userIDSql.
                   '   and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        $globalDb =& QCore_Bl_GlobalDb::getInstance();
        $params = array('userids' => $userIDs,
                        'liteaccountid' => $GLOBALS['Auth']->getLiteAccountId(),
                        'status' => AFFSTATUS_APPROVED);
        $globalDb->changeUserStatus($params);
        
        $siteReplication = QUnit_Global::newObj('Affiliate_Scripts_Bl_ReplicatedSite');
        foreach ($userIDs as $UserID) {
            $siteReplication->userStatusChanged($UserID);
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function delete($params)
    {
        $userIDs = $params['userids'];
        if(!is_array($userIDs) || count($userIDs) < 1)
            return false;

        $chunkedUserIDs = my_array_chunk($userIDs, WD_MAX_PROCESSED_IDS);

        foreach($chunkedUserIDs as $userIDsArray)
        {
            $userIDSql = "('".implode("','", $userIDsArray)."')";

            $sql = 'update wd_g_users set deleted=1 '.
                   ' where userid in '.$userIDSql.
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        $globalDb =& QCore_Bl_GlobalDb::getInstance();
        $params = array('userids' => $userIDs,
                        'liteaccountid' => $GLOBALS['Auth']->getLiteAccountId());
        $globalDb->deleteUser($params);
        
        $siteReplication = QUnit_Global::newObj('Affiliate_Scripts_Bl_ReplicatedSite');
        foreach ($userIDs as $UserID) {
            $siteReplication->deleteFile($UserID);
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function checkData($params, $checkCrossLink = true)
    {
        $payout_methods = $this->blPayoutOptions->getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $payout_fields = $this->blPayoutOptions->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);

        // protect against script injection
        $params['status'] = preg_replace('/[^0-9]/', '', $_POST['status']);
        $params['refid'] = preg_replace('/[^0-9a-zA-Z_-]/', '', $_POST['refid']);
        $params['uname'] = preg_replace('/[\'\"]/', '', $_POST['uname']);
        $params['pwd1'] = preg_replace('/[\'\"]/', '', $_POST['pwd1']);
        $params['pwd2'] = preg_replace('/[\'\"]/', '', $_POST['pwd2']);
        $params['weburl'] = preg_replace('/[\'\"]/', '', $_POST['weburl']);
        $params['name'] = preg_replace('/[\'\"]/', '', $_POST['name']);
        $params['surname'] = preg_replace('/[\'\"]/', '', $_POST['surname']);
        $params['payout_type'] = preg_replace('/[\'\"]/', '', $_POST['payout_type']);
        $params['tax_ssn'] = preg_replace('/[\'\"]/', '', $_POST['tax_ssn']);
        $params['company_name'] = preg_replace('/[\'\"]/', '', $_POST['company_name']);
        $params['street'] = preg_replace('/[\'\"]/', '', $_POST['street']);
        $params['city'] = preg_replace('/[\'\"]/', '', $_POST['city']);
        $params['state'] = preg_replace('/[\'\"]/', '', $_POST['state']);
        $params['country'] = preg_replace('/[\"]/', '', $_POST['country']);
        $params['zipcode'] = preg_replace('/[\'\"]/', '', $_POST['zipcode']);
        $params['phone'] = preg_replace('/[\'\"]/', '', $_POST['phone']);
        $params['fax'] = preg_replace('/[\'\"]/', '', $_POST['fax']);
        $params['minpayout'] = preg_replace('/[^0-9]/', '', $_POST['minpayout']);
        $params['userid'] = preg_replace('/[\'\"]/', '', $_POST['aid']);
        $params['parentuserid'] = preg_replace('/[\'\"]/', '', $_POST['parentuserid']);
        $params['data1'] = preg_replace('/[\'\"]/', '', $_POST['data1']);
        $params['data2'] = preg_replace('/[\'\"]/', '', $_POST['data2']);
        $params['data3'] = preg_replace('/[\'\"]/', '', $_POST['data3']);
        $params['data4'] = preg_replace('/[\'\"]/', '', $_POST['data4']);
        $params['data5'] = preg_replace('/[\'\"]/', '', $_POST['data5']);
        $params['add_campaign_id'] = preg_replace('/[\'\"]/', '', $_POST['add_campaign_id']);
        $params['flags'] = (!empty($_POST['virtual_affiliate']))? VIRTUAL_AFFILIATE : STANDARD_AFFILIATE;        
        $params['vat_is_company'] = preg_replace('/[^0-9]/', '', $_POST['vat_is_company']);
        $params['vat_percentage'] = preg_replace('/[\'\"]/', '', $_POST['vat_percentage']);
        $params['vat_number'] = preg_replace('/[\'\"]/', '', $_POST['vat_number']);
        $params['vat_amountofcapital'] = preg_replace('/[\'\"]/', '', $_POST['vat_amountofcapital']);
        $params['vat_registrationnumber'] = preg_replace('/[\'\"]/', '', $_POST['vat_registrationnumber']);

        foreach($payout_fields as $payfield)
        {
            foreach($payfield as $value)
            {
                $params['field'.$value['payfieldid']] = preg_replace('/[\'\"]/', '', $_POST['field'.$value['payfieldid']]);
            }
        }

        // check correctness of the fields
        $settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());

        checkCorrectness($_POST['uname'], $params['uname'], L_G_USERNAME, CHECK_EMPTYALLOWED);
        if($_POST['uname'] != '' && $this->checkUserExists($_POST['uname'], $params['userid'], $GLOBALS['Auth']->getAccountID(USERTYPE_USER), USERTYPE_USER))
            QUnit_Messager::setErrorMessage(L_G_UNAMEEXISTS);

        if (($settings['Aff_signup_refid'] == "1") && ($settings['Aff_signup_refid_mandatory'] === "true"))
            checkCorrectness($_POST['refid'], $params['refid'], L_G_REFID, CHECK_EMPTYALLOWED);

        if($_POST['refid'] != '' && $this->checkRefIDExists($_POST['refid'], $params['userid'], $GLOBALS['Auth']->getAccountID(USERTYPE_USER)))
            QUnit_Messager::setErrorMessage(L_G_REFIDEXISTS);

        if($_POST['pwd1']!='*****' || $_POST['pwd2']!='*****')
        {
            checkCorrectness($_POST['pwd1'], $params['pwd1'], L_G_PWD1, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['pwd2'], $params['pwd2'], L_G_PWD2, CHECK_EMPTYALLOWED);

            if($_POST['pwd1'] != $_POST['pwd2'])
                QUnit_Messager::setErrorMessage(L_G_PWDDONTMATCH);
        }

        if (($settings['Aff_signup_weburl'] == "1") && ($settings['Aff_signup_weburl_mandatory'] === "true"))
            checkCorrectness($_POST['weburl'], $params['weburl'], L_G_WEBURL, CHECK_EMPTYALLOWED);

        checkCorrectness($_POST['name'], $params['name'], L_G_NAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['surname'], $params['surname'], L_G_SURNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['country'], $params['country'], L_G_COUNTRY, CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_street'] == "1") && ($settings['Aff_signup_street_mandatory'] === "true"))
            checkCorrectness($_POST['street'], $params['street'], L_G_STREET, CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_city'] == "1") && ($settings['Aff_signup_city_mandatory'] === "true"))
            checkCorrectness($_POST['city'], $params['city'], L_G_CITY, CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_zipcode'] == "1") && ($settings['Aff_signup_zipcode_mandatory'] === "true"))
            checkCorrectness($_POST['zipcode'], $params['zipcode'], L_G_ZIPCODE, CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_company_name'] == "1") && ($settings['Aff_signup_company_name_mandatory'] === "true"))
            checkCorrectness($_POST['company_name'], $params['company_name'], L_G_COMPANYNAME, CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_state'] == "1") && ($settings['Aff_signup_state_mandatory'] === "true"))
            checkCorrectness($_POST['state'], $params['state'], L_G_STATE, CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_phone'] == "1") && ($settings['Aff_signup_phone_mandatory'] === "true"))
            checkCorrectness($_POST['phone'], $params['phone'], L_G_PHONE, CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_fax'] == "1") && ($settings['Aff_signup_fax_mandatory'] === "true"))
            checkCorrectness($_POST['fax'], $params['fax'], L_G_FAX, CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_tax_ssn'] == "1") && ($settings['Aff_signup_tax_ssn_mandatory'] === "true"))
            checkCorrectness($_POST['tax_ssn'], $params['tax_ssn'], L_G_TAXSSN, CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_data1'] == "1") && ($settings['Aff_signup_data1_mandatory'] === "true"))
            checkCorrectness($_POST['data1'], $params['data1'], $settings['Aff_signup_data1_name'], CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_data2'] == "1") && ($settings['Aff_signup_data2_mandatory'] === "true"))
            checkCorrectness($_POST['data2'], $params['data2'], $settings['Aff_signup_data2_name'], CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_data3'] == "1") && ($settings['Aff_signup_data3_mandatory'] === "true"))
            checkCorrectness($_POST['data3'], $params['data3'], $settings['Aff_signup_data3_name'], CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_data4'] == "1") && ($settings['Aff_signup_data4_mandatory'] === "true"))
            checkCorrectness($_POST['data4'], $params['data4'], $settings['Aff_signup_data4_name'], CHECK_EMPTYALLOWED);
        if (($settings['Aff_signup_data5'] == "1") && ($settings['Aff_signup_data5_mandatory'] === "true"))
            checkCorrectness($_POST['data5'], $params['data5'], $settings['Aff_signup_data5_name'], CHECK_EMPTYALLOWED);

        if($GLOBALS['Auth']->getSetting('Aff_min_payout_options') != '')
            checkCorrectness($_POST['minpayout'], $params['minpayout'], L_G_MINPAYOUT, CHECK_EMPTYALLOWED, CHECK_NUMBER);

        if($params['payout_type'] == '')
            QUnit_Messager::setErrorMessage(L_G_CHOOSEPAYOUTMETHOD);

        foreach($payout_methods as $method)
        {
            if($params['payout_type'] == $method['payoptid'])
            {
                if (count($payout_fields) > 0) {
                    foreach($payout_fields[$method['payoptid']] as $field)
                    {
                        $check = CHECK_ALLOWED;
                        if($field['mandatory'] == STATUS_ENABLED)
                        {
                            $check = CHECK_EMPTYALLOWED;
                        }

                        checkCorrectness($_POST['field'.$field['payfieldid']], $params['field'.$field['payfieldid']],
                                 (defined($field['langid']) ? constant($field['langid']) : $field['name']), $check);
                    }
                }
            }
        }
        
        if ($params['vat_is_company'] == '1') {
            checkCorrectness($_POST['vat_percentage'], $params['vat_percentage'], L_G_VATPERCENTAGE, CHECK_EMPTYALLOWED);
        }

        // check if there is not the cross link of affiliates, such as A -> B, and B -> A
        $blGlobalFuncs =& QUnit_Global::newObj('QCore_Bl_GlobalFuncs');
        if($checkCrossLink && ($blGlobalFuncs->checkCrossLink($params['parentuserid'], array($params['userid'], $params['parentuserid']), 'userid', 'parentuserid', 'wd_g_users')))
        {
            QUnit_Messager::setErrorMessage(L_G_MERCHPARENTAFFILIATECREATESCHAIN);
        }

        return $params;
    }

    //------------------------------------------------------------------------

    function checkUserExists($username, $aid = '', $accountid, $usertype = '')
    {
        if($username == '') return false;

        $sql = 'select userid from wd_g_users '.
               'where deleted=0 '.
               '  and username='._q($username).
               '  and accountid='._q($accountid);
        if($usertype != '')
             $sql .= ' and rtype='._q(USERTYPE_USER);
        if($aid != '')
            $sql .= ' and userid<>'._q($aid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF)
            return false;

        return true;
    }

    //------------------------------------------------------------------------

    function checkRefIDExists($refID, $aid = '', $accountid)
    {
        $sql = 'select * from wd_g_users '.
               'where deleted=0 '.
               '  and (refid='._q($refID).' or userid='._q($refID).')'.
               '  and accountid='._q($accountid);
        if($aid != '')
            $sql .= ' and userid<>'._q($aid);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF)
            return false;

        return true;
    }

    //------------------------------------------------------------------------

    function insert($params)
    {
        $settings = $params['settings'];

        if ($params['status'] == '')
            $params['status'] = AFFSTATUS_APPROVED;

        // save user to db
        $UserID = QCore_Sql_DBUnit::createUniqueID('wd_g_users', 'userid');
        $sql = 'insert into wd_g_users(userid, refid, parentuserid, accountid, username, '.
               'rpassword, rtype, dateinserted, name, surname, rstatus, userprofileid, '.
               'weburl, company_name, street, city, state, country, zipcode, phone, '.
               ' fax, tax_ssn, payoptid, data1, data2, data3, data4, data5, flags)'.

               ' values('._q($UserID).','._q($params['refid']).','._q($params['parentuserid']).','._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER)).
               ','._q($params['uname']).','._q($params['pwd1']).','._q(USERTYPE_USER).
               ','.sqlNow().','._q($params['name']).','._q($params['surname']).
               ','._q($params['status']).','._q(DEFAULT_USER_PROFILE).
               ','._q($params['weburl']).','._q($params['company_name']).','._q($params['street']).
               ','._q($params['city']).','._q($params['state']).','._q($params['country'])
               .','._q($params['zipcode']).','._q($params['phone']).','._q($params['fax'])
               .','._q($params['tax_ssn']).','._q($params['payout_type']).','._q($params['data1'])
               .','._q($params['data2']).','._q($params['data3']).','._q($params['data4'])
               .','._q($params['data5']).','._q($params['flags']).')';

        $globalDbParams = array('userid' => $UserID,
                                'liteaccountid' => $GLOBALS['Auth']->getLiteAccountId(),
                                'username' => $params['uname'],
                                'refid' => $params['refid'],
                                'password' => $params['pwd1'],
                                'type' => USERTYPE_USER,
                                'status' => $params['status']);

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        if ($params['add_campaign_id'] != '' && $params['add_campaign_id'] != '_') {
            $blAffiliate = QUnit_Global::newObj('Affiliate_Affiliates_Bl_Affiliate');
            $params = array('userID' => $UserID,
                            'CampaignID' => $params['add_campaign_id'],
                            'status' => AFFSTATUS_APPROVED
                           );

            if (!$blAffiliate->isUserInCampaign($params)) {
                if (!$blAffiliate->insertAffCamp($params)) {
                    QUnit_Messager::setErrorMessage(L_G_CANNOTADDAFFILIATETOCAMPAIGN);
                    return false;
                }
            }
        }

        $globalDb =& QCore_Bl_GlobalDb::getInstance();
        $globalDb->insertUser($globalDbParams);
        
        $siteReplication = QUnit_Global::newObj('Affiliate_Scripts_Bl_ReplicatedSite');
        $siteReplication->createFile($UserID);
        
        if (($params['status'] == AFFSTATUS_APPROVED) && ($settings['Aff_affiliateapproval'] != APPROVE_AUTOMATIC || $params['notifymail'] == 'yes'))
        {

            $params['userid'] = $UserID;
            $this->saveUserData($params);

            if ($params['notifymail'] == 'yes') {
                // send password by email
                $emailParams = array();
                $emailParams['pwd'] = $params['pwd1'];

                QUnit_Global::includeClass('QCore_EmailTemplates');

                $emaildata = $this->blEmailTemplates->getFilledEmailMessage($UserID, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), 'AFF_EMAIL_SIGNUP', $_SESSION[SESSION_PREFIX.'lang'], $emailParams);

                $password_sent = false;

                if($emaildata != false)
                {
                    $params = array('accountid' => $GLOBALS['Auth']->getAccountID(USERTYPE_USER),
                                'subject' => $emaildata['subject'],
                                'text' => $emaildata['text'],
                                'message_type' => MESSAGETYPE_EMAIL,
                                'userid' => $UserID,
                                'email' => $params['uname'],
                                'settings' => $settings
                    );
    
                    if(!$this->blCommunications->sendEmail($params)) {
                        QCore_History::DebugMsg(WLOG_DBERROR, L_G_EMAILSEND, __FILE__, __LINE__);
                        QUnit_Messager::setErrorMessage(L_G_CONFEMAILERROR);
                        return true;
                    }
                }
                else
                {
                    QUnit_Messager::setErrorMessage(L_G_CONFEMAILERROR);
                    QCore_History::DebugMsg(WLOG_ACTIONS, L_G_EMAILTEMPERR, __FILE__, __LINE__);
                }
            }
        }

        return true;
    }

    //------------------------------------------------------------------------

    function saveUserData($params)
    {
        $payout_fields = $this->blPayoutOptions->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);

        $sql = 'delete from wd_g_settings '.
               'where accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER)).
               '  and rtype='._q(SETTINGTYPE_USER).
               '  and userid='._q($params['userid']).
               '  and code like \'%'._q_noendtags('Aff_payoptionfield_').'%\'';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        // save data into settings
        QCore_Settings::_update('Aff_payout_type', $params['payout_type'], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), $params['userid']);
        QCore_Settings::_update('Aff_min_payout', $params['minpayout'], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), $params['userid']);
        QCore_Settings::_update('Aff_overwrite_cookie', $params['overwrite_cookie'], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), $params['userid']);

        if(is_array($payout_fields[$params['payout_type']]))
        {
            foreach($payout_fields[$params['payout_type']] as $field)
            {
                QCore_Settings::_update('Aff_payoptionfield_'.$field['payfieldid'], $params['field'.$field['payfieldid']], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), $params['userid'], $field['payfieldid']);
            }
        }
        
        // save VAT data into settings
        QCore_Settings::_update('Aff_vat_is_company', $params['vat_is_company'], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), $params['userid']);
        QCore_Settings::_update('Aff_vat_percentage', $params['vat_percentage'], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), $params['userid']);
        QCore_Settings::_update('Aff_vat_number', $params['vat_number'], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), $params['userid']);
        QCore_Settings::_update('Aff_vat_amountofcapital', $params['vat_amountofcapital'], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), $params['userid']);
        QCore_Settings::_update('Aff_vat_registrationnumber', $params['vat_registrationnumber'], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), $params['userid']);
    }

    //--------------------------------------------------------------------------
/*
    function checkUserCrossLink($userID, $list = array(), $maxRecursion = 50)
    {
        if($userID == '' || $userID == 0 || $maxRecursion <=0)
            return false;

        // get parent affiliate of current aff
        $sql = "select parentuserid from wd_g_users where userid="._q($userID)." and parentuserid<>"._q($userID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if(in_array($rs->fields['parentuserid'], $list))
            return true;

        $list[] = $rs->fields['parentuserid'];

        return $this->checkUserCrossLink($rs->fields['parentuserid'], $list, $maxRecursion - 1);
    }
*/
    //--------------------------------------------------------------------------

    function update($params)
    {
        $siteReplication = QUnit_Global::newObj('Affiliate_Scripts_Bl_ReplicatedSite');
        $siteReplication->saveOldUser($params['userid']);
        
        $oldparams = $params;
        
        if(AFF_DEMO == 1 && $params['userid'] == 2)
        {
            $sql = 'update wd_g_users '.
                   'set name='._q($params['name']).
                   '   ,surname='._q($params['surname']);
        }
        else
        {
            $sql = 'update wd_g_users '.
                   'set username='._q($params['uname']).
                   ', refid='._q($params['refid']).
                   ', surname='._q($params['surname']).
                   ', name='._q($params['name']).
                   ', parentuserid='._q($params['parentuserid']).
                   ', weburl='._q($params['weburl']).
                   ', company_name='._q($params['company_name']).
                   ', street='._q($params['street']).
                   ', city='._q($params['city']).
                   ', state='._q($params['state']).
                   ', country='._q($params['country']).
                   ', zipcode='._q($params['zipcode']).
                   ', phone='._q($params['phone']).
                   ', fax='._q($params['fax']).
                   ', tax_ssn='._q($params['tax_ssn']).
                   ', payoptid='._q($params['payout_type']).
                   ', data1='._q($params['data1']).
                   ', data2='._q($params['data2']).
                   ', data3='._q($params['data3']).
                   ', data4='._q($params['data4']).
                   ', data5='._q($params['data5']).
                   ', flags='._q($params['flags']);

            if($params['status'] != '')
                $sql .=',rstatus='._q($params['status']);

            if($params['pwd1']!='*****' || $params['pwd2']!='*****')
                $sql .=',rpassword='._q($params['pwd1']);
        }

        $sql .= ' where userid='._q($params['userid']).
                '   and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $this->saveUserData($params);

        $globalDb =& QCore_Bl_GlobalDb::getInstance();

        if($params['pwd1']!='*****' || $params['pwd2']!='*****') {
        $params = array('userid' => $params['userid'],
                        'liteaccountid' => $GLOBALS['Auth']->getLiteAccountId(),
                        'username' => $params['uname'],
                        'refid' => $params['refid'],
                        'password' => $params['pwd1']);
        } else {
        $params = array('userid' => $params['userid'],
                        'liteaccountid' => $GLOBALS['Auth']->getLiteAccountId(),
                        'username' => $params['uname'],
                        'refid' => $params['refid']);
	  }


        $globalDb->updateUser($params);
        
        $siteReplication->changeFile($params['userid']);

        if (($oldparams['status'] == AFFSTATUS_APPROVED) && ($settings['Aff_affiliateapproval'] != APPROVE_AUTOMATIC || $oldparams['notifymail'] == 'yes'))
        {
            $this->saveUserData($oldparams);

            if ($oldparams['notifymail'] == 'yes') {
                // send password by email
                $emailParams = array();
                $emailParams['pwd'] = $oldparams['pwd1'];

                QUnit_Global::includeClass('QCore_EmailTemplates');

                $emaildata = $this->blEmailTemplates->getFilledEmailMessage($oldparams['userid'], $GLOBALS['Auth']->getAccountID(USERTYPE_USER), 'AFF_EMAIL_SIGNUP', $_SESSION[SESSION_PREFIX.'lang'], $emailParams);

                $password_sent = false;

                if($emaildata != false)
                {
                    $oldparams = array('accountid' => $GLOBALS['Auth']->getAccountID(USERTYPE_USER),
                                'subject' => $emaildata['subject'],
                                'text' => $emaildata['text'],
                                'message_type' => MESSAGETYPE_EMAIL,
                                'userid' => $UserID,
                                'email' => $oldparams['uname'],
                                'settings' => $settings
                    );
    
                    if(!$this->blCommunications->sendEmail($oldparams)) {
                        QCore_History::DebugMsg(WLOG_DBERROR, L_G_EMAILSEND, __FILE__, __LINE__);
                        QUnit_Messager::setErrorMessage(L_G_CONFEMAILERROR);
                        return true;
                    }
                }
                else
                {
                    QUnit_Messager::setErrorMessage(L_G_CONFEMAILERROR);
                    QCore_History::DebugMsg(WLOG_ACTIONS, L_G_EMAILTEMPERR, __FILE__, __LINE__);
                }
            }
        }
        
        return true;
    }

    //--------------------------------------------------------------------------

    function insertAffiliatesCampaigns($params)
    {
        if(($campaigns_data=$this->blCampCategories->getFirstCampaignsCategory($params)) === false) return false;

        $chunkedUserIDs = my_array_chunk($params['userIDs'], WD_MAX_PROCESSED_IDS);

        foreach($chunkedUserIDs as $userIDsArray)
        {
            foreach($userIDsArray as $UserID)
            {
                $temp_campaigns_data = $campaigns_data;

                foreach($temp_campaigns_data as $campaign_data)
                {
                    $sql = 'select affcampid from wd_pa_affiliatescampaigns '.
                           'where affiliateid='._q($UserID).
                           '  and campaignid='._q($campaign_data['campaignid']);
                    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                    if(!$rs) {
                        QUnit_Messager::setErrorMessage(L_G_DBERROR);
                        return false;
                    }

                    if($rs->EOF)
                    {
                        $AffCampID = QCore_Sql_DBUnit::createUniqueID('wd_pa_affiliatescampaigns', 'affcampid');

                        $sql = 'insert into wd_pa_affiliatescampaigns '.
                               '(affcampid, campcategoryid, affiliateid, campaignid, rstatus)'.
                               ' values '.
                               '('._q($AffCampID).','._q($campaign_data['campcategoryid']).
                               ','._q($UserID).','._q($campaign_data['campaignid']).
                               ','._q(AFFSTATUS_APPROVED).')';
                        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

                        if(!$ret) {
                            QUnit_Messager::setErrorMessage(L_G_DBERROR);
                            return false;
                        }
                    }
                }
            }
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function loadUserInfoAsArray($userid)
    {
        $sql = 'select * from wd_g_users '.
               'where deleted=0 '.
               '  and userid='._q($userid).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $payout_fields = $this->blPayoutOptions->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED, $rs->fields['payoptid']);
        $userData = QCore_Settings::getUserSettings(SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), $rs->fields['userid']);

        $result = $rs->fields;

        $result['virtual_affiliate'] = $result['flags'];
        $result['minpayout'] = $userData['Aff_min_payout'];
        $result['overwrite_cookie'] = $userData['Aff_overwrite_cookie'];
        
        $result['vat_is_company'] = $userData['Aff_vat_is_company'];
        $result['vat_percentage'] = $userData['Aff_vat_percentage'];
        $result['vat_number'] = $userData['Aff_vat_number'];
        $result['vat_amountofcapital'] = $userData['Aff_vat_amountofcapital'];
        $result['vat_registrationnumber'] = $userData['Aff_vat_registrationnumber'];
        $result['vat_invoicenumber'] = $userData['Aff_vat_invoicenumber'];

        if(is_array($payout_fields[$result['payoptid']])) {
            foreach($payout_fields[$result['payoptid']] as $field)
            {
                $result['field'.$field['payfieldid']] = $userData['Aff_payoptionfield_'.$field['payfieldid']];
            }
        }

        return $result;
    }

    //--------------------------------------------------------------------------

    function loadUserInfoToPost($userid)
    {
/*        $sql = 'select * from wd_g_users '.
               'where deleted=0 '.
               '  and userid='._q($userid).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $payout_fields = $this->blPayoutOptions->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED, $rs->fields['payoptid']);
        $userData = QCore_Settings::getUserSettings(SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(USERTYPE_USER), $rs->fields['userid']);

        $_POST['aid'] = $rs->fields['userid'];
        $_POST['refid'] = $rs->fields['refid'];
        if($_POST['refid'] == '')
            $_POST['refid'] = $rs->fields['userid'];
        $_POST['uname'] = $rs->fields['username'];
        $_POST['pwd1'] = '*****';
        $_POST['pwd2'] = '*****';
        $_POST['name'] = $rs->fields['name'];
        $_POST['surname'] = $rs->fields['surname'];
        $_POST['parentuserid'] = $rs->fields['parentuserid'];
        $_POST['weburl'] = $rs->fields['weburl'];
        $_POST['company_name'] = $rs->fields['company_name'];
        $_POST['street'] = $rs->fields['street'];
        $_POST['city'] = $rs->fields['city'];
        $_POST['state'] = $rs->fields['state'];
        $_POST['country'] = $rs->fields['country'];
        $_POST['zipcode'] = $rs->fields['zipcode'];
        $_POST['phone'] = $rs->fields['phone'];
        $_POST['fax'] = $rs->fields['fax'];
        $_POST['tax_ssn'] = $rs->fields['tax_ssn'];
        $_POST['payout_type'] = $rs->fields['payoptid'];
        $_POST['data1'] = $rs->fields['data1'];
        $_POST['data2'] = $rs->fields['data2'];
        $_POST['data3'] = $rs->fields['data3'];
        $_POST['data4'] = $rs->fields['data4'];
        $_POST['data5'] = $rs->fields['data5'];

        $_POST['minpayout'] = $userData['Aff_min_payout'];

        if(is_array($payout_fields[$rs->fields['payoptid']])) {
            foreach($payout_fields[$rs->fields['payoptid']] as $field)
            {
                $_POST['field'.$field['payfieldid']] = $userData['Aff_payoptionfield_'.$field['payfieldid']];
            }
        }

        $_POST['status'] = $rs->fields['rstatus'];*/

        $userInfo = $this->loadUserInfoAsArray($userid);

        foreach ($userInfo as $key => $value) {
            switch ($key) {
                case 'userid':
                    $_POST['aid'] = $value;
                    break;
                case 'refid':
                    ($value == '') ? $_POST['refid'] = $userInfo['userid'] : $_POST['refid'] = $value;
                    break;
                case 'username':
                    $_POST['uname'] = $value;
                    break;
                case 'payoptid':
                    $_POST['payout_type'] = $value;
                    break;
                case 'rstatus':
                    $_POST['status'] = $value;
                    break;
                default:
                    $_POST[$key] = $value;
            }
        }

        $_POST['lastlogindate'] = $this->getUsersLastLogin($_POST['aid']);
        $_POST['logincount'] = $this->getUsersLoginCount($_POST['aid']);

        $_POST['pwd1'] = '*****';
        $_POST['pwd2'] = '*****';

        return true;
    }

    //--------------------------------------------------------------------------

    function getUsersLastLogin($userID) {

        $sql = "select value from wd_g_settings where userid='$userID' and code='Aff_lastlogintime'";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        return $rs->fields['value'];
    }

    //--------------------------------------------------------------------------

    function getUsersLoginCount($userID) {

        $sql = "select value from wd_g_settings where userid='$userID' and code='Aff_logincount'";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        return $rs->fields['value'];
    }

    //--------------------------------------------------------------------------

    function getUsersShortAsArray()
    {
        $sql = 'select * from wd_g_users '.
               'where deleted=0 '.
               '  and rtype='._q(USERTYPE_USER).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $users = array();
        while(!$rs->EOF)
        {
            $temp = array();

            $temp['userid'] = $rs->fields['userid'];
            $temp['name'] = $rs->fields['name'];
            $temp['surname'] = $rs->fields['surname'];
            $temp['username'] = $rs->fields['username'];

            $users[$rs->fields['userid']] = $temp;

            $rs->MoveNext();
        }

        return $users;
    }

    //--------------------------------------------------------------------------

    function getUsersAsArray()
    {
        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK)
            $sql = 'select u.* '.
                   'from wd_g_users u, wd_pa_affiliatescampaigns ac, wd_pa_campaigns c '.
                   'where c.accountid='._q($GLOBALS['Auth']->getAccountID()).
                   '  and c.campaignid=ac.campaignid'.
                   '  and ac.affiliateid=u.userid'.
                   '  and u.deleted=0 '.
                   '  and u.rtype='._q(USERTYPE_USER).
                   '  and u.accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
        else
            $sql = 'select * from wd_g_users '.
                   'where deleted=0 '.
                   '  and rtype='._q(USERTYPE_USER).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $user = array();
        while(!$rs->EOF)
        {
            $temp = array();

            $temp['userid'] = $rs->fields['userid'];
            $temp['name'] = $rs->fields['name'];
            $temp['surname'] = $rs->fields['surname'];
            $temp['username'] = $rs->fields['username'];

            $user[$rs->fields['userid']] = $temp;

            $rs->MoveNext();
        }

        if(count($user) <= 0) {
            return array();
        }

        $user_str = '';
        foreach($user as $k => $v)
        {
            $user_str .= '\''.$k.'\',';
        }
        $user_str = substr($user_str, 0, -1);

        $sql = 'select userid, value '.
               'from wd_g_settings '.
               'where code='._q('Aff_payout_type').
               '  and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER)).
               '  and userid in ('.$user_str.')';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        while(!$rs->EOF)
        {
            $user[$rs->fields['userid']]['payout_type'] = $rs->fields['value'];
            $rs->MoveNext();
        }

        return $user;
    }

    //--------------------------------------------------------------------------

    function getTreeOfUsers($rootID, &$userTree, $tab, $tabLevel, $maxLevel)
    {
        if($maxLevel <= 0)
            return;

        $sql = 'select * from wd_g_users';
        if($rootID == '') {
            $sql .=' where rstatus='.AFFSTATUS_APPROVED.' and deleted=0 and rtype='._q(USERTYPE_USER).' and accountid='._q($GLOBALS['Auth']->getAccountID()).' and (parentuserid=\'\' or parentuserid is null or parentuserid=\'0\')';
        }
        else
            $sql .=' where rstatus='.AFFSTATUS_APPROVED.' and deleted=0 and rtype='._q(USERTYPE_USER).' and accountid='._q($GLOBALS['Auth']->getAccountID()).' and parentuserid='._q($rootID);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        while(!$rs->EOF)
        {
            $temp = array();
            $temp['userid'] = $rs->fields['userid'];
            $temp['username'] = $rs->fields['username'];
            $temp['name'] = $rs->fields['name'];
            $temp['surname'] = $rs->fields['surname'];
            $temp['tab'] = $tab;

            $userTree[] = $temp;

            // look for children
            $this->getTreeOfUsers($rs->fields['userid'], $userTree, $tab.$tabLevel, $tabLevel, $maxLevel-1);

            $rs->MoveNext();
        }
    }

    //--------------------------------------------------------------------------

    function getUsersAsRs()
    {
        if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_NETWORK)
            return $this->_getUsersAsRsNetwork();
        else
            return $this->_getUsersAsRs();
    }

    //--------------------------------------------------------------------------

    function _getUsersAsRs()
    {
        $sql = 'select * from wd_g_users '.
               'where deleted=0 '.
               '  and rtype='._q(USERTYPE_USER).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER)).
               ' order by rstatus, surname, name, username';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return $rs;
    }

    //--------------------------------------------------------------------------

    function _getUsersAsRsNetwork()
    {
        $sql = 'select distinct u.* '.
               'from wd_g_users u, wd_pa_affiliatescampaigns ac, wd_pa_campaigns c '.
               'where c.accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and c.campaignid=ac.campaignid'.
               '  and ac.affiliateid=u.userid'.
               '  and u.deleted=0 '.
               '  and u.rtype='._q(USERTYPE_USER).
               '  and u.accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return $rs;
    }

    //--------------------------------------------------------------------------

    function getUserInfoShort($userid)
    {
        $sql = 'select * from wd_g_users '.
               'where deleted=0 '.
               '  and userid='._q($userid).
               '  and rtype='._q(USERTYPE_USER).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if(!$rs->EOF)
        {
            $temp = array();

            $temp['userid'] = $rs->fields['userid'];
            $temp['name'] = $rs->fields['name'];
            $temp['surname'] = $rs->fields['surname'];
            $temp['username'] = $rs->fields['username'];

            return $temp;
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function getParentUserId($userid)
    {
        $sql = 'select parentuserid from wd_g_users '.
               'where deleted=0 '.
               '  and userid='._q($userid).
               '  and rtype='._q(USERTYPE_USER).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if(!$rs->EOF)
        {
            return $rs->fields['parentuserid'];
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function getUserId($username = '', $userid = '', $refid = '') {
        $sql = 'select userid from wd_g_users '.
               'where deleted=0 ';
        if ($username != '')
            $sql .= '  and username='._q($username);
        if ($userid != '')
            $sql .= '  and userid='._q($userid);
        if ($refid != '')
            $sql .= '  and refid='._q($refid);
        $sql .= '  and rtype='._q(USERTYPE_USER).
                '  and accountid='._q($GLOBALS['Auth']->getAccountID(USERTYPE_USER));

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if ((!$rs) || ($rs->EOF)) {
            return false;
        }

        return $rs->fields['userid'];
    }

}
?>
