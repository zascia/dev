<?php 
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
// E-Gold callback script
//============================================================================

// include files
require_once('global.php');

DebugMsg("E-Gold callback: started, params USER1='".$_REQUEST['USER1']."',PRODUCTID='".$_REQUEST['PRODUCTID']."', PAYEE_ACCOUNT='".$_REQUEST['PAYEE_ACCOUNT']."', PAYMENT_ID='".$_REQUEST['PAYMENT_ID']."', PAYMENT_AMOUNT='".$_REQUEST['PAYMENT_AMOUNT']."', PAYMENT_UNITS='".$_REQUEST['PAYMENT_UNITS']."', PAYMENT_METAL_ID='".$_REQUEST['PAYMENT_METAL_ID']."', PAYMENT_BATCH_NUM='".$_REQUEST['PAYMENT_BATCH_NUM']."', PAYER_ACCOUNT='".$_REQUEST['PAYER_ACCOUNT']."'", __FILE__, __LINE__);

if(!isset($_REQUEST['USER1']) || $_REQUEST['USER1'] == '')
{
    DebugMsg("E-Gold callback: no affiliate parameter given, customer was not referred by any affiliate, or error in passed parameters", __FILE__, __LINE__);
    return; // no affiliate parameter given, customer was not referred by any affilliate
}

$ABid = preg_replace('/[\'\"\ ]/', '', $_REQUEST['USER1']);
$TotalCost = preg_replace('/[^0-9\.]/', '', $_REQUEST['PAYMENT_AMOUNT']);
$OrderID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['PAYMENT_ID']);
if(isset($_REQUEST['PRODUCTID'])){$ProductID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['PRODUCTID']);} else {$ProductID = '';}

$saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');

// register sale
DebugMsg("E-Gold callback: Start registering sale, params TotalCost='".$TotalCost."', OrderID='".$OrderID."', ProductID='".$ProductID."'", __FILE__, __LINE__);

if($saleReg->decodeData($ABid))
    $saleReg->registerSale($TotalCost, $OrderID, $ProductID, true);
else
    DebugMsg("E-Gold callback: Data not decoded, failed to save sale", __FILE__, __LINE__);

DebugMsg("E-Gold callback: End registering sale", __FILE__, __LINE__);
header("HTTP/1.1 200 OK");
?>

