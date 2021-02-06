<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
// WorldPay callback script
//============================================================================

$data = explode('_', $_POST['M_aid'], 3);
$_REQUEST['lid'] = $data[2];
$_POST['M_aid'] = $data[0]."_".$data[1];

// include files
require_once('global.php');

if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_PRO || $GLOBALS['Auth']->getProgramType() == PROG_TYPE_ECOMMAGNET) {
    $GLOBALS['Auth']->setAccountID(DEFAULT_ACCOUNT);
} else {
    if($GLOBALS['Auth']->getAccountID() == '') {
        QCore_History::log(WLOG_ERROR, "WorldPay callback: Cannot recognize account from domain '".getHostName()."'", __FILE__, __LINE__);
        return;
    }
}

DebugMsg("WorldPay callback: started, params transStatus='".$_REQUEST['transStatus']."', M_aid='".$_REQUEST['M_aid']."', M_ProductID='".$_REQUEST['M_ProductID']."'", __FILE__, __LINE__);
    
if($_REQUEST['transStatus'] != 'Y')
{
    $errorMsg = "WorldPay callback: transaction was cancelled";
    LogError($errorMsg, __FILE__, __LINE__);    
    return; // transaction was cancelled
}
    
if($_REQUEST['M_aid'] == '')
{
    DebugMsg("WorldPay callback: no affiliate parameter given, customer was not referred by any affiliate, or error in passed parameters", __FILE__, __LINE__);
    return; // no affiliate parameter given, customer was not referred by any affilliate
}

$ABid = preg_replace('/[\'\"\ ]/', '', $_REQUEST['M_aid']);
$TotalCost = preg_replace('/[^0-9\.]/', '', $_REQUEST['amount']);
$OrderID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['transId']);
$ProductID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['M_ProductID']);

$saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');

// register sale
DebugMsg("WorldPay callback: Start registering sale, params TotalCost='".$TotalCost."', OrderID='".$OrderID."', ProductID=''", __FILE__, __LINE__);
                
if($saleReg->decodeData($ABid))
    $saleReg->registerSale($TotalCost, $OrderID, $ProductID, true);
else
    DebugMsg("WorldPay callback: Data not decoded, failed to save sale", __FILE__, __LINE__);

DebugMsg("WorldPay callback: End registering sale", __FILE__, __LINE__);
?>