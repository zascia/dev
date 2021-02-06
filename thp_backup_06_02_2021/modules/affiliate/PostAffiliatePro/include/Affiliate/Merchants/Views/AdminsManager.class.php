<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QCore_Bl_GlobalDb');
QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Views_TransactionManager');

class Affiliate_Merchants_Views_AdminsManager extends QUnit_UI_ListPage
{

    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Views_AdminsManager() {
        $this->blAdminInfo =& QUnit_Global::newObj('Affiliate_Merchants_Bl_AdminInfo');

        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_ADMINS,'index.php?md=Affiliate_Merchants_Views_AdminsManager&action=main');
    }

    //--------------------------------------------------------------------------

    function initPermissions()
    {
        $this->modulePermissions['insert'] = 'aff_tool_admins_modify';
        $this->modulePermissions['update'] = 'aff_tool_admins_modify';
        $this->modulePermissions['add_new'] = 'aff_tool_admins_modify';
        $this->modulePermissions['edit'] = 'aff_tool_admins_modify';
        $this->modulePermissions['delete'] = 'aff_tool_admins_modify';
        $this->modulePermissions['change_status'] = 'aff_tool_admins_modify';
        $this->modulePermissions['view'] = 'aff_tool_admins_view';
        $this->modulePermissions['viewprofiles'] = 'aff_tool_user_profiles_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['postaction']))
        {
            switch($_POST['postaction'])
            {
                case 'insert':
                    if($this->processInsertAdmin())
                        return;
                    break;

                case 'update':
                    if($this->processUpdateAdmin())
                        return;
                    break;
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'add_new':
                    $this->navigationAddURL(L_G_ADMINSMANAGEMENT,'index.php?md=Affiliate_Merchants_Views_AdminsManager');
                    $this->navigationAddURL(L_G_ADD_ADMIN,'index.php?md=Affiliate_Merchants_Views_AdminsManager&action=add_new');
                    if($this->drawFormAddAdmin())
                        return;
                    break;

                case 'edit':
                    $this->navigationAddURL(L_G_ADMINSMANAGEMENT,'index.php?md=Affiliate_Merchants_Views_AdminsManager');
                    $this->navigationAddURL(L_G_EDIT_ADMIN,'index.php?md=Affiliate_Merchants_Views_AdminsManager&action=edit');
                    if($this->drawFormEditAdmin())
                        return;
                    break;

                case 'delete':
                    if($this->processDeleteAdmin())
                        return;
                    break;

                case 'change_status':
                    if($this->processChangeStatusAdmin())
                        return;
                    break;

                case 'set_main_affiliate_manager':
                    if($this->processSetMainAffiliateManager())
                        return;
                    break;

                case 'main':
                    if($this->showMainScreen())
                        return;
                    break;
            }

            switch($_POST['massaction'])
            {
                case 'suppress':
                    $this->navigationAddURL(L_G_ADMINSMANAGEMENT,'index.php?md=Affiliate_Merchants_Views_AdminsManager');
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED))
				        return;
                    break;

                case 'approve':
                    $this->navigationAddURL(L_G_ADMINSMANAGEMENT,'index.php?md=Affiliate_Merchants_Views_AdminsManager');
                    if($this->processChangeState(AFFSTATUS_APPROVED))
                        return;
                    break;

                case 'delete':
                    if($this->processDelete())
                        return;
                    break;

                case 'invite':
                    if($this->drawInviteAffiliate())
                        return;
                    break;

                case 'sendmail':
                    if($this->processSendMailToAffiliates())
                        return;
                    break;
            }
        }

        $this->navigationAddURL(L_G_ADMINSMANAGEMENT,'index.php?md=Affiliate_Merchants_Views_AdminsManager');
        $this->showAdmins();
    }

    //------------------------------------------------------------------------

    function showAdmins()
    {
        $orderby = '';

        $a = array('a.userid', 'a.name', 'a.surname', 'a.username', 'a.dateinserted',
                   'a.rstatus', 'account_name', 'userprofile_name');

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
        else
            $orderby = ' order by a.username';

        $where = ' where a.accountid=ac.accountid'.
                 '   and ac.accountid='._q($GLOBALS['Auth']->getAccountID()).
                 '   and a.userprofileid=up.userprofileid'.
                 '   and a.rtype='._q(USERTYPE_ADMIN);

        $limitOffset = initPaging($this->getTotalNumberOfRecords('select count(*) as count from wd_g_users a, wd_g_accounts ac, wd_g_userprofiles up '.$where));

        $sql = 'select a.*, ac.name as account_name, up.name as userprofile_name '.
               'from wd_g_users a, wd_g_accounts ac, wd_g_userprofiles up';

        $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        if (!$rs) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return;
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rs);
        $this->initViews();

        $this->assign('a_list_data', $list_data);
        $this->assign('a_numrows', $rs->PO_RecordCount('wd_g_users', $where));

        $temp_perm['add_new'] = $this->checkPermissions('add_new');
        $temp_perm['edit'] = $this->checkPermissions('edit');
        $temp_perm['delete'] = $this->checkPermissions('delete');
        $temp_perm['change_status'] = $this->checkPermissions('change_status');

        $this->assign('a_action_permission', $temp_perm);

        $settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
        $this->assign('main_affiliate_manager', $settings['Aff_main_affiliate_manager']);

        $this->addContent('admins_show');
    }

    //--------------------------------------------------------------------------

    function showMainScreen() {
        $this->addContent('admins_main');

        return true;
    }

    //--------------------------------------------------------------------------

    function printActions($row)
    {
        $actions = array();
        if($this->checkPermissions('edit')) {
            $actions[] = array('id'     => 'edit',
                                    'img'    => 'icon_edit.gif',
                                    'desc'   => L_G_EDIT,
                                    'action' => "editAdmin('".$row['userid']."');" );
        }
        if($GLOBALS['Auth']->getUserID() != $row['userid']) {
            if($this->checkPermissions('change_status')) {
                if($row['rstatus'] == STATUS_ENABLED) {
                    $actions[] = array('id'     => 'enable',
                                            'img'    => 'icon_suppress.gif',
                                            'desc'   => L_G_DISABLE,
                                            'action' => "changeAdminStatus('".$row['userid']."');");
                } else {
                    $actions[] = array('id'     => 'disable',
                                            'img'    => 'icon_approve.gif',
                                            'desc'   => L_G_ENABLE,
                                            'action' => "changeAdminStatus('".$row['userid']."');");
                }
            }
            if($this->checkPermissions('delete')) {
                $actions[] = array('id'     => 'delete',
                                        'img'    => 'icon_delete.gif',
                                        'desc'   => L_G_DELETE,
                                        'action' => "deleteAdmin('".$row['userid']."');" );
            }
        }
        $this->initTemporaryTE();
        $this->temporaryAssign('a_actions', $actions);
        $this->temporaryAssign('a_action_count', count($actions));
        print $this->temporaryFetch('actions_icon');
    }

	function getListViewName()
	{
		return 'am';
	}
    //--------------------------------------------------------------------------

    function loadAdminInfo()
    {
        $adminid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);

        if (($info = $this->blAdminInfo->getAdminInfo($adminid)) == false) {
            return false;
        }

        foreach ($info as $key => $value) {
            $_POST[$key] = $value;
        }

        $this->assign('a_info_list', $info['info_list']);
        $this->assign('a_selected', explode(',', $info['selected_info']));
    }

    //------------------------------------------------------------------------

    function drawFormEditAdmin()
    {
        if($_POST['commited'] != 'yes') {
            $this->loadAdminInfo();
        }

        if($_POST['aid'] == '') $_POST['aid'] = $_REQUEST['aid'];

        $_POST['header'] = L_G_EDIT_ADMIN;
        $_POST['description'] = L_G_ADMINEDIT_DESCRIPTION;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'update';

        $settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
/*        echo "1:".$settings['Aff_main_affiliate_manager'];
        echo "2:".$_POST['aid'];*/

        $this->assign('is_main_affiliate_manager', $_POST['aid'] == $settings['Aff_main_affiliate_manager'] ? true : false);

        $this->drawFormAddAdmin();

        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormAddAdmin()
    {
        if(!isset($_POST['action']))
            $_POST['action'] = 'add_new';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'insert';

        if(!isset($_POST['header'])) {
            $_POST['header'] = L_G_ADD_ADMIN;
            $_POST['description'] = L_G_ADMINADD_DESCRIPTION;
        }

        $_POST['welcome_msg'] = stripslashes($_POST['welcome_msg']);
        $_POST['custom_html'] = stripslashes($_POST['custom_html']);

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($this->getUserProfilesAsArray());

        $this->assign('a_list_data', $list_data);

        $this->assign('a_info_list', $this->blAdminInfo->getInfoList());
        $this->assign('a_selected', explode(',', $_POST['selected_info']));

        $this->addContent('admins_edit');

        return true;
    }

    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================

    function processChangeStatusAdmin()
    {
        $adminid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);

        if($GLOBALS['Auth']->getUserID() != $adminid)
        {
            $sql = 'select rstatus from wd_g_users '.
                   'where userid='._q($adminid).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            if(!$rs || $rs->EOF) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            else
            {
                $new_status = '';
                if($rs->fields['rstatus'] == STATUS_ENABLED) $new_status = STATUS_DISABLED;
                else if($rs->fields['rstatus'] == STATUS_DISABLED) $new_status = STATUS_ENABLED;

                if($new_status != '')
                {
                    $sql = 'update wd_g_users set rstatus = '._q($new_status).
                           ' where userid = '._q($adminid).
                           '  and accountid='._q($GLOBALS['Auth']->getAccountID());
                    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

                    if(!$rs) {
                        QUnit_Messager::setErrorMessage(L_G_DBERROR);
                        return false;
                    }

                    $this->redirect('Affiliate_Merchants_Views_AdminsManager');
                }
            }
        }

        return false;
    }

    function processSetMainAffiliateManager()
    {
        $adminid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);


       // $this->redirect('Affiliate_Merchants_Views_AdminsManager');

        return false;
    }

    //--------------------------------------------------------------------------

    function processDeleteAdmin()
    {
        $adminid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);

        if(AFF_DEMO == 1 && $adminid == 'merch001') {
            return false;
        }

        if($GLOBALS['Auth']->getUserID() != $adminid)
        {
            $sql = 'delete from wd_g_users '.
                   'where userid='._q($adminid).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            if (!$rs) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function processUpdateAdmin()
    {
        // protect against script injection
        $pusername = preg_replace('/[\'\"]/', '', $_POST['username']);
        $ppwd1 = preg_replace('/[\'\"]/', '', $_POST['pwd1']);
        $ppwd2 = preg_replace('/[\'\"]/', '', $_POST['pwd2']);
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $psurname = preg_replace('/[\'\"]/', '', $_POST['surname']);
        $pstatus = preg_replace('/[^0-9]/', '', $_POST['rstatus']);
        $puserprofile = preg_replace('/[\'\"]/', '', $_POST['userprofile']);
        $AdminID = preg_replace('/[\'\"]/', '', $_POST['aid']);

        $protectedVars = array();
        $protectedVars['Aff_user_icq'] = preg_replace('/[\'\"]/', '', $_POST['icq']);
        $protectedVars['Aff_user_msn'] = preg_replace('/[\'\"]/', '', $_POST['msn']);
        $protectedVars['Aff_user_skype'] = preg_replace('/[\'\"]/', '', $_POST['skype']);
        $protectedVars['Aff_user_yahoomessenger'] = preg_replace('/[\'\"]/', '', $_POST['yahoomessenger']);
        $protectedVars['Aff_user_googletalk'] = preg_replace('/[\'\"]/', '', $_POST['googletalk']);
        $protectedVars['Aff_user_other_name'] = preg_replace('/[\'\"]/', '', $_POST['other_name']);
        $protectedVars['Aff_user_other_contact'] = preg_replace('/[\'\"]/', '', $_POST['other_contact']);
        $protectedVars['Aff_user_photo_url'] = preg_replace('/[\'\"]/', '', $_POST['photo_url']);
        $protectedVars['Aff_user_welcome_msg'] = $_POST['welcome_msg'];
        $protectedVars['Aff_user_custom_html'] = $_POST['custom_html'];
        $protectedVars['Aff_user_selected_info'] = preg_replace('/[\'\"]/', '', $_POST['selected_info']);

        // check correctness of the fields
        checkCorrectness($_POST['username'], $pusername, L_G_USER_NAME, CHECK_EMPTYALLOWED);
        if($_POST['username'] != '' && $this->checkAdminExists($_POST['username'], $AdminID))
            QUnit_Messager::setErrorMessage(L_G_UNAMEEXISTS);

        checkCorrectness($_POST['pwd1'], $ppwd1, L_G_PWD1, CHECK_ALLOWED);
        checkCorrectness($_POST['pwd2'], $ppwd2, L_G_PWD2, CHECK_ALLOWED);
        if($_POST['pwd1'] != $_POST['pwd2'])
            QUnit_Messager::setErrorMessage(L_G_PWDDONTMATCH);

        if($AdminID != $GLOBALS['Auth']->getUserID())
            checkCorrectness($_POST['rstatus'], $pstatus, L_G_STATUS, CHECK_EMPTYALLOWED, CHECK_NUMBER);
        checkCorrectness($_POST['userprofile'], $puserprofile, L_G_USER_PROFILE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_ALLOWED);
        checkCorrectness($_POST['surname'], $psurname, L_G_SURNAME, CHECK_ALLOWED);

        // process file upload
        if ( ($photo = $this->processPhotoUpload($AdminID)) != false ) {
            $_POST['photo_url'] = $protectedVars['Aff_user_photo_url'] = $photo;
        }

        if(QUnit_Messager::getErrorMessage() != '')
        {
        }
        else
        {
            if(AFF_DEMO == 1 && $AdminID == 'merch001') {
                $ppwd = $ppwd1;
                $sql = 'update wd_g_users '.
                       'set name='._q($pname).
                       '   ,surname='._q($psurname).
                        ' where userid='._q($AdminID).
                        '   and accountid='._q($GLOBALS['Auth']->getAccountID());
            } else {
                $ppwd = $ppwd1;
                $sql = 'update wd_g_users '.
                       'set username='._q($pusername).
                       '   ,name='._q($pname).
                       '   ,surname='._q($psurname);
                if($ppwd != '') $sql .= ',rpassword='._q($ppwd);
                if($AdminID != $GLOBALS['Auth']->getUserID()) $sql .= '  ,rstatus='._q($pstatus);
                $sql .= '  ,userprofileid='._q($puserprofile).
                        ' where userid='._q($AdminID).
                        '   and accountid='._q($GLOBALS['Auth']->getAccountID());
            }

            // save changes of admin to db
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$ret) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }

            $globalDb =& QCore_Bl_GlobalDb::getInstance();
            $params = array('userid' => $AdminID,
                            'liteaccountid' => $GLOBALS['Auth']->getLiteAccountId(),
                            'username' => $pusername,
                            'refid' => '',
                            'password' => $ppwd);
            $globalDb->updateUser($params);

            // save changes to settings
            if(isset($_POST['main_affiliate_manager'])) {
                QCore_Settings::_update('Aff_main_affiliate_manager', $AdminID, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
            } else {
                $settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
                if($_POST['aid'] == $settings['Aff_main_affiliate_manager']) {
                    QCore_Settings::_update('Aff_main_affiliate_manager', "", SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
                }
            }


            foreach ($protectedVars as $key => $value) {
                QCore_Settings::_update($key, $value, SETTINGTYPE_ADMIN, $GLOBALS['Auth']->getAccountID(), $AdminID);
            }

            if (QUnit_Messager::getErrorMessage() != '') {
                return;
            }

            QUnit_Messager::setOkMessage(L_G_ADMIN_EDITED);
            //QUnit_UI_TemplatePage::redirect('Affiliate_Merchants_Views_AdminsManager');

            return false;
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function processInsertAdmin()
    {
        // protect against script injection
        $pusername = preg_replace('/[\'\"]/', '', $_POST['username']);
        $ppwd1 = preg_replace('/[\'\"]/', '', $_POST['pwd1']);
        $ppwd2 = preg_replace('/[\'\"]/', '', $_POST['pwd2']);
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $psurname = preg_replace('/[\'\"]/', '', $_POST['surname']);
        $pstatus = preg_replace('/[^0-9]/', '', $_POST['rstatus']);
        $puserprofile = preg_replace('/[\'\"]/', '', $_POST['userprofile']);
        $AdminID = QCore_Sql_DBUnit::createUniqueID('wd_g_users', 'userid');

        $protectedVars = array();
        $protectedVars['Aff_user_icq'] = preg_replace('/[\'\"]/', '', $_POST['icq']);
        $protectedVars['Aff_user_msn'] = preg_replace('/[\'\"]/', '', $_POST['msn']);
        $protectedVars['Aff_user_skype'] = preg_replace('/[\'\"]/', '', $_POST['skype']);
        $protectedVars['Aff_user_yahoomessenger'] = preg_replace('/[\'\"]/', '', $_POST['yahoomessenger']);
        $protectedVars['Aff_user_googletalk'] = preg_replace('/[\'\"]/', '', $_POST['googletalk']);
        $protectedVars['Aff_user_other_name'] = preg_replace('/[\'\"]/', '', $_POST['other_name']);
        $protectedVars['Aff_user_other_contact'] = preg_replace('/[\'\"]/', '', $_POST['other_contact']);
        $protectedVars['Aff_user_photo_url'] = preg_replace('/[\'\"]/', '', $_POST['photo_url']);
        $protectedVars['Aff_user_welcome_msg'] = $_POST['welcome_msg'];
        $protectedVars['Aff_user_custom_html'] = $_POST['custom_html'];
        $protectedVars['Aff_user_selected_info'] = preg_replace('/[\'\"]/', '', $_POST['selected_info']);

        // check correctness of the fields
        checkCorrectness($_POST['username'], $pusername, L_G_USER_NAME, CHECK_EMPTYALLOWED);

        if($_POST['username'] != '' && $this->checkAdminExists($_POST['username']))
            QUnit_Messager::setErrorMessage(L_G_UNAMEEXISTS);

        checkCorrectness($_POST['pwd1'], $ppwd1, L_G_PWD1, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['pwd2'], $ppwd2, L_G_PWD2, CHECK_EMPTYALLOWED);
        if($_POST['pwd1'] != $_POST['pwd2'])
            QUnit_Messager::setErrorMessage(L_G_PWDDONTMATCH);

        checkCorrectness($_POST['rstatus'], $pstatus, L_G_STATUS, CHECK_EMPTYALLOWED, CHECK_NUMBER);
        checkCorrectness($_POST['userprofile'], $puserprofile, L_G_USER_PROFILE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_ALLOWED);
        checkCorrectness($_POST['surname'], $psurname, L_G_SURNAME, CHECK_ALLOWED);

        // process file upload
        if ( ($photo = $this->processPhotoUpload($AdminID)) != false ) {
            $_POST['photo_url'] = $protectedVars['Aff_user_photo_url'] = $photo;
        }

        if(QUnit_Messager::getErrorMessage() != '') {
            return;
        }
        else
        {
            // save changes of admin to db
            $ppwd = $ppwd1;
            $sql = 'insert into wd_g_users '.
                   '(userid, username, rpassword, name, '.
                   'surname, dateinserted, rstatus, rtype, accountid, userprofileid)'.
                   ' values '.
                   '('._q($AdminID).','._q($pusername).','._q($ppwd).','._q($pname).
                   ','._q($psurname).','.sqlNow().','._q($pstatus).','._q(USERTYPE_ADMIN).
                   ','._q($GLOBALS['Auth']->getAccountID()).','._q($puserprofile).')';
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$ret) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }

            // save changes to settings
            foreach ($protectedVars as $key => $value) {
                QCore_Settings::_update($key, $value, SETTINGTYPE_ADMIN, $GLOBALS['Auth']->getAccountID(), $AdminID);
            }

            if (QUnit_Messager::getErrorMessage() != '') {
                return;
            }
            else
            {
                QUnit_Messager::setOkMessage(L_G_ADMIN_ADDED);
                QUnit_UI_TemplatePage::redirect('Affiliate_Merchants_Views_AdminsManager');
                return true;
            }
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function processPhotoUpload($adminId) {

        // check file upload
        if($_FILES['photo_file']['name'] != '') {
                $oUpload = QUnit_Global::newObj('QUnit_Net_FileUpload',  $GLOBALS['Auth']->getSetting('Aff_banners_dir'), $_FILES['photo_file'], '_x2g68t_photo_'.$adminId.'.'.substr(strrchr($_FILES['photo_file']['name'], '.'), 1));

                $oUpload->setAllowedTypes($GLOBALS['UPLOAD_ALLOWED_FILE_TYPES']);

                if($oUpload->handleUpload() === false) {
                    return false;
                }
        }
        return false;
    }

    //==========================================================================
    // OTHER FUNCTIONS
    //==========================================================================

    function checkAdminExists($username, $aid = '')
    {
        $sql = 'select * from wd_g_users '.
               'where username='._q($username).
               ' and rtype='._q(USERTYPE_ADMIN);
//               '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        if($aid != '') $sql .= ' and userid <> '._q($aid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF)
            return false;

        return true;
    }

    //--------------------------------------------------------------------------

    function getUserProfilesAsArray()
    {
        $sql = 'select * from wd_g_userprofiles '.
               'where rtype='._q(USERTYPE_ADMIN).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID()).
               ' order by name';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return array();
        }

        $ups = array();

        while(!$rs->EOF)
        {
            $temp = array();
            $temp['userprofileid'] = $rs->fields['userprofileid'];
            $temp['name'] = $rs->fields['name'];
            $ups[$rs->fields['userprofileid']] = $temp;

            $rs->MoveNext();
        }

        return $ups;
    }



	function getAvailableColumns()
	{
	    $col = array(
	        'userid' =>         array(L_G_AFFILIATEID, 'a.userid'),
	        'username' =>       array(L_G_SURNAME, 'a.username'),
	        'name' =>           array(L_G_NAME, 'a.surname'),
	        'account_name' => array(L_G_ACCOUNT, 'account_name'),
	        'userprofile_name' =>    array(L_G_USER_PROFILE, 'userprofile_name'),
	        'rstatus' =>        array(L_G_STATUS, 'a.rstatus'),
	        'approved' =>       array(L_G_JOINED, 'a.dateinserted'),
	        'reversed' =>       array(L_G_REVERSED, 'reversed'),
	        'actions' =>        array(L_G_ACTIONS, ''),
	    );

	    for ($i=1; $i<=5; $i++) {
	        if($GLOBALS['Auth']->settings['Aff_signup_data'.$i] == '1') {
	            $col['data'.$i] = array($GLOBALS['Auth']->settings['Aff_signup_data'.$i.'_name'], 'a.data'.$i);
	        }
	    }
	    return $col;
	}

	function initViews()
	{
		// create default view
		$viewColumns = array(
			'userid',
			'username',
			'name',
			'account_name',
			'userprofile_name',
			'approved',
			'rstatus',
			'approved',
			'actions'
		);
		$this->createDefaultView($viewColumns);

		$this->loadAvailableViews();

		$tplAvailableViews = array();
		foreach($this->availableViews as $objView)
		{
			$tplAvailableViews[$objView->dbid] = $objView->getName();
		}

		$this->assign('a_list_views', $this->tplAvailableViews);

		$this->applyView();
	}

    function createWhereOrderBy(&$orderby, &$where)
    {
        $orderby = '';
        $where = '';

        $a = array(
            'userid',
            'username',
            'name',
            'account_name',
            'userprofile_name',
            'approved',
            'rstatus',
            'approved',
            'actions'
        );

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
        {
            $orderby = " order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
        }
        else
        {
            $orderby = " order by t.dateinserted desc";
        }


        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'tm_') === 0 && !isset($_REQUEST[$k]))
            {
                $_REQUEST[$k] = $v;
            }
            if($k == 'numrows' && $_REQUEST[$k] == '')
            {
                $_REQUEST[$k] = $v;
            }
        }

        $showAllPending = false;
        if($_REQUEST['tmdl_status'] == 'allpending')
        {
            $showAllPending = true;

            // it was called from main profile, display all pending transactions
            $_REQUEST['tm_status'] = AFFSTATUS_NOTAPPROVED;
            $_REQUEST['tm_userid'] = '_';
            $_REQUEST['tm_transtype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();
        }


        if(!$showAllPending)
        {
            //--------------------------------------
            // get default settings for unset variables
            if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
            if($_REQUEST['tm_userid'] == '') $_REQUEST['tm_userid'] = '_';
            if($_REQUEST['tm_transtype'] == '') $_REQUEST['tm_transtype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();
            if($_REQUEST['tm_status'] == '') $_REQUEST['tm_status'] = array(AFFSTATUS_APPROVED, AFFSTATUS_NOTAPPROVED, AFFSTATUS_SUPRESSED);
            if($_REQUEST['tm_day1'] == '') $_REQUEST['tm_day1'] = date("j");
            if($_REQUEST['tm_month1'] == '') $_REQUEST['tm_month1'] = date("n");
            if($_REQUEST['tm_year1'] == '') $_REQUEST['tm_year1'] = date("Y");
            if($_REQUEST['tm_day2'] == '') $_REQUEST['tm_day2'] = date("j");
            if($_REQUEST['tm_month2'] == '') $_REQUEST['tm_month2'] = date("n");
            if($_REQUEST['tm_year2'] == '') $_REQUEST['tm_year2'] = date("Y");

            //--------------------------------------
            // put settings into session
            $_SESSION['numrows'] = $_REQUEST['numrows'];
            $_SESSION['tm_userid'] = $_REQUEST['tm_userid'];
            $_SESSION['tm_transtype'] = $_REQUEST['tm_transtype'];
            $_SESSION['tm_status'] = $_REQUEST['tm_status'];
            $_SESSION['tm_orderid'] = $_REQUEST['tm_orderid'];
            $_SESSION['tm_day1'] = $_REQUEST['tm_day1'];
            $_SESSION['tm_month1'] = $_REQUEST['tm_month1'];
            $_SESSION['tm_year1'] = $_REQUEST['tm_year1'];
            $_SESSION['tm_day2'] = $_REQUEST['tm_day2'];
            $_SESSION['tm_month2'] = $_REQUEST['tm_month2'];
            $_SESSION['tm_year2'] = $_REQUEST['tm_year2'];
        }

        $puserid = preg_replace('/[\'\"]/', '', $_REQUEST['tm_userid']);
        $porderid = preg_replace('/[\'\"]/', '', $_REQUEST['tm_orderid']);
        $pstatus = preg_replace('/[^0-9]/', '', $_REQUEST['tm_status']);

        $where = " where t.affiliateid=a.userid and a.accountid="._q($GLOBALS['Auth']->getAccountID())." and a.deleted=0 and a.rstatus in (".AFFSTATUS_APPROVED.",".AFFSTATUS_NOTAPPROVED.") ";

        if(!$showAllPending)
        {
            $where .= " and (".sqlToDays('t.dateinserted')." >= ".sqlToDays($_REQUEST['tm_year1']."-".$_REQUEST['tm_month1']."-".$_REQUEST['tm_day1']).")".
                      " and (".sqlToDays('t.dateinserted')." <= ".sqlToDays($_REQUEST['tm_year2']."-".$_REQUEST['tm_month2']."-".$_REQUEST['tm_day2']).")";
        }

        if($puserid != '_' && $puserid != '')
        {
            $where .= " and t.affiliateid="._q($puserid);
        }

        if($porderid != '')
        {
            $where .= " and orderid like '%"._q_noendtags($porderid)."%'";
        }

        if(is_array($_REQUEST['tm_transtype']) && count($_REQUEST['tm_transtype'])>0)
        {
            $where .= " and transtype in (".implode(',', $_REQUEST['tm_transtype']).")";
        }

        if($pstatus != '_' && $pstatus != '')
        {
            $where .= " and t.rstatus="._q($pstatus);
        }

        return true;
    }
}
?>
