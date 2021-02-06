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
|	cart.php
|   ========================================
|	The heart of the shopping cart pages	
+--------------------------------------------------------------------------
*/
	include_once("includes/ini.inc.php");
	
	
	
	// INCLUDE CORE VARIABLES & FUNCTIONS
	include_once("includes/global.inc.php");
	
	// initiate db class
	include_once("classes/db.inc.php");
	$db = new db();
	
	include_once("includes/functions.inc.php");
	$config = fetchDbConfig("config");
	
	include_once("includes/sessionStart.inc.php");
	
	include_once("includes/sslSwitch.inc.php");
	
	// get session data
	if($_GET['act']!=="logout"){
	include_once("includes/session.inc.php");
	}
	
	// get exchange rates etc
	include_once("includes/currencyVars.inc.php");
	
	$lang_folder = "";
	if(empty($ccUserData[0]['lang'])){
		$lang_folder = $config['defaultLang'];
	} else {
		$lang_folder = $ccUserData[0]['lang'];
	}
	include_once("language/".$lang_folder."/lang.inc.php");
	
	// require template class
	include_once("classes/xtpl.php");
	
	$body = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/global/cart.tpl");

	if(isset($_GET['searchStr'])){
		$body->assign("SEARCHSTR",treatGet($_GET['searchStr']));
	} else {
		$body->assign("SEARCHSTR","");
	}
	$body->assign("CURRENCY_VER",$currencyVer);
	$body->assign("VAL_ISO",$charsetIso);
	$body->assign("VAL_SKIN",$config['skinDir']);
	// MarksCarts FAQ Management for CubeCart, http://cc3.biz
	$faq_config = fetchDbConfig("FAQ_Management");
	
	//.: site testimonials mod http://www.cubecartmodder.com/ :.
	$testimonials_manager = fetchDbConfig("Site_Testimonials");
	//.: site testimonials mod http://www.cubecartmodder.com/ :.
	
		// START META DATA
	$body->assign("META_TITLE",htmlspecialchars(str_replace("&#39;","'",$config['siteTitle'])).c());
	$body->assign("META_DESC",$config['metaDescription']);
	$body->assign("META_KEYWORDS",$config['metaKeyWords']);
		
	// START  MAIN CONTENT
	switch (treatGet($_GET['act'])) {
		
		case "step1":
			include("includes/content/step1.inc.php");
			$body->assign("PAGE_CONTENT",$page_content);
		break;
		
		case "cart":
		case "step2":
		case "step3":
		case "step4":
			include("includes/content/cart.inc.php");
			$body->assign("PAGE_CONTENT",$page_content);
		break; 
		
		case "step5":
			include("includes/content/gateway.inc.php");
			$body->assign("PAGE_CONTENT",$page_content);
		break; 
		
		case "reg":
			include("includes/content/reg.inc.php");
			$body->assign("PAGE_CONTENT",$page_content);
		break;
		
		case "express":
			include("includes/content/expressreg.inc.php");
			$body->assign("PAGE_CONTENT",$page_content);
		break;

		case "upgradeReg":
			include("includes/content/upgradeReg.inc.php");
			$body->assign("PAGE_CONTENT",$page_content);
		break;

		case "viewOrders":
			include("includes/content/viewOrders.inc.php");
			$body->assign("PAGE_CONTENT",$page_content);
		break;
		
		case "viewOrder":
			include("includes/content/viewOrder.inc.php");
			$body->assign("PAGE_CONTENT",$page_content);
		break;
		
		case "noShip":
			include("includes/content/noShip.inc.php");
			$body->assign("PAGE_CONTENT",$page_content);
		break;
		
		case "overWeight":
			include("includes/content/overWeight.inc.php");
			$body->assign("PAGE_CONTENT",$page_content);
		break;
		
		case "confirmed":
			include("includes/content/confirmed.inc.php");
			$body->assign("PAGE_CONTENT",$page_content);
		break;
		
		default:
			header("Location: index.php");
			exit;
		break;
  	
	}
	// END MAIN CONTENT
	
	
	// START CONTENT BOXES

	// FAQ Management System by MarksCarts, http://cc3.biz
	if ($faq_config['status']==1 && $config['show_faqCats']==1) {
	// FAQ top-level menu in sidebox if mod is enabled and this option is chosen
	include("includes/boxes/faqCats.inc.php");
	$body->assign("FAQ_CATS",$box_content); }

	include("includes/boxes/searchForm.inc.php");
	$body->assign("SEARCH_FORM",$box_content);
	
	include("includes/boxes/session.inc.php");
	$body->assign("SESSION",$box_content);
	
	include("includes/boxes/siteDocs.inc.php");
	$body->assign("SITE_DOCS",$box_content);
	
	include("includes/boxes/cartNavi.inc.php");
	$body->assign("CART_NAVI",$box_content);
	
	//.: site testimonials mod http://www.cubecartmodder.com/ :.
	if($testimonials_manager['status']==1) {
		include("includes/boxes/viewTestimonials.inc.php");
		$body->assign("SITE_TESTIMONIALS",$box_content);
	}
	//.: site testimonials mod :.
	
	// END CONTENT BOXES
	
	// parse and spit out final document
	$body->parse("body");
	$body->out("body");
echo $testoutput;
?>
