<?php  

/*
+--------------------------------------------------------------------------
|   Store selector v1.0
|   Created by convict.sk (c)2006
|
|   CubeCart v3.0.X 
|   Copyright Devellion Limited 2005 - 2006. All rights reserved.
|   ========================================
|	stores.inc.php
|   ========================================
|	Stores Jump Box Copyright convict (c)2006
+--------------------------------------------------------------------------
*/

if(!isset($config)){
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}
if ($store_selector['status']==1 && $store_selector['frontend']==1) {

	$path = $GLOBALS['rootDir']."/skins";
	if ($dir = opendir($path)) {
		$returnPage = "";
		$returnPage = urlencode(currentPage());

		while (false !== ($file = readdir($dir))) if(!eregi($file,array(".",".."))) $skinArray[] = $file;
	}

	$top_cats_results = $db->select("SELECT cat_name, cat_id FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_father_id = 0 ORDER BY cat_name");

	for ($i=0;$i<count($top_cats_results);$i++) {
	
		if ($store_selector['frontend_name']==1) {
			// cat names	
			$storeArray[$top_cats_results[$i]['cat_id']] = $top_cats_results[$i]['cat_name'];
		
		} elseif (isset($store_selector[$top_cats_results[$i]['cat_id']]) && !empty($store_selector[$top_cats_results[$i]['cat_id']] )) {
			// skin names (skin must exists)	
			$storeArray[$top_cats_results[$i]['cat_id']] = $store_selector[$top_cats_results[$i]['cat_id']];
		}
	}
	
	if($store_selector['sale_items_show']==1 && empty($storeArray)){ $storeArray['saleItems'] = "Sale Items"; }

	if (!empty($storeArray)) {
	
		$box_content = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/boxes/store.tpl");
		$box_content->assign("LANG_SKIN_TITLE","Store");

		asort($storeArray);
		reset ($storeArray);

		if($store_selector['sale_items_show']==1){ $storeArray['saleItems'] = "Sale Items"; }

		$box_content->assign("STORE_NAME","Home Page");
		$box_content->assign("STORE_VAL","");
		$box_content->assign("VAL_CURRENT_PAGE","index.php");
		$box_content->parse("store.home");

		foreach ($storeArray as $cat => $Target ) {

			if (($store_selector['frontend_name']==1 && $cat==$topCategory) OR ($store_selector['frontend_name']==0 && $Target==$store_selector[$topCategory])) {
				$box_content->assign("STORE_SELECTED","selected='selected'");
			} else {
				$box_content->assign("STORE_SELECTED","");
			}
					
			$box_content->assign("STORE_NAME",$Target);
			$box_content->assign("STORE_VAL",$cat);
			$box_content->assign("VAL_CURRENT_PAGE",$returnPage);
			$box_content->parse("store.option");
		}

		$box_content->parse("store");
		$box_content = $box_content->text("store");
	}

} else {

	$box_content = "";

}
// SaleItems hack back
if ($topCategory == "saleItems") {$topCategory = "-1";}
?>