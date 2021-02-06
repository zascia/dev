<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Affiliates_Views_AffCampaignManager');

class Affiliate_Affiliates_Views_AffCampaignManagerNetwork extends Affiliate_Affiliates_Views_AffCampaignManager
{
    var $blAffiliate;
    var $blSettings;
    var $viewAffBannerManager;

    function Affiliate_Affiliates_Views_AffCampaignManagerNetwork() {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Affiliates_Bl_Affiliate');
        $this->blSettings =& QUnit_Global::newObj('Affiliate_Affiliates_Bl_Settings');
        $this->viewAffBannerManager =& QUnit_Global::newObj('Affiliate_Affiliates_Views_AffBannerManager');        
    }

    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
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
  
    function showCampaigns()
    {
        // get aff campaigns status
        $params = array('userID' => $GLOBALS['Auth']->getUserID());

        $affcamps = $this->blAffiliate->getAffiliateCampaignsStatus($params);

        if(is_bool($affcamps) && $affcamps == false) return false;

        $sql = 'select distinct c.* from wd_pa_campaigns c, wd_pa_campcat2 cc2 '.
               'where c.deleted=0'.
               '  and c.campaignid=cc2.campaignid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            $this->addErrorMessage(L_G_DBERROR);
            return false;
        }

        $data = array();
    
        $params = array();
    
        $affs_camp = $this->blSettings->getAffCampaignSettings($params);
        $bannercount = $this->viewAffBannerManager->getCountBannersAsArray();
        $campaignCommissions = $this->getCommissionsAsArray($GLOBALS['Auth']->userID);

        while(!$rs->EOF)
        {
            if($affs_camp[$rs->fields['campaignid']][SETTINGTYPEPREFIX_AFF_CAMP.'status'] == AFF_CAMP_PRIVATE
               && ($affcamps[$rs->fields['campaignid']] == '' || $affcamps[$rs->fields['campaignid']] != AFFSTATUS_APPROVED))
            {
                $rs->MoveNext();
                continue;
            }

            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['name'] = $rs->fields['name'];
            $temp['shortdescription'] = $rs->fields['shortdescription'];
            $temp['commtype'] = $rs->fields['commtype'];

            $temp['banner_url'] = $affs_camp[$rs->fields['campaignid']][SETTINGTYPEPREFIX_AFF_CAMP.'banner_url'];

            $temp['rstatus'] = $affcamps[$rs->fields['campaignid']];

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

        $this->addContent('cm_list_network');
    }
}
?>
