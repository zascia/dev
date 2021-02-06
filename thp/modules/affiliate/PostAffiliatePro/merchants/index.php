<?php 
//============================================================================
// Copyright (c) webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

include_once('global.php');

$page = QUnit_Global::newObj('QUnit_UI_MainPage');

if(AFF_PROGRAM_TYPE == PROG_TYPE_ECOMMAGNET) {
    $page->setDefaultView('Home');
    $page->user_type = USERTYPE_ADMIN;
    $page->setFilePrefix('EComMagnet_Merchants_Views_');
} else {
    $page->setDefaultView('MerchantProfile');
    $page->user_type = USERTYPE_ADMIN;
    $page->setFilePrefix('Affiliate_Merchants_Views_');
}

echo $page->process();
?>
