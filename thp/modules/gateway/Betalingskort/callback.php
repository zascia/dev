<?php
/*
+--------------------------------------------------------------------------
|	callback.php
| ========================================
|	Call Back for the ePay Gateway to store comments, transaction id
| and set order status(if customer didnt get back)	
+--------------------------------------------------------------------------
*/
unset($lang); // Issue on some servers
include("../../../includes/ini.inc.php");
include("../../../includes/global.inc.php");
require_once("../../../classes/db.inc.php");
$db = new db();
include_once("../../../includes/functions.inc.php");
$config = fetchDbConfig("config");
include_once("../../../language/".$config['defaultLang']."/lang.inc.php");
include("../../../includes/currencyVars.inc.php");
$module = fetchDbConfig("Betalingskort");

$buffer = date("d.m.y H:i:s")."\r\n";
$buffer .= "GET start -----------------
";
foreach ($_GET as $key => $value) {
	$buffer .= "$key -> $value\n";
}
$buffer .=  "GET end -------------------\r\n\r\n";

$transact = isset($_GET['tid']) ? $_GET['tid'] : "";
$orderid  = isset($_GET['orderid']) ? $_GET['orderid'] : "";
$amount   = isset($_GET['amount']) ? $_GET['amount'] : "";
$currency = isset($_GET['cur']) ? $_GET['cur'] : "";
$authentic_key = isset($_GET['eKey']) ? $_GET['eKey'] : "";
$fraud_severity = isset($_GET['fraud']) ? $_GET['fraud'] : "";
$orderfee = isset($_GET['transfee']) ? $_GET['transfee'] : "";
$error = 0; $ePay_comments = "";

// Store to order comments if items active
$ePay_comments .= (!empty($fraud_severity)) ? "Fraud severity: ".$fraud_severity."\r\n" : "";
$ePay_comments .= (!empty($orderfee)) ? "Order fee: ".($orderfee/100)."\r\n" : "";

if(!empty($transact) && !empty($orderid)){
		
	$summary = $db->select("SELECT prod_total, comments, sec_order_id, status FROM ".$glob['dbprefix']."CubeCart_order_sum WHERE cart_order_id = ".$db->mySQLsafe($_GET['orderid']));
	
	$transact_id = $db->select("SELECT cart_order_id FROM ".$glob['dbprefix']."CubeCart_order_sum WHERE sec_order_id = ".$db->mySQLsafe($transact));

	// cross control
	if ($transact_id[0]['cart_order_id']==$orderid || !empty($summary[0]['sec_order_id'])) { $error = 1; $buffer .= "ORDER EXISTS\r\n"; $ePay_comments .= "Duplicate Order\r\n"; }

	if (strlen($module['key'])>0 && $module['auth']==1) {

		if (!empty($_GET['eKey']) && strlen($_GET['eKey'])>0 && $_GET['eKey']==MD5(($summary[0]['prod_total']*100).$orderid.$transact.$module['key'])) {				
		} else {
			$error += 2;
			$ePay_comments .= "MD5 error\r\n";
			$buffer .= "MD5 Error\r\n";
		}
	} elseif ($summary[0]['prod_total']*100!=$amount){
			$ePay_comments .= "Order amount doesnt match\r\n";
			$buffer .= "Amount Error\r\n";
			$error += 2;
	}

	// Save transaction id to database if first time checkout AND comments
	if ($error==0) $updateOrder['sec_order_id'] = $db->mySQLSafe($transact);
	
	if ($error!= 1){
		$updateOrder['comments'] = $db->mySQLSafe($ePay_comments);
		$update = $db->update($glob['dbprefix']."CubeCart_order_sum", $updateOrder,"cart_order_id=".$db->mySQLSafe($orderid));
		$buffer .= "Comments added\r\n";
	}

	// Payment
	if($error==0 && $summary[0]['status']!=2){	
		$cart_order_id = $orderid;
		include("../../../includes/orderSuccess.inc.php");
		$buffer .= "PROCESSING\r\n";
	} elseif ($error==0 && $summary[0]['status']==2) {
		$buffer .= "PROCESSING\r\n";
	}
}
/* Testing
$file = fopen ("call.log", "a+");
fwrite($file,$buffer);
fclose($file);
*/
?>