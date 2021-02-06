<?php  

/*
+--------------------------------------------------------------------------
|   CubeCart v3.0.10
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
|	viewCat.inc.php
|   ========================================
|	Display the Current Category	
+--------------------------------------------------------------------------
*/
if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}


if(isset($_GET['page'])){
	
	$page = treatGet($_GET['page']);

} else {
	
	$page = 0;

}

$do_search = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/content/doSearch.tpl");


////////////////////////////
// BUILD PRODUCTS
///////////

include($glob['rootDir']."/admin/modules/3rdparty/relevant_search/search.inc.php");

	if(isset($_GET['searchStr'])){
		
		$do_search->assign("TXT_CAT_TITLE",$lang['front']['viewCat']['search_results']);
	
	} elseif($_GET['catId']=="saleItems" && $config['saleMode']>0) {
		
		$do_search->assign("TXT_CAT_TITLE",$lang['front']['viewCat']['sale_items']);
	
	} else {
		
		$do_search->assign("TXT_CAT_TITLE",validHTML($currentCat[0]['cat_name']));
	
	}
	
	$do_search->assign("LANG_IMAGE",$lang['front']['viewCat']['image']);
	$do_search->assign("LANG_DESC",$lang['front']['viewCat']['description']);
	$do_search->assign("LANG_PRICE",$lang['front']['viewCat']['price']);
	$do_search->assign("PAGINATION",$db->paginate($totalNoProducts, $config['productPages'], $page, "page"));

// repeated region
if($productResults == TRUE){
	
	if($_GET['catId']>0){
	
		$do_search->assign("LANG_CURRENT_DIR",$lang['front']['viewCat']['products_in']);
		$do_search->assign("CURRENT_DIR",getCatDir($currentCat[0]['cat_name'],$currentCat[0]['cat_father_id'], $currentCat[0]['cat_id'], $link=TRUE));
	}
	
	for ($i=0; $i<count($productResults); $i++){
	
		// alternate class
		$do_search->assign("CLASS",cellColor($i, $tdEven="tdEven", $tdOdd="tdOdd"));
		// grishick advanced_image_manager mod START -->
		if ($add_img_mgr_config['status']==1) {

			if(file_exists($GLOBALS['rootDir']."/images/uploads/".$productResults[$i]['img_folder']."/thumbs/thumb_".$productResults[$i]['image'])){
				$do_search->assign("SRC_PROD_THUMB",$GLOBALS['rootRel']."images/uploads/".$productResults[$i]['img_folder']."/thumbs/thumb_".$productResults[$i]['image']);
			} else {
				$do_search->assign("SRC_PROD_THUMB",$GLOBALS['rootRel']."skins/".$config['skinDir']."/styleImages/thumb_nophoto.gif");
			}
		} else {
	// grishick advanced_image_manager mod END -->		
			if(file_exists($GLOBALS['rootDir']."/images/uploads/thumbs/thumb_".$productResults[$i]['image'])){
				$do_search->assign("SRC_PROD_THUMB",$GLOBALS['rootRel']."images/uploads/thumbs/thumb_".$productResults[$i]['image']);
			} else {
				$do_search->assign("SRC_PROD_THUMB",$GLOBALS['rootRel']."skins/".$config['skinDir']."/styleImages/thumb_nophoto.gif");
			}
		// grishick advanced_image_manager mod START -->
		}	
		// grishick advanced_image_manager mod END -->


		$do_search->assign("TXT_TITLE",validHTML($productResults[$i]['name']));		

		if(strlen($productResults[$i]['description'])>2) {
			$do_search->assign("TXT_DESC",substr(strip_tags($productResults[$i]['description']),0,$config['productPrecis'])."&hellip;");
		} else {
			$do_search->assign("TXT_DESC", "");
		}
		
//In-house Affiliates MOD start		
if ($iha_config['status']==1) {	
		$do_search->assign("LANG_BY_PUBLISHER",  $lang['front']['viewCat']['by_author']);
		$do_search->assign("TXT_PUBLISHER",  $productResults[$i]['aff_name']);
		$do_search->assign("PUBLISHER_ID",  $productResults[$i]['affiliate_id']);
}
//In-house Affiliates MOD end		

		if(strlen($productResults[$i]['description'])>2) {
			$do_search->assign("TXT_DESC",substr(strip_tags($productResults[$i]['description']),0,$config['productPrecis'])."&hellip;");
		} else {
			$do_search->assign("TXT_DESC", "");
		}
		if(salePrice($productResults[$i]['price'], $productResults[$i]['sale_price'])==FALSE){
			$do_search->assign("TXT_PRICE",priceFormat($productResults[$i]['price']));
		} else {
			$do_search->assign("TXT_PRICE","<span class='txtOldPrice'>".priceFormat($productResults[$i]['price'])."</span>");
		}
		$salePrice = salePrice($productResults[$i]['price'], $productResults[$i]['sale_price']);
		
		$do_search->assign("TXT_SALE_PRICE", priceFormat($salePrice));

		if(isset($_GET['add']) && isset($_GET['quan'])){
			
			$do_search->assign("CURRENT_URL",str_replace(array("&amp;add=".$_GET['add'],"&amp;quan=".$_GET['quan']),"",currentPage()));
			
		} else {
		
			$do_search->assign("CURRENT_URL",currentPage());
			
		}

		if($config['outofstockPurchase']==1){
			
			$do_search->assign("BTN_BUY",$lang['front']['viewCat']['buy']);
			$do_search->assign("PRODUCT_ID",$productResults[$i]['productId']);
			$do_search->parse("do_search.productTable.products.buy_btn");
		
		} elseif($productResults[$i]['useStockLevel']==1 && $productResults[$i]['stock_level']>0){
			
			$do_search->assign("BTN_BUY",$lang['front']['viewCat']['buy']);
			$do_search->assign("PRODUCT_ID",$productResults[$i]['productId']);
			$do_search->parse("do_search.productTable.products.buy_btn");
		
		} elseif($productResults[$i]['useStockLevel']==0){
		
			$do_search->assign("BTN_BUY",$lang['front']['viewCat']['buy']);
			$do_search->assign("PRODUCT_ID",$productResults[$i]['productId']);
			$do_search->parse("do_search.productTable.products.buy_btn");
		
		}

		$do_search->assign("BTN_MORE",$lang['front']['viewCat']['more']);
		$do_search->assign("PRODUCT_ID",$productResults[$i]['productId']);

		if($productResults[$i]['stock_level']<1 && $productResults[$i]['useStockLevel']==1 && $productResults[$i]['digital']==0){
		
			$do_search->assign("TXT_OUTOFSTOCK",$lang['front']['viewCat']['out_of_stock']);
			
		} else {
		
			$do_search->assign("TXT_OUTOFSTOCK","");
		
		}
		
		$do_search->parse("do_search.productTable.products");
	}
	$do_search->parse("do_search.productTable");

} elseif(isset($_GET['searchStr'])) {

	$do_search->assign("TXT_NO_PRODUCTS",$lang['front']['viewCat']['no_products_match']." ".treatGet($_GET['searchStr']));
	$do_search->parse("do_search.noProducts");

} else {
	
	$do_search->assign("TXT_NO_PRODUCTS",$lang['front']['viewCat']['no_prods_in_cat']);
	$do_search->parse("do_search.noProducts");

}

$do_search->parse("do_search");
$page_content = $do_search->text("do_search");
?>