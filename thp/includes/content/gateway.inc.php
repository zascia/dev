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
|	gateway.inc.php
|   ========================================
|	Choose and transfer to gateway
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

if($ccUserData[0]['customer_id']<1)
{
	header("Location: cart.php?act=step1");
	exit;
}

require_once("classes/cart.php");
$cart = new cart();
$basket = $cart->cartContents($ccUserData[0]['basket']);
// Quick Checkout by convict http://cubecartmods.eu -->
$qch_config = fetchDbConfig("Quick_Checkout");
if ($qch_config['status']==1):
if (isset($basket['gateway'])) { $_POST['gateway'] = $basket['gateway']; }
if (isset($basket['customer_comments'])) { $_POST['customer_comments'] = $basket['customer_comments']; }
endif;
// <-- Quick Checkout by convict

$gateway = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/content/gateway.tpl");
$gateway->assign("VAL_SKIN",$config['skinDir']);
$gateway->assign("LANG_PAYMENT",$lang['front']['gateway']['payment']);
$gateway->assign("LANG_CART",$lang['front']['gateway']['cart']);
$gateway->assign("LANG_ADDRESS",$lang['front']['gateway']['address']);
$gateway->assign("LANG_PAYMENT",$lang['front']['gateway']['payment']);
$gateway->assign("LANG_COMPLETE",$lang['front']['gateway']['complete']);

