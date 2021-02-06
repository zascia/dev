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
|	searchForm.inc.php
|   ========================================
|	Search Box	
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}
// grishick's relevant_search MOD 2006 START -->
$relevant_search_config = fetchDbConfig("relevant_search");
// grishick's relevant_search MOD 2006 END -->
$box_content = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/boxes/searchForm.tpl");

$box_content->assign("LANG_SEARCH_FOR",$lang['front']['boxes']['search_for']);
if(isset($_GET['searchStr'])){
	$box_content->assign("SEARCHSTR",treatGet($_GET['searchStr']));
} else {
	$box_content->assign("SEARCHSTR","");
}
// grishick's relevant_search MOD 2006 START -->
if($relevant_search_config['status']==1) {
	$box_content->assign("FORM_ACTION","doSearch");
} else {
	$box_content->assign("FORM_ACTION","viewCat");
}
// grishick's relevant_search MOD 2006 END -->
$box_content->assign("LANG_GO",$lang['front']['boxes']['go']);
		
$box_content->parse("search_form");
$box_content = $box_content->text("search_form");
?>