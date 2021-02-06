<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QCore_Bl_GlobalFuncs');

class Affiliate_Merchants_Views_MerchantReports extends QUnit_UI_TemplatePage
{
    var $blAffiliate;
    var $blTrendStat;
    var $blTimeStat;
    var $blSaleStat;
    var $impClickStat;
    var $blTopAffStat;
    var $blTopCampaignStat;
    var $blCampaign;
    var $viewCampManager;

    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Views_MerchantReports() {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blTrendStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TrendStatistics');
        $this->blTimeStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TimerangeStatistics');
        $this->blSaleStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleStatistics');
        $this->impClickStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_ImpClicksStatistics');
        $this->blTopAffStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TopAffiliateStatistics');
        $this->blTopCampaignStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TopCampaignStatistics');
        $this->blCampaign =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Campaign');
        $this->viewCampManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_REPORTS,'index.php?md=Affiliate_Merchants_Views_MerchantReports');
    }

    //--------------------------------------------------------------------------

    function initPermissions()
    {
        $this->modulePermissions['view'] = true;
        $this->modulePermissions['quick'] = 'aff_rep_quick_report_view';
        $this->modulePermissions['transactions'] = 'aff_rep_transactions_view';
        $this->modulePermissions['traffic'] = 'aff_rep_traffic_and_sales_view';
        $this->modulePermissions['top20affiliates'] = 'aff_rep_top_20_affiliates_view';
        $this->modulePermissions['affiliatecounts'] = 'aff_rep_number_of_affiliates_view';
        $this->modulePermissions['subidreport'] = 'aff_rep_subid_view';
        $this->modulePermissions['topurls'] = 'aff_rep_top_urls_view';
        $this->modulePermissions['nonperformaffiliates'] = 'aff_rep_non_perform_affiliates_view';
        $this->modulePermissions['impclicks'] = 'aff_rep_impclicks_view';
        $this->modulePermissions['rotator'] = 'aff_rep_rotator_view';        
    }

    //--------------------------------------------------------------------------

    function process()
    {
        $this->assign('a_md', 'Affiliate_Merchants_Views_MerchantReports');
        if($_REQUEST['reporttype'] == '')
            $_REQUEST['reporttype'] = 'listofreports';

        if(!empty($_REQUEST['reporttype']))
        {
            switch($_REQUEST['reporttype'])
            {
                case 'listofreports':
                    if($this->showListOfReports())
                        return;
                    break;
                    
                case 'quick':
                    $this->navigationAddURL(L_G_QUICK,'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=quick');
                    if($this->showReportQuick())
                        return;
                    break;

                case 'transactions':
                    $this->navigationAddURL(L_G_TRANSACTIONS,'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=transactions');
                    if($this->showReportTransactions())
                        return;
                    break;

                case 'traffic':
                    $this->navigationAddURL(L_G_TRAFFIC,'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=traffic');
                    if($this->showReportTraffic())
                        return;
                    break;
                    
                case 'impclicks':
                    $this->navigationAddURL(L_G_IMPRESSIONCLICKS, 'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=impclicks');
                    if($this->showReportClickImpressions())
                        return;
                    break;

                case 'top20affiliates':
                    $this->navigationAddURL(L_G_TOPAFFILIATES,'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=top20affiliates');
                    if($this->showReportTop20Aff())
                        return;
                    break;
                    
                case 'topcampaigns':
                    if($this->showReportTopCampaigns())
                        return;
                    break;

                case 'affiliatecounts':
                    $this->navigationAddURL(L_G_AFFILIATECOUNTS,'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=affiliatecounts');
                    if($this->showAffCounts())
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

    function showListOfReports()
    {
        $reports = array();
        
        if ($this->checkPermissions('quick')) {
            $reports['quick'] =
                array('name' => L_G_QUICK,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=quick',
                      'desc' => L_G_QUICKREPORT_DESCRIPTION_SHORT);
        }

        if ($this->checkPermissions('transactions')) {
            $reports['transactions'] =
                array('name' => L_G_TRANSACTIONS,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=transactions',
                      'desc' => L_G_TRANSACTIONREPORT_DESCRIPTION_SHORT);
        }
    
        if ($this->checkPermissions('traffic')) {
            $reports['traffic'] = 
                array('name' => L_G_TRAFFIC,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=traffic',
                      'desc' => L_G_TRAFFICANDSALES_DESCRIPTION_SHORT);
        }
    
        if ($this->checkPermissions('top20affiliates')) {
            $reports['top20affiliates'] = 
                array('name' => L_G_TOPAFFILIATES,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=top20affiliates',
                      'desc' => L_G_TOP20AFFILIATES_DESCRIPTION_SHORT);
        }
    
        if ($this->checkPermissions('affiliatecounts')) {
            $reports['affiliatecounts'] = 
                array('name' => L_G_AFFILIATECOUNTS,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=affiliatecounts',
                      'desc' => L_G_AFFCOUNT_DESCRIPTION_SHORT);
        }
        
        if ($this->checkPermissions('impclicks')) {
            $reports['affiliatecounts'] = 
                array('name' => L_G_IMPRESSIONCLICKS,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=impclicks',
                      'desc' => L_G_IMPRESSIONCLICKS_DESCRIPTION_SHORT);
        }
    
        if ($this->checkPermissions('subidreport')) {
            $reports['subidreport'] = 
                array('name' => L_G_SUBID,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=subid',
                      'desc' => L_G_SUBID_DESCRIPTION_SHORT);
        }

        if ($this->checkPermissions('topurls')) {
            $reports['topurls'] = 
                array('name' => L_G_TOPREFERRINGURLS,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_TopReferringUrls',
                      'desc' => L_G_TOPREFERRINGURLS_DESCRIPTION_SHORT);
        }
        
        if ($this->checkPermissions('nonperformaffiliates')) {
            $reports['nonperformaffiliates'] = 
                array('name' => L_G_NONPERFORMAFFILIATES,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_NonPerformAffiliates',
                      'desc' => L_G_NONPERFORMAFFILIATES_DESCRIPTION_SHORT);
        }
        
        if ($this->checkPermissions('rotator')) {
            $reports['rotator'] = 
                array('name' => L_G_ROTATORSTATS,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_RotatorReport',
                      'desc' => L_G_ROTATORSTATS_DESCRIPTION_SHORT);
        }
        
        $reports['profile'] = 
                array('name' => L_G_PROFILEREPORT,
                      'url'  => 'index.php?md=Affiliate_Merchants_Views_MerchantProfile',
                      'desc' => L_G_PROFILEREPORT_DESCRIPTION_SHORT);

        $this->assign('a_reports', $reports);
        $this->assign('a_main_description', L_G_REPORTS_DESCRIPTION);
        
        $this->addContent('rep_list');
    }
    
    //------------------------------------------------------------------------

    function showAffCounts()
    {
        $this->assign('a_form_preffix', 'rac_');
        $this->assign('a_form_name', 'FilterForm');
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rac_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }

        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['rac_py_year'] == '') $_REQUEST['rac_py_year'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['rac_py_year'] = $_REQUEST['rac_py_year'];
        
        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_affcounts_filter');
        
        $this->getAffiliateCounts($_REQUEST['rac_py_year'], $signedCounts, $allCounts, $declinedCounts);

        for($i=1; $i<=12; $i++)
        {
            $labels[] = constant($GLOBALS['wd_monthname'][$i]);
            $values[0][] = $allCounts['data'][$i];
            $values[1][] = $signedCounts['data'][$i];
            $values[2][] = $declinedCounts['data'][$i];
        }
        
         // make graphs
        $graph = QUnit_Global::newobj('QUnit_Graphics_Graph');
        $params = array(
                    'type' => array('3d_column', 'column', 'line'),
                    'library' => 'xmlswf',
                    'values' => $values,
                    'labels' => $labels,
                    'width' => '777',
                    'legend' => array(L_G_ALLINMONTH,L_G_SIGNEDINMONTH,L_G_DECLINEDFROMMONTH)
                  );
        $gdata = $graph->create($params);
        $this->assign('a_aff_graph', $gdata);
        
        
        $this->addContent('rep_affcounts_list');
    }

    //------------------------------------------------------------------------
    
    function getAffiliateCounts($py_year, &$signedCounts, &$allCounts, &$declinedCounts)
    {
        $maxY = 0;
        $rs = null;
        $signedCounts = array();
        $signedCounts['data'] = null;
        
        $allCounts = array();
        $allCounts['data'] = null;
        
        // get number of affiliates before this period
        $sql = "select count(*) as count". 
               " from wd_g_users where accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and rtype="._q(USERTYPE_USER).
               " and deleted=0".
               " and rstatus<>"._q(AFFSTATUS_SUPPRESSED).
               " and YEAR(dateinserted)<$py_year";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;

        $allAffiliatesBefore = $rs->fields['count'];
        
        $sql = "select MONTH(dateinserted) as period, count(*) as count". 
               " from wd_g_users".
               " where YEAR(dateinserted)=$py_year".
               " and rtype="._q(USERTYPE_USER).
               " and deleted=0".               
               " and rstatus<>"._q(AFFSTATUS_SUPPRESSED).
               "   and accountid="._q($GLOBALS['Auth']->getAccountID()).
               " group by MONTH(dateinserted)";
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        $all = array();
        $signed = array();
        $declined = array();

        if($rs == null)
            return null;
        
        for($i=1; $i<=12; $i++)
        {
            $all[$i] = $allAffiliatesBefore;
            $signed[$i] = 0;
        }
        
        while(!$rs->EOF)
        {
            $signed[$rs->fields['period']] = $rs->fields['count'];
            $rs->MoveNext();
        }
        
        // compute declined affiliates
        $sql = "select MONTH(dateinserted) as period, count(*) as count". 
               " from wd_g_users".
               " where YEAR(dateinserted)=$py_year".
               " and rtype="._q(USERTYPE_USER).
               " and deleted=0".               
               " and rstatus="._q(AFFSTATUS_SUPPRESSED).
               "   and accountid="._q($GLOBALS['Auth']->getAccountID()).
               " group by MONTH(dateinserted)";
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        while(!$rs->EOF)
        {
            $declined[$rs->fields['period']] = $rs->fields['count'];
            $rs->MoveNext();
        }
        
        // compute all affiliates in current month
        $signedUntil = 0;
        $currentYear = date("Y");
        $currentMonth = date("n");

        for($i=1; $i<=12; $i++)
        {
            if($currentYear == $py_year && $currentMonth < $i)
                $all[$i] = 0;
            else
            {
                $signedUntil += $signed[$i];
            
                $all[$i] += $signedUntil;
            }
        }

        $maxY = $signedUntil + $allAffiliatesBefore;
        
        $signedCounts['data'] = $signed;
        $allCounts['data'] = $all;
        $declinedCounts['data'] = $declined;
        
        return $graph_data;
    }
    
    //------------------------------------------------------------------------
    
    function getLabelString($rec) {
        if ($rec == '') {
            return '&nbsp;-&nbsp;';
        }
        return $rec['name'].' '.$rec['surname'];
        
        return '<table>'.
               '<tr><td width="50">'.$rec['userid'].' :</td>'.
                   '<td width="200"><a href="index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=view&aid='.$rec['userid'].'">'
                        .$rec['name'].' '.$rec['surname'].'</a></td>'.
               '</tr></table>';
    }
    
    //------------------------------------------------------------------------
    
    function showReportTop20Aff()
    {
        $this->assign('a_form_preffix', 'rt_');
        $this->assign('a_form_name', 'FilterForm');
        $this->getCampaignsForFilter();
        
        if($_REQUEST['commited'] && !isset($_REQUEST['rt_virtual_affiliates'])) {
            $_REQUEST['rt_virtual_affiliates'] = 'no';
        }

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
        if($_REQUEST['rt_day1'] == '') $_REQUEST['rt_day1'] = date("j");
        if($_REQUEST['rt_month1'] == '') $_REQUEST['rt_month1'] = date("n");
        if($_REQUEST['rt_year1'] == '') $_REQUEST['rt_year1'] = date("Y");
        if($_REQUEST['rt_day2'] == '') $_REQUEST['rt_day2'] = date("j");
        if($_REQUEST['rt_month2'] == '') $_REQUEST['rt_month2'] = date("n");
        if($_REQUEST['rt_year2'] == '') $_REQUEST['rt_year2'] = date("Y");
        if($_REQUEST['rt_timeselect'] == '') $_REQUEST['rt_timeselect'] = TIME_PRESET;
        if($_REQUEST['rt_timepreset'] == '') $_REQUEST['rt_timepreset'] = TIME_TODAY;
        if($_REQUEST['rt_topcount'] == '') $_REQUEST['rt_topcount'] = 20;
        
        //--------------------------------------
        // put settings into session
        $_SESSION['rt_campaign'] = $_REQUEST['rt_campaign'];
        $_SESSION['rt_reporttype'] = $_REQUEST['rt_reporttype'];
        $_SESSION['rt_day1'] = $_REQUEST['rt_day1'];
        $_SESSION['rt_month1'] = $_REQUEST['rt_month1'];
        $_SESSION['rt_year1'] = $_REQUEST['rt_year1'];
        $_SESSION['rt_day2'] = $_REQUEST['rt_day2'];
        $_SESSION['rt_month2'] = $_REQUEST['rt_month2'];
        $_SESSION['rt_year2'] = $_REQUEST['rt_year2'];
        $_SESSION['rt_topcount'] = $_REQUEST['rt_topcount'];
        $_SESSION['rt_timeselect'] = $_REQUEST['rt_timeselect'];
        $_SESSION['rt_timepreset'] = $_REQUEST['rt_timepreset'];
        $_SESSION['rt_virtual_affiliates'] = $_REQUEST['rt_virtual_affiliates'];

        // process time filter
        if($_REQUEST['rt_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['rt_timepreset'], 'rt_'));
        }
        
        $campaigns = $this->viewCampManager->getCampaignsAsArray();

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($campaigns);
        $this->assign('a_list_data', $list_data);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_top20aff_filter');
        
        $d1 = $_REQUEST['rt_day1'];
        $m1 = $_REQUEST['rt_month1'];
        $y1 = $_REQUEST['rt_year1'];
        $d2 = $_REQUEST['rt_day2'];
        $m2 = $_REQUEST['rt_month2'];
        $y2 = $_REQUEST['rt_year2'];
        
        $data = $this->blTopAffStat->getTopAffStats($_REQUEST['rt_campaign'],
                                                    $_REQUEST['rt_topcount'],
                                                    $d1, $m1, $y1, $d2, $m2, $y2,
                                                    '', '',
                                                    $_REQUEST['rt_virtual_affiliates'] == 'yes'
                                                   );
        
        // prepare data
        $labelsImps = array();
        $valuesImps = array();
        $valuesImpsUnique = array();
        $labelsCpm = array();
        $valuesCpm = array();
        $labelsClick = array();
        $valuesClick = array();
        $labelsSale = array();
        $valuesSale = array();
        $labelsLead = array();
        $valuesLead = array();
        $labelsRev = array();
        $valuesRev = array();
        
        $emptyImp = 0;
        foreach($data['imps'] as $rec) {
            $labelsImps[] = $this->getLabelString($rec);
            $valuesImps[] = $rec['all'];
            $valuesImpsUnique[] = $rec['unique'];
            $emptyImp += $rec['all'];
        }
        if($emptyImp == 0) {
            $valuesImps = array();
            $valuesImps[] = 1;
            $valuesImpsUnique = array();
            $valuesImpsUnique[] = 1;
        }
        
        $emptyCpm = 0;
        foreach($data['cpm'] as $rec) {
            $labelsCpm[] = $this->getLabelString($rec);
            $valuesCpm[] = $rec['count'];
            $emptyCpm += $rec['count'];
        }
        if($emptyCpm == 0) {
            $valuesCpm = array();
            $valuesCpm[] = 1;
        }
        
        $emptyClick = 0;
        foreach($data['click'] as $rec) {
            $labelsClick[] = $this->getLabelString($rec);
            $valuesClick[] = $rec['count'];
            $emptyClick += $rec['count'];
        }
        if($emptyClick == 0) {
            $valuesClick = array();
            $valuesClick[] = 1;
        }
        
        $emptySale = 0;
        foreach($data['sale'] as $rec) {
            $labelsSale[] = $this->getLabelString($rec);
            $valuesSale[] = $rec['count'];
            $emptySale += $rec['count'];
        }
        if($emptySale == 0) {
            $valuesSale = array();
            $valuesSale[] = 1;
        }
        
        $emptyLead = 0;
        foreach($data['lead'] as $rec) {
            $labelsLead[] = $this->getLabelString($rec);
            $valuesLead[] = $rec['count'];
            $emptyLead += $rec['count'];
        }
        if($emptyLead == 0) {
            $valuesLead = array();
            $valuesLead[] = 1;
        }
        
        $emptyRev = 0;
        foreach($data['revenue'] as $rec) {
            $labelsRev[] = $this->getLabelString($rec);
            $valuesRev[] = $rec['sum'];
            $emptyRev += $rec['sum'];
        }
        if($emptyRev == 0) {
            $valuesRev = array();
            $valuesRev[] = 1;
        }

        $height = 200;
        $seriesColor = array();
        for($i=0; $i<20; $i++) {
            $seriesColor[] = "A5C3E1";
            $seriesColor[] = "DAC0DE";
            $seriesColor[] = "C0DED3";
            $seriesColor[] = "ABCA94";
            $seriesColor[] = "FFC258";
            $seriesColor[] = "F28180";
        }
        
        // make graphs
        $graph = QUnit_Global::newobj('QUnit_Graphics_Graph');
        $params = array(
                    'type' => '3d pie',
                    'library' => 'xmlswf',
                    'width' => 386,
                    'height' => 200,
                    'values' => $valuesImps,
                    'values_orientation' => 'opposite',
                    'labels' => $labelsImps,
                    'series_color' => $seriesColor,
                  );
        ($emptyImp == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_impstop_graph', $gdata);
        $this->assign('a_impstop_data', $data['imps']);
        
        $params['values'] = $valuesImpsUnique;
        $params['labels'] = $labelsImps;
        ($emptyImp == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_impstopunique_graph', $gdata);
        
        $params['width'] = 777;
        $params['values'] = $valuesCpm;
        $params['labels'] = $labelsCpm;
        ($emptyCpm == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_cpmtop_graph', $gdata);
        $this->assign('a_cmptop_data', $data['cpm']);
        
        $params['values'] = $valuesClick;
        $params['labels'] = $labelsClick;
        
        ($emptyClick == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_clickstop_graph', $gdata);
        $this->assign('a_clickstop_data', $data['click']);
        
        $params['values'] = $valuesSale;
        $params['labels'] = $labelsSale;
        ($emptySale == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_salestop_graph', $gdata);
        $this->assign('a_salestop_data', $data['sale']);
        
        $params['values'] = $valuesLead;
        $params['labels'] = $labelsLead;
        ($emptyLead == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_leadstop_graph', $gdata);
        $this->assign('a_leadstop_data', $data['lead']);
        
        $params['values'] = $valuesRev;
        $params['labels'] = $labelsRev;
        
        $currency = $GLOBALS['Auth']->getSetting('Aff_system_currency');
        if($GLOBALS['Auth']->getSetting('Aff_currency_left_position') == '1') {
            $params['prefix'] = $currency.' ';
        } else {
            $params['suffix'] = $currency.' ';
        }
        ($emptyRev == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_revenuetop_graph', $gdata);
        $this->assign('a_revenuetop_data', $data['revenue']);
        
        $this->assign('a_seriesColor', $seriesColor);
        
        $this->setSupportedResults($_REQUEST['rt_campaign']);
        
        $this->addContent('rep_top20aff_list');
    }
    
    //------------------------------------------------------------------------
    
    function showReportTopCampaigns()
    {
        $this->assign('a_form_preffix', 'rt_');
        $this->assign('a_form_name', 'FilterForm');
        $this->getCampaignsForFilter();
        
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rt_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }
        
        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['rt_reporttype'] == '') $_REQUEST['rt_reporttype'] = 'perday';
        if($_REQUEST['rt_pd_day'] == '') $_REQUEST['rt_pd_day'] = date("j");
        if($_REQUEST['rt_pd_month'] == '') $_REQUEST['rt_pd_month'] = date("n");
        if($_REQUEST['rt_pd_year'] == '') $_REQUEST['rt_pd_year'] = date("Y");
        if($_REQUEST['rt_pm_month'] == '') $_REQUEST['rt_pm_month'] = date("n");
        if($_REQUEST['rt_pm_year'] == '') $_REQUEST['rt_pm_year'] = date("Y");
        if($_REQUEST['rt_py_year'] == '') $_REQUEST['rt_py_year'] = date("Y");
        if($_REQUEST['rt_topcount'] == '') $_REQUEST['rt_topcount'] = 20;
        
        
        //--------------------------------------
        // put settings into session
        $_SESSION['rt_reporttype'] = $_REQUEST['rt_reporttype'];
        $_SESSION['rt_pd_day'] = $_REQUEST['rt_pd_day'];
        $_SESSION['rt_pd_month'] = $_REQUEST['rt_pd_month'];
        $_SESSION['rt_pd_year'] = $_REQUEST['rt_pd_year'];
        $_SESSION['rt_pm_month'] = $_REQUEST['rt_pm_month'];
        $_SESSION['rt_pm_year'] = $_REQUEST['rt_pm_year'];
        $_SESSION['rt_py_year'] = $_REQUEST['rt_py_year'];
        $_SESSION['rt_topcount'] = $_REQUEST['rt_topcount'];
        
        // process time filter
        if($_REQUEST['rt_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['rt_timepreset'], 'rt_'));
        }
        
        $d1 = $_REQUEST['rt_day1'];
        $m1 = $_REQUEST['rt_month1'];
        $y1 = $_REQUEST['rt_year1'];
        $d2 = $_REQUEST['rt_day2'];
        $m2 = $_REQUEST['rt_month2'];
        $y2 = $_REQUEST['rt_year2'];        
        
        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_topcampaigns_filter');

        $data = $this->blTopCampaignStat->getTopCampaignStats($_REQUEST['rt_topcount'],
                                                                            $d1, $m1, $y1, $d2, $m2, $y2
                                                                           );
        // prepare data
        $labelsImps = array();
        $valuesImps = array();
        $valuesImpsUnique = array();
        $labelsCpm = array();
        $valuesCpm = array();
        $labelsClick = array();
        $valuesClick = array();
        $labelsSale = array();
        $valuesSale = array();
        $labelsLead = array();
        $valuesLead = array();
        $labelsRev = array();
        $valuesRev = array();
        
        $emptyImp = 0;
        foreach($data['imps'] as $rec) {
            $labelsImps[] = $rec['campaignid'].': '.$rec['name'];
            $valuesImps[] = $rec['all'];
            $valuesImpsUnique[] = $rec['unique'];
            $emptyImp += $rec['all'];
        }
        if($emptyImp == 0) {
            $valuesImps[] = 1;
            $valuesImpsUnique[] = 1;
            $labelsImps[] = L_G_NODATA;
        }
        
        $emptyCpm = 0;
        foreach($data['cpm'] as $rec) {
            $labelsCpm[] = $rec['campaignid'].': '.$rec['name'];
            $valuesCpm[] = $rec['count'];
            $emptyCpm += $rec['count'];
        }
        if($emptyCpm == 0) {
            $valuesCpm[] = 1;
            $labelsCpm[] = L_G_NODATA;
        }

        $emptyClick = 0;
        foreach($data['click'] as $rec) {
            $labelsClick[] = $rec['campaignid'].': '.$rec['name'];
            $valuesClick[] = $rec['count'];
            $emptyClick += $rec['count'];
        }
        if($emptyClick == 0) {
            $valuesClick[] = 1;
            $labelsClick[] = L_G_NODATA;
        }
        
        $emptySale = 0;
        foreach($data['sale'] as $rec) {
            $labelsSale[] = $rec['campaignid'].': '.$rec['name'];
            $valuesSale[] = $rec['count'];
            $emptySale += $rec['count'];
        }
        if($emptySale == 0) {
            $valuesSale[] = 1;
            $labelsSale[] = L_G_NODATA;
        }
        
        $emptyLead = 0;
        foreach($data['lead'] as $rec) {
            $labelsLead[] = $rec['campaignid'].': '.$rec['name'];
            $valuesLead[] = $rec['count'];
            $emptyLead += $rec['count'];
        }
        if($emptyLead == 0) {
            $valuesLead[] = 1;
            $labelsLead[] = L_G_NODATA;
        }
        
        $emptyRev = 0;
        foreach($data['revenue'] as $rec) {
            $labelsRev[] = $rec['campaignid'].': '.$rec['name'];
            $valuesRev[] = $rec['sum'];
            $emptyRev += $rec['sum'];
        }
        if($emptyRev == 0) {
            $valuesRev[] = 1;
            $labelsRev[] = L_G_NODATA;
        }

        $height = 200;
        $seriesColor = array();
        for($i=0; $i<20; $i++) {
            $seriesColor[] = "A5C3E1";
            $seriesColor[] = "DAC0DE";
            $seriesColor[] = "C0DED3";
            $seriesColor[] = "ABCA94";
            $seriesColor[] = "FFC258";
            $seriesColor[] = "F28180";
        }
        
        // make graphs
        $graph = QUnit_Global::newobj('QUnit_Graphics_Graph');
        $params = array(
                    'type' => '3d pie',
                    'library' => 'xmlswf',
                    'width' => 386,
                    'height' => 200,
                    'values' => $valuesImps,
                    'values_orientation' => 'opposite',
                    'labels' => $labelsImps,
                    'series_color' => $seriesColor,
                  );
        ($emptyImp == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_impstop_graph', $gdata);
        $this->assign('a_impstop_data', $data['imps']);
        
        $params['values'] = $valuesImpsUnique;
        $params['labels'] = $labelsImps;
        ($emptyImp == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_impstopunique_graph', $gdata);
        
        $params['width'] = 777;
        $params['values'] = $valuesCpm;
        $params['labels'] = $labelsCpm;
        ($emptyCpm == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_cpmtop_graph', $gdata);
        $this->assign('a_cmptop_data', $data['cpm']);
        
        $params['values'] = $valuesClick;
        $params['labels'] = $labelsClick;
        
        ($emptyClick == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_clickstop_graph', $gdata);
        $this->assign('a_clickstop_data', $data['click']);
        
        $params['values'] = $valuesSale;
        $params['labels'] = $labelsSale;
        ($emptySale == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_salestop_graph', $gdata);
        $this->assign('a_salestop_data', $data['sale']);
        
        $params['values'] = $valuesLead;
        $params['labels'] = $labelsLead;
        ($emptyLead == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_leadstop_graph', $gdata);
        $this->assign('a_leadstop_data', $data['lead']);
        
        $params['values'] = $valuesRev;
        $params['labels'] = $labelsRev;
        
        $currency = $GLOBALS['Auth']->getSetting('Aff_system_currency');
        if($GLOBALS['Auth']->getSetting('Aff_currency_left_position') == '1') {
            $params['prefix'] = $currency.' ';
        } else {
            $params['suffix'] = $currency.' ';
        }
        ($emptyRev == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_revenuetop_graph', $gdata);
        $this->assign('a_revenuetop_data', $data['revenue']);
        
        $this->assign('a_seriesColor', $seriesColor);

        $this->setSupportedResults($_REQUEST['rt_campaign']);

        $this->addContent('rep_topcampaigns_list');
    }

    //------------------------------------------------------------------------

    function showReportTraffic()
    {
        $this->assign('a_form_preffix', 'rt_');
        $this->assign('a_form_name', 'FilterForm');
        $this->getUsersForFilter();
        $this->getCampaignsForFilter();
        
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rt_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }
        
        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['rt_userid'] == '') $_REQUEST['rt_userid'] = '_';
        if($_REQUEST['rt_campaign'] == '') $_REQUEST['rt_campaign'] = '_';
        if($_REQUEST['rt_reporttype'] == '') $_REQUEST['rt_reporttype'] = 'perday';
        if($_REQUEST['rt_pd_day'] == '') $_REQUEST['rt_pd_day'] = date("j");
        if($_REQUEST['rt_pd_month'] == '') $_REQUEST['rt_pd_month'] = date("n");
        if($_REQUEST['rt_pd_year'] == '') $_REQUEST['rt_pd_year'] = date("Y");
        if($_REQUEST['rt_pm_month'] == '') $_REQUEST['rt_pm_month'] = date("n");
        if($_REQUEST['rt_pm_year'] == '') $_REQUEST['rt_pm_year'] = date("Y");
        if($_REQUEST['rt_pw_week'] == '') $_REQUEST['rt_pw_week'] = date("W");
        if($_REQUEST['rt_pw_year'] == '') $_REQUEST['rt_pw_year'] = date("Y");
        if($_REQUEST['rt_py_year'] == '') $_REQUEST['rt_py_year'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['rt_userid'] = $_REQUEST['rt_userid'];
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
    
        //---------------------------------------------------
        //added by AdAstra - process new variable - get default setting and put into session
        if($_REQUEST['rt_date_select_mode'] == '' ) $_REQUEST['rt_date_select_mode'] = '1';
        $_SESSION['rt_date_select_mode'] = $_REQUEST['rt_date_select_mode'];
        //---------------------------------------------------


        $campaigns = $this->viewCampManager->getCampaignsAsArray();
        $affiliates = $this->blAffiliate->getUsersAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($affiliates);
        $this->assign('a_list_data2', $list_data2);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_traffic_filter');

        if($_REQUEST['rt_reporttype'] == 'perday')
        {
            $reportType = 'hourly';
            $d1 = ($_REQUEST['rt_pd_day']   == '_') ? 1         : $_REQUEST['rt_pd_day'];
            $m1 = ($_REQUEST['rt_pd_month'] == '_') ? 1         : $_REQUEST['rt_pd_month'];
            $y1 = ($_REQUEST['rt_pd_year']  == '_') ? PAP_STARTING_YEAR : $_REQUEST['rt_pd_year'];
            $d2 = ($_REQUEST['rt_pd_day']   == '_') ? 31        : $_REQUEST['rt_pd_day'];
            $m2 = ($_REQUEST['rt_pd_month'] == '_') ? 12        : $_REQUEST['rt_pd_month'];
            $y2 = ($_REQUEST['rt_pd_year']  == '_') ? date("Y") : $_REQUEST['rt_pd_year'];
        }
        else if($_REQUEST['rt_reporttype'] == 'permonth')
        {
            $reportType = 'daily';
            $d1 = 1;
            $m1 = ($_REQUEST['rt_pm_month'] == '_') ? 1         : $_REQUEST['rt_pm_month'];
            $y1 = ($_REQUEST['rt_pm_year']  == '_') ? PAP_STARTING_YEAR : $_REQUEST['rt_pm_year'];
            $d2 = 31;
            $m2 = ($_REQUEST['rt_pm_month'] == '_') ? 12        : $_REQUEST['rt_pm_month'];
            $y2 = ($_REQUEST['rt_pm_year']  == '_') ? date("Y") : $_REQUEST['rt_pm_year'];
        }
        else if($_REQUEST['rt_reporttype'] == 'perweek')
        {
            $reportType = 'weekly';
            $d1 = 1;
            $m1 = ($_REQUEST['rt_pw_week'] == '_') ? 1         : $_REQUEST['rt_pw_week'];
            $y1 = ($_REQUEST['rt_pw_year'] == '_') ? PAP_STARTING_YEAR : $_REQUEST['rt_pw_year'];
            $d2 = 31;
            $m2 = ($_REQUEST['rt_pw_week'] == '_') ? 53        : $_REQUEST['rt_pw_week'];
            $y2 = ($_REQUEST['rt_pw_year'] == '_') ? date("Y") : $_REQUEST['rt_pw_year'];
        }
        else if($_REQUEST['rt_reporttype'] == 'peryear')
        {
            $reportType = 'monthly';
            $d1 = 1;
            $m1 = 1;
            $y1 = ($_REQUEST['rt_py_year'] == '_') ? PAP_STARTING_YEAR : $_REQUEST['rt_py_year'];
            $d2 = 31;
            $m2 = 12;
            $y2 = ($_REQUEST['rt_py_year'] == '_') ? date("Y") : $_REQUEST['rt_py_year'];
        }
        
        //----------------------------------------------------------
        //processes variable from advanced filter
        if( $_REQUEST['rt_advanced_filter_show']  == '1'){
            $dateSelectMode = ( $_REQUEST['rt_date_select_mode'] == '' ) ? '1' : $_REQUEST['rt_date_select_mode'];
        }
        else{
            $dateSelectMode = '1';
        }
        //---------------------------------------------------
        $trend = $this->blTrendStat->getTrendStats(
                                                     $_REQUEST['rt_userid'],
                                                     $_REQUEST['rt_campaign'],
                                                     $reportType,
                                                     $d1, $m1, $y1,
                                                     $d2, $m2, $y2,
                                                     '', '', true, $dateSelectMode );
        
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
            $valuesCpm[] = $trend['cpm'][$i];
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
            $campaignInfo = $this->blCampaign->load(array('campaignid' => $campaign));
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
                $clickSaveSupported = true;
                $clickRevenueSupported = true;
            }
        } else {
            if($GLOBALS['Auth']->getSetting('Aff_dont_save_click_transaction') != 1) {
                $clickSaveSupported = true;
            }
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1)
        {
            // no campaign defined, set supported transaction types
            if(!$campaignUsed || ($campaignUsed && $campaignInfo['commtype'] & TRANSTYPE_CLICK))
            {
                $clickRevenueSupported = true;
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
    
    //------------------------------------------------------------------------

    function saveProcessData($processedData)
    {
        if(is_array($processedData) && count($processedData)>0)
        {
            // save change
            $error = false;
            foreach($processedData as $code => $value)
            {
                if(!QCore_Settings::_update($code, $value, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID()))
                    $error = true;
            }
            
            if($error)
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);
            else
                QUnit_Messager::setOkMessage(L_G_SETTINGSSAVED);
            
            $GLOBALS['Auth']->loadSettings();
        }
    }
        
    //------------------------------------------------------------------------

    function setLoadAffiliateTransactionReportViewSettings() {
        
        if ($_REQUEST['aff_trans_report_settings']) {
            
            $aff_trans_rep_settings = array();
            
            if ($_REQUEST['allow_pending_trans']) {
                $aff_trans_rep_settings['Aff_allow_pending_trans'] = 'allow';
            } else {
                $aff_trans_rep_settings['Aff_allow_pending_trans'] = 'deny';
            }
            
            if ($_REQUEST['allow_declined_trans']) {
                $aff_trans_rep_settings['Aff_allow_declined_trans'] = 'allow';
            } else {
                $aff_trans_rep_settings['Aff_allow_declined_trans'] = 'deny';
            }
            
            $this->saveProcessData($aff_trans_rep_settings);
        }
        
        $aff_trans_rep_settings = $GLOBALS['Auth']->getSettings();
        
        if ($aff_trans_rep_settings['Aff_allow_declined_trans'] == null) {
            $aff_trans_rep_settings['Aff_allow_declined_trans'] = 'allow';
        }

        if ($aff_trans_rep_settings['Aff_allow_pending_trans'] == null) {
            $aff_trans_rep_settings['Aff_allow_pending_trans'] = 'allow';
        }

        $_POST['allow_declined_trans'] = $aff_trans_rep_settings['Aff_allow_declined_trans'];
        $_POST['allow_pending_trans'] = $aff_trans_rep_settings['Aff_allow_pending_trans'];
    }

    //------------------------------------------------------------------------
        
    function showReportTransactions()
    {
        $this->assign('a_form_preffix', 'rq_');
        $this->assign('a_form_name', 'FilterForm');
        $this->getUsersForFilter();
        $this->getCampaignsForFilter();
        
        $this->assign('a_filterColumns', array('t.orderid' => L_G_ORDERID,
                                               't.data1' => L_G_DATA1,
                                               't.data2' => L_G_DATA2,
                                               't.data3' => L_G_DATA3,));
        
        //--------------------------------------
        // try to load settings from session
        if($_REQUEST['commited'] != 'yes') {
            foreach($_SESSION as $k => $v) {
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
        
        //--------------------------------------
        //clear checkboxes
        if( $_REQUEST['filtered'] == '1' ){
            if( !isset( $_REQUEST['rq_transtype'] ) ) $_REQUEST['rq_transtype'] = array();
            if( !isset( $_REQUEST['rq_status'] ) ) $_REQUEST['rq_status'] = array();
            if( !isset( $_REQUEST['rq_flags'] ) ) $_REQUEST['rq_flags'] = false;
        }
        //-----------------------------------
        
        //--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
        if($_REQUEST['rq_userid'] == '') $_REQUEST['rq_userid'] = '_';
        if($_REQUEST['rq_campaign'] == '') $_REQUEST['rq_campaign'] = '';
        if($_REQUEST['rq_reporttype'] == '') $_REQUEST['rq_reporttype'] = 'today';
        if($_REQUEST['rq_day1'] == '') $_REQUEST['rq_day1'] = date("j");
        if($_REQUEST['rq_month1'] == '') $_REQUEST['rq_month1'] = date("n");
        if($_REQUEST['rq_year1'] == '') $_REQUEST['rq_year1'] = date("Y");
        if($_REQUEST['rq_day2'] == '') $_REQUEST['rq_day2'] = date("j");
        if($_REQUEST['rq_month2'] == '') $_REQUEST['rq_month2'] = date("n");
        if($_REQUEST['rq_year2'] == '') $_REQUEST['rq_year2'] = date("Y");
        if($_REQUEST['rq_timeselect'] == '') $_REQUEST['rq_timeselect'] = TIME_PRESET;
        if($_REQUEST['rq_timepreset'] == '') $_REQUEST['rq_timepreset'] = TIME_TODAY;

        //----------------------------------------
        //adds defaults for status and transtype and flags
        if( $_REQUEST['rq_status'] == '' ) $_REQUEST['rq_status'] = array( AFFSTATUS_APPROVED, AFFSTATUS_NOTAPPROVED, AFFSTATUS_SUPPRESSED );
        if( $_REQUEST['rq_transtype'] == '' ) $_REQUEST['rq_transtype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();
        if( $_REQUEST['rq_flags'] !== false ) $_REQUEST['rq_flags'] = VIRTUAL_AFFILIATE;
        
        //---------------------------------------
        
        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['rq_userid'] = $_REQUEST['rq_userid'];
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
        
        //---------------------------------------------------
        // added by AdAstra gets default setting for new variable and puts it into session
        if( $_REQUEST['rq_date_select_mode'] == '') $_REQUEST['rq_date_select_mode'] = '1';
        $_SESSION['rq_date_select_mode'] = $_REQUEST['rq_date_select_mode'];
        $_SESSION['rq_flags'] = $_REQUEST['rq_flags'];
        
        //--------------------------------------------------

        $this->setLoadAffiliateTransactionReportViewSettings();
        
        // process time filter
        if($_REQUEST['rq_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['rq_timepreset'], 'rq_'));
        }

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_trans_filter');
        
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['rq_campaign']);
        
        if(empty($_REQUEST['list_page'])) 
            $page = 0;
        else 
            $page = $_REQUEST['list_page'];
        
        if ($_REQUEST['rq_advanced_filter_show'] == '1') {
        //--------------------------------------------
        //added by AdAstra - sets new variable
        $dateSelectMode = $_REQUEST['rq_date_select_mode'];
        $virtualAffiliates = $_REQUEST['rq_flags'];
        //-------------------------------------------
    
            $custom1data = preg_replace('/[\'\"]/', '', $_REQUEST['rq_custom1data']);
            $custom2data = preg_replace('/[\'\"]/', '', $_REQUEST['rq_custom2data']);
            $custom3data = preg_replace('/[\'\"]/', '', $_REQUEST['rq_custom3data']);
        
            $transType = ($_REQUEST['rq_transtype'] == '') ? array() : $_REQUEST['rq_transtype'];
            $status = ($_REQUEST['rq_status'] == '') ? array() : $_REQUEST['rq_status'];
        
            if($_REQUEST['rq_userid'] != '' && $_REQUEST['rq_userid'] != '_')
                $AffiliateID = $_REQUEST['rq_userid'];
            else
                $AffiliateID = '';

            $extrafilter = array();

            if ($custom1data != '')
                $extrafilter[$_REQUEST['rq_custom1']] = $custom1data;
            if ($custom2data != '')
                $extrafilter[$_REQUEST['rq_custom2']] = $custom2data;
            if ($custom3data != '')
                $extrafilter[$_REQUEST['rq_custom3']] = $custom3data;
            
            //---------------------------------------------------
            //added new variable into $conditions
            //---------------------------------------------------
            $conditions = array(
                                'CampaignID' => $CampaignID,
                                'UserID' => $AffiliateID,
                                'TransactionType' => $transType,
                                'Status' => $status,
                                'page' => $page,
                                'rowsPerPage' => $_REQUEST['numrows'],
                                'day1'   => $_REQUEST['rq_day1'],
                                'month1' => $_REQUEST['rq_month1'],
                                'year1'  => $_REQUEST['rq_year1'],
                                'day2'   => $_REQUEST['rq_day2'],
                                'month2' => $_REQUEST['rq_month2'],
                                'year2'  => $_REQUEST['rq_year2'],
                                'extrafilter' => $extrafilter,
                'dateSelectMode' => $dateSelectMode,
                'virtual_affiliates' => $virtualAffiliates,
                            );
        } else {
            $conditions = array(
                                'CampaignID' => $CampaignID,
                                'TransactionType' => array_keys($GLOBALS['Auth']->getSupportedCommissions(false)),
                                'page' => $page,
                                'rowsPerPage' => $_REQUEST['numrows'],
                                'day1'   => $_REQUEST['rq_day1'],
                                'month1' => $_REQUEST['rq_month1'],
                                'year1'  => $_REQUEST['rq_year1'],
                                'day2'   => $_REQUEST['rq_day2'],
                                'month2' => $_REQUEST['rq_month2'],
                                'year2'  => $_REQUEST['rq_year2'],
                            );
        }
        
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

        $this->addContent('rep_trans_list');
    }
    
    //------------------------------------------------------------------------

    function showReportSubId()
    {
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
        if($_REQUEST['rq_userid'] == '') $_REQUEST['rq_userid'] = '_';
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
        $_SESSION['rq_userid'] = $_REQUEST['rq_userid'];
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
        $affiliates = $this->blAffiliate->getUsersAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($affiliates);
        $this->assign('a_list_data2', $list_data2);

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
        
        
        if($_REQUEST['rq_userid'] != '' && $_REQUEST['rq_userid'] != '_')
            $AffiliateID = $_REQUEST['rq_userid'];
        else
            $AffiliateID = '';

        $conditions = array(
                            'CampaignID' => $CampaignID,
                            'UserID' => $AffiliateID,
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
        $this->assign('a_form_preffix', 'rq_');
        $this->assign('a_form_name', 'FilterForm');
        $this->getUsersForFilter();
        $this->getCampaignsForFilter();
        
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rq_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }
        
        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['rq_userid'] == '') $_REQUEST['rq_userid'] = '_';
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
        $_SESSION['rq_userid'] = $_REQUEST['rq_userid'];
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

        $this->setLoadAffiliateTransactionReportViewSettings();

        // process time filter
        if($_REQUEST['rq_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['rq_timepreset'], 'rq_'));
        }

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_quick_filter');
        
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['rq_campaign']);
        
        $data = $this->blTimeStat->getTimerangeStats(
                        $_REQUEST['rq_userid'], $CampaignID,
                        $_REQUEST['rq_day1'], $_REQUEST['rq_month1'], $_REQUEST['rq_year1'], 
                        $_REQUEST['rq_day2'], $_REQUEST['rq_month2'], $_REQUEST['rq_year2'], 
                        $GLOBALS['Auth']->getAccountID()
                        );
         
        $this->assign('a_data', $data);

        $this->setSupportedResults($CampaignID);
        
        $this->addContent('rep_quick_list');
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

    function getCampaignsForFilter()
    {
        $campaigns = $this->viewCampManager->getCampaignsAsArray();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($campaigns);

        $this->assign('a_list_campaigns', $list_data);
    }

    //------------------------------------------------------------------------

    function showReportClickImpressions()
    {
        $this->assign('a_form_preffix', 'rq_');
        $this->assign('a_form_name', 'FilterForm');
        $this->getCampaignsForFilter();
        $this->getUsersForFilter();
        //--------------------------------------
        // try to load settings from session
        if($_REQUEST['commited'] != 'yes') {
            foreach($_SESSION as $k => $v) {
                if(strstr($k, 'rq_status' ) !== false && ($_REQUEST['status_comitted'] == '1')){
                    continue;
                }
                if(strstr($k, 'rq_transtype' ) !== false && ( $_REQUEST['transtype_comitted'] == '1')){
                    continue;
                }
                if(strpos($k, 'rq_') === 0 && $_REQUEST[$k] == '')
                    $_REQUEST[$k] = $v;
                if($k == 'numrows' && $_REQUEST[$k] == '')
                    $_REQUEST[$k] = $v;                
            }
        }
    
        //---------------------------------------
        //clear  checkboxes
        if( $_REQUEST['filtered'] == '1' ){
            if( !isset( $_REQUEST['rq_status'] ) )$_REQUEST['rq_status'] = array();
            if( !isset( $_REQUEST['rq_transtype'] ) )$_REQUEST['rq_transtype'] = array();
        }
        //---------------------------------------

        //--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
        if($_REQUEST['rq_campaign'] == '') $_REQUEST['rq_campaign'] = DEFAULT_CAMPAIGN;
        if($_REQUEST['rq_userid'] == '') $_REQUEST['rq_userid'] = '_';
        if($_REQUEST['rq_reporttype'] == '') $_REQUEST['rq_reporttype'] = 'today';
        if($_REQUEST['rq_day1'] == '') $_REQUEST['rq_day1'] = date("j");
        if($_REQUEST['rq_month1'] == '') $_REQUEST['rq_month1'] = date("n");
        if($_REQUEST['rq_year1'] == '') $_REQUEST['rq_year1'] = date("Y");
        if($_REQUEST['rq_day2'] == '') $_REQUEST['rq_day2'] = date("j");
        if($_REQUEST['rq_month2'] == '') $_REQUEST['rq_month2'] = date("n");
        if($_REQUEST['rq_year2'] == '') $_REQUEST['rq_year2'] = date("Y");
        if($_REQUEST['rq_timeselect'] == '') $_REQUEST['rq_timeselect'] = TIME_PRESET;
        if($_REQUEST['rq_timepreset'] == '') $_REQUEST['rq_timepreset'] = TIME_TODAY;
        
        //---------------------------------------
        //added by AdAstra - sets defaults for request and transtype
        if( $_REQUEST['rq_transtype'] == '' ) $_REQUEST['rq_transtype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();
        if( $_REQUEST['rq_status'] == '' ) $_REQUEST['rq_status'] = array( AFFSTATUS_APPROVED, AFFSTATUS_NOTAPPROVED, AFFSTATUS_SUPPRESSED );
        //---------------------------------------
        
        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['rq_campaign'] = $_REQUEST['rq_campaign'];
        $_SESSION['rq_userid'] = $_REQUEST['rq_userid'];
        $_SESSION['rq_reporttype'] = $_REQUEST['rq_reporttype'];
        $_SESSION['rq_day1'] = $_REQUEST['rq_day1'];
        $_SESSION['rq_month1'] = $_REQUEST['rq_month1'];
        $_SESSION['rq_year1'] = $_REQUEST['rq_year1'];
        $_SESSION['rq_day2'] = $_REQUEST['rq_day2'];
        $_SESSION['rq_month2'] = $_REQUEST['rq_month2'];
        $_SESSION['rq_year2'] = $_REQUEST['rq_year2'];
        $_SESSION['rq_timeselect'] = $_REQUEST['rq_timeselect'];
        $_SESSION['rq_timepreset'] = $_REQUEST['rq_timepreset'];
    
        //-------------------------------------------------------
        //added by AdAstraNet - process advanced filter - adds variables into session
        $_SESSION['rq_date_select_mode'] = $_REQUEST['rq_date_select_mode'];
        $_SESSION['rq_status'] = $_REQUEST['rq_status'];
        $_SESSION['rq_transtype'] = $_REQUEST['rq_transtype'];
        //--------------------------------------------------------
    

        // process time filter
        if($_REQUEST['rq_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['rq_timepreset'], 'rq_'));
        }

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_impclicks_filter');
        
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['rq_campaign']);
        
        if(empty($_REQUEST['list_page'])) 
            $page = 0;
        else 
            $page = $_REQUEST['list_page'];
        
        $conditions = array(
                            'CampaignID' => $CampaignID,
                            'day1'   => $_REQUEST['rq_day1'],
                            'month1' => $_REQUEST['rq_month1'],
                            'year1'  => $_REQUEST['rq_year1'],
                            'day2'   => $_REQUEST['rq_day2'],
                            'month2' => $_REQUEST['rq_month2'],
                            'year2'  => $_REQUEST['rq_year2'],
                           );
               
        //----------------------------------------------------
        //added by AdAstra - adds advanced filter variablet into conditions
        if( $_REQUEST['rq_advanced_filter_show'] == '1' ){
            $transtype = ( $_REQUEST['rq_transtype'] == '' ) ? array() : $_REQUEST['rq_transtype'];
            $status = ( $_REQUEST['rq_status'] == '1' ) ? array() : $_REQUEST['rq_status'];
            $dateSelectMode = ( $_REQUEST['rq_date_select_mode'] == '' ) ? '1' : $_REQUEST['rq_date_select_mode'];
        
            $conditions['TransactionType'] = $transtype;
            $conditions['Status'] = $status;
            $conditions['dateSelectMode'] = $dateSelectMode;
        }
        //---------------------------------------------------

        $data = $this->impClickStat->getImpClicksStatistics($conditions);
        $summaries = $data['summaries'];
        unset($data['summaries']);
        
        /*---------------------------------------------------------------------------------------*/
        
        $rootUserId = $_REQUEST['rq_userid'];

        if ($rootUserId != '' && $rootUserId != '_') {
            $treeData = array();
            $params   = array();
            $params['rootID'] = $rootUserId;
            $params['tab'] = '';
            $params['maxLevel'] = 20;
            $params['table_name'] = 'wd_g_users';
            $params['column_id'] = 'userid';
            $params['column_parentid'] = 'parentuserid';
            $params['getvalues'] = array('userid');
            $params['where'] = array('deleted' => '0', /*'rstatus' => AFFSTATUS_APPROVED,*/ 'rtype' => USERTYPE_USER);
            $params['order'] = array('name');

            QCore_Bl_GlobalFuncs::getTree($treeData, $params);

            $unfilteredData = $data;
            $data = array();
            $data[$rootUserId] = $unfilteredData[$rootUserId];
            $summaries = array();
            
            $summaries['imps_all']    = $unfilteredData[$rootUserId]['imps_all'];
            $summaries['imps_unique'] = $unfilteredData[$rootUserId]['imps_unique'];
            $summaries['clicks']      = $unfilteredData[$rootUserId]['clicks'];
            $summaries['sales']       = $unfilteredData[$rootUserId]['sales'];
            $summaries['commission']  = $unfilteredData[$rootUserId]['commission'];
            $summaries['totalcost']   = $unfilteredData[$rootUserId]['totalcost'];
            
            foreach ($treeData as $userData) {
                $data[$userData['userid']] = $unfilteredData[$userData['userid']];
               
                $summaries['imps_all']    += $unfilteredData[$userData['userid']]['imps_all'];
                $summaries['imps_unique'] += $unfilteredData[$userData['userid']]['imps_unique'];
                $summaries['clicks']      += $unfilteredData[$userData['userid']]['clicks'];
                $summaries['sales']       += $unfilteredData[$userData['userid']]['sales'];
                $summaries['commission']  += $unfilteredData[$userData['userid']]['commission'];
                $summaries['totalcost']   += $unfilteredData[$userData['userid']]['totalcost'];
            }
        }
        
        /*---------------------------------------------------------------------------------------*/

        if ($_REQUEST['list_page'] == '') $_REQUEST['list_page'] = 0;
        if ($_REQUEST['numrows'] == '') $_REQUEST['numrows'] = 20;
        $_REQUEST['allcount'] = count($data);
        $_REQUEST['list_pages'] = ceil($_REQUEST['allcount']/$_REQUEST['numrows']);
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($data);
        $this->assign('a_list_data', $list_data);
        $this->assign('a_summaries', $summaries);

        $this->pageLimitsAssign();
        
        $this->setSupportedResults($CampaignID);

        $this->addContent('rep_impclicks_list');
    }
}

?>
