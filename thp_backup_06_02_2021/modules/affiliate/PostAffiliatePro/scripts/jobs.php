<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

//error_reporting(E_ALL);
// include files
$path = substr(__FILE__, 0, strrpos(__FILE__, "/"));
if ($path != '') chdir($path);
require_once('global_nosession.php');

//ini_set('max_execution_time', 12);
$settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, 'default1');
$GLOBALS['Auth'] = QUnit_Global::newObj(AUTH_CLASS);
$GLOBALS['Auth']->settings = $settings;

loadLanguage(LANG_PATH);

$jobScheduler = QUnit_Global::newObj('Affiliate_Scripts_Bl_JobScheduler');
$jobScheduler->process();

?>