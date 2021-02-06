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
|	orderForm.inc.php
|   ========================================
|	Makes Printable Order Form	
+--------------------------------------------------------------------------
*/
	
	// INCLUDE CORE VARIABLES & FUNCTIONS
	include_once("../../../includes/global.inc.php");
	
	// initiate db class
	include_once("../../../classes/db.inc.php");
	$db = new db();
	
	include_once("../../../includes/functions.inc.php");
	
	$config = fetchDbConfig("config");

	$module = fetchDbConfig("Print_Order_Form");
	
	// get session data
	include_once("../../../includes/session.inc.php");
	
	// initiate basket
	include_once("../../../classes/cart.php");
	
	$lang_folder = "";
	
	if(empty($ccUserData[0]['lang'])){
		$lang_folder = $config['defaultLang'];
	} else {
		$lang_folder = $ccUserData[0]['lang'];
	}
	include_once("../../../language/".$lang_folder."/lang.inc.php");
	
	$cart = new cart();
	$basket = $cart->cartContents($ccUserData[0]['basket']);
	
	// get exchange rates etc override users curency if need be
	if($module['multiCurrency']==0){
		$ccUserData[0]['currency'] = $config['defaultCurrency'];
	}
	include_once("../../../includes/currencyVars.inc.php");
	
	// require template class
	include_once("../../../classes/xtpl.php");
	
	$print_order_form = new XTemplate("orderForm.tpl");
	
	$result = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_order_sum INNER JOIN ".$glob['dbprefix']."CubeCart_customer ON ".$glob['dbprefix']."CubeCart_order_sum.customer_id = ".$glob['dbprefix']."CubeCart_customer.customer_id WHERE ".$glob['dbprefix']."CubeCart_order_sum.cart_order_id = ".$db->mySQLSafe($basket['cart_order_id']));
	
	if($result == FALSE){
	header("Location: ".$glob['rootRel']."cart.php?cart.php&act=step2");
	}
	include_once("../../../language/".$config['defaultLang']."/config.inc.php");
	$print_order_form->assign("VAL_ISO",$charsetIso);
	
	$print_order_form->assign("VAL_STORE_NAME",$config['storeName']);
	$print_order_form->assign("VAL_STORE_URL",$glob['storeURL']);
	$print_order_form->assign("LANG_INVOICE_TO",$lang['printOrderForm']['invoiceTo']);
	$print_order_form->assign("VAL_INVOICE_NAME",$result[0]['name']);
	$print_order_form->assign("VAL_INVOICE_ADD1",$result[0]['add_1']);
	$print_order_form->assign("VAL_INVOICE_ADD2",$result[0]['add_2']);
	$print_order_form->assign("VAL_INVOICE_TOWN",$result[0]['town']);
	$print_order_form->assign("VAL_INVOICE_STATE",$result[0]['county']);
	$print_order_form->assign("VAL_INVOICE_POSTCODE",$result[0]['postcode']);
	$print_order_form->assign("VAL_INVOICE_COUNTRY",countryName($result[0]['country']));
	
	$print_order_form->assign("LANG_DELIVER_TO",$lang['printOrderForm']['deliverTo']);
	$print_order_form->assign("VAL_DELIVER_NAME",$result[0]['name_d']);
	$print_order_form->assign("VAL_DELIVER_ADD1",$result[0]['add_1_d']);
	$print_order_form->assign("VAL_DELIVER_ADD2",$result[0]['add_2_d']);
	$print_order_form->assign("VAL_DELIVER_TOWN",$result[0]['town_d']);
	$print_order_form->assign("VAL_DELIVER_STATE",$result[0]['county_d']);
	$print_order_form->assign("VAL_DELIVER_POSTCODE",$result[0]['postcode_d']);
	$print_order_form->assign("VAL_DELIVER_COUNTRY",$result[0]['country_d']);
		  
	$print_order_form->assign("LANG_INVOICE_RECIEPT_FOR",$lang['printOrderForm']['postalOrderFor']);
	$print_order_form->assign("LANG_ORDER_OF_TIME",$lang['printOrderForm']['orderOf']);
	$print_order_form->assign("VAL_TIME_DATE",formatTime($result[0]['time']));
	$print_order_form->assign("LANG_CART_ORDER_ID",$lang['printOrderForm']['orderID']);
	$print_order_form->assign("VAL_CART_ORDER_ID",$basket['cart_order_id']);
	
	$print_order_form->assign("LANG_PRODUCT",$lang['printOrderForm']['product']);
	$print_order_form->assign("LANG_PRODUCT_CODE",$lang['printOrderForm']['code']);
	$print_order_form->assign("LANG_QUANTITY",$lang['printOrderForm']['qty']);
	$print_order_form->assign("LANG_PRICE",$lang['printOrderForm']['price']);
	
	// repeat products 
	$results = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_order_inv WHERE cart_order_id = ".$db->mySQLSafe($basket['cart_order_id']));
	
	for($i=0;$i<count($results);$i++){
		$print_order_form->assign("VAL_PRODUCT_NAME",$results[$i]['name']);
		$print_order_form->assign("VAL_PRODUCT_OPTS",$results[$i]['product_options']);
		$print_order_form->assign("VAL_PRODUCT_CODE",$results[$i]['productCode']);
		$print_order_form->assign("VAL_PRODUCT_QUANTITY",$results[$i]['quantity']);
		$print_order_form->assign("VAL_PRODUCT_PRICE",priceFormat($results[$i]['price']));
		$print_order_form->parse("order_form.repeat_order_inv");
	}
	
	$print_order_form->assign("LANG_SHIPPING_METHOD",$lang['printOrderForm']['shippingMethod']);
	$print_order_form->assign("VAL_SHIPPING_METHOD",$result[0]['shipMethod']);  
	$print_order_form->assign("LANG_SUBTOTAL",$lang['printOrderForm']['subtotal']);
	$print_order_form->assign("VAL_SUBTOTAL",priceFormat($result[0]['subtotal']));

