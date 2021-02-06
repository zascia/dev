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
|	orderSuccess.inc.php
|   ========================================
|	Fulfill the order	
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) { 
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

$cart_order_id = treatGet($cart_order_id);

// get exchange rates etc
if(isset($cart_order_id) && !empty($cart_order_id)){
	// build thank you and confirmation email
	if (!isset($mail)) {
	include($glob['rootDir']."/classes/class.phpmailer.php");
		$mail = new PHPMailer();
	}
	
	// update order status to payment received
	$data['status'] = 2;
	$update = $db->update($glob['dbprefix']."CubeCart_order_sum", $data,"cart_order_id=".$db->mySQLSafe($cart_order_id));
	
	$query = "SELECT * FROM ".$glob['dbprefix']."CubeCart_order_sum INNER JOIN ".$glob['dbprefix']."CubeCart_customer ON ".$glob['dbprefix']."CubeCart_order_sum.customer_id = ".$glob['dbprefix']."CubeCart_customer.customer_id WHERE ".$glob['dbprefix']."CubeCart_order_sum.cart_order_id = ".$db->mySQLSafe($cart_order_id);
	
	$order = $db->select($query);

	//.: adg_coupon_mod http://www.alexgoldberg.com/cubemods :.
//.: This block of code is used when redeeming coupons :.
	$query = "UPDATE ".$glob['dbprefix']."CubeCart_adg_coupon_mod SET times_used = times_used + 1, coupon_updated = 1 WHERE coupon_code = ".$db->mySQLSafe($order[0]['coupon_code']);
	$update = $db->misc($query);
//.: adg_coupon_mod http://www.alexgoldberg.com/cubemods :.

	
	include_once($glob['rootDir']."/includes/currencyVars.inc.php");

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
	
	$text = sprintf($lang['front']['orderSuccess']['inv_email_body_1'],
				$order[0]['name'],
				$cart_order_id,
				formatTime($order[0]['time']),
				$order[0]['name'],
				priceFormat($order[0]['subtotal']),
				priceFormat($order[0]['coupon_savings']),
				priceFormat($order[0]['total_ship']),
				priceFormat($order[0]['total_tax']),
				priceFormat($order[0]['prod_total']),
				$discount_info,
				$order[0]['name'],
				$order[0]['add_1'],
				$order[0]['add_2'],
				$order[0]['town'],
				$order[0]['county'],
				$order[0]['postcode'],
				countryName($order[0]['country']),
				$order[0]['name_d'],
				$order[0]['add_1_d'],
				$order[0]['add_2_d'],
				$order[0]['town_d'],
				$order[0]['county_d'],
				$order[0]['postcode_d'],
				$order[0]['country_d'],
				str_replace("_"," ",$order[0]['gateway']),
				str_replace("_"," ",$order[0]['shipMethod']));
	
	if(!empty($order[0]['customer_comments'])){
		$text .= sprintf($lang['front']['orderSuccess']['inv_email_body_2'],
					$order[0]['customer_comments']);
	}
	
	$text .= $lang['front']['orderSuccess']['inv_email_body_3'];
	
	$products = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_order_inv WHERE cart_order_id = ".$db->mySQLSafe($cart_order_id));
	
	if($products==TRUE){
		// Start  Email template mod
		if (isset($prod)) {
			unset($prod);
		}
		$prod="";
		//End Email template mod
		for($i=0;$i<count($products); $i++){
		
			// if the product isn't digital we need to lower the stock if not done so already ;)
			$useStock = $db->select("SELECT useStockLevel FROM ".$glob['dbprefix']."CubeCart_inventory WHERE productId = ".$db->mySQLSafe($products[$i]['productId']));
			
			if($products[$i]['digital']==0  && $useStock[0]['useStockLevel']==1 && $products[$i]['stockUpdated']==0){
				
				$query = "UPDATE ".$glob['dbprefix']."CubeCart_inventory SET stock_level = stock_level - ".$products[$i]['quantity']." WHERE productId = ".$products[$i]['productId'];
				$update = $db->misc($query);
				
				$query = "UPDATE ".$glob['dbprefix']."CubeCart_order_inv SET stockUpdated =  1 WHERE productId = ".$products[$i]['productId']." AND  product_options = '".$products[$i]['product_options']."' AND cart_order_id = '".$products[$i]['cart_order_id']."'";
				$update = $db->misc($query);
			
			}
			//	Start Email template mod
			$prod .= $products[$i]['quantity']." x ".$products[$i]['name']." - ".priceFormat($products[$i]['price'])."<br />";
			if ($products[$i]['product_options'] != '') {
				$prod .= $products[$i]['product_options']."<br />";
			}
			//	 End Email template mod
		
			$text .= sprintf($lang['front']['orderSuccess']['inv_email_body_4'],
						$products[$i]['name']);
			
			if(!empty($products[$i]['product_options'])){
			$text .= sprintf($lang['front']['orderSuccess']['inv_email_body_5'],
						str_replace(array("\r","\n")," ",$products[$i]['product_options']));
			}
			
			
			
			$text .= sprintf($lang['front']['orderSuccess']['inv_email_body_6'],
						$products[$i]['quantity'],
						$products[$i]['productCode'],
						priceFormat($products[$i]['price']));
			
		
		}
	
	}
	
	if(isset($emailText) && !empty($emailText)) {
		$text .= sprintf($lang['front']['orderSuccess']['inv_email_body_7'],$emailText);
	}
	
	//Start Email Template mod
	$email_template = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_eMail WHERE enabled = 1 AND type = 'customer'");
	if ($email_template == TRUE) {
	
		$search = array(
			"{PROD_LIST}",
			"{TOTAL}",
			"{SHOP_OWNER}",
			"{ORDER_TIME}",
			"{SUBTOTAL}",
			"{COUPON}",
			"{SHIPPING}",
			"{TAX}",
			"{NAME}",
			"{ADDRESS1}",
			"{ADDRESS2}",
			"{TOWN}",
			"{COUNTY}",
			"{POSTCODE}",
			"{COUNTRY}",
			"{NAME_D}",
			"{ADDRESS1_D}",
			"{ADDRESS2_D}",
			"{TOWN_D}",
			"{COUNTY_D}",
			"{POSTCODE_D}",
			"{COUNTRY_D}",
			"{GATEWAY}",
			"{SHIP_METHOD}",
			"{COMMENTS}",
			"{CREDIT}"
		);
	
		$replace = array(
			$prod,
			priceFormat($order[0]['prod_total']),
			$config['masterName'],
			formatTime($order[0]['time']),
			priceFormat($order[0]['subtotal']),
			priceFormat($order[0]['coupon_savings']),
			priceFormat($order[0]['total_ship']),
			priceFormat($order[0]['total_tax']),
			$order[0]['name'],
			$order[0]['add_1'],
			$order[0]['add_2'],
			$order[0]['town'],
			$order[0]['county'],
			$order[0]['postcode'],
			countryName($order[0]['country']),
			$order[0]['name_d'],
			$order[0]['add_1_d'],
			$order[0]['add_2_d'],
			$order[0]['town_d'],
			$order[0]['county_d'],
			$order[0]['postcode_d'],
			$order[0]['country_d'],
			str_replace("_"," ",$order[0]['gateway']),
			str_replace("_"," ",$order[0]['shipMethod']),
			$order[0]['customer_comments'],
			priceFormat($order[0]['credit_used'])
		);
	
		$ebody = $email_template[0]['body'];
		$subject = str_replace("{ORDER_ID}", $cart_order_id, $email_template[0]['subject']);
		$ebody = str_replace($search, $replace, $ebody);
		include($glob['rootDir']."/includes/email_config.inc.php");
		$mail->From = $config['masterEmail'];
		$mail->FromName = $config['masterName'];
		$mail->AddAddress($order[0]['email'], $order[0]['name']);
		$mail->AddReplyTo($config['masterEmail'], $config['masterName']);
		$mail->WordWrap = 50;
		$mail->Subject = $subject;
		$mail->Body    = $ebody;
		$mail->Send();
	}
	//End Email template mod
	
	// Send Email To Access the Digital Download IF Applicable ;o)
	$digitalProducts = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_Downloads INNER JOIN ".$glob['dbprefix']."CubeCart_inventory ON ".$glob['dbprefix']."CubeCart_Downloads.productId =  ".$glob['dbprefix']."CubeCart_inventory.productId WHERE cart_order_id = ".$db->mySQLSafe($cart_order_id));
	
	if($digitalProducts == TRUE){
	// Out commented for Email template mod -- $mail = new htmlMimeMail();
	// build email with access details
	$text = sprintf($lang['front']['orderSuccess']['digi_email_body1'],
				$order[0]['name'],
				$cart_order_id,
				formatTime($order[0]['time']),
				formatTime($digitalProducts[0]['expire']),
				$config['dnLoadTimes']);
		
		for($i=0;$i<count($digitalProducts); $i++){
			$lnks .= '<a href="'.$glob['storeURL'].'/download.php?pid='.$digitalProducts[$i]['productId'].'&oid='.base64_encode($cart_order_id).'&ak='.$digitalProducts[$i]['accessKey'].'">'.$digitalProducts[$i]['name'].'</a><br />';
		}
		
		$email_template = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_eMail WHERE enabled = 1 AND type = 'digital'");
		if ($email_template == TRUE) {
			$search = array(
				"{NAME}",
				"{EXPIRE}",
				"{ATTEMPTS}",
				"{SHOP_OWNER}",
				"{LINKS}"
			);
			$replace = array(
				$order[0]['name'],
				formatTime($digitalProducts[0]['expire']),
				$config['dnLoadTimes'],
				$config['masterName'],
				$lnks
			);
			$ebody = $email_template[0]['body'];
			$subject = str_replace("{ORDER_ID}", $cart_order_id, $email_template[0]['subject']);
			$ebody = str_replace($search, $replace, $ebody);
			include($glob['rootDir']."/includes/email_config.inc.php");
			$mail->ClearAddresses();
			$mail->From = $config['masterEmail'];
			$mail->FromName = $config['masterName'];
			$mail->AddAddress($order[0]['email'], $order[0]['name']);
			$mail->AddReplyTo($config['masterEmail'], $config['masterName']);
			$mail->WordWrap = 50;
			$mail->Subject = $subject;
			$mail->Body    = $ebody;
			$mail->Send();
		}
	
	}
	// empty basket
	$emptyBasket['basket'] = "''";
	$where = "basket LIKE '%".$cart_order_id."%'";
	$delete = $db->update($glob['dbprefix']."CubeCart_sessions",$emptyBasket ,$where);
}
?>