<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_AffiliateDomains extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
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
                    if($this->processChangeStateCheck(AFFSTATUS_SUPPRESSED))
                        return;
                break;

                case 'approve':
                    if($this->processChangeStateCheck(AFFSTATUS_APPROVED))
                        return;
                break;
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'suppress':
                    if($this->processChangeStateCheck(AFFSTATUS_SUPPRESSED))
                        return;
                break;

                case 'approve':
                    if($this->processChangeStateCheck(AFFSTATUS_APPROVED))
                        return;
                break;
            }
        }
    
        $this->showAffiliateDomains();
    }

    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================

    function processChangeStateCheck($state)
    {
        if(($affDomainIDs = $this->returnDIDs()) == false)
            return false;

        if($state == AFFSTATUS_SUPPRESSED)
        {
            $_POST['header'] = L_G_EDIT_DECLINE_REASON;
            $_POST['action'] = '';
            $_POST['postaction'] = 'edit_reason';
            $_POST['itemschecked'] = serialize($affDomainIDs);

            $this->assign('a_md', 'Affiliate_Merchants_Views_AffiliateDomains');
            $this->addContent('decline_reason_edit');
            
            return true;
        }

        $this->processChangeState($state, $affDomainIDs);
    }

    //--------------------------------------------------------------------------

    function processChangeState($state, $affDomainIDs)
    {
        $params = array();
        $params['affDomainIDs'] = $affDomainIDs;
        $params['state'] = $state;
        $params['AccountID'] = $GLOBALS['Auth']->getAccountID();
        $params['decline_reason'] = $_POST['decline_reason'];
        $params['round_numbers'] = $GLOBALS['Auth']->getSetting('Aff_round_numbers');
        $params['settings'] = $GLOBALS['Auth']->getSettings();

        $objDomains =& QUnit_Global::newObj('QCore_Sql_Table_Domains');
        $objDomains->changeState($params);

        return false;
    }

    //--------------------------------------------------------------------------

    function returnDIDs()
    {
        if($_POST['massaction'] != '')
        {
            $affDomainIDs = $_POST['itemschecked'];
        }
        else
        {
            $affDomainIDs = array($_REQUEST['did']);
        }
        
        if(!is_array($affDomainIDs) || count($affDomainIDs) < 1 ) return false;
        
        return $affDomainIDs;
    }

    //==========================================================================
    // FORMS FUNCTIONS
    //==========================================================================

    function showAffiliateDomains()
    {
        $orderby = '';

        $a = array('a.userid', 'a.name', 'a.surname', 'd.url',
                   'd.dateinserted', 'd.rstatus');

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder']; 
        else
            $orderby = ' order by a.username'; 

        $where = ' where a.accountid='._q($GLOBALS['Auth']->getAccountID()).
                 '   and a.accountid=d.accountid'.
                 '   and a.userid=d.userid'.
                 '   and a.rstatus='._q(AFFSTATUS_APPROVED).
                 '   and d.rtype='._q(DOMAIN_USERS);

        $objUsers =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $affiliates = $objUsers->getUsersShortAsArray();

        if($affiliates === false) return false;

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'ad_') === 0 && !isset($_REQUEST[$k]))
                $_REQUEST[$k] = $v;
        }
       
        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['ad_status'] == '') $_REQUEST['ad_status'] = '_';
        if($_REQUEST['ad_affiliate'] == '') $_REQUEST['ad_affiliate'] = '_';
        
        //--------------------------------------
        // put settings into session
        $_SESSION['ad_url'] = $_REQUEST['ad_url'];
        $_SESSION['ad_status'] = $_REQUEST['ad_status'];
        $_SESSION['ad_affiliate'] = $_REQUEST['ad_affiliate'];

        if($_REQUEST['ad_status'] != '' && $_REQUEST['ad_status'] != '_')
            $where .= ' and d.rstatus='._q($_REQUEST['ad_status']);
        if($_REQUEST['ad_affiliate'] != '' && $_REQUEST['ad_affiliate'] != '_')
            $where .= ' and a.userid='._q($_REQUEST['ad_affiliate']);
        if($_REQUEST['ad_url'] != '')
            $where .= ' and d.url like \'%'._q_nonendtags($_REQUEST['ad_url']).'%\'';

        $sql = 'select d.*, a.name, a.surname '.
               'from wd_g_users a, wd_g_domains d';
        $rs = QCore_Sql_DBUnit::execute($sql.' '.$where.' '.$orderby, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($affiliates);

        $this->assign('a_list_data', $list_data);

        $this->addContent('aff_domains_filter');

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rs);

        $this->assign('a_list_data', $list_data);
        $this->assign('a_numrows', $rs->PO_RecordCount('wd_g_users a, wd_g_domains d', $where));

        $this->addContent('aff_domains_show');
    }

    //==========================================================================
    // OTHER FUNCTIONS
    //==========================================================================

}  
?>
