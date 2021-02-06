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
|	categories.inc.php
|   ========================================
|	Categories Box	
+--------------------------------------------------------------------------
*/
if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}
// Store selector mod by convict (c)2006 -->
if (!function_exists('GetCatTree')):
// --> Store selector mod by convict (c)2006

function GetCatTree (&$CatTree,$currentCat) {

	global $db, $glob;

	$topCat = $db->select("SELECT cat_father_id FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_id = $currentCat");

	if ($topCat[0]['cat_father_id'] != 0) {
		$CatTree[]=$topCat[0]['cat_father_id'];
		GetCatTree($CatTree,$topCat[0]['cat_father_id']);
	}
	return;
}

// Store selector mod -->
endif;
// < -- Store selector mod
function BuildCatTree (&$box_c,$cat_father_id=0,$catlevel=1) {
	global $db, $glob, $resultsForeign, $catTreeIn, $currentCategory;

	$results = $db->select("SELECT cat_name, cat_id, noProducts, $catlevel as cat_level FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_father_id = $cat_father_id AND cat_active = '1' ORDER BY cat_name");
//print_r($results);
	if($results == TRUE){

		$catlevel++;

		if ($store_selector['status']==1 && $store_selector['hidetop']==1) {
			$levels = $catlevel;
			$levels_no = 2;
		} else {
			$levels = $cat_father_id;
			$levels_no = 0;
		}
		for ($i=0; $i<count($results); $i++){

			if(is_array($resultsForeign)){

				for ($k=0; $k<count($resultsForeign); $k++){

					if($resultsForeign[$k]['cat_id'] == $results[$i]['cat_id']){

						$results[$i]['cat_name'] = $resultsForeign[$k]['cat_name'];

					}

				}

			} else {
				$results[$i]['cat_name'] = $results[$i]['cat_name'];
			}

			$products = ($results[$i]['noProducts']==0) ? "" : "(".$results[$i]['noProducts'].")";

			$box_c->assign("DATA",$results[$i]);

			$isFather =  $db->select("SELECT cat_id FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_father_id = ".$results[$i]['cat_id']);


			if ($levels==$levels_no) {
				$box_c->parse("categories.cats.cats_topcat_start");
				$box_c->parse("categories.cats");
			}


			if ($isFather==TRUE) {

				if ((is_array($catTreeIn) && in_array($results[$i]['cat_id'],$catTreeIn)) && (isset($currentCategory) && $results[$i]['cat_id'] == $currentCategory)) {
					$box_c->parse("categories.cats.cats_father_start_open_current");
				} elseif (is_array($catTreeIn) && in_array($results[$i]['cat_id'],$catTreeIn)) {
					$box_c->parse("categories.cats.cats_father_start_open");
				} else {
					$box_c->parse("categories.cats.cats_father_start");
				}

				$box_c->parse("categories.cats");

			} else {

				if (isset($currentCategory) && $results[$i]['cat_id'] == $currentCategory) {
					$box_c->parse("categories.cats.cats_simple_current");
				} else {
					$box_c->parse("categories.cats.cats_simple");
				}
				$box_c->parse("categories.cats");
			}

			BuildCatTree ($box_c, $results[$i]['cat_id'], $catlevel);

			if ($levels==$levels_no){
				$box_c->parse("categories.cats.cats_topcat_end");
				$box_c->parse("categories.cats");
			}

		}

		if ($levels!=$levels_no) {
				$box_c->parse("categories.cats.cats_father_end");
				$box_c->parse("categories.cats");
		}

	}

	return;
}
// query database
$results = $db->select("SELECT cat_name, cat_id FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_father_id = 0");

$resultsForeign = $db->select("SELECT cat_master_id as cat_id, cat_name FROM ".$glob['dbprefix']."CubeCart_cats_lang WHERE cat_lang = '".$lang_folder."'");  

$box_content=new XTemplate ("skins/".$config['skinDir']."/styleTemplates/boxes/categories.tpl");

$box_content->assign("LANG_CATEGORY_TITLE",$lang['front']['boxes']['shop_by_cat']);

	$box_content->assign("LANG_HOME",$lang['front']['boxes']['homepage']);
// Store selector mod by convict (c)2006 -->
$father_cat = 0;

if ($store_selector['status']!=1) {
// --> Store selector mod by convict (c)2006
// Advanced Expanding Category Links by convict (c)2006 http://cubecartmods.eu -->
$prodCat = $db->select("SELECT cat_id FROM ".$glob['dbprefix']."CubeCart_inventory WHERE productId = ". $db->mySQLSafe($_GET['productId']));
$currCat = $db->select("SELECT cat_id FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_id = ". $db->mySQLSafe($_GET['catId'])); // check only

$currentCategory = ($prodCat != true) ? $currCat[0]['cat_id'] : $prodCat[0]['cat_id'];

if (isset($currentCategory)) {

	$catTreeIn[0] = $currentCategory;
	GetCatTree ($catTreeIn,$currentCategory);
	$catTreeIn = array_reverse($catTreeIn);
}

} elseif ($store_selector['status']==1 && $store_selector['hidetop']==1) {

	$father_cat = $topCategory;
}

BuildCatTree ($box_content,$father_cat);
// --> Store selector mod by convict (c)2006

if($config['saleMode']>0){
	$box_content->assign("LANG_SALE_ITEMS",$lang['front']['boxes']['sale_items']);
	$box_content->parse("categories.sale");
}
	//FAQ link in category box
	$faq_config = fetchDbConfig("FAQ_Management");
	if ($faq_config['status']==1 && $config['showFAQs']==1)  { 
		$box_content->assign("FAQ",$lang['front']['faqs']['faqs']);
		$box_content->parse("categories.faq");
	}

$box_content->parse("categories");
$box_content = $box_content->text("categories");

// <-- Advanced Expanding Category Links by convict
?>
