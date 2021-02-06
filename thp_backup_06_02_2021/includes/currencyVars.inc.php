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
|	currencyVars.inc.php
|   ========================================
|	Gets Currency Array	
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

$override = array("viewOrder" => 1, "viewOrders" => 1);

$page = treatGet($_GET['act']);

if(isset($override[$page]) && $override[$page] == 1){

	$cCode = $config['defaultCurrency'];
	
} elseif(!empty($ccUserData[0]['currency'])){

	$cCode = $ccUserData[0]['currency'];
	
} elseif(!empty($order[0]['currency'])){

	$cCode = $order[0]['currency'];
	
} else {

	$cCode = $config['defaultCurrency'];
	
}
$currencyVer = $ini['ver'];
$query = "SELECT value, symbolLeft, symbolRight, decimalPlaces, name FROM ".$glob['dbprefix']."CubeCart_currencies WHERE code=".$db->mySQLSafe($cCode);
$currencyVars = $db->select($query);
?>