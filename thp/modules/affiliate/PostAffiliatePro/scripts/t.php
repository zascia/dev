<?php

//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

header('Content-Type: application/x-javascript');

error_reporting(E_ALL ^ E_NOTICE);

require_once('../settings/globalConst.php');

if (GLOBAL_DB_ENABLED == 1) {
    if(!@include_once(CACHE_PATH.$_REQUEST['lid'].'_paramNames.php')) {
        @include_once(CACHE_PATH.'paramNames.php');
    }
} else {
    @include_once(CACHE_PATH.'paramNames.php');
}

@require_once('../settings/paramNamesCheck.php');


// check if parameters exist before connecting to DB etc. to decrease server load
if($_REQUEST[PARAM_A_AID] == '' && $_REQUEST['a_aid'] == '' && $_REQUEST['AffiliateID'] == '') {
    // no affiliate parameter, probably the script was called with site related parameters 
    exit;
}

require_once('global.php');

QUnit_Global::includeClass('Affiliate_Scripts_Bl_ClickRegistrator');
$clickReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_ClickRegistrator');

$clickReg->process($params);

?>