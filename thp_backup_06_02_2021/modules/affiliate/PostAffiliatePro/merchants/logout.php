<?php 
    include_once('global.php');

    // process logout
    $GLOBALS['Auth']->logout();
  
//    QUnit_Templates::includeTemplate('header_popup.tpl.php');
  
    Redirect('index.php');
    $_SESSION[LID_PREFFIX.'lite_accountid'] = '';  
    exit;
?>
