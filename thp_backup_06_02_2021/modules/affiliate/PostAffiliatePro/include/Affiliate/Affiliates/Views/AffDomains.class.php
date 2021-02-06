<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Affiliates_Views_AffDomains extends QUnit_UI_TemplatePage
{
    var $class_name = 'Affiliate_Affiliates_Views_AffDomains';
    var $blSettings;
    var $blDomains;
    
    function Affiliate_Affiliates_Views_AffDomains()
    {
        $this->blDomains =& QUnit_Global::newObj('QCore_Sql_Table_Domains');
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_DOMAINS,'index.php?md=Affiliate_Affiliates_Views_AffDomains');
    }
    
    function process()
    {
        if(!empty($_POST['postaction']))
        {
            switch($_POST['postaction'])
            {              
                case 'insert':
                    if($this->processInsertDomain())
                        return;
                    break;

                case 'update':
                    if($this->processUpdateDomain())
                        return;
                    break;
            }
        }

        $panel_settings = QUnit_Global::newObj('Affiliate_Affiliates_Views_AffPanelSettings');
        $this->assign('a_description', L_G_DOMAINS_DESCRIPTION);
        $this->assign('a_panel_settings', $panel_settings->loadPanelSettings('affdomains'));
        $this->addContent('section_descriptions');
        
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'add_new':
                    if($this->drawFormAddDomain())
                        return;
                    break;

                case 'edit':
                    if($this->drawFormEditDomain())
                        return;
                    break;

                case 'delete':
                    if($this->processDeleteDomain())
                        return;
                    break;
            }
        }
            
        $this->showDomains();
    }
    
    //------------------------------------------------------------------------
    
    function processDeleteDomain()
    {
        $DomainID = preg_replace('/[\'\"]/', '', $_REQUEST['did']);

        $this->blDomains->setColumn('domainid', $DomainID);
        $this->blDomains->setColumn('accountid', $GLOBALS['Auth']->getAccountID());
        $this->blDomains->setColumn('userid', $GLOBALS['Auth']->getUserID());
        $ret = $this->blDomains->delete();
        
        if($ret == false) return false;
    }
    
    //------------------------------------------------------------------------
    
    function processInsertDomain()
    {
        $purl = preg_replace('/[\'\"]/', '', $_POST['url']);
    
        checkCorrectness($_POST['url'], $purl, L_G_URL, CHECK_EMPTYALLOWED);
    
        if(QUnit_Messager::getErrorMessage() != '')
            return false;
        
        $this->blDomains->setColumn('accountid', $GLOBALS['Auth']->getAccountID());
        $this->blDomains->setColumn('userid', $GLOBALS['Auth']->getUserID());
        $this->blDomains->setColumn('rtype', DOMAIN_USERS);
        $this->blDomains->setColumn('url', $purl);
        if($GLOBALS['Auth']->getSettings('approve_domain_type') == APPROVE_AUTOMATIC)
            $this->blDomains->setColumn('rstatus', AFFSTATUS_APPROVED);
        else
            $this->blDomains->setColumn('rstatus', AFFSTATUS_NOTAPPROVED);
        
        $this->blDomains->setColumnWithDate('dateinserted');
        $this->blDomains->setUniqueId('domainid');
        $ret = $this->blDomains->insert();
        
        if($ret == false) return false;

        $this->addOkMessage(L_G_DOMAINADDED);

        if($_POST['show_no_popup'] == '1')
        {
            $this->showDomains();
            return true;
        }

        $this->closeWindow('Affiliate_Affiliates_Views_AffDomains');
        $this->addContent('closewindow');

        return true;
    }
  
    //------------------------------------------------------------------------

    function processUpdateDomain()
    {
        $DomainID = preg_replace('/[\'\"]/', '', $_POST['did']);
        $purl = preg_replace('/[\'\"]/', '', $_POST['url']);

        checkCorrectness($_POST['url'], $purl, L_G_URL, CHECK_EMPTYALLOWED);
    
        if(QUnit_Messager::getErrorMessage() != '')
            return false;

        $this->blDomains->setColumn('url', $purl);
        $this->blDomains->setColumn('domainid', $DomainID);
        $this->blDomains->setWhereColumn('accountid', $GLOBALS['Auth']->getAccountID());
        $this->blDomains->setWhereColumn('userid', $GLOBALS['Auth']->getUserID());
        $ret = $this->blDomains->update();

        if($ret == false) return false;

        $this->addOkMessage(L_G_DOMAINEDITED);

        if($_POST['show_no_popup'] == '1')
        {
            $this->showDomains();
            return true;
        }

        $this->closeWindow('Affiliate_Affiliates_Views_AffDomains');
        $this->addContent('closewindow');

        return true;
    }

    //------------------------------------------------------------------------
    
    function loadDomainInfo()
    {
        $pdomainid = preg_replace('/[\'\"]/', '', $_REQUEST['did']);
    
        $params = array('domainid' => $pdomainid,
                        'userid' => $GLOBALS['Auth']->getUserID(),
                        'accountid' => $GLOBALS['Auth']->getAccountID()
        );
    
        $rs = $this->blDomains->getDomainRS($params);

        if($rs === false)
        {
            $this->closeWindow('Affiliate_Affiliates_Views_AffDomains');
            $this->addContent('closewindownobutton');
        }
        
        $_POST['did'] = $rs->fields['domainid'];
        $_POST['url'] = $rs->fields['url'];
    }

    //------------------------------------------------------------------------

    function drawFormEditDomain()
    {
        if($_POST['commited'] != 'yes')
        {
            if($this->loadDomainInfo() === false) ;
        }
        
        $pshow_no_popup = preg_replace('/[\'\"]/', '', $_REQUEST['show_no_popup']);
        
        if($pshow_no_popup != '')
            $_POST['show_no_popup'] = $pshow_no_popup;
    
        if($_POST['did'] == '') $_POST['did'] = $_REQUEST['did'];
    
        $_POST['header'] = L_G_EDIT_DOMAIN;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'update';

        $this->drawFormAddDomain();
    
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function drawFormAddDomain()
    {
        if(!isset($_POST['action']))
            $_POST['action'] = 'add_new';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'insert';

        if(!isset($_POST['header']))
            $_POST['header'] = L_G_ADD_DOMAIN;

        $this->addContent('domain_edit');
          
        return true;
    }

    //------------------------------------------------------------------------

    function drawDeclineReason()
    {
        $_POST['header'] = L_G_DOMAIN_DECLINE_REASON;
    
        $params = array('userID' => $GLOBALS['Auth']->getUserID(),
                        'accountid' => $GLOBALS['Auth']->getAccountID(),
                        'domainid' => $_REQUEST['domainid']
                       );

        $data = $this->blDomains->getDeclineReason($params);

        if($data == false) return false;

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS(array($data));
        $this->assign('a_list_data', $list_data);

        $this->addContent('decline_reason_view');

        return true;
    }

    //--------------------------------------------------------------------------
  
    function showDomains()
    {
        $orderby = '';
    
        $a = array('d.domainid', 'd.url', 'd.dateinserted', 'd.username', 'd.rstatus');
        
        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder']; 
        else
            $orderby = ' order by d.url';
  
        $where = ' where d.accountid='._q($GLOBALS['Auth']->getAccountID()).
                 '   and d.userid='._q($GLOBALS['Auth']->getUserID()).
                 '   and d.rtype='._q(DOMAIN_USERS);

        $sql = 'select * from wd_g_domains d '.$where.' '.$orderby;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $this->assign('a_numrows', $rs->PO_RecordCount('wd_g_domains', $where));

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rs);
        $this->assign('a_list_data', $list_data);

        $this->assign('a_no_record', $rs->EOF);

        $this->addContent('domain_list');
    }
}
?>
