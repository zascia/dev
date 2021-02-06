<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_RotatorReport extends QUnit_UI_TemplatePage
{
    var $blBanners;
    var $blRotatorStat;

    function Affiliate_Merchants_Views_RotatorReport() {
        $this->blBanners =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Banners');
        $this->blRotatorStat =& QUnit_Global::newObj('Affiliate_Scripts_Bl_RotatorStatistics');
    }

    //--------------------------------------------------------------------------

    function process()
    {
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_REPORTS,'index.php?md=Affiliate_Merchants_Views_MerchantReports');
        $this->navigationAddURL(L_G_ROTATORSTATS,'index.php?md=Affiliate_Merchants_Views_RotatorReport');
        
    	if($this->show())
          return;
    }  

    //------------------------------------------------------------------------

    function show()
    {
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
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
        if($_REQUEST['rq_banner'] == '') $_REQUEST['rq_banner'] = '_';
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
        $_SESSION['rq_banner'] = $_REQUEST['rq_banner'];
        $_SESSION['rq_reporttype'] = $_REQUEST['rq_reporttype'];
        $_SESSION['rq_day1'] = $_REQUEST['rq_day1'];
        $_SESSION['rq_month1'] = $_REQUEST['rq_month1'];
        $_SESSION['rq_year1'] = $_REQUEST['rq_year1'];
        $_SESSION['rq_day2'] = $_REQUEST['rq_day2'];
        $_SESSION['rq_month2'] = $_REQUEST['rq_month2'];
        $_SESSION['rq_year2'] = $_REQUEST['rq_year2'];
        $_SESSION['rq_timeselect'] = $_REQUEST['rq_timeselect'];
        $_SESSION['rq_timepreset'] = $_REQUEST['rq_timepreset'];

        $params = array();
        $params['AccountID'] = $GLOBALS['Auth']->getAccountID();
        $params['in'] = array(BANNERTYPE_ROTATOR);
        
        $banners = $this->blBanners->getBannersAsArray($params);
      	$this->assign('a_banners', $banners);
		
        // process time filter
        if($_REQUEST['rq_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['rq_timepreset'], 'rq_'));
        }

        $this->assign('a_curyear', date("Y"));
			
        $this->addContent('rep_rotator_filter');
        
        $params = array();
        $params['AccountID'] = $GLOBALS['Auth']->getAccountID();
        $params['in'] = 'all';
        
        $bannerInfo = $this->blBanners->getBannersAsArray($params);
        $this->assign('a_banner_info', $bannerInfo);
        
        $bannersToShow = array();
        if ($_REQUEST['rq_banner'] == '' || $_REQUEST['rq_banner'] == '_') {
            foreach ($banners as $bannerID => $bannerData) {
                $bannersToShow[] = $bannerID;
            }
        } else {
            $bannersToShow[] = $_REQUEST['rq_banner'];
        }
        
        $data = array();
        foreach ($bannersToShow as $rotatorID) {
            $subbanners = $this->parseRotatorBannerDescription($banners[$rotatorID]['description']);
            foreach ($subbanners as $bannerID => $bannerStats) {
                $data[$rotatorID][$bannerID] = $this->blRotatorStat->initData();
            }
        }
        
        $conditions = array(
                        'BannerID' => $bannersToShow,
                        'day1' =>   $_REQUEST['rq_day1'],
                        'month1' => $_REQUEST['rq_month1'],
                        'year1' =>  $_REQUEST['rq_year1'],
                        'day2' =>   $_REQUEST['rq_day2'],
                        'month2' => $_REQUEST['rq_month2'],
                        'year2' =>  $_REQUEST['rq_year2']
                    ); 
        
        $data = $this->blRotatorStat->getStats($conditions, $data);
        if (count($data) < 1) {
            $this->addContent('rep_rotator_nodata');
            return true;
        }
        
        foreach ($data as $rotatorID => $rotatorStats) {
            $this->assign('a_rotator', $rotatorID);
            $this->assign('a_data', $rotatorStats);
            $this->addContent('rep_rotator_item');
        }
    }
    
    //------------------------------------------------------------------------
    
    function parseRotatorBannerDescription($desc)
    {
        if($desc == '') {
            return array();
        }

        $descArray = explode(',', $desc);
        $parsed = array();

        foreach($descArray as $descItem) {
            $banner = explode(';', $descItem);
            $parsed[$banner[0]] = array('all_imps'  => $banner[1],
                                        'uniq_imps' => $banner[2],
                                        'clicks'    => $banner[3],
                                        'rank'      => $banner[4]);
        }
        return $parsed;
    }

}

?>
