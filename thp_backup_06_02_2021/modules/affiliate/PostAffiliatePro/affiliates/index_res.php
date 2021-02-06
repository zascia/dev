<?php 
//============================================================================
// Copyright (c) webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

include_once('global.php');
include("menu_left_resources.php");

$GLOBALS['resourcesLeftMenu'] = true;
$GLOBALS['defaultResourcesPage'] = 'index';

$page = QUnit_Global::newobj('QUnit_UI_MainPage');

$page->setDefaultView('Resources');

$page->user_type = USERTYPE_USER;
$page->setFilePrefix('Affiliate_Affiliates_Views_');

echo $page->process();
?>
