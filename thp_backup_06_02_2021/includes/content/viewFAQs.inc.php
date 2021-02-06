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
|	viewFAQs.inc.php by MarksCarts
|   ========================================
|	Displays a list of FAQ topics and Q & A list
+--------------------------------------------------------------------------
*/
//Function to trim string using words
function strtrim($str, $maxlen=500, $elli=NULL, $maxoverflow=15) {
    global $CONF;
        
    if (strlen($str) > $maxlen) {
            
        if ($CONF["BODY_TRIM_METHOD_STRLEN"]) {
            return substr($str, 0, $maxlen);
        }
            
        $output = NULL;
        $body = explode(" ", $str);
        $body_count = count($body);
        
        $i=0;
    
        do {
            $output .= $body[$i]." ";
            $thisLen = strlen($output);
            $cycle = ($thisLen < $maxlen && $i < $body_count-1 && ($thisLen+strlen($body[$i+1])) < $maxlen+$maxoverflow?true:false);
            $i++;
        } while ($cycle);
        return $output.$elli;
    }
    else return $str;
}
if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

if(isset($_GET['page'])){
	
	$page = treatGet($_GET['page']);

} else {
	
	$page = 0;

}

$view_faqs=new XTemplate ("skins/".$config['skinDir']."/styleTemplates/content/viewFAQs.tpl");

