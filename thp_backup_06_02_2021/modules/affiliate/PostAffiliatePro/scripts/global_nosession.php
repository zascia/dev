<?php
/**
*
*   @copyright Copyright (c) webradev.com
*   All rights reserved
*
*   @package PostAffiliate Pro
*   @since Version 2.0
*
*   For support contact info@webradev.com
*/

error_reporting(E_ALL ^ E_NOTICE);

define('LID_PREFFIX', 's_');

require_once('../settings/settings.php');
require_once('../settings/globalConst.php');

define('LANG_PATH', dirname(realpath(__FILE__)).'/../langs/');

require_once($GLOBALS['CORE_INCLUDE_PATH'].'/QUnit/Global.class.php');
$GLOBALS['mainTemplatePath'] = '';

/*
//$GLOBALS['CORE_INCLUDE_PATH'] = realpath('../../../core/trunk/include');
$GLOBALS['PROJECT_ROOT_PATH'] = realpath('..');
$GLOBALS['PROJECT_INCLUDE_PATH'] = $GLOBALS['PROJECT_ROOT_PATH'].'/include';
$webRootPath = dirname($_SERVER['PHP_SELF']);
$GLOBALS['WEB_ROOT_PATH'] = (($webRootPath == '/') ? "" : $webRootPath);
$GLOBALS['WEB_PATH'] = 'scripts';

if(PAP_RELEASE == 1)
{
//    $GLOBALS['IncludesPath'] = '../../../core/trunk/include';
    require_once($GLOBALS['CORE_INCLUDE_PATH'].'/QUnit/Global.class.php');
    $GLOBALS['mainTemplatePath'] = '';
}
else
{
//    $GLOBALS['IncludesPath'] = '../../../core/trunk/include';
    require_once($GLOBALS['CORE_INCLUDE_PATH'].'/QUnit/Global.class.php');
    $GLOBALS['mainTemplatePath'] = '';
}
*/

// ---------------------------------------------------------------------------
// include files
// ---------------------------------------------------------------------------
QUnit_Global::includeClass('QUnit_GlobalFuncs');
QUnit_Global::includeClass('QCore_Sql_DBUnit');
QUnit_Global::includeClass('QUnit_Messager');
QUnit_Global::includeClass('QCore_History');
QUnit_Global::includeClass('QCore_Logs');
require_once('../settings/emailTemplates.php');

QUnit_Global::includeClass('QCore_Constants');
QCore_Constants::initConstants();

define('AUTH_CLASS', 'Affiliate_Scripts_Bl_Auth');
QUnit_Global::includeClass(AUTH_CLASS);
QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');

require_once('../settings/trafficLimits.php');

// ---------------------------------------------------------------------------
// log into local database
// ---------------------------------------------------------------------------

$dbObj =& QUnit_Global::newObj('QUnit_Sql_DbConnection',
    DB_HOSTNAME, DB_USERNAME,
    DB_PASSWORD, DB_DATABASE);
$GLOBALS['db'] = $dbObj->getConnection();
$GLOBALS['dbrequests'] = 0;


?>
