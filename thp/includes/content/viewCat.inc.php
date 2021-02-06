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
// Manufacturers by convict http://cubecartmods.eu -->
$cman_config = fetchDbConfig("Manufacturers");
// <-- Manufacturers by convict http://cubecartmods.eu
$view_cat = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/content/viewCat.tpl");

// Store selector mod by convict (c)2006 -->
$isTop = $db->select("SELECT cat_father_id FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_id = ".$db->mySQLSafe($_GET['catId']));

if ($store_selector['status']==1 && ($store_selector['hidetop']==0 || ($isTop==TRUE && $isTop[0]['cat_father_id']!=0))) {
// < -- Store selector mod by convict (c)2006
////////////////////////
// BUILD SUB CATEGORIES
////////
if(isset($_GET['catId'])) {
	$_GET['catId'] = treatGet($_GET['catId']);
	// build query
		//Hide Categories and products, http://cc3.biz
	//Code replaced, original line below
	//$query = "SELECT * FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_father_id = ".$db->mySQLSafe($_GET['catId'])." ORDER BY cat_name ASC";
	$query = "SELECT * FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_father_id = ".$db->mySQLSafe($_GET['catId'])." AND cat_active ='1' ORDER BY cat_name ASC";
	//Hide Categories and products, http://cc3.biz
	
	// get category array in foreign innit
	$resultsForeign = $db->select("SELECT cat_master_id as cat_id, cat_name FROM ".$glob['dbprefix']."CubeCart_cats_lang WHERE cat_lang = '".$lang_folder."'");
	
	// query database
	$subCategories = "";
	$subCategories = $db->select($query);

}

if(isset($_GET['catId']) && $_GET['catId']>0 && $subCategories == TRUE) {

// loop results
for ($i=0; $i<count($subCategories); $i++){
		
			if(is_array($resultsForeign)){
	
				for ($k=0; $k<count($resultsForeign); $k++){
	
					if($resultsForeign[$k]['cat_id'] == $subCategories[$i]['cat_id']){
					
						$subCategories[$i]['cat_name'] = $resultsForeign[$k]['cat_name'];
					
					}
					
				}
			
			}

			if(empty($subCategories[$i]['cat_image'])){
				$view_cat->assign("IMG_CATEGORY",$GLOBALS['rootRel']."skins/".$config['skinDir']."/styleImages/catnophoto.gif");
			} else {
				$view_cat->assign("IMG_CATEGORY",$GLOBALS['rootRel']."images/uploads/".$subCategories[$i]['cat_image']);
			}
		
		$view_cat->assign("TXT_LINK_CATID",$subCategories[$i]['cat_id']);

		$view_cat->assign("TXT_CATEGORY", validHTML($subCategories[$i]['cat_name']));
		
		//Hide Categories and products, convict http://cc3.biz	
		$total_cat = $db->numrows("SELECT ".$glob['dbprefix']."CubeCart_cats_idx.productId FROM ".$glob['dbprefix']."CubeCart_cats_idx INNER JOIN ".$glob['dbprefix']."CubeCart_inventory ON ".$glob['dbprefix']."CubeCart_inventory.productId = ".$glob['dbprefix']."CubeCart_cats_idx.productId WHERE hidden != 'yes' AND ".$glob['dbprefix']."CubeCart_cats_idx.cat_id = ".$db->mySQLSafe($subCategories[$i]['cat_id']));
		$view_cat->assign("NO_PRODUCTS", $total_cat);
		//Hide Categories and products, http://cc3.biz
		
		$view_cat->parse("view_cat.sub_cats.sub_cats_loop");
	
	} // end loop results
$view_cat->parse("view_cat.sub_cats");
} // end $subCategories == TRUE

// Store selector mod by convict (c)2006 -->
}
// < -- Store selector mod
////////////////////////////
// BUILD PRODUCTS
///////////