### Mod must be enabled in order for content to show
$faq_config = fetchDbConfig("FAQ_Management");
if ($faq_config['status']==1)  {

### Build FAQ subcategory tree
if(isset($_GET['faqCatId']) && $_GET['faqCatId']>0) {
	$_GET['faqCatId'] = treatGet($_GET['faqCatId']);
	// build query
	$query = "SELECT * FROM ".$glob['dbprefix']."CubeCart_faq_category WHERE faqCat_father_id = ".$db->mySQLSafe($_GET['faqCatId'])." ORDER BY faqCat_name ASC";
	
	// get category array in foreign innit
	$resultsForeign = $db->select("SELECT faqCat_master_id as faqCat_id, faqCat_name FROM ".$glob['dbprefix']."CubeCart_faq_cats_lang WHERE faqCat_lang = '".$lang_folder."'");
	
	// query database
	$subCategories = "";
	$subCategories = $db->select($query);

} elseif($_GET['faqCatId']==0) {
	$_GET['faqCatId'] = treatGet($_GET['faqCatId']);
	// build query
	$query = "SELECT * FROM ".$glob['dbprefix']."CubeCart_faq_category WHERE faqCat_father_id = 0 ORDER BY faqCat_name ASC";
	
	// get category array in foreign innit
	$resultsForeign = $db->select("SELECT faqCat_master_id as faqCat_id, faqCat_name FROM ".$glob['dbprefix']."CubeCart_faq_cats_lang WHERE faqCat_lang = '".$lang_folder."'");
	
	// query database
	$subCategories = "";
	$subCategories = $db->select($query);
}

if(isset($_GET['faqCatId']) && $subCategories == TRUE) {

// loop results
for ($i=0; $i<count($subCategories); $i++){
		
			if(is_array($resultsForeign)){
	
				for ($k=0; $k<count($resultsForeign); $k++){
	
					if($resultsForeign[$k]['faqCat_id'] == $subCategories[$i]['faqCat_id']){
					
						$subCategories[$i]['faqCat_name'] = $resultsForeign[$k]['faqCat_name'];
					
					}
					
				}
			
			}

		$view_faqs->assign("TXT_LINK_CATID",$subCategories[$i]['faqCat_id']);

		$view_faqs->assign("TXT_FAQ_CATEGORY", validHTML($subCategories[$i]['faqCat_name']));
		
		$view_faqs->assign("NO_FAQS", $subCategories[$i]['noFAQs']);
		
		$view_faqs->parse("view_faqs.sub_cats.sub_cats_loop");
	
	} // end loop results
$view_faqs->parse("view_faqs.sub_cats");
} // end $subCategories == TRUE


### Build FAQ list data

//set a default value for number of FAQs per page to prevent division by zero errors
if($config['faqPages']>0) {
	$noFAQs = $config['faqPages'];
} else {
	$noFAQs = 15;
}

$faqListQuery = "SELECT ".$glob['dbprefix']."CubeCart_faq_idx.faqCat_id, ".$glob['dbprefix']."CubeCart_faq_idx.faq_id, question, answer FROM ".$glob['dbprefix']."CubeCart_faq_idx INNER JOIN ".$glob['dbprefix']."CubeCart_faqs ON ".$glob['dbprefix']."CubeCart_faq_idx.faq_id = ".$glob['dbprefix']."CubeCart_faqs.faq_id WHERE ".$glob['dbprefix']."CubeCart_faq_idx.faqCat_id = ".$db->mySQLSafe($_GET['faqCatId']);
$faqResults = $db->select($faqListQuery, $noFAQs, $page);

// get different languages 
if($faqResults == TRUE && $lang_folder !== $config['defaultLang']){

	for($i=0;$i<count($faqResults);$i++){
	
		if(($val = faqAltLang($faqResults[$i]['faq_id'])) == TRUE){
			
				$faqResults[$i]['question'] = $val['question'];
				$faqResults[$i]['answer'] = $val['answer'];
		
		}
		
	}

}

$totalNoFAQs = $db->numrows($faqListQuery);

// get current category info
	if(isset($_GET['faqCatId'])){
		$currentCatQuery = "SELECT faqCat_name, faqCat_father_id, faqCat_id FROM ".$glob['dbprefix']."CubeCart_faq_category WHERE faqCat_id = ".$db->mySQLSafe($_GET['faqCatId']);
		$currentCat = $db->select($currentCatQuery);
		
		$resultForeign = $db->select("SELECT faqCat_master_id as faqCat_id, faqCat_name FROM ".$glob['dbprefix']."CubeCart_faq_cats_lang WHERE faqCat_lang = '".$lang_folder."' AND faqCat_master_id = ".$db->mySQLSafe($_GET['faqCatId']));
		
		if($resultForeign == TRUE){
			
			$currentCat[0]['faqCat_name'] = $resultForeign[0]['faqCat_name'];
		
		}
		
		
	}

	if($_GET['faqCatId']==0)  {
		
		$view_faqs->assign("TXT_CAT_TITLE",$lang['front']['faqs']['start_page_title']);
		$view_faqs->assign("TXT_START",$lang['front']['faqs']['start_page_desc']);
		$view_faqs->parse("view_faqs.start_page");
	
	} else {
		
		$view_faqs->assign("TXT_CAT_TITLE",validHTML($currentCat[0]['faqCat_name']));
		$view_faqs->parse("view_faqs.back_nav_links");
	
	}

	if($currentCat[0]['faqCat_father_id']>0)  {
	
		$view_faqs->parse("view_faqs.faqHome_nav_links");
	}
	
	$view_faqs->assign("PAGINATION",$db->paginate($totalNoFAQs, $noFAQs, $page, "page"));

// repeated region
if($faqResults == TRUE){
	
	if($_GET['faqCatId']>0){
	
		$view_faqs->assign("LANG_CURRENT_DIR",$lang['front']['faqs']['location']);
		$view_faqs->assign("CURRENT_DIR",getCatDir(validHTML($currentCat[0]['faqCat_name']),$currentCat[0]['faqCat_father_id'], $currentCat[0]['faqCat_id'], $link=TRUE));
	
	}
	
	for ($i=0; $i<count($faqResults); $i++){
	
		// alternate class
		$view_faqs->assign("CLASS",cellColor($i, $tdEven="tdEven", $tdOdd="tdOdd"));

		$faqId = $faqResults[$i]['faq_id'];
		$view_faqs->assign("FAQ_ID",$faqId);		
		$view_faqs->assign("TXT_Q",validHTML($faqResults[$i]['question']));		
		$view_faqs->assign("TXT_A",strtrim(strip_tags($faqResults[$i]['answer']),$config['productPrecis'])."<br />
		<a href=\"index.php?act=viewFAQ&amp;faqId=".$faqId."\" target=\"_self\" class=\"txtDefault\"><em>more<em>");

		$view_faqs->parse("view_faqs.faqTable.faqs");
	}
	$view_faqs->parse("view_faqs.faqTable");

} elseif(isset($_GET['searchStr'])) {

	$view_faqs->assign("TXT_NO_FAQS",$lang['front']['faqs']['no_faqs_match']." ".treatGet($_GET['searchStr']));
	$view_faqs->parse("view_faqs.no_faqs");

} elseif($_GET['faqCatId']>0){

	
	$view_faqs->assign("TXT_NO_FAQS",$lang['front']['faqs']['no_faqs_in_cat']);
	$view_faqs->parse("view_faqs.no_faqs");

}
### Content is replaced when mod is disabled
} else {

	$view_faqs->assign("TXT_CAT_TITLE",$lang['front']['faqs']['unavailable']);
	$view_faqs->assign("DISABLED",$lang['front']['faqs']['disabled']);
	$view_faqs->parse("view_faqs.disabled");
	
}

$view_faqs->parse("view_faqs");
$page_content = $view_faqs->text("view_faqs");
?>