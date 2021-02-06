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
|	confirmed.inc.php
|   ========================================
|	Order Confirmation
+--------------------------------------------------------------------------
*/

if (ereg(".inc.php",$HTTP_SERVER_VARS['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

require_once("classes/cart.php");
$cart = new cart();

$basket = $cart->cartContents($ccUserData[0]['basket']);

// WORK OUT IS THE ORDER WAS SUCCESSFULL OR NOT ;)

// 1. Include gateway file

// Override basket value as fix for some gateways
if(isset($_GET['pg']) && !empty($_GET['pg'])){
	
	$pg = base64_decode($_GET['pg']);
	
	if(ereg("Authorize|WorldPay|Protx|SECPay|BluePay",$pg)){
		$basket['gateway'] = $pg;
	}

############################################################################################
// Following lines added for Sir William's PayPal AutoReturn Fix
} elseif(isset($_GET['tx']) && isset($_GET['st'])) {
 $basket['gateway'] = "PayPal";
############################################################################################

// DIBS CALLBACK FIX by convict -->
} elseif(isset($_POST['cb_dibs'])) {
 $basket['gateway'] = "Dibs";
// <--

} elseif(!isset($basket['gateway'])){
	echo "Error: No payment gateway variable is set!";
	exit;
}
include("modules/gateway/".$basket['gateway']."/transfer.inc.php");

// 2. Include function which returns ture or false
$success = success();

$confirmation = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/content/confirmed.tpl");

	$confirmation->assign("LANG_CONFIRMATION_SCREEN",$lang['front']['confirmed']['confirmation_screen']);
	
	$confirmation->assign("LANG_CART",$lang['front']['confirmed']['cart']);
	$confirmation->assign("LANG_ADDRESS",$lang['front']['confirmed']['address']);
	$confirmation->assign("LANG_PAYMENT",$lang['front']['confirmed']['payment']);
	$confirmation->assign("LANG_COMPLETE",$lang['front']['confirmed']['complete']);
	
	if($success == TRUE){
		
		if($stateUpdate == TRUE){
				$cart_order_id = $basket['cart_order_id'];
				include_once("includes/orderSuccess.inc.php");
		}
		
		$confirmation->assign("LANG_ORDER_SUCCESSFUL",$lang['front']['confirmed']['order_success']);
		
		// add affilate tracking code/module
		$affiliateModule = $db->select("SELECT status, folder, `default` FROM ".$glob['dbprefix']."CubeCart_Modules WHERE module='affiliate' AND status = 1");
	
		if($affiliateModule == TRUE) {
		
			for($i=0; $i<count($affiliateModule); $i++){
			
				if($affiliateModule[$i]['status']==1){
					
						include("modules/affiliate/".$affiliateModule[$i]['folder']."/tracker.inc.php");
						// VARS AVAILABLE
						// Order Id Number $basket['cart_order_id']
						// Order Total $order[0]['prod_total']
						$confirmation->assign("AFFILIATE_IMG_TRACK",$affCode);
						$confirmation->parse("confirmation.session_true.order_success.aff_track");
				
				}
			
			}
		
		}
		
		$confirmation->parse("confirmation.session_true.order_success");
		
		// empty basket & other session data
		$basket = $cart->unsetVar("conts");
		$basket = $cart->unsetVar("delInf");
		$basket = $cart->unsetVar("cart_order_id");
		$basket = $cart->unsetVar("shipCost");
		$basket = $cart->unsetVar("subTotal");
		$basket = $cart->unsetVar("tax");
		$basket = $cart->unsetVar("shipCost");
		$basket = $cart->unsetVar("grandTotal");
		$basket = $cart->unsetVar("customer_comments");
		$basket = $cart->unsetVar("counted");
		$basket = $cart->unsetVar("shipMethod");

//.: adg_coupon_mod http://www.alexgoldberg.com/cubemods :.
		$basket = $cart->unsetVar("coupon_code");
		$basket = $cart->unsetVar("coupon_savings");
//.: adg_coupon_mod :.


		
	} else {
		
		$confirmation->assign("LANG_ORDER_FAILED",$lang['front']['confirmed']['order_fail']);
		$confirmation->assign("LANG_ORDER_RETRY",$lang['front']['confirmed']['try_again_desc']);
		$confirmation->assign("LANG_RETRY_BUTTON",$lang['front']['confirmed']['try_again']);
		$confirmation->parse("confirmation.session_true.order_failed");
	}
	
	$confirmation->assign("LANG_LOGIN_REQUIRED",$lang['front']['confirmed']['request_login']);
	
	if($ccUserData[0]['customer_id']>0) $confirmation->parse("confirmation.session_true");
	
	else $confirmation->parse("confirmation.session_false");
	
	$confirmation->parse("confirmation");
	
$page_content = $confirmation->text("confirmation");
?>