<?php  
 

/*
+--------------------------------------------------------------------------
|   CubeCart v3.0.16
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
|   Date: Wednesday, 9th May 2007
|   Email: sales (at) cubecart (dot) com
|	License Type: CubeCart is NOT Open Source Software and Limitations Apply 
|   Licence Info: http://www.cubecart.com/site/faq/license.php
+--------------------------------------------------------------------------
|	faqCats.inc.php
|   ========================================
|	Top-level FAQ Categories Box	
+--------------------------------------------------------------------------
*/
if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

// query database
$results = $db->select("SELECT faqCat_name, faqCat_id FROM ".$glob['dbprefix']."CubeCart_faq_category WHERE faqCat_father_id = 0");

$resultsForeign = $db->select("SELECT faqCat_master_id as faqCat_id, faqCat_name FROM ".$glob['dbprefix']."CubeCart_faq_cats_lang WHERE faqCat_lang = '".$lang_folder."'");  

$box_content=new XTemplate ("skins/".$config['skinDir']."/styleTemplates/boxes/faqCats.tpl");

$box_content->assign("FAQ_CATS_TITLE",$lang['front']['faqs']['faq_cats']);

	// loop results
	if($results == TRUE){
		for ($i=0; $i<count($results); $i++){
		
			if(is_array($resultsForeign)){
				
				for ($k=0; $k<count($resultsForeign); $k++){
			
					if($resultsForeign[$k]['faqCat_id'] == $results[$i]['faqCat_id']){
					
						$results[$i]['faqCat_name'] = validHTML($resultsForeign[$k]['faqCat_name']);
					
					}
					
				}
			
			} else {
				$results[$i]['faqCat_name'] = validHTML($results[$i]['faqCat_name']);
			}
			
			$box_content->assign("DATA",$results[$i]);
			$box_content->parse("faq_cats.li");
		} // end for loop
	}
	
$box_content->parse("faq_cats");
$box_content = $box_content->text("faq_cats");
?>