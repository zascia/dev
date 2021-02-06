<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');

class Affiliate_Merchants_Views_ExpensesManager extends QUnit_UI_ListPage
{
    var $campCategory;
    var $blAffiliate;
    var $campaignManager;
    var $campCategManager;
    
    function Affiliate_Merchants_Views_ExpensesManager() {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blCampaignManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
        $this->blCampCategManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampCategoriesManager');
    }

    //--------------------------------------------------------------------------    

    function initPermissions()
    {
//        $this->modulePermissions['approvetrans'] = 'aff_trans_transactions_approvedecline';
//        $this->modulePermissions['denytrans'] = 'aff_trans_transactions_approvedecline';
//        $this->modulePermissions['create'] = 'aff_trans_transactions_modify';
//        $this->modulePermissions['edit'] = 'aff_trans_transactions_modify';
//        $this->modulePermissions['suppress'] = 'aff_trans_transactions_approvedecline';
//        $this->modulePermissions['approve'] = 'aff_trans_transactions_approvedecline';
//        $this->modulePermissions['delete'] = 'aff_trans_transactions_modify';
//        $this->modulePermissions['view'] = 'aff_trans_transactions_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
               case 'create':
                    if($this->processCreateExpense())
                        return;
                    break;
            }
        }
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {                
                case 'create':
                    if($this->drawFormCreateExpense())
                        return;
                    break;
            }
        }        

        if($_REQUEST['action'] == 'exportcsv')
            $this->showTransactions(true);
        else
            $this->showTransactions(false);      
    }

    //--------------------------------------------------------------------------
    
    function drawFormCreateExpense()
    {
            if($_REQUEST['exp_day1'] == '') $_REQUEST['exp_day1'] = date("j");
            if($_REQUEST['exp_month1'] == '') $_REQUEST['exp_month1'] = date("n");
            if($_REQUEST['exp_year1'] == '') $_REQUEST['exp_year1'] = date("Y");
            if($_REQUEST['exp_day2'] == '') $_REQUEST['exp_day2'] = date("j");
            if($_REQUEST['exp_month2'] == '') $_REQUEST['exp_month2'] = date("n");
            if($_REQUEST['exp_year2'] == '') $_REQUEST['exp_year2'] = date("Y");        
        
        $campaigns = $this->blCampaignManager->getCampaignsAsArray();
        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        
        
        $this->assign('a_list_data1', $list_data1);

        $users = $this->blAffiliate->getUsersAsArray();
        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($users);
        $this->assign('a_list_data2', $list_data2);
        $this->assign('a_curyear', date("Y"));
        $this->addContent('expenses_create');
        
        return true;
    }    
    
    //--------------------------------------------------------------------------
    
    function processCreateExpense()
    {
        // protect against script injection
        $userid = preg_replace('/[\'\"]/', '', $_POST['userid']);
        $campaignid = preg_replace('/[\'\"]/', '', $_POST['campaignid']);
        $totalexpense = preg_replace('/[^0-9\.]/', '', $_POST['totalexpense']);
        $channel = preg_replace('/[\'\"]/', '', $_POST['channel']);
        $episode = preg_replace('/[\'\"]/', '', $_POST['episode']);
        $timeslot = preg_replace('/[\'\"]/', '', $_POST['timeslot']);
        $purchasedate = $_POST['exp_year1']."-".$_POST['exp_month1']."-".$_POST['exp_day1']." 00:00:00";
        $expensedate = $_POST['exp_year2']."-".$_POST['exp_month2']."-".$_POST['exp_day2']." 00:00:00";
        
        // check correctness of the fields
        checkCorrectness($_POST['userid'], $userid, L_G_AFFILIATE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['campaignid'], $campaignid, L_G_CAMPAIGN, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['totalexpense'], $totalexpense, L_G_TOTALEXPENSE, CHECK_ALLOWED, CHECK_NUMBER);
                
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return;
        }
        else
        {
            $ret = $this->createExpense($userid, $campaignid, $purchasedate, $expensedate, $totalexpense, $channel, $episode, $timeslot);
            
            if($ret)
                QUnit_Messager::setOkMessage(L_G_EXPENSECREATED);
            else
                return false;
  
            $this->closeWindow('Affiliate_Merchants_Views_ExpensesManager');
            $this->addContent('closewindow');            
            return true;
        }
        
        return false;
    }

    //--------------------------------------------------------------------------        
    
    function createExpense($userid, $campaignid, $purchasedate, $expensedate, $totalexpense, $channel, $episode, $timeslot)
    {
        //---------------------------------------
        // check commission category for this user
        $sql = 'select cc.* '.
               'from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campaignid='._q($campaignid).
               '  and cc.campcategoryid=ac.campcategoryid '.
               '  and affiliateid='._q($userid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        return false;
        
        if($rs->EOF)
        {
            // get basic commission category for this campaign
            $sql = 'select * from wd_pa_campaigncategories where deleted=0 and campaignid='._q($campaignid).' and deleted=0 order by campcategoryid asc';
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
            return false;          
        }
        
        $campcategoryid = $rs->fields['campcategoryid'];
        
        // save changes of user to db
        $expID = QCore_Sql_DBUnit::createUniqueID('wd_pa_expenses', 'expenseid');
        $sql = "insert into wd_pa_expenses(expenseid, affiliateid, campcategoryid, purchasedate, expensedate, totalexpense, channel, episode, timeslot)".
        "values("._q($expID).","._q($userid).","._q($campcategoryid).","._q($purchasedate).","._q($expensedate).", ".myquotes($totalexpense).","._q($channel).","._q($episode).","._q($timeslot).")";
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);        
        if (!$ret)        
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }  
        return true;
    }    
    
    //--------------------------------------------------------------------------
    
    function showTransactions($exportToCsv)
    {
        $temp_perm['view'] = $this->checkPermissions('view');
        $temp_perm['create'] = $this->checkPermissions('create');

        $this->assign('a_action_permission', $temp_perm);

        $this->createWhereOrderBy($orderby, $where);
        
        $this->getUsersForFilter();
        $this->getCampaingsForFilter();
        $this->campCategory = $this->blCampCategManager->getCampCategoriesAsArray();
        if($exportToCsv)
        {
            // prepare export file first
            $this->prepareExportFile($orderby, $where);
        }

        $recs = $this->getRecords($orderby, $where);
        $this->initViews();
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($recs);
        
        $this->assign('a_list_data', $list_data);
        $this->assign('a_curyear', date("Y"));
        
        $this->pageLimitsAssign();

        $this->addContent('expenses_list');        
    }    

    //--------------------------------------------------------------------------

    function getUsersForFilter()
    {
        $usersRs = $this->blAffiliate->getUsersAsRs();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($usersRs);
        
        $this->assign('a_list_users', $list_data);
    }

    function getCampaingsForFilter()
    {    
        $campaigns = $this->blCampaignManager->getCampaignsAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_campaings', $list_data1);
    }


    //--------------------------------------------------------------------------

    function getRecords($orderby, $where)
    {
        //------------------------------------------------
        // init paging
        $sql = 'select count(*) as count from wd_pa_expenses e, wd_g_users a, wd_pa_campaigncategories c ';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        
        //------------------------------------------------
        // get records
        $sql = "select a.userid, a.name, a.surname, ".
                "c.campaignid, ".
                "e.expenseid, e.purchasedate, e.expensedate, ".
                "e.totalexpense, e.bannerid, e.affiliateid, ".
                "e.campcategoryid, e.channel, e.episode, e.timeslot, e.exit ".
                "from wd_pa_expenses e, wd_g_users a, wd_pa_campaigncategories c";

        $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        return $rs;
    }
    
    //--------------------------------------------------------------------------
    
    /** returns list of columns in list view */
    function getAvailableColumns()
    {
        return array(
            'expenseid' =>            array(L_G_EXPENSEID, 'expenseid'),
            'purchasedate' =>         array(L_G_PURCHASEDATE, 'purchasedate'),
            'expensedate' =>         array(L_G_EXPENSEDATE, 'expensedate'),
            'totalexpense' =>         array(L_G_TOTALEXPENSE, 'totalexpense'),
            'bannerid' =>         array(L_G_BANNERID, 'bannerid'),
            'affiliateid' =>         array(L_G_AFFILIATEID, 'affiliateid'),
            'campcategoryid' =>         array(L_G_CAMPCATEGORY, 'campcategoryid'),
            'channel' =>         array(L_G_CHANNEL, 'channel'),
            'episode' =>         array(L_G_EPISODE, 'episode'),
            'timeslot' =>         array(L_G_TIMESLOT, 'timeslot'),
            'exit' =>         array(L_G_EXIT, 'exit'),
        );
    }
    
    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'expenses_list';
    }
    
    //--------------------------------------------------------------------------

    function initViews()
    {        
        $this->createDefaultView(array_keys($this->getAvailableColumns()));
        $this->loadAvailableViews();
        
        $tplAvailableViews = array();
        foreach($this->availableViews as $objView)
        {
            $tplAvailableViews[$objView->dbid] = $objView->getName();
        }

        $this->assign('a_list_views', $this->tplAvailableViews);
        
        $this->applyView();
    }    
    
    //--------------------------------------------------------------------------

    function createWhereOrderBy(&$orderby, &$where)
    {
        $orderby = '';
        $where = '';
        
        $a = array_keys($this->getAvailableColumns());
        
        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
        {
            $orderby = " order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
        }
        else
        {
            $orderby = " order by e.purchasedate desc";
        }
        

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'exp_') === 0 && !isset($_REQUEST[$k]))
            {
                $_REQUEST[$k] = $v;
            }
            if($k == 'numrows' && $_REQUEST[$k] == '')
            {
                $_REQUEST[$k] = $v;
            }
        }
                
            //--------------------------------------
            // get default settings for unset variables
            if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
            if($_REQUEST['exp_affiliateid'] == '') $_REQUEST['exp_affiliateid'] = '_';
            if($_REQUEST['exp_day1'] == '') $_REQUEST['exp_day1'] = date("j");
            if($_REQUEST['exp_month1'] == '') $_REQUEST['exp_month1'] = date("n");
            if($_REQUEST['exp_year1'] == '') $_REQUEST['exp_year1'] = date("Y");
            if($_REQUEST['exp_day2'] == '') $_REQUEST['exp_day2'] = date("j");
            if($_REQUEST['exp_month2'] == '') $_REQUEST['exp_month2'] = date("n");
            if($_REQUEST['exp_year2'] == '') $_REQUEST['exp_year2'] = date("Y");
            
            //--------------------------------------
            // put settings into session
            $_SESSION['numrows'] = $_REQUEST['numrows'];
            $_SESSION['exp_affiliateid'] = $_REQUEST['exp_affiliateid'];
            $_SESSION['exp_day1'] = $_REQUEST['exp_day1'];
            $_SESSION['exp_month1'] = $_REQUEST['exp_month1'];
            $_SESSION['exp_year1'] = $_REQUEST['exp_year1'];
            $_SESSION['exp_day2'] = $_REQUEST['exp_day2'];
            $_SESSION['exp_month2'] = $_REQUEST['exp_month2'];
            $_SESSION['exp_year2'] = $_REQUEST['exp_year2'];
            $_SESSION['exp_channel'] = $_REQUEST['exp_channel'];
            $_SESSION['exp_episode'] = $_REQUEST['exp_episode'];
            $_SESSION['exp_timeslot'] = $_REQUEST['exp_timeslot'];
            $_SESSION['exp_exit'] = $_REQUEST['exp_exit'];
                
        $where = " where e.affiliateid=a.userid and a.accountid="._q($GLOBALS['Auth']->getAccountID())." and a.rstatus in (".AFFSTATUS_APPROVED.",".AFFSTATUS_NOTAPPROVED.") and e.campcategoryid=c.campcategoryid";

        $where .= " and (".sqlToDays('e.purchasedate')." >= ".sqlToDays($_REQUEST['exp_year1']."-".$_REQUEST['exp_month1']."-".$_REQUEST['exp_day1']).")".
                      " and (".sqlToDays('e.purchasedate')." <= ".sqlToDays($_REQUEST['exp_year2']."-".$_REQUEST['exp_month2']."-".$_REQUEST['exp_day2']).")";
        
        $puserid = preg_replace('/[\'\"]/', '', $_REQUEST['exp_affiliateid']);
        
        if($puserid != '_' && $puserid != '')
        {            
            $where .= " and e.affiliateid="._q($puserid);
        }
        
        if($_REQUEST['exp_channel'] != '_' && $_REQUEST['exp_channel'] != '')
        {            
            $where .= " and e.channel like '%".addslashes($_REQUEST['exp_channel'])."%'";
        }
        if($_REQUEST['exp_episode'] != '_' && $_REQUEST['exp_episode'] != '')
        {            
            $where .= " and e.episode like '%".addslashes($_REQUEST['exp_episode'])."%'";
        }
        if($_REQUEST['exp_timeslot'] != '_' && $_REQUEST['exp_timeslot'] != '')
        {            
            $where .= " and e.timeslot like '%".addslashes($_REQUEST['exp_timeslot'])."%'";
        }
        if($_REQUEST['exp_exit'] != '_' && $_REQUEST['exp_exit'] != '')
        {            
            $where .= " and e.exit like '%".addslashes($_REQUEST['exp_exit'])."%'";
        }
        
        if($_REQUEST['exp_campaign'] != '_' && $_REQUEST['exp_campaign'] != '')
        {            
            $where .= " and c.campaignid="._q($_REQUEST['exp_campaign']);                
        }
        return true;
    }    
    
    //--------------------------------------------------------------------------

    function printListRow($row)
    {
        $view = $this->getView();
        if($view == false || $view == null)
        {
            print '<td><font color="ff0000">no view given</font></td>';
            return false;
        }

        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['expenseid'].'"></td>';
        
        foreach($view->columns as $column)
        {
            switch($column)
            {
                case 'expenseid': print '<td class=listresult>&nbsp;'.$row['expenseid'].'&nbsp;</td>';
                        break;

                case 'bannerid': print '<td class=listresult>&nbsp;'.$row['bannerid'].'&nbsp;</td>';
                        break;
                                                
                case 'totalexpense': print '<td class=listresultnocenter align="right" nowrap>&nbsp;'.$row['totalexpense'].'&nbsp;'.($row['totalexpense'] != '' ? $GLOBALS['Auth']->getSetting('Aff_system_currency') : '').'&nbsp;</td>';
                        break;
                        
                case 'purchasedate': print '<td class=listresult align=right nowrap>&nbsp;'.$row['purchasedate'].'&nbsp;</td>';
                        break;

                case 'expensedate': print '<td class=listresult align=right nowrap>&nbsp;'.$row['expensedate'].'&nbsp;</td>';
                        break;

                case 'campcategoryid': print '<td class=listresult align=right nowrap>&nbsp;'.$this->campCategory[$row['campcategoryid']].'&nbsp;</td>';
                        break;
                        
                case 'rstatus': 
                        print '<td class=listresult align=right nowrap>&nbsp;';
                        
                        if($row['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
                        else if($row['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
                        else if($row['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED;
                        
                        print '&nbsp;</td>';
                        break;
                        
                case 'affiliateid': print '<td class=listresult nowrap>&nbsp;'.$row['userid'].': '.$row['name'].' '.$row['surname'].'&nbsp;</td>';
                        break;
                        
                case 'channel': print '<td class=listresult align=right nowrap>&nbsp;'.$row['channel'].'&nbsp;</td>';
                        break;

                case 'episode': print '<td class=listresult align=right nowrap>&nbsp;'.$row['episode'].'&nbsp;</td>';
                        break;

                case 'timeslot': print '<td class=listresult align=right nowrap>&nbsp;'.$row['timeslot'].'&nbsp;</td>';
                        break;
                case 'exit': print '<td class=listresult align=right nowrap>&nbsp;'.$row['exit'].'&nbsp;</td>';
                break;

                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <?php if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:editTransaction('<?php echo $row['transid']?>');"><?php echo L_G_EDIT?></a>
                                <?php } ?>
                                <?php if($this->checkPermissions('approve')) { ?>
                                  <?php if($row['rstatus'] != AFFSTATUS_APPROVED) { ?>
                                      <option value="javascript:ChangeState('<?php echo $row['transid']?>','approve');"><?php echo L_G_APPROVE?></a>
                                  <?php } ?>
                                  <?php if($row['rstatus'] != AFFSTATUS_SUPPRESSED) { ?>
                                      <option value="javascript:ChangeState('<?php echo $row['transid']?>','suppress');"><?php echo L_G_SUPPRESS?></a>
                                <?php   }
                                   }
                                   if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:Delete('<?php echo $row['transid']?>');"><?php echo L_G_DELETE?></a>
                                <?php } ?>
                            </select>
                        </td>
<?php
                        break;

                default: 
                        print '<td class=listresult>&nbsp;<font color="#ff0000">'.L_G_UNKNOWN.' '.$column.'</font>&nbsp;</td>';
                        break;
            }
        }
    }    
    //--------------------------------------------------------------------------

    function printMassAction()
    {
?>
      <td align=left>&nbsp;&nbsp;&nbsp;<?php echo L_G_SELECTED;?>&nbsp;
        <select name="massaction">
          <option value=""><?php echo L_G_CHOOSEACTION?></option>
          <?php if($this->checkPermissions('approve')) { ?>
               <option value="suppress"><?php echo L_G_SUPPRESS?></a>
          <?php }
             if($this->checkPermissions('approve')) { ?>
               <option value="approve"><?php echo L_G_APPROVE?></a>
          <?php }
             if($this->checkPermissions('delete')) { ?>
               <option value="delete"><?php echo L_G_DELETE?></a>
          <?php } ?>
        </select>
        &nbsp;&nbsp;
        <input type=submit value="<?php echo L_G_SUBMITMASSACTION?>">
      </td>
<?php
    }    
    
    //--------------------------------------------------------------------------

    function prepareExportFile($orderby, $where)
    {
        // prepare file for export
        $fname = 'exp_'.date("Y_m_d").'_'.substr(md5(uniqid(rand(),1)), 0, 6).'.csv';
        $fdirname = $GLOBALS['Auth']->getSetting('Aff_export_dir').$fname;
        
        $exportFile = @fopen($fdirname, "wb");
        if($exportFile == FALSE)
        {
            showMsg(L_G_CANNOTWRITETOEXPORTDIR, 'error');
            return false;
        }

        foreach($this->getAvailableColumns() as $key => $col) {
            $str .= ';'.csvFormat($col[0]);
        }
        $str = ltrim($str, ";");
                
        fwrite($exportFile, $str."\r\n");
        
        $sql = "select a.userid, a.name, a.surname, ".
        "c.campaignid, ".
        "e.expenseid, e.purchasedate, e.expensedate, ".
        "e.totalexpense, e.bannerid, e.affiliateid, ".
        "e.campcategoryid, e.channel, e.episode, e.timeslot, e.exit ".
        "from wd_pa_expenses e, wd_g_users a, wd_pa_campaigncategories c";

        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);
        
        while(!$rs->EOF)
        {
            $str = csvFormat($rs->fields['expenseid']);
            $str .= ';'.csvFormat($rs->fields['purchasedate']);
            $str .= ';'.csvFormat($rs->fields['expensedate']);
            $str .= ';'.csvFormat($rs->fields['totalexpense']);
            $str .= ';'.csvFormat($rs->fields['bannerid']);
            $str .= ';'.csvFormat($rs->fields['name'].' '.$rs->fields['surname']);
            $str .= ';'.csvFormat($this->campCategory[$rs->fields['campcategoryid']]);


            if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $rstatus = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $rstatus = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $rstatus = L_G_SUPPRESSED;

            $str .= ';'.csvFormat($rstatus);

            $str .= ';'.csvFormat(($rs->fields['payoutstatus'] == AFFSTATUS_APPROVED ? L_G_YES : L_G_NO));
            $str .= ';'.csvFormat($rs->fields['channel']);
            $str .= ';'.csvFormat($rs->fields['episode']);
            $str .= ';'.csvFormat($rs->fields['timeslot']);            
            $str .= ';'.csvFormat($rs->fields['exit']);
            
            fwrite($exportFile, $str."\r\n");        
            
            $rs->MoveNext();
        }
        
        fclose($exportFile);

        $this->assign('a_exportFileName', $fname);
        
        return true;
        
    }    
}
?>
