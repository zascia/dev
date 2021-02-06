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
|	info.inc.php
|   ========================================
|	Info & Stats Box	
+--------------------------------------------------------------------------
*/
if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

// query database
//Hide Categories and products, http://cc3.biz
$noProducts = $db->select("SELECT count(productId) as no FROM ".$glob['dbprefix']."CubeCart_inventory WHERE hidden!='yes' and hidden_cat!='yes'");
//$noProducts = $db->select("SELECT count(productId) as no FROM ".$glob['dbprefix']."CubeCart_inventory");
//Hide Categories and products, http://cc3.biz
// query database
//Hide Categories and products, http://cc3.biz
//$noCategories = $db->select("SELECT count(cat_id) as no FROM ".$glob['dbprefix']."CubeCart_category"); 
$noCategories = $db->select("SELECT count(cat_id) as no FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_active = '1'"); 
//Hide Categories and products, http://cc3.biz
 

$box_content=new XTemplate ("skins/".$config['skinDir']."/styleTemplates/boxes/info.tpl");

$box_content->assign("LANG_INFO_TITLE",$lang['front']['boxes']['information']);
$box_content->assign("LANG_INFO_PRODUCTS",$lang['front']['boxes']['products']);
$box_content->assign("DATA_NO_PRODUCTS",$noProducts[0]['no']);
$box_content->assign("LANG_INFO_CATEGORIES",$lang['front']['boxes']['categories']);
$box_content->assign("DATA_NO_CATEGORIES",$noCategories[0]['no']);
$box_content->assign("LANG_INFO_PRICES",$lang['front']['boxes']['prices']);
$box_content->assign("DATA_CURRENCY",$currencyVars[0]['name']);

$box_content->parse("info");

$box_content = $box_content->text("info");
?>