// build query
if(isset($_GET['searchStr'])){
	
	// Fix for SQL Injection if Reg Globals is On
	if(isset($searchArray))
	{
		unset($searchArray);
	}
	$searchwords = split ( "[ ,]", treatGet($_GET['searchStr']));   
	foreach($searchwords as $word){
		$searchArray[]=$word;
	}

	$noKeys = count($searchArray);
	$like = "";
	for ($i=0; $i<$noKeys;$i++) {
		
		$ucSearchTerm = strtoupper($searchArray[$i]);
		if(($ucSearchTerm!=="AND") && ($ucSearchTerm!=="OR")){
			// Manufacturers by convict http://cubecartmods.eu -->
			//$like .= "(name LIKE '%".$searchArray[$i]."%' OR description LIKE '%".$searchArray[$i]."%' OR productCode LIKE '%".$searchArray[$i]."%') OR ";
			if ($cman_config['status']==1){
				$like .= "(manufacturer LIKE '%".$searchArray[$i]."%' OR name LIKE '%".$searchArray[$i]."%' OR description LIKE '%".$searchArray[$i]."%' OR productCode LIKE '%".$searchArray[$i]."%') OR ";
			} else {
				$like .= "(name LIKE '%".$searchArray[$i]."%' OR description LIKE '%".$searchArray[$i]."%' OR productCode LIKE '%".$searchArray[$i]."%') OR ";
			}
			// <-- Manufacturers by convict http://cubecartmods.eu
			// see if search terrm is in database
			$searchQuery = "SELECT id FROM ".$glob['dbprefix']."CubeCart_search WHERE searchstr='".$ucSearchTerm."'";
			$searchLogs = $db->select($searchQuery);
			
			$insertStr['searchstr'] = $db->mySQLsafe($ucSearchTerm);
			$insertStr['hits'] = $db->mySQLsafe(1);
			$updateStr['hits'] = "hits+1";
			
			if($searchLogs == TRUE) {
				
				$db->update($glob['dbprefix']."CubeCart_search",$updateStr,"id=".$searchLogs[0]['id'],$quote = "");
			
			} elseif(!empty($_GET['searchStr'])) {
				
				$db->insert($glob['dbprefix']."CubeCart_search",$insertStr);
			
			}
			
		} else {
			
			$like = substr($like,0,strlen($like)-3);
			$like .= $ucSearchTerm;
		
		}  

	}
	$like = substr($like,0,strlen($like)-3);
	
//******** Start - Hide product mod ***********
	//$productListQuery = "SELECT * FROM ".$glob['dbprefix']."CubeCart_inventory WHERE ".$like;
	$productListQuery = "SELECT * FROM ".$glob['dbprefix']."CubeCart_inventory WHERE hidden!='yes' and hidden_cat!='yes' and ".$like;
//******** Start - Hide product mod ***********

} elseif($_GET['catId']=="saleItems" && $config['saleMode']>0) {
	
//******** Start - Hide product mod ***********
	$productListQuery = "SELECT ".$glob['dbprefix']."CubeCart_cats_idx.cat_id, ".$glob['dbprefix']."CubeCart_cats_idx.productId, productCode, quantity, description, image, price, name, popularity, sale_price, stock_level, useStockLevel, hasVideo FROM ".$glob['dbprefix']."CubeCart_cats_idx INNER JOIN ".$glob['dbprefix']."CubeCart_inventory ON ".$glob['dbprefix']."CubeCart_cats_idx.productId = ".$glob['dbprefix']."CubeCart_inventory.productId WHERE  hidden!='yes' and hidden_cat!='yes' and sale_price > 0 GROUP BY ".$glob['dbprefix']."CubeCart_inventory.productId";
	//$productListQuery = "SELECT ".$glob['dbprefix']."CubeCart_cats_idx.cat_id, ".$glob['dbprefix']."CubeCart_cats_idx.productId, productCode, quantity, description, image, price, name, popularity, sale_price, stock_level, useStockLevel FROM ".$glob['dbprefix']."CubeCart_cats_idx INNER JOIN ".$glob['dbprefix']."CubeCart_inventory ON ".$glob['dbprefix']."CubeCart_cats_idx.productId = ".$glob['dbprefix']."CubeCart_inventory.productId WHERE sale_price > 0 GROUP BY ".$glob['dbprefix']."CubeCart_inventory.productId";
//******** End - Hide product mod ***********	
// Manufacturers by convict http://cubecartmods.eu -->
} elseif ($cman_config['status']==1 && isset($_GET['manuf'])) {
	$manufacturer = str_replace("amp;", "",base64_decode($_GET['manuf']));
	$productListQuery = "SELECT cat_id, productId, productCode, quantity, description, image, price, name, popularity, sale_price, stock_level, useStockLevel, hasVideo FROM ".$glob['dbprefix']."CubeCart_inventory WHERE hidden!='yes' and manufacturer='".$manufacturer."' ORDER BY productId";
// <-- Manufacturers by convict
	
} else {

//******** Start - Hide product mod ***********
	$productListQuery = "SELECT ".$glob['dbprefix']."CubeCart_cats_idx.cat_id, ".$glob['dbprefix']."CubeCart_cats_idx.productId, productCode, quantity, description, image, price, name, popularity, sale_price, stock_level, useStockLevel, hasVideo, hidden_cat FROM ".$glob['dbprefix']."CubeCart_cats_idx INNER JOIN ".$glob['dbprefix']."CubeCart_inventory ON ".$glob['dbprefix']."CubeCart_cats_idx.productId = ".$glob['dbprefix']."CubeCart_inventory.productId WHERE  hidden!='yes' and hidden_cat!='yes' and  ".$glob['dbprefix']."CubeCart_cats_idx.cat_id = ".$db->mySQLSafe($_GET['catId']);
	//$productListQuery = "SELECT ".$glob['dbprefix']."CubeCart_cats_idx.cat_id, ".$glob['dbprefix']."CubeCart_cats_idx.productId, productCode, quantity, description, image, price, name, popularity, sale_price, stock_level, useStockLevel FROM ".$glob['dbprefix']."CubeCart_cats_idx INNER JOIN ".$glob['dbprefix']."CubeCart_inventory ON ".$glob['dbprefix']."CubeCart_cats_idx.productId = ".$glob['dbprefix']."CubeCart_inventory.productId WHERE ".$glob['dbprefix']."CubeCart_cats_idx.cat_id = ".$db->mySQLSafe($_GET['catId']);
//******** End - Hide product mod ***********	
 //*** Start --> CubeHelper product sorting v1.0 ****
 $module = fetchDbConfig('Product_Sorting');
 if($module['status']==1) {
    $sort_col = "";
    if(isset($_GET['sort'])) {
	      $productListQuery = $productListQuery." order by ".$_GET['sort'];
	      if(isset($_GET['direction']) && $_GET['direction'] != "" ) {
	        $cur_direction =  $_GET['direction'];
	        if ( $cur_direction == 'asc' ) {
	  	     $direction = 'desc';
	        } else {
  	       $direction = 'asc';
  	     }
        } else {
  	      $cur_direction = 'asc';
  	      $direction = 'desc';
       }
       $productListQuery = $productListQuery." ".$cur_direction;
   } else {  // v1.5
      if ( $module['default_psort'] == 1 ) {
         $sort_col = "name";
      } else {
         $sort_col = "price";
      }
      if ( $module['default_pdirection'] == 1 ) {
         $cur_direction = 'asc';  $direction = 'desc';
      } else {
         $cur_direction = 'desc'; $direction = 'asc';
      }
      $productListQuery = $productListQuery." order by ".$sort_col;
      $productListQuery = $productListQuery." ".$cur_direction;
   }
   //echo "sql: ".$productListQuery."<br>";
}
//*** End --> CubeHelper product sorting v1.0 *****
}

