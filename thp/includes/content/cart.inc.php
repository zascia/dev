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
|	cart.inc.php
|   ========================================
|	Core Checkout & Cart Pages	
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

// check the user is logged on
if(($_GET['act']=="step2" || $_GET['act']=="step3" || $_GET['act']=="step4") && $ccUserData[0]['customer_id']<1)
{
	header("Location: cart.php?act=step1");
	exit;
}

require_once("classes/cart.php");
$cart = new cart();
$basket = $cart->cartContents($ccUserData[0]['basket']);

// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
$cavs_config = fetchDbConfig("Shipping_And_Tax_Always_Visible");
// <-- Shipping & Tax Always Visible by convict
// Quick Checkout by convict http://cubecartmods.eu -->
$qch_config = fetchDbConfig("Quick_Checkout");

if ($qch_config['status']==1):

$gatewayModulesNo = $db->numrows("SELECT folder, `default` FROM ".$glob['dbprefix']."CubeCart_Modules WHERE module='gateway' AND status = 1");

if ($gatewayModulesNo != 1 && !isset($_POST['gateway']) && isset($basket['gateway']) && $basket['gateway'] != "Free") {
	$basket = $cart->unsetVar("gateway");
}

if($_GET['act']=="step2" || (!isset($_SESSION['qchShipE']) && $_GET['act']=="cart" && $ccUserData[0]['customer_id']>0)) {
	$basket = $cart->setVar(3,"currentStep");
	$basket = $cart->setVar(4,"stepLimit");
	if (!isset($basket['delInf']['county'])):
	$delInf['title'] = $ccUserData[0]['title'];
	$delInf['firstName'] = $ccUserData[0]['firstName'];
	$delInf['lastName'] = $ccUserData[0]['lastName'];
	$delInf['add_1'] = $ccUserData[0]['add_1'];
	$delInf['add_2'] = $ccUserData[0]['add_2'];
	$delInf['town'] = $ccUserData[0]['town'];
	$delInf['county'] = $ccUserData[0]['county'];
	$delInf['postcode'] = $ccUserData[0]['postcode'];
	$delInf['country'] = $ccUserData[0]['country'];    
	$basket = $cart->setVar($delInf,"delInf");
	endif;
	header("Location: cart.php?act=step4");
	exit;
}

if (isset($_POST['customer_comments'])) {
	$basket = $cart->setVar($_POST['customer_comments'],"customer_comments");
}

if (isset($_POST['gateway']) && !empty($_POST['gateway'])) {	
	$basket = $cart->setVar($_POST["gateway"],"gateway");	
}

if (isset($basket['gateway']) && !empty($basket['gateway']) && isset($_POST['quick_checkout']) && $_POST['quick_checkout']==1) {
	header("Location: cart.php?act=step5");
	exit;
}
endif;
// <-- Quick Checkout by convict

//////////////////////////////////////////////////////
// SO: FIX TO MAKE SURE BASKET FLOW PROCESS IS CORRECT
//////////////////////////////////////////////////////

if($_GET['act']=="cart") {
   
    $basket = $cart->setVar(1,"currentStep");
    $basket = $cart->setVar(2,"stepLimit");
   
} if($_GET['act']=="step2") {

    if(isset($basket['stepLimit']) && $basket['stepLimit']<2) {
        header("Location: cart.php?act=step".$basket['currentStep']);
        exit;
    }
    $basket = $cart->setVar(2,"currentStep");
    $basket = $cart->setVar(3,"stepLimit");

} elseif($_GET['act']=="step3") {

    if(isset($basket['stepLimit']) && $basket['stepLimit']<3) {
        header("Location: cart.php?act=step".$basket['currentStep']);
        exit;
    }
    $basket = $cart->setVar(3,"currentStep");
    $basket = $cart->setVar(4,"stepLimit");
   
} elseif($_GET['act']=="step4") {

    if(isset($basket['stepLimit']) && $basket['stepLimit']<4){
        header("Location: cart.php?act=step".$basket['currentStep']);
        exit;
    }
    $basket = $cart->setVar(4,"currentStep");
    $basket = $cart->setVar(5,"stepLimit");
   
}

//////////////////////////////////////////////////////
// EO: FIX TO MAKE SURE BASKET FLOW PROCESS IS CORRECT
//////////////////////////////////////////////////////


if(isset($_POST['shipping'])){

	$basket = $cart->setVar(sprintf("%.2f",$_POST['shipping']),"shipCost");
	// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
	if (empty($cavs_config['status']) || ($cavs_config['status'] && $cavs_config['ship'] && $_GET['act']=="step3")):
	// <-- Shipping & Tax Always Visible by convict
	$headerLoc = "step4";
// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
	endif;

//} elseif(isset($_POST['delInf'])){ // commented orriginal
}
if(isset($_POST['delInf'])){
// <-- Shipping & Tax Always Visible by convict
	
	$basket = $cart->setVar($_POST['delInf'],"delInf");
	$headerLoc = "step4";
	
}

function headerRedir() {

	global $headerLoc;

	if(isset($headerLoc) && !empty($headerLoc)) {
		
		header("Location: cart.php?act=".$headerLoc);
	
	} elseif(isset($_GET['act']) && !empty($_GET['act'])){
		
		header("Location: cart.php?act=".$_GET['act']);
	
	} else {
		
		header("Location: cart.php?act=step2");
	
	}
	exit;

}

