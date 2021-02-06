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
|	account.inc.php
|   ========================================
|	Customers Account Homepage	
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

// query database

$account=new XTemplate ("skins/".$config['skinDir']."/styleTemplates/content/account.tpl");

	$account->assign("LANG_YOUR_ACCOUNT",$lang['front']['account']['your_account']);

	$account->assign("TXT_PERSONAL_INFO",$lang['front']['account']['personal_info']);
	
	$account->assign("TXT_ORDER_HISTORY",$lang['front']['account']['order_history']);
	
	$account->assign("TXT_CHANGE_PASSWORD",$lang['front']['account']['change_password']);
	
	$account->assign("TXT_NEWSLETTER",$lang['front']['account']['newsletter']);
	
	$account->assign("LANG_LOGIN_REQUIRED",$lang['front']['account']['login_to_view']);
	
	if($ccUserData[0]['customer_id']>0) $account->parse("account.session_true");
	
	else $account->parse("account.session_false");
	
	$account->parse("account");
	
$page_content = $account->text("account");
?>