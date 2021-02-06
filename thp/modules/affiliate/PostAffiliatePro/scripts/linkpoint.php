<?php 
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

define('LID_PREFFIX', 's_');

// second call for sale registration, process sale
// include files
require_once('global.php');

$TotalCost = preg_replace('/[^0-9\.\,]/', '', $_POST['chargetotal']);
$TotalCost = str_replace(',', '.', $TotalCost);
$OrderID = preg_replace('/[\'\"\ ]/', '', $_POST['oid']);
$ProductID = preg_replace('/[\'\"\ ]/', '', $_POST['ProductID']);

$data = explode('_', $_POST['custom'], 3);
$_REQUEST['lid'] = $data[2];

$custom = $data[0]."_".$data[1];

QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleRegistrator');
$saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');

$saleReg->setAccountID();

$debug_sales = $GLOBALS['Auth']->getSettingForScripts('Aff_debug_sales');
QCore_History::logWithCondition($debug_sales == 1, WLOG_DEBUG, "Sale registration: Start registering sale, params: ".getParams($_REQUEST), __FILE__, __LINE__);

$saleReg->setP3PPolicy();

$saleReg->setExtraData($Data1, $Data2, $Data3);

// register sale
if($saleReg->decodeData($custom)) {
    $saleReg->registerSale($TotalCost, $OrderID, $ProductID);
} else {
    QCore_History::logWithCondition($debug_sales == 1, WLOG_DEBUG, "Sale registration: Data not decoded, failed to save sale", __FILE__, __LINE__);
}

QCore_History::logWithCondition($debug_sales == 1, WLOG_DEBUG, "Sale registration: End registering sale", __FILE__, __LINE__);
?>
