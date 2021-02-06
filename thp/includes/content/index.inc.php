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
|	index.inc.php
|   ========================================
|	The Homepage :O)	
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}
// Home Page Product v1.0 by convict http://cubecartmods.eu -->
$hpp_config = fetchDbConfig("Home_Page_Product");
if ($hpp_config['status']==1) {
	@include ("homeProd.inc.php");
}
// <-- Home Page Product v1.0 by convict
$index=new XTemplate ("skins/".$config['skinDir']."/styleTemplates/content/index.tpl");

// Home Page Product v1.0 by convict http://cubecartmods.eu -->
if (empty($hpp_config['status']) OR isset($hpp_config['error'])) {

	include("language/".$lang_folder."/home.inc.php");

	if($home['enabled']==0){

		include("language/".$config['defaultLang']."/home.inc.php");

	}

	$index->assign("HOME_TITLE",validHTML(stripslashes($home['title'])));
	$index->assign("HOME_CONTENT",stripslashes($home['copy']));
	$index->parse("index.home");
}
// <-- Home Page Product v1.0 by convict

//Hide Categories and products, http://cc3.biz
//$latestProducts = $db->select("SELECT productId, image, price, name, sale_price FROM ".$glob['dbprefix']."CubeCart_inventory WHERE `showFeatured` = 1 ORDER BY productId DESC LIMIT ".$config['noLatestProds']);
$latestProducts = $db->select("SELECT productId, image, price, name, sale_price, hasVideo FROM ".$glob['dbprefix']."CubeCart_inventory WHERE `showFeatured` = 1 AND hidden!='yes' and hidden_cat!='yes' ORDER BY productId DESC LIMIT ".$config['noLatestProds']);
//Hide Categories and products, http://cc3.biz


if($config['showLatestProds']==1 && $latestProducts==TRUE){
	
	for($i=0;$i<count($latestProducts);$i++){
	
		if(($val = prodAltLang($latestProducts[$i]['productId'])) == TRUE){
			
				$latestProducts[$i]['name'] = $val['name'];
		
		}
	
		if(file_exists($GLOBALS['rootDir']."/images/uploads/thumbs/thumb_".$latestProducts[$i]['image'])){
			
			$index->assign("VAL_IMG_SRC",$GLOBALS['rootRel']."images/uploads/thumbs/thumb_".$latestProducts[$i]['image']);
		
		} else {
		
			$index->assign("VAL_IMG_SRC",$GLOBALS['rootRel']."skins/".$config['skinDir']."/styleImages/thumb_nophoto.gif");
		
		}
	$index->assign("LANG_LATEST_PRODUCTS",$lang['front']['index']['latest_products']);
	//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
	include("includes/goobermods/Group_Discounts/mod_part8.php");
	//.: Group Discounts Mod by Goober
	
	if(salePrice($latestProducts[$i]['price'], $latestProducts[$i]['sale_price'])==FALSE){
			
			$index->assign("TXT_PRICE",priceFormat($latestProducts[$i]['price']));
	
	} else {
			
			$index->assign("TXT_PRICE","<span class='txtOldPrice'>".priceFormat($latestProducts[$i]['price'])."</span>");
	
	}
		
		$salePrice = salePrice($latestProducts[$i]['price'], $latestProducts[$i]['sale_price']);
		
	$index->assign("VAL_WIDTH", $config['gdthumbSize']+75);
		
	$index->assign("TXT_SALE_PRICE", priceFormat($salePrice));
	
	$index->assign("VAL_PRODUCT_ID",$latestProducts[$i]['productId']);
	
	$index->assign("VAL_PRODUCT_NAME",validHTML($latestProducts[$i]['name']));
	
### START ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz --> 
	$index->assign("SKIN",$config['skinDir']);
	if($latestProducts[$i]['hasVideo']=='1') {
		$index->parse("index.latest_prods.repeat_prods.video_button");
	}
### STOP ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz --> 
	$index->parse("index.latest_prods.repeat_prods");
	
	}
	
	$index->parse("index.latest_prods");	

	///////////////////////
//// CATAGORIES

// build query
$query = "SELECT * FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_father_id = ".$db->mySQLSafe(0)." ORDER BY cat_name ASC";

// get category array in foreign innit
$resultsForeign = $db->select("SELECT cat_master_id as cat_id, cat_name FROM ".$glob['dbprefix']."CubeCart_cats_lang WHERE cat_lang = '".$lang_folder."'");

// query database
$subCategories = "";
$subCategories = $db->select($query);

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
    $index->assign("IMG_CATEGORY",$GLOBALS['rootRel']."skins/".$config['skinDir']."/styleImages/catnophoto.gif");
  } else {
    $index->assign("IMG_CATEGORY",$GLOBALS['rootRel']."images/uploads/".$subCategories[$i]['cat_image']);
  }
 
  $index->assign("TXT_LINK_CATID",$subCategories[$i]['cat_id']);

  $index->assign("TXT_CATEGORY", validHTML($subCategories[$i]['cat_name']));
 
  $index->assign("NO_PRODUCTS", $subCategories[$i]['noProducts']);
 
  $index->parse("index.sub_cats.sub_cats_loop");

} // end loop results
$index->parse("index.sub_cats");
// end $subCategories

}

$index->parse("index");

// Home Page Product v1.0 by convict http://cubecartmods.eu -->

// Replacement
$page_content .= $index->text("index");
// <-- Home Page Product v1.0 by convict
?>
