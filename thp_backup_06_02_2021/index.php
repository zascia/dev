<?php 
 error_reporting(0);
 

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
|	index.php
|   ========================================
|	Main pages of the store	
+--------------------------------------------------------------------------
*/
	include_once("includes/ini.inc.php");
	
	
	
	// INCLUDE CORE VARIABLES & FUNCTIONS
	include_once("includes/global.inc.php");
	
	// check if installed
	if($glob['installed']==0){
	
		header("location: install/index.php");
		exit;
		
	} elseif((file_exists($glob['rootDir']."/install/index.php") || file_exists($glob['rootDir']."/upgrade.php") && $glob['installed']==1)){
	
		echo "<strong>WARNING</strong> - Your store will not function until the install directory and/or upgrade.php is deleted from the server.";
		exit;
		
	}
	
	// initiate db class
	include_once("classes/db.inc.php");
	$db = new db();
	include_once("includes/functions.inc.php");
	$config = fetchDbConfig("config");
	
	include_once("includes/sessionStart.inc.php");
	
	include_once("includes/sslSwitch.inc.php");
	
	// get session data
	include_once("includes/session.inc.php");
	
	// get exchange rates etc
	include_once("includes/currencyVars.inc.php");
	
	$lang_folder = "";
	
	if(empty($ccUserData[0]['lang'])){
		$lang_folder = $config['defaultLang'];
	} else {
		$lang_folder = $ccUserData[0]['lang'];
	}
	include_once("language/".$lang_folder."/lang.inc.php");
	// Store selector mod by convict (c)2006 -->
	include("includes/3rdp_topcat.inc.php");
	// <-- Store selector mod
	#:convict:# >>
	if (isset($_GET['gift']) && !empty($_GET['gift'])) {
	@setcookie("coupon_code", base64_encode($_GET['gift']) ,time()+108000, $GLOBALS['rootRel']);
	}
	#:convict:# <<
	
	// require template class
	include_once("classes/xtpl.php");
	
	$body = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/global/index.tpl");
	$body->assign("LINGU",$lang_folder);

	if(isset($_GET['searchStr'])){
		$body->assign("SEARCHSTR",treatGet($_GET['searchStr']));
	} else {
		$body->assign("SEARCHSTR","");
	}
	
	$body->assign("CURRENCY_VER",$currencyVer);
	$body->assign("VAL_ISO",$charsetIso);
	$body->assign("VAL_SKIN",$config['skinDir']);
	//.: site testimonials mod http://www.cubecartmodder.com/ :.
	$testimonials_manager = fetchDbConfig("Site_Testimonials");
	//.: site testimonials mod http://www.cubecartmodder.com/ :.
	// MarksCarts FAQ Management for CubeCart, http://cc3.biz
	$faq_config = fetchDbConfig("FAQ_Management");
		
	// START  MAIN CONTENT
	if(isset($_GET['act'])){
	
		switch (treatGet($_GET['act'])) {
			// MarksCarts FAQ Management for CubeCart, http://cc3.biz       #START
			case "viewFAQs":
				include("includes/content/viewFAQs.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break; 
			case "viewFAQ":
				include("includes/content/viewFAQ.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break; 
			// MarksCarts FAQ Management for CubeCart, http://cc3.biz       #STOP

			//.: site testimonials mod http://www.cubecartmodder.com/ :.
			case "viewTestimonial":
			case "addTestimonial":
				include("includes/content/viewTestimonials.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break;
			//.: site testimonials mod :.
			case "viewDoc":
				include("includes/content/viewDoc.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break; 
			case "viewCat":
				include("includes/content/viewCat.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break;
			// grishick's relevant_search MOD 2006 START -->
			case "doSearch":
				include("includes/content/doSearch.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break;			
			// grishick's relevant_search MOD 2006 END -->
			case "viewProd":
				include("includes/content/viewProd.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break;
			case "unsubscribe":
				include("includes/content/unsubscribe.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break;
			case "taf":
				include("includes/content/tellafriend.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break;
			case "login":
				include("includes/content/login.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break; 
			case "logout":
				include("includes/content/logout.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break; 
			case "forgotPass":
				include("includes/content/forgotPass.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break; 
			case "account":
				include("includes/content/account.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break; 
			case "profile":
				include("includes/content/profile.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break;     
			case "changePass":
				include("includes/content/changePass.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break;
			case "newsletter":
				include("includes/content/newsletter.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break;
			case "dnExpire":
				include("includes/content/dnExpire.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break; 
			default:
				include("includes/content/index.inc.php");
				$body->assign("PAGE_CONTENT",$page_content);
			break;
		}
		
	} else {
		
		include("includes/content/index.inc.php");
		$body->assign("PAGE_CONTENT",$page_content);
	
	}
	// END MAIN CONTENT
	
	// START META DATA
	if(isset($meta)){
		$body->assign("META_TITLE",htmlspecialchars($meta['siteTitle']).c());
		$body->assign("META_DESC",$meta['metaDescription']);
		$body->assign("META_KEYWORDS",$config['metaKeyWords']);
	} else {
		$body->assign("META_TITLE",htmlspecialchars(str_replace("&#39;","'",$config['siteTitle'])).c());
		$body->assign("META_DESC",$config['metaDescription']);
		$body->assign("META_KEYWORDS",$config['metaKeyWords']);
	}
	
	// START CONTENT BOXES
	// Store selector mod by convict (c)2006 -->
	include("includes/boxes/store.inc.php");
	$body->assign("STORE",$box_content);
	// <-- Store selector mod
	// FAQ Management System by MarksCarts, http://cc3.biz
	if ($faq_config['status']==1 && $config['show_faqCats']==1 && (isset($_GET['faqCatId']) || isset($_GET['faqId']))) {
	// FAQ top-level menu in sidebox if mod is enabled and this option is chosen
	include("includes/boxes/faqCats.inc.php");
	$body->assign("FAQ_CATS",$box_content); }
	include("includes/boxes/searchForm.inc.php");
	$body->assign("SEARCH_FORM",$box_content);
	// Manufacturers by convict http://cubecartmods.eu -->
	include("includes/boxes/manufacturers.inc.php");
	$body->assign("MANUFACTURERS",$box_content);
	// <-- Manufacturers by convict
	include("includes/boxes/session.inc.php");
	$body->assign("SESSION",$box_content);

	//.: site testimonials mod http://www.cubecartmodder.com/ :.
	if($testimonials_manager['status']==1) {
		include("includes/boxes/viewTestimonials.inc.php");
		$body->assign("SITE_TESTIMONIALS",$box_content);
	}
	//.: site testimonials mod :.

	include("includes/boxes/categories.inc.php");
	$body->assign("CATEGORIES",$box_content);

	include("includes/boxes/brands.inc.php");
	$body->assign("BRANDS",$box_content);
	
	include("includes/boxes/randomProd.inc.php");
	$body->assign("RANDOM_PROD",$box_content);
	// OUR FAVORITE PRODUCTS SLIDESHOW by MarksCarts, http://cc3.biz
	if(isset($config['showSlides']) && file_exists("skins/".$config[skinDir]."/styleTemplates/boxes/ourFavorites.tpl")) {
	include("includes/boxes/ourFavorites.inc.php");
	$body->assign("SLIDESHOW",$box_content);}
	
	include("includes/boxes/info.inc.php");
	$body->assign("INFORMATION",$box_content);
	
	include("includes/boxes/language.inc.php");
	$body->assign("LANGUAGE",$box_content);
	
	include("includes/boxes/currency.inc.php");
	$body->assign("CURRENCY",$box_content);
	
	include("includes/boxes/shoppingCart.inc.php");
	$body->assign("SHOPPING_CART",$box_content);
	
	include("includes/boxes/popularProducts.inc.php");
	$body->assign("POPULAR_PRODUCTS",$box_content);
	
	include("includes/boxes/saleItems.inc.php");
	$body->assign("SALE_ITEMS",$box_content);
	
	include("includes/boxes/mailList.inc.php");
	$body->assign("MAIL_LIST",$box_content);
	
	include("includes/boxes/siteDocs.inc.php");
	$body->assign("SITE_DOCS",$box_content);
	// END CONTENT BOXES
	
	// parse and spit out final document
	$body->parse("body");
	$body->out("body");
?>