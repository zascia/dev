<?php 
######################################################
# ePay CubeCart3 module v1.0 written by convict      #
# http://cubecart-mods-skins.com (C)2007             #
# Standard part                                      #
######################################################
$module = fetchDbConfig("Betalingskort");

function repeatVars(){

		return FALSE;
	
}

function fixedVars() {

	global $module, $basket, $cart_order_id, $config, $GLOBALS, $lang_folder, $glob;
	
	if ($module['mode']==1) return FALSE;

  @include($glob['rootDir']."/modules/gateway/Betalingskort/commom.inc.php");
	
	$hiddenVars = "<input type='hidden' name='merchantnumber' value='".$module['acNo']."' />
				<input type='hidden' name='orderid' value='$cart_order_id' />
				<input type='hidden' name='amount' value='".$amount."' />
				<input type='hidden' name='currency' value='".$currencyNo."' />
				<input type='hidden' name='windowstate' value='3' />
				<input type='hidden' name='language' value='".$language."' />
				<input type='hidden' name='accepturl' value='".$GLOBALS['storeURL']."/confirmed.php' />
				<input type='hidden' name='declineurl' value='".$GLOBALS['storeURL']."/confirmed.php' />
				<input type='hidden' name='addfee' value='".$order_fee."' />
				<input type='hidden' name='instantcapture' value='".$module['instant']."' />
				<input type='hidden' name='use3D' value='".$module['3D']."' />
				<input type='hidden' name='subscription' value='".$module['subscription']."' />
				<input type='hidden' name='cardtype' value='".$acceptedCards."' />
";
				if(!empty($module['authmail']) && validateEmail($module['authmail'])) $hiddenVars .="
				<input type='hidden' name='authmail' value='".$module['authmail']."' />
";
				if(!empty($module['authsms'])) $hiddenVars .="
				<input type='hidden' name='authsms' value='".$module['authsms']."' />
";

				if($module['callback']=="1") $hiddenVars .="
				<input type='hidden' name='callbackurl' value='".$GLOBALS['storeURL']."/modules/gateway/Betalingskort/callback.php' />
";

				if (strlen($module['key'])>0 && $module['auth'] == 1){
	        $md5key = MD5($currencyNo.$amount.$cart_order_id.$module['key']);
					$hiddenVars .= "
					<input type='hidden' name='md5key' value='".$md5key."'>";
				}

	return $hiddenVars;
	
}

function success(){
	
	global $db, $glob, $module, $basket;
		
	if(isset($_GET['tid']) && ($_GET['orderid']==$basket['cart_order_id'])){

		if (strlen($module['key'])>0 && $module['auth']==1) {

			if (isset($_GET['eKey']) && strlen($_GET['eKey'])>0 && $_GET['eKey']==MD5(($basket['grandTotal']*100).$basket['cart_order_id'].$_GET['tid'].$module['key'])) {
					
				return TRUE;			
				
			} else {
				
				return FALSE;
			
			} 
			
		} else {
				
			return TRUE;
		}
			
	} else {
		
		return FALSE;		
	}
	
}

///////////////////////////
// Other Vars
////////
//$formAction  = "https://ssl.ditonlinebetalingssystem.dk/popup/default.asp";
$formAction  = "https://ssl.ditonlinebetalingssystem.dk/integration/ewindow/Default.aspx";
$formMethod  = "post";
$formTarget  = "_self";
$transfer    = empty($module['mode']) ? "auto" : "manual";
$stateUpdate = TRUE;
?>
