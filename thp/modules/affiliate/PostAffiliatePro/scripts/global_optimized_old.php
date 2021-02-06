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

//apd_set_pprof_trace();
//xdebug_start_profiling('/home/juju/devel/qu/output_profiling.htmls');

error_reporting(E_ALL ^ E_NOTICE);

$GLOBALS['RootPath'] = '..';
require('../settings/settings.php');
require('../settings/globalConst.php');
require('../settings/paramNames.php');
require('../settings/paramNamesCheck.php');

//define('LANG_PATH', dirname(realpath(__FILE__)).'/../langs/');

if(PAP_RELEASE == 1)
{
    $GLOBALS['IncludesPath'] = '../include/';
    require($GLOBALS['IncludesPath'].'QUnit/Global.class.php');
    $GLOBALS['mainTemplatePath'] = '';
}
else
{
    $GLOBALS['IncludesPath'] = '../../..';
    require($GLOBALS['IncludesPath'].'/QUnit/Global.class.php');
    $GLOBALS['mainTemplatePath'] = '';
}


// ---------------------------------------------------------------------------
// include files
// ---------------------------------------------------------------------------
QUnit_Global::includeClass('QUnit_GlobalFuncs');
QUnit_Global::includeClass('QCore_Sql_DBUnit');
QUnit_Global::includeClass('QUnit_Messager');
QUnit_Global::includeClass('QCore_History');

QUnit_Global::includeClass('QCore_Constants');
QCore_Constants::initConstants();

// ---------------------------------------------------------------------------
// log in to database
// ---------------------------------------------------------------------------
require(BASEDIR . '/adodb/adodb.inc.php');
$GLOBALS['db'] =& NewADOConnection(DB_TYPE);
$GLOBALS['db']->Connect(DB_HOSTNAME, DB_USERNAME, 
                DB_PASSWORD,DB_DATABASE);
/*$dbObj =& QUnit_Global::newObj('QUnit_Sql_DbConnection', DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$GLOBALS['db'] = $dbObj->getConnection();*/
$GLOBALS['dbrequests'] = 0;;

//xdebug_dump_function_profile(4);
//$output = xdebug_get_function_profile(4);
//$fp = fopen('/home/juju/devel/qu/bench2/output.'.md5(microtime()).'.ser', 'w');
//fwrite($fp, serialize($output));
//fclose($fp);

?>
