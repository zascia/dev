<?php 
//============================================================================
// Copyright (c) webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

include_once('global.php');

$page = QUnit_Global::newobj('QUnit_UI_MainPage');

$page->setDefaultView('MainPage');
$page->user_type = USERTYPE_USER;
$page->setFilePrefix('Affiliate_Affiliates_Views_');

echo $page->process();
?>