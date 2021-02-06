<?php
/*
+--------------------------------------------------------------------------
|   CubeCart v3.0.15
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
|   Date: Thursday, 4th January 2007
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
	
	// require template class
	include_once("classes/xtpl.php");
	
	$body = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/global/index2.tpl");

	if(isset($_GET['searchStr'])){
		$body->assign("SEARCHSTR",treatGet($_GET['searchStr']));
	} else {
		$body->assign("SEARCHSTR","");
	}
	
	$body->assign("CURRENCY_VER",$currencyVer);
	$body->assign("VAL_ISO",$charsetIso);
	$body->assign("VAL_SKIN",$config['skinDir']);
		
	// START  MAIN CONTENT
	if(isset($_GET['act'])){
	
		switch (treatGet($_GET['act'])) {
			case "newsletter":
				include("includes/content/newsletter.inc.php");
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
		$body->assign("META_TITLE",htmlspecialchars($config['siteTitle']).c());
		$body->assign("META_DESC",$config['metaDescription']);
		$body->assign("META_KEYWORDS",$config['metaKeyWords']);
	}
	
	include("includes/boxes/prizeDraw.inc.php");
	$body->assign("MAIL_LIST",$box_content);
	
	// parse and spit out final document
	$body->parse("body");
	$body->out("body");
?>