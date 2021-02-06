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
|	viewFAQ.inc.php
|   ========================================
|	Displays an FAQ	by MarksCarts http://cc3.biz
+--------------------------------------------------------------------------
*/
// query database

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}
// query database
$_GET['faqId'] = treatGet($_GET['faqId']);
$query = "SELECT faq_id, question, answer, faqCat_name, ".$glob['dbprefix']."CubeCart_faqs.faqCat_id, faqCat_father_id, noFAQs FROM ".$glob['dbprefix']."CubeCart_faqs INNER JOIN ".$glob['dbprefix']."CubeCart_faq_category ON ".$glob['dbprefix']."CubeCart_faqs.faqCat_id = ".$glob['dbprefix']."CubeCart_faq_category.faqCat_id where faq_id = ".$db->mySQLSafe($_GET['faqId']);

$faqArray = $db->select($query);

$meta['siteTitle'] = $config['siteTitle']." - ".$faqArray[0]['question'];
$meta['metaDescription'] = substr(strip_tags($faqArray[0]['answer']),0,35);

$view_faq=new XTemplate ("skins/".$config['skinDir']."/styleTemplates/content/viewFAQ.tpl");

if($faqArray == TRUE){
	
	$val = "";
	
	if(($val = faqAltLang($faqArray[0]['faq_id'])) == TRUE){
				
		$faqArray[0]['question'] = $val['question'];
		$faqArray[0]['answer'] = $val['answer'];
			
	}

	$view_faq->assign("TXT_Q",validHTML($faqArray[0]['question']));
	$view_faq->assign("TXT_A",$faqArray[0]['answer']);
	$view_faq->assign("CURRENT_DIR",getFAQDir($faqArray[0]['faqCat_name'],$faqArray[0]['faqCat_father_id'], $faqArray[0]['faqCat_id'],$link=TRUE));
	$view_faq->assign("LANG_DIR_LOC",$lang['front']['faqs']['location']);
	$view_faq->parse("view_faq.faq_true");
	
} else {

	$view_faq->assign("NON_FAQ",$lang['front']['faqs']['non_faq']);
	$view_faq->parse("view_faq.faq_false");
	
}

$view_faq->parse("view_faq");
$page_content = $view_faq->text("view_faq");
?>