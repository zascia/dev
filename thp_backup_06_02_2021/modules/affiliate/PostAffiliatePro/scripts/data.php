<?php
//============================================================================
// Copyright (c) Ladislav Tamas, qualityunit.com 2005
// All rights reserved
//
// For support contact info@qualityunit.com
//============================================================================

require_once('global.php');
?>
<xml>
<?php
$username = preg_replace('/[\'\"]/', '', $_REQUEST['u']);
$password = preg_replace('/[\'\"]/', '', $_REQUEST['p']);
$lastTransId = preg_replace('/[\'\"]/', '', $_REQUEST['lt']);
$lastAffId = preg_replace('/[\'\"]/', '', $_REQUEST['la']);
$lastNewsId = preg_replace('/[\'\"]/', '', $_REQUEST['ln']);
$date = preg_replace('/[\'\"]/', '', $_REQUEST['d']);
$recordsLimit = preg_replace('/[\'\"]/', '', $_REQUEST['lm']);

if($username == '' || $password == '') {
    echo "<error>Username or password is empty</error>";
    exit;
}

$affData = QUnit_Global::newObj('Affiliate_Scripts_Bl_Data');

if(!$affData->checkUser($username, $password)) {
    echo "<error>".$affData->getError()."</error>";
    exit;
}

$params = array();
$params['date'] = $date;
$params['recordsLimit'] = $recordsLimit;
$params['lastTransId'] = $lastTransId;
$params['lastAffId'] = $lastAffId;
$params['lastNewsId'] = $lastNewsId;

echo $affData->getNotifications($params);

?>
</xml>
