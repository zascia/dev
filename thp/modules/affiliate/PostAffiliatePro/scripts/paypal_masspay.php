<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('global.php');
$massPay = QUnit_Global::newObj('Affiliate_Scripts_Bl_PaypalMassPay');
$massPay->process($params);
?>
