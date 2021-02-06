<?php
/**
*
*   @author Maros Fric
*   @copyright Copyright (c) webradev.com
*   All rights reserved
*
*   @package PostAffiliate Pro
*   @since Version 2.0
*
*   For support contact info@webradev.com
*/

//============================================================================
// Other constants
// Do not edit anything below this line unless you know exactly
// what are you doing.
//============================================================================

define('POSTGLOBAL_VERSION', '3.1.5');
define('SESSION_PREFIX','merch');
define('TEMPATE_IMAGES','/images/');
define('DEFAULT_STYLE','blue');
define('DB_DEBUG', 0);
define('AFF_DEMO', 0);
define('PAP_RELEASE', 1);
define('PAP_STARTING_YEAR', 2003);
define('GLOBAL_DB_ENABLED', 0);
define('QUICK_IMPRESSION_ENABLED', 0);

if (GLOBAL_DB_ENABLED == 1) {
	if (isset($_REQUEST['lid']) && ($_REQUEST['lid'] != '')) {
		$lid = $_REQUEST['lid'];
	} elseif (isset($_SESSION[LID_PREFFIX.'lite_accountid']) && ($_SESSION[LID_PREFFIX.'lite_accountid'] != '')) {
		$lid = $_SESSION[LID_PREFFIX.'lite_accountid'];
	} else {
		$lid = '';
	}
	define('COOKIE_NAME',      'POSTAff2Cookie_'.$lid);
	define('TIME_COOKIE_NAME', 'POSTAff2TimeCookie_'.$lid);
	define('CLICK_COOKIE_NAME','POSTAff2ClickCookie_'.$lid);
	define('REF_COOKIE_NAME',  'PAPR_0_'.$lid);
} else {
	define('COOKIE_NAME',      'POSTAff2Cookie');
	define('TIME_COOKIE_NAME', 'POSTAff2TimeCookie');
    define('CLICK_COOKIE_NAME','POSTAff2ClickCookie');
	define('REF_COOKIE_NAME',  'PAPR_0');
}

define('PROG_TYPE_PRO',        1);
define('PROG_TYPE_ENTERPRISE', 2);
define('PROG_TYPE_NETWORK',    3);
define('PROG_TYPE_ECOMMAGNET', 4);
define('PROG_TYPE_LITE',       5);
define('AFF_PROGRAM_TYPE',     PROG_TYPE_PRO);


if(AFF_PROGRAM_TYPE == PROG_TYPE_ECOMMAGNET) {
	define('PRODUCT', 'ecommagnet');
	define('DEFAULT_TEMPLATE','default');
} else if(AFF_PROGRAM_TYPE == PROG_TYPE_LITE) {
	define('DEFAULT_CAMPAIGN', '1');
	define('PRODUCT', 'afflite');
    define('DEFAULT_TEMPLATE','default');
} else if(AFF_PROGRAM_TYPE == PROG_TYPE_PRO) {
    define('PRODUCT', 'affiliate');
    define('DEFAULT_TEMPLATE','default');
} else {
    define('PRODUCT', 'affent');
    define('DEFAULT_TEMPLATE','default');
}

define('DEFAULT_PRODUCT', 'affiliate');

if(PAP_RELEASE == 1) {
    $GLOBALS['CORE_INCLUDE_PATH'] = realpath(dirname(realpath(__FILE__)) . '/../include');
    $GLOBALS['PROJECT_ROOT_PATH'] = realpath(dirname(realpath(__FILE__)) . '/..');
    $GLOBALS['PROJECT_INCLUDE_PATH'] = $GLOBALS['PROJECT_ROOT_PATH'].'/include';
    $webRootPath = dirname(dirname($_SERVER['PHP_SELF']));
    $GLOBALS['WEB_ROOT_PATH'] = (($webRootPath == '/' || $webRootPath == '\\') ? "" : $webRootPath);
    $GLOBALS['WEB_INCLUDE_PATH'] = '../include';
    $GLOBALS['WEB_PATH'] = basename(realpath('.')); // basename(dirname($_SERVER["PHP_SELF"]))
} else {
    $GLOBALS['CORE_INCLUDE_PATH'] = realpath(dirname(realpath(__FILE__)) . '/../include');
    $GLOBALS['PROJECT_ROOT_PATH'] = realpath(dirname(realpath(__FILE__)) . '/..');
    $GLOBALS['PROJECT_INCLUDE_PATH'] = $GLOBALS['PROJECT_ROOT_PATH'].'/include';
    $webRootPath = dirname(dirname($_SERVER['PHP_SELF']));
    $GLOBALS['WEB_ROOT_PATH'] = (($webRootPath == '/' || $webRootPath == '\\') ? "" : $webRootPath);
    $GLOBALS['WEB_INCLUDE_PATH'] = '../include';
//	$GLOBALS['WEB_INCLUDE_PATH'] = '../../../core/trunk/include';
    $GLOBALS['WEB_PATH'] = basename(realpath('.'));
}
        
