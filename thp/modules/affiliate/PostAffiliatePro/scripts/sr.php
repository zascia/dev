<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

error_reporting(E_ALL ^ E_NOTICE);

define('REF_COOKIE_NAME',  'PAPR_0');

// save referrer
$ref = urldecode($_REQUEST['ref']);
if($ref == '') exit;
if($_COOKIE[REF_COOKIE_NAME] != '') exit;

$cookie = time()."_".$ref;
setcookie(REF_COOKIE_NAME, $cookie, time() + 3650*86400, '/');
?>
document.cookie = '<?php echo REF_COOKIE_NAME?>='+escape('<?php echo $cookie?>')+';expires=Fri, 31-Dec-2023 00:00:00 GMT';
