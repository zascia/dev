<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_RecurringManager extends QUnit_UI_TemplatePage
{
    var $blAffiliate;
    var $viewCampManager;
    var $blGlobalFuncs;

    function Affiliate_Merchants_Views_RecurringManager()
    {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->viewCampManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
        $this->blGlobalFuncs =& QUnit_Global::newObj('QCore_Bl_GlobalFuncs');
        
      	$this->navigationAddURL(L_G_HOME,'index.php?md=home');
      	$this->navigationAddURL(L_G_TOPMENU_TRANSACTIONS,'index.php?md=Affiliate_Merchants_Views_TransactionManager');
		$this->navigationAddURL(L_G_RECURRINGCOMMS,'index.php?md=Affiliate_Merchants_Views_RecurringManager&type=all');
    }

    //--------------------------------------------------------------------------

    function initPermissions()
    {
        $this->modulePermissions['delete'] = 'aff_trans_recurr_transactions_modify';
        $this->modulePermissions['suppress'] = 'aff_trans_recurr_transactions_approvedecline';
        $this->modulePermissions['approve'] = 'aff_trans_recurr_transactions_approvedecline';
        $this->modulePermissions['view'] = 'aff_trans_recurr_transactions_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'delete':
                    if($this->processDelete())
                        return;
                    break;

                case 'suppress':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED))
                        return;
                    break;

                case 'approve':
                    if($this->processChangeState(AFFSTATUS_APPROVED))
                        return;
                    break;
            }
        }

        if(!empty($_POST['massaction']))
        {
            switch($_POST['massaction'])
            {
                case 'suppress':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED))
                        return;
                break;

                case 'approve':
                    if($this->processChangeState(AFFSTATUS_APPROVED))
                        return;
                break;

                case 'delete':
                    if($this->processDelete())
                        return;
                break;
            }
        }

        $this->showRecurringTransactions();
    }

    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================

    function processDelete()
    {
        if(($IDs = $this->blGlobalFuncs->returnIDs()) == false)
            return false;

        $params = array();
        $params['ids'] = $IDs;
        $params['values'] = array('deleted' => '1');
        $params['table_name'] = 'wd_pa_recurringcommissions';
        $params['column_id'] = 'recurringcommid';

        $this->blGlobalFuncs->updateMass($params);

        return false;
    }

    //--------------------------------------------------------------------------

    function processChangeState($state)
    {
        if(($IDs = $this->blGlobalFuncs->returnIDs()) == false)
            return false;

        $params = array();
        $params['ids'] = $IDs;
        $params['values'] = array('rstatus' => $state);
        $params['table_name'] = 'wd_pa_recurringcommissions';
        $params['column_id'] = 'recurringcommid';

        $this->blGlobalFuncs->updateMass($params);

        return false;
    }

    //==========================================================================
    // FORMS FUNCTIONS
    //==========================================================================

    function showRecurringTransactions()
    {
        if ($_REQUEST['status_comitted'] != '1' && $_REQUEST['f_status'] == '') {
            $_REQUEST['f_status'] = array(AFFSTATUS_APPROVED, AFFSTATUS_NOTAPPROVED, AFFSTATUS_SUPPRESSED);
        }
        
        //--------------------------------------
        // put settings into session
        foreach ($_REQUEST as $key => $value) {
            if (substr($key, 0, 2) == 'f_') {
                $_SESSION[$key] = $value;
            }
        }
        
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v) {
            if(strstr($k, 'f_status') !== false && ($_REQUEST['status_comitted'] == '1')) {
                continue;
            }
            if(strpos($k, 'f_') === 0 && !isset($_REQUEST[$k])) {
                $_REQUEST[$k] = $v;
            }
        }
        
        $paffiliateid = preg_replace('/[\'\"]/', '', $_REQUEST['f_affiliateid']);
        $porderid = preg_replace('/[\'\"]/', '', $_REQUEST['f_orderid']);
        $pstatus = preg_replace('/[^0-9]/', '', $_REQUEST['f_status']);

        $a = array('t.recurringcommid', 'cc.campaignid', 'affiliateid', 't.orderid',
                   'r.dateinserted', 'r.commission', 'r.commdate', 'r.datetype', 'r.rstatus');
        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
          $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
        else
            $orderby = ' order by r.dateinserted desc';

        $where = 'where r.deleted=0 and r.originaltransid=t.transid'.
                 '  and r.campcategoryid=cc.campcategoryid'.
                 '  and t.accountid='._q($GLOBALS['Auth']->getAccountID());

        if($paffiliateid != '_' && $paffiliateid != '')
            $where .= ' and r.affiliateid='._q($paffiliateid);
        if($porderid != '')
            $where .= ' and t.orderid like \'%'._q_noendtags($porderid).'%\'';
            
        if(is_array($pstatus)&& count($pstatus)>0) {
            $where .= " and t.rstatus in (".implode(',', $pstatus).")";
        } else {
            $where .= " and t.rstatus like ''";
        }
        
        //if($pstatus != '_' && $pstatus != '')
        //    $where .= ' and r.rstatus='._q($pstatus);

        //------------------------------------------------
        // get total number of records
        $sql = 'select count(r.recurringcommid) as count '.
               'from wd_pa_recurringcommissions r, wd_pa_transactions t, wd_pa_campaigncategories cc ';
        $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $this->assign('a_numrows', $rs->fields['count']);

        $sql = 'select r.*, '.sqlDayOfMonth('r.dateinserted').' as dayofmonth, '.
               'MONTH(r.dateinserted) as month, '.sqlWeek('r.dateinserted').' as week, '.
               sqlDayOfWeek('r.dateinserted').' as dayofweek, YEAR(r.dateinserted) as year, '.
               't.orderid, cc.campaignid '.
               'from wd_pa_recurringcommissions r, wd_pa_transactions t, wd_pa_campaigncategories cc ';
         //------------------------------------------------
         // get records
        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $campaigns = $this->viewCampManager->getCampaignsAsArray();
        
        $affiliates = $this->blAffiliate->getUsersAsArray();
        $usersRs = $this->blAffiliate->getUsersAsRs();
        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($usersRs);
        
        $this->assign('a_list_users', $list_data);
        
        //$this->addContent('rc_filter');
        //$this->addContent('rc_filter_temp');

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rs);

        $this->assign('a_list_data', $list_data);
        $this->assign('a_campaigns', $campaigns);
        $this->assign('a_affiliates', $affiliates);

        $temp_perm['approve'] = $this->checkPermissions('approve');
        $temp_perm['suppress'] = $this->checkPermissions('suppress');
        $temp_perm['delete'] = $this->checkPermissions('delete');

        $this->assign('a_action_permission', $temp_perm);
        
        $this->assign("a_form_preffix", "f_");
        $this->assign("a_form_name", "FilterForm");

        $this->addContent('rc_list');
    }
}
?>