if(isset($_GET['remove'])){
	
	$basket = $cart->unsetVar("invArray");
	$basket = $cart->remove($_GET['remove']);
	headerRedir();
	
} elseif(isset($_POST['quan'])){

	$basket = $cart->unsetVar("invArray");
	
	foreach($_POST['quan'] as $key => $value){
		
		$basket = $cart->update($key,$value);

	}

	// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
	// Quick Checkout by convict http://cubecartmods.eu -->
	if (($cavs_config['status'] && $cavs_config['ship']) || $qch_config['status']):
	if(isset($_POST['shipping']) && $_POST['shipping']>0) {$basket = $cart->setVar($_POST['shipping'],"shipKey");}
	endif;
	// <-- Quick Checkout by convict
	// <-- Shipping & Tax Always Visible by convict

	
	headerRedir();

} elseif(isset($_GET['mode']) && $_GET['mode']=="emptyCart"){
	
	$basket = $cart->emptyCart();
	
	headerRedir();

} elseif(isset($_POST['productCode']) && !empty($_POST['productCode'])) {
	
	$result = $db->select("SELECT productId FROM ".$glob['dbprefix']."CubeCart_inventory WHERE productCode = ".$db->mySQLSafe($_POST['productCode']));
	
	if($result == TRUE) {
		
		// check for product options (if so go to view product page)
		$noOpts = $db->numrows("SELECT product FROM ".$glob['dbprefix']."CubeCart_options_bot WHERE product = ".$db->mySQLSafe($result[0]['productId']));
		
		if($noOpts>0){
		
			header("Location: index.php?act=viewProd&productId=".$result[0]['productId']);
			exit;
		
		} else {
			$basket = $cart->add($result[0]['productId'],1,"");
			headerRedir();
		
		}
	
	}

}
// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
elseif ($headerLoc) {
	headerRedir();
}
// <-- Shipping & Tax Always Visible by convict
$view_cart = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/content/cart.tpl");
$view_cart->assign("VAL_SKIN",$config['skinDir']);
$view_cart->assign("LANG_VIEW_CART",$lang['front']['cart']['view_cart']);
$view_cart->assign("LANG_CART",$lang['front']['cart']['cart']);
$view_cart->assign("LANG_ADDRESS",$lang['front']['cart']['address']);
$view_cart->assign("LANG_PAYMENT",$lang['front']['cart']['payment']);
$view_cart->assign("LANG_COMPLETE",$lang['front']['cart']['complete']);
$view_cart->assign("LANG_ADD_PRODCODE",$lang['front']['cart']['add_more']);
$view_cart->assign("LANG_ADD",$lang['front']['cart']['add']);
$view_cart->assign("LANG_QTY",$lang['front']['cart']['qty']);
$view_cart->assign("LANG_PRODUCT",$lang['front']['cart']['product']);
$view_cart->assign("LANG_CODE",$lang['front']['cart']['code']);
$view_cart->assign("LANG_STOCK",$lang['front']['cart']['stock']);
$view_cart->assign("LANG_PRICE",$lang['front']['cart']['price']);
$view_cart->assign("LANG_LINE_PRICE",$lang['front']['cart']['line_price']);
$view_cart->assign("LANG_DELETE",$lang['front']['cart']['delete']);
$view_cart->assign("LANG_REMOVE_ITEM",$lang['front']['cart']['remove']);

if($_GET['act']=="cart"){
	$view_cart->assign("CLASS_STEP2","class='txtcartProgressCurrent'");
	$view_cart->assign("CONT_VAL","cart.php?act=step1");

} elseif($_GET['act']=="step2"){
	
	$view_cart->assign("CLASS_STEP2","class='txtcartProgressCurrent'");
	$view_cart->assign("CONT_VAL","cart.php?act=step3");

} elseif($_GET['act']=="step3" OR $_GET['act']=="step4"){

	$view_cart->assign("CLASS_STEP3","class='txtcartProgressCurrent'");
	
	$view_cart->assign("LANG_INVOICE_ADDRESS",$lang['front']['cart']['invoice_address']);
	$view_cart->assign("LANG_DELIVERY_ADDRESS",$lang['front']['cart']['delivery_address']);
	
	$view_cart->assign("TXT_TITLE",$lang['front']['cart']['title']);
	$view_cart->assign("TXT_FIRST_NAME",$lang['front']['cart']['first_name']);
	$view_cart->assign("TXT_LAST_NAME",$lang['front']['cart']['last_name']);
	$view_cart->assign("TXT_ADD_1",$lang['front']['cart']['address2']);
	$view_cart->assign("TXT_ADD_2","");
	$view_cart->assign("TXT_TOWN",$lang['front']['cart']['town']);
	$view_cart->assign("TXT_COUNTY",$lang['front']['cart']['county']);
	$view_cart->assign("TXT_POSTCODE",$lang['front']['cart']['postcode']);
	$view_cart->assign("TXT_COUNTRY",$lang['front']['cart']['country']);
	
	// stick in delivery details
	
	// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
//	if(isset($basket['delInf'])){
	if(isset($basket['delInf']) && (($cavs_config['status'] && $cavs_config['ship'] && isset($basket['delInf']['county'])) || empty($cavs_config['status']))){
	// <-- Shipping & Tax Always Visible by convict
		
		$view_cart->assign("VAL_DEL_TITLE",$basket['delInf']['title']);
		$view_cart->assign("VAL_DEL_FIRST_NAME",$basket['delInf']['firstName']);
		$view_cart->assign("VAL_DEL_LAST_NAME",$basket['delInf']['lastName']);
		$view_cart->assign("VAL_DEL_ADD_1",$basket['delInf']['add_1']);
		$view_cart->assign("VAL_DEL_ADD_2",$basket['delInf']['add_2']);
		$view_cart->assign("VAL_DEL_TOWN",$basket['delInf']['town']);
		$view_cart->assign("VAL_DEL_COUNTY",$basket['delInf']['county']);
		$view_cart->assign("VAL_DEL_POSTCODE",$basket['delInf']['postcode']);
		$view_cart->assign("VAL_DEL_COUNTRY",countryName($basket['delInf']['country']));
	
	} else {
	
		$view_cart->assign("VAL_DEL_TITLE",$ccUserData[0]['title']);
		$view_cart->assign("VAL_DEL_FIRST_NAME",$ccUserData[0]['firstName']);
		$view_cart->assign("VAL_DEL_LAST_NAME",$ccUserData[0]['lastName']);
		$view_cart->assign("VAL_DEL_ADD_1",$ccUserData[0]['add_1']);
		$view_cart->assign("VAL_DEL_ADD_2",$ccUserData[0]['add_2']);
		$view_cart->assign("VAL_DEL_TOWN",$ccUserData[0]['town']);
		$view_cart->assign("VAL_DEL_COUNTY",$ccUserData[0]['county']);
		$view_cart->assign("VAL_DEL_POSTCODE",$ccUserData[0]['postcode']);
		$view_cart->assign("VAL_DEL_COUNTRY",countryName($ccUserData[0]['country']));
	
	} 

	// stick in invoice details
	$view_cart->assign("VAL_TITLE",$ccUserData[0]['title']);
	$view_cart->assign("VAL_FIRST_NAME",$ccUserData[0]['firstName']);
	$view_cart->assign("VAL_LAST_NAME",$ccUserData[0]['lastName']);
	$view_cart->assign("VAL_ADD_1",$ccUserData[0]['add_1']);
	$view_cart->assign("VAL_ADD_2",$ccUserData[0]['add_2']);
	$view_cart->assign("VAL_TOWN",$ccUserData[0]['town']);
	$view_cart->assign("VAL_COUNTY",$ccUserData[0]['county']);
	$view_cart->assign("VAL_POSTCODE",$ccUserData[0]['postcode']);
	$view_cart->assign("VAL_COUNTRY",countryName($ccUserData[0]['country']));
	
	//$view_cart->assign("LANG_CHANGE_INV_ADD",$lang['front']['cart']['edit_invoice_address']);
	$result = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_customer WHERE customer_id = ".$ccUserData[0]['customer_id']." and mobile='8888888888'");

if($result <> TRUE) {
$view_cart->assign("LANG_CHANGE_INV_ADD",$lang['front']['cart']['edit_invoice_address']);
	$view_cart->assign("VAL_BACK_TO",$_GET['act']);
	$view_cart->assign("CLASSED","txtUpdate");
	$view_cart->parse("view_cart.cart_true.step_3.change_invoice");
	$view_cart->parse("view_cart.cart_true.step_4.change_invoice");
}
	$view_cart->assign("VAL_BACK_TO",$_GET['act']);

} 