//.: adg_coupon_mod http://www.alexgoldberg.com/cubemods :.
		$print_order_form->assign("LANG_COUPON",$lang['front']['cart']['coupon']."<br>".$result[0]['coupon_code']);
		$print_order_form->assign("VAL_COUPON",priceFormat($result[0]['coupon_savings']));
//.: adg_coupon_mod http://www.alexgoldberg.com/cubemods :.


	$print_order_form->assign("LANG_TOTAL_TAX",$lang['printOrderForm']['totalTax']);
	$print_order_form->assign("VAL_TOTAL_TAX",priceFormat($result[0]['total_tax']));
	$print_order_form->assign("LANG_SHIPPING",$lang['printOrderForm']['totalShipping']);
	$print_order_form->assign("VAL_SHIPPING",priceFormat($result[0]['total_ship']));
	$print_order_form->assign("LANG_GRAND_TOTAL",$lang['printOrderForm']['grandTotal']);
	$print_order_form->assign("VAL_GRAND_TOTAL",priceFormat($result[0]['prod_total']));
	$print_order_form->assign("EPAY_AMOUNT",str_replace(".", "", $result[0]['prod_total']));
	
	if($module['cheque'] == 1){
		$print_order_form->assign("LANG_PAY_BY_CHEQUE",$lang['printOrderForm']['payByCheck']);
		$print_order_form->assign("VAL_MAKE_CHEQUES_PAYABLE_TO",$lang['printOrderForm']['payTo']." ".$module['payableTo'].".");
		$print_order_form->parse("order_form.check_true");
	}
	
	if($module['card'] == 1){
		$print_order_form->assign("LANG_PAY_BY_CARD",$lang['printOrderForm']['payByCard']);
		$print_order_form->assign("LANG_CARD_TYPE",$lang['printOrderForm']['cardType']);
		
		$cards = explode(",",$module['cards']);
		
		if(is_array($cards)){
			foreach($cards as $key => $value){
			$print_order_form->assign("VAL_CARD_NAME",$value);
			$print_order_form->parse("order_form.card_true.repeat_card");
			}
		}
		
		$print_order_form->assign("LANG_CARD_NO",$lang['printOrderForm']['cardNo']);
		$print_order_form->assign("LANG_3_DIG_ID",$lang['printOrderForm']['3-4DigiId']);
		$print_order_form->assign("LANG_EXPIRE_DATE",$lang['printOrderForm']['expiryDate']);
		$print_order_form->assign("LANG_ISSUE_DATE",$lang['printOrderForm']['issueDate']);
		$print_order_form->assign("LANG_ISSUE_NUMBER",$lang['printOrderForm']['issueNo']);
		$print_order_form->assign("LANG_SIGNATURE",$lang['printOrderForm']['signature']);
		$print_order_form->parse("order_form.card_true");
	}
	
	
	if($module['bank'] == 1){
		$print_order_form->assign("LANG_PAY_BY_WIRE",$lang['printOrderForm']['payByTransfer']);
		$print_order_form->assign("LANG_BANK_NAME",$lang['printOrderForm']['bankName']);
		$print_order_form->assign("VAL_BANK_NAME",$module['bankName']);
		$print_order_form->assign("LANG_ACCOUNT_NAME",$lang['printOrderForm']['accountName']);
		$print_order_form->assign("VAL_ACCOUNT_NAME",$module['accName']);
		$print_order_form->assign("LANG_SORT_CODE",$lang['printOrderForm']['sortCode']);
		$print_order_form->assign("VAL_SORT_CODE",$module['sortCode']);
		$print_order_form->assign("LANG_AC_NO",$lang['printOrderForm']['accountNo']);
		$print_order_form->assign("VAL_AC_NO",$module['acNo']);
		$print_order_form->assign("LANG_SWIFT_CODE",$lang['printOrderForm']['swiftCode']);
		$print_order_form->assign("VAL_SWIFT_CODE",$module['swiftCode']);
		$print_order_form->assign("LANG_ADDRESS",$lang['printOrderForm']['bankAddress']);
		$print_order_form->assign("VAL_ADDRESS",$module['address']);
		$print_order_form->parse("order_form.bank_true");
	}
	
	if(!empty($module['notes'])){
	$print_order_form->assign("VAL_CUST_NOTES",$module['notes']);
	$print_order_form->parse("order_form.cust_notes");
	}
	
	$print_order_form->assign("LANG_THANK_YOU",$lang['printOrderForm']['thanks']);
	$print_order_form->assign("LANG_SEND_TO",$lang['printOrderForm']['postalAddress']);
	$print_order_form->assign("VAL_STORE_ADDRESS",$config['storeAddress']);
	
	// empty basket
	//$basket = $cart->emptyCart();
