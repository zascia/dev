<?php  
 

/*
+--------------------------------------------------------------------------
|   Store selector v1.0
|   Created by convict.sk (c)2006
|
|   CubeCart Copyright Devellion Limited 2005 - 2006. All rights reserved.
+--------------------------------------------------------------------------
|	3rdp_topcat.inc.php
|   ========================================
|	Get top cat and skin
+--------------------------------------------------------------------------
*/
$store_selector = fetchDbConfig("Store_Selector");

if ($store_selector['status']==1):

if (!function_exists('GetCatTree')):
function GetCatTree (&$CatTree,$currentCat) {

	global $db, $glob;
	
	$topCat = $db->select("SELECT cat_father_id FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_id = $currentCat");

	if ($topCat[0]['cat_father_id'] != 0) {
		$CatTree[]=$topCat[0]['cat_father_id'];	
		GetCatTree($CatTree,$topCat[0]['cat_father_id']);
	}
	return;
} 
endif;

$prodCat = $db->select("SELECT cat_id FROM ".$glob['dbprefix']."CubeCart_inventory WHERE productId = ". $db->mySQLSafe($_GET['productId']));
$currCat = $db->select("SELECT cat_id FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_id = ". $db->mySQLSafe($_GET['catId'])); // check only

$currentCategory = ($prodCat != true) ? $currCat[0]['cat_id'] : $prodCat[0]['cat_id'];

if (!empty($currentCategory)) {
	$catTreeIn[0] = $currentCategory;	
	GetCatTree ($catTreeIn,$currentCategory);
	$catTreeIn = array_reverse($catTreeIn);
	$topCategory = $catTreeIn[0];
} else {
	$topCategory = "-1";
}

// SaleItems hack
if ($_GET['catId']=="saleItems") {$topCategory = "saleItems";}

// check top level category and set up skin
if (!empty($topCategory) && isset($store_selector[$topCategory]) && !empty($store_selector[$topCategory])) {
	
	$store_skin = (is_dir($GLOBALS['rootDir']."/skins/".$store_selector[$topCategory])) ? $store_selector[$topCategory] : $config['skinDir'];

} else {
	
	$store_skin = $config['skinDir'];
}

$config['skinDir'] = $store_skin;



endif;
?>