// sanitise gateway variable
if($basket == TRUE && isset($_POST['gateway']) && !eregi("[^0-9a-z_-]",$_POST['gateway'])) {
	
	//$basket = $cart->setVar($basket['shipCost'],"shipCost");
	// Quick Checkout by convict http://cubecartmods.eu Replacement -->
	// $basket = $cart->setVar($_POST['gateway'],"gateway");
	if (!isset($basket['gateway'])) {$basket = $cart->setVar($_POST['gateway'],"gateway");}
	// <-- Quick Checkout by convict
	
	include("modules/gateway/".$_POST['gateway']."/transfer.inc.php");
	
	// build order number
	if(!isset($basket['cart_order_id']) || (isset($basket['cart_order_id']) && empty($basket['cart_order_id']))){
		
		$cart_order_id = date("ymd-His-").rand(1000,9999);
		$cart->setVar($cart_order_id,"cart_order_id");
				
		$basket = $cart->setVar(0,"mailSent");
		
		$record['noOrders'] = "noOrders + 1";
		$where = "customer_id = ".$ccUserData[0]['customer_id'];
		$update = $db->update($glob['dbprefix']."CubeCart_customer", $record, $where);
		
	} else {
		
		$cart_order_id = $basket["cart_order_id"];
		$basket = $cart->setVar(1,"mailSent");
		
		// delete old orders with that Id
		$where = "cart_order_id = '".$cart_order_id."'";
		$delete = $db->delete($glob['dbprefix']."CubeCart_order_sum", $where);
		$delete = $db->delete($glob['dbprefix']."CubeCart_order_inv", $where);
		$delete = $db->delete($glob['dbprefix']."CubeCart_Downloads", $where);
	
	}
		
	// insert order inventory
	
	$transVars = "";
	//start Email template mod
	if (isset($prod)) {
		unset($prod);
	}
	$prod="";
	// End Email template mod
	
	for($i=0;$i<count($basket['invArray']);$i++){
		
		$orderInv['cart_order_id'] = $db->mySQLSafe($cart_order_id);
		$orderInv['productId'] = $db->mySQLSafe($basket['invArray'][$i+1]["productId"]);
		$orderInv['name'] = $db->mySQLSafe($basket['invArray'][$i+1]["name"]);
		$orderInv['price'] = $db->mySQLSafe($basket['invArray'][$i+1]["price"]);
		$orderInv['quantity'] = $db->mySQLSafe($basket['invArray'][$i+1]["quantity"]);
		$orderInv['product_options'] = $db->mySQLSafe($basket['invArray'][$i+1]["prodOptions"]);
		$orderInv['productCode'] = $db->mySQLSafe($basket['invArray'][$i+1]["productCode"]);
		$orderInv['digital'] = $db->mySQLSafe($basket['invArray'][$i+1]["digital"]);
	
		$insert = $db->insert($glob['dbprefix']."CubeCart_order_inv", $orderInv);

		##################################################################################
		## Admin E-Mail Fix by Sir William -- http://www.swscripts.com/
		// build admin email product list
		
		if($basket['mailSent']==0){ // send only if not sent already for current order number
			// Start Email template mod
			$prod .= $basket['invArray'][$i+1]["quantity"]." x ".$basket['invArray'][$i+1]["name"]." - ".priceFormat($basket['invArray'][$i+1]["price"])."<br />";
			if(!empty($basket['invArray'][$i+1]["prodOptions"])){
				$prod .= str_replace(array("\r","\n"),"<br />",$basket['invArray'][$i+1]["prodOptions"]);
			}			
			// End Email template mod				
			
			$prodtext .= sprintf($lang['front']['gateway']['admin_email_body_4'],
						$basket['invArray'][$i+1]["name"]);
			
			if(!empty($basket['invArray'][$i+1]["prodOptions"])){
			$prodtext .= sprintf($lang['front']['gateway']['admin_email_body_5'],
						str_replace(array("\r","\n")," ",$basket['invArray'][$i+1]["prodOptions"]));
			}
			
			$prodtext .= sprintf($lang['front']['gateway']['admin_email_body_6'],
						$basket['invArray'][$i+1]["quantity"],
						$basket['invArray'][$i+1]["productCode"],
						priceFormat($basket['invArray'][$i+1]["price"]));
					
		}
					
		##################################################################################
		
		foreach($orderInv as $key => $value){
		
			$orderInv[$key] = str_replace("'","",$value);
		
		}
		$transVars .= repeatVars();
		
		if($basket['invArray'][$i+1]["digital"]==1){
		
			$digitalProduct['cart_order_id'] = $db->mySQLSafe($cart_order_id);
			$digitalProduct['customerId'] = $db->mySQLSafe($ccUserData[0]['customer_id']);
			$digitalProduct['expire'] = $db->mySQLSafe(time()+$config['dnLoadExpire']);
			$digitalProduct['productId'] = $db->mySQLSafe($basket['invArray'][$i+1]["productId"]);
			$digitalProduct['accessKey'] = $db->mySQLSafe(randomPass());
			$insert = $db->insert($glob['dbprefix']."CubeCart_Downloads", $digitalProduct);
			
		}
	
	}
	
	if($insert==FALSE) {
		echo "An error building the order inventory was encountered. Please inform a member of staff.";
		exit;
	}
	
	// insert order summary
	
	//////////////////
	// Invoice info
	/////
	$orderSum['cart_order_id'] = $db->mySQLSafe($cart_order_id);
	$orderSum['customer_id'] = $db->mySQLSafe($ccUserData[0]['customer_id']);
	$orderSum['email'] = $db->mySQLSafe($ccUserData[0]['email']);
	$orderSum['name'] = $db->mySQLSafe($ccUserData[0]['title']." ".$ccUserData[0]['firstName']." ".$ccUserData[0]['lastName']); 
	$orderSum['add_1'] = $db->mySQLSafe($ccUserData[0]['add_1']);
	$orderSum['add_2'] = $db->mySQLSafe($ccUserData[0]['add_2']);
	$orderSum['town'] = $db->mySQLSafe($ccUserData[0]['town']);
	$orderSum['county'] = $db->mySQLSafe($ccUserData[0]['county']);
	$orderSum['postcode'] = $db->mySQLSafe($ccUserData[0]['postcode']);
	$orderSum['country'] = $db->mySQLSafe(countryName($ccUserData[0]['country']));
	$orderSum['phone'] = $db->mySQLSafe($ccUserData[0]['phone']);
	$orderSum['mobile'] = $db->mySQLSafe($ccUserData[0]['mobile']);
	
	$currency = $db->select("SELECT currency FROM ".$glob['dbprefix']."CubeCart_sessions WHERE sessId = ".$db->mySQLSafe($_SESSION['ccUser']));
	
	if($currency == TRUE){
		$orderSum['currency'] = $db->mySQLSafe($currency[0]['currency']);
	} else {
		$orderSum['currency'] = $config['defaultCurrency'];
	}
	//////////////////
	// Delivery info
	/////
	$orderSum['name_d'] = $db->mySQLSafe($basket['delInf']['title']." ".$basket['delInf']['firstName']." ".$basket['delInf']['lastName']); 
	$orderSum['add_1_d'] = $db->mySQLSafe($basket['delInf']['add_1']);
	$orderSum['add_2_d'] = $db->mySQLSafe($basket['delInf']['add_2']);
	$orderSum['town_d'] = $db->mySQLSafe($basket['delInf']['town']);
	$orderSum['county_d'] = $db->mySQLSafe($basket['delInf']['county']);
	$orderSum['postcode_d'] = $db->mySQLSafe($basket['delInf']['postcode']);
	$orderSum['country_d'] = $db->mySQLSafe(countryName($basket['delInf']['country']));
	
	//////////////////
	// Summary
	/////
	$orderSum['subtotal'] = $db->mySQLSafe($basket['subTotal']);
	$orderSum['total_ship'] = $db->mySQLSafe($basket['shipCost']);
	$orderSum['total_tax'] = $db->mySQLSafe($basket['tax']);
	$orderSum['prod_total'] = $db->mySQLSafe($basket['grandTotal']);
	$orderSum['shipMethod'] = $db->mySQLSafe($basket['shipMethod']); 
	$device=(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$_SERVER["HTTP_USER_AGENT"])||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($_SERVER["HTTP_USER_AGENT"],0,4)))?"mobile":"desktop";
	$orderSum['device'] = $db->mySQLSafe($device); 
