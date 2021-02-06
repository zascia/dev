<?php 
//============================================================================
// Copyright (c) Ladislav Tamas, qualityunit.com 2005
// All rights reserved
//
// For support contact info@qualityunit.com
//============================================================================

require_once('global.php');

$affiliateid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);
$tag = preg_replace('/[\'\"]/', '', $_REQUEST['tag']);
$AccountID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['accountid']);

if($affiliateid == '')
{
    $blRegistrator = QUnit_Global::newObj('Affiliate_Scripts_Bl_Registrator');
    if($blRegistrator->setAccountID($AccountID) == false) return;
    
    $blRegistrator->setP3PPolicy();

    $temp = $blRegistrator->decodeValue($_COOKIE[COOKIE_NAME]);
    $affiliateid = $temp[0];
}

if($affiliateid == '' || $tag == '')
    return;

$blAffiliate = QUnit_Global::newObj('Affiliate_Scripts_Bl_Affiliate');
$userInfo = $blAffiliate->getUserInfo($affiliateid);

if(is_array($userInfo) && count($userInfo) > 0)
    print 'document.write("'.$userInfo[$tag].'");';
?>
