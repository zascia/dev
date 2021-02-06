<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_AppliedAffiliate extends QUnit_UI_TemplatePage
{
    var $blAffiliate;
    
    function Affiliate_Merchants_Views_AppliedAffiliate() {
        $this->blAffiliate = QUnit_Global::newObj('Affiliate_Affiliates_Bl_Affiliate');
    }
    
    //--------------------------------------------------------------------------
    
    function initPermissions()
    {
        $this->modulePermissions['approve'] = 'aff_aff_appliedaffiliates_approvedecline';
        $this->modulePermissions['decline'] = 'aff_aff_appliedaffiliates_approvedecline';
        $this->modulePermissions['delete']  = 'aff_aff_appliedaffiliates_modify';
        $this->modulePermissions['view']    = 'aff_aff_appliedaffiliates_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_APPLIEDAFFILIATES,'index.php?md=Affiliate_Merchants_Views_AppliedAffiliate');

        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'edit_reason':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED, unserialize(str_replace('\\','', $_POST['itemschecked']))))
                        return;
                break;
            }

            switch($_POST['massaction'])
            {
                case 'suppress':
                    $this->navigationAddURL(L_G_DECLINE, '');
                    if($this->processChangeStateCheck(AFFSTATUS_SUPPRESSED))
                        return;
                break;

                case 'approve':
                    if($this->processChangeStateCheck(AFFSTATUS_APPROVED))
                        return;
                break;

                case 'pending':
                    if($this->processChangeStateCheck(AFFSTATUS_NOTAPPROVED))
                        return;
                break;

                case 'delete':
                    if($this->processDelete())
                        return;
                break;
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'suppress':
                    $this->navigationAddURL(L_G_DECLINE, '');
                    if($this->processChangeStateCheck(AFFSTATUS_SUPPRESSED))
                        return;
                break;

                case 'approve':
                    if($this->processChangeStateCheck(AFFSTATUS_APPROVED))
                        return;
                break;

                case 'pending':
                    if($this->processChangeStateCheck(AFFSTATUS_NOTAPPROVED))
                        return;
                break;

                case 'delete':
                    if($this->processDelete())
                        return;
                break;
                
                case 'add_aff':
                    $this->processAddAffiliateToCampaign();
                break;
            }
        }

        $this->showAffiliateCampaigns();
    }

    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================

    function processChangeStateCheck($state)
    {
        if(($affCampIDs = $this->returnACIDs()) == false)
            return false;

        if($state == AFFSTATUS_SUPPRESSED)
        {
            $_POST['header'] = L_G_EDIT_DECLINE_REASON;
            $_POST['action'] = '';
            $_POST['postaction'] = 'edit_reason';
            $_POST['itemschecked'] = serialize($affCampIDs);

            $this->assign('a_md', 'Affiliate_Merchants_Views_AppliedAffiliate');
            $this->addContent('decline_reason_edit');

            return true;
        }

        $this->processChangeState($state, $affCampIDs);
    }

    //--------------------------------------------------------------------------

    function processDelete()
    {
        if(($affCampIDs = $this->returnACIDs()) == false)
            return false;

        $params = array();
        $params['affCampIDs'] = $affCampIDs;
        $params['AccountID'] = $GLOBALS['Auth']->getAccountID();
        $params['settings'] = $GLOBALS['Auth']->getSettings();

        $objCampaigns =& QUnit_Global::newObj('Affiliate_Merchants_Bl_AffiliateCampaigns');
        $objCampaigns->delete($params);

        return false;

        $this->processChangeState($state, $affCampIDs);
    }

    //--------------------------------------------------------------------------

    function processChangeState($state, $affCampIDs)
    {
        $params = array();
        $params['affCampIDs'] = $affCampIDs;
        $params['state'] = $state;
        $params['AccountID'] = $GLOBALS['Auth']->getAccountID();
        $params['decline_reason'] = $_POST['decline_reason'];
        $params['round_numbers'] = $GLOBALS['Auth']->getSetting('Aff_round_numbers');
        $params['settings'] = $GLOBALS['Auth']->getSettings();

        $objCampaigns =& QUnit_Global::newObj('Affiliate_Merchants_Bl_AffiliateCampaigns');
        $objCampaigns->changeState($params);

        return false;
    }

    //--------------------------------------------------------------------------

    function returnACIDs()
    {
        if($_POST['massaction'] != '')
        {
            $affCampIDs = $_POST['itemschecked'];
        }
        else
        {
            $affCampIDs = array($_REQUEST['acid']);
        }

        if(!is_array($affCampIDs) || count($affCampIDs) < 1 ) return false;

        return $affCampIDs;
    }

    //==========================================================================
    // FORMS FUNCTIONS
    //==========================================================================

    function showAffiliateCampaigns()
    {
        $this->assign('a_form_preffix', 'aa_');
        $this->assign('a_form_name', 'FilterForm');

        $viewCampManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
        $campaigns = $viewCampManager->getCampaignsAsArray();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($campaigns);
        $this->assign('a_list_campaigns', $list_data);

        $blAffiliate = QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $usersRs = $blAffiliate->getUsersAsRs();
        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($usersRs);
        $this->assign('a_list_users', $list_data);

        $orderby = '';

        $a = array('a.userid', 'a.name', 'a.surname', 'camp_name', 'campstatus',
                   'c.dateinserted', 'ac.rstatus', 'affstatus', 'c.commtype');

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
        else
            $orderby = ' order by a.username';

        $where = ' where a.accountid='._q($GLOBALS['Auth']->getAccountID()).
                 '   and a.userid=ac.affiliateid'.
                 '   and ac.campaignid=c.campaignid';

        $params = array('where' => $where);

        $objCampaigns =& QUnit_Global::newObj('Affiliate_Merchants_Bl_AffiliateCampaigns');
        $camp_cats = $objCampaigns->getCampCats($params);

        if($camp_cats === false) return false;

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strstr($k, 'aa_status') !== false && ($_REQUEST['status_comitted'] == '1'))
                continue;
            if(strstr($k, 'aa_affstatus') !== false && ($_REQUEST['affstatus_comitted'] == '1'))
                continue;
            if(strstr($k, 'aa_campstatus') !== false && ($_REQUEST['campstatus_comitted'] == '1'))
                continue;
            if(strpos($k, 'aa_') === 0 && !isset($_REQUEST[$k]))
                $_REQUEST[$k] = $v;
        }

        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['aa_status'] == '' && $_REQUEST['status_comitted'] != '1') $_REQUEST['aa_status'] = array(AFFSTATUS_APPROVED, AFFSTATUS_NOTAPPROVED, AFFSTATUS_SUPPRESSED);
        if($_REQUEST['aa_affstatus'] == '' && $_REQUEST['affstatus_comitted'] != '1') $_REQUEST['aa_affstatus'] = array(AFFSTATUS_APPROVED, AFFSTATUS_NOTAPPROVED, AFFSTATUS_SUPPRESSED);
        if($_REQUEST['aa_campstatus'] == '' && $_REQUEST['campstatus_comitted'] != '1') $_REQUEST['aa_campstatus'] = array(AFF_CAMP_PUBLIC, AFF_CAMP_PRIVATE);
        if($_REQUEST['aa_campaign'] == '') $_REQUEST['aa_campaign'] = '_';

        //--------------------------------------
        // put settings into session
        $_SESSION['aa_campaign'] = $_REQUEST['aa_campaign'];
        $_SESSION['aa_status'] = $_REQUEST['aa_status'];
        $_SESSION['aa_affstatus'] = $_REQUEST['aa_affstatus'];
        $_SESSION['aa_campstatus'] = $_REQUEST['aa_campstatus'];
        $_SESSION['aa_advanced_filter_show'] = $_REQUEST['aa_advanced_filter_show'];

        if($_REQUEST['aa_campaign'] != '_')
            $where .= ' and c.campaignid='._q($_REQUEST['aa_campaign']);

        if($_REQUEST['aa_userid'] != '_' && $_REQUEST['aa_userid'] != '')
            $where .= ' and ac.affiliateid='._q($_REQUEST['aa_userid']);
        if ($_REQUEST['aa_advanced_filter_show'] == '1') {
            if($_REQUEST['aa_status'] != '_') {
               $status = ($_REQUEST['aa_status'] == '') ? array() : $_REQUEST['aa_status'];
                if (count($status) > 0) {
                    $where .= ' and ac.rstatus in ('.implode(',', $status).')';
                } else {
                    $where .= ' and 1=0';
                }
            }
            if($_REQUEST['aa_affstatus'] != '_') {
               $affstatus = ($_REQUEST['aa_affstatus'] == '') ? array() : $_REQUEST['aa_affstatus'];
                if (count($affstatus) > 0) {
                    $where .= ' and a.rstatus in ('.implode(',', $affstatus).')';
                } else {
                    $where .= ' and 1=0';
                }
            }
            if($_REQUEST['aa_campstatus'] != '_') {
               $campstatus = ($_REQUEST['aa_campstatus'] == '') ? array() : $_REQUEST['aa_campstatus'];
                if (count($campstatus) > 0) {
                    $where .= ' and s.value in ('.implode(',', $campstatus).')';
                } else {
                    $where .= ' and 1=0';
                }
            }
        }

        $sql = 'select count(distinct(ac.affcampid)) as count '.
               'from wd_g_users a, wd_pa_campaigns c '.
               'left join wd_g_settings s on s.id1=c.campaignid and s.code='._q('Aff_camp_status').', '.
               'wd_pa_affiliatescampaigns ac';
        $rs = QCore_Sql_DBUnit::execute($sql.' '.$where, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        $limitOffset = initPaging($rs->fields['count']);

        $sql = 'select distinct(ac.affcampid), a.userid, a.name, a.surname, a.rstatus as affstatus, c.campaignid, c.name as camp_name '.
               '      ,c.dateinserted, c.commtype, ac.rstatus, ac.affcampid, s.value as campstatus '.
               'from wd_g_users a, wd_pa_campaigns c '.
               'left join wd_g_settings s on s.id1=c.campaignid and s.code='._q('Aff_camp_status').', '.
               'wd_pa_affiliatescampaigns ac';

        $rs = QCore_Sql_DBUnit::selectLimit($sql.' '.$where.' '.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($camp_cats);

        $this->assign('a_list_data', $list_data);

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rs);

        $this->assign('a_list_data', $list_data);
        $this->assign('a_numrows', $rs->PO_RecordCount('wd_g_users a, wd_pa_campaigns c, wd_pa_affiliatescampaigns ac', $where));

        $this->pageLimitsAssign();

        $this->addContent('appl_aff_show');
    }

    //--------------------------------------------------------------------------
    
    function processAddAffiliateToCampaign() {
        $campaignId = preg_replace('/[\"\']/', '', $_POST['aa_campaign']);
        $affiliateId = preg_replace('/[\"\']/', '', $_POST['aa_userid']);
        
        if($campaignId == '_') {
            QUnit_Messager::setErrorMessage(L_G_YOUHAVETOSELECTCAMPAIGN);
            return false; 
        }
        
        if($affiliateId == '_' || $affiliateId == '') {
            QUnit_Messager::setErrorMessage(L_G_YOUHAVETOSELECTAFFILIATE);
            return false;
        }
        
        $params = array('userID' => $affiliateId,
                        'CampaignID' => $campaignId,
                        'status' => AFFSTATUS_APPROVED
                       );

        if (!$this->blAffiliate->isUserInCampaign($params)) {
            $ret = $this->blAffiliate->insertAffCamp($params);
            if($ret == false) return false;
        }
                
        $this->addOkMessage(L_G_AFFILIATEADDEDTOCAMPAIGN);
        
        return true;
    }

}
?>
