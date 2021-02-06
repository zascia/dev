<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

$GLOBALS['leftMenuResources'] = array(
    // menu table
    array(
        array('header', 'Test header 1'),
        array('item', '<a class="aLeftRedMenuItem" href="index.php">'.L_G_CPANEL.'</a>'),
    ),

    array(
        array('header', 'Test header 2'),
        array('item', '<a class="aLeftMenuItem" href="index_res.php?md=Affiliate_Affiliates_Views_Resources&p=test">Test page</a>'),
        array('item', '<a class="aLeftMenuItem" href="index_res.php?md=Affiliate_Affiliates_Views_Resources&p=test2">Test page 2</a>'),
        array('item', '<a class="aLeftMenuItem" href="index_res.php?md=Affiliate_Affiliates_Views_Resources&p=test3">Test page 3</a>'),
    ),


    array(
        array('item', '<a class="aLeftMenuItem" href="logout.php">'.L_G_LOGOUT.'</a>'),
    ),
);


?>
