<?php  

/*
+--------------------------------------------------------------------------
|   CubeCart v3.0.17
|   ========================================
|   by Alistair Brookbanks
|	CubeCart is a Trade Mark of Devellion Limited
|   Copyright Devellion Limited 2005 - 2006. All rights reserved.
|   Devellion Limited,
|   5 Bridge Street,
|   Bishops Stortford,
|   HERTFORDSHIRE.
|   CM23 2JU
|   UNITED KINGDOM
|   http://www.devellion.com
|	UK Private Limited Company No. 5323904
|   ========================================
|   Web: http://www.cubecart.com
|   Date: Tuesday, 17th July 2007
|   Email: sales (at) cubecart (dot) com
|	License Type: CubeCart is NOT Open Source Software and Limitations Apply 
|   Licence Info: http://www.cubecart.com/site/faq/license.php
+--------------------------------------------------------------------------
|	confirmed.inc.php
|   ========================================
|	Order Confirmation
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
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
	
	$pg = preg_replace('/[^a-zA-Z0-9_\-\+]/', '',base64_decode($_GET['pg']));
	
	if(ereg("Authorize|WorldPay|Protx|SECPay|BluePay|mals-e|Nochex_APC|PayOffline",$pg)){
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
		
	// start Email template mod
	if(!isset($_POST['FREE'])) {
	if (!isset($mail)) {
		include($glob['rootDir']."/classes/class.phpmailer.php");
		$mail = new PHPMailer();
	}
	include($glob['rootDir']."/includes/email_config.inc.php");
	$email_template2 = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_eMail WHERE enabled = 1 AND type = 'order'");
	if ($email_template2 == TRUE) {
		if (isset($prod)) {
			unset($prod);
		}
		$prod="";
		for($i=0;$i<count($basket['invArray']);$i++) {
				$prod .= $basket['invArray'][$i+1]["quantity"]." x ".$basket['invArray'][$i+1]["name"]." - ".priceFormat($basket['invArray'][$i+1]["price"])."<br />";
				if(!empty($basket['invArray'][$i+1]["prodOptions"])) {
					$prod .= str_replace(array("\r","\n"),"<br />",$basket['invArray'][$i+1]["prodOptions"]);
				}
		}
		$search = array(
			"{PROD_LIST}",
			"{TOTAL}",
			"{SHOP_OWNER}",
			"{ORDER_TIME}",
			"{SUBTOTAL}",
			"{SHIPPING}",
			"{TAX}",
			"{TITLE}",
			"{FNAME}",
			"{LNAME}",
			"{ADDRESS1}",
			"{ADDRESS2}",
			"{TOWN}",
			"{COUNTY}",
			"{POSTCODE}",
			"{COUNTRY}",
			"{TITLE_D}",
			"{FNAME_D}",
			"{LNAME_D}",
			"{ADDRESS1_D}",
			"{ADDRESS2_D}",
			"{TOWN_D}",
			"{COUNTY_D}",
			"{POSTCODE_D}",
			"{COUNTRY_D}",
			"{GATEWAY}",
			"{SHIP_METHOD}",
			"{COMMENTS}",
			"{ORDER_ID}",
			"{CREDIT}"
		);
		$replace = array(
			$prod,
			priceFormat($basket['grandTotal']),
			$config['masterName'],
			formatTime(time()),
			priceFormat($basket['subTotal']),
			priceFormat($emailShipCost),
			priceFormat($basket['tax']),
			$ccUserData[0]['title'],
			$ccUserData[0]['firstName'],
			$ccUserData[0]['lastName'],
			$ccUserData[0]['add_1'],
			$ccUserData[0]['add_2'],
			$ccUserData[0]['town'],
			$ccUserData[0]['county'],
			$ccUserData[0]['postcode'],
			countryName($ccUserData[0]['country']),
			$basket['delInf']['title'],
			$basket['delInf']['firstName'],
			$basket['delInf']['lastName'],
			$basket['delInf']['add_1'],
			$basket['delInf']['add_2'],
			$basket['delInf']['town'],
			$basket['delInf']['county'],
			$basket['delInf']['postcode'],
			countryName($basket['delInf']['country']),
			str_replace("_"," ",$basket['gateway']),
			str_replace("_"," ",$basket['shipMethod']),
			$comments,
			$basket['cart_order_id'],
			priceFormat($basket['credit'])
		);
		$ebody2 = $email_template2[0]['body'];
		$subject2 = str_replace("{ORDER_ID}", $basket['cart_order_id'], $email_template2[0]['subject']);
		$ebody2 = str_replace($search, $replace, $ebody2);
		$mail->From = $config['masterEmail'];
		$mail->FromName = $config['masterName'];
		$mail->AddAddress($ccUserData[0]['email'], $ccUserData[0]['firstName']." ".$ccUserData[0]['lastName']);
		$mail->AddReplyTo($config['masterEmail'], $config['masterName']);
		$mail->WordWrap = 50;
		$mail->Subject = $subject2;
		$mail->Body    = $ebody2;
		$mail->Send();
	}
}

// End email template mod
			
	// Start Analytics mod
			$confirmation->assign("VAL_ORDER_ID", $basket['cart_order_id']);
			$confirmation->assign("VAL_TOTAL", $basket['grandTotal']);
			$confirmation->assign("VAL_SHIPPING", $basket['shipCost']);
			$confirmation->assign("VAL_CITY", $basket['delInf']['town']);
	
			for($i=0;$i<count($basket['invArray']);$i++) {
				$confirmation->assign("VAL_PROD_NAME", $basket['invArray'][$i+1]["name"]);
				$confirmation->assign("VAL_PRICE", $basket['invArray'][$i+1]["price"]);
				$confirmation->assign("VAL_QTY", $basket['invArray'][$i+1]["quantity"]);
				$confirmation->parse("confirmation.session_true.order_success.analytics");
			}
	// End Analytics mod

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
		$basket = $cart->unsetVar("invArray");
		$basket = $cart->unsetVar("shipKey");
		$basket = $cart->unsetVar("gateway");
		$basket = $cart->unsetVar("currentStep");
		$basket = $cart->unsetVar("stepLimit");
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