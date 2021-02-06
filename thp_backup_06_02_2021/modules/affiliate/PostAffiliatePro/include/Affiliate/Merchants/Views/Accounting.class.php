<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
//QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Settings');

class Affiliate_Merchants_Views_Accounting extends QUnit_UI_TemplatePage
{
    var $blAffiliate;
    var $blPayoutOpts;

    function Affiliate_Merchants_Views_Accounting() {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blPayoutOpts =& QUnit_Global::newObj('Affiliate_Merchants_Bl_PayoutOptions');

        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_AFFPAYOUTHISTORY,'index.php?md=Affiliate_Merchants_Views_Accounting');
    }

    function initPermissions()
    {
        $this->modulePermissions['savedetails'] = 'aff_aff_accounting_modify';
        $this->modulePermissions['details'] = 'aff_aff_accounting_view';
        $this->modulePermissions['view'] = 'aff_aff_accounting_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        $this->assign('a_form_preffix', 'acc_');
        $this->assign('a_form_name', 'FilterForm');

        if(!empty($_POST['commited']))
        {
            switch($_POST['action'])
            {
                case 'savedetails':
                if($this->processSaveDetails())
                    return;
                break;
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'details':
                if($this->drawFormDetails())
                    return;
                break;
            }
        }

        $this->showAccounting();
    }

    //--------------------------------------------------------------------------

    function processSaveDetails()
    {
        $accountingid = preg_replace('/[\'\"]/', '', $_POST['aid']);
        $note = $_POST['note'];

        $sql = "update wd_pa_accounting set note="._q($note)." where accountingid="._q($accountingid);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        QUnit_Messager::setOkMessage(L_G_CHANGESSAVED);

        $this->drawFormDetails();
        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormDetails()
    {
        $accountingid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);

        $sql = "select accountingid,".
               sqlShortDate('dateinserted')." as dateinserted,".
               sqlShortDate('datefrom')." as datefrom,".
               sqlShortDate('dateto')." as dateto,".
               " SUBSTRING(note, 1, 50) as note,".
               " rfile".
               " from wd_pa_accounting where accountingid="._q($accountingid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $_POST['accountingid'] = $rs->fields['accountingid'];
        $_POST['dateinserted'] = $rs->fields['dateinserted'];
        $_POST['datefrom'] = $rs->fields['datefrom'];
        $_POST['dateto'] = $rs->fields['dateto'];
        $_POST['note'] = $rs->fields['note'];
        $_POST['rfile'] = $rs->fields['rfile'];

        // get payment information per user
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($this->getPayoutsPerAffiliate($accountingid));

        $this->assign('a_list_data', $list_data);

        $payout_methods = $this->blPayoutOpts->getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID());
        $this->assign('a_payout_methods', $payout_methods);

        $this->assign('a_action_permission', $this->modulePermissions);
        $this->addContent('acc_details');

        return true;
    }

    //--------------------------------------------------------------------------

    function getAccountingId($affiliateId)
    {
        $tempsql = "select distinct accountingid from wd_pa_transactions where affiliateid = "._q($affiliateId) . " and accountingid is not null";
        $rs = QCore_Sql_DBUnit::execute($tempsql, __FILE__, __LINE__);
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $result = '';
        if (!$rs->EOF) {
            $result .= _q($rs->fields['accountingid']);
            $rs->MoveNext();
        }

        while (!$rs->EOF) {
            $result .= ','._q($rs->fields['accountingid']);
            $rs->MoveNext();
        }

        if (empty($result))
            return "('')";
        else
            return '('.$result.')';
    }

    //--------------------------------------------------------------------------

    function showAccounting()
    {
        // sorting
        $orderby = '';
        $a = array("accountingid", "dateinserted", "datefrom", "dateto", "note");

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
            $orderby = " order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
        else
            $orderby = " order by dateinserted desc";

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'acc_') === 0 && !isset($_REQUEST[$k]))
            $_REQUEST[$k] = $v;
        }

        $_REQUEST['acc_note'] = preg_replace('/[\'\"]/', '', $_REQUEST['acc_note']);

        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['acc_userid'] == '') $_REQUEST['acc_userid'] = '_';
        if($_REQUEST['acc_day1'] == '') $_REQUEST['acc_day1'] = 1;
        if($_REQUEST['acc_month1'] == '') $_REQUEST['acc_month1'] = 1;
        if($_REQUEST['acc_year1'] == '') $_REQUEST['acc_year1'] = PAP_STARTING_YEAR;
        if($_REQUEST['acc_day2'] == '') $_REQUEST['acc_day2'] = date("j");
        if($_REQUEST['acc_month2'] == '') $_REQUEST['acc_month2'] = date("n");
        if($_REQUEST['acc_year2'] == '') $_REQUEST['acc_year2'] = date("Y");
        if($_REQUEST['acc_day1'] == '' && $_REQUEST['acc_month1'] == '' && $_REQUEST['acc_year1'] == '')
        {
            $this->getLastPeriod($_REQUEST['acc_day1'], $_REQUEST['acc_month1'], $_REQUEST['acc_year1']);
        }
        if($_REQUEST['acc_timeselect'] == '') $_REQUEST['acc_timeselect'] = TIME_PRESET;
        if($_REQUEST['acc_timepreset'] == '') $_REQUEST['acc_timepreset'] = TIME_TODAY;


        //--------------------------------------
        // put settings into session
        $_SESSION['acc_userid'] = $_REQUEST['acc_userid'];
        $_SESSION['acc_note'] = $_REQUEST['acc_note'];
        $_SESSION['acc_day1'] = $_REQUEST['acc_day1'];
        $_SESSION['acc_month1'] = $_REQUEST['acc_month1'];
        $_SESSION['acc_year1'] = $_REQUEST['acc_year1'];
        $_SESSION['acc_day2'] = $_REQUEST['acc_day2'];
        $_SESSION['acc_month2'] = $_REQUEST['acc_month2'];
        $_SESSION['acc_year2'] = $_REQUEST['acc_year2'];
        $_SESSION['acc_timeselect'] = $_REQUEST['acc_timeselect'];
        $_SESSION['acc_timepreset'] = $_REQUEST['acc_timepreset'];
        $_SESSION['acc_note'] = $_REQUEST['acc_note'];

        $this->assign('a_curyear', date("Y"));

        // process time filter
        if($_REQUEST['acc_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['acc_timepreset'], 'acc_'));
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($this->blAffiliate->getUsersAsArray());
        $this->assign('a_list_data', $list_data);

        $this->getUsersForFilter();
        $this->addContent('acc_filter');

        $note = preg_replace('/[\'\"]/', '', $_REQUEST['acc_note']);

        $sql = "select accountingid,".
               sqlShortDate('dateinserted')." as dateinserted,".
               sqlShortDate('datefrom')." as datefrom,".
               sqlShortDate('dateto')." as dateto,".
               " SUBSTRING(note, 1, 50) as note,".
               " rfile".
               " from wd_pa_accounting where 1=1";
        if ($_REQUEST['acc_userid'] != '_') {
            if (!$subselect = $this->getAccountingId($_REQUEST['acc_userid']))
                return;
            $sql .= " and accountingid in " . $subselect;
        }
        if($note != '')
            $sql .= " and note like '%"._q_noendtags($note)."%'";
        $sql .= " and (".sqlToDays('datefrom')." between ".sqlToDays($_REQUEST['acc_year1']."-".$_REQUEST['acc_month1']."-".$_REQUEST['acc_day1']).
                       " and ".sqlToDays($_REQUEST['acc_year2']."-".$_REQUEST['acc_month2']."-".$_REQUEST['acc_day2']).
                " or ".sqlToDays($_REQUEST['acc_year1']."-".$_REQUEST['acc_month1']."-".$_REQUEST['acc_day1']).
                       " between ".sqlToDays('datefrom')." and ".sqlToDays('dateto').")";

        $sql .= $orderby;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $AccData = array();

        // prepare the data
        $accPayments = $this->getPayoutsPerAccounting();

        while(!$rs->EOF)
        {
            $temp = array();
            $temp['accountingid'] = $rs->fields['accountingid'];
            $temp['dateinserted'] = $rs->fields['dateinserted'];
            $temp['datefrom'] = $rs->fields['datefrom'];
            $temp['dateto'] = $rs->fields['dateto'];
            $temp['note'] = $rs->fields['note'];

            $temp['paid'] = $accPayments[$rs->fields['accountingid']];

            if ($temp['paid'] > 0)
                $AccData[] = $temp;
            $rs->MoveNext();
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($AccData);

        $this->assign('a_list_data', $list_data);
        $this->assign('a_numrows', count($AccData));

        $this->addContent('acc_list');
    }

    //--------------------------------------------------------------------------

    function getUsersForFilter()
    {
        $usersRs = $this->blAffiliate->getUsersAsRs();
        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($usersRs);

        $this->assign('a_list_users', $list_data);
    }

    //--------------------------------------------------------------------------

    function getLastPeriod(&$day, &$month, &$year)
    {
        $sql = "select max(dateto) as dateto from wd_pa_accounting";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF || $rs->fields['dateto'] == '')
        {
            return false;
        }

        sscanf($rs->fields['dateto'], "%d-%d-%d", $year, $month, $day);

        return true;
    }

    //--------------------------------------------------------------------------

    function getPayoutsPerAccounting()
    {
        $sql = "select accountingid, sum(commission) as commission ".
               "from wd_pa_transactions ".
               "where rstatus=".AFFSTATUS_APPROVED.
               "  and accountid="._q($GLOBALS['Auth']->getAccountID()).
               "  and payoutstatus=".AFFSTATUS_APPROVED.
               " group by accountingid";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $data = array();
        while(!$rs->EOF)
        {
            $data[$rs->fields['accountingid']] = $rs->fields['commission'];

            $rs->MoveNext();
        }

        return $data;
    }

    //--------------------------------------------------------------------------

    function getPayoutsPerAffiliate($accountingid)
    {
        $sql = "select affiliateid, sum(commission) as commission ".
               "from wd_pa_transactions ".
               "where rstatus=".AFFSTATUS_APPROVED.
               "  and payoutstatus=".AFFSTATUS_APPROVED.
               "  and accountingid="._q($accountingid).
               " group by affiliateid";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $data = array();

        $users = $this->blAffiliate->getUsersAsArray();
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['userid'] = $rs->fields['affiliateid'];
            $temp['commission'] = $rs->fields['commission'];
            $temp['name'] = $users[$rs->fields['affiliateid']]['name'];
            $temp['surname'] = $users[$rs->fields['affiliateid']]['surname'];
            $temp['payout_type'] = $users[$rs->fields['affiliateid']]['payout_type'];
            $data[] = $temp;

            $rs->MoveNext();
        }

        return $data;
    }

    //--------------------------------------------------------------------------

    function getAccountingAsArray()
    {
        $sql = "select accountingid,".
               sqlShortDate('dateinserted')." as dateinserted,".
               sqlShortDate('datefrom')." as datefrom,".
               sqlShortDate('dateto')." as dateto,".
               " SUBSTRING(note, 1, 50) as note,".
               " rfile".
               " from wd_pa_accounting";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $data = array();
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['accountingid'] = $rs->fields['accountingid'];
            $temp['dateinserted'] = $rs->fields['dateinserted'];
            $temp['datefrom'] = $rs->fields['datefrom'];
            $temp['dateto'] = $rs->fields['dateto'];
            $temp['note'] = $rs->fields['note'];
            $temp['rfile'] = $rs->fields['rfile'];
            $data[$rs->fields['accountingid']] = $temp;

            $rs->MoveNext();
        }

        return $data;
    }

    function printListRowActions($row)
    {
        $actions = array();

        $actions[] = array('id' => 'details',
                           'img' => 'icon_view.gif',
                           'desc' => L_G_DETAILS,
                           'action' => "Details('".$row['accountingid']."');");

        $this->initTemporaryTE();
        $this->temporaryAssign('a_actions', $actions);
        $this->temporaryAssign('a_action_count', 1);
        print '<td class=listresultnocenter align="left">'.$this->temporaryFetch('actions_icon').'</td>';
    }
}
?>
