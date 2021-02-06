<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QUnit_UI_ResourcesPage');

class Affiliate_Affiliates_Views_Resources extends QUnit_UI_ResourcesPage
{
    //------------------------------------------------------------------------
    
    function Affiliate_Affiliates_Views_Resources() {
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_RESOURCES,'index_res.php');
    }
    
    //------------------------------------------------------------------------
    
    function process()
    {
        $this->drawPage();
    }

    //------------------------------------------------------------------------

    function drawPage()
    {
        $this->assign('a_content', $this->getContent());

        $this->addContent('resource_page');

        return true;
    }
    
    //------------------------------------------------------------------------

    function getContent()
    {
        if($_REQUEST['p'] != '') {
            $page = $this->findPage($_REQUEST['p']);
        }
        
        if($page == false) {
            $page = $this->findPage($GLOBALS['defaultResourcesPage']);
        }

        $page = $this->fillAffiliateInfo($page);

        return $page;
    }
    
    //------------------------------------------------------------------------

    function fillAffiliateInfo($page) 
    {
        // get affiliate 
        $sql = 'select * from wd_g_users where deleted=0 and userid='._q($GLOBALS['Auth']->getUserID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return $page;
        }
        
        if($rs->EOF) {
            return $page;
        }
        
        $Affiliate_id = $rs->fields['userid'];
        $Affiliate_name = $rs->fields['name'].' '.$rs->fields['surname'];
        $Affiliate_firstname = $rs->fields['name'];
        $Affiliate_lastname = $rs->fields['surname'];
        $Affiliate_username = $rs->fields['username'];
        $Affiliate_password = $params['pwd'];
        
        if(!defined('L_G_APPROVED')) {
            // try to load language file
            setLanguage();
        }
        if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $Affiliate_status = L_G_APPROVED;
        else if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $Affiliate_status = L_G_WAITINGAPPROVAL;
        else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $Affiliate_status = L_G_SUPPRESSED;

        $page = str_replace('$Date', date("Y-m-d"), $page);
        $page = str_replace('$Time', date("h:i:s"), $page);
        $page = str_replace('$Affiliate_id', $rs->fields['userid'], $page);
        $page = str_replace('$Affiliate_refid', ($rs->fields['refid'] != '' ? $rs->fields['refid'] : $rs->fields['userid']), $page);
        $page = str_replace('$Affiliate_name', $rs->fields['name'].' '.$rs->fields['surname'], $page);
        $page = str_replace('$Affiliate_firstname', $rs->fields['name'], $page);
        $page = str_replace('$Affiliate_lastname', $rs->fields['surname'], $page);
        $page = str_replace('$Affiliate_username', $rs->fields['username'], $page);

        $page = str_replace('$Affiliate_password', $rs->fields['rpassword'], $page);
        $page = str_replace('$Affiliate_company', $rs->fields['company_name'], $page);
        $page = str_replace('$Affiliate_weburl', $rs->fields['weburl'], $page);
        $page = str_replace('$Affiliate_street', $rs->fields['street'], $page);
        $page = str_replace('$Affiliate_city', $rs->fields['city'], $page);
        $page = str_replace('$Affiliate_state', $rs->fields['state'], $page);
        $page = str_replace('$Affiliate_country', $rs->fields['country'], $page);
        $page = str_replace('$Affiliate_zipcode', $rs->fields['zipcode'], $page);
        $page = str_replace('$Affiliate_phone', $rs->fields['phone'], $page);
        $page = str_replace('$Affiliate_fax', $rs->fields['fax'], $page);
        $page = str_replace('$Affiliate_taxssn', $rs->fields['taxssn'], $page);
        
        return $page;
    }
}
?>
