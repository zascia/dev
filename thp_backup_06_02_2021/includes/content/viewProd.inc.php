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
|	viewProduct.inc.php
|   ========================================
|	Displays the Product in Detail
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}


// query database
$_GET['productId'] = treatGet($_GET['productId']);

// SELECT ALL FIELDS
//$query = "SELECT productId, productCode, quantity, name, description, image, noImages, price, popularity, sale_price, stock_level, useStockLevel, digital, digitalDir, cat_name, ".$glob['dbprefix']."CubeCart_inventory.cat_id, cat_father_id, cat_image, per_ship, item_ship, item_int_ship, per_int_ship, noProducts FROM ".$glob['dbprefix']."CubeCart_inventory INNER JOIN ".$glob['dbprefix']."CubeCart_category ON ".$glob['dbprefix']."CubeCart_inventory.cat_id = ".$glob['dbprefix']."CubeCart_category.cat_id where productId = ".$db->mySQLSafe($_GET['productId']);
$query = "SELECT *, ".$glob['dbprefix']."CubeCart_inventory.cat_id FROM ".$glob['dbprefix']."CubeCart_inventory INNER JOIN ".$glob['dbprefix']."CubeCart_category ON ".$glob['dbprefix']."CubeCart_inventory.cat_id = ".$glob['dbprefix']."CubeCart_category.cat_id where productId = ".$db->mySQLSafe($_GET['productId']);

$prodArray = $db->select($query);
//.: Facebook like button by Thomas Pedersen
$body->assign("VAL_IMAGE","http://www.nyah-beauty.com/images/uploads/".$prodArray[0]['image']);
//.: Facebook like button by Thomas Pedersen

//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
include("includes/goobermods/Group_Discounts/mod_part4.php");
//.: Group Discounts Mod by Goober

$meta['siteTitle'] = str_replace('\\','',$prodArray[0]['name']);
$meta['metaDescription'] = substr(strip_tags(str_replace('\\','',$prodArray[0]['description'])),0,150);

$view_prod = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/content/viewProd.tpl");

