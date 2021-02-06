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

$TotalCost = preg_replace('/[^0-9\.\,]/', '', $_REQUEST['TotalCost']);
$TotalCost = str_replace(',', '.', $TotalCost);
$OrderID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['OrderID']);
$ProductID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['ProductID']);
$Data1 = preg_replace('/[\'\"]/', '', $_REQUEST[PARAM_DATA1]);
$Data2 = preg_replace('/[\'\"]/', '', $_REQUEST[PARAM_DATA2]);
$Data3 = preg_replace('/[\'\"]/', '', $_REQUEST[PARAM_DATA3]);
$aid   = preg_replace('/[\'\"]/', '', $_REQUEST[
]);

QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleRegistrator');
$saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');

$saleReg->setAccountID();

$debug_sales = $GLOBALS['Auth']->getSettingForScripts('Aff_debug_sales');
QCore_History::logWithCondition($debug_sales == 1, WLOG_DEBUG, "Sale registration: Start registering sale, params: ".getParams($_REQUEST), __FILE__, __LINE__);

$saleReg->setP3PPolicy();

$saleReg->setExtraData($Data1, $Data2, $Data3);

// register sale
if($saleReg->decodeData($_REQUEST['c'], $aid)) {
    $saleReg->registerSale($TotalCost, $OrderID, $ProductID);
} else {
    QCore_History::logWithCondition($debug_sales == 1, WLOG_DEBUG, "Sale registration: Data not decoded, failed to save sale", __FILE__, __LINE__);
}

QCore_History::logWithCondition($debug_sales == 1, WLOG_DEBUG, "Sale registration: End registering sale", __FILE__, __LINE__);
?>
