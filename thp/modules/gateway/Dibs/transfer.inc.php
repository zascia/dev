<?php 
/*
+--------------------------------------------------------------------------
|   CubeCart v3.0.8
|   ========================================
|   by Alistair Brookbanks
|	CubeCart is a Trade Mark of Devellion Limited
|   Copyright Devellion Limited 2005 - 2006. All rights reserved.
|   Devellion Limited,
|   22 Thomas Heskin Court,
|   Station Road,
|   Bishops Stortford,
|   HERTFORDSHIRE.
|   CM23 3EE
|   UNITED KINGDOM
|   http://www.devellion.com
|	UK Private Limited Company No. 5323904
|   ========================================
|   Web: http://www.cubecart.com
|   Date: Monday, 23rd January 2006
|   Email: info (at) cubecart (dot) com
|	License Type: CubeCart is NOT Open Source Software and Limitations Apply 
|   Licence Info: http://www.cubecart.com/site/faq/license.php
+--------------------------------------------------------------------------
|	transfer.php
|   ========================================
|	Core functions for the Dibs Gateway	
+--------------------------------------------------------------------------
*/

/*
//////////////////////////
// IN THE REPEATED REGION
//////
$orderInv['productId']						- product id as an integer
$orderInv['name']							- product name as a varchar
$orderInv['price']							- price of each product (inc options)
$orderInv['quantity']						- quantity of products as an integer
$orderInv['product_options']				- products attributes as test
$orderInv['productCode']					- product code as a varchar
$i											- This is the current incremented integer starting at 0

/////////////////////////
// FIXED VARS
///////
$cart_order_id							- cart order id as a varchar
$ccUserData[0]['email']						- Customers email address
$ccUserData[0]['title']						- Customers title (Mr Miss etc...)
$ccUserData[0]['firstName']					- Customers first name
$ccUserData[0]['lastName']					- Customers last name 
$ccUserData[0]['add_1']						- Invoice Address line 1
$ccUserData[0]['add_2']						- Invoice Address line 1
$ccUserData[0]['town']						- Invoice Town or city
$ccUserData[0]['county']					- Invoice County or state
$ccUserData[0]['postcode']					- Invoice Post/Zip Code
$ccUserData[0]['country']					- Invoice country Id we can look up the country name like this
										countryName($ccUserData[0]['country']);
$ccUserData[0]['phone']						- Contact phone no
$ccUserData[0]['mobile']					- Mobile/Cell phone number

$basket['delInf']['title']				- Delivery title (Mr Miss etc...)
$basket['delInf']['firstName']			- Delivery customers first name
$basket['delInf']['lastName']			- Delivery customers last name 
$basket['delInf']['add_1']				- Delivery Address line 1
$basket['delInf']['add_2']				- Delivery Address line 1
$basket['delInf']['town']				- Delivery Town or city
$basket['delInf']['county']				- Delivery County or state
$basket['delInf']['postcode']			- Delivery Post/Zip Code
$basket['delInf']['country']			- Delivery  country Id we can look up the country name like this	
									countryName($basket['delInf']['country']);


$basket['subTotal'] 					- Order Subtotal (exTax and Shipping)
$basket['grandTotal']					- Basket total which has to be paid (inc Tax and Shipping).
$basket['tax']							- Total tax to pay
$basket['shipCost']						- Shipping price
////////////////////////////////////////////////////////
*/

$module = fetchDbConfig("Dibs");

function repeatVars(){

		return FALSE;
	
}

function fixedVars() {
	
	global $module, $basket, $ccUserData, $cart_order_id, $config, $GLOBALS, $lang_folder;

	$amount = sprintf("%.2f",$basket['subTotal']+$basket['tax'])*100;

	if    ($config['defaultCurrency']=="USD"){ $currencyNo = 840; }
	elseif($config['defaultCurrency']=="CAD"){ $currencyNo = 124; }
	elseif($config['defaultCurrency']=="CHF"){ $currencyNo = 756; }
	elseif($config['defaultCurrency']=="GBP"){ $currencyNo = 826; }
	elseif($config['defaultCurrency']=="AUD"){ $currencyNo = 036; }
	elseif($config['defaultCurrency']=="JPY"){ $currencyNo = 392; }
	elseif($config['defaultCurrency']=="EUR"){ $currencyNo = 978; }
	elseif($config['defaultCurrency']=="DKK"){ $currencyNo = 208; }
	elseif($config['defaultCurrency']=="SEK"){ $currencyNo = 752; }
	elseif($config['defaultCurrency']=="NOK"){ $currencyNo = 578; }

	$merchant = "merchant=".$module['merchant'];
	$orderid = "orderid=".$cart_order_id;
	$currency = "currency=".$currencyNo;
	$amountv = "amount=".$amount;
	
	$hiddenVars = "<input type='hidden' name='merchant' value='".$module['merchant']."' />
				<input type='hidden' name='orderid' value='$cart_order_id' />
				<input type='hidden' name='amount' value='".$amount."' />
				<input type='hidden' name='currency' value='".$currencyNo."' />
				<input type='hidden' name='delivery1' value='".$basket['delInf']['lastName']." ".$basket['delInf']['firstName']."' />
				<input type='hidden' name='delivery2' value='".$basket['delInf']['add_1']." ".$basket['delInf']['add_2']."' />
				<input type='hidden' name='lang' value='".$lang_folder."' />
				<input type='hidden' name='accepturl' value='".$GLOBALS['storeURL']."/confirmed.php' />
				<input type='hidden' name='cancelurl' value='".$GLOBALS['storeURL']."/confirmed.php' />";


				if($module['method']=="callback") $hiddenVars .="<input type='hidden' name='callbackurl' value='".$GLOBALS['storeURL']."/modules/gateway/Dibs/call_back.php' />\r\n<input type='hidden' name='cb_dibs' value='yes' />
				";
									
				if($module['testMode']==1) $hiddenVars .= "<input type='hidden' name='test' value='yes'>";
				
				if($module['auth']==1)	{
					
					$md5key = MD5($module['key2'] . MD5($module['key1'] . "$merchant&$orderid&$currency&$amountv")); 
					$hiddenVars .= "\r\n<input type='hidden' name='md5key' value='$md5key'>";
					
				}
				
				
	return $hiddenVars;
	
}

function success(){
		
	global $db, $glob, $module, $basket;

	if($module['method']=="std") {

		if(isset($_POST['transact']) && ($_POST['orderid'] == $basket['cart_order_id']) ){
			
			$_POST=array(); // safety
					
			return TRUE;
			
		} else {
		
			return FALSE;		
		}
		
	} elseif ($module['method']=="callback") {
		
		$result = $db->select("SELECT status  FROM ".$glob['dbprefix']."CubeCart_order_sum WHERE sec_order_id = ".$db->mySQLSafe($_POST['transact']) );
		
		if($result[0]['status']==2){
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
}

///////////////////////////
// Other Vars
////////
$formAction = "https://payment.architrade.com/payment/start.pml";
$formMethod = "post";
$formTarget = "_self";
$transfer = "auto";

if($module['method']=="std"){

	$stateUpdate = TRUE;

} else {

	$stateUpdate = FALSE;
}
?>