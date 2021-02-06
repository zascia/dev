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
|	popularProducts.inc.php
|   ========================================
|	Display the most Popular Products	
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

// query database
//Hide Categories and products, http://cc3.biz
$popularProds = $db->select("SELECT name, productId FROM ".$glob['dbprefix']."CubeCart_inventory WHERE hidden!='yes' and hidden_cat!='yes' ORDER BY popularity DESC",$config['noPopularBoxItems']);
//$popularProds = $db->select("SELECT name, productId FROM ".$glob['dbprefix']."CubeCart_inventory ORDER BY popularity DESC",$config['noPopularBoxItems']);
//Hide Categories and products, http://cc3.biz

$box_content = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/boxes/popularProducts.tpl");

$box_content->assign("LANG_POPULAR_PRODUCTS_TITLE",$lang['front']['boxes']['popular_products']);

if($popularProds == TRUE){
	// start loop
	for ($i=0; $i<count($popularProds); $i++){
		
		if(($val = prodAltLang($popularProds[$i]['productId'])) == TRUE){
			
				$popularProds[$i]['name'] = str_replace('\\','',$val['name']);
		
		}
		$popularProds[$i]['name'] = str_replace('\\','',validHTML($popularProds[$i]['name']));
		$box_content->assign("DATA",$popularProds[$i]);
		$box_content->parse("popular_products.li");
	
	} // end loop
} 
$box_content->parse("popular_products");
$box_content = $box_content->text("popular_products");
?>
