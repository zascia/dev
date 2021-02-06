<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
// StormPay callback script
//============================================================================

$data = explode('_', $_POST['user1'], 3);
$_REQUEST['lid'] = $data[2];
$_POST['user1'] = $data[0]."_".$data[1];

// include files
require_once('global.php');

if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_PRO || $GLOBALS['Auth']->getProgramType() == PROG_TYPE_ECOMMAGNET) {
    $GLOBALS['Auth']->setAccountID(DEFAULT_ACCOUNT);
} else {
    if($GLOBALS['Auth']->getAccountID() == '') {
        QCore_History::log(WLOG_ERROR, "StormPay callback: Cannot recognize account from domain '".getHostName()."'", __FILE__, __LINE__);
        return;
    }
}

DebugMsg("StormPay callback: started, params status='".$_REQUEST['status']."', user1='".$_REQUEST['user1']."', amount='".$_REQUEST['amount']."', transaction_id='".$_REQUEST['transaction_id']."', transaction_ref='".$_REQUEST['transaction_ref']."'", __FILE__, __LINE__);
    
if($_REQUEST['status'] != 'SUCCESS')
{
    $errorMsg = "StormPay callback: transaction was not in SUCCESS state";
    LogError($errorMsg, __FILE__, __LINE__);    
    return; // transaction was cancelled
}
    
if($_REQUEST['user1'] == '')
{
    DebugMsg("StormPay callback: no affiliate parameter given, customer was not referred by any affiliate, or error in passed parameters", __FILE__, __LINE__);
    return; // no affiliate parameter given, customer was not referred by any affilliate
}

$ABid = preg_replace('/[\'\"\ ]/', '', $_REQUEST['user1']);
$TotalCost = preg_replace('/[^0-9\.]/', '', $_REQUEST['amount']);
$OrderID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['transaction_id']);
$ProductID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['transaction_ref']);

$saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');

// register sale
DebugMsg("StormPay callback: Start registering sale, params TotalCost='".$TotalCost."', OrderID='".$OrderID."', ProductID='".$ProductID."'", __FILE__, __LINE__);
                
if($saleReg->decodeData($ABid))
    $saleReg->registerSale($TotalCost, $OrderID, $ProductID, true);
else
    DebugMsg("StormPay callback: Data not decoded, failed to save sale", __FILE__, __LINE__);

DebugMsg("StormPay callback: End registering sale", __FILE__, __LINE__);
header("HTTP/1.1 202 Accepted");
?>