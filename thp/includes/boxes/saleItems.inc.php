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
|	saleItems.inc.php
|   ========================================
|	Sales Items Box	
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

// query database

//Hide Categories and products, http://cc3.biz
$saleItems = $db->select("SELECT name, productId, price, sale_price, price - sale_price as saving FROM ".$glob['dbprefix']."CubeCart_inventory WHERE hidden!='yes' and hidden_cat!='yes' and price > sale_price AND sale_price > 0 ORDER BY saving ASC",$config['noSaleBoxItems']);
//$saleItems = $db->select("SELECT name, productId, price, sale_price, price - sale_price as saving FROM ".$glob['dbprefix']."CubeCart_inventory WHERE price > sale_price AND sale_price > 0 ORDER BY saving DESC",$config['noSaleBoxItems']);
//Hide Categories and products, http://cc3.biz

if($saleItems == TRUE && $config['saleMode']>0){

$salePrice = 0;

$box_content=new XTemplate ("skins/".$config['skinDir']."/styleTemplates/boxes/saleItems.tpl");

$box_content->assign("LANG_SALE_ITEMS_TITLE",$lang['front']['boxes']['sale_items']);

	for($i=0;$i<count($saleItems);$i++){
			
			
			
			if(($val = prodAltLang($saleItems[$i]['productId'])) == TRUE){
			
				$saleItems[$i]['name'] = $val['name'];
		
			}
			
			$salePrice = salePrice($saleItems[$i]['price'], $saleItems[$i]['sale_price']);
			$saleItems[$i]['name'] = validHTML($saleItems[$i]['name']);
			$box_content->assign("DATA",$saleItems[$i]);
			$box_content->assign("SAVING",priceFormat($saleItems[$i]['price'] - $salePrice));
			$box_content->assign("LANG_SAVE",$lang['front']['boxes']['save']);
			$box_content->parse("sale_items.li");
	
	} // end loop
	
$box_content->parse("sale_items");
$box_content = $box_content->text("sale_items"); 

} else {
	
	$box_content = "";

}
?>
