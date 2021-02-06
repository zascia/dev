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

$GLOBALS['RootPath'] = '..';
require_once('../settings/globalConst.php');

if (GLOBAL_DB_ENABLED == 1) {
    @require_once(CACHE_PATH.$_REQUEST['lite_accountid'].'_paramNames.php');
} else {
    require_once(CACHE_PATH.'paramNames.php');
}
require_once('../settings/settings.php');
define('LANG_PATH', dirname(realpath(__FILE__)).'/../langs/');

if(PAP_RELEASE == 1)
{
    $GLOBALS['IncludesPath'] = '../include/';
    require_once($GLOBALS['IncludesPath'].'QUnit/Global.class.php');
    $GLOBALS['mainTemplatePath'] = '';
}
else
{
    //echo realpath('../../../core/trunk/include/');
    $GLOBALS['IncludesPath'] = '../../../core/trunk/include/';
    require_once($GLOBALS['IncludesPath'].'/QUnit/Global.class.php');
    $GLOBALS['mainTemplatePath'] = '';
}

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

require_once('../settings/trafficLimits.php');

//define('AUTH_CLASS', 'Affiliate_Scripts_Bl_Auth');
//QUnit_Global::includeClass(AUTH_CLASS);
//QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');

// ---------------------------------------------------------------------------
// init authorization object
// ---------------------------------------------------------------------------
//begin_page();

?>
