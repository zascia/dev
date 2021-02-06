<?php  

/*
+--------------------------------------------------------------------------
|   CubeCart v3.0.x
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
|   Date: Tuesday, 14th March 2006
|   Email: info (at) cubecart (dot) com
|	License Type: CubeCart is NOT Open Source Software and Limitations Apply 
|   Licence Info: http://www.cubecart.com/site/faq/license.php
+--------------------------------------------------------------------------
|	homeProd.inc.php
|   ========================================
|	Home Page Product mod by convict (c)2006
+--------------------------------------------------------------------------
*/

if (ereg(".inc.php",$HTTP_SERVER_VARS['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}


$hp_query = "SELECT * FROM ".$glob['dbprefix']."CubeCart_inventory WHERE productId = ".$hpp_config['product'];

if($db->numrows($hp_query) == 1){
	
	$hppArray = $db->select($hp_query);
	
	$home_prod = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/content/homeProd.tpl");

	$val = "";
	
	if(($val = prodAltLang($hppArray[0]['productId'])) == TRUE){	
		$hppArray[0]['name'] = $val['name'];
		$hppArray[0]['description'] = $val['description'];	
	}

	if ($hpp_config['popular']=1) {	
		$upPop['popularity'] = "popularity+1"; 
		$db->update($glob['dbprefix']."CubeCart_inventory",$upPop,"productId = ".$db->mySQLSafe($hppArray[0]['productId']));
	}
	
	$home_prod->assign("HPP_HEAD",$lang['front']['index']['hpp_head']);
	$home_prod->assign("LANG_PRODTITLE",$lang['front']['viewProd']['product']);
	$home_prod->assign("LANG_PRODINFO",$lang['front']['viewProd']['product_info']);
	$home_prod->assign("LANG_PRICE",$lang['front']['viewProd']['price']);
	$home_prod->assign("LANG_PRODCODE",$lang['front']['viewProd']['product_code']);
	$home_prod->assign("TXT_PRODTITLE",validHTML($hppArray[0]['name']));
	$home_prod->assign("TXT_DESCRIPTION",$hppArray[0]['description']);
	
	if(isset($_GET['add']) && isset($_GET['quan'])){
		$home_prod->assign("CURRENT_URL",str_replace(array("&amp;add=".$_GET['add'],"&amp;quan=".$_GET['quan']),"",currentPage()));
	} else {
		$home_prod->assign("CURRENT_URL",currentPage());
	}

	if(salePrice($hppArray[0]['price'], $hppArray[0]['sale_price'])==FALSE){
		$home_prod->assign("TXT_PRICE",priceFormat($hppArray[0]['price']));
	} else {
		$home_prod->assign("TXT_PRICE","<span class='txtOldPrice'>".priceFormat($hppArray[0]['price'])."</span>");
	}
	$salePrice = salePrice($hppArray[0]['price'], $hppArray[0]['sale_price']);
	$home_prod->assign("TXT_SALE_PRICE", priceFormat($salePrice));
	$home_prod->assign("TXT_PRODCODE", $hppArray[0]['productCode']);
	$home_prod->assign("LANG_QUAN",$lang['front']['viewProd']['quantity']);
	$home_prod->assign("PRODUCT_ID",$hppArray[0]['productId']);

	if(!empty($hppArray[0]['image'])){
		$home_prod->assign("IMG_SRC","images/uploads/".$hppArray[0]['image']);
	} else {
		$home_prod->assign("IMG_SRC","skins/".$config['skinDir']."/styleImages/nophoto.gif");
	}
	
	if($hppArray[0]['noImages']>0){
		$home_prod->assign("LANG_MORE_IMAGES",$lang['front']['viewProd']['more_images']);
		$home_prod->parse("view_prod.more_images");
	}
	
	if($config['outofstockPurchase']==1){
		$home_prod->assign("BTN_ADDBASKET",$lang['front']['viewProd']['add_to_basket']);
		$home_prod->parse("view_prod.buy_btn");
	} elseif($hppArray[0]['useStockLevel']==1 && $hppArray[0]['stock_level']>0){
		$home_prod->assign("BTN_ADDBASKET",$lang['front']['viewProd']['add_to_basket']);
		$home_prod->parse("view_prod.buy_btn");	
	} elseif($hppArray[0]['useStockLevel']==0){
		$home_prod->assign("BTN_ADDBASKET",$lang['front']['viewProd']['add_to_basket']);
		$home_prod->parse("view_prod.buy_btn");
	}

	$home_prod->assign("LANG_DIR_LOC",$lang['front']['viewProd']['location']);

	if($config['stockLevel']==1 && $hppArray[0]['useStockLevel']==1 && $hppArray[0]['stock_level']>0){
		$home_prod->assign("TXT_INSTOCK",$lang['front']['viewProd']['no_instock']." ".$hppArray[0]['stock_level']);
	} elseif($hppArray[0]['useStockLevel']==1 && $hppArray[0]['stock_level']>0) {
		$home_prod->assign("TXT_INSTOCK",$lang['front']['viewProd']['instock']);
	} else {
		$home_prod->assign("TXT_INSTOCK","");
	}

	if($hppArray[0]['stock_level']<1 && $hppArray[0]['useStockLevel']==1 && $hppArray[0]['digital']==0){
		$home_prod->assign("TXT_OUTOFSTOCK",$lang['front']['viewProd']['out_of_stock']);
	} else {
		$home_prod->assign("TXT_OUTOFSTOCK","&nbsp;");
	}

// build sql query for product options luuuuuurvely
	$query = "SELECT ".$glob['dbprefix']."CubeCart_options_bot.option_id, ".$glob['dbprefix']."CubeCart_options_bot.value_id, option_price, option_symbol, value_name, option_name, assign_id FROM `".$glob['dbprefix']."CubeCart_options_bot` INNER JOIN `".$glob['dbprefix']."CubeCart_options_mid` ON ".$glob['dbprefix']."CubeCart_options_mid.value_id = ".$glob['dbprefix']."CubeCart_options_bot.value_id INNER JOIN `".$glob['dbprefix']."CubeCart_options_top` ON ".$glob['dbprefix']."CubeCart_options_bot.option_id = ".$glob['dbprefix']."CubeCart_options_top.option_id WHERE product =".$db->mySQLSafe($hppArray[0]['productId'])." ORDER BY option_name, value_name ASC";

	$options = $db->select($query); 

	if($options == TRUE){
	
		$home_prod->assign("TXT_PROD_OPTIONS",$lang['front']['viewProd']['prod_opts']);
		for ($i=0; $i<count($options); $i++){
			$home_prod->assign("VAL_ASSIGN_ID", $options[$i]['assign_id']);
			$home_prod->assign("VAL_VALUE_NAME", $options[$i]['value_name']);
			if($options[$i]['option_price']>0){
				$home_prod->assign("VAL_OPT_SIGN",$options[$i]['option_symbol']);
				$home_prod->assign("VAL_OPT_PRICE",priceFormat($options[$i]['option_price']));
				$home_prod->parse("view_prod.prod_opts.repeat_options.repeat_values.repeat_price");
			}
			$home_prod->parse("view_prod.prod_opts.repeat_options.repeat_values");	
			
			if($options[$i]['option_id']!==$options[$i+1]['option_id']){
				$home_prod->assign("VAL_OPTS_NAME", $options[$i]['option_name']);
				$home_prod->parse("view_prod.prod_opts.repeat_options");
			} 
		}
		$home_prod->parse("view_prod.prod_opts");
	} // end if product options are true 

	$home_prod->parse("view_prod");
	$page_content = $home_prod->text("view_prod");
} else {
	$hpp_config['error'] = 1;
}
?>
