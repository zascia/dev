<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

define('LID_PREFFIX', 's_');

// include files
require_once('../settings/globalConst.php');
if (GLOBAL_DB_ENABLED == 1) {
    if(!@include_once(CACHE_PATH.$_REQUEST['lid'].'_paramNames.php')) {
        @include_once(CACHE_PATH.'paramNames.php');
    }
} else {
    @include_once(CACHE_PATH.'paramNames.php');
}

@require_once('../settings/paramNamesCheck.php');

include('sb_norm.php');
?>