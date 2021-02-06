<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_NonPerformAffiliates extends QUnit_UI_TemplatePage
{
    var $results = array();

    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Views_NonPerformAffiliates() {

        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');

        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_REPORTS,'index.php?md=Affiliate_Merchants_Views_MerchantReports');
        $this->navigationAddURL(L_G_NONPERFORMAFFILIATES,'index.php?md=Affiliate_Merchants_Views_NonPerformAffiliates');
    }

    //--------------------------------------------------------------------------

    function initPermissions()
    {
        $this->modulePermissions['nonperformaffiliates'] = 'aff_rep_non_perform_affiliates_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
    	$this->show();
    }

    //------------------------------------------------------------------------

    function show()
    {
        $this->assign('a_form_preffix', 'np_');
        $this->assign('a_form_name', 'FilterForm');
        $this->assign('a_md', 'Affiliate_Merchants_Views_NonPerformAffiliates');

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'np_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
            if($k == 'numrows' && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }

        //--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
        if($_REQUEST['np_day1'] == '') $_REQUEST['np_day1'] = date("j");
        if($_REQUEST['np_month1'] == '') $_REQUEST['np_month1'] = date("n");
        if($_REQUEST['np_year1'] == '') $_REQUEST['np_year1'] = date("Y");
        if($_REQUEST['np_day2'] == '') $_REQUEST['np_day2'] = date("j");
        if($_REQUEST['np_month2'] == '') $_REQUEST['np_month2'] = date("n");
        if($_REQUEST['np_year2'] == '') $_REQUEST['np_year2'] = date("Y");
        if($_REQUEST['np_year2'] == '') $_REQUEST['np_year2'] = date("Y");
        if($_REQUEST['np_impressions'] == '') $_REQUEST['np_impressions'] = '0';
        if($_REQUEST['np_clicks'] == '') $_REQUEST['np_clicks'] = '0';
        if($_REQUEST['np_sales'] == '') $_REQUEST['np_sales'] = '0';
        if($_REQUEST['np_leads'] == '') $_REQUEST['np_leads'] = '0';
        if($_REQUEST['np_impressions_less'] == '') $_REQUEST['np_impressions_less'] = '';
        if($_REQUEST['np_clicks_less'] == '') $_REQUEST['np_clicks_less'] = '';
        if($_REQUEST['np_sales_less'] == '') $_REQUEST['np_sales_less'] = '';
        if($_REQUEST['np_leads_less'] == '') $_REQUEST['np_leads_less'] = '';
        if($_REQUEST['np_timeselect'] == '') $_REQUEST['np_timeselect'] = TIME_PRESET;
        if($_REQUEST['np_timepreset'] == '') $_REQUEST['np_timepreset'] = TIME_TODAY;

        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['np_day1'] = $_REQUEST['np_day1'];
        $_SESSION['np_month1'] = $_REQUEST['np_month1'];
        $_SESSION['np_year1'] = $_REQUEST['np_year1'];
        $_SESSION['np_day2'] = $_REQUEST['np_day2'];
        $_SESSION['np_month2'] = $_REQUEST['np_month2'];
        $_SESSION['np_year2'] = $_REQUEST['np_year2'];
        $_SESSION['np_timeselect'] = $_REQUEST['np_timeselect'];
        $_SESSION['np_timepreset'] = $_REQUEST['np_timepreset'];
        $_SESSION['np_impressions'] = $_REQUEST['np_impressions'];
        $_SESSION['np_clicks'] = $_REQUEST['np_clicks'];
        $_SESSION['np_sales'] = $_REQUEST['np_sales'];
        $_SESSION['np_leads'] = $_REQUEST['np_leads'];
        $_SESSION['np_impressions_less'] = $_REQUEST['np_impressions_less'];
        $_SESSION['np_clicks_less'] = $_REQUEST['np_clicks_less'];
        $_SESSION['np_sales_less'] = $_REQUEST['np_sales_less'];
        $_SESSION['np_leads_less'] = $_REQUEST['np_leads_less'];

        $this->assign('a_curyear', date("Y"));
        $this->addContent('rep_non_perform_affiliates_filter');

        // process time filter
        if($_REQUEST['np_timeselect'] == TIME_PRESET) {
            $_REQUEST = array_merge($_REQUEST, getTimerangeForPreset($_REQUEST['np_timepreset'], 'np_'));
        }

        if(empty($_REQUEST['list_page']))
            $page = 0;
        else
            $page = $_REQUEST['list_page'];
        
        $conditions = array('day1'   => $_REQUEST['np_day1'],
                            'month1' => $_REQUEST['np_month1'],
                            'year1'  => $_REQUEST['np_year1'],
                            'day2'   => $_REQUEST['np_day2'],
                            'month2' => $_REQUEST['np_month2'],
                            'year2'  => $_REQUEST['np_year2']);

        $results = $this->getStats($conditions);

        //sales, leads, clicks, impressions filter
        $filter_vars = array('impressions','clicks','sales','leads');
        
        foreach ($filter_vars as $var_name) {
            switch ($_REQUEST['np_'.$var_name]) {
                
                case 'less':
                    ${$var_name} = $_REQUEST['np_'.$var_name.'_less'];
                    break;
                    
                case 'any':
                    ${$var_name} = -1;
                    break;
                    
                default : ${$var_name} = 0;
            }
        }

        foreach ($results as $key => $result) {
            
            $add = true;
            $any = 0;

            foreach ($filter_vars as $var_name) {
                
                if (${$var_name} < 0) {
                    $any++;
                    continue;
                }
            
                if ($result[$var_name] > ${$var_name}) {
                    $add = false;
                }
            }

            if ($add || $any == count($filter_vars)) {
                $this->results[$key] = $result;
            }
        }
        
        if (!empty($_REQUEST['np_loginFilter'])) {
            $this->results = $this->dateFilter($this->results, $_REQUEST['np_day'], $_REQUEST['np_month'], $_REQUEST['np_year'], 'timelastlogin');
        }
        
        if (!empty($_REQUEST['np_registerFilter'])) {
            $this->results = $this->dateFilter($this->results, $_REQUEST['np_regday'], $_REQUEST['np_regmonth'], $_REQUEST['np_regyear'], 'dateinserted');
        }
        
        // sorting, default by affiliate surname, name
        if (!empty($_REQUEST['np_sortby']) && $_REQUEST['np_sortby'] != 'affiliate') {
            $GLOBALS['uasort_by'] = $_REQUEST['np_sortby'];
            $GLOBALS['uasort_order'] = 'asc';
            usort($this->results, cmp_sort);
        }
        
        $_REQUEST['allcount'] = count($this->results);
        $_REQUEST['list_pages'] = ceil($_REQUEST['allcount']/$_REQUEST['numrows']);
        $this->results = array_slice($this->results,$page*$_REQUEST['numrows'],$_REQUEST['numrows']);
        
        $this->pageLimitsAssign();
        $this->addContent('rep_non_perform_affiliates_list');
    }

    //--------------------------------------------------------------------------

    function dateFilter($array, $d, $m, $y, $field) {
        $results = array();
        $date = strtotime("$y-$m-$d");
        
        foreach ($array as $key => $result) {
            if ($result[$field] == null || $result[$field] < $date) {
                $results[] = $result;
            }
        }
        
        return $results;
    }
    
    //--------------------------------------------------------------------------

    function getStats($conditions) {
        $results = array();

        if(AFF_PROGRAM_TYPE != PROG_TYPE_PRO) {
            $campaignid = preg_replace('/[\'\"]/', '', $_REQUEST['np_campaignid']);
            if (empty($campaignid)) {
                $campaignid = DEFAULT_CAMPAIGN;
            }
            $campcategories = "('".implode("','",$this->getCampaignCategories($campaignid))."')";
            $campaign_condition = " and b.campcategoryid IN $campcategories ";
        } else {
            $campaign_condition = '';
        }
        
        $d1 = $conditions['day1'];
        $m1 = $conditions['month1'];
        $y1 = $conditions['year1'];
        $d2 = $conditions['day2'];
        $m2 = $conditions['month2'];
        $y2 = $conditions['year2'];

        $fields = array('userinfo',
                        'impressions',
                        'clicks',
                        'sales',
                        'leads',
                        'lastlogindate',
                        'logincount');

        if($d1 != '' && $m1 != '' && $y1 != '' && $d2 != '' && $m2 != '' && $y2 != '') {
            $filter_date .= "and (".sqlToDays('b.dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").") ".
                            "and (".sqlToDays('b.dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
        }        
                        
        // wd_g_users as a wd_g_transactions as b
        $filter_user  = "where a.rtype = ".USERTYPE_USER." and a.rstatus = ".AFFSTATUS_APPROVED." and a.deleted=0";
        $order        = "order by a.surname, a.name";

        // COUNT(*)-1 due to [NULL]
        $correct = 1;
        $field_queries = array("select a.userid, a.name, a.surname, UNIX_TIMESTAMP(a.dateinserted) as dateinserted, a.dateinserted as datejoined from wd_g_users as a $filter_user $order",
                               "select a.userid, sum(b.all_imps_count)-1 as '".$fields[1]."' from wd_g_users as a left join wd_pa_impressions as b on a.userid = b.affiliateid $filter_user group by userid $order",
                               "select a.userid, count(b.transid) as '".$fields[2]."' from wd_g_users a left join wd_pa_transactions b on a.userid = b.affiliateid and b.transtype = ".TRANSTYPE_CLICK." $campaign_condition $filter_date $filter_user group by a.userid $order",
                               "select a.userid, count(b.transid) as '".$fields[3]."' from wd_g_users a left join wd_pa_transactions b on a.userid = b.affiliateid and b.transtype = ".TRANSTYPE_SALE." $campaign_condition $filter_date $filter_user group by a.userid $order",
                               "select a.userid, count(b.transid) as '".$fields[4]."' from wd_g_users a left join wd_pa_transactions b on a.userid = b.affiliateid and b.transtype = ".TRANSTYPE_LEAD." $campaign_condition $filter_date $filter_user group by a.userid $order",
                               "select a.userid, UNIX_TIMESTAMP(DATE_FORMAT(b.value,'%Y-%m-%d %H:%i:%s')) as timestamp, b.value as '".$fields[5]."' from wd_g_users as a left join wd_g_settings as b on a.userid = b.userid and b.code = 'Aff_lastlogintime' $filter_user group by a.userid $order",
                               "select a.userid, b.value as '".$fields[6]."' from wd_g_users as a left join wd_g_settings as b on a.userid = b.userid and b.code = 'Aff_logincount' $filter_user group by a.userid $order");
                               
        foreach ($field_queries as $key=>$sql) {
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }

            switch ($key) {
                
                case 0 :
                    while(!$rs->EOF) {
                        foreach ($rs->fields as $fieldkey=>$val) {
                            if(!is_numeric($fieldkey)) {
                                $results[$rs->fields['userid']][$fieldkey] = $val;
                            }
                        }
                        $rs->MoveNext();
                    }
                    break;
                    
                case 5 :
                    while(!$rs->EOF) {
                        $date = (empty($rs->fields[$fields[$key]]))? L_G_NEVER : $rs->fields[$fields[$key]];
                        $results[$rs->fields['userid']][$fields[$key]] = $date;
                        $results[$rs->fields['userid']]['timelastlogin'] = $rs->fields['timestamp'];
                        $rs->MoveNext();
                    }
                    break;
                
                case 6 :
                    $correct = 0;
                    
                default:
                    while(!$rs->EOF) {
                        $data = ($rs->fields[$fields[$key]] != 0)? $rs->fields[$fields[$key]]+$correct : 0;
                        $results[$rs->fields['userid']][$fields[$key]] = $data;
                        $rs->MoveNext();
                    }
            }
        }
        
        return $results;
    }

    //--------------------------------------------------------------------------
    
    function getCampaignCategories($campaignid) {
        
        $sql = "SELECT campcategoryid FROM wd_pa_campaigncategories WHERE campaignid = '".$campaignid."'";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        $temp = array();

        while (!$rs->EOF) {

            $temp[] = $rs->fields['campcategoryid'];
            $rs->MoveNext();
        }
        
        return $temp;
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