if($_GET['act']=="step3") {

	
	if($config['shipAddressLock'] == 1){
	
		$delInf['title'] = $ccUserData[0]['title'];
		$delInf['firstName'] = $ccUserData[0]['firstName'];
		$delInf['lastName'] = $ccUserData[0]['lastName'];
		$delInf['add_1'] = $ccUserData[0]['add_1'];
		$delInf['add_2'] = $ccUserData[0]['add_2'];
		$delInf['town'] = $ccUserData[0]['town'];
		$delInf['county'] = $ccUserData[0]['county'];
		$delInf['postcode'] = $ccUserData[0]['postcode'];
		$delInf['country'] = $ccUserData[0]['country'];
		
		$basket = $cart->setVar($delInf,"delInf");
		header("Location: cart.php?act=step4");
		exit;
	
	}
	
	
	$view_cart->assign("CONT_VAL","javascript:submitDoc('cart');");
	
	$countries = $db->select("SELECT id, printable_name FROM ".$glob['dbprefix']."CubeCart_iso_countries ORDER BY printable_name"); 

	for($i=0; $i<count($countries); $i++){

		
			if(($countries[$i]['id'] == $basket['delInf']['country']) || ($countries[$i]['id']==$ccUserData[0]['country'] && !isset($basket['delInf']['country']))){
				
				$view_cart->assign("COUNTRY_SELECTED","selected='selected'");
			
			} else {
				
				$view_cart->assign("COUNTRY_SELECTED","");
			
			}
		
			$view_cart->assign("VAL_DEL_COUNTRY_ID",$countries[$i]['id']);
	
			$countryName = "";
			$countryName = $countries[$i]['printable_name'];
	
			if(strlen($countryName)>20){
	
				$countryName = substr($countryName,0,20)."&hellip;";
	
			}
	
			$view_cart->assign("VAL_DEL_COUNTRY_NAME",$countryName);
			
			$view_cart->parse("view_cart.cart_true.step_3.country_opts");
		
		}
	
		$view_cart->parse("view_cart.cart_true.step_3");
	
	

} elseif($_GET['act']=="step4") {

	if($config['shipAddressLock'] == 0){
	
	$view_cart->assign("LANG_CHANGE_DEL_ADD",$lang['front']['cart']['edit_delivery_address']);
	$view_cart->parse("view_cart.cart_true.step_4.edit_btn");
	
	}
	$view_cart->assign("CONT_VAL","cart.php?act=step5");
	
	$view_cart->parse("view_cart.cart_true.step_4");

}
// Quick Checkout by convict http://cubecartmods.eu -->
# v1.6
if($qch_config['status']) {
	if ($_GET['act']=="cart") {
		$qchc_step = $qch_config['direct_reg'] ? 11 : 1;
		$view_cart->assign("CONT_VAL","javascript:submitQ($qchc_step)");
	}
	$view_cart->parse("view_cart.cart_true.quick_checkout_def");
}
// Quick Checkout by convict <--

