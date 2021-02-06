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
|	siteDocs.inc.php
|   ========================================
|	Build Links to Site Docs	
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

// query database
$results = $db->select("SELECT doc_id, doc_name FROM ".$glob['dbprefix']."CubeCart_docs ORDER BY doc_name ASC");

$resultsForeign = $db->select("SELECT doc_master_id as doc_id, doc_name FROM ".$glob['dbprefix']."CubeCart_docs_lang WHERE doc_lang = '".$lang_folder."'"); 

$box_content = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/boxes/siteDocs.tpl");

// build attributes
if($results == TRUE){

	// start loop
	for ($i=0; $i<count($results); $i++){
 	
		if($i<count($results)-1){
			$box_content->parse("site_docs.a.sep");
		}
		
		
		if(is_array($resultsForeign)){
			
			for ($k=0; $k<count($resultsForeign); $k++){
		
				if($resultsForeign[$k]['doc_id'] == $results[$i]['doc_id']){
				
					$results[$i]['doc_name'] = $resultsForeign[$k]['doc_name'];
				
				}
				
			}
		
		}
		
		$results[$i]['doc_name'] = validHTML($results[$i]['doc_name']);
		$box_content->assign("DATA",$results[$i]);
		$box_content->parse("site_docs.a");
	
	} // end loop 
}
$box_content->parse("site_docs");
$box_content = $box_content->text("site_docs");
?>