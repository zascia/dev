<?php 
######################################################
# ePay CubeCart3 module v1.0 written by convict      #
# http://cubecart-mods-skins.com (C)2007             #
# Advanced mode part                                 #
######################################################
$module = fetchDbConfig("Betalingskort");

include($glob['rootDir']."/modules/gateway/Betalingskort/commom.inc.php");

$formTemplate = new XTemplate ("modules/gateway/Betalingskort/form.tpl");

@include("language/$lang_folder/epay.inc.php");

$formTemplate->assign("MERCHANT",$module['acNo']);
$formTemplate->assign("ORDERID",$cart_order_id);
$formTemplate->assign("AMOUNT",$amount);
$formTemplate->assign("CURRENCY",$currencyNo);
$formTemplate->assign("LANG",$language);
$formTemplate->assign("AURL",$GLOBALS['storeURL']."/confirmed.php");
$formTemplate->assign("DURL",$GLOBALS['storeURL']."/confirmed.php");
$formTemplate->assign("ADDFEE",$order_fee);
$formTemplate->assign("INSTANT",$module['instant']);
$formTemplate->assign("3D",$module['3D']);
$formTemplate->assign("SUBSCRIBE",$module['subscription']);
$formTemplate->assign("ALLOWED",$acceptedCards);

if(!empty($module['authmail']) && validateEmail($module['authmail'])){
$formTemplate->assign("AUTHMAIL",$module['authmail']);
$formTemplate->parse("form.authmail");
}
if(!empty($module['authsms'])){
$formTemplate->assign("AUTHSMS",$module['authsms']);
$formTemplate->parse("form.autsms");
}
if($module['callback']=="1"){
$formTemplate->assign("CALLBACK",$GLOBALS['storeURL']."/modules/gateway/Betalingskort/callback.php");
$formTemplate->parse("form.callback");
}
if (strlen($module['key'])>0 && $module['auth'] == 1){
$md5key = MD5($currencyNo.$amount.$cart_order_id.$module['key']);
$formTemplate->assign("MD5",$md5key);
$formTemplate->parse("form.md5");
}

// CARD TYPES
$select = 0;
foreach($card_screen as $showcards) {
	$formTemplate->assign("VAL_CARD_IMG",$showcards[1]);
	$formTemplate->assign("VAL_CARD_NAME",$showcards[2]);
	$formTemplate->assign("VAL_CARD",$showcards[0]);
	
	if($select == 0 ){
		$formTemplate->assign("CARD_SELECTED","checked='checked'");
		$select = 1;
	} else {
		$formTemplate->assign("CARD_SELECTED","");
	}
	$formTemplate->parse("form.repeat_cards");
}
$formTemplate->assign("LANG_INFO_TITLE",$lang['module']['epay']['title']);

$formTemplate->parse("form");
$formTemplate = $formTemplate->text("form");

$gateway->assign("LANG_FORM_TITLE","");
?>
