<?php
/*
+--------------------------------------------------------------------------
|   CubeCart v3.0.8
|   ========================================
|   by Alistair Brookbanks
|	CubeCart is a Trade Mark of Devellion Limited
|   Copyright Devellion Limited 2005 - 2006. All rights reserved.
|   Devellion Limited,
|   22 Thomas Heskin Court,
|   Station Road,
|   Bishops Stortford,
|   HERTFORDSHIRE.
|   CM23 3EE
|   UNITED KINGDOM
|   http://www.devellion.com
|	UK Private Limited Company No. 5323904
|   ========================================
|   Web: http://www.cubecart.com
|   Date: Monday, 23rd January 2006
|   Email: info (at) cubecart (dot) com
|	License Type: CubeCart is NOT Open Source Software and Limitations Apply 
|   Licence Info: http://www.cubecart.com/site/faq/license.php
+--------------------------------------------------------------------------
|	confirmed.php
|   ========================================
|	Confirms the customers order	
+--------------------------------------------------------------------------
*/
	
	include_once("includes/ini.inc.php");
	
	
	// INCLUDE CORE VARIABLES & FUNCTIONS
	include_once("includes/global.inc.php");
	$enableSSl = 1;
	
	// initiate db class
	include_once("classes/db.inc.php");
	$db = new db();
	
	include_once("includes/functions.inc.php");
	$config = fetchDbConfig("config");
	
	include_once("includes/sessionStart.inc.php");
	
	include_once("includes/sslSwitch.inc.php");
	
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
	
	// require template class
	include_once("classes/xtpl.php");
	
	$body = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/global/cart.tpl");

	if(isset($_GET['searchStr'])){
		$body->assign("SEARCHSTR",$_GET['searchStr']);
	} else {
		$body->assign("SEARCHSTR","");
	}
	$body->assign("CURRENCY_VER",$currencyVer);
	$body->assign("VAL_SKIN",$config['skinDir']);
	
		// START META DATA
	$body->assign("META_TITLE",$config['siteTitle'].c());
	$body->assign("META_DESC",$config['metaDescription']);
	$body->assign("META_KEYWORDS",$config['metaKeyWords']);
		
	include("includes/content/confirmed.inc.php");
	$body->assign("PAGE_CONTENT",$page_content);
	
	// START CONTENT BOXES
	include("includes/boxes/searchForm.inc.php");
	$body->assign("SEARCH_FORM",$box_content);
	
	include("includes/boxes/session.inc.php");
	$body->assign("SESSION",$box_content);
	
	include("includes/boxes/siteDocs.inc.php");
	$body->assign("SITE_DOCS",$box_content);
	
	include("includes/boxes/cartNavi.inc.php");
	$body->assign("CART_NAVI",$box_content);
	
	// END CONTENT BOXES
	
	// parse and spit out final document
	$body->parse("body");
	$body->out("body");
?>