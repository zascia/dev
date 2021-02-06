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
|	reg.inc.php
|   ========================================
|	Customer Registration	
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

if($ccUserData[0]['customer_id']>0){

header("Location: cart.php?act=step1");

}
if(isset($_POST['email'])){

	$emailArray = $db->select("SELECT customer_id, type FROM ".$glob['dbprefix']."CubeCart_customer WHERE email=".$db->mySQLSafe($_POST['email']));

	if(empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['add_1']) || empty($_POST['town']) || empty($_POST['county']) || empty($_POST['postcode']) || empty($_POST['country']) || empty($_POST['password']) || empty($_POST['passwordConf'])){
	
	$errorMsg = $lang['front']['reg']['fill_required'];
	
	} elseif($_POST['password'] !== $_POST['passwordConf']) {
	
	$errorMsg = $lang['front']['reg']['pass_not_match'];
	
	} elseif(validateEmail($_POST['email'])==FALSE) {
	
	$errorMsg = $lang['front']['reg']['enter_valid_email'];
	
	} elseif(!ereg("[0-9]",$_POST['phone'])) {
	
	$errorMsg = $lang['front']['reg']['enter_valid_tel'];
	
	} elseif(!empty($_POST['mobile']) && !ereg("[0-9]",$_POST['mobile'])) {
	
	$errorMsg = $lang['front']['reg']['enter_valid_tel'];
	
/*	} elseif($emailArray == TRUE && $emailArray[0]['type']==1) {
	
	$errorMsg = $lang['front']['reg']['email_in_use'];
*/
	} else {

		$record["email"] = $db->mySQLSafe($_POST['email']);
		$record["password"] = $db->mySQLSafe(md5($_POST['password']));
		$record["title"] = $db->mySQLSafe($_POST['title']);
		$record["firstName"] = $db->mySQLSafe($_POST['firstName']);
		$record["lastName"] = $db->mySQLSafe($_POST['lastName']);
		$record["add_1"] = $db->mySQLSafe($_POST['add_1']);
		$record["add_2"] = $db->mySQLSafe($_POST['add_2']);
		$record["town"] = $db->mySQLSafe($_POST['town']);
		$record["county"] = $db->mySQLSafe($_POST['county']);
		$record["postcode"] = $db->mySQLSafe($_POST['postcode']);
		$record["country"] = $db->mySQLSafe($_POST['country']);
		$record["phone"] = $db->mySQLSafe($_POST['phone']);
		$record["mobile"] = $db->mySQLSafe($_POST['mobile']);
		$record["regTime"] = $db->mySQLSafe(time());
		$record["ipAddress"] = $db->mySQLSafe($_SERVER['REMOTE_ADDR']);
		
		if(isset($_POST['optIn1st'])){
			
			$record["optIn1st"] = $db->mySQLSafe($_POST['optIn1st']);
		
		}
		
		$record["type"] = 1;
		$record["htmlEmail"] = $db->mySQLSafe($_POST['htmlEmail']);
		
		// look up users zone
		$zoneId = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_iso_counties WHERE (abbrev LIKE ".$db->mySQLSafe($_POST['county'])." OR name LIKE ".$db->mySQLSafe($_POST['county']).")");
		
		if($zoneId[0]['id']>0){
		
			$record["zoneId"] = $zoneId[0]['id'];
		
		}
		
		
		//if($emailArray == TRUE && $emailArray['type']==0){
		if($emailArray == TRUE){

		// update
		
		$where = "customer_id = ".$db->mySQLSafe($emailArray[0]['customer_id']);

		$update = $db->update($glob['dbprefix']."CubeCart_customer", $record, $where);
		
		$sessData['customer_id'] = $emailArray[0]['customer_id'];
		$update = $db->update($glob['dbprefix']."CubeCart_sessions", $sessData,"sessId=".$db->mySQLSafe($_SESSION['ccUser']));
		
		} else {

		$insert = $db->insert($glob['dbprefix']."CubeCart_customer", $record);
		
		$sessData['customer_id'] = $db->insertid();
		$update = $db->update($glob['dbprefix']."CubeCart_sessions", $sessData,"sessId=".$db->mySQLSafe($_SESSION['ccUser']));
			//	 Start Email template mod
			// Start of email on registration
			$email_template2 = $db->select("SELECT * FROM ".$glob['dbprefix']."CubeCart_eMail WHERE enabled = 1 AND type = 'registration'");
			if ($email_template2 == TRUE) {
				$search2 = array(
					"{SHOP_OWNER}",
					"{TITLE}",
					"{FNAME}",
					"{LNAME}",
					"{ADDRESS1}",
					"{ADDRESS2}",
					"{TOWN}",
					"{COUNTY}",
					"{POSTCODE}",
					"{COUNTRY}",
					"{CREDIT}"
				);
				$replace2 = array(
					$config['masterName'],
					$_POST['title'],
					$_POST['firstName'],
					$_POST['lastName'],
					$_POST['add_1'],
					$_POST['add_2'],
					$_POST['town'],
					$_POST['county'],
					$_POST['postcode'],
					countryName($_POST['country']),
					priceFormat($basket['credit'])
				);
				$ebody2 = $email_template2[0]['body'];		
				$subject2 = $email_template2[0]['subject'];
				$ebody2 = str_replace($search2, $replace2, $ebody2);
				if (!isset($mail)) {
					include_once($glob['rootDir']."/classes/class.phpmailer.php");
					$mail = new PHPMailer();
				}
				include($glob['rootDir']."/includes/email_config.inc.php");
				$mail->From = $config['masterEmail'];
				$mail->FromName = $config['masterName'];
				$mail->AddAddress($_POST['email'], $_POST['firstName']." ".$_POST['lastName']);
				$mail->AddReplyTo($config['masterEmail'], $config['masterName']);
				$mail->WordWrap = 50;
				$mail->Subject = $subject2;
				$mail->Body    = $ebody2;
				$mail->Send();
			}
			// End of email on registration				
		
			$redir = treatGet(base64_decode($_GET['redir']));
		
			if(eregi("^http://|^https://",$redir) && !eregi("^".$glob['storeURL']."|^".$config['storeURL_SSL'],$redir)){
				die("Redirect URL not allowed!");
			}
		
			require_once("classes/cart.php");
			$cart = new cart();
			$basket = $cart->cartContents($ccUserData[0]['basket']);
		
			if(is_array($basket['conts']) && !empty($basket['conts'])) {
			
			header("Location: cart.php?act=step1");
			exit;
			
			} elseif(isset($_GET['redir']) && !empty($_GET['redir']) && !eregi("logout|login|forgotPass|changePass",$redir)) {
			
			header("Location: ".str_replace("amp;","",$redir));
			exit;
			
			} else {
			
			header("Location: index.php");
			exit;
			
			}
		
		}
	
	}

}

