<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Scripts_Bl_TrendStatistics
{
    function getTrendStats($AffiliateID,
                           $CampaignID,
                           $reportType,
                           $d1='',$m1='',$y1='',$d2='',$m2='',$y2='',
                           $AccountID='',
                           $settings = '',
                           $supportAllOption = false,
			   $dateSelectMode='1')
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
                $settings['Aff_support_refund_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_refund_commissions');
            	$settings['Aff_support_chargeback_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_chargeback_commissions');
            }
        }
        
        $TrendData = $this->initResults($reportType);
        
        $TrendData = $this->getImpressionStats($AffiliateID, 
                                                                             '',            // BannerID
                                                                             $CampaignID,
                                                                             $reportType,
                                                                             $d1,$m1,$y1,
                                                                             $d2,$m2,$y2,
                                                                             $AccountID,
                                                                             $TrendData,
                                                                             $supportAllOption
									     );

        $TrendData = $this->getTransactionsStats($AffiliateID, 
                                                                             $CampaignID,
                                                                             $reportType,
                                                                             $d1,$m1,$y1,
                                                                             $d2,$m2,$y2,
                                                                             $AccountID,
                                                                             $TrendData,
                                                                             $settings,
                                                                             $supportAllOption,
									     $dateSelectMode = '');
	                                                                     
        return $TrendData;
    }

    //------------------------------------------------------------------------
    
    function initResults($reportType)
    {
        $TrendData = array();
        
        if($reportType == 'hourly')
        {
            $min = 0;
            $max = 23;
        }
        else if($reportType == 'daily')
        {
            $min = 1;
            $max = 31;
        }
        else if($reportType == 'weekly') {
            $min = 1;
            $max = 7;
        }
        else if($reportType == 'monthly')
        {
            $min = 1;
            $max = 12;
        }
        
        for($i=$min; $i<=$max; $i++)
        {
            $TrendData['imps'][$i]['unique'] = 0;
            $TrendData['imps'][$i]['all'] = 0;
            $TrendData['cpm'][$i] = 0;
            $TrendData['clicks'][$i] = 0;
            $TrendData['sales'][$i] = 0;
            $TrendData['leads'][$i] = 0;
            $TrendData['revenue'][$i] = 0;
        }
        
        return $TrendData;
    }
    
    //------------------------------------------------------------------------
    
    function getImpressionStats($AffiliateID, $BannerID, $CampaignID, $reportType, $d1,$m1,$y1, $d2,$m2,$y2, $AccountID, $TrendData, $supportAllOption = false)
    {
        if($reportType == 'hourly')
        {
            $period = sqlHour('i.dateimpression');
        }
        else if($reportType == 'daily')
        {
            $period = sqlDayOfMonth('i.dateimpression');
        }
        else if($reportType == 'weekly')
        {
            $period = sqlDayOfWeek('i.dateimpression');
        }
        else if($reportType == 'monthly')
        {
            $period = sqlMonth('i.dateimpression');
        }

        
        $sql = "select ".$period." as period, sum(all_imps_count) as count, sum(unique_imps_count) as unique_count". 
                   " from wd_pa_impressions i, wd_pa_banners b".
                   " where i.bannerid=b.bannerid".
                   " and i.accountid="._q($AccountID);
                   
        if($BannerID != '_' && $BannerID != '')
        {
            $sql .= " and i.bannerid="._q($BannerID);
        }
        if($AffiliateID != '_' && $AffiliateID != '')
        {
            $sql .= " and i.affiliateid="._q($AffiliateID);
        }
        if($d1 != '' && $m1 != '' && $y1 != '')
        {
            if ($supportAllOption) {
                $sql .= " and (".sqlDayOfMonth('i.dateimpression')." >= "._q($d1).")".
                        " and (".sqlDayOfMonth('i.dateimpression')." <= "._q($d2).")";
                if($reportType == 'weekly') {
                    $sql .= " and (".sqlWeek('i.dateimpression')." >= "._q($m1).")".
                            " and (".sqlWeek('i.dateimpression')." <= "._q($m2).")";
                } else {
                    $sql .= " and (".sqlMonth('i.dateimpression')." >= "._q($m1).")".
                            " and (".sqlMonth('i.dateimpression')." <= "._q($m2).")";
                }
                $sql .= " and (".sqlYear('i.dateimpression')." >= "._q($y1).")".
                        " and (".sqlYear('i.dateimpression')." <= "._q($y2).")";
            } else {
                $sql .= " and (".sqlToDays('i.dateimpression')." >= ".sqlToDays("$y1-$m1-$d1").")".
                        " and (".sqlToDays('i.dateimpression')." <= ".sqlToDays("$y2-$m2-$d2").")";
            }
        }
        if($CampaignID != '_' && $CampaignID != '')
        {
            $sql .= " and b.campaignid="._q($CampaignID);
        }

        $sql .= " group by ".$period;
	
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        while(!$rs->EOF)
        {
            $TrendData['imps'][$rs->fields['period']]['all'] = $rs->fields['count'];

            $TrendData['imps'][$rs->fields['period']]['unique'] = $rs->fields['unique_count'];

            $rs->MoveNext();
        }
        
        return $TrendData;
    }
    
    //------------------------------------------------------------------------
    
    function getTransactionsStats($AffiliateID, $CampaignID, $reportType, $d1,$m1,$y1, $d2,$m2,$y2, $AccountID, 
	$TrendData, $settings, $supportAllOption = false, $dateSelectMode=1 )
    {
        // build sql
	
        //added by AdAstra
        //added switch between date inserted and date approved, date inserted is default
        switch($dateSelectMode){
            case 2:
            //this is added
            if($reportType == 'hourly'){
                $period = sqlHour('t.dateapproved');
            }
            else if($reportType == 'daily'){
                $period = sqlDayOfMonth('t.dateapproved');
            }
            else if($reportType == 'weekly'){
                $period = sqlDayOfWeek('t.dateapproved');
            }
            else if($reportType == 'monthly'){
                $period = sqlMonth('t.dateapproved');    
            }
            break;
            default:
            //this is left from base program
        	if($reportType == 'hourly')
            {
	            $period = sqlHour('t.dateinserted');
    		}
	        else if($reportType == 'daily')
    		{
	            $period = sqlDayOfMonth('t.dateinserted');
    		}
	        else if($reportType == 'weekly')
    		{
	            $period = sqlDayOfWeek('t.dateinserted');
    		}
	        else if($reportType == 'monthly')
    		{
	            $period = sqlMonth('t.dateinserted');
    		}
            break;
        }
        //end added
        
        $sql = "select ".$period." as period, ";
        
        $sqlTransType = "sum(count) as count, t.transtype ";
                
        $where = " from wd_pa_transactions t, wd_g_users a, wd_pa_campaigncategories cc".
               " where t.campcategoryid=cc.campcategoryid ".
               " and t.affiliateid=a.userid and a.deleted=0 ".
               " and a.rtype="._q(USERTYPE_USER).
               " and a.rstatus="._q(AFFSTATUS_APPROVED).
               " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and t.transkind=".TRANSKIND_NORMAL.
               " and t.rstatus<>".AFFSTATUS_SUPPRESSED;
        
        $where2 = '';
        if($AffiliateID != '_' && $AffiliateID != '')
        {
            $where2 .= " and t.affiliateid="._q($AffiliateID);
        }
        if($d1 != '' && $m1 != '' && $y1 != '')
        {
	//added by AdAstra
	//added switch
	    switch($dateSelectMode){
		case '2':
		//select by date approved
		    if($supportAllOption){
			$where2 .= " and (".sqlDayOfMonth('t.dateapproved')." >= "._q($d1).")".
				   " and (".sqlDayOfMonth('t.dateapproved')." <= "._q($d2).")";
				   
			if($reportType == 'weekly') {
			    $where2 .= " and (".sqlWeek('t.dateapproved')." >= "._q($m1).")".
				       " and (".sqlWeek('t.dateapproved')." <= "._q($m2).")";
			} else {
			    $where2 .= " and (".sqlMonth('t.dateapproved')." >= "._q($m1).")".
				       " and (".sqlMonth('t.dateapproved')." <= "._q($m2).")";
			}
			$where2 .= " and (".sqlYear('t.dateapproved')." >= "._q($y1).")".
				   " and (".sqlYear('t.dateapproved')." <= "._q($y2).")";
				        
		    } else {
			$where2 .= " and (".sqlToDays('t.dateapproved')." >= ".sqlToDays("$y1-$m1-$d1").")".
				   " and (".sqlToDays('t.dateapproved')." <= ".sqlToDays("$y2-$m2-$d2").")";
		    }
		    break;
    		default:
		//default left untouched
	    	    if ($supportAllOption) {
        	        $where2 .= " and (".sqlDayOfMonth('t.dateinserted')." >= "._q($d1).")".
                	           " and (".sqlDayOfMonth('t.dateinserted')." <= "._q($d2).")";
			if($reportType == 'weekly') {
    	            	    $where2 .= " and (".sqlWeek('t.dateinserted')." >= "._q($m1).")".
        	        	       " and (".sqlWeek('t.dateinserted')." <= "._q($m2).")";
                	} else {
	            	    $where2 .= " and (".sqlMonth('t.dateinserted')." >= "._q($m1).")".
    	                	       " and (".sqlMonth('t.dateinserted')." <= "._q($m2).")";
        		}
			$where2 .= " and (".sqlYear('t.dateinserted')." >= "._q($y1).")".
                    	           " and (".sqlYear('t.dateinserted')." <= "._q($y2).")";
    		    } else {
            		$where2 .= " and (".sqlToDays('t.dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
                    		   " and (".sqlToDays('t.dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
        	    }	    
		    break;
    	    }
        }
        if($CampaignID != '_' && $CampaignID != '')
        {
            $where2 .= " and cc.campaignid="._q($CampaignID);
        }

        $groupby = " group by t.transtype, ".$period;
	
        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        while(!$rs->EOF)
        {
            switch($rs->fields['transtype'])
            {
                case TRANSTYPE_CPM: $TrendData['cpm'][$rs->fields['period']] = $rs->fields['count']; break;
                case TRANSTYPE_CLICK: $TrendData['clicks'][$rs->fields['period']] = $rs->fields['count']; break;
                case TRANSTYPE_LEAD: $TrendData['leads'][$rs->fields['period']] = $rs->fields['count']; break;
                case TRANSTYPE_SALE: $TrendData['sales'][$rs->fields['period']] = $rs->fields['count']; break;
            }

            $rs->MoveNext();
        }

        // get revenues
        $sqlTransType = "sum(commission) as count";
        
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
            if($settings['Aff_support_refund_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_REFUND;
            if($settings['Aff_support_chargeback_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_CHARGEBACK;
            
            if(count($allowedTransactions) > 0)
            {
                $where2 .= " and t.transtype in (".implode(',', $allowedTransactions).")";
            }
        }        
        $groupby = " group by ".$period;
        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        while(!$rs->EOF)
        {
            $TrendData['revenue'][$rs->fields['period']] = _rnd($rs->fields['count']);

            $rs->MoveNext();
        }
        
        if($CampaignID == '_' || $CampaignID == '')
        {
            // process non-campaign transactions in time range
            $where = " from wd_pa_transactions t, wd_g_users a".
                      " where (t.campcategoryid Is Null or t.campcategoryid='' or t.campcategoryid='0')".
                      " and t.affiliateid=a.userid and a.deleted=0 ".
                      " and a.rtype="._q(USERTYPE_USER).
                      " and a.rstatus="._q(AFFSTATUS_APPROVED).
                      " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
                      " and t.transkind=".TRANSKIND_NORMAL.
                      " and t.rstatus<>".AFFSTATUS_SUPPRESSED;
                      
            $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
            if (!$rs)
            return false;
            
            while(!$rs->EOF)
            {
                $TrendData['revenue'][$rs->fields['period']] += _rnd($rs->fields['count']);
                
                $rs->MoveNext();
            }            
            
        }
        return $TrendData;
    }
    
    //------------------------------------------------------------------------

    function checkSomeTransImpsExistedLastYear($affiliateID = '')
    {
        $year = date('Y') - 1;
        
        $sql = "select * from wd_pa_transactions where accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and (".sqlToDays('dateinserted')." >= ".sqlToDays("$year-01-01").")".
               " and (".sqlToDays('dateinserted')." <= ".sqlToDays("$year-12-31").")";

                       
        if($affiliateID != '')
        {
            $sql .= " and affiliateid="._q($affiliateID);
        }

        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$groupby, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
            return false;

        return true;
    }
}
?>