$productResults = $db->select($productListQuery, $config['productPages'], $page);

// get different languages 
if($productResults == TRUE && $lang_folder !== $config['defaultLang']){

	for($i=0;$i<count($productResults);$i++){
	
		if(($val = prodAltLang($productResults[$i]['productId'])) == TRUE){
			
				$productResults[$i]['name'] = $val['name'];
				$productResults[$i]['description'] = $val['description'];
		
		}
		
	}

}

$totalNoProducts = $db->numrows($productListQuery);

// get current category info
	if(isset($_GET['catId']) && $_GET['catId']>0){
		$currentCatQuery = "SELECT cat_name, cat_desc, cat_father_id, cat_image, cat_id FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_id = ".$db->mySQLSafe($_GET['catId']);
		$currentCat = $db->select($currentCatQuery);
		
		$resultForeign = $db->select("SELECT cat_master_id as cat_id, cat_name FROM ".$glob['dbprefix']."CubeCart_cats_lang WHERE cat_lang = '".$lang_folder."' AND cat_master_id = ".$db->mySQLSafe($_GET['catId']));
		
		if($resultForeign == TRUE){
			
			$currentCat[0]['cat_name'] = $resultForeign[0]['cat_name'];
		
		}
		
		
	}

		if(!empty($currentCat[0]['cat_image'])) {
			$view_cat->assign("IMG_CURENT_CATEGORY","images/uploads/".$currentCat[0]['cat_image']);
			$view_cat->assign("TXT_CURENT_CATEGORY",validHTML($currentCat[0]['cat_name']));
			$view_cat->parse("view_cat.cat_img");
		}

	if(isset($_GET['searchStr'])){
		
		$view_cat->assign("TXT_CAT_TITLE",$lang['front']['viewCat']['search_results']);
	
	} elseif($_GET['catId']=="saleItems" && $config['saleMode']>0) {
		
		$view_cat->assign("TXT_CAT_TITLE",$lang['front']['viewCat']['sale_items']);
	// Manufacturers by convict http://cubecartmods.eu -->
	} elseif ($cman_config['status']==1 && isset($_GET['manuf'])) {

		$view_cat->assign("TXT_CAT_TITLE",validHTML($manufacturer));
	// <-- Manufacturers by convict
	} else {
		
		$view_cat->assign("TXT_CAT_TITLE",validHTML($currentCat[0]['cat_name']));
		
		#:convict:#
		$meta['siteTitle'] = str_replace("&#39;","'",$currentCat[0]['cat_name'])." - ".$config['siteTitle'];
		$meta['metaDescription'] = $config['metaDescription'];
	
	}
	
	$view_cat->assign("TXT_CAT_DESC",$currentCat[0]['cat_desc']);
	
      //*****  Start --> CubeHelper.com product sorting v1.0 ******
      if($module['status']==1) {
	  $price_direction = "<img src='images/cubehelper/arrow_off.gif' border='0'>";
	  $desc_direction = "<img src='images/cubehelper/arrow_off.gif' border='0'>";
	  if ( isset($_GET['sort']) )  $sort_col = $_GET['sort']; //v1.5
	  if ( isset($sort_col) ) {
	            if ( $sort_col == 'price' &&  isset($cur_direction) ) {
		  	 $price_direction = "<img src='images/cubehelper/arrow_".$cur_direction.".gif' border='0'>";
		    }
		    if ( $sort_col == 'name' &&  isset($cur_direction) ) {
		  	 $desc_direction = "<img src='images/cubehelper/arrow_".$cur_direction.".gif' border='0'>";
		    } 
        }
        $price_href = "<a class='txtDefault' href='index.php?act=viewCat&catId=".$_GET['catId']."&sort=price&direction=".$direction."'>".$lang['front']['viewCat']['price']."</a>".$price_direction;
	$desc_href = "<a class='txtDefault' href='index.php?act=viewCat&catId=".$_GET['catId']."&sort=name&direction=".$direction."'>".$lang['front']['viewCat']['description']."</a>".$desc_direction;
	   
	   $view_cat->assign("LANG_IMAGE",$lang['front']['viewCat']['image']."<img src='images/general/px.gif' width='7' height='16' border='0'");
	   $view_cat->assign("LANG_STATUS",$lang['front']['viewCat']['status']."<img src='images/general/px.gif' width='7' height='16' border='0'");
	   $view_cat->assign("LANG_DESC",$desc_href);
	   $view_cat->assign("LANG_PRICE",$price_href);
	   $view_cat->assign("PAGINATION",$db->paginate($totalNoProducts, $config['productPages'], $page, "page"));
 } else {
 	$view_cat->assign("LANG_IMAGE",$lang['front']['viewCat']['image']);
	$view_cat->assign("LANG_DESC",$lang['front']['viewCat']['description']);
	$view_cat->assign("LANG_PRICE",$lang['front']['viewCat']['price']);
	$view_cat->assign("PAGINATION",$db->paginate($totalNoProducts, $config['productPages'], $page, "page"));
 }
 //***** End --> CubeHelper.com product sorting v1.0 *****