// Pear Libraries ----------------------------------
set_include_path($GLOBALS['CORE_INCLUDE_PATH'].'/Pear/'.PATH_SEPARATOR.'./'.PATH_SEPARATOR.get_include_path());
//--------------------------------------------------

// PayPal Libraries --------------------------------
$include_path = ini_get('include_path');
if (strpos($include_path, $GLOBALS['CORE_INCLUDE_PATH']) === false) {
    $include_path .= ';'.$GLOBALS['CORE_INCLUDE_PATH'];
    if (@ini_set('include_path', $include_path) === false) {
        echo "Error setting include path '".$GLOBALS['CORE_INCLUDE_PATH']."'<br>Please set it manually";
        exit();
    }
}
if (strpos($include_path, $GLOBALS['CORE_INCLUDE_PATH'].'/pear/') === false) {
    $include_path .= ';'.$GLOBALS['CORE_INCLUDE_PATH'].'/pear/';
    if (@ini_set('include_path', $include_path) === false) {
        echo "Error setting include path '".$GLOBALS['CORE_INCLUDE_PATH'].'/pear/'."'<br>Please set it manually";
        exit();
    }
}
// -------------------------------------------------

// caching settings
define('USE_CACHING', 0);
define('USE_GRAPH_CACHING', 1);

//define('CACHE_CLASS_FILE',              'TextCache.class.php');
define('CACHE_CLASS_FILE',              'DbmCache.class.php');
define('CACHE_PATH',                    $GLOBALS['PROJECT_ROOT_PATH'].'/cache/');
define('SB_CACHE_FILENAME',             'sb_cache.dbm');
define('SB_OUTPUT_CACHE_FILENAME',      'sb_out_cache.dbm');
define('LOG_CACHE_FILENAME',            'log_cache.dbm');
define('T_CACHE_FILENAME',              't_cache.dbm');
define('T_OUTPUT_CACHE_FILENAME',       't_out_cache.dbm');
define('REFID_USERID_CACHE_FILENAME',   'refid_user_cache.dbm');
define('ROT_OUT_CACHE_FILENAME',        'rot_out_cache.dbm');
define('ROT_DESC_CACHE_FILENAME',       'rot_desc_cache.dbm');
define('BANNER_DESTURL_CACHE_FILENAME', 'banner_desturl_cache.dbm');

define('LITE_ACCOUNTS_CACHE_FILENAME',  'lite_accounts.dbm');
define('BANNERS_CACHE_FILENAME',        'banners.dbm');

define('CACHED_FILE_EXPIRATION', 300); // in seconds

define('TRANSKIND_NORMAL',      1);
define('TRANSKIND_RECURRING',   3);
define('TRANSKIND_SECONDTIER', 10);

define('TRANSTYPE_CLICK',        1);
define('TRANSTYPE_LEAD',         2);
define('TRANSTYPE_SALE',         4);
define('TRANSTYPE_RECURRING',    8);
define('TRANSTYPE_SIGNUP',      16);
define('TRANSTYPE_CPM',         32);
define('TRANSTYPE_REFERRAL',    64);
define('TRANSTYPE_REFUND',     128);
define('TRANSTYPE_CHARGEBACK', 256);

define('BANNERTYPE_TEXT',       1);
define('BANNERTYPE_IMAGE',      2);
define('BANNERTYPE_HTML',       3);
define('BANNERTYPE_POPUP',      4);
define('BANNERTYPE_POPUNDER',   5);
define('BANNERTYPE_ROTATOR',    6);
define('BANNERTYPE_TEXTEMAIL', 14);
define('BANNERTYPE_HTMLEMAIL', 15);

