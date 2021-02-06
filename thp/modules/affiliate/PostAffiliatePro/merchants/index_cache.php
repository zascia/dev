<?php 
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

include_once('../settings/globalConst.php');

$request = '';
foreach ($_GET as $key => $value) {
    if ($key == 'refresh') continue; 
    $request .= $key.$value;
}
$filename = CACHE_PATH."cached_".md5($request).".html";

// check if cashed file exists and is not expired yet
if (($_REQUEST['refresh'] != '1') && file_exists($filename) && (time() - filemtime($filename) < CACHED_FILE_EXPIRATION)) {
    echo file_get_contents($filename);
    return;
}

include_once('global.php');

$page = QUnit_Global::newobj('QUnit_UI_MainPage');

$page->setMainTemplate('main_blank');

$page->user_type = USERTYPE_ADMIN;
$page->setFilePrefix('Affiliate_Merchants_Views_');

$content = $page->process();

// save content to file
$handle = fopen($filename, "w");
fputs($handle, $content);
fclose($handle);

// send content
echo $content;
?>
