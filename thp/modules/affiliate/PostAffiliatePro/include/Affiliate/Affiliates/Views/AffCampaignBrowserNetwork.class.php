<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');

class Affiliate_Affiliates_Views_AffCampaignBrowserNetwork extends Affiliate_Affiliates_Views_AffCampaignManager
{
    var $class_name = 'Affiliate_Affiliates_Views_AffCampaignBrowserNetwork';
    var $blAffiliate;
    var $blSettings;
    var $viewAffBannerManager;    
    
    function Affiliate_Affiliates_Views_AffCampaignBrowserNetwork() {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Affiliates_Bl_Affiliate');
        $this->blSettings =& QUnit_Global::newObj('Affiliate_Affiliates_Bl_Settings');
        $this->viewAffBannerManager =& QUnit_Global::newObj('Affiliate_Affiliates_Views_AffBannerManager');
        $this->blCategories =& QUnit_Global::includeClass('SuperAdmins_Bl_Categories');
             
    }

    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'join_camp':
                    if($this->processJoinToCampaign($this->class_name.'&r='.$_REQUEST['r']))
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
    
    //--------------------------------------------------------------------------
  
    function showCampaigns()
    {
        // get aff campaigns status
        $params = array('userID' => $GLOBALS['Auth']->getUserID());

        $affcamps = $this->blAffiliate->getAffiliateCampaignsStatus($params);

        if(is_bool($affcamps) && $affcamps == false) return false;

        // get tree path content
        $this->initTemporaryTE();

        $prootid = preg_replace('/[\'\"]/', '', $_REQUEST['r']);

        $parentsData = array();
        $params = array();
        $params['parentID'] = ($prootid != '' ? $prootid : '');
        $params['table_name'] = 'wd_g_categories';
        $params['column_id'] = 'catid';
        $params['column_parentid'] = 'parentcatid';
        $params['where'] = array('deleted' => '0', 'rstatus' => STATUS_ENABLED);
        $params['getvalues'] = array('id' => 'catid', 'name');
    
        QCore_Bl_GlobalFuncs::getParents($parentsData, $params);

        $this->temporaryAssign('a_parents_data', $parentsData);
        
        // get tree content
        $treeData = array();
        $params = array();
        $params['rootID'] = ($prootid != '' ? $prootid : '');
        $params['tab'] = '';
        $params['tabLevel'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $params['level'] = 1;
        $params['maxLevel'] = 20;
        $params['table_name'] = 'wd_g_categories';
        $params['column_id'] = 'catid';
        $params['column_parentid'] = 'parentcatid';
        $params['getvalues'] = array('catid', 'name', 'parentcatid');
        $params['where'] = array('deleted' => '0', 'rstatus' => STATUS_ENABLED);
        $params['order'] = array('name');

        QCore_Bl_GlobalFuncs::getTree($treeData, $params);

        $evaluateTreeNodes = $this->getNumberOfCampaignsInTreeNode($treeData);
        $this->temporaryAssign('a_evaluatedNodes', $evaluateTreeNodes);

        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($treeData);
        $this->temporaryAssign('a_list_data', $list_data);
        $this->temporaryAssign('a_treeData_count', (is_array($treeData) ? count($treeData) : 0));

        if($prootid != '')
        {
            $rootData = $this->blCategories->getCategoryAsArray($prootid);
            $this->temporaryAssign('a_root_data', $rootData);
        }

        $content = $this->temporaryFetch('categories_tree');
        $this->assign('a_category_tree_content', $content);
/*
        $catIDsSQL = '';
        if($prootid != '') $catIDsSQL = '\''.$prootid.'\',';
        if(is_array($treeData) && count($treeData) > 0)
            foreach($treeData as $node)
                $catIDsSQL .= '\''.$node['catid'].'\',';

        $catIDsSQL = substr($catIDsSQL, 0, -1);
*/
        $sql = 'select distinct c.* from wd_pa_campaigns c, wd_pa_campcat2 cc2 '.
               'where c.deleted=0'.
               '  and c.campaignid=cc2.campaignid';
//        if($catIDsSQL != '') $sql .= '  and cc2.catid in ('.$catIDsSQL.')';
        if($prootid != '') $sql .= ' and cc2.catid='._q($prootid);
        else $sql .= ' and cc2.catid is null';
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
               && ($affcamps[$rs->fields['campaignid']] == '' || $affcamps[$rs->fields['campaignid']] == AFFSTATUS_APPROVED))
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

        $this->addContent('cm_browser');
    }
    
    //--------------------------------------------------------------------------
    
    function getNumberOfCampaignsInTreeNode($treeData)
    {
        if(!is_array($treeData) || count($treeData) < 1) return false;
    
        $GLOBALS['uasort_by'] = 'level';
        $GLOBALS['uasort_order'] = 'desc';

        uasort($treeData, 'cmp_sort');

        $evaluateNodes = array();
        foreach($treeData as $node)
        {
            $sql = 'select count(cc2.campaignid) as camps '.
                   'from wd_pa_campcat2 cc2 '.
                   'where cc2.catid='._q($node['catid']);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs) {
                $this->addErrorMessage(L_G_DBERROR);
                return false;
            }

            $evaluateNodes[$node['catid']] = (int)$evaluateNodes[$node['catid']] + (int)$rs->fields['camps'];
            if($node['parentcatid'] != '')
                $evaluateNodes[$node['parentcatid']] = (int)$evaluateNodes[$node['parentcatid']] + (int)$evaluateNodes[$node['catid']];
        }
        
        return $evaluateNodes;
    }
}
?>