$reg = new XTemplate ("skins/".$config['skinDir']."/styleTemplates/content/reg.tpl");
// Quick Checkout by convict http://cubecartmods.eu -->
$qch_config = fetchDbConfig("Quick_Checkout");
if ($qch_config['status']) {

	if ($qch_config['direct_reg'] && isset($_GET['qch'])) {

		$reg->assign("LANG_LOGIN_TITLE",$lang['front']['step1']['allready_customer']);
		$reg->assign("LANG_LOGIN_BELOW",$lang['front']['step1']['login_below']);
		$reg->assign("VAL_SELF",base64_encode(currentPage()));
		$reg->assign("LANG_USERNAME",$lang['front']['step1']['username']);

		$reg->assign("LANG_PASSWORD",$lang['front']['step1']['password']);
		$reg->assign("LANG_REMEMBER",$lang['front']['step1']['remember_me']);
		$reg->assign("TXT_LOGIN",$lang['front']['step1']['login']);

		$reg->assign("LANG_CONT_SHOPPING",$lang['front']['step1']['cont_shopping_q']);
		$reg->assign("LANG_CONT_SHOPPING_BTN",$lang['front']['step1']['cont_shopping']);
		$reg->assign("LANG_CONT_SHOPPING_DESC",$lang['front']['step1']['cont_browsing']);

		$reg->parse("reg.quick_checkout");
	}
}
// Quick Checkout by convict <--
	if(isset($errorMsg)){
	
		$reg->assign("VAL_ERROR",$errorMsg);
		$reg->parse("reg.error");
	
	} else {
	
		$reg->assign("LANG_REGISTER_DESC",$lang['front']['reg']['note_required']);
		$reg->parse("reg.no_error");
	
	}
	
	$reg->assign("LANG_REGISTER",$lang['front']['reg']['express_reg']);
	$reg->assign("LANG_REGISTER_SUBMIT",$lang['front']['reg']['submit_and_cont']);
	
	if(isset($_GET['redir']) && !empty($_GET['redir'])) {
		$reg->assign("VAL_ACTION","cart.php?act=reg&amp;redir=".treatGet($_GET['redir']));
	} else {
		$reg->assign("VAL_ACTION","cart.php?act=reg");
	}

	$reg->assign("LANG_PERSONAL_DETAILS",$lang['front']['reg']['personal_details']);
	$reg->assign("LANG_ADDRESS",$lang['front']['reg']['address']);
	$reg->assign("LANG_TITLE",$lang['front']['reg']['title']);
	$reg->assign("LANG_TITLE_DESC",$lang['front']['reg']['title_desc']);
	$reg->assign("LANG_FIRST_NAME",$lang['front']['reg']['first_name']); 
	$reg->assign("LANG_ADDRESS_FORM",$lang['front']['reg']['address2']); 
	$reg->assign("LANG_LAST_NAME",$lang['front']['reg']['last_name']);
	$reg->assign("LANG_EMAIL_ADDRESS",$lang['front']['reg']['email_address']); 
	$reg->assign("LANG_TOWN",$lang['front']['reg']['town']);
	$reg->assign("LANG_TELEPHONE",$lang['front']['reg']['phone']);
	$reg->assign("LANG_COUNTY",$lang['front']['reg']['county']);
	$reg->assign("LANG_MOBILE",$lang['front']['reg']['mobile']);
	$reg->assign("LANG_COUNTRY",$lang['front']['reg']['country']);
	$reg->assign("LANG_POSTCODE",$lang['front']['reg']['postcode']);
	$reg->assign("LANG_SECURITY_DETAILS",$lang['front']['reg']['security_details']);
	$reg->assign("LANG_CHOOSE_PASSWORD",$lang['front']['reg']['choose_pass']);
	$reg->assign("LANG_CONFIRM_PASSWORD",$lang['front']['reg']['conf_pass']);
	$reg->assign("LANG_PRIVACY_SETTINGS",$lang['front']['reg']['privacy_settings']);
	$reg->assign("LANG_RECIEVE_EMAILS",$lang['front']['reg']['receive_emails']);
	$reg->assign("LANG_EMAIL_FORMAT",$lang['front']['reg']['email_format']); 
	$reg->assign("LANG_HTML_FORMAT",$lang['front']['reg']['styled_html']);
	$reg->assign("LANG_PLAIN_TEXT",$lang['front']['reg']['plain_text']); 
	$reg->assign("LANG_TANDCS",$lang['front']['reg']['tandcs']);
	$reg->assign("LANG_PLEASE_READ",$lang['front']['reg']['please_read']);
	
	$countries = $db->select("SELECT id, printable_name FROM ".$glob['dbprefix']."CubeCart_iso_countries");
	
	for($i=0; $i<count($countries); $i++){
	
		$reg->assign("VAL_COUNTRY_ID",$countries[$i]['id']);
		
		$countryName = "";
		$countryName = $countries[$i]['printable_name'];
		
		if(strlen($countryName)>20){
		
		$countryName = substr($countryName,0,20)."&hellip;";
		
		}
		
		$reg->assign("VAL_COUNTRY_NAME",$countryName);
		
		if(isset($_POST['country']) && $_POST['country'] == $countries[$i]['id']){
		
			$reg->assign("VAL_COUNTRY_SELECTED","selected='selected'");
			
		} elseif(!isset($_POST['country']) && ($countries[$i]['id']==$config['siteCountry'])) {
		
			$reg->assign("VAL_COUNTRY_SELECTED","selected='selected'");
			
		} else {
			$reg->assign("VAL_COUNTRY_SELECTED","");
		}
		$reg->parse("reg.repeat_countries");
	
	}
	
	
	if(isset($_POST['title'])){
	
		$reg->assign("VAL_TITLE",treatGet($_POST['title']));
		$reg->assign("VAL_FIRST_NAME",treatGet($_POST['firstName']));
		$reg->assign("VAL_LAST_NAME",treatGet($_POST['lastName']));
		$reg->assign("VAL_EMAIL",treatGet($_POST['email']));
		$reg->assign("VAL_PHONE",treatGet($_POST['phone']));
		$reg->assign("VAL_MOBILE",treatGet($_POST['mobile']));
		$reg->assign("VAL_ADD_1",treatGet($_POST['add_1']));
		$reg->assign("VAL_ADD_2",treatGet($_POST['add_2']));
		$reg->assign("VAL_TOWN",treatGet($_POST['town']));
		$reg->assign("VAL_COUNTY",treatGet($_POST['county']));
		$reg->assign("VAL_POSTCODE",treatGet($_POST['postcode']));
		
		if($_POST['password'] == $_POST['passwordConf']){
			
			$reg->assign("VAL_PASSWORD",treatGet($_POST['password']));
			$reg->assign("VAL_PASSWORD_CONF",treatGet($_POST['passwordConf']));
		
		}
		
		if(isset($_POST['optIn1st']) && $_POST['optIn1st']==1) {
			$reg->assign("VAL_OPTIN1ST_CHECKED","checked='checked'");
		}
		
		if($_POST['htmlEmail']==0){
			$reg->assign("VAL_HTMLEMAIL_SELECTED","selected='selected'");
		}
	}
	
$reg->parse("reg");
$page_content = $reg->text("reg");
?>
