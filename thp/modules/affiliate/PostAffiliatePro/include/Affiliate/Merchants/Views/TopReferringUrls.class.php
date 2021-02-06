<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_TopUrlStatistics');

class Affiliate_Merchants_Views_TopReferringUrls extends QUnit_UI_TemplatePage
{
    var $blAffiliate;
    var $blTopUrlStat;

    function Affiliate_Merchants_Views_TopReferringUrls() {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blTopUrlStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_TopUrlStatistics');
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_REPORTS,'index.php?md=Affiliate_Merchants_Views_MerchantReports');
        $this->navigationAddURL(L_G_TOPREFERRINGURLS,'index.php?md=Affiliate_Merchants_Views_TopReferringUrls');
    }
        
    function initPermissions()
    {
        $this->modulePermissions['topurls'] = 'aff_rep_top_urls_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
    	if($this->show())
          return;
    }  

    //------------------------------------------------------------------------

    function show($affPanel = false)
    {
        $this->assign('a_form_preffix', 'rq_');
        $this->assign('a_form_name', 'FilterForm');
        if ($affPanel) {
            $this->assign('a_md', 'Affiliate_Affiliates_Views_AffTopUrls');
        } else {
            $this->assign('a_md', 'Affiliate_Merchants_Views_TopReferringUrls');
        }
        
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strstr($k, 'rq_transtype') !== false && ($_REQUEST['transtype_comitted'] == '1')) {
                continue;
            }
            if(strpos($k, 'rq_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
            if($k == 'numrows' && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;                
        }

        //--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
        if($_REQUEST['rq_userid'] == '') $_REQUEST['rq_userid'] = '_';
        if($_REQUEST['rq_transtype'] == '') $_REQUEST['rq_transtype'] = array();
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
        $_SESSION['rq_transtype'] = $_REQUEST['rq_transtype'];
        $_SESSION['rq_reporttype'] = $_REQUEST['rq_reporttype'];
        $_SESSION['rq_day1'] = $_REQUEST['rq_day1'];
        $_SESSION['rq_month1'] = $_REQUEST['rq_month1'];
        $_SESSION['rq_year1'] = $_REQUEST['rq_year1'];
        $_SESSION['rq_day2'] = $_REQUEST['rq_day2'];
        $_SESSION['rq_month2'] = $_REQUEST['rq_month2'];
        $_SESSION['rq_year2'] = $_REQUEST['rq_year2'];
        $_SESSION['rq_timeselect'] = $_REQUEST['rq_timeselect'];
        $_SESSION['rq_timepreset'] = $_REQUEST['rq_timepreset'];

        if (!$affPanel) {
        	$this->getUsersForFilter();
        }
			
        $this->assign('a_curyear', date("Y"));
        $this->assign('a_affPanel', $affPanel);
			
        $this->addContent('rep_top_url_filter');
        
        // process time filter
        if($_REQUEST['rq_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['rq_timepreset'], 'rq_'));
        }
        
        if(empty($_REQUEST['list_page'])) 
            $page = 0;
        else 
            $page = $_REQUEST['list_page'];
        
        if ($_REQUEST['rq_advanced_filter_show'] == '1') {            
            $transType = ($_REQUEST['rq_transtype'] == '') ? array() : $_REQUEST['rq_transtype'];
                
            if (!$affPanel) {
        	   if($_REQUEST['rq_userid'] != '' && $_REQUEST['rq_userid'] != '_')
            	   $AffiliateID = $_REQUEST['rq_userid'];
        	   else
                	$AffiliateID = '';
            } else {
        	   $AffiliateID = $GLOBALS['Auth']->getUserID();
            }

            $conditions = array(
                                'AffiliateID' => $AffiliateID,
                                'TransactionType' => $transType,
                                'page' => $page,
                                'rowsPerPage' => $_REQUEST['numrows'],
                                'day1'   => $_REQUEST['rq_day1'],
                                'month1' => $_REQUEST['rq_month1'],
                                'year1'  => $_REQUEST['rq_year1'],
                                'day2'   => $_REQUEST['rq_day2'],
                                'month2' => $_REQUEST['rq_month2'],
                                'year2'  => $_REQUEST['rq_year2']
                            );
        } else {
            $conditions = array(
                                'page' => $page,
                                'rowsPerPage' => $_REQUEST['numrows'],
                                'day1'   => $_REQUEST['rq_day1'],
                                'month1' => $_REQUEST['rq_month1'],
                                'year1'  => $_REQUEST['rq_year1'],
                                'day2'   => $_REQUEST['rq_day2'],
                                'month2' => $_REQUEST['rq_month2'],
                                'year2'  => $_REQUEST['rq_year2']
                            );
        }
        
        if ($affPanel) {
            $conditions['AffiliateID'] = $GLOBALS['Auth']->getUserID();
        }
        
        $conditions['page'] = 0;
        $topurldata = $this->blTopUrlStat->getTopUrlStats($conditions);
        
        $seriesColor = array();
        for($i=0; $i<20; $i++) {
            $seriesColor[] = "A5C3E1";
            $seriesColor[] = "DAC0DE";
            $seriesColor[] = "C0DED3";
            $seriesColor[] = "ABCA94";
            $seriesColor[] = "FFC258";
        }
        
        $empty = 0;
        $count = 0;
        $other = 0;
        foreach($topurldata as $rec) {
            if($count<20) {
                $labels[] = ($rec['refererurl'] != '' ? $rec['refererurl'] : L_G_NOURL);
                $values[] = $rec['count'];
            } else {
                $other += $rec['count'];
            }
            $count++;
        }
        if($count == 0) {
            $labels[] = '';
            $values = array();
            $values[] = 100;
        }
        if($other != 0) {
            $labels[] = L_G_OTHER;
            $values[] = $other;
        }
        
        // make graphs
        $graph = QUnit_Global::newobj('QUnit_Graphics_Graph');
        $params = array(
                    'type' => '3d pie',
                    'library' => 'xmlswf',
                    'width' => 770,
                    'height' => 200,
                    'values' => $values,
                    'values_orientation' => 'opposite',
                    'labels' => $labels,
                    'series_color' => $seriesColor,
                  );
        ($count == 0 ? $params['positionTip'] = 'hide' : $params['positionTip'] = 'cursor');                    
        $gdata = $graph->create($params);
        $this->assign('a_topurls_graph', $gdata);
        $this->assign('a_seriesColor', $seriesColor);
        
        $conditions['page'] = $page;
        $topurldata = $this->blTopUrlStat->getTopUrlStats($conditions);
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($topurldata);
        $this->assign('a_list_data', $list_data);
        $this->assign('a_count_data', count($values));
        $this->pageLimitsAssign();
                
        $this->addContent('rep_top_url_list');
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
