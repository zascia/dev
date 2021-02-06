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
// init authorization object
// ---------------------------------------------------------------------------

begin_auth();

// ---------------------------------------------------------------------------
// log into global database
// ---------------------------------------------------------------------------

if (GLOBAL_DB_ENABLED == 1) {
    if($_REQUEST['lid'] == '') {
        echo "ERROR: can't get accountid";
        exit;
    }
    
    require_once('SimpleCache.class.php');
    
    $cache =& new SimpleCache(CACHE_PATH.LITE_ACCOUNTS_CACHE_FILENAME);
    if($cache->openRead() === false) {
        echo 'Error opening accountid cache file '.CACHE_PATH.LITE_ACCOUNTS_CACHE_FILENAME;
        exit;
    }
    
    if (($accountinfo = $cache->getData($_REQUEST['lid'])) == false) {
        echo "ERROR: can't get account data for account ".$_REQUEST['lid'];
        exit;
    }
    
    $_SESSION[LID_PREFFIX.'lite_accountid'] = $_REQUEST['lid'];

    $accountinfo = explode(';', $accountinfo);

    $_SESSION[LID_PREFFIX.'lite_accountdb_hostname'] = $accountinfo[0];
    $_SESSION[LID_PREFFIX.'lite_accountdb_username'] = $accountinfo[1];
    $_SESSION[LID_PREFFIX.'lite_accountdb_password'] = $accountinfo[2];
    $_SESSION[LID_PREFFIX.'lite_accountdb_database'] = $accountinfo[3];

    $cache->close();
} else {
    $_SESSION[LID_PREFFIX.'lite_accountdb_hostname'] = DB_HOSTNAME;
    $_SESSION[LID_PREFFIX.'lite_accountdb_username'] = DB_USERNAME;
    $_SESSION[LID_PREFFIX.'lite_accountdb_password'] = DB_PASSWORD;
    $_SESSION[LID_PREFFIX.'lite_accountdb_database'] = DB_DATABASE;
}

// ---------------------------------------------------------------------------
// load param names
// ---------------------------------------------------------------------------
if (GLOBAL_DB_ENABLED == 1) {
    if(!@include_once(CACHE_PATH.$GLOBALS['Auth']->getLiteAccountID().'_paramNames.php')) {
        if(!include_once(CACHE_PATH.'paramNames.php')) {
            echo CACHE_PATH."paramNames.php don't exist, exiting";
            exit;
        }
    }
} else {
    require_once(CACHE_PATH.'paramNames.php');
}
require_once('../settings/paramNamesCheck.php');

// ---------------------------------------------------------------------------
// log into local database
// ---------------------------------------------------------------------------

$dbObj =& QUnit_Global::newObj('QUnit_Sql_DbConnection',
    $_SESSION[LID_PREFFIX.'lite_accountdb_hostname'], $_SESSION[LID_PREFFIX.'lite_accountdb_username'],
    $_SESSION[LID_PREFFIX.'lite_accountdb_password'], $_SESSION[LID_PREFFIX.'lite_accountdb_database']);
$GLOBALS['db'] = $dbObj->getConnection();
$GLOBALS['dbrequests'] = 0;

// ---------------------------------------------------------------------------
// load settings
// ---------------------------------------------------------------------------

begin_loadsettings();

?>