if($prodArray == TRUE){
	
	$val = "";
	
	if(($val = prodAltLang($prodArray[0]['productId'])) == TRUE){
				
		$prodArray[0]['name'] = str_replace('\\','',$val['name']);
		$prodArray[0]['description'] = str_replace('\\','',$val['description']);
			
	}

// update amount of views
	$upPop['popularity'] = "popularity+1"; 
	$db->update($glob['dbprefix']."CubeCart_inventory",$upPop,"productId = ".$db->mySQLSafe($_GET['productId']));
	
	$view_prod->assign("LANG_PRODTITLE",$lang['front']['viewProd']['product']);
	$view_prod->assign("LANG_PRODINFO",$lang['front']['viewProd']['product_info']);
	$view_prod->assign("LANG_PRICE",$lang['front']['viewProd']['price']);
	//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
	include("includes/goobermods/Group_Discounts/mod_part5.php");
	//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
	$view_prod->assign("LANG_PRODCODE",$lang['front']['viewProd']['product_code']);
	$view_prod->assign("LANG_TELLFRIEND",$lang['front']['viewProd']['tellafriend']);
	$view_prod->assign("TXT_PRODTITLE",validHTML(str_replace('\\','',$prodArray[0]['name'])));
	$view_prod->assign("TXT_DESCRIPTION",str_replace('\\','',$prodArray[0]['description']));
### START ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz --> 
	if($prodArray[0]['hasVideo'] == '1') {

		$view_prod->assign("VISIBILITY","block");
		$view_prod->assign("TXT_VIDTITLE","Watch it in action! Play the video for ".str_replace('\\','',$prodArray[0]['name']).". . .");
	
		if(!empty($prodArray[0]['embedYouTube'])) {
	
			$view_prod->assign("EMBED_YOUTUBE",stripslashes($prodArray[0]['embedYouTube']));
			$view_prod->parse("view_prod.prod_true.show_video.embed_youTube");
			
		}

		if(!empty($prodArray[0]['videoFilename'])) {
	
			$view_prod->assign("FILENAME",$prodArray[0]['videoFilename']);
			$view_prod->parse("view_prod.prod_true.show_video.download_video");
			
		}
			
			
		$view_prod->parse("view_prod.prod_true.show_video");
		
	} else {
	
		$view_prod->assign("VISIBILITY","none");
		
	}
### STOP ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz -->
	
	if(isset($_GET['add']) && isset($_GET['quan'])){
		$view_prod->assign("CURRENT_URL",str_replace(array("&amp;add=".$_GET['add'],"&amp;quan=".$_GET['quan']),"",currentPage()));
	} else {
		$view_prod->assign("CURRENT_URL",currentPage());
	}

	if(salePrice($prodArray[0]['price'], $prodArray[0]['sale_price'])==FALSE){
		$view_prod->assign("TXT_PRICE",priceFormat($prodArray[0]['price']));
	} else {
		$view_prod->assign("TXT_PRICE","<span class='txtOldPrice'>".priceFormat($prodArray[0]['price'])."</span>");
	}
	$salePrice = salePrice($prodArray[0]['price'], $prodArray[0]['sale_price']);
	$view_prod->assign("TXT_SALE_PRICE", priceFormat($salePrice));
	$view_prod->assign("TXT_PRODCODE", $prodArray[0]['productCode']);

	$view_prod->assign("CURRENT_DIR",getCatDir($prodArray[0]['cat_name'],$prodArray[0]['cat_father_id'], $prodArray[0]['cat_id'],$link=TRUE, $lastlink=TRUE));

	$view_prod->assign("LANG_QUAN",$lang['front']['viewProd']['quantity']);

	$view_prod->assign("PRODUCT_ID",$prodArray[0]['productId']);



	if(!empty($prodArray[0]['image'])){
		$view_prod->assign("IMG_SRC","images/uploads/".$prodArray[0]['image']);
	} else {
		$view_prod->assign("IMG_SRC","skins/".$config['skinDir']."/styleImages/nophoto.gif");
	}
	
	if($prodArray[0]['noImages']>0){
		// start: Product Images Mod
		$view_prod->assign("VALUE_THUMB_WIDTH","");
		$view_prod->assign("LANG_MORE_IMAGES_2",$lang['front']['viewProd']['more_images_2']);
//		$view_prod->assign("LANG_MORE_IMAGES",$lang['front']['viewProd']['more_images']);
		$view_prod->assign("VALUE_SRC",$glob['rootRel']."images/uploads/".$prodArray[0]['image']);
	
		if(file_exists("images/uploads/thumbs/thumb_".$prodArray[0]['image']))
		{
			$view_prod->assign("VALUE_THUMB_SRC","images/uploads/thumbs/thumb_".$prodArray[0]['image']);
		}
	       	elseif(!empty($prodArray[0]['image']) && file_exists("images/uploads/".$prodArray[0]['image']))
	       	{
			$view_prod->assign("VALUE_THUMB_WIDTH","width=\"".$config['gdthumbSize']."\"");
			$view_prod->assign("VALUE_THUMB_SRC","images/uploads/".$prodArray[0]['image']);
		}
	       	else
	       	{
			$view_prod->assign("VALUE_THUMB_SRC","skins/".$config['skinDir']."/styleImages/thumb_nophoto.gif");
		}
		$view_prod->parse("view_prod.prod_true.more_images.repeat_thumbs");
		// query database
		$results = $db->select("SELECT img FROM ".$glob['dbprefix']."CubeCart_img_idx WHERE productId = ".$db->mySQLsafe($_GET['productId']));
		if($results == TRUE){
			// start loop
			for ($i=0; $i<count($results); $i++){
				$view_prod->assign("VALUE_SRC",$glob['rootRel']."images/uploads/".$results[$i]['img']);
				$view_prod->assign("VALUE_THUMB_WIDTH","");

				if(file_exists("images/uploads/thumbs/thumb_".$results[$i]['img']))
				{
					$view_prod->assign("VALUE_THUMB_SRC","images/uploads/thumbs/thumb_".$results[$i]['img']);
				}
				elseif(!empty($results[$i]['img']) && file_exists("images/uploads/".$results[$i]['img']))
				{
					$view_prod->assign("VALUE_THUMB_WIDTH","width=\"".$config['gdthumbSize']."\"");
					$view_prod->assign("VALUE_THUMB_SRC","images/uploads/".$results[$i]['img']);
				}
				else
				{
					$view_prod->assign("VALUE_THUMB_SRC","skins/".$config['skinDir']."/styleImages/thumb_nophoto.gif");
				}

				$view_prod->parse("view_prod.prod_true.more_images.repeat_thumbs");
			}
		}
		// end: Product Images Mod
		$view_prod->parse("view_prod.prod_true.more_images");	
	}
	
		// start mod: Related Items
	$config_rp = fetchDbConfig("Related_Products");
	if ($config_rp['status'] && $config_rp['auto'])
	{
		$name = strtolower(strip_tags(str_replace('\\','',$prodArray[0]['name'])));

		// cut words to be ignored
		$ignore = explode(",",strtolower($config_rp['ignore']));
		foreach($ignore as $term) {
			$ignore_terms[] = trim($term);
		}
		if (is_array($ignore_terms)) {
			$name = str_replace($ignore_terms, "", $name);
		}

		$desc = "";
		if ($config_rp['use_desc'])
		{
			$desc = strtolower(str_replace('\\','',$prodArray[0]['description']));

			// search for "description terminators"
			$delimArray = explode(",",strtolower($config_rp['desc_up_to']));
			if ($delimArray[0]!="")
			{
				foreach ($delimArray as $delim)
				{
					$pos = strpos($desc, trim($delim));
					if ($pos > 0) {
						$delim_pos[] = $pos;
					}
				}
				// cut at first "terminator"
				if (isset($delim_pos))
				{
					if (count($delim_pos)>1) {
						$end = min($delim_pos);
					} else {
						$end = $delim_pos[0];
					}
					$desc = substr($desc,0,$end);
				}
			}

			$desc = strip_tags($desc);

			// cut words to be ignored
			if (is_array($ignore_terms)) {
				$desc = str_replace($ignore_terms, "", $desc);
			}
		}
			
		// search terms
		$search1 = $db->mySQLSafe($name);
		if ($desc != "") {
			$search2 = $db->mySQLSafe($desc);
		}
	}
	if ($config_rp['status'])
	{
		// manual
		$query = "SELECT relatedId as productId, name, image, description FROM ".$glob['dbprefix']."CubeCart_mod_related_prods as rel, ".$glob['dbprefix']."CubeCart_inventory as inv WHERE rel.relatedId=inv.productId AND ((inv.stock_level>0 AND inv.useStockLevel=1) OR inv.useStockLevel=0) AND inv.hidden!='yes' AND inv.hidden_cat!='yes' AND rel.productId=".$db->mySQLSafe($prodArray[0]['productId'])." ORDER BY id";
		$manual_related = $db->select($query);
	}
	if ($config_rp['status'] && $config_rp['auto'])
	{
		// auto search
		$manual_count = 0;
		$not_in = $prodArray[0]['productId'];
		if (is_array($manual_related))
		{
			foreach ($manual_related as $man) {
				$not_in .= ",".$man['productId'];
			}
			$manual_count = count($manual_related);
		}

		$relevance_cutoff = 3;

		if (empty($search2))
		{
			$query = "SELECT MATCH (name,description) AGAINST (".$search1.") AS score1, productId, name, image, description FROM ".$glob['dbprefix']."CubeCart_inventory WHERE MATCH (name,description) AGAINST (".$search1.") > ".$relevance_cutoff." AND productId NOT IN (".$not_in.") AND ((stock_level>0 AND useStockLevel=1) OR useStockLevel=0) AND hidden!='yes' AND hidden_cat!='yes' ORDER BY MATCH (name,description) AGAINST (".$search1.") DESC LIMIT ".($config_rp['max_shown']+1);
		}
		else
		{
			$query = "SELECT MATCH (name,description) AGAINST (".$search1.") AS score1, MATCH (name,description) AGAINST (".$search2.") AS score2, productId, name, image, description FROM ".$glob['dbprefix']."CubeCart_inventory WHERE MATCH (name,description) AGAINST (".$search1.") + MATCH (name,description) AGAINST (".$search2.") > ".$relevance_cutoff." AND productId NOT IN (".$not_in.") AND ((stock_level>0 AND useStockLevel=1) OR useStockLevel=0) AND hidden!='yes' AND hidden_cat!='yes' ORDER BY MATCH (name,description) AGAINST (".$search1.") + MATCH (name,description) AGAINST (".$search2.") DESC LIMIT ".($config_rp['max_shown']+1);
		}
		$auto_related = $db->select($query);

		if (is_array($manual_related) && is_array($auto_related)) {

			$related = array_merge($manual_related,$auto_related);

		} elseif (is_array($auto_related) ) {

			$related = $auto_related;

		} elseif (is_array($manual_related)) {

			$related = $manual_related;

		}
	}
	if ($config_rp['status'])
	{
		if ($config_rp['auto']==FALSE && is_array($manual_related)) {
			$related = $manual_related;
		}

		$view_prod->assign("TXT_RELATED_PRODUCTS",$lang['front']['viewProd']['related_products']);
		$view_prod->assign("TXT_NONE",$lang['front']['viewProd']['none']);

		if (isset($related))
		{
			for ($i=0; $i<count($related) && $i<$config_rp['max_shown']; $i++)
			{
				// reset width, may be set later if necessary
				$view_prod->assign("100","");

				$view_prod->assign("VALUE_RELATED_LINK","index.php?act=viewProd&productId=".$related[$i]['productId']);
				$view_prod->assign("VALUE_RELATED_NAME",str_replace('\\','',$related[$i]['name']));

				if(file_exists("images/uploads/thumbs/thumb_".$related[$i]['image'])){
					$view_prod->assign("VALUE_RELATED_THUMB","images/uploads/thumbs/thumb_".$related[$i]['image']);
				} elseif(!empty($related[$i]['image']) && file_exists("images/uploads/".$related[$i]['image'])) {
					$view_prod->assign("VALUE_RELATED_THUMB","images/uploads/".$related[$i]['image']);
					$view_prod->assign("VALUE_THUMB_WIDTH","width=\"".$config['gdthumbSize']."\"");
				} else {
					$view_prod->assign("VALUE_RELATED_THUMB","skins/".$config['skinDir']."/styleImages/thumb_nophoto.gif");
				}

				$view_prod->parse("view_prod.prod_true.related_prods_true.repeat_related_prods");
			}
			$view_prod->parse("view_prod.prod_true.related_prods_true");
		}
		else
		{
			$view_prod->parse("view_prod.prod_true.related_prods_false");
		}
	}
	// end mod: Related Items	

	if($config['outofstockPurchase']==1){
	
		$view_prod->assign("BTN_ADDBASKET",$lang['front']['viewProd']['add_to_basket']);
		$view_prod->parse("view_prod.prod_true.buy_btn");
		
	
	} elseif($prodArray[0]['useStockLevel']==1 && $prodArray[0]['stock_level']>0){
	
		$view_prod->assign("BTN_ADDBASKET",$lang['front']['viewProd']['add_to_basket']);
		$view_prod->parse("view_prod.prod_true.buy_btn");	
		
	} elseif($prodArray[0]['useStockLevel']==0){

		$view_prod->assign("BTN_ADDBASKET",$lang['front']['viewProd']['add_to_basket']);
		$view_prod->parse("view_prod.prod_true.buy_btn");

	}

	$view_prod->assign("LANG_DIR_LOC",$lang['front']['viewProd']['location']);


	if($config['stockLevel']==1 && $prodArray[0]['useStockLevel']==1 && $prodArray[0]['stock_level']>0){
		
		$view_prod->assign("TXT_INSTOCK",$lang['front']['viewProd']['no_instock']." ".$prodArray[0]['stock_level']);
	
	} elseif($prodArray[0]['useStockLevel']==1 && $prodArray[0]['stock_level']>0) {
		
		$view_prod->assign("TXT_INSTOCK",$lang['front']['viewProd']['instock']);
	
	} else {
		
		$view_prod->assign("TXT_INSTOCK","");
	
	}


	if($prodArray[0]['stock_level']<1 && $prodArray[0]['useStockLevel']==1 && $prodArray[0]['digital']==0){
	
		$view_prod->assign("TXT_OUTOFSTOCK",$lang['front']['viewProd']['out_of_stock']);
		
	} else {
	
		$view_prod->assign("TXT_OUTOFSTOCK","&nbsp;");
	
	}

// build sql query for product options luuuuuurvely
	$query = "SELECT ".$glob['dbprefix']."CubeCart_options_bot.option_id, ".$glob['dbprefix']."CubeCart_options_bot.value_id, option_price, option_symbol, value_name, option_name, assign_id FROM `".$glob['dbprefix']."CubeCart_options_bot` INNER JOIN `".$glob['dbprefix']."CubeCart_options_mid` ON ".$glob['dbprefix']."CubeCart_options_mid.value_id = ".$glob['dbprefix']."CubeCart_options_bot.value_id INNER JOIN `".$glob['dbprefix']."CubeCart_options_top` ON ".$glob['dbprefix']."CubeCart_options_bot.option_id = ".$glob['dbprefix']."CubeCart_options_top.option_id WHERE product =".$db->mySQLSafe($_GET['productId'])." ORDER BY option_name, value_name ASC";

	$options = $db->select($query); 


	if($options == TRUE){
	
		$view_prod->assign("TXT_PROD_OPTIONS",$lang['front']['viewProd']['prod_opts']);
	
		// start loop
			
		for ($i=0; $i<count($options); $i++){
		
			$view_prod->assign("VAL_ASSIGN_ID", $options[$i]['assign_id']);
			$view_prod->assign("VAL_VALUE_NAME", $options[$i]['value_name']);
					
			
			if($options[$i]['option_price']>0){
				//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
				include("includes/goobermods/Group_Discounts/mod_part6.php");
				//.: Group Discounts Mod by Goober
				$view_prod->assign("VAL_OPT_SIGN",$options[$i]['option_symbol']);
				$view_prod->assign("VAL_OPT_PRICE",priceFormat($options[$i]['option_price']));
				$view_prod->parse("view_prod.prod_true.prod_opts.repeat_options.repeat_values.repeat_price");
			}
			$view_prod->parse("view_prod.prod_true.prod_opts.repeat_options.repeat_values");	
			
			if($options[$i]['option_id']!==$options[$i+1]['option_id']){
		
				$view_prod->assign("VAL_OPTS_NAME", $options[$i]['option_name']);
				$view_prod->parse("view_prod.prod_true.prod_opts.repeat_options");

			} 
				
			
		}
	
		$view_prod->parse("view_prod.prod_true.prod_opts");
	
	} // end if product options are true 

	//.: product ratings & reviews mod http://www.cubecartmodder.com/ :.
	include("includes/content/viewReviews.inc.php");
	$view_prod->assign("REVIEW_CONTENT",$review_content);
	//.: product ratings & reviews mod :.

	// Manufacturers by convict http://cubecartmods.eu -->
	$cman_config = fetchDbConfig("Manufacturers");

	if (!empty($cman_config['status']) && !empty($cman_config['product_page']) && !empty($prodArray[0]['manufacturer'])):

	$view_prod->assign("MANUFACTURER_LANG",$lang['front']['viewProd']['manufacturer']);
	$view_prod->assign("MANUFACTURER_VAL",$prodArray[0]['manufacturer']);
	$view_prod->parse("view_prod.prod_true.manufacturer");

	endif;
	// <-- Manufacturers by convict http://cubecartmods.eu
	$view_prod->parse("view_prod.prod_true");

	# >> Customers Also Bought by convict >>
	# mod shop: http://cubecart-mods-skins.com
	include("modules/3rdparty/Customer_Also_Bought/viewProd.inc.php");
	# << Customers Also Bought by convict <<

} else {// end if product array is true
	
	$view_prod->assign("LANG_PRODUCT_EXPIRED",$lang['front']['viewProd']['prod_not_found']);
	$view_prod->parse("view_prod.prod_false");

}
$view_prod->parse("view_prod");
$page_content = $view_prod->text("view_prod");
?>
