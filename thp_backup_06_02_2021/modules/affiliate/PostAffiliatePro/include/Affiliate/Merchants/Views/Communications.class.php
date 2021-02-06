<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_Communications extends QUnit_UI_TemplatePage
{
    var $blCommunications;
    var $blAffiliate;
    
    function Affiliate_Merchants_Views_Communications() {
        $this->blCommunications = QUnit_Global::newObj('QCore_Bl_Communications');
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->viewBroadcastMessage =& QUnit_Global::newObj('Affiliate_Merchants_Views_BroadcastMessage');
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_COMMUNICATION,'index.php?md=Affiliate_Merchants_Views_Communications');
    }

    function initPermissions()
    {
        $this->modulePermissions['edit'] = 'aff_comm_communications_modify';
        $this->modulePermissions['delete'] = 'aff_comm_communications_modify';
        $this->modulePermissions['view'] = 'aff_comm_communications_view';
        $this->modulePermissions['send'] = 'aff_comm_broadcast_email_use';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        $this->assign('a_form_preffix', 'c_');
        $this->assign('a_form_name', 'FilterForm');
        
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'edit':
                    if($this->processEditMessage())
                        return;
                break;
            }
        }
     
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'view':
                    if($this->drawFormViewMessage())
                        return;
                break;

                case 'edit':
                    if($this->drawFormEditMessage())
                        return;
                break;
                
                case 'activate':
                    if($this->processChangeState(true))
                        return;
                break;
                
                case 'deactivate':
                    if($this->processChangeState(false))
                        return;
                break;

                case 'delete':
                    if($this->processDeleteMessage())
                        return;
                break;
            }
        }

        $this->showMessages();
    }
    
    //------------------------------------------------------------------------
    
    function showMessages($SuperAdminsPanel = false)
    {
        // sorting
        $orderby = '';
        $a = array("m.messageid", "m.dateinserted", "m.title", "m.rtext",
                   "m.rtype", "users_count", "mu.email");
        
        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
            $orderby = " order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder']; 
        else
            $orderby = " order by m.dateinserted desc"; 
        
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strstr($k, 'c_type') !== false && ($_REQUEST['type_comitted'] == '1')) {
                continue;
            }
            if(strpos($k, 'c_') === 0 && !isset($_REQUEST[$k]))
                $_REQUEST[$k] = $v;
        }

        $_REQUEST['c_title'] = preg_replace('/[\'\"]/', '', $_REQUEST['c_title']);
        $_REQUEST['c_type'] = preg_replace('/[\'\"]/', '', $_REQUEST['c_type']);

        //--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
        $_REQUEST['numrows'] = $_REQUEST['numrows'];
        if($_REQUEST['c_type'] == '') $_REQUEST['c_type'] = array();
        if($_REQUEST['c_day1'] == '') $_REQUEST['c_day1'] = date("j");
        if($_REQUEST['c_month1'] == '') $_REQUEST['c_month1'] = date("n");
        if($_REQUEST['c_year1'] == '') $_REQUEST['c_year1'] = date("Y");
        if($_REQUEST['c_day2'] == '') $_REQUEST['c_day2'] = date("j");
        if($_REQUEST['c_month2'] == '') $_REQUEST['c_month2'] = date("n");
        if($_REQUEST['c_year2'] == '') $_REQUEST['c_year2'] = date("Y");
        if($_REQUEST['c_userid'] == '') $_REQUEST['c_userid'] = '_';
        if($_REQUEST['c_timeselect'] == '') $_REQUEST['c_timeselect'] = TIME_PRESET;
        if($_REQUEST['c_timepreset'] == '') $_REQUEST['c_timepreset'] = TIME_TODAY;
        
        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['c_title'] = $_REQUEST['c_title'];
        $_SESSION['c_text'] = $_REQUEST['c_text'];
        $_SESSION['c_email'] = $_REQUEST['c_email'];
        $_SESSION['c_type'] = $_REQUEST['c_type'];
        $_SESSION['c_day1'] = $_REQUEST['c_day1'];
        $_SESSION['c_month1'] = $_REQUEST['c_month1'];
        $_SESSION['c_year1'] = $_REQUEST['c_year1'];
        $_SESSION['c_day2'] = $_REQUEST['c_day2'];
        $_SESSION['c_month2'] = $_REQUEST['c_month2'];
        $_SESSION['c_year2'] = $_REQUEST['c_year2'];
        $_SESSION['c_userid'] = $_REQUEST['c_userid'];
        $_SESSION['c_timeselect'] = $_REQUEST['c_timeselect'];
        $_SESSION['c_timepreset'] = $_REQUEST['c_timepreset'];

        $this->assign('a_curyear', date("Y"));
        $this->assign_md();
        
        // process time filter
        if($_REQUEST['c_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['c_timepreset'], 'c_'));
        }
        
        $this->getUsersForFilter();

        $this->addContent('communications_filter');

        //------------------------------------------------
        // build where statement
        $where = ' where m.deleted=\'0\'';
        if($SuperAdminsPanel) {
        	if($GLOBALS['Auth']->getSetting('Merch_display_news') != '1')
            	$where .= ' and m.rtype='._q(SA_MESSAGETYPE_EMAIL).' and not (m.rtype='._q(SA_MESSAGETYPE_NEWS).') ';
        	else 
	        	$where .= ' and (m.rtype='._q(SA_MESSAGETYPE_EMAIL).' or m.rtype='._q(SA_MESSAGETYPE_NEWS).') ';
        } else {
        	if($GLOBALS['Auth']->getSetting('Aff_display_news') != '1')
            	$where .= ' and m.rtype='._q(MESSAGETYPE_EMAIL).' and not (m.rtype='._q(MESSAGETYPE_NEWS).') ';
        	else 
	        	$where .= ' and (m.rtype='._q(MESSAGETYPE_EMAIL).' or m.rtype='._q(MESSAGETYPE_NEWS).') ';
        }
        
        if($GLOBALS['Auth']->getSetting('Aff_display_news') == '1') {
            if(count($_REQUEST['c_type']) > 0) {
                $where .= " and m.rtype in (".implode(',', $_REQUEST['c_type']).")";
            } else {
                $where .= ' and m.rtype is NULL';
            }
        }
        
        if ($_REQUEST['c_advanced_filter_show'] == '1') {
            if(($_REQUEST['c_userid'] != '') && ($_REQUEST['c_userid'] != '_'))
                $where .= ' and mu.userid='._q($_REQUEST['c_userid']);
            if($_REQUEST['c_title'] != '')
                $where .= ' and m.title like \'%'._q_noendtags($_REQUEST['c_title']).'%\'';
            if($_REQUEST['c_text'] != '' && $_REQUEST['c_text'] != '_')
                $where .= ' and m.rtext like \'%'._q_noendtags($_REQUEST['c_text']).'%\'';
            if($_REQUEST['c_email'] != '' && $_REQUEST['c_email'] != '_')
                $where .= ' and mu.email like \'%'._q_noendtags($_REQUEST['c_email']).'%\'';
        }
            
        $where .= ' and ('.sqlToDays('m.dateinserted').' >= '.sqlToDays($_REQUEST['c_year1'].'-'.$_REQUEST['c_month1'].'-'.$_REQUEST['c_day1']).')'.
                  ' and ('.sqlToDays('m.dateinserted').' <= '.sqlToDays($_REQUEST['c_year2'].'-'.$_REQUEST['c_month2'].'-'.$_REQUEST['c_day2']).')';
		if(!$SuperAdminsPanel)                  
        	$where .= ' and m.accountid='._q($GLOBALS['Auth']->getAccountID());

        $groupby = ' group by m.messageid ';
        //------------------------------------------------
        // get total number of records
        $sql = 'select count(distinct m.messageid) as count '.
               'from wd_g_messages m left join wd_g_messagestousers mu on m.messageid=mu.messageid ';
        $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql.$where.$groupby, __FILE__, __LINE__);
            return;
        }

        $limitOffset = initPaging($rs->fields['count']);

        //------------------------------------------------
        // get records
        $sql = 'select m.*, count(messagetouserid) as users_count, '.
               '       mu.messagetouserid, mu.email '.
               'from wd_g_messages m left join wd_g_messagestousers mu on m.messageid=mu.messageid ';
        $sql .= $where.$groupby.$orderby;
        $rs = QCore_Sql_DBUnit::selectLimit($sql, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return;
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rs);
        $this->assign('a_list_data', $list_data);
        $this->pageLimitsAssign();

        if($SuperAdminsPanel)
        	$params = array('accountid' => '');
        else
        	$params = array('accountid' => $GLOBALS['Auth']->getAccountID());

        $message_users = QCore_Bl_Communications::getUsersOfMessageAsArray($params);
        $this->assign('a_message_users', $message_users);

        if ($SuperAdminsPanel) {
        	$temp_perm['edit'] = $temp_perm['delete'] = $temp_perm['view'] = true;
        } else {
        	$temp_perm['edit'] = $this->checkPermissions('edit');
        	$temp_perm['delete'] = $this->checkPermissions('delete');
        	$temp_perm['view'] = $this->checkPermissions('view');
        }

        $this->assign('a_action_permission', $temp_perm);

        $this->addContent('communications_list');
    }

    //------------------------------------------------------------------------

    function loadMessageInfo()
    {
        $messageid = preg_replace('/[\'\"]/', '', $_REQUEST['mid']);
        
        $params = array('messageid' => $messageid,
                        'accountid' => $GLOBALS['Auth']->getAccountID()
                       );

        $this->blCommunications->loadMessageInfoToPost($params);
    }

    //------------------------------------------------------------------------
    
    function drawFormViewMessage()
    {
        $messageid = preg_replace('/[\'\"]/', '', $_REQUEST['mid']);
        
        $this->loadMessageInfo();
               
        $_POST['header'] = L_G_VIEWMESSAGE;

        $params = array('messageid' => $messageid,
                        'accountid' => $GLOBALS['Auth']->getAccountID()
                       );

        $message_users = $this->blCommunications->getUsersOfMessageAsArray($params);
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($message_users[$messageid]);
        $this->assign('a_list_data', $list_data);

        $this->assign('a_message_users_count', count($message_users[$messageid]));
		$this->assign_md();
        
        $this->addContent('message_view');

        return true;
    }
    
    //------------------------------------------------------------------------

    function drawFormEditMessage()
    {
        $messageid = preg_replace('/[\'\"]/', '', $_REQUEST['mid']);
    
        $params = array('messageid' => $messageid,
                        'messagetype' => MESSAGETYPE_EMAIL,
                        'checknegate' => true
                       );

        if($this->blCommunications->checkMessageType($params) === false)
        {
            QUnit_Messager::setErrorMessage(L_G_EMAIL_CAN_NOT_EDIT);

            $this->closeWindow('Affiliate_Merchants_Views_Communications');
            $this->assign_md();
            $this->addContent('closewindow');

            return true;
        }
    
        if($_POST['commited'] != 'yes')
        {
            $this->loadMessageInfo();
        }

        $_POST['header'] = L_G_EDITMESSAGE;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'edit';  

        $params = array('messageid' => $messageid,
                        'accountid' => $GLOBALS['Auth']->getAccountID()
                       );

        $message_users = $this->blCommunications->getOnlyUserIDsOfMessageAsArray($params);
        $this->assign('a_list_data3', $message_users);

        $this->viewBroadcastMessage->showForm();
        $this->setContent($this->viewBroadcastMessage->getContent());

        return true;
    }

    //------------------------------------------------------------------------

    function processDeleteMessage()
    {
        $mid = preg_replace('/[\'\"]/', '', $_REQUEST['mid']);
    
        $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                        'messageid' => $mid
                       );
        
        $this->blCommunications->deleteMessage($params);

        return false;
    }
    
    //------------------------------------------------------------------------

    function processChangeState($activate)
    {
        $mid = preg_replace('/[\'\"]/', '', $_REQUEST['mid']);
        
        $this->blCommunications->changeMessageActiveStatus($mid, $activate);

        return false;
    }

    //------------------------------------------------------------------------
    
    function processEditMessage()
    {
        $mid = preg_replace('/[\'\"]/', '', $_POST['mid']);

        $title = $_POST['emailsubject']; //$_POST['title'];
        $text = $_POST['emailtext']; //$_POST['rtext'];
    
        // check correctness of the fields
        checkCorrectness($_POST['emailsubject'], $title, L_G_TITLE, CHECK_EMPTY);
        checkCorrectness($_POST['emailtext'], $text, L_G_MESSAGE_TEXT, CHECK_EMPTY);

        if(QUnit_Messager::getErrorMessage() != '') return false;
        
        $sql = 'update wd_g_messages '.
               'set title='._q($title).
               '   ,rtext='._q($text).
               ' where messageid='._q($mid).
               '   and accountid='._q($GLOBALS['Auth']->getAccountID()).
               '   and deleted=\'0\'';
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        else
        {
            QUnit_Messager::setOkMessage(L_G_MESSAGE_EDITED);

            $this->closeWindow('Affiliate_Merchants_Views_Communications');
            $this->assign_md();
            $this->addContent('closewindow');

            return true;
        }
    }
    
    //------------------------------------------------------------------------
    
    function assign_md()
    {
    	$this->assign('a_md', 'Affiliate_Merchants_Views_Communications');
    }
    
    //--------------------------------------------------------------------------

    function getUsersForFilter()
    {
        $usersRs = $this->blAffiliate->getUsersAsRs();
        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($usersRs);
        
        $this->assign('a_list_users', $list_data);
    }
}
?>
