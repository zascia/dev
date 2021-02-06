<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Scripts_Bl_TopCampaignStatistics
{
    function getTopCampaignStats($topCount,
                           $d1='',$m1='',$y1='',$d2='',$m2='',$y2='',
                           $AccountID='',
                           $settings = '')
    {
        if(is_object($GLOBALS['Auth']))
        {
            if($AccountID == '')
            {
                $AccountID = $GLOBALS['Auth']->getAccountID();
            }
            if($settings == '')
            {
                $settings = array();
                $settings['Aff_support_signup_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_signup_commissions');
                $settings['Aff_support_referral_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_referral_commissions');
                $settings['Aff_support_cpm_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions');
                $settings['Aff_support_click_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_click_commissions');
                $settings['Aff_support_sale_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_sale_commissions');
                $settings['Aff_support_lead_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_lead_commissions');
                $settings['Aff_support_recurring_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions');
            }
        }
        
        $TopData = array();
        $TopData['cpm'] = array();
        $TopData['imps'] = array();
        $TopData['click'] = array();
        $TopData['lead'] = array();
        $TopData['sale'] = array();
        $TopData['revenue'] = array();
        
        $TopData = Affiliate_Scripts_Bl_TopCampaignStatistics::getImpressionTopData('',          // BannerID
                                                                             $topCount,
                                                                             $d1,$m1,$y1,
                                                                             $d2,$m2,$y2,
                                                                             $AccountID,
                                                                             $TopData);

        $TopData = Affiliate_Scripts_Bl_TopCampaignStatistics::getTransactionsTopData($topCount,
                                                                             $d1,$m1,$y1,
                                                                             $d2,$m2,$y2,
                                                                             $AccountID,
                                                                             $TopData,
                                                                             $settings);
                                                                             
        return $TopData;
    }

    //------------------------------------------------------------------------
    
    function getImpressionTopData($BannerID, $topCount, $d1,$m1,$y1, $d2,$m2,$y2, $AccountID, $TopData)
    {
        $sql = "select b.campaignid as campaignid, sum(all_imps_count) as count, sum(unique_imps_count) as unique_count, c.name as name". 
                   " from wd_pa_impressions i, wd_pa_banners b, wd_pa_campaigns c".
                   " where i.bannerid=b.bannerid and b.campaignid=c.campaignid and c.deleted=0".
                   " and i.accountid="._q($AccountID);
                   
        if($BannerID != '_' && $BannerID != '')
        {
            $sql .= " and i.bannerid="._q($BannerID);
        }
        if($d1 != '' && $m1 != '' && $y1 != '')
        {
            $sql .= " and (".sqlToDays('i.dateimpression')." >= ".sqlToDays("$y1-$m1-$d1").")".
                    " and (".sqlToDays('i.dateimpression')." <= ".sqlToDays("$y2-$m2-$d2").")";
        }
        
        $sql .= " group by campaignid order by unique_count desc";

        if($topCount != '' && $topCount != '_')
        {
            $sql .= " LIMIT $topCount";
        }
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['name'] = $rs->fields['name'];
            $temp['all'] = $rs->fields['count'];
            $temp['unique'] = $rs->fields['unique_count'];
            $TopData['imps'][] = $temp;

            $rs->MoveNext();
        }
        
        return $TopData;
    }
    
    //------------------------------------------------------------------------
    
    function getTransactionsTopData($topCount, $d1,$m1,$y1, $d2,$m2,$y2, $AccountID, $TopData, $settings)
    {
        if($topCount == '' || $topCount == '_') {
            $topCount = 1000;
        }
        
        // build sql
        $sql = "select cc.campaignid as campaignid, c.name as name, ";
        $sqlTransType = "count(transid) as countt, t.transtype ";
        
        $where = " from wd_pa_transactions t, wd_g_users a, wd_pa_campaigncategories cc, wd_pa_campaigns c".
               " where t.campcategoryid=cc.campcategoryid ".
               " and cc.campaignid=c.campaignid ".
               " and t.affiliateid=a.userid and a.deleted=0 ".
               " and c.deleted=0 ".
               " and a.rtype="._q(USERTYPE_USER).
               " and a.rstatus="._q(AFFSTATUS_APPROVED).
               " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and t.rstatus<>".AFFSTATUS_SUPPRESSED;
        
        $where2 = '';

        if($d1 != '' && $m1 != '' && $y1 != '')
        {
            $where2 .= " and (".sqlToDays('t.dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
                    " and (".sqlToDays('t.dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
        }

        $groupby = " group by campaignid, t.transtype order by countt desc";

        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        $allDone = true;
        while(!$rs->EOF)
        {
            $transType = $rs->fields['transtype'];
            
            if($transType == TRANSTYPE_CPM) {
                if(count($TopData['cpm']) < $topCount) {
                    $temp = array();
                    $temp['campaignid'] = $rs->fields['campaignid'];
                    $temp['name'] = $rs->fields['name'];
                    $temp['count'] = $rs->fields['countt'];
                    $TopData['cpm'][] = $temp;
                }
                
                if(count($TopData['cpm']) < $topCount) {
                    $allDone = false;
                }
            }
            
            if($transType == TRANSTYPE_CLICK) {
                if(count($TopData['click']) < $topCount) {
                    $temp = array();
                    $temp['campaignid'] = $rs->fields['campaignid'];
                    $temp['name'] = $rs->fields['name'];
                    $temp['count'] = $rs->fields['countt'];
                    $TopData['click'][] = $temp;
                }
                
                if(count($TopData['click']) < $topCount) {
                    $allDone = false;
                }
            }

            if($transType == TRANSTYPE_LEAD) {
                if(count($TopData['lead']) < $topCount) {
                    $temp = array();
                    $temp['campaignid'] = $rs->fields['campaignid'];
                    $temp['name'] = $rs->fields['name'];
                    $temp['count'] = $rs->fields['countt'];
                    $TopData['lead'][] = $temp;
                }
                
                if(count($TopData['lead']) < $topCount) {
                    $allDone = false;
                }
            }

            if($transType == TRANSTYPE_SALE) {
                if(count($TopData['sale']) < $topCount) {
                    $temp = array();
                    $temp['campaignid'] = $rs->fields['campaignid'];
                    $temp['name'] = $rs->fields['name'];
                    $temp['count'] = $rs->fields['countt'];
                    $TopData['sale'][] = $temp;
                }
                
                if(count($TopData['sale']) < $topCount) {
                    $allDone = false;
                }
            }

            if($allDone) break;
                
            $rs->MoveNext();
        }

        //------------------------------------------------
        // get revenues
        $sqlTransType = "sum(commission) as countt";
        
        if($settings != '')
        {
            $allowedTransactions = array();

            if($settings['Aff_support_signup_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_SIGNUP;
            if($settings['Aff_support_referral_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_REFERRAL;
            if($settings['Aff_support_cpm_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_CPM;
            if($settings['Aff_support_click_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_CLICK;
            if($settings['Aff_support_sale_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_SALE;
            if($settings['Aff_support_lead_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_LEAD;
            if($settings['Aff_support_recurring_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_RECURRING;
            
            if(count($allowedTransactions) > 0)
            {
                $where2 .= " and t.transtype in (".implode(',', $allowedTransactions).")";
            }
        }        
        $groupby = " group by campaignid order by countt desc";

        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        $topUsers = array();
        while(!$rs->EOF)
        {
            $topUsers[$rs->fields['campaignid']]['campaignid'] = $rs->fields['campaignid'];
            $topUsers[$rs->fields['campaignid']]['name'] = $rs->fields['name'];
            $topUsers[$rs->fields['campaignid']]['sum'] = _rnd($rs->fields['countt']);
            if(count($topUsers) > $topCount*5) break;
            
            $rs->MoveNext();
        }

        // sort top campaigns by count
        $GLOBALS['uasort_by'] = 'sum';
        $GLOBALS['uasort_order'] = 'desc';

        uasort($topUsers, 'cmp_sort');
        reset($topUsers);
        
        while (list($key, $val) = each($topUsers)) {
            $temp = array();
            $temp['campaignid'] = $val['campaignid'];
            $temp['name'] = $val['name'];
            $temp['sum'] = $val['sum'];
            $TopData['revenue'][] = $temp;
            
            if(count($TopData['revenue']) >= $topCount) break;
        }

        return $TopData;
    }
    
    //------------------------------------------------------------------------

}
?>
