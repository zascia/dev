<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_GeoReports extends QUnit_UI_TemplatePage
{
    var $blAffiliate;
    var $blGeoStat;
    var $blCampaign;
    var $viewCampManager;
    
    function Affiliate_Merchants_Views_GeoReports() {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blGeoStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_GeoStatistics');
        $this->blCampaign =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Campaign');
        $this->viewCampManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');        
    }
    
    function initPermissions()
    {
        $this->modulePermissions['geostats'] = 'aff_rep_geo_stats_view';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        $this->showReportGeo();
    }  
    
    //------------------------------------------------------------------------
    
    function setSupportedResults($campaign)
    {
        // get supported results
        $signupSupported = false;
        $referralSupported = false;
        $clickSupported = false;
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
            }
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1)
        {
            // no campaign defined, set supported transaction types
            if(!$campaignUsed || ($campaignUsed && $campaignInfo['commtype'] & TRANSTYPE_CLICK))
            {
                $clickSupported = true;
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
        $this->assign('a_clickRevenueSupported', $clickRevenueSupported);
        $this->assign('a_cpmSupported', $cpmSupported);
        $this->assign('a_saleSupported', $saleSupported);
        $this->assign('a_leadSupported', $leadSupported);
    }

    //------------------------------------------------------------------------

    function showReportGeo()
    {
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
        if($_REQUEST['rt_userid'] == '') $_REQUEST['rt_userid'] = '_';
        if($_REQUEST['rt_campaign'] == '') $_REQUEST['rt_campaign'] = '_';
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
        $_SESSION['rt_userid'] = $_REQUEST['rt_userid'];
        $_SESSION['rt_campaign'] = $_REQUEST['rt_campaign'];
        $_SESSION['rt_day1'] = $_REQUEST['rt_day1'];
        $_SESSION['rt_month1'] = $_REQUEST['rt_month1'];
        $_SESSION['rt_year1'] = $_REQUEST['rt_year1'];
        $_SESSION['rt_day2'] = $_REQUEST['rt_day2'];
        $_SESSION['rt_month2'] = $_REQUEST['rt_month2'];
        $_SESSION['rt_year2'] = $_REQUEST['rt_year2'];
        $_SESSION['rt_topcount'] = $_REQUEST['rt_topcount'];
        $_SESSION['rt_timeselect'] = $_REQUEST['rt_timeselect'];
        $_SESSION['rt_timepreset'] = $_REQUEST['rt_timepreset'];
        $_SESSION['rt_topcount'] = $_REQUEST['rt_topcount'];
        
        if (is_numeric($_REQUEST['rt_topcount'])) {
            $topcount = $_REQUEST['rt_topcount'];
        } else {
            $topcount = 9999;
        }

        $campaigns = $this->viewCampManager->getCampaignsAsArray();
        $affiliates = $this->blAffiliate->getUsersAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_campaigns', $list_data1);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($affiliates);
        $this->assign('a_list_users', $list_data2);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_geo_filter');
        
        // process time filter
        if($_REQUEST['rt_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['rt_timepreset'], 'rt_'));
        }
        
        $geo = $this->blGeoStat->getGeoStats($_REQUEST['rt_userid'],
                                             $_REQUEST['rt_campaign'],
                                             $reportType,
                                             $_REQUEST['rt_day1'], $_REQUEST['rt_month1'], $_REQUEST['rt_year1'],
                                             $_REQUEST['rt_day2'], $_REQUEST['rt_month2'], $_REQUEST['rt_year2']
                                             );
        $this->assign('a_found_countries', $geo['foundcountries']);
        $countries = $geo['foundcountries'];
        
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
             
        // impressions
        $emptyImp = 0;
        if ($geo['imps_unique'] != '') {
        	array_multisort($geo['imps_unique'], SORT_DESC, $geo['imps_all']);
        	$geo['imps_unique'] = array_slice($geo['imps_unique'], 0, $topcount);
        	$geo['imps_all'] = array_slice($geo['imps_all'], 0, $topcount);
        	foreach ($geo['imps_all'] as $country => $value) {
        	    $labelsImps[] = $countries[$country]['countryname'];
        	    $valuesImps[] = $geo['imps_all'][$country];
        	    $valuesImpsUnique[] = $geo['imps_unique'][$country];
        	    $emptyImp += $geo['imps_all'][$country];
        	}
        }
        if($emptyImp == 0) {
            $valuesImps = array();
            $valuesImps[] = 1;
            $valuesImpsUnique = array();
            $valuesImpsUnique[] = 1;
        }

        // cpm
        $data = $this->prepareData($geo['cpm'], $countries, $topcount);
        $emptyCpm = (count($data['values']) == 0) ? 0 : 1;
        $labelsCpm = $data['labels'];
        $valuesCpm = $data['values'];
        $this->assign('a_cmptop_data', $data);
        if($emptyCpm == 0) {
            $valuesCpm = array();
            $valuesCpm[] = 1;
        }
        
        // clicks
        $data = $this->prepareData($geo['clicks'], $countries, $topcount);
        $emptyClick = (count($data['values']) == 0) ? 0 : 1;
        $labelsClick = $data['labels'];
        $valuesClick = $data['values'];
        $this->assign('a_clickstop_data', $data);
        if($emptyClick == 0) {
            $valuesClick = array();
            $valuesClick[] = 1;
        }
        
        // sales
        $data = $this->prepareData($geo['sales'], $countries, $topcount);
        $emptySale = (count($data['values']) == 0) ? 0 : 1;
        $labelsSale = $data['labels'];
        $valuesSale = $data['values'];
        $this->assign('a_salestop_data', $data);
        if($emptySale == 0) {
            $valuesSale = array();
            $valuesSale[] = 1;
        }
        
        // leads
        $data = $this->prepareData($geo['leads'], $countries, $topcount);
        $emptyLead = (count($data['values']) == 0) ? 0 : 1;
        $labelsLead = $data['labels'];
        $valuesLead = $data['values'];
        $this->assign('a_leadstop_data', $data);
        if($emptyLead == 0) {
            $valuesLead = array();
            $valuesLead[] = 1;
        }
        
        // revenue
        $data = $this->prepareData($geo['revenue'], $countries, $topcount);
        $emptyRev = (count($data['values']) == 0) ? 0 : 1;
        $labelsRev = $data['labels'];
        $valuesRev = $data['values'];
        $this->assign('a_revenuetop_data', $data);
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
                    'series_color' => array_slice($seriesColor,0, $topcount),
                  );
        ($emptyImp == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_impstop_graph', $gdata);
        $this->assign('a_impstop_all_data', $geo['imps_all']);
        
        $params['values'] = $valuesImpsUnique;
        $params['labels'] = $labelsImps;
        ($emptyImp == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_impstopunique_graph', $gdata);
        $this->assign('a_impstop_unique_data', $geo['imps_unique']);
        
        $params['width'] = 777;
        $params['values'] = $valuesCpm;
        $params['labels'] = $labelsCpm;
        ($emptyCpm == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_cpmtop_graph', $gdata);
        
        $params['values'] = $valuesClick;
        $params['labels'] = $labelsClick;       
        ($emptyClick == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_clickstop_graph', $gdata);
        
        $params['values'] = $valuesSale;
        $params['labels'] = $labelsSale;
        ($emptySale == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_salestop_graph', $gdata);
        
        $params['values'] = $valuesLead;
        $params['labels'] = $labelsLead;
        ($emptyLead == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_leadstop_graph', $gdata);
        
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
        
        $this->assign('a_seriesColor', $seriesColor);
        
        $this->assign('a_trendData', $geo);
        
        $this->setSupportedResults($_REQUEST['rt_campaign']);
        
        $this->addContent('rep_geo_list');
    }
    
    //------------------------------------------------------------------------

    function prepareData($values, $countries, $topcount = 9999) {
    	if(!is_array($values)) {
    		return array('labels' => array(),
    					 'values' => array());
    	}
    	arsort($values); reset($values);
    	$labelsGraph = array();
    	$valuesGraph = array();
        foreach ($values as $country => $data) {
        	$labelsGraph[] = $countries[$country]['countryname'];
        	$valuesGraph[] = $values[$country];
        }
    	return array('labels' => array_slice($labelsGraph, 0, $topcount),
    				 'values' => array_slice($valuesGraph, 0, $topcount));
    }
}

?>