//
//
//	
//$print_order_form->parse("order_form");
//
//$print_order_form->out("order_form");
//
//
//
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>ePay | Standard betalingsvindue</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<style type="text/css">
			
			BODY 
			{
				color: #000000;
				font-family: verdana, arial;
				font-size: 12px;
			}

			TD 
			{
				color: #000000;
				font-family: verdana, arial;
				font-size: 12px;
			}	
			
			FORM 
			{
				margin: 0px;
				padding: 0px;
				border: 0px;
			}
			
		</style>
		<script type="text/javascript" src="http://www.epay.dk/js/standardwindow.js"></script>
	</head>
<body onLoad="open_ePay_window()">
"Bemærk! Hvis du benytter en popup stopper, skal du holde CTRL tasten nede, mens du trykker på knappen."
	<br />
	<br />
	<br /><br />
	<input type="button" value="Åben betalingsvinduet" onClick="open_ePay_window()">
	<form action="https://ssl.ditonlinebetalingssystem.dk/popup/default.asp" method="post" name="ePay" target="ePay_window" id="ePay">
		<input type="hidden" name="merchantnumber" value="88888888" />	
		<input type="hidden" name="amount" value= <?php EPAY_AMOUNT ?> />
		<input type="hidden" name="currency" value="208" />
		<input type="hidden" name="orderid" value=<?php VAL_GRAND_TOTAL ?> />
		<input type="hidden" name="accepturl" value="http://www.nyah-beauty.com/" />
		<input type="hidden" name="declineurl" value="http://www.nyah-beauty.com" />
		<input type="hidden" name="instantcapture" value="0" /> 
		<input type="hidden" name="ordretext" value="Tekst til kvitteringen som vises for kunden" /> 
		<input type="hidden" name="group" value="" />
		<input type="hidden" name="description" value="Beskrivelse som kan ses inde i administrationen til ePay" />
		<input type="hidden" name="windowstate" value="1" />
		<input type="hidden" name="authmail" value="" />
		<input type="hidden" name="addfee" value="0" />
	</form>
</body>	
</html>

<?php 
// add affilate tracking code/module
	$affiliateModule = $db->select("SELECT folder, `default` FROM ".$glob['dbprefix']."CubeCart_Modules WHERE module='affiliate' AND status = 1");

	if($affiliateModule == TRUE) {
	
		for($i=0; $i<count($affiliateModule); $i++){
			
			include("../../../modules/affiliate/".$affiliateModule[$i]['folder']."/tracker.inc.php");
			// VARS AVAILABLE
			// Order Id Number $basket['cart_order_id']
			// Order Total $order[0]['prod_total']
			//$basket['cart_order_id'] = $_POST['x_invoice_num'];
			$order[0]['prod_total'] = $result[0]['prod_total'];
			echo $affCode;
		
		}
	
	}

?>
