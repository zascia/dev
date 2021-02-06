<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_BroadcastMessage extends QUnit_UI_TemplatePage
{
    var $blCommunications;

    function Affiliate_Merchants_Views_BroadcastMessage() {
        $this->blCommunications = QUnit_Global::newObj('QCore_Bl_Communications');
    }

    function initPermissions()
    {
        $this->modulePermissions['broadcast'] = 'aff_comm_broadcast_email_use';
        $this->modulePermissions['view'] = 'aff_comm_broadcast_email_use';

        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_BROADCAST,'index.php?md=Affiliate_Merchants_Views_BroadcastMessage');
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'broadcast':
                    if($this->processBroadcastMessage())
                        return;
                break;

                case 'savemessage':
                    if($this->processSaveMessage())
                        return;
                break;
            }
        }
        switch($_REQUEST['action']) {
            case 'sendemails':
                $this->processSendEmails();
                return;
            break;

            case 'showresults':
                $this->showResults();
            break;
        }

        $this->showForm();
    }

    //--------------------------------------------------------------------------

    function processBroadcastMessage()
    {
        if( ( ($_POST['emailcategory'] == 'AFF_EMAIL_AF_DL_REP') || ($_POST['emailcategory'] == 'AFF_EMAIL_DAILY_REP') ) &&  !checkdate($_POST['rq_month'], $_POST['rq_day'], $_POST['rq_year'])) {
        	QUnit_Messager::setErrorMessage(L_G_INVALIDDATE);
        	return false;
        }
        if( ( ($_POST['emailcategory'] == 'AFF_EMAIL_AF_ML_REP') || ($_POST['emailcategory'] == 'AFF_EMAIL_MONTH_REP') ) &&  !checkdate($_POST['rq_month'], 1, $_POST['rq_year'])) {
        	QUnit_Messager::setErrorMessage(L_G_INVALIDDATE);
        	return false;
        }

        //if($_POST['message_type'] == MESSAGETYPE_EMAIL) {
        if($_POST['br_sheet'] == 'mail') {
            // process time filter
            if($_POST['brs_timeselect'] == TIME_PRESET) {
                $_POST = array_merge($_POST, getTimerangeForPreset($_POST['brs_timepreset'], 'brs_'));
            }
            $_REQUEST = array_merge($_REQUEST, $_POST);
            $_SESSION['emailPost'] = $_POST;
            $this->assign('a_sendemails', true);
            return false;
        }

        return $this->processBroadcastNews();
    }

    //--------------------------------------------------------------------------

    function processBroadcastNews()
    {
        if (!checkdate($_POST['br_month1'], $_POST['br_day1'], $_POST['br_year1'])) {
            QUnit_Messager::setErrorMessage(L_G_INVALID_DATEFROM);
            return false;
        }

        if (!checkdate($_POST['br_month2'], $_POST['br_day2'], $_POST['br_year2'])) {
            QUnit_Messager::setErrorMessage(L_G_INVALID_DATETO);
            return false;
        }

        $dateFrom  = mktime(0, 0, 0, $_POST['br_month1'], $_POST['br_day1'], $_POST['br_year1']);
        $dateTo    = mktime(23, 59, 59, $_POST['br_month2'], $_POST['br_day2'], $_POST['br_year2']);
        $active    = preg_replace('/[^0-1]/', '', $_POST['br_news_status']);
        $showToAll = preg_replace('/[^0-1]/', '', $_POST['br_news_show']);

        if ($dateFrom > $dateTo) {
            QUnit_Messager::setErrorMessage(L_G_DATEFROMISAFTERDATETO);
            return false;
        }

        if(get_magic_quotes_gpc())
        {
            $_POST['emailsubject'] = stripslashes($_POST['emailsubject']);
            $_POST['emailtext'] = stripslashes($_POST['emailtext']);
        }

        $users = explode(",", $_POST['selectedusers']);
        $subject = $_POST['emailsubject'];
        $text = $_POST['emailtext'];
        if ($showToAll == "1") {
            // replace $Date and $Time for news before storing to DB
            $objCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');
            $strs = array('title' => $subject, 'text' => $text);
            $strs = $objCommunications->replaceDateTime($strs);
            $subject = $strs['title'];
            $text = $strs['text'];

            $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                            'subject' => $subject,
                            'text' => $text,
                            'message_type' => MESSAGETYPE_NEWS,
                            'users' => '',
                            'datevalidfrom' => date("Y-m-d H:i:s", $dateFrom),
                            'datevalidto' => date("Y-m-d H:i:s", $dateTo),
                            'active' => $active,
                            'showtoall' => $showToAll
                           );

            if($objCommunications->insert($params) == false) return false;

            QUnit_Messager::setOkMessage(L_G_SAVE_OK);
            return false;
        }

        $chunkedUserIDs = my_array_chunk($users, WD_MAX_PROCESSED_IDS);

        foreach($chunkedUserIDs as $userIDsArray)
        {
            $userid_str = "('".implode("','", $userIDsArray)."')";

            if($userid_str == '') return false;

            $params = array('AccountID' => $GLOBALS['Auth']->getAccountID(),
                            'userid_str' => $userid_str
                           );
            $objUsers =& QUnit_Global::newObj('QCore_Bl_Users');
            $users = $objUsers->getUsersToBroadcastMessage($params, true);

            // replace $Date and $Time for news before storing to DB
            $objCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');
            $strs = array('title' => $subject, 'text' => $text);
            $strs = $objCommunications->replaceDateTime($strs);
            $subject = $strs['title'];
            $text = $strs['text'];

            $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                            'subject' => $subject,
                            'text' => $text,
                            'message_type' => MESSAGETYPE_NEWS,
                            'users' => $users,
                            'datevalidfrom' => date("Y-m-d H:i:s", $dateFrom),
                            'datevalidto' => date("Y-m-d H:i:s", $dateTo),
                            'active' => $active,
                            'showtoall' => $showToAll
                           );

            if(($mus = $objCommunications->insert($params)) == false) return false;
        }

        QUnit_Messager::setOkMessage(L_G_SAVE_OK);

        return false;
    }

    //--------------------------------------------------------------------------

    function processSaveMessage() {
        if (!checkdate($_POST['br_month1'], $_POST['br_day1'], $_POST['br_year1'])) {
            QUnit_Messager::setErrorMessage(L_G_INVALID_DATEFROM);
            return false;
        }

        if (!checkdate($_POST['br_month2'], $_POST['br_day2'], $_POST['br_year2'])) {
            QUnit_Messager::setErrorMessage(L_G_INVALID_DATETO);
            return false;
        }

        $dateFrom  = mktime(0, 0, 0, $_POST['br_month1'], $_POST['br_day1'], $_POST['br_year1']);
        $dateTo    = mktime(23, 59, 59, $_POST['br_month2'], $_POST['br_day2'], $_POST['br_year2']);
        $active    = preg_replace('/[^0-1]/', '', $_POST['br_news_status']);
        $showToAll = preg_replace('/[^0-1]/', '', $_POST['br_news_show']);

        if ($dateFrom > $dateTo) {
            QUnit_Messager::setErrorMessage(L_G_DATEFROMISAFTERDATETO);
            return false;
        }

        if(get_magic_quotes_gpc())
        {
            $_POST['emailsubject'] = stripslashes($_POST['emailsubject']);
            $_POST['emailtext'] = stripslashes($_POST['emailtext']);
        }

        $users = explode(",", $_POST['selectedusers']);
        $subject = $_POST['emailsubject'];
        $text = $_POST['emailtext'];

        $params = array('mid' => $_REQUEST['mid'],
                        'accountid' => $GLOBALS['Auth']->getAccountID(),
                        'subject' => $subject,
                        'text' => $text,
                        'message_type' => MESSAGETYPE_NEWS,
                        'users' => $users,
                        'datevalidfrom' => date("Y-m-d H:i:s", $dateFrom),
                        'datevalidto' => date("Y-m-d H:i:s", $dateTo),
                        'active' => $active,
                        'showtoall' => $showToAll,
                        'show_again' => $_REQUEST['show_again']
                        );

        if ($this->blCommunications->update($params)) {
            QUnit_Messager::setOkMessage(L_G_NEWS_UPDATED);
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function processSendEmails()
    {
        $_POST = $_SESSION['emailPost'];

        if(get_magic_quotes_gpc())
        {
            $_POST['emailsubject'] = stripslashes($_POST['emailsubject']);
            $_POST['emailtext'] = stripslashes($_POST['emailtext']);
        }

        $users = explode(",", $_POST['selectedusers']);
        $subject = $_POST['emailsubject'];
        $text = $_POST['emailtext'];

        if ($_REQUEST['start'] == '1') {
            $chunkedUserIDs = my_array_chunk($users, WD_MAX_PROCESSED_IDS);

            foreach($chunkedUserIDs as $userIDsArray)
            {
                $userid_str = "('".implode("','", $userIDsArray)."')";

                if($userid_str == '') return false;

                $params = array('AccountID' => $GLOBALS['Auth']->getAccountID(),
                                'userid_str' => $userid_str
                               );
                $objUsers =& QUnit_Global::newObj('QCore_Bl_Users');
                $users = $objUsers->getUsersToBroadcastMessage($params, true);

                $objCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');
                $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                                'subject' => $subject,
                                'text' => $text,
                                'message_type' => MESSAGETYPE_EMAIL,
                                'users' => $users
                            );

                if(($mus = $objCommunications->insert($params)) == false) return false;
            }

            // check if we need to compute stats
            $stat_const = explode("<br>", L_G_HLP_AFF_EMAIL_STATS_CONSTANTS);
            $_SESSION['sendemail_compute_stats'] = 0;
            foreach ($stat_const as $const) {
                if (strstr($text, $const) !== false) {
                    $_SESSION['sendemail_compute_stats'] = 1;
                    break;
                }
                if (strstr($subject, $const) !== false) {
                    $_SESSION['sendemail_compute_stats'] = 1;
                    break;
                }
            }

            // init
            $_SESSION['sendemail_ok_messages'] = array();
            $_SESSION['sendemail_error_messages'] = array();
            $_SESSION['emailToSend'] = 0;
		    Redirect_nomsg("index_popup.php?md=Affiliate_Merchants_Views_BroadcastMessage&action=sendemails", 0);
		    $this->assign('a_message', L_G_SENDINGEMAILS);
		    $this->addContent("sendemail_progress");
		    return false;
        }

        $emailToSend = $_SESSION['emailToSend'];
        $i = 0;
        $emailsSend = 0;
        $emailsCount = count($users);
        $maxTimeToRun = (ini_get('max_execution_time') == '') ? 20 : ini_get('max_execution_time') - 10;

        foreach($users as $userid)
        {
            if($i++ < $emailToSend) {
                continue;
            }

            $this->sendMessageByEmail($userid, $mus, $subject, $text);

            $emailsSend++;
            QUnit_Page::end_timer();
		    $timeRunning = QUnit_Page::getTimeGenerated();
		    // do we have time to send another email
		    if ($timeRunning + $timeRunning/$emailsSend > $maxTimeToRun) {
		        $_SESSION['emailToSend'] = $emailToSend + $emailsSend;
		        break;
		    }
        }

        if($emailToSend + $emailsSend < $emailsCount) {
            $this->assign('a_message', ($emailToSend + $emailsSend).' '.L_G_OF.' '.$emailsCount.' '.L_G_EMAILSSENT);
            Redirect_nomsg("index_popup.php?md=Affiliate_Merchants_Views_BroadcastMessage&action=sendemails", 0);
        } else {
            $this->assign('a_message', 'end');
        }

        $this->addContent("sendemail_progress");
        return false;
    }

    //--------------------------------------------------------------------------

    function sendMessageByEmail($userid, $mus, $tmplSubject, $tmplText)
    {
        $objUsers =& QUnit_Global::newObj('QCore_Bl_Users');
        if (($user = $objUsers->getUserData($userid)) == false)
            return false;

        $objCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');

        $subject = $tmplSubject;
        $text = $tmplText;

        switch ($_POST['emailcategory']) {
            case 'AFF_EMAIL_AF_DL_REP' :
                $objTimerangeStats =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TimerangeStatistics');
                $userstats = $objTimerangeStats->getTimerangeStats(
                        $user['userid'], '',
                        $_POST['rq_day'], $_POST['rq_month'], $_POST['rq_year'],
                        $_POST['rq_day'], $_POST['rq_month'], $_POST['rq_year'],
                        $GLOBALS['Auth']->getAccountID(),
                        $GLOBALS['Auth']->getSettings());
                        $userstats['ReportDateTimestamp'] = mktime (0,0,0,$_POST['rq_month'] , $_POST['rq_day'], $_POST['rq_year']);

                $objEmailTemplates =& QUnit_Global::newObj('QCore_EmailTemplates');
                $emaildata = $objEmailTemplates->replaceConstatntsInEmailMessage($user['userid'], $_POST['emailcategory'], $subject, $text, $userstats);
                $subject = $emaildata['subject'];
                $text = $emaildata['text'];
                break;
            case 'AFF_EMAIL_AF_ML_REP':
                $y = $_POST['rq_year'];
                $m = $_POST['rq_month'];
                $d1 = 1;
                $d2 = date("j", mktime (0,0,0,$m + 1,0,$y)); // last day of month

                $objTimerangeStats =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TimerangeStatistics');
                $data = $objTimerangeStats->getTimerangeStats(
                        $user['userid'], '',
                        $d1, $m, $y, $d2, $m, $y,
                        $GLOBALS['Auth']->getAccountID(),
                        $GLOBALS['Auth']->getSettings());
                $data['ReportDateTimestamp'] = mktime (0,0,0,$_POST['rq_month'] , 1, $_POST['rq_year']);

                // sales and leads list
                $cond  =  array('CampaignID' => '',
                                'UserID' => $userid,
                                'Status' => '',
                                'page' => 0,
                                'rowsPerPage' => 200,
                                'day1' => $d1,
                                'month1' => $m,
                                'year1' => $y,
                                'day2' => $d2,
                                'month2' => $m,
                                'year2' => $y);

                $monthlyReport = QUnit_Global::newObj('Affiliate_Scripts_Bl_MonthlyReports');
                // sales list
                $cond['TransactionType'] = TRANSTYPE_SALE;
                $data_sales = Affiliate_Scripts_Bl_SaleStatistics::getTransactionsStats($cond, $account['accountid']);
                $data['sales_list'] = $monthlyReport->formatTransactionList($data_sales['transactions'], $account_settings[$account['accountid']]);
                // leads list
                $cond['TransactionType'] = TRANSTYPE_LEAD;
                $data_leads = Affiliate_Scripts_Bl_SaleStatistics::getTransactionsStats($cond, $account['accountid']);
                $data['leads_list'] = $monthlyReport->formatTransactionList($data_leads['transactions'], $account_settings[$account['accountid']]);

                $objEmailTemplates =& QUnit_Global::newObj('QCore_EmailTemplates');
                $emaildata = $objEmailTemplates->replaceConstatntsInEmailMessage($user['userid'], $_POST['emailcategory'], $subject, $text, $data);
                $subject = $emaildata['subject'];
                $text = $emaildata['text'];
                break;
            case 'AFF_EMAIL_FORGOTPAS1':
                $user['pwd'] = $user['rpassword'];
                $objEmailTemplates =& QUnit_Global::newObj('QCore_EmailTemplates');
                $emaildata = $objEmailTemplates->replaceConstatntsInEmailMessage($user['userid'], $_POST['emailcategory'], $subject, $text, $user);
                $subject = $emaildata['subject'];
                $text = $emaildata['text'];
                break;
            default:
                if ($_SESSION['sendemail_compute_stats'] != 1) break;

                $objTimerangeStats =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TimerangeStatistics');
                $userstats = $objTimerangeStats->getTimerangeStats(
                        $user['userid'], '',
                        $_POST['brs_day1'], $_POST['brs_month1'], $_POST['brs_year1'],
                        $_POST['brs_day2'], $_POST['brs_month2'], $_POST['brs_year2'],
                        $GLOBALS['Auth']->getAccountID(),
                        $GLOBALS['Auth']->getSettings());

                $objEmailTemplates =& QUnit_Global::newObj('QCore_EmailTemplates');
                $emaildata = $objEmailTemplates->replaceConstatntsInEmailMessage($user['userid'], AFF_EMAIL_AF_ML_REP, $subject, $text, $userstats);

                $subject = $emaildata['subject'];
                $text = $emaildata['text'];
                break;
        }

        $strs = array('title' => $subject, 'text' => $text);

        $strs = $objCommunications->replaceInNews($user, $strs);

        $subject = $strs['title'];
        $text = $strs['text'];

        $print_message =  L_G_SENDING.$user['name'].' '.$user['surname'].' : '.$user['username'];

        $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
        'subject' => $subject,
        'text' => $text,
        'message_type' => MESSAGETYPE_EMAIL,
        'userid' => $userid,
        'email' => $user['username'],
        'settings' => $GLOBALS['Auth']->getSettings()
        );

        if($objCommunications->sendEmailDirect($params)) {
            QUnit_Messager::setOkMessage($print_message.L_G_SENTOK);
        }
        else {
            QUnit_Messager::setErrorMessage($print_message.L_G_SENTFAILED);
        }


        if (is_array(QUnit_Messager::getOkMessages()))
        $_SESSION['sendemail_ok_messages'] = array_merge($_SESSION['sendemail_ok_messages'], QUnit_Messager::getOkMessages());
        if (is_array(QUnit_Messager::getErrorMessages()))
        $_SESSION['sendemail_error_messages'] = array_merge($_SESSION['sendemail_error_messages'], QUnit_Messager::getErrorMessages());
        QUnit_Messager::resetMessages();

        return true;
    }

    //--------------------------------------------------------------------------

    function loadMessageData($mid) {
        if (!empty($_POST['commited']))
            return;

        $params = array( 'messageid' => $mid, 'accountid' => $GLOBALS['Auth']->getAccountID() );
        $this->blCommunications->loadMessageInfoToPost($params);

        $_POST['br_news_status'] = $_POST['active'];
        $_POST['br_news_show'] = $_POST['showtoall'];

        $dateFrom = getdate(strtotime($_POST['datevalidfrom']));
        $dateTo   = getdate(strtotime($_POST['datevalidto']));
        $_POST['br_day1']   = $dateFrom['mday'];
        $_POST['br_month1'] = $dateFrom['mon'];
        $_POST['br_year1']  = $dateFrom['year'];
        $_POST['br_day2']   = $dateTo['mday'];
        $_POST['br_month2'] = $dateTo['mon'];
        $_POST['br_year2']  = $dateTo['year'];

        if ($_POST['showtoall'] != '1') {
            $users = $this->blCommunications->getUsersOfMessageAsArray($params);
            $_GET['fromsession'] = '1';
            $_SESSION['bm_userids'] = array();
            foreach ($users[$mid] as $user)
                $_SESSION['bm_userids'][] = $user['userid'];
        }
    }

    //--------------------------------------------------------------------------

    function showForm()
    {
        $_POST['action'] = $_REQUEST['action'];
        if(!isset($_POST['action']))
            $_POST['action'] = 'broadcast';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'broadcast';
        if(isset($_REQUEST['emailcategory']) && ($_REQUEST['emailcategory'] != 'nocategory')) {
        	$_POST['emailcategory'] = $_REQUEST['emailcategory'];
        	$_POST['postaction'] = 'broadcast';
        	$_REQUEST['br_sheet'] = 'mail';
        } else {
        	$_POST['emailcategory'] = 'nocategory';
        }
        if($_POST['action'] == 'edit') {
            $this->loadMessageData($_REQUEST['mid']);
            $_REQUEST['br_sheet'] = 'news';
            $_POST['postaction'] = 'savemessage';
        }

        // report time filter
        $today = getdate();
        if(!isset($_POST['rq_day']))
        	$_POST['rq_day'] = $today['mday'];
        if(!isset($_POST['rq_month']))
        	$_POST['rq_month'] = $today['mon'];
        if(!isset($_POST['rq_year']))
        	$_POST['rq_year'] = $today['year'];

        // news time filter
        if(!isset($_POST['br_day1']))
        	$_POST['br_day1'] = $today['mday'];
        if(!isset($_POST['br_month1']))
        	$_POST['br_month1'] = $today['mon'];
        if(!isset($_POST['br_year1']))
        	$_POST['br_year1'] = $today['year'];

        $nexmonth = getdate(mktime(0, 0, 0, $today['mon']+1, $today['mday'], $today['year']));
        if(!isset($_POST['br_day2']))
        	$_POST['br_day2'] = $nexmonth['mday'];
        if(!isset($_POST['br_month2']))
        	$_POST['br_month2'] = $nexmonth['mon'];
        if(!isset($_POST['br_year2']))
        	$_POST['br_year2'] = $nexmonth['year'];

        if(!isset($_POST['br_news_status']))
            $_POST['br_news_status'] = '1';
        if(!isset($_POST['br_news_show']))
            $_POST['br_news_show'] = '0';

        if(!isset($_POST['header']))
            $_POST['header'] = L_G_BROADCAST_MESSAGE;

        if (empty($_POST['commited'])) {
            if($_GET['fromsession'] == '1') {
                $this->assign('a_list_data3', $_SESSION['bm_userids']);
            } elseif($_GET['userid'] != '') {
                $this->assign('a_list_data3', array($_GET['userid']));
            } else {
                $this->assign('a_list_data3', array());
            }
        } else {
            $this->assign('a_list_data3', explode(",", $_POST['selectedusers']));
        }

        $objUsers =& QUnit_Global::newObj('QCore_Bl_Users');
        $users = $objUsers->getUsersShort($GLOBALS['Auth']->getAccountID(), USERTYPE_USER, true);

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($users);
        $this->assign('a_list_data1', $list_data1);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($users);
        $this->assign('a_list_data2', $list_data2);

        $this->initTemporaryTE();

        if ($_REQUEST['br_sheet'] == '')
            $_REQUEST['br_sheet'] = 'mail';

        $p_tabs[] = array('id'       => 'mail',
        	              'caption'  => L_G_SENDEMAIL,
        	              'content'  => '',
        	              'error'    => '0',
        	              'disabled' => ($_POST['action'] == "edit" ? '1' : '0'),
        	              'onclick'  =>  "javascript: document.getElementById('brdesc_mail').style.display='block';
        	                                          document.getElementById('brdesc_news').style.display='none';
        	                                          document.getElementById('brcons_mail').style.display='block';");

        if ($GLOBALS['Auth']->getSetting('Aff_display_news') == '1') {
            $p_tabs[] = array('id'       => 'news',
        	                  'caption'  => ($_POST['action'] == "edit" ? L_G_EDITNEWS : L_G_SENDNEWS),
        	                  'content'  => '',
        	                  'error'    => '0',
        	                  'disabled' => ($_POST['emailcategory'] == 'nocategory' ? '0' : '1'),
        	                  'onclick'  =>  "javascript: document.getElementById('brdesc_news').style.display='block';
        	                                              document.getElementById('brdesc_mail').style.display='none';
        	                                              document.getElementById('brcons_mail').style.display='none';");
        }
        $this->assign('a_tabs', $p_tabs);
        $this->assign('a_form_preffix', 'brs_');
        $this->assign('a_form_name', 'FilterForm');
        $this->addContent('broademail_show');
    }

    //--------------------------------------------------------------------------

    function showResults() {
        QUnit_Messager::resetMessages();
        if (count($_SESSION['sendemail_ok_messages']) > 0) {
            foreach ($_SESSION['sendemail_ok_messages'] as $msg) {
                QUnit_Messager::setOkMessage($msg);
            }
        }
        if (count($_SESSION['sendemail_error_messages']) > 0) {
            foreach ($_SESSION['sendemail_error_messages'] as $msg) {
                QUnit_Messager::setErrorMessage($msg);
            }
        }
    }
}
?>
