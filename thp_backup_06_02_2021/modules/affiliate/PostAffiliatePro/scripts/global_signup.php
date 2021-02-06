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

define('LID_PREFFIX', 's_');

require_once('../settings/settings.php');
require_once('../settings/globalConst.php');

define('LANG_PATH', dirname(realpath(__FILE__)).'/../langs/');



if(PAP_RELEASE == 1)
{
    $GLOBALS['CORE_INCLUDE_PATH'] = realpath('../include');
    $GLOBALS['PROJECT_ROOT_PATH'] = realpath('../');
    $GLOBALS['PROJECT_INCLUDE_PATH'] = $GLOBALS['PROJECT_ROOT_PATH'].'/include';
    $webRootPath = dirname($_SERVER['PHP_SELF']).'/..';
    $GLOBALS['WEB_ROOT_PATH'] = (($webRootPath == '/') ? "" : $webRootPath);
    $GLOBALS['WEB_PATH'] = 'scripts';
}
else
{
    $GLOBALS['CORE_INCLUDE_PATH'] = realpath(dirname(realpath(__FILE__)).'/../include');
    $GLOBALS['PROJECT_ROOT_PATH'] = realpath('../');
    $GLOBALS['PROJECT_INCLUDE_PATH'] = $GLOBALS['PROJECT_ROOT_PATH'].'/include';
    $webRootPath = dirname($_SERVER['PHP_SELF']).'/..';
    $GLOBALS['WEB_ROOT_PATH'] = (($webRootPath == '/') ? "" : $webRootPath);
    $GLOBALS['WEB_PATH'] = 'scripts';
}

require_once($GLOBALS['CORE_INCLUDE_PATH'].'/QUnit/Global.class.php');

// ---------------------------------------------------------------------------
// include files
// ---------------------------------------------------------------------------
QUnit_Global::includeClass('QUnit_GlobalFuncs');
QUnit_Global::includeClass('QCore_Sql_DBUnit');
QUnit_Global::includeClass('QCore_History');
require_once('../settings/emailTemplates.php');

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
// init authorization object
// ---------------------------------------------------------------------------

begin_auth();

// ---------------------------------------------------------------------------
// log into global database
// ---------------------------------------------------------------------------

if (GLOBAL_DB_ENABLED == 1) {
    if (!$GLOBALS['Auth']->isLogged()) {
        
        if($_REQUEST['lid'] != '') {
            $_SESSION[LID_PREFFIX.'lite_accountid'] = $_REQUEST['lid'];
        }

        if($_SESSION[LID_PREFFIX.'lite_accountid'] == '') {
            Redirect_nomsg(LOGIN_ERROR_REDIRECT);
            exit;
        }

        // global database
        $dbObj =& QUnit_Global::newObj('QUnit_Sql_DbConnection', DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
        $GLOBALS['db'] = $dbObj->getConnection();
        $GLOBALS['dbrequests'] = 0;

        $sql = 'select * from wd_c_liteaccounts'.
        ' where liteaccountid='._q($_SESSION[LID_PREFFIX.'lite_accountid']).
        ' and rtype > '._q(ACCOUNT_TEMP);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs || $rs->EOF) {
            Redirect_nomsg(LOGIN_ERROR_REDIRECT);
            exit;
        }

        $_SESSION[LID_PREFFIX.'lite_accountdb_hostname'] = $rs->fields['dbhost'];
        $_SESSION[LID_PREFFIX.'lite_accountdb_username'] = $rs->fields['dbuname'];
        $_SESSION[LID_PREFFIX.'lite_accountdb_password'] = $rs->fields['dbpwd'];
        $_SESSION[LID_PREFFIX.'lite_accountdb_database'] = $rs->fields['dbname'];

        if (strstr(basename($_SERVER[PHP_SELF]), 'index')) {
            $_POST['commited']  = 'yes';
            $_POST['md']        = 'QCore_Login';
            $_POST['accountid'] = DEFAULT_ACCOUNT;
            $_POST['action']    = 'login';
            $_POST['username']  = $_SESSION[LID_PREFFIX.'lite_username'];
            $_POST['rpassword'] = $_SESSION[LID_PREFFIX.'lite_password'];
            foreach ($_POST as $key => $value) {
                $_REQUEST[$key] = $value;
            }
        }

        $GLOBALS['db']->disconnect();
    }
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
    @include(CACHE_PATH.$GLOBALS['Auth']->getLiteAccountID().'_paramNames.php');
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