define('URL_OWN',   1);
define('URL_EXIST', 2);

define('WINDOWSIZE_PREDEFINED', 1);
define('WINDOWSIZE_OWN',        2);

define('RECURRINGTYPE_MONTHLY',    1);
define('RECURRINGTYPE_WEEKLY',     2);
define('RECURRINGTYPE_QUARTERLY',  3);
define('RECURRINGTYPE_BIANNUALLY', 4);
define('RECURRINGTYPE_YEARLY',     5);

define('PAYOUT_TYPE_WIRE',              1);
define('PAYOUT_TYPE_PAYPAL',            2);
define('PAYOUT_TYPE_MONEYBOOKERS',      3);
define('PAYOUT_TYPE_CHECK',             4);

define('LINK_STYLE_OLD', 1);
define('LINK_STYLE_NEW', 2);

define('AFF_CAMP_PUBLIC',  1);
define('AFF_CAMP_PRIVATE', 2);

define('PAYOUTFIELD_TYPE_TEXT',   1);
define('PAYOUTFIELD_TYPE_SELECT', 2);

define('MATRIX_ALL_AFFILIATES', 'm1');
define('MATRIX_NO_SPONSOR',     'm2');
define('MATRIX_ACTUAL_SPONSOR', 'm3');

define('RULE_ALL',                   1);
define('RULE_NUMBER_OF_SALES',       2);
define('RULE_AMOUNT_OF_COMMISSIONS', 3);
define('RULE_ACTUAL_MONTH',          4);
define('RULE_ACTUAL_YEAR',           5);
define('RULE_LOWER',                 6);
define('RULE_HIGHER',                7);
define('RULE_IS',                    8);
define('RULE_IS_BETWEEN',            9);
define('RULE_AMOUNT_OF_TOTAL_COST', 10);
define('RULE_LAST_WEEK',            11);
define('RULE_LAST_TWOWEEKS',        12);
define('RULE_LAST_MONTH',           13);
define('RULE_LAST_YEAR',            14);

define('PERIODICITY_WEEKLY',   1);
define('PERIODICITY_BIWEEKLY', 2);
define('PERIODICITY_MONTHLY',  3);

define('SELFOPTIMIZATION_NONE',       0);
define('SELFOPTIMIZATION_CLICKS',     1);
define('SELFOPTIMIZATION_CTR',        2);
define('SELFOPTIMIZATION_SPEED',      100);
define('MAX_RANK',                    100);
define('RANK_PRECISION',              2);

define('ROTATOR_CONTENT_CHANGE',  1);
define('ROTATOR_RESET_STATS',     2);
define('ROTATOR_RESET_RANK',      4);

define('SALE_TRACKING_COOKIE',          1);
define('SALE_TRACKING_IP',              2);
define('SALE_TRACKING_REFERRED',        3);
define('SALE_TRACKING_SESSION',         4);
define('SALE_TRACKING_1STPARTY_COOKIE', 5);
define('SALE_TRACKING_FLASH',           6);
define('SALE_TRACKING_AFFILIATEID',     7);

// account transaction count types
define('LIMIT_COUNT_IMPRESSIONS', 1);
define('LIMIT_COUNT_CLICKS',      2);
define('LIMIT_COUNT_SALES',       4);

define('LIMIT_DEFAULT_REDIRECT', 'http://www.affplanet.com');
define('LOGIN_ERROR_REDIRECT',   'http://www.affplanet.com');

// import file field type
define('FIELD_MANDATORY',   1);
define('FIELD_NOIMPORT',    2);
define('FIELD_PROCESS',     4);

define('STANDARD_AFFILIATE', 0);
define('VIRTUAL_AFFILIATE',  1);

define('AGGREGATION_HOUR', 1);
define('AGGREGATION_DAY',  2);

