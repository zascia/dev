<?php
include_once("includes/global.inc.php");

include_once("classes/db.inc.php");
$db = new db();

$return = $db->select("SELECT * FROM `".$glob['dbprefix']."CubeCart_img_idx`");

print_r($return);


?>
Thank you. Your store has been updated. Please now delete this upgrade script.
<?php
?>
