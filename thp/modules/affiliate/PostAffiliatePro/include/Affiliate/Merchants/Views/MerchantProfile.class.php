<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QCore_Bl_GlobalDb');

class Affiliate_Merchants_Views_MerchantProfile extends QUnit_UI_TemplatePage
{
    var $blTrendStat;
    var $blTimeStat;

    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Views_MerchantProfile() {
        $this->blTrendStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TrendStatistics');
        $this->blTimeStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TimerangeStatistics');
        $this->blCommunications = QUnit_Global::newObj('QCore_Bl_Communications');

        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
    }

    //--------------------------------------------------------------------------

    function initPermissions()
    {
        $this->modulePermissions['showcodes'] = 'aff_tool_integration_view';
        $this->modulePermissions['view'] = '';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if($_REQUEST['action'] != '') {
            switch($_REQUEST['action']) {
                case 'firststeps':
                        $this->navigationAddURL(L_G_FIRSTSTEPSTITLE,'index.php?md=home&action=firststeps');
                        if($this->showFirstSteps())
                            return true;
                        break;
                        
                case 'showaffstats':
                    $this->showAffiliateStats();
                    return;
                    
                case 'showtransstats':
                    $this->showTransStats();
                    return;
            }
        }

        $this->showProfile();
    }
    
    //--------------------------------------------------------------------------
    
    function showProfile() {
        $GLOBALS['Auth']->loadSettings($GLOBALS['Auth']->getAccountID(), $GLOBALS['Auth']->getUserID());
        $GLOBALS['Auth']->getFromSession();

        if( (AFF_PROGRAM_TYPE != PROG_TYPE_PRO) && ($GLOBALS['Auth']->getSetting('Merch_display_news') == '1') ) {
            $this->processNews();
        }
        
        
        // AffPlanet news
        $globalDB = QCore_Bl_GlobalDb::getInstance();
        $params = array('userid'        => $GLOBALS['Auth']->getUserID(),
                        'liteaccountid' => $GLOBALS['Auth']->getLiteAccountID(),
                        'view_old'      => $_REQUEST['view_old']);
        $news = $globalDB->getMerchantNews($params);

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($news);
        $this->assign('a_list_data', $list_data);

        $this->assign('a_news_count', count($news));

        $params = array('userid'        => $GLOBALS['Auth']->getUserID(),
                        'liteaccountid' => $GLOBALS['Auth']->getLiteAccountID(),
                        'view_old'      => '1');
        $news = $globalDB->getMerchantNews($params);

        $this->assign('a_old_news_exist', (count($news) > 0));
        
        
        $this->addContent('m_profile');
    }

    //--------------------------------------------------------------------------

    function showTransStats()
    {
        // get number of transactions waiting for approval
        $sql = 'select count(transid) as amount from wd_pa_transactions t, wd_g_users u '.
        'where u.userid=t.affiliateid '.
        '  and u.rtype='._q(USERTYPE_USER).
        '  and u.accountid='._q($GLOBALS['Auth']->getAccountID()).
        '  and t.rstatus='.AFFSTATUS_NOTAPPROVED.
        '  and u.deleted=0 and u.rstatus in (1,2)';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        $this->assign('a_trans_waiting', $rs->fields['amount']);

        // get statistics for today
        $d1 = date("j");
        $m1 = date("n");
        $y1 = date("Y");
        $d2 = date("j");
        $m2 = date("n");
        $y2 = date("Y");

        $data = $this->blTimeStat->getTimerangeStats(
                    '', '', $d1, $m1, $y1, $d2, $m2, $y2,
                    $GLOBALS['Auth']->getAccountID()
                    );

        $this->assign('a_data', $data);
        $this->assign('a_settings', QUnit_Global::newObj('Affiliate_Merchants_Bl_Settings'));
        $this->assign('a_auth', $GLOBALS['Auth']);
        
        $sql = 'select count(*) as rcount, rstatus from wd_g_users '.
               'where rtype='._q(USERTYPE_USER).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and deleted=0'.
               ' group by rstatus';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF) {
            return false;
        }

        $approved = 0;
        $waiting = 0;
        $declined = 0;
        $all = 0;

        while(!$rs->EOF)
        {
            $status = $rs->fields['rstatus'];

            if($status == AFFSTATUS_APPROVED)
            {
                $approved = $rs->fields['rcount'];
            }
            else if($status == AFFSTATUS_NOTAPPROVED)
            {
                $waiting = $rs->fields['rcount'];
            }
            else if($status == AFFSTATUS_SUPPRESSED)
            {
                $declined = $rs->fields['rcount'];
            }

            $rs->MoveNext();
        }

