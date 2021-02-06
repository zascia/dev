<?php 

// include files
require_once('global.php');

$OrderID = preg_replace('/[\'\"\ ]/', '', $_GET['OrderID']);

$recComm = QUnit_Global::newObj('Affiliate_Scripts_Bl_RecurringCommissions');

$recComm->cancelRecurring($OrderID);

?>
OK
