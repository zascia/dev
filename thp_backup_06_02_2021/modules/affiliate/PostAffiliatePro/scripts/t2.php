<?php 
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('../settings/globalConst.php');
if(GLOBAL_DB_ENABLED == 1) {
    @require_once(CACHE_PATH.$_REQUEST['lid'].'_paramNames.php');
} else {
    require_once(CACHE_PATH.'paramNames.php');
}
require_once('../settings/paramNamesCheck.php');

$_REQUEST['dr'] = 'n';
include('t.php');

?>