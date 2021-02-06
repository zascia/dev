<?php 
//============================================================================
// Copyright (c) webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

error_reporting(E_ALL ^ E_NOTICE);

include_once('global.php');

$page = QUnit_Global::newobj('QUnit_UI_MainPage');

$page->setDefaultView('Install');
$page->setFilePrefix('Affiliate_Install_Views_');

echo $page->processNoSecurityCheck();
?>