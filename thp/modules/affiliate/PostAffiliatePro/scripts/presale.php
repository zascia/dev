<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// presale script

header('Content-Type: application/x-javascript');

define('LID_PREFFIX', 's_');

require_once('global.php');

$preSale = QUnit_Global::newObj('Affiliate_Scripts_Bl_PreSale');
$preSale->process();

?>