        $all = $approved + $waiting + $declined;

        $this->assign('a_aff_all', $all);
        $this->assign('a_aff_waiting', $waiting);

        $this->addContent('m_profile_trans');
    }

    //--------------------------------------------------------------------------

    function getWarnings() {
        $warnings = array();
        $last_job_time = $GLOBALS['Auth']->getSetting('Aff_last_job_time');
        if ($last_job_time == '' || (time() - $last_job_time) > 2*3600) {
            $path = substr(__FILE__, 0, strpos(__FILE__, "include"));
            $warnings[] = L_G_CRONJOBNOTRUNNING.'/usr/local/bin/php -q '.$path."scripts/jobs.php".L_G_CRONJOBNOTRUNNING2;
        }

        return $warnings;
    }



    //--------------------------------------------------------------------------

    function showFirstSteps() {
        $this->assign('a_warnings', $this->getWarnings());

        $this->addContent('first_steps');

        return true;
    }

    //--------------------------------------------------------------------------

    function showAffiliateStats()
    {
        $sql = 'select count(*) as rcount, rstatus from wd_g_users '.
               'where rtype='._q(USERTYPE_USER).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and deleted=0'.
               ' group by rstatus';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF) {
            return false;
        }

        $approved = 0;
        $waiting = 0;
        $declined = 0;
        $all = 0;

        while(!$rs->EOF)
        {
            $status = $rs->fields['rstatus'];

            if($status == AFFSTATUS_APPROVED)
            {
                $approved = $rs->fields['rcount'];
            }
            else if($status == AFFSTATUS_NOTAPPROVED)
            {
                $waiting = $rs->fields['rcount'];
            }
            else if($status == AFFSTATUS_SUPPRESSED)
            {
                $declined = $rs->fields['rcount'];
            }

            $rs->MoveNext();
        }

        $all = $approved + $waiting + $declined;

        $this->assign('a_aff_all', $all);
        $this->assign('a_aff_waiting', $waiting);

        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
        $labels = "<a class=textlink href='index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1&umprof_status=".AFFSTATUS_APPROVED."'>".L_G_APPROVED."</a>,";
        $labels .= "<a class=textlink href='index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1&umprof_status=".AFFSTATUS_NOTAPPROVED."'>".L_G_WAITINGAPPROVAL."</a>,";
        $labels .= "<a class=textlink href='index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1&umprof_status=".AFFSTATUS_SUPPRESSED."'>".L_G_SUPPRESSED."</a>";
        $graph->labels = $labels;
        $graph->values = $approved.','.$waiting.','.$declined;
        $graph->barColor = '#486B8F';
        $graph->barLength = 4.0;
        $gdata = $graph->create();

        $this->assign('a_affstats_graph', $gdata);
        
        $this->addContent("m_profile_aff");
    }

    //--------------------------------------------------------------------------

    function checkMerchantExists($username, $aid = '')
    {
        $sql = 'select * from wd_g_users '.
               'where username='._q($username).
               '  and rtype='._q(USERTYPE_ADMIN);
        if($aid != '')
            $sql .= ' and userid<>'._q($aid);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF)
            return false;

        return true;
    }

    //--------------------------------------------------------------------------

    function getAccountAdminsAsArray($accountid)
    {
        if($accountid == '') return array();

        $sql = 'select userid, name, surname from wd_g_users '.
               'where accountid='._q($accountid).
               '  and rstatus='._q(STATUS_ENABLE).
               '  and rtype='._q(USERTYPE_ADMIN).
               ' order by name, surname';

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $account_admins = array();

        while(!$rs->EOF)
        {
            $temp = array();
            $temp['name'] = $rs->fields['name'];
            $temp['surname'] = $rs->fields['surname'];
            $temp['userid'] = $rs->fields['userid'];

            $account_admins[$rs->fields['userid']] = $temp;

            $rs->moveNext();
        }

        return $account_admins;
    }

    //------------------------------------------------------------------------

    function processNews()
    {
        $params = array(
            'userid' => $GLOBALS['Auth']->getUserID(),
            'accountid' => SA_ACCOUNT_ID,
            'view_old' => $_REQUEST['view_old']
        );


        $user_news = $this->blCommunications->getUserNews($params);
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($user_news[$GLOBALS['Auth']->getUserID()]);
        $this->assign('a_list_data', $list_data);

        $this->assign('a_news_count', count($user_news[$GLOBALS['Auth']->getUserID()]));

        $this->assign('a_old_news_exist', $this->blCommunications->checkOldNewsExist($params));
    }

}
?>
