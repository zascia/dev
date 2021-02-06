<?php  
 

/*
+--------------------------------------------------------------------------
|   CubeCart v3.0.x
|   ========================================
|   by Alistair Brookbanks
|	CubeCart is a Trade Mark of Devellion Limited
|   Copyright Devellion Limited 2005 - 2006. All rights reserved.
+--------------------------------------------------------------------------
|	manufacturers.inc.php
|   ========================================
|	Manufacturers by convict http://cubecartmods.eu
+--------------------------------------------------------------------------
*/
if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}
$cman_config = fetchDbConfig("Manufacturers");
//$lang['front']['boxes']['shop_by_manufacturer'] = "Manufacturers";
//$lang['front']['boxes']['select_manufacturer'] = "Select Manufacturer";
$manufacturer_list = $db->select("SELECT DISTINCT manufacturer FROM ".$glob['dbprefix']."CubeCart_inventory WHERE manufacturer != '' ORDER BY manufacturer ASC");

if($cman_config['status']==1 && $manufacturer_list == TRUE && $cman_config['man_box']!=0){
	
	$box_content=new XTemplate ("skins/".$config['skinDir']."/styleTemplates/boxes/manufacturers.tpl");
	$box_content->assign("LANG_TITLE",$lang['front']['boxes']['shop_by_manufacturer']);
	
	for ($i=0; $i<count($manufacturer_list); $i++){
		
		$manufacturer_list[$i]['manufacturer'] = validHTML($manufacturer_list[$i]['manufacturer']);
	
		$box_content->assign("MANUFACTURER",$manufacturer_list[$i]['manufacturer']);
		$box_content->assign("MANUFACTURER_C",base64_encode($manufacturer_list[$i]['manufacturer']));
		if ($cman_config['man_box']==2){
		################################################################
		# LIST
		$box_content->parse("manufacturers.list.li");
		################################################################
		} elseif ($cman_config['man_box']==1){
		################################################################
		# DROPDOWN
		if (isset($_GET['manuf']) && base64_decode($_GET['manuf']) == $manufacturer_list[$i]['manufacturer']) {
			$box_content->assign("SELECTED","selected=\"selected\"");
		} else {
			$box_content->assign("SELECTED","");
		}
		$box_content->parse("manufacturers.dropdown.option");
		################################################################
		}
		
	} // end for loop

	if ($cman_config['man_box']==2){
	################################################################
	# LIST
	$box_content->parse("manufacturers.list");
	################################################################
	} elseif ($cman_config['man_box']==1){
	################################################################
	# DROPDOWN
	$box_content->assign("SELECT_MANUFACTURER",$lang['front']['boxes']['select_manufacturer']);
	$box_content->parse("manufacturers.dropdown");
	################################################################
	}
	$box_content->parse("manufacturers");
	$box_content = $box_content->text("manufacturers");
} else {
	$box_content = "";
}
?>