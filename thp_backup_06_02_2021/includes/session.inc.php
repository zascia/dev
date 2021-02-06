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
|	session.php
|   ========================================
|	Core Session Management	
+--------------------------------------------------------------------------
*/

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

if(($config['offLine']==1 && isset($_SESSION['ccAdmin']) && $config['offLineAllowAdmin']==0) || ($config['offLine']==1 && !isset($_SESSION['ccAdmin']))) {
	header("Location: offLine.php");
	exit;
}

$sessData["location"] = $db->mySQLSafe(currentPage());
$lkParsed = "PC9ib2R5Pg==";

if( !isset($_SESSION['ccUser']) && (isset($_COOKIE['ccUser']) || isset($_GET['ccUser'])) ){

	if(isset($_COOKIE['ccUser'])){

		$sessId = base64_decode(treatGet($_COOKIE['ccUser']));
	
	} elseif(isset($_GET['ccUser'])){

		$sessId = treatGet($_GET['ccUser']);
	
	}
	## remove possible CRLF injection
	$sessId = str_replace(array('%0d', '%0a'), '', $sessId);
	
	// see if session is still in db
	$query = "SELECT sessId FROM ".$glob['dbprefix']."CubeCart_sessions WHERE sessId=".$db->mySQLSafe($sessId);
	$results = $db->select($query);
	
	if($results == TRUE){

	
		$sessData["timeLast"] = $db->mySQLSafe(time());
		
		if(!isset($_COOKIE['ccRemember'])) { $sessData["customer_id"] = 0; }
		
		$update = $db->update($glob['dbprefix']."CubeCart_sessions", $sessData,"sessId=".$db->mySQLSafe($results[0]['sessId']));
		
		$_SESSION['ccUser'] = $results[0]['sessId'];
		// set cookie to extend expire time meaning if the visitor visits regularly they stay logged in
		setcookie("ccUser", base64_encode($sessId),time()+$config['sqlSessionExpiry'], $sessionDomain);
	
	}
	
}

if(!isset($_SESSION['ccUser']) && $results == FALSE) {
	
	
	$sessId = makeSessId();
	$_SESSION['ccUser'] = $sessId;
	
	// insert sessionId into db
	
	$sessData["sessId"] = $db->mySQLSafe($_SESSION['ccUser']);		
	$timeNow = $db->mySQLSafe(time());
	$sessData["timeStart"] = $timeNow;	
	$sessData["timeLast"] = $timeNow;
	$sessData["customer_id"] = 0;

	$insert = $db->insert($glob['dbprefix']."CubeCart_sessions", $sessData);
	
	// set cookie
	setcookie("ccUser", base64_encode($sessId),time()+$config['sqlSessionExpiry'], $sessionDomain);
	
	// delete sessions older than time set in config file
	$expiredSessTime = time() - $config['sqlSessionExpiry'];
	$delete = $db->delete($glob['dbprefix']."CubeCart_sessions", "timeLast<".$expiredSessTime);

} else {
	
	$sessData["timeLast"] = $db->mySQLSafe(time());

	$update = $db->update($glob['dbprefix']."CubeCart_sessions", $sessData,"sessId=".$db->mySQLSafe($_SESSION['ccUser']));

}

$uniKey = "PGRpdiBjbGFzcz0ndHh0Q29weXJpZ2h0Jz5Qb3dlcmVkIGJ5IDxhIGhyZWY9J2h0dHA6Ly93d3cuY3ViZWNhcnQuY29tJyBjbGFzcz0ndHh0Q29weXJpZ2h0JyB0YXJnZXQ9J19ibGFuayc+Q3ViZUNhcnQ8L2E+JnRyYWRlOzxiciAvPkNvcHlyaWdodCA8YSBocmVmPSdodHRwOi8vd3d3LmRldmVsbGlvbi5jb20nIGNsYXNzPSd0eHRDb3B5cmlnaHQnIHRhcmdldD0nX2JsYW5rJz5EZXZlbGxpb24gTGltaXRlZDwvYT4gMjAwNi4gQWxsIHJpZ2h0cyByZXNlcnZlZC48L2Rpdj48L2JvZHk+";
$uniKey2 = "TG9jYXRpb246IGh0dHA6Ly93d3cuY3ViZWNhcnQuY29tL3NpdGUvcHVyY2hhc2Uv";


// get userdata
//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
$query = "SELECT * FROM ".$glob['dbprefix']."CubeCart_sessions LEFT JOIN ".$glob['dbprefix']."CubeCart_customer ON ".$glob['dbprefix']."CubeCart_sessions.customer_id = ".$glob['dbprefix']."CubeCart_customer.customer_id LEFT JOIN  ".$glob['dbprefix']."CubeCart_adg_groups_mod on discount_group_id = group_id WHERE sessId = ".$db->mySQLSafe($_SESSION['ccUser']);
eval(gzinflate(base64_decode('DdHbknNIAADgV9m7f6ZcGHGurb2QIIgWNNO42XJoEseOM0+/+73Ch9e0/arOd1+26Yy/snTCAvdvgfOhwF9/1OJqNB/HVBRVGaljXjigqp55BZlm1MowahrvRWq2jev1vj3nXtq6RDwNwf5Qgs3cJH6WrfXps8IoTQGXTzQtQNDo2U6MHucdhmqpfbwfCW3rq2E4a15Wu0FPAckh6aEjmlL6YaR+4cSgjicWwE5+cw0RwyKq5oQ/kjiqQ+wLUmoOzkSzk6mktkNiggDVi+1H3aMbgRqW4DCrR29wcvU5x4bpkXIsgtv47xPogZ/1jJBcj0Oq1cZPncsxqkMWyORx2TVG5dGd8LAa3rN0FnDxxRd5yMw78HJrfdgKlDspEEBUX15WwOuN7ljLGcyoWf2L7UMvWmgNdmeqgxz4T0BtObX+HI9bbRTQn/OejVN+G+Pg8HgUYvTyWNNb3suLnCACo3zcbED8M7QD6iru8v6SmXlYVeLx3aqwkZfg/VYKuYY2C1iordq8bm5kLP19XJug6OcUCWkiKvVvw5VB/nHWaz94dKyF7+HHbTW49pcLa4Mu4UC7pVnDmkZax7DARbOEaqfHdxGtvzPDOQXSOYGIj92YHDTO62AG06VwEg5vwUUMeuuepaZabn2Rjt0ZmKBLwSntfCULS3PwZqn42fbAvavW2ph2ZL6vMl0L00DFd60zPJ2FfsvcqcpgnkJv8Jg6dlqsP5FCVci7mfVjcq8q55flgTBUhnrenadVN9Bi60jq8UTp73fl1TBGyXpfOice5SE1K/ZxefLvk3dgzmEf/T9BjFDnxR/BQYGG6Zo+Z+5pqFhKSaSwRIDFYtkJuekN0nrw8dzfa9RkFv8LgDipi9O7etSSJwrdOJMJlKnp+F3MgbZFOeXOdprlPNzCozgE15mEEbeTWJu8FrlcjpxBbG40rdLlykq0e/L8If3z5/v7+++//gM='))); 
//.: Group Discounts Mod by Goober http://www.cubecartmodder.com/
$ccUserData = $db->select($query);

// We have a session issue :-/ (e.g. session but no matching DB value)
if($ccUserData==FALSE)
{
	// reset session and reload current page
	unset($_SESSION['ccUser'],$_COOKIE['ccUser'],$_COOKIE['ccRemember']);
	header("Location: ".str_replace("&amp;","&",currentPage()));
	exit;
}

?>