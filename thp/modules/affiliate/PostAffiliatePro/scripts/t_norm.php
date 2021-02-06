<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('global.php');

QUnit_Global::includeClass('Affiliate_Scripts_Bl_ClickRegistrator');

if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_PRO || $GLOBALS['Auth']->getProgramType() == PROG_TYPE_ECOMMAGNET) {
    $GLOBALS['Auth']->setAccountID(DEFAULT_ACCOUNT);
} else {
    if($GLOBALS['Auth']->getAccountID() == '') {
        QCore_History::log(WLOG_ERROR, "Click registration: Cannot recognize account from domain '".getHostName()."'", __FILE__, __LINE__);
        return;
    }
}

QCore_History::logWithCondition($GLOBALS['Auth']->getSettingForScripts('Aff_debug_clicks') == 1, WLOG_DEBUG, "Click registration: Start registering click, params: ".getParams($_REQUEST), __FILE__, __LINE__);

// check if it has correct parameters
if(!isset($_REQUEST[PARAM_A_AID]) || $_REQUEST[PARAM_A_AID] == '') {
    QCore_History::logWithCondition($GLOBALS['Auth']->getSettingForScripts('Aff_debug_clicks') == 1, WLOG_DEBUG, "Click registration: Missing Affiliate ID when calling click registration", __FILE__, __LINE__);
    return;
}

$params = array();
$params['affiliateID'] = preg_replace('/[\'\"]/', '', $_REQUEST[PARAM_A_AID]);
$params['bannerID'] = preg_replace('/[\'\"]/', '', $_REQUEST[PARAM_A_BID]);
$params['subBannerID'] = preg_replace('/[\'\"]/', '', $_REQUEST['a_sbid']);
$params['data1'] = preg_replace('/[\'\"]/', '', $_REQUEST[PARAM_DATA1]);
$params['data2'] = preg_replace('/[\'\"]/', '', $_REQUEST[PARAM_DATA2]);
$params['data3'] = preg_replace('/[\'\"]/', '', $_REQUEST[PARAM_DATA3]);
$params['destUrl'] = preg_replace('/[\'\"]/', '', $_REQUEST[PARAM_DESTURL]);
$params['referrer'] = '';
$params['dontRedirect'] = false;

$browserIdentification = $_SERVER['HTTP_USER_AGENT'].$_SERVER['HTTP_ACCEPT_LANGUAGE'].$_SERVER['HTTP_ACCEPT'];
$params['browserHash'] = substr(md5($browserIdentification), 0, 6);

$clickReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_ClickRegistrator');

$clickReg->process($params);
?>
