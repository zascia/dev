<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');

class Affiliate_Merchants_Views_AffiliateSelect extends QUnit_UI_ListPage
{
    var $blAffiliate;
    var $userType;
    var $customFieldsNo;
    var $rowsPerPage;
    
    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Views_AffiliateSelect() {    
        $this->userType       = USERTYPE_USER;
        $this->customFieldsNo = 2;
        $this->rowsPerPage    = $_REQUEST['numrows'] = 5;
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
    }    

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_REQUEST['commited'])) {
            $this->showUsers();
        } else {
            $this->showFilter();
        }
    }
    
    //--------------------------------------------------------------------------
    
    function showUsers() {
        $orderby = '';
        $where = '';
        $this->createWhereOrderBy($orderby, $where);
        
        $UserData = $this->getRecords($orderby, $where);        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($UserData);
        $this->assign('a_list_data', $list_data);

        $this->pageLimitsAssign();

        $this->assign('a_md', 'Affiliate_Merchants_Views_AffiliateSelect');
        $this->assign('a_numrows', $this->rowsPerPage);
        $this->addContent('affsel_list');

    }
    
    //--------------------------------------------------------------------------
    
    function showFilter() {
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'affsel_') === 0 && !isset($_REQUEST[$k]))
            $_REQUEST[$k] = $v;
        }
        
        $this->assign('a_filterColumns', $this->getAvailableFilterColumns());
        $this->assign('a_customFieldsNo', $this->customFieldsNo);
        $this->addContent('affsel_filter');
    }
    
    //--------------------------------------------------------------------------

    function getAvailableFilterColumns()
    {
        return array(
            'a.refid' =>          L_G_REFID,
            'a.username' =>       L_G_USERNAME,
            //'a.name' =>           L_G_NAME,
            //'a.surname' =>        L_G_SURNAME,
            'a.company_name' =>   L_G_COMPANYNAME,
            'a.weburl' =>         L_G_WEBURL,
            'a.street' =>         L_G_STREET,
            'a.city' =>           L_G_CITY,
            'a.state' =>          L_G_STATE,
            'a.country' =>        L_G_COUNTRY,
            'a.zipcode' =>        L_G_ZIPCODE,
            'a.phone' =>          L_G_PHONE,
            'a.fax' =>            L_G_FAX,
        );
    }
    
    //--------------------------------------------------------------------------

    function createWhereOrderBy(&$orderby, &$where)
    {
        $orderby = '';
        $where = '';

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'affsel_') === 0 && !isset($_REQUEST[$k]))
            $_REQUEST[$k] = $v;
        }

        $orderby = ' order by a.dateinserted desc';
        
        $where = ' where a.deleted=0 '.
                 '   and a.rtype='._q($this->userType).
                 '   and accountid='._q($GLOBALS['Auth']->getAccountID($this->userType));
        
        for ($i = 1; $i <= 2+$this->customFieldsNo; $i++) {
            $_SESSION['affsel_custom'.$i.'data'] = $customData = preg_replace('/[\'\"]/', '', $_REQUEST['affsel_custom'.$i.'data']);
            $_SESSION['affsel_custom'.$i] = $field = $_REQUEST['affsel_custom'.$i];
            
            if ($customData != '') {
                $where .= ' and ('.$field.' like \'%'._q_noendtags($customData).'%\')';
            }
        }
        return true;
    }
    
    //--------------------------------------------------------------------------

    function getRecords($orderby, $where)
    {
        //------------------------------------------------
        // init paging
        $sql = 'select count(*) as count from wd_g_users a';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

        //------------------------------------------------
        // get records
        $sql = 'select a.userid, a.refid, a.username, a.name, a.surname, a.rstatus, '.
               sqlShortDate('a.dateinserted').' as joined from wd_g_users a ';
        $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $this->rowsPerPage, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $UserData = array();

        // prepare the data
        while(!$rs->EOF)
        {
            $UserData[$rs->fields['userid']]['userid'] = $rs->fields['userid'];
            $UserData[$rs->fields['userid']]['refid'] = $rs->fields['refid'];
            $UserData[$rs->fields['userid']]['joined'] = $rs->fields['joined'];
            $UserData[$rs->fields['userid']]['username'] = $rs->fields['username'];
            $UserData[$rs->fields['userid']]['name'] = $rs->fields['name'];
            $UserData[$rs->fields['userid']]['surname'] = $rs->fields['surname'];
            $UserData[$rs->fields['userid']]['rstatus_numeric'] = $rs->fields['rstatus'];
            
            if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $UserData[$rs->fields['userid']]['rstatus'] = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $UserData[$rs->fields['userid']]['rstatus'] = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $UserData[$rs->fields['userid']]['rstatus'] = L_G_SUPPRESSED;
            
            $rs->MoveNext();      
        }
        
        return $UserData;
    }

}

?>
