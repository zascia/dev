<?php
//============================================================================
// Copyright (c) Maros Fric, QualityUnit 2006
// All rights reserved
//
// For support contact support@qualityunit.com
//============================================================================

define('LID_PREFFIX', 's_');

// second call for sale registration, process sale
// include files
require_once('global.php');

$OrderID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['OrderID']);
$ProductID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['ProductID']);

QCore_History::logWithCondition($debug_sales == 1, WLOG_DEBUG, "Sale approve: Start approving sale, params: ".getParams($_REQUEST), __FILE__, __LINE__);

// search transactions if we'll find sale with this order ID
$sql = "update wd_pa_transactions set rstatus="._q(AFFSTATUS_APPROVED)." where orderid="._q($OrderID)." and rstatus <> "._q(AFFSTATUS_SUPPRESSED);

$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
if(!$ret) {
    $this->registratorLog(WLOG_DEBUG, "Sale approve:  Error approving sale, '$sql'", __FILE__, __LINE__);
    return false;
}

QCore_History::logWithCondition($debug_sales == 1, WLOG_DEBUG, "Sale approve: End approving sale with OrderID: '$OrderID'", __FILE__, __LINE__);
?>
