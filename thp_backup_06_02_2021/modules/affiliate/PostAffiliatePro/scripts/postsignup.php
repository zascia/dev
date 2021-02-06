<?php
//============================================================================
// Copyright (c) webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

include_once('global_signup.php');

$page = QUnit_Global::newobj('QUnit_UI_MainPage');

$page->setDefaultView('AffiliateAfterSignup');
$page->user_type = USERTYPE_ADMIN;
$page->setFilePrefix('Affiliate_Scripts_Views_');
$page->setMainTemplate('main_after_signup');

echo $page->processNoSecurityCheck();
?>