// define account types for ecommagnet
define('AFF_ACC_TYPE_PRETEMP',          '0');
define('AFF_ACC_TYPE_TEMP',             'T');
define('AFF_ACC_TYPE_ERROR',            'E');
define('AFF_ACC_TYPE_PAID',             'Y');
define('AFF_ACC_TYPE_PENDINGPAID',      'K');
define('AFF_ACC_TYPE_LIVE',             'S');
define('AFF_ACC_TYPE_PROCESSING',       'P');
define('AFF_ACC_TYPE_SIGNEDNOACCOUNT',  'N');
define('AFF_ACC_TYPE_UPDATEPLANNED',    'U');

// scheduled jobs
define('JOB_TYPE_DAILYREPORTS',          1);
define('JOB_TYPE_WEEKLYREPORTS',         2);
define('JOB_TYPE_MONTHLYREPORTS',        3);
define('JOB_TYPE_RECURRINGCOMMISSIONS',  4);
define('JOB_TYPE_CACHECLEAN',            5);

// aff overwrite cookies
define('AFF_OVERWRITE_COOKIE_DEFAULT', 1);
define('AFF_OVERWRITE_COOKIE_ON',      2);
define('AFF_OVERWRITE_COOKIE_OFF',     3);

// import
define('IMPORTSTATUS_PAID',     10);
define('IMPORTSTATUS_FROMFILE', 11);

// invoice sending
define('SEND_TO_MERCHANT',             1);
define('SEND_TO_AFFILIATE',            2);
define('SEND_TO_MERCHANTANDAFFILIATE', 3);

// update url
define('INTEGRATION_UPDATE_SERVER', 'www.qualityunit.com');
define('INTEGRATION_VERSION_FILE',  '/doc/iw_update.ver');
define('INTEGRATION_UPDATE_FILE',   '/doc/iw_update.sql');


define('UNASSIGNED_USERS', 'L_G_UNASSIGNED_USERS');

define('COOKIE_JS_CODE', '<script><br>
$SCRIPTDIR<br>
$AID<br>
$BID<br>
$DATA1<br>
$DATA2 <br>
$DATA3 <br></script>');

define('DEFAULT_BANNER_FORMAT', '<a href=$DESTINATION><strong>$TITLE</strong><br>$DESCRIPTION$IMPRESSION_TRACK</a>');
define('DEFAULT_GRAPHICS_BANNER_FORMAT', '<a href=$DESTINATION><img src=$IMAGE_SRC alt="$ALT" title="$ALT"></a>');

$classMap = array();
//$classMap[PROG_TYPE_ENTERPRISE]['Affiliate_Merchants_Views_Settings'] = 'AffEnt_Merchants_Views_Settings';
$classMap[PROG_TYPE_ENTERPRISE]['Affiliate_Merchants_Bl_MerchantDBAuth'] = 'AffEnt_Merchants_Bl_MerchantDBAuth';
$classMap[PROG_TYPE_ENTERPRISE]['Affiliate_Affiliates_Bl_AffiliateDBAuth'] = 'AffEnt_Affiliates_Bl_AffiliateDBAuth';
//$classMap[PROG_TYPE_ENTERPRISE]['Affiliate_Merchants_Views_Menu'] = 'AffEnt_Merchants_Views_Menu';
$classMap[PROG_TYPE_NETWORK]['Affiliate_Merchants_Bl_MerchantDBAuth'] = 'AffNet_Merchants_Bl_MerchantDBAuth';
$classMap[PROG_TYPE_NETWORK]['Affiliate_Affiliates_Bl_AffiliateDBAuth'] = 'AffNet_Affiliates_Bl_AffiliateDBAuth';

$mdClassMap = array();
$mdClassMap[PROG_TYPE_LITE]['Affiliate_Merchants_Views_AffiliateManager'] = 'AffLite_Merchants_Views_AffiliateManager';
$mdClassMap[PROG_TYPE_LITE]['Affiliate_Merchants_Views_TransactionManager'] = 'AffLite_Merchants_Views_TransactionManager';
$mdClassMap[PROG_TYPE_LITE]['Affiliate_Merchants_Views_Settings'] = 'AffLite_Merchants_Views_Settings';
$mdClassMap[PROG_TYPE_LITE]['Affiliate_Affiliates_Views_AffBannerManager'] = 'AffLite_Affiliates_Views_AffBannerManager';

$GLOBALS['UPLOAD_ALLOWED_FILE_TYPES'] = array('jpg', 'png', 'gif', 'csv', 'txt');

?>
