<?php
/*
+--------------------------------------------------------------------------
|	callback.php
|   ========================================
|	Call Back for the DIBs Gateway	
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

$module = fetchDbConfig("Dibs");

// variable names like for API usage
$MD5['K1'] =$module['key1'];
$MD5['K2'] =$module['key2'];

$transact = "transact=".$_POST['transact'];
$merchant = "merchant=".$_POST['merchant'];
$orderid = "orderid=".$_POST['orderid'];
$amount = "amount=".$_POST['amount'];
$currency = "currency=".$_POST['currency'];

$authentic_key = $_POST['authkey'];
$fraud_severity = $_POST['severity'];
$control_key = MD5($MD5['K2'] . MD5($MD5['K1'] . "$transact&$amount&$currency"));

$check_amount = ($_POST['amount']/100);

$dibs_comments = "Payment type: ".$_POST['paytype']."\r\n";
$dibs_comments .= "Fraud severity: ".$fraud_severity."\r\n";

/*
foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}
*/
// Check MD5 hash if payment is regular
if ($control_key == $_POST['authkey']) {

	$fail = FALSE;

	$summary = $db->select("SELECT prod_total, comments FROM ".$glob['dbprefix']."CubeCart_order_sum WHERE cart_order_id = ".$db->mySQLsafe($_POST['orderid']));

	// Check if transaction was made before
	$transact_id = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_order_sum WHERE sec_order_id = ".$db->mySQLsafe($_POST['transact']));
	
	// Save transaction id to database if first time checkout
	if($transact_id == TRUE){
		$fail = TRUE;
	} else {
		$updateOrderTransact['sec_order_id'] = $db->mySQLSafe($_POST['transact']);
		$update = $db->update($glob['dbprefix']."CubeCart_order_sum", $updateOrderTransact,"cart_order_id=".$db->mySQLSafe($_POST['orderid']));
	}
	
	// Check that merchant id is the same as defined in module settings
	if($_POST['merchant']!==trim($module['merchant'])){
		$fail = TRUE;
		}
/*	
Treba volat funkciu pre menu (desatinne miesta)
	// Check payed amount is same as in database
	if($check_amount!==$summary[0]['prod_total']){
$lolo = "$check_amount - ";
		
$updateOrder['comments'] = $db->mySQLSafe($check_amount);
$update = $db->update($glob['dbprefix']."CubeCart_order_sum", $updateOrder,"cart_order_id=".$db->mySQLSafe($_POST['orderid']));
		
		$fail = TRUE;
	}
*/

	// Payment
	if($fail==FALSE){

//$updateOrder['comments'] = $db->mySQLSafe("MD5-".$_POST['authkey']." Calc-".$control_key);
$updateOrder['comments'] = $db->mySQLSafe($dibs_comments);
$update = $db->update($glob['dbprefix']."CubeCart_order_sum", $updateOrder,"cart_order_id=".$db->mySQLSafe($_POST['orderid']));
		
		$cart_order_id = $_POST['orderid'];
		include("../../../includes/orderSuccess.inc.php");
	}

}
?>