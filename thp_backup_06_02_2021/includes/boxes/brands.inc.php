<?php  
/*
+--------------------------------------------------------------------------
|   CubeCart v3
|   ========================================
|   by Alistair Brookbanks
|   CubeCart is a Trade Mark of Devellion Limited
+--------------------------------------------------------------------------
|   brands.inc.php
|   ========================================
|   Brand / Manufacturer Box	
+--------------------------------------------------------------------------
*/
// query database
$results = $db->select("SELECT cat_name, cat_id FROM ".$glob['dbprefix']."CubeCart_category WHERE cat_father_id = 0 AND cat_brand = '0' AND cat_active = '1'"); 

$box_content=new XTemplate ("skins/".$config['skinDir']."/styleTemplates/boxes/brands.tpl");

$box_content->assign("LANG_BRAND_TITLE",$lang['front']['boxes']['shop_by_brand']);

$box_content->assign("LANG_HOME",$lang['front']['boxes']['homepage']);

// loop results
if($results == TRUE){
	for ($i=0; $i<count($results); $i++){
		if (isset($_GET['catId']) && $_GET['catId']==$results[$i]['cat_id']) {
			$box_content->assign("SELECTED",'selected="selected"');
		} else {
			$box_content->assign("SELECTED",'');
		}
		$box_content->assign("DATA",$results[$i]);
		$box_content->parse("categories.option");
	} // end for loop
	
    $box_content->parse("categories");
    $box_content = $box_content->text("categories");
		
} else {
	
    $box_content = "";
	
}
?>
