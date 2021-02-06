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
|	ourFavorites.inc.php
|   ========================================
|	"Our Favorite Products" slideshow by MarksCarts (http://cc3.biz)	
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

$box_content=new XTemplate ("skins/".$config['skinDir']."/styleTemplates/boxes/ourFavorites.tpl");

$favoriteProducts = $db->select("SELECT productId, image, name FROM ".$glob['dbprefix']."CubeCart_inventory WHERE hidden!='yes' and hidden_cat!='yes' AND showFavorites = 1 ORDER BY productId DESC LIMIT ".$config['numberSlides']);

if ($config['showSlides']==1 && $favoriteProducts==TRUE) {
	
	for($i=0;$i<count($favoriteProducts);$i++){
		
		if(($val = prodAltLang($favoriteProducts[$i]['productId'])) == TRUE){
		
		$favoriteProducts[$i]['name'] = $val['name'];
		}
		if(file_exists($GLOBALS['rootDir']."/images/uploads/thumbs/thumb_".$favoriteProducts[$i]['image'])){
			$box_content->assign("VAL_IMG_SRC", $GLOBALS['rootRel']."images/uploads/thumbs/thumb_".$favoriteProducts[$i]['image']);
		} else {
			$box_content->assign("VAL_IMG_SRC",$GLOBALS['rootRel']."skins/".$config['skinDir']."/styleImages/thumb_nophoto.gif");
		}
	$box_content->assign("NUM",$i);
		
	$box_content->assign("VAL_PRODUCT_ID",$favoriteProducts[$i]['productId']);
		
	if ($config['showProdName']==1) {	
		$box_content->assign("VAL_PRODUCT_NAME",validHTML($favoriteProducts[$i]['name']));
		} else {
		$box_content->assign("VAL_PRODUCT_NAME","");
		}
	$box_content->parse("ourFavorites.favorite_prods.repeat_prods");
	}
	
	if (isset ($config['slideShowName'])) {
		$box_content->assign("LANG_FAVORITE_PRODUCTS",$config['slideShowName']);
		} else {
		$box_content->assign("LANG_FAVORITE_PRODUCTS","Our Favorites");
		} 
	if ($config['showProdName']==1) {	
		$box_content->assign("W", $config['gdthumbSize']+$config['nameSpaceW']);
		$box_content->assign("H", $config['gdthumbSize']+$config['nameSpaceH']);
		} else {
		$box_content->assign("W", $config['gdthumbSize']+0);
		$box_content->assign("H", $config['gdthumbSize']+0);
		}
	if (isset ($config['topPadding'])) {
		$box_content->assign("PAD",$config['topPadding']); //set name in ACP
		} else {
		$box_content->assign("PAD","5");}
	
	if ($config['randomize']==1) {	
		$box_content->assign("RANDOM",", \"R\"");
		} else {
		$box_content->assign("RANDOM","");
		}
	if (isset ($config['bgColor'])) {
		$box_content->assign("BG_COLOR",$config['bgColor']); //set background color in ACP
		} else {
		$box_content->assign("BG_COLOR","#FFFFFF");
		} 
	if (isset ($config['slideSpeed'])) {
		$box_content->assign("SPEED", $config['slideSpeed']); //set speed according to ACP speed setting
		} else {
		$box_content->assign("SPEED", "2000");
		} 
	if (isset ($config['pauseSlide'])) {
		$box_content->assign("PAUSE", $config['pauseSlide']); 
		} else {
		$box_content->assign("PAUSE", "0");
		} 
		
	$box_content->parse("ourFavorites.favorite_prods");	

}

$box_content->parse("ourFavorites");
$box_content = $box_content->text("ourFavorites");
?>
