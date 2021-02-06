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

$GLOBALS['RootPath'] = '.';

require_once('./settings/settings.php');
require_once('./settings/globalConst.php');
require_once('./settings/paramNames.php');
require_once('./settings/paramNamesCheck.php');
define('LANG_PATH', dirname(realpath(__FILE__)).'/langs/');

$GLOBALS['CORE_INCLUDE_PATH'] = realpath('include');
$GLOBALS['PROJECT_ROOT_PATH'] = realpath('.');
$GLOBALS['PROJECT_INCLUDE_PATH'] = $GLOBALS['PROJECT_ROOT_PATH'].'/include';
$webRootPath = dirname($_SERVER['PHP_SELF']);
$GLOBALS['WEB_ROOT_PATH'] = (($webRootPath == '/') ? "" : $webRootPath);
$GLOBALS['WEB_PATH'] = 'scripts';

if(PAP_RELEASE == 1)
{
    require_once($GLOBALS['CORE_INCLUDE_PATH'].'/QUnit/Global.class.php');
}
else
{
    require_once($GLOBALS['CORE_INCLUDE_PATH'].'/QUnit/Global.class.php');
}

// ---------------------------------------------------------------------------
// include files
// ---------------------------------------------------------------------------
QUnit_Global::includeClass('QUnit_GlobalFuncs');
QUnit_Global::includeClass('QCore_Sql_DBUnit');
QUnit_Global::includeClass('QCore_History');
require_once('./settings/emailTemplates.php');

QUnit_Global::includeClass('Affiliate_Merchants_Bl_MerchantDBAuth');
QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');

QUnit_Global::includeClass('QCore_Constants');
QCore_Constants::initConstants();

QUnit_Global::includeClass('QUnit_Page');
QUnit_Page::init_page();

//define('AUTH_CLASS', 'Affiliate_Merchants_Bl_MerchantDBAuth');
define('AUTH_CLASS', 'Affiliate_Scripts_Bl_Auth');
define('LOGIN_PAGE', 'QCore_Login');
define('TEMPLATES_PATH','./scripts/templates/');


// ---------------------------------------------------------------------------
// log in to database
// ---------------------------------------------------------------------------
$dbObj =& QUnit_Global::newObj('QUnit_Sql_DbConnection', DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$GLOBALS['db'] = $dbObj->getConnection();
$GLOBALS['dbrequests'] = 0;


// ---------------------------------------------------------------------------
// init authorization object
// ---------------------------------------------------------------------------
begin_page();


// ---------------------------------------------------------------------------
// set language file
// ---------------------------------------------------------------------------
setLanguage();


// ---------------------------------------------------------------------------
// load menus (after language)
// ---------------------------------------------------------------------------
//loadMenu('./menu_left.php');


// ---------------------------------------------------------------------------
// set template and style
// ---------------------------------------------------------------------------
unset($_SESSION[SESSION_PREFIX.'template']);
unset($_SESSION[SESSION_PREFIX.'templateImages']);
unset($_SESSION[SESSION_PREFIX.'style']);
unset($_SESSION[SESSION_PREFIX.'javascript']);
if(empty($_SESSION[SESSION_PREFIX.'template']))
  $_SESSION[SESSION_PREFIX.'template'] = TEMPLATES_PATH.DEFAULT_TEMPLATE;
if(empty($_SESSION[SESSION_PREFIX.'templateImages']))
  $_SESSION[SESSION_PREFIX.'templateImages'] = $_SESSION[SESSION_PREFIX.'template'].TEMPATE_IMAGES;
if(empty($_SESSION[SESSION_PREFIX.'style']))
  $_SESSION[SESSION_PREFIX.'style'] = $_SESSION[SESSION_PREFIX.'template'].'/'.DEFAULT_STYLE;
if(empty($_SESSION[SESSION_PREFIX.'javascript']))
  $_SESSION[SESSION_PREFIX.'javascript'] = $GLOBALS['IncludesPath'].'/QUnit/functions.js';
?>
