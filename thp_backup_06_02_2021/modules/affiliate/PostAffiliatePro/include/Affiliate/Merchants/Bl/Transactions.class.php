<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_History');

class Affiliate_Merchants_Bl_Transactions
{
    function Affiliate_Merchants_Bl_Transactions() {
        $this->blRules =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Rules');
        $this->blIpCountry =& QUnit_Global::newObj('QCore_Bl_IpCountry');
    }
    
    //--------------------------------------------------------------------------

    function changeState($params)
    {
        $transIDs = $params['transids'];
        $state = $params['state'];
        if(!is_array($transIDs) || count($transIDs) < 1)
            return false;

        if($state != AFFSTATUS_APPROVED && $state != AFFSTATUS_SUPPRESSED && $state != AFFSTATUS_NOTAPPROVED)
            return false;

        $chunkedTransIDs = my_array_chunk($transIDs, WD_MAX_PROCESSED_IDS);

        foreach($chunkedTransIDs as $transIDsArray)
        {
            $transIDSql = "('".implode("','", $transIDsArray)."')";
            
            $sql = 'update wd_pa_transactions set rstatus='._q($state).
                   ', dateapproved=NOW() '.
                   ' where transid in '.$transIDSql.
                   '   and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            
            // update also possible recurring commissions
            $sql = 'update wd_pa_recurringcommissions set rstatus='.myquotes($state).
                   ' where originaltransid in '.$transIDSql.
                   ' and rstatus='.AFFSTATUS_NOTAPPROVED;
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        // check reward rules
        //if($state != AFFSTATUS_APPROVED)
        //    return true;

        $params = array('AccountID' => $GLOBALS['Auth']->getAccountID());

        if(($rules = $this->blRules->getRulesAsArray($params)) === false) return true;

        $chunkedTransIDs = my_array_chunk($transIDs, WD_MAX_PROCESSED_IDS);

        foreach($chunkedTransIDs as $transIDsArray)
        {
            $trans_users = $this->getUserFromTransaction($transIDsArray);
			
            $params = array('users' => $trans_users,
                            'AccountID' => $GLOBALS['Auth']->getAccountID(),
                            'decimal_places' => $this->settings['Aff_round_numbers']
                           );

            $this->blRules->checkPerformanceRules($params, $rules);
        }

        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function getUserFromTransaction($transIDs)
    {
        if(!is_array($transIDs) || count($transIDs) < 1)
            return false;
           
        $transIDSql = "('".implode("','", $transIDs)."')";
            
        $sql = 'select transid, affiliateid from wd_pa_transactions '.
               'where transid in '.$transIDSql.
               '   and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $trans_users = array();
        
        while(!$rs->EOF)
        {
            $trans_users[$rs->fields['transid']] = $rs->fields['affiliateid'];
            
            $rs->MoveNext();
        }
        
        return $trans_users;
    }
    
    //--------------------------------------------------------------------------

    function delete($params)
    {
        $transIDs = $params['transids'];
        if(!is_array($transIDs) || count($transIDs) < 1)
            return false;

        $chunkedTransIDs = my_array_chunk($transIDs, WD_MAX_PROCESSED_IDS);
        
        foreach($chunkedTransIDs as $transIDsArray)
        {
            $transIDSql = "('".implode("','", $transIDsArray)."')";
            
            $sql = 'delete from wd_pa_transactions'.
                   ' where transid in '.$transIDSql.
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }

            // delete also possible recurring commissions
            $sql = 'update wd_pa_recurringcommissions set deleted=1'.
                   ' where originaltransid in '.$transIDSql.
                   ' and rstatus='.AFFSTATUS_NOTAPPROVED;
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function loadTransactionInfo($params, $preffix = '')
    {
        $transid = preg_replace('/[\'\"]/', '', $_REQUEST['tid']);
        $sql = 'select * from wd_pa_transactions '.
               'where transid='._q($transid).
               '  and accountid='._q($params['AccountID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }

        $_POST[$preffix.'tid'] = $rs->fields['transid'];
        $_POST[$preffix.'rstatus'] = $rs->fields['rstatus'];
        $_POST[$preffix.'transtype'] = $rs->fields['transtype'];
        $_POST[$preffix.'payoutstatus'] = $rs->fields['payoutstatus'];
        $_POST[$preffix.'cookiestatus'] = $rs->fields['cookiestatus'];
        $_POST[$preffix.'orderid'] = $rs->fields['orderid'];
        $_POST[$preffix.'totalcost'] = $rs->fields['totalcost'];
        $_POST[$preffix.'bannerid'] = $rs->fields['bannerid'];
        $_POST[$preffix.'transkind'] = $rs->fields['transkind'];
        $_POST[$preffix.'refererurl'] = $rs->fields['refererurl'];
        $_POST[$preffix.'affiliate'] = $rs->fields['affiliateid'];
        $_POST[$preffix.'campcategoryid'] = $rs->fields['campcategoryid'];
        $_POST[$preffix.'parenttrans'] = $rs->fields['parenttransid'];
        $_POST[$preffix.'commission'] = $rs->fields['commission'];
        $_POST[$preffix.'ip'] = $rs->fields['ip'];
        $_POST[$preffix.'recurringcommid'] = $rs->fields['recurringcommid'];
        $_POST[$preffix.'accountingid'] = $rs->fields['accountingid'];
        $_POST[$preffix.'productid'] = $rs->fields['productid'];
        $_POST[$preffix.'data1'] = $rs->fields['data1'];
        $_POST[$preffix.'data2'] = $rs->fields['data2'];
        $_POST[$preffix.'data3'] = $rs->fields['data3'];
    }
    
    //--------------------------------------------------------------------------
    
    function getTransactionInfo($transid, $params)
    {
        $sql = 'select * from wd_pa_transactions '.
               'where transid='._q($transid).
               '  and accountid='._q($params['AccountID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }

        return $rs->fields;
    }
    
    //--------------------------------------------------------------------------
    
    function getTransactionDetails($transid, $accountID)
    {
        $sql = 'select t.*, u.name, u.surname, u.username from wd_pa_transactions t, wd_g_users u '.
               'where t.transid='._q($transid).
               '  and t.accountid='._q($accountID).
               '  and t.affiliateid=u.userid';
               
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
        
        $data = $rs->fields;
        
        if ( ($data['transtype'] == TRANSTYPE_SALE) || ($data['transtype'] == TRANSTYPE_LEAD)) {
            $details = QCore_Settings::_getSettings(SETTINGTYPE_ACCOUNT, $accountID, '', $transid);
            if ($details['Sale_information'] != '') {
                $details = explode("_", $details['Sale_information'], 6);
                $data['trackingmethod'] = $details[0];
                $data['firstclick'] = $details[1];
                $data['lastclick'] = $details[2];
                $data['clickcount'] = $details[3];
                $data['originalreferrertime'] = $details[4];
                $data['originalreferrer'] = $details[5];
            }
        }
        
        if($GLOBALS['Auth']->getSetting('Glob_acct_geo_allowed') == '1') {
            $countryInfo = $this->blIpCountry->getCountryInfo($data['countrycode']);
            if ($countryInfo['countrycode'] == '__') {
                $data['countryname'] = L_G_UNKNOWN;
            } else {
                $data['countryname'] = $countryInfo['countryname'];
            }
        }

        return $data;
    }
    
    //--------------------------------------------------------------------------
    
    function updateTransaction($params)
    {
        $sql = 'update wd_pa_transactions '.
               'set rstatus='._q($params['rstatus']).
               '   ,transtype='._q($params['transtype']).
               '   ,transkind='._q($params['transkind']).
               '   ,payoutstatus='._q($params['payoutstatus']).
               '   ,totalcost='._q($params['totalcost']).
               '   ,refererurl='._q($params['refererurl']).
               '   ,affiliateid='._q($params['affiliate']).
               '   ,parenttransid='._q($params['parenttrans']).
               '   ,commission='._q($params['commission']).
               '   ,ip='._q($params['ip']).
               '   ,productid='._q($params['productid']).
               '   ,data1='._q($params['data1']).
               '   ,data2='._q($params['data2']).
               '   ,data3='._q($params['data3']).
               ' where transid='._q($params['TransID']);
        if($params['AccountID'] != '') $sql .= ' and accountid='._q($params['AccountID']);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($params['rstatus'] == AFFSTATUS_APPROVED)
        {
            $params = array('users' => array($params['affiliate']),
                            'AccountID' => $params['AccountID'],
                            'decimal_places' => $params['decimal_places']
                           );

            if(($rules = $this->blRules->getRulesAsArray($params)) !== false)
                $this->blRules->checkPerformanceRules($params, $rules);
        }

        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function checkTransactionExists($TransID, $AccountID)
    {
        $sql = 'select transid from wd_pa_transactions '.
               'where transid='._q($TransID).
               '  and accountid='._q($AccountID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        

        if($rs->EOF)
            return true;

        return false;
    }
}
?>
