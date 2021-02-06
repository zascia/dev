<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

header('Content-Type: text/css');

include_once('global.php');

$page = QUnit_Global::newobj('QUnit_UI_MainPage');

$page->setMainTemplate('main_blank');

$page->user_type = USERTYPE_ADMIN;
$page->setFilePrefix('Affiliate_Merchants_Views_');

echo $page->processNoSecurityCheck();
?>
