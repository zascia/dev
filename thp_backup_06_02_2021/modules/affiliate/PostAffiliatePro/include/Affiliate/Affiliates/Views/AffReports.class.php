<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QCore_Bl_GlobalFuncs');

class Affiliate_Affiliates_Views_AffReports extends QUnit_UI_TemplatePage
{
    var $viewCampManager;
    var $denyStatus = array();

    //------------------------------------------------------------------------

    function Affiliate_Affiliates_Views_AffReports() {
        $this->viewCampManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
        $this->blTimeStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TimerangeStatistics');
        $this->blTrendStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TrendStatistics');
        $this->blSaleStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleStatistics');
        $this->blCampaign =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Campaign');
        $this->blSettings =& QUnit_Global::newObj('Affiliate_Affiliates_Bl_Settings');
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Affiliates_Bl_Affiliate');
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_REPORTS,'index.php?md=Affiliate_Affiliates_Views_AffReports');
    }

    //------------------------------------------------------------------------

    function process()
    {
        $this->assign('a_md', 'Affiliate_Affiliates_Views_AffReports');
        if($_REQUEST['reporttype'] == '')
            $_REQUEST['reporttype'] = 'quick';

        $this->loadAffiliateTransactionViewSettings();

        if(!empty($_REQUEST['reporttype']))
        {
            //panel custom description
            $this->assign('a_panel_type', $_REQUEST['reporttype']);

            switch($_REQUEST['reporttype'])
            {
                case 'quick':
                    if($this->showReportQuick())
                        return;
                    break;

                case 'transactions':
                    if($this->showReportTransactions())
                        return;
                    break;

                case 'traffic':
                    if($this->showReportTraffic())
                        return;
                    break;

                case 'subaffiliates':
                    if($this->drawTree())
                        return;
                    break;

                case 'subid':
                    if($this->showReportSubId())
                        return;
                    break;
            }
        }
    }

    //------------------------------------------------------------------------

    function showReportTraffic()
    {
        $this->navigationAddURL(L_G_TRAFFIC,'index.php?md=Affiliate_Affiliates_Views_AffReports&reporttype=traffic');
        $this->getCampaignsForFilter();

        $panel_settings = QUnit_Global::newObj('Affiliate_Affiliates_Views_AffPanelSettings');
        $this->assign('a_description', L_G_AFF_TRAFFICANDSALES_DESCRIPTION);
        $this->assign('a_panel_settings', $panel_settings->loadPanelSettings('traffic'));
        $this->addContent('section_descriptions');

        $this->assign('a_form_preffix', 'rt_');
        $this->assign('a_form_name', 'FilterForm');

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rt_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }

        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['rt_campaign'] == '') $_REQUEST['rt_campaign'] = '_';
        if($_REQUEST['rt_reporttype'] == '') $_REQUEST['rt_reporttype'] = 'perday';
        if($_REQUEST['rt_pd_day'] == '') $_REQUEST['rt_pd_day'] = date("j");
        if($_REQUEST['rt_pd_month'] == '') $_REQUEST['rt_pd_month'] = date("n");
        if($_REQUEST['rt_pd_year'] == '') $_REQUEST['rt_pd_year'] = date("Y");
        if($_REQUEST['rt_pw_week'] == '') $_REQUEST['rt_pw_week'] = date("W");
        if($_REQUEST['rt_pw_year'] == '') $_REQUEST['rt_pw_year'] = date("Y");
        if($_REQUEST['rt_pm_month'] == '') $_REQUEST['rt_pm_month'] = date("n");
        if($_REQUEST['rt_pm_year'] == '') $_REQUEST['rt_pm_year'] = date("Y");
        if($_REQUEST['rt_py_year'] == '') $_REQUEST['rt_py_year'] = date("Y");
	//----------------------------------------
	//added by AdAstra
	if($_REQUEST['rt_date_select_mode'] == '') $_REQUEST['rt_date_select_mode'] = 1;
	//---------------------------------------
	

        //--------------------------------------
        // put settings into session
        $_SESSION['rt_campaign'] = $_REQUEST['rt_campaign'];
        $_SESSION['rt_reporttype'] = $_REQUEST['rt_reporttype'];
        $_SESSION['rt_pd_day'] = $_REQUEST['rt_pd_day'];
        $_SESSION['rt_pd_month'] = $_REQUEST['rt_pd_month'];
        $_SESSION['rt_pd_year'] = $_REQUEST['rt_pd_year'];
        $_SESSION['rt_pw_week'] = $_REQUEST['rt_pw_week'];
        $_SESSION['rt_pw_year'] = $_REQUEST['rt_pw_year'];
        $_SESSION['rt_pm_month'] = $_REQUEST['rt_pm_month'];
        $_SESSION['rt_pm_year'] = $_REQUEST['rt_pm_year'];
        $_SESSION['rt_py_year'] = $_REQUEST['rt_py_year'];
	//--------------------------------------------------
	//added by AdAstra
	$_SESSION['rt_date_select_mode'] = $_REQUEST['rt_date_select_mode'];
	//--------------------------------------------------

        QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');

        $campaigns = $this->viewCampManager->getCampaignsAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_traffic_filter');

        if($_REQUEST['rt_reporttype'] == 'perday')
        {
            $reportType = 'hourly';
            $d1 = ($_REQUEST['rt_pd_day']   == '_') ? 1         : $_REQUEST['rt_pd_day'];
            $m1 = ($_REQUEST['rt_pd_month'] == '_') ? 1         : $_REQUEST['rt_pd_month'];
            $y1 = ($_REQUEST['rt_pd_year']  == '_') ? PAP_STARTING_YEAR      : $_REQUEST['rt_pd_year'];
            $d2 = ($_REQUEST['rt_pd_day']   == '_') ? 31        : $_REQUEST['rt_pd_day'];
            $m2 = ($_REQUEST['rt_pd_month'] == '_') ? 12        : $_REQUEST['rt_pd_month'];
            $y2 = ($_REQUEST['rt_pd_year']  == '_') ? date("Y") : $_REQUEST['rt_pd_year'];
        }
        else if($_REQUEST['rt_reporttype'] == 'permonth')
        {
            $reportType = 'daily';
            $d1 = 1;
            $m1 = ($_REQUEST['rt_pm_month'] == '_') ? 1         : $_REQUEST['rt_pm_month'];
            $y1 = ($_REQUEST['rt_pm_year']  == '_') ? PAP_STARTING_YEAR      : $_REQUEST['rt_pm_year'];
            $d2 = 31;
            $m2 = ($_REQUEST['rt_pm_month'] == '_') ? 12        : $_REQUEST['rt_pm_month'];
            $y2 = ($_REQUEST['rt_pm_year']  == '_') ? date("Y") : $_REQUEST['rt_pm_year'];
        }
        else if($_REQUEST['rt_reporttype'] == 'perweek')
        {
            $reportType = 'weekly';
            $d1 = 1;
            $m1 = ($_REQUEST['rt_pw_week'] == '_') ? 1         : $_REQUEST['rt_pw_week'];
            $y1 = ($_REQUEST['rt_pw_year'] == '_') ? PAP_STARTING_YEAR      : $_REQUEST['rt_pw_year'];
            $d2 = 31;
            $m2 = ($_REQUEST['rt_pw_week'] == '_') ? 53        : $_REQUEST['rt_pw_week'];
            $y2 = ($_REQUEST['rt_pw_year'] == '_') ? date("Y") : $_REQUEST['rt_pw_year'];
        }
        else if($_REQUEST['rt_reporttype'] == 'peryear')
        {
            $reportType = 'monthly';
            $d1 = 1;
            $m1 = 1;
            $y1 = ($_REQUEST['rt_py_year'] == '_') ? PAP_STARTING_YEAR      : $_REQUEST['rt_py_year'];
            $d2 = 31;
            $m2 = 12;
            $y2 = ($_REQUEST['rt_py_year'] == '_') ? date("Y") : $_REQUEST['rt_py_year'];
        }
	//----------------------------------------------
	//added by AdAstra net
	//added new variable $dateSelectMode, added new param to $this->$blTrendStat->getTrendStats
	$dateSelectMode = $_REQUEST['rt_date_select_mode'];

        $trend = $this->blTrendStat->getTrendStats(
                                                     $GLOBALS['Auth']->getUserID(),
                                                     $_REQUEST['rt_campaign'],
                                                     $reportType,
                                                     $d1, $m1, $y1,
                                                     $d2, $m2, $y2,
                                                     '', '', true, $dateSelectMode);

        if($reportType == 'hourly')
        {
            $periodMin = 0;
            $periodMax = 23;

            $this->assign('a_period', L_G_HOURS);
        }
        else if($reportType == 'daily')
        {
            $periodMin = 1;
            $periodMax = ($_REQUEST['rt_pm_month'] == '_') ? 31 : getDaysInMonth($_REQUEST['rt_pm_month'], $_REQUEST['rt_pm_year']);

            $this->assign('a_period', L_G_DAYS);
        }
        else if($reportType == 'weekly')
        {
            $periodMin = 1;
            $periodMax = 7;

            $this->assign('a_period', L_G_DAYS);
        }
        else if($reportType == 'monthly')
        {
            $periodMin = 1;
            $periodMax = 12;

            $this->assign('a_period', L_G_MONTHS);
        }

        for($i=$periodMin; $i<=$periodMax; $i++)
        {
            switch($reportType) {
                case 'monthly':
                    $labels[] = constant($GLOBALS['wd_monthname'][$i]);
                    break;
                case 'weekly':
                    $labels[] = constant($GLOBALS['wd_dayname'][$i]);
                    break;
                default:
                    $labels[] = $i;
                    break;
            }

            $valuesImps[0][] = $trend['imps'][$i]['unique'];
            $valuesImps[1][] = $trend['imps'][$i]['all'];
            $valuesCpm[] = $trend['cmp'][$i];
            $valuesClicks[] = $trend['clicks'][$i];
            $valuesSales[] = $trend['sales'][$i];
            $valuesLeads[] = $trend['leads'][$i];
            $valuesRevenue[] = $trend['revenue'][$i];
        }

        // make graphs
        $graph = QUnit_Global::newobj('QUnit_Graphics_Graph');
        $params = array(
                    'type' => array('3d_column', 'column', 'line'),
                    'library' => 'xmlswf',
                    'values' => $valuesImps,
                    'labels' => $labels,
                    'width' => '777',
                    'legend' => array(L_G_UNIQUEIMPRESSIONS, L_G_ALLIMPRESSIONS)
                  );
        $gdata = $graph->create($params);
        $this->assign('a_impstrend_graph', $gdata);

        $params['values'] = $valuesCpm;
        $gdata = $graph->create($params);
        $this->assign('a_cpmstrend_graph', $gdata);

        $params['values'] = $valuesClicks;
        $gdata = $graph->create($params);
        $this->assign('a_clickstrend_graph', $gdata);

        $params['values'] = $valuesSales;
        $gdata = $graph->create($params);
        $this->assign('a_salestrend_graph', $gdata);

        $params['values'] = $valuesLeads;
        $gdata = $graph->create($params);
        $this->assign('a_leadstrend_graph', $gdata);

        $params['values'] = $valuesRevenue;
        $gdata = $graph->create($params);
        $this->assign('a_revenuetrend_graph', $gdata);

        $this->assign('a_periodMin', $periodMin);
        $this->assign('a_periodMax', $periodMax);
        $this->assign('a_reportType', $reportType);
        $this->assign('a_trendData', $trend);

        $this->setSupportedResults($_REQUEST['rt_campaign']);

        $this->addContent('rep_traffic_list');
    }

    //------------------------------------------------------------------------

    function loadAffiliateTransactionViewSettings() {

        $aff_trans_rep_settings = $GLOBALS['Auth']->getSettings();
        if ($aff_trans_rep_settings['Aff_allow_declined_trans'] == null) {
            $aff_trans_rep_settings['Aff_allow_declined_trans'] = 'allow';
        }
        if ($aff_trans_rep_settings['Aff_allow_pending_trans'] == null) {
            $aff_trans_rep_settings['Aff_allow_pending_trans'] = 'allow';
        }
        $_POST['allow_declined_trans'] = $aff_trans_rep_settings['Aff_allow_declined_trans'];
        $_POST['allow_pending_trans'] = $aff_trans_rep_settings['Aff_allow_pending_trans'];

        $this->denyStatus = array();
        if ($aff_trans_rep_settings['Aff_allow_pending_trans'] == 'deny') {
            $this->denyStatus[] = AFFSTATUS_NOTAPPROVED;
        }
        if ($aff_trans_rep_settings['Aff_allow_declined_trans'] == 'deny') {
            $this->denyStatus[] = AFFSTATUS_SUPPRESSED;
        }
    }

    //------------------------------------------------------------------------

    function showReportTransactions()
    {
        $this->navigationAddURL(L_G_TRANSACTIONS,'index.php?md=Affiliate_Affiliates_Views_AffReports&reporttype=transactions');
        $this->getCampaignsForFilter();

        $panel_settings = QUnit_Global::newObj('Affiliate_Affiliates_Views_AffPanelSettings');
        $this->assign('a_description', L_G_AFF_TRANSACTION_DESCRIPTION);
        $this->assign('a_panel_settings', $panel_settings->loadPanelSettings('transactions'));
        $this->addContent('section_descriptions');

        $this->assign('a_form_preffix', 'rq_');
        $this->assign('a_form_name', 'FilterForm');
        $this->assign('a_filterColumns', array('t.orderid' => L_G_ORDERID,
                                               't.data1' => L_G_DATA1,
                                               't.data2' => L_G_DATA2,
                                               't.data3' => L_G_DATA3,));
                                               
        if ($_REQUEST['commited'] != 'yes') {
            //--------------------------------------
            // try to load settings from session
            foreach($_SESSION as $k => $v)
            {
                if(strstr($k, 'rq_status') !== false && ($_REQUEST['status_comitted'] == '1')) {
                    continue;
                }
                if(strstr($k, 'rq_transtype') !== false && ($_REQUEST['transtype_comitted'] == '1')) {
                    continue;
                }
                if(strpos($k, 'rq_') === 0 && $_REQUEST[$k] == '')
                    $_REQUEST[$k] = $v;
                if($k == 'numrows' && $_REQUEST[$k] == '')
                    $_REQUEST[$k] = $v;
            }
        }

	//------------------------------------------
	//clear checkboxes
	if( $_REQUEST['filtered'] == '1' ){
	    if( !isset( $_REQUEST['rq_transtype'] ) ) $_REQUEST['rq_transtype'] = array();
	    if( !isset( $_REQUEST['rq_status'] ) ) $_REQUEST['rq_status'] = array();
	}
	//------------------------------------------
	

        //--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
        if($_REQUEST['rq_campaign'] == '') $_REQUEST['rq_campaign'] = '_';
        if($_REQUEST['rq_transtype'] == '') $_REQUEST['rq_transtype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();
        if($_REQUEST['rq_status'] == '') $_REQUEST['rq_status'] = '_';
        if($_REQUEST['rq_reporttype'] == '') $_REQUEST['rq_reporttype'] = 'today';
        if($_REQUEST['rq_day1'] == '') $_REQUEST['rq_day1'] = date("j");
        if($_REQUEST['rq_month1'] == '') $_REQUEST['rq_month1'] = date("n");
        if($_REQUEST['rq_year1'] == '') $_REQUEST['rq_year1'] = date("Y");
        if($_REQUEST['rq_day2'] == '') $_REQUEST['rq_day2'] = date("j");
        if($_REQUEST['rq_month2'] == '') $_REQUEST['rq_month2'] = date("n");
        if($_REQUEST['rq_year2'] == '') $_REQUEST['rq_year2'] = date("Y");
        if($_REQUEST['rq_timeselect'] == '') $_REQUEST['rq_timeselect'] = TIME_PRESET;
        if($_REQUEST['rq_timepreset'] == '') $_REQUEST['rq_timepreset'] = TIME_TODAY;
	//-----------------------------------------
	//added by AdAstra
	if($_REQUEST['rq_date_select_mode'] == '') $_REQUEST['rq_date_select_mode'] = 1;
	//----------------------------------------

        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['rq_campaign'] = $_REQUEST['rq_campaign'];
        $_SESSION['rq_transtype'] = $_REQUEST['rq_transtype'];
        $_SESSION['rq_status'] = $_REQUEST['rq_status'];
        $_SESSION['rq_reporttype'] = $_REQUEST['rq_reporttype'];
        $_SESSION['rq_day1'] = $_REQUEST['rq_day1'];
        $_SESSION['rq_month1'] = $_REQUEST['rq_month1'];
        $_SESSION['rq_year1'] = $_REQUEST['rq_year1'];
        $_SESSION['rq_day2'] = $_REQUEST['rq_day2'];
        $_SESSION['rq_month2'] = $_REQUEST['rq_month2'];
        $_SESSION['rq_year2'] = $_REQUEST['rq_year2'];
        $_SESSION['rq_custom1'] = $_REQUEST['rq_custom1'];
        $_SESSION['rq_custom2'] = $_REQUEST['rq_custom2'];
        $_SESSION['rq_custom3'] = $_REQUEST['rq_custom3'];
        $_SESSION['rq_custom1data'] = $_REQUEST['rq_custom1data'];
        $_SESSION['rq_custom2data'] = $_REQUEST['rq_custom2data'];
        $_SESSION['rq_custom3data'] = $_REQUEST['rq_custom3data'];
        $_SESSION['rq_timeselect'] = $_REQUEST['rq_timeselect'];
        $_SESSION['rq_timepreset'] = $_REQUEST['rq_timepreset'];
	//--------------------------------
	//added by AdAstra
	$_SESSION['rq_date_select_mode'] = $_REQUEST['rq_date_select_mode'];
	//-------------------------------
	
	//-------------------------------
        // process time filter
        if($_REQUEST['rq_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['rq_timepreset'], 'rq_'));
        }

        QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');

        $campaigns = $this->viewCampManager->getCampaignsAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_trans_filter');

        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['rq_campaign']);

        if(empty($_REQUEST['list_page']))
            $page = 0;
        else
            $page = $_REQUEST['list_page'];

        if($_REQUEST['rq_transtype'] != '')
        {
            $transType = $_REQUEST['rq_transtype'];
        }

        if($_REQUEST['rq_status'] != '' && $_REQUEST['rq_status'] != '_')
            $status = $_REQUEST['rq_status'];
        else
            $status = '';

        $AffiliateID = $GLOBALS['Auth']->getUserID();

         if ($_REQUEST['rq_advanced_filter_show'] == '1') {
            $custom1data = preg_replace('/[\'\"]/', '', $_REQUEST['rq_custom1data']);
            $custom2data = preg_replace('/[\'\"]/', '', $_REQUEST['rq_custom2data']);
            $custom3data = preg_replace('/[\'\"]/', '', $_REQUEST['rq_custom3data']);

            $transType = ($_REQUEST['rq_transtype'] == '') ? array() : $_REQUEST['rq_transtype'];
            $status = ($_REQUEST['rq_status'] == '') ? array() : $_REQUEST['rq_status'];

            $extrafilter = array();

            if ($custom1data != '')
                $extrafilter[$_REQUEST['rq_custom1']] = $custom1data;
            if ($custom2data != '')
                $extrafilter[$_REQUEST['rq_custom2']] = $custom2data;
            if ($custom3data != '')
                $extrafilter[$_REQUEST['rq_custom3']] = $custom3data;

            $conditions = array(
                                'CampaignID' => $CampaignID,
                                'UserID' => $AffiliateID,
                                'TransactionType' => $transType,
                                'Status' => $status,
                                'denyStatus' => $this->denyStatus,
                                'page' => $page,
                                'rowsPerPage' => $_REQUEST['numrows'],
                                'day1'   => $_REQUEST['rq_day1'],
                                'month1' => $_REQUEST['rq_month1'],
                                'year1'  => $_REQUEST['rq_year1'],
                                'day2'   => $_REQUEST['rq_day2'],
                                'month2' => $_REQUEST['rq_month2'],
                                'year2'  => $_REQUEST['rq_year2'],
                                'extrafilter' => $extrafilter
                            );
        } else {
            $conditions = array(
                                'CampaignID' => $CampaignID,
                                'UserID' => $AffiliateID,
                                'TransactionType' => array_keys($GLOBALS['Auth']->getSupportedCommissions(false)),
                                'page' => $page,
                                'rowsPerPage' => $_REQUEST['numrows'],
                                'day1'   => $_REQUEST['rq_day1'],
                                'month1' => $_REQUEST['rq_month1'],
                                'year1'  => $_REQUEST['rq_year1'],
                                'day2'   => $_REQUEST['rq_day2'],
                                'month2' => $_REQUEST['rq_month2'],
                                'year2'  => $_REQUEST['rq_year2'],
                                'denyStatus' => $this->denyStatus,
                            );
        }
	//-------------------------------------------
	//added by AdAstra
	$conditions['date_select_mode'] = $_REQUEST['date_select_mode'];
	//-------------------------------------------

        $transdata = $this->blSaleStat->getTransactionsStats($conditions);
        $summaries = $this->blSaleStat->getTransactionsSummaries($conditions);

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($transdata['transactions']);
        $this->assign('a_list_data', $list_data);

        if($AffiliateID != '')
        {
            $this->assign('a_summaries', $summaries[$AffiliateID]);
        }
        else
        {
            $summ = array();
            foreach($summaries as $aff => $summary)
            {
                $summ['paid'] += $summary['paid'];
                $summ['pending'] += $summary['pending'];
                $summ['approved'] += $summary['approved'];
                $summ['reversed'] += $summary['reversed'];
                $summ['totalcost'] += $summary['totalcost'];
            }

            $this->assign('a_summaries', $summ);
        }

        $this->pageLimitsAssign();

        $this->assign('a_geo_allowed', $GLOBALS['Auth']->getSetting('Glob_acct_geo_allowed'));
        if($GLOBALS['Auth']->getSetting('Glob_acct_geo_allowed') == '1') {
            $blIpCountry = QUnit_Global::newObj('QCore_Bl_IpCountry');
            $this->assign('a_country_info', $blIpCountry->getCountriesAsArray());
        }

        $this->setSupportedResults($CampaignID);
        $this->addContent('rep_trans_list');
    }

    //------------------------------------------------------------------------

    function showReportSubId()
    {
        $this->navigationAddURL(L_G_SUBID,'index.php?md=Affiliate_Affiliates_Views_AffReports&reporttype=subid');
        $this->getCampaignsForFilter();

        $panel_settings = QUnit_Global::newObj('Affiliate_Affiliates_Views_AffPanelSettings');
        $this->assign('a_description', L_G_AFF_SUBID_DESCRIPTION);
        $this->assign('a_panel_settings', $panel_settings->loadPanelSettings('subid'));
        $this->addContent('section_descriptions');

        //--------------------------------------
        // try to load settings from session
        if($_REQUEST['commited'] != 'yes') {
            foreach($_SESSION as $k => $v) {
                if(strpos($k, 'rq_') === 0 && $_REQUEST[$k] == '')
                    $_REQUEST[$k] = $v;
                if($k == 'numrows' && $_REQUEST[$k] == '')
                    $_REQUEST[$k] = $v;
            }
        }

        //--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
        //if($_REQUEST['rq_affiliate'] == '') $_REQUEST['rq_affiliate'] = '_';
        if($_REQUEST['rq_campaign'] == '') $_REQUEST['rq_campaign'] = '_';

        if($_REQUEST['rq_reporttype'] == '') $_REQUEST['rq_reporttype'] = 'today';
        if($_REQUEST['rq_day1'] == '') $_REQUEST['rq_day1'] = date("j");
        if($_REQUEST['rq_month1'] == '') $_REQUEST['rq_month1'] = date("n");
        if($_REQUEST['rq_year1'] == '') $_REQUEST['rq_year1'] = date("Y");
        if($_REQUEST['rq_day2'] == '') $_REQUEST['rq_day2'] = date("j");
        if($_REQUEST['rq_month2'] == '') $_REQUEST['rq_month2'] = date("n");
        if($_REQUEST['rq_year2'] == '') $_REQUEST['rq_year2'] = date("Y");

        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['rq_affiliate'] = $_REQUEST['rq_affiliate'];
        $_SESSION['rq_campaign'] = $_REQUEST['rq_campaign'];
        $_SESSION['rq_reporttype'] = $_REQUEST['rq_reporttype'];
        $_SESSION['rq_day1'] = $_REQUEST['rq_day1'];
        $_SESSION['rq_month1'] = $_REQUEST['rq_month1'];
        $_SESSION['rq_year1'] = $_REQUEST['rq_year1'];
        $_SESSION['rq_day2'] = $_REQUEST['rq_day2'];
        $_SESSION['rq_month2'] = $_REQUEST['rq_month2'];
        $_SESSION['rq_year2'] = $_REQUEST['rq_year2'];
        $_SESSION['rq_data1'] = $_REQUEST['rq_data1'];
        $_SESSION['rq_data2'] = $_REQUEST['rq_data2'];
        $_SESSION['rq_data3'] = $_REQUEST['rq_data3'];

        $campaigns = $this->viewCampManager->getCampaignsAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_subid_filter');

        //------------------------------

        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['rq_campaign']);

        if($_REQUEST['rq_reporttype'] == 'timerange')
        {
            $d1 = $_REQUEST['rq_day1'];
            $m1 = $_REQUEST['rq_month1'];
            $y1 = $_REQUEST['rq_year1'];
            $d2 = $_REQUEST['rq_day2'];
            $m2 = $_REQUEST['rq_month2'];
            $y2 = $_REQUEST['rq_year2'];
        }
        else if($_REQUEST['rq_reporttype'] == 'today')
        {
            $d1 = date("j");
            $m1 = date("n");
            $y1 = date("Y");
            $d2 = date("j");
            $m2 = date("n");
            $y2 = date("Y");
        }
        else if($_REQUEST['rq_reporttype'] == 'thismonth')
        {
            $d1 = 1;
            $m1 = date("n");
            $y1 = date("Y");
            $m2 = date("n");
            $y2 = date("Y");
            $d2 = getDaysInMonth($m2, $y2);
        }
        else if($_REQUEST['rq_reporttype'] == 'thisweek')
        {
            $d1 = date("j");
            $m1 = date("n");
            $y1 = date("Y");
            $d2 = date("j");
            $m2 = date("n");
            $y2 = date("Y");

            $dayOfWeek = date("w");

            // compute beginning of week
            $beginOfWeek = (computeDateToDays(date("j"), date("n"), date("Y")) - ($dayOfWeek - 1));
            computeDaysToDate($beginOfWeek, $d1, $m1, $y1);

            // compute end of week
            $endOfWeek = (computeDateToDays(date("j"), date("n"), date("Y")) + (7 - $dayOfWeek));
            computeDaysToDate($endOfWeek, $d2, $m2, $y2);
        }

        if(empty($_REQUEST['list_page']))
            $page = 0;
        else
            $page = $_REQUEST['list_page'];

        $conditions = array(
                            'CampaignID' => $CampaignID,
                            'UserID' => $GLOBALS['Auth']->getUserID(),
                            'page' => $page,
                            'rowsPerPage' => $_REQUEST['numrows'],
                            'day1' => $d1,
                            'month1' => $m1,
                            'year1' => $y1,
                            'day2' => $d2,
                            'month2' => $m2,
                            'year2' => $y2,
                            'data1' =>  $_REQUEST['rq_data1'],
                            'data2' =>  $_REQUEST['rq_data2'],
                            'data3' =>  $_REQUEST['rq_data3'],
                        );

        $subIdStat = QUnit_Global::newObj('Affiliate_Scripts_Bl_SubIdStatistics');
        $data = $subIdStat->getStats($conditions);

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($data);
        $this->assign('a_list_data', $list_data);

        $this->pageLimitsAssign();

        $this->addContent('rep_subid_list');
    }

    //------------------------------------------------------------------------

    function showReportQuick()
    {
        $this->navigationAddURL(L_G_QUICK,'index.php?md=Affiliate_Affiliates_Views_AffReports&reporttype=quick');
        $this->getCampaignsForFilter();
        
        $panel_settings = QUnit_Global::newObj('Affiliate_Affiliates_Views_AffPanelSettings');
        $this->assign('a_description', L_G_AFF_QUICKREPORT_DESCRIPTION);
        $this->assign('a_panel_settings', $panel_settings->loadPanelSettings('quick'));
        $this->addContent('section_descriptions');

        $this->assign('a_form_preffix', 'rq_');
        $this->assign('a_form_name', 'FilterForm');

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rq_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }

        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['rq_campaign'] == '') $_REQUEST['rq_campaign'] = '_';
        if($_REQUEST['rq_reporttype'] == '') $_REQUEST['rq_reporttype'] = 'today';
        if($_REQUEST['rq_day1'] == '') $_REQUEST['rq_day1'] = date("j");
        if($_REQUEST['rq_month1'] == '') $_REQUEST['rq_month1'] = date("n");
        if($_REQUEST['rq_year1'] == '') $_REQUEST['rq_year1'] = date("Y");
        if($_REQUEST['rq_day2'] == '') $_REQUEST['rq_day2'] = date("j");
        if($_REQUEST['rq_month2'] == '') $_REQUEST['rq_month2'] = date("n");
        if($_REQUEST['rq_year2'] == '') $_REQUEST['rq_year2'] = date("Y");
        if($_REQUEST['rq_timeselect'] == '') $_REQUEST['rq_timeselect'] = TIME_PRESET;
        if($_REQUEST['rq_timepreset'] == '') $_REQUEST['rq_timepreset'] = TIME_TODAY;

        //--------------------------------------
        // put settings into session
        $_SESSION['rq_campaign'] = $_REQUEST['rq_campaign'];
        $_SESSION['rq_reporttype'] = $_REQUEST['rq_reporttype'];
        $_SESSION['rq_day1'] = $_REQUEST['rq_day1'];
        $_SESSION['rq_month1'] = $_REQUEST['rq_month1'];
        $_SESSION['rq_year1'] = $_REQUEST['rq_year1'];
        $_SESSION['rq_day2'] = $_REQUEST['rq_day2'];
        $_SESSION['rq_month2'] = $_REQUEST['rq_month2'];
        $_SESSION['rq_year2'] = $_REQUEST['rq_year2'];
        $_SESSION['rq_timeselect'] = $_REQUEST['rq_timeselect'];
        $_SESSION['rq_timepreset'] = $_REQUEST['rq_timepreset'];

        // process time filter
        if($_REQUEST['rq_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['rq_timepreset'], 'rq_'));
        }

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_quick_filter');

        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['rq_campaign']);

        $data = $this->blTimeStat->getTimerangeStats(
                        $GLOBALS['Auth']->getUserID(), $CampaignID,
                        $_REQUEST['rq_day1'], $_REQUEST['rq_month1'], $_REQUEST['rq_year1'],
                        $_REQUEST['rq_day2'], $_REQUEST['rq_month2'], $_REQUEST['rq_year2'],
                        $GLOBALS['Auth']->getAccountID()
                        );

        $this->assign('a_data', $data);

        $this->setSupportedResults($CampaignID);

        $this->assign('a_denyStatus', $this->denyStatus);

        $this->addContent('rep_quick_list');
    }

    //------------------------------------------------------------------------

    //--------------------------------------------------------------------------

    function drawTree()
    {
        $this->navigationAddURL(L_G_SUBAFFILIATES,'index.php?md=Affiliate_Affiliates_Views_AffReports&reporttype=subaffiliates');

        $panel_settings = QUnit_Global::newObj('Affiliate_Affiliates_Views_AffPanelSettings');
        $this->assign('a_description', L_G_AFF_SUBAFFILIATES_DESCRIPTION);
        $this->assign('a_panel_settings', $panel_settings->loadPanelSettings('subaffiliates'));
        $this->addContent('section_descriptions');

        $treeData = array();
        $params = array();
        $params['rootID'] = $GLOBALS['Auth']->getUserId();
        $params['tab'] = '';
        $params['tabLevel'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $params['maxLevel'] = 20;
        $params['table_name'] = 'wd_g_users';
        $params['column_id'] = 'userid';
        $params['column_parentid'] = 'parentuserid';
        $params['getvalues'] = array('userid', 'name', 'surname', 'username','weburl', 'rstatus');
        $params['where'] = array('deleted' => '0', /*'rstatus' => AFFSTATUS_APPROVED*/);
        $params['order'] = array('name');

        QCore_Bl_GlobalFuncs::getTree($treeData, $params);

        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($treeData);
        $this->assign('a_list_data', $list_data);

        // count subaffiliates
        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($treeData);
        $max_level = 0;
        while($data = $list_data->getNextRecord()) {
            if ($data['level'] == '') $data['level'] = 0;
            $sub_affiliates[$data['level']]++;
            $max_level = max($max_level, $data['level']);
        }
        for ($i=0; $i<=$max_level; $i++) {
            if ($sub_affiliates[$i] == '') $sub_affiliates[$i] = 0;
        }
        
        $this->assign('a_sub_affilates', $sub_affiliates);
        $this->assign('a_max_depth', $max_level);
        
        $max_visble_level = $GLOBALS['Auth']->getSetting('Aff_tiers_visible_to_user');
        if($max_visble_level == '') $max_visble_level = 999999;       
        $this->assign('a_max_level', $max_visble_level);

        $this->addContent('um_tree');

        return true;
    }

    //------------------------------------------------------------------------

    function setSupportedResults($campaign)
    {
        // get supported results
        $signupSupported = false;
        $referralSupported = false;
        $clickSupported = false;
        $clickSaveSupported = false;
        $clickRevenueSupported = false;
        $cpmSupported = false;
        $saleSupported = false;
        $leadSupported = false;

        $campaignUsed = false;
        if($campaign != '' && $campaign != '_')
        {
            // check if this campaign supports CPM
            $campaignInfo = $this->blCampaign->load($campaign);
            $campaignUsed = true;
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_signup_commissions') == 1 && !$campaignUsed)
        {
            $signupSupported = true;
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_referral_commissions') == 1 && !$campaignUsed)
        {
            $referralSupported = true;
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1)
        {
            // no campaign defined, set supported transaction types
            if(!$campaignUsed || ($campaignUsed && $campaignInfo['commtype'] & TRANSTYPE_CLICK))
            {
                $clickSupported = true;
                $clickRevenueSupported = true;
                $clickSaveSupported = true;
            }
        } else {
            if($GLOBALS['Auth']->getSetting('Aff_dont_save_click_transaction') != 1) {
                $clickSaveSupported = true;
            }
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions') == 1)
        {
            // no campaign defined, set supported transaction types
            if(!$campaignUsed || ($campaignUsed && $campaignInfo['commtype'] & TRANSTYPE_CPM))
            {
                $cpmSupported = true;
            }
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_sale_commissions') == 1)
        {
            // no campaign defined, set supported transaction types
            if(!$campaignUsed || ($campaignUsed && $campaignInfo['commtype'] & TRANSTYPE_SALE))
            {
                $saleSupported = true;
            }
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_lead_commissions') == 1)
        {
            // no campaign defined, set supported transaction types
            if(!$campaignUsed || ($campaignUsed && $campaignInfo['commtype'] & TRANSTYPE_LEAD))
            {
                $leadSupported = true;
            }
        }

        $this->assign('a_signupSupported', $signupSupported);
        $this->assign('a_referralSupported', $referralSupported);
        $this->assign('a_clickSupported', $clickSupported);
        $this->assign('a_clickSaveSupported', $clickSaveSupported);
        $this->assign('a_clickRevenueSupported', $clickRevenueSupported);
        $this->assign('a_cpmSupported', $cpmSupported);
        $this->assign('a_saleSupported', $saleSupported);
        $this->assign('a_leadSupported', $leadSupported);
    }

    //--------------------------------------------------------------------------

    function getCampaignsForFilter()
    {
        $campaigns = $this->viewCampManager->getCampaignsAsArray();
        
        if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1') {
            $params = array('userID' => $GLOBALS['Auth']->getUserID());
            $affcamps = $this->blAffiliate->getAffiliateCampaignsStatus($params);

            $params = array('accountid' => $GLOBALS['Auth']->getAccountID());
            $affs_camp = $this->blSettings->getAffCampaignSettings($params);

            $campaigns2 = array();
            foreach($campaigns as $campaign) {
                if($affs_camp[$campaign['campaignid']][SETTINGTYPEPREFIX_AFF_CAMP.'status'] == AFF_CAMP_PRIVATE
                    && $affcamps[$campaign['campaignid']] != AFFSTATUS_APPROVED)
                {
                    // do nothing
                } else {
                    $campaigns2[] = $campaign;
                }
            }
        } else {
            $campaigns2 = $campaigns;
        }
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($campaigns2);

        $this->assign('a_list_campaigns', $list_data);
    }

}
?>
