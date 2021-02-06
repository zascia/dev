<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');

class Affiliate_Affiliates_Views_AffCampaignManager extends Affiliate_Merchants_Views_CampaignManager
{
    var $class_name = 'Affiliate_Affiliates_Views_AffCampaignManager';
    var $blAffiliate;
    var $blSettings;
    var $viewAffBannerManager;

    //------------------------------------------------------------------------

    function Affiliate_Affiliates_Views_AffCampaignManager()
    {
        Affiliate_Merchants_Views_CampaignManager::Affiliate_Merchants_Views_CampaignManager();
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Affiliates_Bl_Affiliate');
        $this->blSettings =& QUnit_Global::newObj('Affiliate_Affiliates_Bl_Settings');
        $this->viewAffBannerManager =& QUnit_Global::newObj('Affiliate_Affiliates_Views_AffBannerManager');
    }

    //------------------------------------------------------------------------

    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'join_camp':
                    if($this->processJoinToCampaign())
                        return;
                    break;

                case 'show_decline_reason':
                    if($this->drawDeclineReason())
                        return;
                    break;

                case 'details':
                    if($this->drawFormDetails())
                        return;
                    break;
            }
        }

        $this->showCampaigns();
    }

    //------------------------------------------------------------------------

    function processJoinToCampaign($redir_request = 'Affiliate_Affiliates_Views_AffCampaignManager')
    {
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['campaign']);

        $params = array('userID' => $GLOBALS['Auth']->getUserID(),
                        'CampaignID' => $CampaignID
                       );

        $ret = $this->blAffiliate->insertAffCamp($params);

        if($ret == false) return false;

        $this->addOkMessage(L_G_JOINCAMPAIGNREQUESTSENT);

        $this->redirect($redir_request);

        return true;
    }

    //------------------------------------------------------------------------

    function drawDeclineReason()
    {
        $_POST['header'] = L_G_CAMPAIGN_DECLINE_REASON;

        $params = array('userID' => $GLOBALS['Auth']->getUserID(),
                        'campaign' => $_REQUEST['campaign']
                       );

        $data = $this->blAffiliate->getDeclineReason($params);

        if($data == false) return false;

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS(array($data));
        $this->assign('a_list_data', $list_data);

        $this->addContent('decline_reason_view');

        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormDetails()
    {
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['campaign']);

        $_POST['header'] = L_G_CAMPAIGN_DETAILS;

        // get aff campaigns status
        $params = array('userID' => $GLOBALS['Auth']->getUserID());

        $affcamps = $this->blAffiliate->getAffiliateCampaignsStatus($params);

        if($affcamps === false) return false;

        // get campaign data
        $sql = 'select * from wd_pa_campaigns '.
               'where deleted=0 ';
        if($CampaignID != '') $sql .= '  and campaignid='._q($CampaignID);
        if($GLOBALS['Auth']->getProgramType() != PROG_TYPE_NETWORK)
            $sql .= '  and accountid='._q($GLOBALS['Auth']->getAccountID());

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            $this->addErrorMessage(L_G_DBERROR);
            return true;
        }

        // colect other campaign data
        if($GLOBALS['Auth']->getProgramType() != PROG_TYPE_NETWORK) {
            $params = array('accountid' => $GLOBALS['Auth']->getAccountID());
        } else {
            $paramas = array();
        }

        $affs_camp = $this->blSettings->getAffCampaignSettings($params);
        $bannercount = $this->viewAffBannerManager->getCountBannersAsArray();
        $campaignCommissions = $this->getCommissionsAsArray($GLOBALS['Auth']->userID);

        $params = array('userID' => $GLOBALS['Auth']->getUserID(),
                        'campaign' => $CampaignID
                       );

        $declinereason = $this->blAffiliate->getDeclineReason($params);

        // now we have all data
        $data['campaignid'] = $rs->fields['campaignid'];
        $data['name'] = $rs->fields['name'];
        $data['shortdescription'] = $rs->fields['shortdescription'];
        $data['description'] = nl2br($rs->fields['description']);
        $data['commtype'] = $rs->fields['commtype'];

        $data['banner_url'] = $affs_camp[$rs->fields['campaignid']][SETTINGTYPEPREFIX_AFF_CAMP.'banner_url'];
        $data['rstatus'] = $affcamps[$rs->fields['campaignid']];

        $data['cpmcommission'] = $campaignCommissions[$rs->fields['campaignid']]['cpmcommission'];
        $data['clickcommission'] = $campaignCommissions[$rs->fields['campaignid']]['clickcommission'];
        $data['salecommission'] = $campaignCommissions[$rs->fields['campaignid']]['salecommission'];
        $data['salecommtype'] = $campaignCommissions[$rs->fields['campaignid']]['salecommtype'];
        $data['stsalecommtype'] = $campaignCommissions[$rs->fields['campaignid']]['stsalecommtype'];
        $data['recurringcommission'] = $campaignCommissions[$rs->fields['campaignid']]['recurringcommission'];
        $data['recurringcommtype'] = $campaignCommissions[$rs->fields['campaignid']]['recurringcommtype'];

        for($i=2; $i<10; $i++) {
            $data['st'.$i.'clickcommission'] = $campaignCommissions[$rs->fields['campaignid']]['st'.$i.'clickcommission'];
            $data['st'.$i.'salecommission'] = $campaignCommissions[$rs->fields['campaignid']]['st'.$i.'salecommission'];
            $data['st'.$i.'recurringcommission'] = $campaignCommissions[$rs->fields['campaignid']]['st'.$i.'salecommission'];
        }
        $data['bannercount'] = ($bannercount[$rs->fields['campaignid']] != '' ? $bannercount[$rs->fields['campaignid']] : '0');

        $data['declinereason'] = $declinereason['declinereason'];

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS(array($data));
        $this->assign('a_list_data', $list_data);

        $this->addContent('cm_details');

        return true;
    }

    //--------------------------------------------------------------------------

    function showCampaigns()
    {
        // get aff campaigns status
        $params = array('userID' => $GLOBALS['Auth']->getUserID());

        $affcamps = $this->blAffiliate->getAffiliateCampaignsStatus($params);

        if(is_bool($affcamps) && $affcamps === false) return false;

        $orderby = '';

        $a = array('name', 'description', 'commtype');

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
        {
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
        }
        else
        {
            $orderby = ' order by dateinserted desc';
        }

        if(!isset($_REQUEST['filtered']) && $_SESSION[SESSION_PREFIX.'cmwhere'] != '')
        {
            $where = $_SESSION[SESSION_PREFIX.'cmwhere'];
        }
        else
        {
            $where = ' where deleted=0'.
                     '  and accountid='._q($GLOBALS['Auth']->getAccountID());

            if($_REQUEST['filtered'] == 1)
            {
                $_REQUEST['f_cname'] = preg_replace('/[\'\"]/', '', $_REQUEST['f_cname']);
//                $_REQUEST['f_weburl'] = preg_replace('/[^0-9]/', '', $_REQUEST['f_weburl']);
                $_REQUEST['f_ctype'] = preg_replace('/[^0-9]/', '', $_REQUEST['f_ctype']);

                if($_REQUEST['f_cname'] != '')
                    $where .= ' and (name like \'%'._q_noendtags($_REQUEST['f_cname']).'%\')';
//                if($_REQUEST['f_weburl'] != '')
//                      $where .= ' and (weburl like \'%'._q_noendtags($_REQUEST['f_weburl']).'%\')';
                if($_REQUEST['f_ctype'] != '')
                    $where .= ' and (commtype ='._q($_REQUEST['f_ctype']).')';
            }

            $_SESSION[SESSION_PREFIX.'cmwhere'] = $where;
        }

        $sql = 'select * from wd_pa_campaigns '.$where.' '.$orderby;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            $this->addErrorMessage(L_G_DBERROR);
            return;
        }

        $data = array();

        $params = array('accountid' => $GLOBALS['Auth']->getAccountID());

        $affs_camp = $this->blSettings->getAffCampaignSettings($params);
        $bannercount = $this->viewAffBannerManager->getCountBannersAsArray();
        $campaignCommissions = $this->getCommissionsAsArray($GLOBALS['Auth']->userID);

        while(!$rs->EOF)
        {
            if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1'
               && $affs_camp[$rs->fields['campaignid']][SETTINGTYPEPREFIX_AFF_CAMP.'status'] == AFF_CAMP_PRIVATE
               && $affcamps[$rs->fields['campaignid']] != AFFSTATUS_APPROVED)
            {
                $rs->MoveNext();
                continue;
            }

            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['name'] = $rs->fields['name'];
            $temp['shortdescription'] = $rs->fields['shortdescription'];
            $temp['description'] = $rs->fields['description'];
            $temp['commtype'] = $rs->fields['commtype'];

            $temp['banner_url'] = $affs_camp[$rs->fields['campaignid']][SETTINGTYPEPREFIX_AFF_CAMP.'banner_url'];

            $temp['rstatus'] = $affcamps[$rs->fields['campaignid']];

            if ($temp['rstatus'] == AFFSTATUS_SUPPRESSED) {
                $p = array('userID' => $GLOBALS['Auth']->getUserID(),
                          'campaign' => $rs->fields['campaignid']);
                $d = $this->blAffiliate->getDeclineReason($p);
                if($d != false) {
                    $temp['declinereason'] = $d['declinereason'];
                }
            }

            $temp['cpmcommission'] = $campaignCommissions[$rs->fields['campaignid']]['cpmcommission'];
            $temp['clickcommission'] = $campaignCommissions[$rs->fields['campaignid']]['clickcommission'];
            $temp['salecommission'] = $campaignCommissions[$rs->fields['campaignid']]['salecommission'];
            $temp['salecommtype'] = $campaignCommissions[$rs->fields['campaignid']]['salecommtype'];
            $temp['recurringcommission'] = $campaignCommissions[$rs->fields['campaignid']]['recurringcommission'];
            $temp['recurringcommtype'] = $campaignCommissions[$rs->fields['campaignid']]['recurringcommtype'];

            $temp['bannercount'] = ($bannercount[$rs->fields['campaignid']] != '' ? $bannercount[$rs->fields['campaignid']] : '0');
            $data[] = $temp;

            $rs->MoveNext();
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($data);
        $this->assign('a_list_data', $list_data);

        $this->assign('a_numrows', count($data));

        $this->assign('a_blCampManager', QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager'));

        $this->addContent('cm_list');
    }

    //------------------------------------------------------------------------

    function getCommissionsAsArray($AffiliateID)
    {
        $sql = 'select cc.* from wd_pa_campaigncategories cc, wd_pa_campaigns c '.
               'where c.deleted=0 and cc.deleted=0'.
               '  and cc.name='._q(UNASSIGNED_USERS).
               '  and c.campaignid=cc.campaignid ';
        if($GLOBALS['Auth']->getProgramType() != PROG_TYPE_NETWORK)
            $sql .= ' and c.accountid='._q($GLOBALS['Auth']->getAccountID());
        $sql .= ' order by cc.campaignid, cc.campcategoryid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs)
        {
            $this->addErrorMessage(L_G_DBERROR);
            return false;
        }

        $campaignCategories = array();
        $affiliateCategories = array();
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['campcategoryid'] = $rs->fields['campcategoryid'];
            $temp['name'] = $rs->fields['name'];
            $temp['cpmcommission'] = $rs->fields['cpmcommission'];
            $temp['clickcommission'] = $rs->fields['clickcommission'];
            $temp['stclickcommission'] = $rs->fields['stclickcommission'];
            $temp['salecommission'] = $rs->fields['salecommission'];
            $temp['stsalecommission'] = $rs->fields['stsalecommission'];
            $temp['salecommtype'] = $rs->fields['salecommtype'];
            $temp['stsalecommtype'] = $rs->fields['stsalecommtype'];
            $temp['recurringcommission'] = $rs->fields['recurringcommission'];
            $temp['recurringcommtype'] = $rs->fields['recurringcommtype'];

            for($i=2; $i<10; $i++) {
                $temp['st'.$i.'clickcommission'] = $rs->fields['st'.$i.'clickcommission'];
                $temp['st'.$i.'salecommission'] = $rs->fields['st'.$i.'salecommission'];
                $temp['st'.$i.'recurringcommission'] = $rs->fields['st'.$i.'recurringcommission'];
            }

            if(!isset($campaignCategories[$temp['campaignid']]))
            {
                $campaignCategories[$temp['campaignid']] = array();

                $affiliateCategories[$temp['campaignid']] = $temp['campcategoryid'];
            }

            $campaignCategories[$temp['campaignid']][$temp['campcategoryid']] = $temp;

            $rs->MoveNext();
        }

        $sql = 'select cc.campaignid, cc.campcategoryid '.
               'from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campcategoryid=ac.campcategoryid'.
               '  and ac.affiliateid='._q($AffiliateID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs)
        {
            $this->addErrorMessage(L_G_DBERROR);
            return false;
        }

        while(!$rs->EOF)
        {
            $affiliateCategories[$rs->fields['campaignid']] = $rs->fields['campcategoryid'];

            $rs->MoveNext();
        }

        // now get commissions for every campaign
        $campaignCommissions = array();
        foreach($affiliateCategories as $CampaignID => $CampCategoryID)
        {
            $sql = 'select cc.* from wd_pa_campaigncategories cc, wd_pa_campaigns c '.
                'where c.deleted=0 and cc.deleted=0'.
                '  and c.campaignid=cc.campaignid '.
                " and c.campaignid='$CampaignID' and cc.campcategoryid='$CampCategoryID'";
            if($GLOBALS['Auth']->getProgramType() != PROG_TYPE_NETWORK)
                $sql .= ' and c.accountid='._q($GLOBALS['Auth']->getAccountID());
            $sql .= ' order by cc.campaignid, cc.campcategoryid';
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            $temp = array();
            $temp['cpmcommission'] = $rs->fields['cpmcommission'];
            $temp['clickcommission'] = $rs->fields['clickcommission'];
            $temp['stclickcommission'] = $rs->fields['stclickcommission'];
            $temp['salecommission'] = $rs->fields['salecommission'];
            $temp['stsalecommission'] = $rs->fields['stsalecommission'];
            $temp['salecommtype'] = $rs->fields['salecommtype'];
            $temp['stsalecommtype'] = $rs->fields['stsalecommtype'];
            $temp['recurringcommission'] = $rs->fields['recurringcommission'];
            $temp['recurringcommtype'] = $rs->fields['recurringcommtype'];

            for($i=2; $i<10; $i++) {
                $temp['st'.$i.'clickcommission'] = $rs->fields['st'.$i.'clickcommission'];
                $temp['st'.$i.'salecommission'] = $rs->fields['st'.$i.'salecommission'];
                $temp['st'.$i.'recurringcommission'] = $rs->fields['st'.$i.'salecommission'];
            }

            $campaignCommissions[$CampaignID] = $temp;
        }

        return $campaignCommissions;
    }
    
    //--------------------------------------------------------------------------
    
    function drawCommissionField($data, $optionLike = false, $drawSubTiers = false)
    {

        $maxCommissionLevels = $GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels');
        if($maxCommissionLevels == '') {
            $maxCommissionLevels = 1;
        }
         
        if($maxCommissionLevels == 1) {
            $drawSubTiers = false;
        }
        
        if($optionLike)
        {
            // draw commission category name
            print '&nbsp;'.($data['name'] == UNASSIGNED_USERS && defined($data['name']) ? constant($data['name']) : $data['name']).', ';
        }
        
        // draw commission type
        $somedrawn = false;
        if($data['commtype'] & TRANSTYPE_CPM)
        {
            print '&nbsp;<b>'.L_G_TYPECPM.'</b>: '.Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['cpmcommission']));
            $somedrawn = true;
        }
        
        print ($somedrawn ? '&nbsp;'.($optionLike ? ', ' : '<br>') : '');
        
        if($data['commtype'] & TRANSTYPE_CLICK)
        {
            print '&nbsp;<b>'.L_G_TYPECLICK.'</b>: ';
            
            if($data['clickcommission'] != '' && $data['clickcommission'] != '0')
            {
                print Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['clickcommission']));
                
                if($drawSubTiers) {
                    for($i=2; $i<=$maxCommissionLevels; $i++) {
                        print "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$i-tier: ".Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['st'.$i.'clickcommission']));
                    }
                }
            }
            else
            {
                print '-';
            }
            
            $somedrawn = true;
        }
        
        print ($somedrawn ? '&nbsp;'.($optionLike ? ', ' : '<br>') : '');
        
        if(($data['commtype'] & TRANSTYPE_SALE) || ($data['commtype'] & TRANSTYPE_LEAD))
        {
            print '&nbsp;<b>'.($data['commtype'] & TRANSTYPE_SALE ? L_G_TYPESALE : L_G_TYPELEAD).'</b>: ';
            
            if($data['salecommission'] != '' && $data['salecommission'] != '0')
            {
                // draw normal commissions
                if($data['salecommtype'] == '%')
                {
                    print _rnd($data['salecommission']).' %';
                    
                    if($drawSubTiers) 
                    {
                        for($i=2; $i<=$maxCommissionLevels; $i++) {
                        	if($data['stsalecommtype'] == '%'){
                        		print "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$i-tier: "._rnd($data['st'.$i.'salecommission']).' %';
                        	}
                        	else {
                        		print "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$i-tier: ".Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['st'.$i.'salecommission']));
                        	}
                        }
                    }
                }
                else
                {
                    print Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['salecommission']));
                    
                    if($drawSubTiers) 
                    {
                        for($i=2; $i<=$maxCommissionLevels; $i++) {
                            if($data['stsalecommtype'] == '%'){
                        		print "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$i-tier: "._rnd($data['st'.$i.'salecommission']).' %';
                        	}
                        	else {
                        		print "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$i-tier: ".Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['st'.$i.'salecommission']));
                        	}
                        }
                    }
                }
                
                print ($somedrawn ? '&nbsp;'.($optionLike ? ', ' : '<br>') : '');
                
                // draw recurring commissions
                if($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') == 1) 
                {
                    print '&nbsp;<b>'.($data['commtype'] & TRANSTYPE_SALE ? L_G_TYPESALE : L_G_TYPELEAD).' '.L_G_SMALLRECURRING.'</b>: ';
                    
                    if($data['recurringcommission'] != '' && $data['recurringcommission'] != '0')
                    {
                        if($data['recurringcommtype'] == '%')
                        {
                            print _rnd($data['recurringcommission']).' %'.' '.L_G_SMALLRECURRING.' ';
                            
                            if($drawSubTiers) {
                                for($i=2; $i<=$maxCommissionLevels; $i++) {
                                    if ($data['strecurringcommtype'] == '%') {
                                    	print "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$i-tier: "._rnd($data['st'.$i.'recurringcommission']).' %'.' '.L_G_SMALLRECURRING.' ';
                                    } else {
                                    	print "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$i-tier: ".Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['st'.$i.'recurringcommission'])).' '.L_G_SMALLRECURRING.' ';
                                    }
                                }
                            }
                        }
                        else
                        {
                            print Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['recurringcommission']));
                            
                            if($drawSubTiers) {
                                for($i=2; $i<=$maxCommissionLevels; $i++) {
                                    print "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$i-tier: ".Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['st'.$i.'recurringcommission'])).' '.L_G_SMALLRECURRING.' ';
                                }
                            }
                        }
                        
                        switch($data['recurringdatetype'])
                        {
                            case RECURRINGTYPE_WEEKLY: print L_G_WEEKLY; break;
                            case RECURRINGTYPE_MONTHLY: print L_G_MONTHLY; break;
                            case RECURRINGTYPE_QUARTERLY: print L_G_QUARTERLY; break;
                            case RECURRINGTYPE_BIANNUALLY: print L_G_BIANNUALLY; break;
                            case RECURRINGTYPE_YEARLY: print L_G_YEARLY; break;
                        }
                    }
                    else
                    {
                        print '-';
                    }
                }
            }
            else
            {
                print '-';
            }
            $somedrawn = true;
        }
    }
}
?>
