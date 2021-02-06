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

// ---------------------------------------------------------------------------
// include files
// ---------------------------------------------------------------------------
QUnit_Global::includeClass('QUnit_GlobalFuncs');
QUnit_Global::includeClass('QCore_Sql_DBUnit');
QUnit_Global::includeClass('QUnit_Messager');
QUnit_Global::includeClass('QCore_History');
require_once('../settings/emailTemplates.php');

QUnit_Global::includeClass('QCore_Constants');
QCore_Constants::initConstants();

define('AUTH_CLASS', 'Affiliate_Scripts_Bl_Auth');
QUnit_Global::includeClass(AUTH_CLASS);
QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');

// ---------------------------------------------------------------------------
// log in to database
// ---------------------------------------------------------------------------
$dbObj =& QUnit_Global::newObj('QUnit_Sql_DbConnection', DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$GLOBALS['db'] = $dbObj->getConnection();
$GLOBALS['dbrequests'] = 0;;

?>