// repeated region
if($productResults == TRUE){
	
	if($_GET['catId']>0){
	
		$view_cat->assign("LANG_CURRENT_DIR",$lang['front']['viewCat']['products_in']);
		$view_cat->assign("CURRENT_DIR",getCatDir(validHTML($currentCat[0]['cat_name']),$currentCat[0]['cat_father_id'], $currentCat[0]['cat_id'], $link=TRUE));
	
	}
	
	for ($i=0; $i<count($productResults); $i++){
	
		// alternate class
		$view_cat->assign("CLASS",cellColor($i, $tdEven="tdEven", $tdOdd="tdOdd"));

		if(file_exists($GLOBALS['rootDir']."/images/uploads/thumbs/thumb_".$productResults[$i]['image'])){
			
			$view_cat->assign("SRC_PROD_THUMB",$GLOBALS['rootRel']."images/uploads/thumbs/thumb_".$productResults[$i]['image']);
		} else {
			$view_cat->assign("SRC_PROD_THUMB",$GLOBALS['rootRel']."skins/".$config['skinDir']."/styleImages/thumb_nophoto.gif");
		}


		$view_cat->assign("TXT_TITLE",validHTML($productResults[$i]['name']));		

		$view_cat->assign("TXT_DESC",substr(strip_tags($productResults[$i]['description']),0,$config['productPrecis'])."&hellip;");
		//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
		include("includes/goobermods/Group_Discounts/mod_part7.php");
		//.: Group Discounts Mod by Goober

		if(salePrice($productResults[$i]['price'], $productResults[$i]['sale_price'])==FALSE){
			$view_cat->assign("TXT_PRICE",priceFormat($productResults[$i]['price']));
		} else {
			$view_cat->assign("TXT_PRICE","<span class='txtOldPrice'>".priceFormat($productResults[$i]['price'])."</span>");
		}
		$salePrice = salePrice($productResults[$i]['price'], $productResults[$i]['sale_price']);
		
		$view_cat->assign("TXT_SALE_PRICE", priceFormat($salePrice));

		if(isset($_GET['add']) && isset($_GET['quan'])){
			
			$view_cat->assign("CURRENT_URL",str_replace(array("&amp;add=".$_GET['add'],"&amp;quan=".$_GET['quan']),"",currentPage()));
			
		} else {
		
			$view_cat->assign("CURRENT_URL",currentPage());
			
		}

		if($config['outofstockPurchase']==1){
			
			$view_cat->assign("BTN_BUY",$lang['front']['viewCat']['buy']);
			$view_cat->assign("PRODUCT_ID",$productResults[$i]['productId']);
			$view_cat->parse("view_cat.productTable.products.buy_btn");
		
		} elseif($productResults[$i]['useStockLevel']==1 && $productResults[$i]['stock_level']>0){
			
			$view_cat->assign("BTN_BUY",$lang['front']['viewCat']['buy']);
			$view_cat->assign("PRODUCT_ID",$productResults[$i]['productId']);
			$view_cat->parse("view_cat.productTable.products.buy_btn");
		
		} elseif($productResults[$i]['useStockLevel']==0){
		
			$view_cat->assign("BTN_BUY",$lang['front']['viewCat']['buy']);
			$view_cat->assign("PRODUCT_ID",$productResults[$i]['productId']);
			$view_cat->parse("view_cat.productTable.products.buy_btn");
		
		}

		$view_cat->assign("BTN_MORE",$lang['front']['viewCat']['more']);
		$view_cat->assign("PRODUCT_ID",$productResults[$i]['productId']);

		if($productResults[$i]['stock_level']<1 && $productResults[$i]['useStockLevel']==1 && $productResults[$i]['digital']==0){
		
			$view_cat->assign("TXT_OUTOFSTOCK",$lang['front']['viewCat']['out_of_stock']);
			
		} else {
		
			$view_cat->assign("TXT_OUTOFSTOCK","");
		
		}
		
### START ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz --> 
		$view_cat->assign("SKIN",$config['skinDir']);
		if($productResults[$i]['hasVideo']=='1') {
		
			$view_cat->parse("view_cat.productTable.products.video_button");
			
		}
### STOP ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz -->
		$view_cat->parse("view_cat.productTable.products");
	}
	$view_cat->parse("view_cat.productTable");

} elseif(isset($_GET['searchStr'])) {

	$view_cat->assign("TXT_NO_PRODUCTS",$lang['front']['viewCat']['no_products_match']." ".treatGet($_GET['searchStr']));
	$view_cat->parse("view_cat.noProducts");

} else {
	
	$view_cat->assign("TXT_NO_PRODUCTS",$lang['front']['viewCat']['no_prods_in_cat']);
	$view_cat->parse("view_cat.noProducts");

}

$view_cat->parse("view_cat");
$page_content = $view_cat->text("view_cat");
?>