//.: adg_coupon_mod http://www.alexgoldberg.com/cubemods :.
	$orderSum['coupon_code'] = $db->mySQLSafe($basket['coupon_code']); 
	$orderSum['coupon_savings'] = $db->mySQLSafe($basket['coupon_savings']); 
//.: adg_coupon_mod :.

	
	if(!empty($sec_order_id)){
		$orderSum['sec_order_id'] = $db->mySQLSafe($sec_order_id);
	}
	
	$orderSum['ip'] = $db->mySQLSafe($_SERVER['REMOTE_ADDR']);
	$orderSum['time'] = $db->mySQLSafe(time());
	$orderSum['customer_comments'] = $db->mySQLSafe($_POST['customer_comments']);
		
	$cart->setVar($_POST['customer_comments'],"customer_comments");
	
	$orderSum['gateway'] = $db->mySQLSafe($_POST['gateway']);
	
	$insert = $db->insert($glob['dbprefix']."CubeCart_order_sum", $orderSum);
	
	if($insert==FALSE) {
		echo "An error building the order summary was encountered. Please inform a member of staff.";
		exit;
	}
	
		//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
		if ($adg_gd_module['status']==1 && $adg_gd_module['show_group']==1 && $ccUserData[0]['group_discount'] >0) {
			$discount_info = $lang['mods']['adg_group_mod']['front_discount_group'].": ";
			$discount_info .= $ccUserData[0]['group_name']."\n";
			$discount_info .= $lang['mods']['adg_group_mod']['front_you_save'].": ";
			$discount_info .= $ccUserData[0]['group_discount']."% \n";
		} else {
			$discount_info = " ";
		}
		//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
	
	##################################################################################
	## Admin E-Mail Fix by Sir William -- http://www.swscripts.com/
	// Start Email template mod
	// notify shop owner of new order
	
	if($basket['mailSent']==0){ // send only if not sent already for current order number
	if (!isset($mail)) {
		include_once($glob['rootDir']."/classes/class.phpmailer.php");
		$mail = new PHPMailer();
	}
	include($glob['rootDir']."/includes/email_config.inc.php");

	if(!empty($_POST['customer_comments'])){
		$comments = $_POST['customer_comments'];
	}
	if($basket['shipCost']>0){
		$emailShipCost = $basket['shipCost'];
	} else {
		$emailShipCost = "0.00";
	}
	$email_template = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_eMail WHERE enabled = 1 AND type = 'admin'");
	if ($email_template == TRUE) {
		$search = array(
			"{PROD_LIST}",
			"{TOTAL}",
			"{GROUP_DISCOUNT}",
			"{SHOP_OWNER}",
			"{ORDER_TIME}",
			"{SUBTOTAL}",
			"{COUPON}",
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
			$discount_info,
			$config['masterName'],
			formatTime(time()),
			priceFormat($basket['subTotal']),
			priceFormat($basket['coupon_savings']),
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
			str_replace("_"," ",$_POST['gateway']),
			str_replace("_"," ",$basket['shipMethod']),
			$comments,
			$cart_order_id,
			priceFormat($basket['credit'])
		);
		$ebody = $email_template[0]['body'];
		$subject = str_replace("{ORDER_ID}", $cart_order_id, $email_template[0]['subject']);
		$ebody = str_replace($search, $replace, $ebody);
		$mail->From = $ccUserData[0]['email'];
		$mail->FromName = $ccUserData[0]['firstName']." ".$ccUserData[0]['lastName'];
		$mail->AddAddress($config['masterEmail'], $config['masterName']);
		$mail->AddReplyTo($ccUserData[0]['email'], $ccUserData[0]['firstName']." ".$ccUserData[0]['lastName']);
		$mail->WordWrap = 50;
		$mail->Subject = $subject;
		$mail->Body    = $ebody;
		$mail->Send();
	}
}
//	End Email Template mod
	##################################################################################

	if($transfer == "manual"){
		
		$gateway->assign("LANG_FORM_TITLE",$lang['front']['gateway']['fill_out_below']);
		
		include("modules/gateway/".$_POST['gateway']."/form.inc.php");
		
		$gateway->assign("FORM_TEMPLATE",$formTemplate);
		
		$gateway->parse("gateway.cart_true.transfer.manual_submit");
	
	} else {
		//	Start Email template mod
		if (!isset($mail)) {
			include_once($glob['rootDir']."/classes/class.phpmailer.php");
			$mail = new PHPMailer();
		}
		include($glob['rootDir']."/includes/email_config.inc.php");
		
		if ($_POST['gateway'] == "Print_Order_Form") {
			$email_template2 = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_eMail WHERE enabled = 1 AND type = 'order'");
			if ($email_template2 == TRUE) {
				$search = array(
					"{PROD_LIST}",
					"{TOTAL}",
					"{SHOP_OWNER}",
					"{ORDER_TIME}",
					"{SUBTOTAL}",
					"{COUPON}",
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
					"{ORDER_ID}"
				);
				$replace = array(
					$prod,
					priceFormat($basket['grandTotal']),
					$config['masterName'],
					formatTime(time()),
					priceFormat($basket['subTotal']),
					priceFormat($basket['coupon_savings']),
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
					str_replace("_"," ",$_POST['gateway']),
					str_replace("_"," ",$basket['shipMethod']),
					$comments,
					$cart_order_id
				);
				$ebody2 = $email_template2[0]['body'];
				$subject2 = str_replace("{ORDER_ID}", $cart_order_id, $email_template2[0]['subject']);
				$ebody2 = str_replace($search, $replace, $ebody2);
				$mail->ClearAddresses();
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
		//	End email template mod
		$gateway->assign("LANG_TRANSFERRING",$lang['front']['gateway']['transferring']);
		$gateway->parse("gateway.cart_true.transfer.auto_submit");
	
	}
	
	$gateway->assign("VAL_FORM_ACTION",$formAction);
	$gateway->assign("VAL_FORM_METHOD",$formMethod);
	$gateway->assign("VAL_TARGET",$formTarget);
	
	// add fixed vars
	$transVars .= fixedVars();
	
	$gateway->assign("FORM_PARAMETERS",$transVars);
	
	$gateway->assign("LANG_CHECKOUT",$lang['front']['gateway']['go_now']);
	
	$gateway->parse("gateway.cart_true.transfer");
	$gateway->parse("gateway.cart_true");

	
} elseif($basket==TRUE && !isset($_POST['gateway'])) {
	
	$gateway->assign("VAL_FORM_ACTION","cart.php?act=step5");
	$gateway->assign("VAL_FORM_METHOD","post");
	$gateway->assign("VAL_TARGET","_self");
	$gateway->assign("LANG_CHECKOUT",$lang['front']['gateway']['continue']);
	$gateway->assign("LANG_CHOOSE_GATEWAY",$lang['front']['gateway']['choose_method']);
	
	$gatewayModules = $db->select("SELECT folder, `default` FROM ".$glob['dbprefix']."CubeCart_Modules WHERE module='gateway' AND status = 1");
	
	if($gatewayModules == TRUE) {
	
		$gateway->assign("LANG_COMMENTS",$lang['front']['gateway']['your_comments']);
	
		for($i=0; $i<count($gatewayModules); $i++){
			
			$gateway->assign("TD_CART_CLASS",cellColor($i, $tdEven="tdcartEven", $tdOdd="tdcartOdd"));

			$module = fetchDbConfig($gatewayModules[$i]['folder']);
		
			$gateway->assign("VAL_GATEWAY_DESC",$module['desc']);
			$gateway->assign("VAL_GATEWAY_FOLDER",$gatewayModules[$i]['folder']);
			
			if($gatewayModules[$i]['default'] == 1){
				$gateway->assign("VAL_CHECKED","checked='checked'");
			} else {
				$gateway->assign("VAL_CHECKED","");
			}
			
			$gateway->parse("gateway.cart_true.choose_gate.gateways_true");
		}
		if(isset($basket['customer_comments'])){
		$gateway->assign("VAL_CUSTOMER_COMMENTS",$basket['customer_comments']);
		} 
		$gateway->parse("gateway.cart_true.choose_gate");
	
	} else {
		$gateway->assign("LANG_GATEWAYS_FALSE",$lang['front']['gateway']['none_configured']);
		$gateway->parse("gateway.cart_true.choose_gate.gateways_flase");
		$gateway->parse("gateway.cart_true.choose_gate");
	}
	$gateway->parse("gateway.cart_true");

} else {

	$gateway->assign("LANG_CART_EMPTY","Your shopping cart is currently empty.");
	$gateway->parse("gateway.cart_false");

} 

$gateway->parse("gateway");
$page_content = $gateway->text("gateway");
?>