if($basket['conts'] == TRUE) {

//.: coupon code :.
	// if coupons are enabled we need to work them out :)
	$coupon_module = fetchDbConfig("Coupon_Manager");
	$coupon_manager = $coupon_module['status'];
	if ($coupon_manager) {
		unset($coupon_error);
		if (isset($_POST['coupon_code'])) {
			$coupon_code = $_POST['coupon_code'];
		} elseif (isset($basket['coupon_code'])) {
			$coupon_code = $basket['coupon_code'];
		#:convict:# >>
		} elseif (isset($_COOKIE['coupon_code'])) {
			$coupon_code = base64_decode($_COOKIE['coupon_code']); $c_coupon = true;
		#:convict:# <<
		} else {
			$coupon_code = FALSE;
		}
		//echo $coupon_code;
		if ($coupon_code) {
			$query = "SELECT * FROM ".$glob['dbprefix']."CubeCart_adg_coupon_mod WHERE coupon_code=".$db->mySQLSafe($coupon_code);
			$coupon_info = $db->select($query);
			if ($coupon_info[0]['per_customer'] ==1) {
				$use_query = "SELECT * FROM ".$glob['dbprefix']."CubeCart_order_sum	WHERE coupon_code =	".$db->mySQLSafe($coupon_code)." AND customer_id = ".$db->mySQLSafe($ccUserData[0]['customer_id']);
				$use_info = $db->select($use_query);
				if ($use_info == TRUE){
					$code_now = "error";
					$coupon_error = $lang['mods']['adg_coupon_mod']['per_customer_limit'];
					$coupon_info[0]['type'] = "error";
				}
				if ($ccUserData[0]['customer_id']==0){
					$code_now = "error";
					$coupon_error = $lang['mods']['adg_coupon_mod']['must_register_first'];
					$coupon_info[0]['type'] = "error";
				}
			}
			if ($coupon_info) {
				if ($coupon_info[0]['coupon_status']==0) {$coupon_error = $lang['front']['cart']['coupon_code_expired'];};
				if ($coupon_info[0]['end_date'] != "0000-00-00"){
					$cp_date = strtotime($coupon_info[0]['end_date']);
					if(strtotime($coupon_info[0]['end_date']) < strtotime(date(ymd))) {$coupon_error = $lang['front']['cart']['coupon_code_expired'];}
				}
				if ($coupon_info[0]['times_used']>=$coupon_info[0]['max_times']	&& $coupon_info[0]['max_times'] !=0) {$coupon_error = $lang['front']['cart']['coupon_code_expired'];};
				if(!isset($coupon_error)){
					$basket = $cart->unsetVar("coupon_code");
					$basket = $cart->setVar($coupon_code,"coupon_code");
					$basket = $cart->setVar($coupon_info[0]['coupon_code'],"coupon_code");
					$basket = $cart->setVar($coupon_info[0]['use_method'],"use_method");
					$basket = $cart->setVar($coupon_info[0]['discount_method'],"discount_method");
					$basket = $cart->setVar($coupon_info[0]['discount_amount'],"discount_amount");
					$basket = $cart->setVar($coupon_info[0]['productCode'],"productCode");
					$basket = $cart->setVar($coupon_info[0]['discount_percent'],"discount_percent");
					$basket = $cart->setVar($coupon_info[0]['percent'],"percent");
					$basket = $cart->setVar($coupon_info[0]['order_limit'],"order_limit");
					$basket = $cart->setVar($coupon_info[0]['order_limit_amount'],"order_limit_amount");
					#:convict:# >>
					if ($c_coupon) @setcookie("coupon_code", "" ,time()-108000, $GLOBALS['rootRel']);
					#:convict:# <<
				} else {
					$basket = $cart->setVar($coupon_code,"coupon_code");
					$basket = $cart->unsetVar("coupon_code");
					$coupon_code = FALSE;
	
				}
			} else {
					$basket = $cart->setVar($coupon_code,"coupon_code");
					$basket = $cart->unsetVar("coupon_code");
					$coupon_code = FALSE;
					#:convict:# >>
					if (!$c_coupon)
					#:convict:# <<
					$coupon_error = $lang['front']['cart']['coupon_code_not_valid'];
			}
		}
	}
	//.: coupon code :.



	$tax = 0;
	$taxCustomer = 0;
	// work out if customer is obliged to pay tax or not
	// EU members ISO country codes
	$isoEUmembers = "AT,BE,BG,CZ,CY,DE,DK,EE,ES,FI,FR,GB,GR,HU,IE,IT,LV,LT,LU,MT,NL,PL,PT,RO,SE,SI,SK";

	if(stristr($isoEUmembers,countryIso($ccUserData[0]['country'])) !== FALSE) {
		$taxCustomer = 1;
	}
	
	$totalWeight = "";
	$i = 0;
	$subTotal = 0;
	$shipCost = 0;
	$grandTotal = 0;
	
	foreach($basket['conts'] as $key => $value){
		
		$i++;
		$productId = $cart->getProductId($key);
		// get product details
		
		// if shipping by category is enabled we need to get the values too
		$module = fetchDbConfig("Per_Category");
		$shipByCat = $module['status'];
		
		$extraJoin = "";
		
		// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
		//if($shipByCat==1 && $_GET['act']=="step4"){
		if($shipByCat==1 && (($cavs_config['status'] && $cavs_config['ship']) || ((!$cavs_config['status'] || $cavs_config['status'] && !$cavs_config['ship']) && $_GET['act']=="step4"))){
		// <-- Shipping & Tax Always Visible by convict
			$extraJoin = "INNER JOIN ".$glob['dbprefix']."CubeCart_category ON ".$glob['dbprefix']."CubeCart_inventory.cat_id = ".$glob['dbprefix']."CubeCart_category.cat_id";
		}
		
		$product = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_inventory INNER JOIN ".$glob['dbprefix']."CubeCart_taxes ON ".$glob['dbprefix']."CubeCart_taxes.id = taxType ".$extraJoin." WHERE productId=".$db->mySQLSafe($productId));
		
		// FIX FOR DELETED TAX BANDS PRE 3.0.5
		if($product == FALSE){
		
			$product = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_inventory WHERE productId=".$db->mySQLSafe($productId));
			$product[0]['percent'] = 0;
		
		}
		
		if(($val = prodAltLang($product[0]['productId'])) == TRUE){
			
			$product[0]['name'] = $val['name'];
		
		}
	
		$view_cart->assign("TD_CART_CLASS",cellColor($i, $tdEven="tdcartEven", $tdOdd="tdcartOdd"));

		$view_cart->assign("VAL_PRODUCT_ID",$productId);
		$view_cart->assign("VAL_CURRENT_STEP",$_GET['act']);
		$view_cart->assign("VAL_PRODUCT_KEY",$key);
		
		if(empty($product[0]["image"])){
			
			$view_cart->assign("VAL_IMG_SRC","skins/".$config['skinDir']."/styleImages/thumb_nophoto.gif");
		
		} else {
		
			$view_cart->assign("VAL_IMG_SRC","images/uploads/thumbs/thumb_".$product[0]["image"]);
		
		}
		
		
		// only calculate shipping IF the product is tangible
		if($product[0]["digital"]==0){
			$orderTangible = TRUE;
		}
		
		$view_cart->assign("VAL_PRODUCT_NAME",validHTML($product[0]["name"]));
		$view_cart->assign("VAL_PRODUCT_CODE",$product[0]["productCode"]);  
		

		// start mod: Product Description on Checkout Pages
		if (strlen($product[0]['description'])>$config['productPrecis']) {
			$view_cart->assign("VAL_PRODUCT_INFO",substr(strip_tags($product[0]['description']),0,$config['productPrecis'])."&hellip;");

		} else {

			$view_cart->assign("VAL_PRODUCT_INFO",substr(strip_tags($product[0]['description']),0,$config['productPrecis']));
		}
		// end mod: Product Description on Checkout Pages


		// build the product options
		$optionKeys = $cart->getOptions($key);
		
		$optionsCost = 0;
		$plainOpts = "";
		
		if(!empty($optionKeys)){
		
			$options = explode("|",$optionKeys);
			
			foreach($options as $value)
			{
				// look up options in database
				$option = $db->select("SELECT ".$glob['dbprefix']."CubeCart_options_bot.option_id, ".$glob['dbprefix']."CubeCart_options_bot.value_id, option_price, option_symbol, value_name, option_name, assign_id FROM `".$glob['dbprefix']."CubeCart_options_bot` INNER JOIN `".$glob['dbprefix']."CubeCart_options_mid` ON ".$glob['dbprefix']."CubeCart_options_mid.value_id = ".$glob['dbprefix']."CubeCart_options_bot.value_id INNER JOIN `".$glob['dbprefix']."CubeCart_options_top` ON ".$glob['dbprefix']."CubeCart_options_bot.option_id = ".$glob['dbprefix']."CubeCart_options_top.option_id WHERE assign_id = ".$db->mySQLSafe($value));
				 
				$view_cart->assign("VAL_OPT_NAME",validHTML($option[0]['option_name']));
				$view_cart->assign("VAL_OPT_VALUE",$option[0]['value_name']);
				
				$plainOpts .= $option[0]['option_name']." - ".$option[0]['value_name']."\r\n";
				
				if($option[0]['option_price']>0){ 
					
					if($option[0]['option_symbol']=="+"){
				
						$optionsCost = $optionsCost + $option[0]['option_price'];
			
					} elseif($option[0]['option_symbol']=="-"){
			
						$optionsCost = $optionsCost - $option[0]['option_price'];
			
					} elseif($option[0]['option_symbol']=="~"){
					
						$optionsCost = 0;
					
					}
					
				}
				$view_cart->parse("view_cart.cart_true.repeat_cart_contents.options");
			}
			
		}
	
		if($product[0]["useStockLevel"]==1 && $config['stockLevel']==1){
			
			$view_cart->assign("VAL_INSTOCK",$product[0]["stock_level"]);
		
		} else {
		
			$view_cart->assign("VAL_INSTOCK","&infin;");
		
		}
		
		if(($config['outofstockPurchase']==1) && ($product[0]["stock_level"]<$cart->cartArray['conts'][$key]["quantity"]) && ($product[0]["useStockLevel"]==1)) {
		
			$view_cart->assign("VAL_STOCK_WARN",$lang['front']['cart']['stock_warn']);
			
			$quantity = $cart->cartArray['conts'][$key]["quantity"];
			$view_cart->parse("view_cart.repeat_cart_contents.stock_warn");
		
		} elseif(($config['outofstockPurchase']==0) && ($product[0]["stock_level"]<$cart->cartArray['conts'][$key]["quantity"]) && ($product[0]["useStockLevel"]==1)) {
		
			$view_cart->assign("VAL_STOCK_WARN",$lang['front']['cart']['amount_capped']." ".$product[0]["stock_level"].".");
			
			$quantity = $product[0]["stock_level"];
			
			$basket = $cart->update($key,$quantity);
			
			$view_cart->parse("view_cart.cart_true.repeat_cart_contents.stock_warn");
		
		} else {
			
			$quantity = $cart->cartArray['conts'][$key]["quantity"];
		
		}
		
		$view_cart->assign("VAL_QUANTITY",$quantity);
		//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
		include("includes/goobermods/Group_Discounts/mod_part1.php");
		//.: Group Discounts Mod by Goober
		
		if(salePrice($product[0]['price'], $product[0]['sale_price'])==FALSE){
			
			$price = $product[0]['price'];
		
		} else {
			
			$price = salePrice($product[0]['price'], $product[0]['sale_price']);
		
		}
		
		$price = $price + ($optionsCost);
		
		if(isset($_GET['act']) && $_GET['act']!=="step4"){
			$view_cart->assign("TEXT_BOX_CLASS","textbox");
		}
		
		if(isset($_GET['act']) && $_GET['act']=="step4"){
			// set live vars for order inv and its the last step
			// Quick Checkout by convict http://cubecartmods.eu -->
			if ($qch_config['status']==1){
				$view_cart->assign("TEXT_BOX_CLASS","textbox");
			} else {
				$view_cart->assign("QUAN_DISABLED","disabled");
				$view_cart->assign("TEXT_BOX_CLASS","textboxDisabled");
			}
			// <-- Quick Checkout by convict

			$basket = $cart->setVar($productId,"productId","invArray",$i);
			$basket = $cart->setVar($product[0]['name'],"name","invArray",$i);
			$basket = $cart->setVar($product[0]['productCode'],"productCode","invArray",$i);
			$basket = $cart->setVar($plainOpts,"prodOptions","invArray",$i);
			$basket = $cart->setVar(sprintf("%.2f",$price*$quantity),"price","invArray",$i);
			$basket = $cart->setVar($quantity,"quantity","invArray",$i);
			$basket = $cart->setVar($product[0]['digital'],"digital","invArray",$i);
		//}  else { // commented by convict due to Coupon mod
		//	$basket = $cart->unsetVar("invArray"); // commented by convict due to Coupon mod
		}
		
		$view_cart->assign("VAL_IND_PRICE",priceFormat($price));
		
		$view_cart->assign("VAL_LINE_PRICE",priceFormat($price*$quantity));

//.: coupon code :.
		if ($coupon_manager) {
			if (isset($basket['coupon_code'])) {
				if (($coupon_info[0]['use_method'] == 1) 
				&& ($product[0]['productCode'] == $coupon_info[0]['productCode'])) { //individual item coupon
					if ($coupon_info[0]['discount_method'] == 1) {
						$coupon_savings     = $coupon_info[0]['discount_amount'];
						$coupon_savings_tax = $coupon_info[0]['discount_amount'] * ($coupon_info[0]['percent'] / 100);
						$tax = $tax - $coupon_savings_tax;
					} else {
						$coupon_savings = $price * ($coupon_info[0]['discount_percent'] / 100);
						$coupon_savings_tax = $coupon_info[0]['discount_amount'] * ($coupon_info[0]['percent'] / 100);
						$tax = $tax - $coupon_savings_tax;
					}
					$coupon_savings = $coupon_savings * $quantity;
					if ($coupon_savings > $price) {$coupon_savings = $price;} 
					if ($coupon_savings >0) {
						$view_cart->assign("LANG_COUPON",$lang['front']['cart']['coupon']);
						$view_cart->assign("VAL_COUPON",$basket['coupon_code']);
						$view_cart->assign("VAL_COUPON_SAVING","-".priceFormat($coupon_savings));
						$view_cart->parse("view_cart.cart_true.coupon");
					}
				}
			}
		}
		//.: coupon code :.


		
		// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
		//if($shipByCat==1 && $_GET['act']=="step4"){
		if($shipByCat==1 && (($cavs_config['status'] && $cavs_config['ship']) || ((!$cavs_config['status'] || $cavs_config['status'] && !$cavs_config['ship']) && $_GET['act']=="step4"))){
			if ($cavs_config['status'] && $cavs_config['ship'] && !isset($basket['delInf']['country'])) {
				$delInf['country'] = $cavs_config['default_country'];
				$basket = $cart->setVar($delInf,"delInf");
			}
		// <-- Shipping & Tax Always Visible by convict
			// calculate the line category shipping price
			include("modules/shipping/Per_Category/line.inc.php");
		
		}
		
		$subTotal = $subTotal + ($price * $quantity);
		
		$view_cart->parse("view_cart.cart_true.repeat_cart_contents");
		
		// work out weight
		if($product[0]['prodWeight']>0 && $product[0]['digital']==0){
		
		$totalWeight = ($product[0]['prodWeight'] * $quantity) + $totalWeight;
		
		}
		
		// work out tax
		// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
		// if($config['priceIncTax']==0 && $taxCustomer==1){
		if(((empty($cavs_config['status']) || ($cavs_config['status'] && empty($cavs_config['tax']))) && $config['priceIncTax']==0 && $taxCustomer==1) || ($cavs_config['status'] && $cavs_config['tax'] && $config['priceIncTax']==0)) {
		// <-- Shipping & Tax Always Visible by convict
			$lineTax = ($product[0]['percent'] / 100) * ($price * $quantity);
			$tax = $tax + $lineTax;
		}
		// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
		elseif ($cavs_config['status'] && $cavs_config['tax'] && $config['priceIncTax']==1) {
			$lineTax = ($price - ($price / (1 + ($product[0]['percent'])/100))) * $quantity;
			$tax = $tax + $lineTax;
		}
		// <-- Shipping & Tax Always Visible by convict

	}

	// calculate shipping when we have reached step4 or over
	// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
	//if($_GET['act']=="step4" && $orderTangible==TRUE) {
	if($orderTangible==TRUE && (($cavs_config['status'] && $cavs_config['ship']) || ((!$cavs_config['status'] || $cavs_config['status'] && !$cavs_config['ship']) && $_GET['act']=="step4"))) {
		if ($cavs_config['status'] && $cavs_config['ship'] && !isset($basket['delInf']['country'])) {
			$delInf['country'] = $cavs_config['default_country'];
			$basket = $cart->setVar($delInf,"delInf");
		}
	    // <-- Shipping & Tax Always Visible by convict


		$shippingModules = $db->select("SELECT folder FROM ".$glob['dbprefix']."CubeCart_Modules WHERE module='shipping' AND status = 1");
		
		$noItems = $cart->noItems();
		$sum = 0;

		//Free freight mod start **************
		$offerFreeShipping = FALSE;
		if($config['offerFreeShipping'] <> 0 && $subTotal > $config['offerFreeShipping']) {
			$offerFreeShipping = TRUE;
		}
		//Free freight mod end ****************

		if($shippingModules == TRUE && $offerFreeShipping == FALSE){

			$shippingPrice = "<select name='shipping' onchange=\"submitDoc('cart');\">";
			
			$shipKey = 0;
			
			// if selected key has not been set, set it 
			if(isset($_GET['s']) && $_GET['s']==1) {
			
				$basket = $cart->setVar(1,"shipKey");
			
			} elseif(isset($_POST['shipping']) && $_POST['shipping']>0) {
			
				$basket = $cart->setVar($_POST['shipping'],"shipKey");
			
			} elseif(!isset($basket['shipKey'])) {
			
				$basket = $cart->setVar(1,"shipKey");
			
			}
			
			for($i=0; $i<count($shippingModules); $i++){
				
				$shipKey++;
				// Bug fix for missing default shipping by convict -->
				if (strpos($shippingPrice,"selected")===FALSE && $basket['shipKey']<$shipKey) {
				$basket = $cart->setVar($shipKey,"shipKey");
				}
				// <-- Bug fix for missing default shipping by convict
				include("modules/shipping/".$shippingModules[$i]['folder']."/calc.php");
			
			}
		
			$shippingPrice .= "</select>";
			// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
			if($cavs_config['status'] && $cavs_config['only_country'] && $cavs_config['default_country'] && $basket['delInf']['country']!=$cavs_config['default_country']) {
				$shippingAvailable=FALSE;
				if ($cavs_config['ship']) {$basket = $cart->emptyCart();} // empty the cart
			}
			// <-- Shipping & Tax Always Visible by convict
			
			// if no shipping method is available go to error page
			if($shippingAvailable!==TRUE && $overWeight == TRUE){
				// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
				if($cavs_config['status'] && $cavs_config['ship']){$basket = $cart->emptyCart();} // empty the cart
				// <-- Shipping & Tax Always Visible by convict

				header("Location: cart.php?act=overWeight");
				exit;
			
			// if no shipping is available show error
			} elseif($shippingAvailable!==TRUE){
			
				header("Location: cart.php?act=noShip");
				exit;
			
			}
			
			// if shipping key is greater than those available redirect and set to 1!!
			if($basket['shipKey']>$shipKey){
				header("Location: cart.php?act=step4&s=1");
				exit;
			}
			

		} else {
			
			$shippingPrice .= "<select name='shipping' onchange=\"submitDoc('cart');\">\r\n<option value='0.00'>".$lang['front']['cart']['free_shipping']."</option>\r\n</select>";
			$basket = $cart->setVar($lang['front']['cart']['free_shipping'],"shipMethod");
		
		}

	} else {

		$shippingPrice = $lang['front']['cart']['na'];
		// Bug fix for incorrect total by Estelle - reset shipping cost
 		$basket = $cart->setVar(0.00,"shipCost");

	}
	
	$view_cart->assign("LANG_SHIPPING",$lang['front']['cart']['shipping']);
	// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
	if ($cavs_config['status'] && count($shippingModules) == 1 && $shipKey == 2){
		//preg_match("/.*selected='selected'>(.*)<\/option>/i", $shippingPrice, $matches);
		@ereg(".*selected='selected'>(.*)<\/option>", $shippingPrice, $matches);
		$shippingPrice = str_replace(" ","&nbsp;",$matches[1]);
	}
	// <-- Shipping & Tax Always Visible by convict
	$view_cart->assign("VAL_SHIPPING",$shippingPrice);
	// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
	if($cavs_config['status'] && $cavs_config['tax'] && $config['priceIncTax']==1) {

	$view_cart->assign("LANG_TAX",$lang['front']['cart']['tax2']);

	} else {
	// <-- Shipping & Tax Always Visible by convict

	$view_cart->assign("LANG_TAX",$lang['front']['cart']['tax']);

	// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
	}
	// <-- Shipping & Tax Always Visible by convict
	//.: coupon code :.
	if ($coupon_manager) {
		if (isset($coupon_error)) { $view_cart->assign("LANG_ERROR_COUPONCODE","<font color=red>".$coupon_error."</font><br />");}
			if ($basket['order_limit'] == 1 && $basket['order_limit_amount'] > $subTotal) {
					$code_now = "error";
					$coupon_error = sprintf($lang['mods']['adg_coupon_mod']['spend_more'],priceFormat($basket['order_limit_amount']));
			} else {
			if (isset($basket['coupon_code']) && $coupon_info[0]['use_method'] == 3) { //full site coupon
				$view_cart->assign("LANG_COUPON",$lang['front']['cart']['coupon']);
				$view_cart->assign("VAL_COUPON",$basket['coupon_code']);
					if ($coupon_info[0]['discount_method'] == 1) {
						$coupon_savings     = $coupon_info[0]['discount_amount'];
					} else {
						$coupon_savings = $subTotal * ($coupon_info[0]['discount_percent'] / 100);
					} 
				if ($coupon_savings > $subTotal) {
					 $coupon_savings = $subTotal;
				} 
				if ($coupon_savings >0) {
					$view_cart->assign("VAL_COUPON_SAVING","-".priceFormat($coupon_savings));
					$view_cart->parse("view_cart.cart_true.coupon");
				}
			}
		}
   		$tax = sprintf("%.2f",($subTotal - $coupon_savings) * ($product[0]['percent'] / 100));
	}
	//.: coupon code :.

	
	if($tax>0){
		
		$view_cart->assign("VAL_TAX",priceFormat($tax));
	
	} else {
		
		$view_cart->assign("VAL_TAX",$lang['front']['cart']['na']);
	
	}

	$view_cart->assign("LANG_SUBTOTAL",$lang['front']['cart']['subtotal']);
	$view_cart->assign("VAL_SUBTOTAL",priceFormat($subTotal));
	
	//$grandTotal = $subTotal + $tax + $basket['shipCost'];
//.: coupon code :.
	// $grandTotal = $subTotal + $tax + $basket['shipCost']; // replaced by coupon mod
	//$view_cart->assign("LANG_CART_TOTAL",$lang['front']['cart']['cart_total']); // replaced by coupon mod
	// $view_cart->assign("VAL_CART_TOTAL",priceFormat($grandTotal)); // replaced by coupon mod
	// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
	if($cavs_config['status'] && $cavs_config['tax'] && $config['priceIncTax']==1) {
	// <-- Shipping & Tax Always Visible by convict

	$grandTotal = $subTotal + $basket['shipCost'] - $coupon_savings;

	} else {
	// <-- Shipping & Tax Always Visible by convict
	//$grandTotal = $subTotal + $tax + $basket['shipCost'];
	$grandTotal = $subTotal + $basket['shipCost'] - $coupon_savings;
	// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
	}
	// <-- Shipping & Tax Always Visible by convict	$view_cart->assign("LANG_CART_TOTAL",$lang['front']['cart']['cart_total']);
	if ($grandTotal==0) {
		$view_cart->assign("VAL_CART_TOTAL","FREE");
	} else {
		$view_cart->assign("VAL_CART_TOTAL",priceFormat($grandTotal));
		//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
		include("includes/goobermods/Group_Discounts/mod_part2.php");
		//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
	}	
//.: coupon code :.
	
	if(isset($_GET['act']) && $_GET['act']=="step4"){
		
		// build array of price vars in session data
		$basket = $cart->setVar(sprintf("%.2f",$subTotal),"subTotal");

		// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
		# Do not store tax into DB if Tax is included
		if($cavs_config['status'] && $cavs_config['tax'] && $config['priceIncTax']==1){
			$basket = $cart->setVar(sprintf("%.2f",$tax),"tax_incl");
			$tax=0;
		}
		// <-- Shipping & Tax Always Visible by convict http://cubecartmods.eu
		$basket = $cart->setVar(sprintf("%.2f",$tax),"tax");
		$basket = $cart->setVar(sprintf("%.2f",$grandTotal),"grandTotal");
//.: adg_coupon_mod:.
		$basket = $cart->setVar(sprintf("%.2f",$coupon_savings),"coupon_savings");
//.: adg_coupon_mod:.
	
	}
	

	// Shipping & Tax Always Visible by convict http://cubecartmods.eu -->
	elseif ($_GET['act']=="cart" && $cavs_config['status'] && $cavs_config['default_country'] && $cavs_config['ship']) {
		$view_cart->assign("DELIVERY_NOTE",sprintf($lang['front']['cart']['sat_country'],countryName($cavs_config['default_country'])));
		$view_cart->parse("view_cart.cart_true.delivery_note");
	}
	// <-- Shipping & Tax Always Visible by convict http://cubecartmods.eu
	$view_cart->assign("LANG_UPDATE_CART_DESC",$lang['front']['cart']['if_changed_quan']);
	
	$view_cart->assign("LANG_UPDATE_CART",$lang['front']['cart']['update_cart']);
	
	$view_cart->assign("LANG_CHECKOUT",$lang['front']['cart']['continue']);
	
	$view_cart->assign("VAL_FORM_ACTION",currentPage());
	// Quick Checkout by convict http://cubecartmods.eu -->
	if($qch_config['status']==1 && $_GET['act']=="step4") {

		$gatewayModules = $db->select("SELECT folder, `default` FROM ".$glob['dbprefix']."CubeCart_Modules WHERE module='gateway' AND status = 1");
		
		if ($grandTotal==0) {
		// FREE gateway
			$gatewayModules[0]['folder'] = "Free";
			$gatewayModulesNo = 1;
		}

		$view_cart->assign("LANG_COMMENTS",$lang['front']['gateway']['your_comments']);
		$view_cart->assign("CONT_VAL","javascript:submitQ(3);"); # v1.6 update
		if (isset($basket['customer_comments'])) { 
			$view_cart->assign("VAL_CUSTOMER_COMMENTS",$basket['customer_comments']);
		}

		if ($gatewayModulesNo==1):		
		// One gateway
		$basket = $cart->setVar($gatewayModules[0]['folder'],"gateway");
		$view_cart->assign("LANG_CHECKOUT",$lang['front']['gateway']['go_now']);
		if ($grandTotal>0) $view_cart->parse("view_cart.cart_true.quick_checkout.comments");
		$view_cart->parse("view_cart.cart_true.quick_checkout");
		//
		else:
		// More gateways
		
		if($gatewayModules == TRUE) {

			$view_cart->assign("LANG_CHOOSE_GATEWAY",$lang['front']['gateway']['choose_method']);
	
			for($i=0; $i<count($gatewayModules); $i++){
				$view_cart->assign("TD_CART_CLASS",cellColor($i, $tdEven="tdcartEven", $tdOdd="tdcartOdd"));

				$module = fetchDbConfig($gatewayModules[$i]['folder']);
		
				$view_cart->assign("VAL_GATEWAY_DESC",$module['desc']);
				$view_cart->assign("VAL_GATEWAY_FOLDER",$gatewayModules[$i]['folder']);
			
				if (isset($basket['gateway']) && $basket['gateway']==$gatewayModules[$i]['folder']){
					$view_cart->assign("VAL_CHECKED","checked='checked'");
				} elseif (!isset($basket['gateway']) && $gatewayModules[$i]['default'] == 1){
					$view_cart->assign("VAL_CHECKED","checked='checked'");
				} else {
					$view_cart->assign("VAL_CHECKED","");
				}

				$view_cart->parse("view_cart.cart_true.gateway.choose_gate.gateways_true");
			}
			
			if (isset($basket['gateway'])) {
				$basket = $cart->unsetVar("gateway");
			}
			
			$view_cart->parse("view_cart.cart_true.gateway.choose_gate");
	
		} else {
			$view_cart->assign("LANG_GATEWAYS_FALSE",$lang['front']['gateway']['none_configured']);
			$view_cart->assign("CONT_VAL","index.php");
			$view_cart->parse("view_cart.cart_true.gateway.choose_gate.gateways_false");
			$view_cart->parse("view_cart.cart_true.gateway.choose_gate");
		}
		
		if (isset($basket['gateway'])) {
			$view_cart->assign("LANG_CHECKOUT",$lang['front']['gateway']['go_now']);
		}
		
		$view_cart->parse("view_cart.cart_true.gateway");	

		endif;

	} else {
		$view_cart->parse("view_cart.cart_true.continue");
	}
	// <-- Quick Checkout by convict

//.: adg_coupon_mod http://www.alexgoldberg.com/cubemods :.
	if ($coupon_manager) {
		$view_cart->assign("LANG_ADD_COUPONCODE",$lang['front']['cart']['add_coupon_code']);
		if (!isset($basket['coupon_code']) or $coupon_savings==0) {
			if ($coupon_savings==0 && isset($basket['coupon_code'])) {
				$coupon_error=isset($coupon_error) == TRUE ? $coupon_error : $lang['front']['cart']['not_qualified'];
				$view_cart->assign("LANG_ERROR_COUPONCODE","<font color=red>".$coupon_error."</font><br />");
				}
			$view_cart->parse("view_cart.coupon_form");
		}
	}
//.: coupon code :.


	
	$view_cart->parse("view_cart.cart_true");
	
} else {

	$view_cart->assign("LANG_CART_EMPTY",$lang['front']['cart']['cart_empty']);
	$view_cart->parse("view_cart.cart_false");

} 
$view_cart->parse("view_cart");
$page_content = $view_cart->text("view_cart");
?>
