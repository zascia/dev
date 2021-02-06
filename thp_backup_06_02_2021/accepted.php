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
	include_once("includes/global.inc.php");
	
	// initiate db class
	include_once("classes/db.inc.php");
	$db = new db();
	
	include_once("includes/functions.inc.php");
	
	$config = fetchDbConfig("config");

	$module = fetchDbConfig("Print_Order_Form");
	
	// get session data
	include_once("includes/session.inc.php");
	
	// initiate basket
	include_once("classes/cart.php");
	
	$lang_folder = "";
	
	if(empty($ccUserData[0]['lang'])){
		$lang_folder = $config['defaultLang'];
	} else {
		$lang_folder = $ccUserData[0]['lang'];
	}
	include_once("language/".$lang_folder."/lang.inc.php");
	
	$cart = new cart();
	$basket = $cart->cartContents($ccUserData[0]['basket']);
	
	// get exchange rates etc override users curency if need be
	if($module['multiCurrency']==0){
		$ccUserData[0]['currency'] = $config['defaultCurrency'];
	}
	include_once("includes/currencyVars.inc.php");
	
	// require template class
	include_once("classes/xtpl.php");
	
	$print_order_form = new XTemplate("orderForm.tpl");
	
	$result = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_order_sum INNER JOIN ".$glob['dbprefix']."CubeCart_customer ON ".$glob['dbprefix']."CubeCart_order_sum.customer_id = ".$glob['dbprefix']."CubeCart_customer.customer_id WHERE ".$glob['dbprefix']."CubeCart_order_sum.cart_order_id = ".$db->mySQLSafe($basket['cart_order_id']));
	
	if($result == FALSE){
	header("Location: ".$glob['rootRel']."cart.php?cart.php&act=step2");
	}
	include_once("language/".$config['defaultLang']."/config.inc.php");
	$print_order_form->assign("VAL_ISO",$charsetIso);
	
	
	
	if(!empty($module['notes'])){
	$print_order_form->assign("VAL_CUST_NOTES",$module['notes']);
	$print_order_form->parse("order_form.cust_notes");
	}
	
	$print_order_form->assign("LANG_THANK_YOU",$lang['printOrderForm']['thanks']);
	$print_order_form->assign("LANG_SEND_TO",$lang['printOrderForm']['postalAddress']);
	$print_order_form->assign("VAL_STORE_ADDRESS",$config['storeAddress']);
	
	// empty basket
	$basket = $cart->emptyCart();
	
$print_order_form->parse("order_form");
	
$print_order_form->out("order_form");


// add affilate tracking code/module
	$affiliateModule = $db->select("SELECT folder, `default` FROM ".$glob['dbprefix']."CubeCart_Modules WHERE module='affiliate' AND status = 1");

	if($affiliateModule == TRUE) {
	
		for($i=0; $i<count($affiliateModule); $i++){
			
			include("modules/affiliate/".$affiliateModule[$i]['folder']."/tracker.inc.php");
			// VARS AVAILABLE
			// Order Id Number $basket['cart_order_id']
			// Order Total $order[0]['prod_total']
			//$basket['cart_order_id'] = $_POST['x_invoice_num'];
			$order[0]['prod_total'] = $result[0]['prod_total'];
			echo $affCode;
		
		}
	
	}

?>
