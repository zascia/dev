<?php 
    include_once('global.php');

    // process logout
    $redirect_url = $GLOBALS['Auth']->getSetting('Aff_afflogouturl');
    $GLOBALS['Auth']->logout();

    $_SESSION[LID_PREFFIX.'lite_accountid'] = '';
    if($redirect_url != '')
        Redirect($redirect_url);
    else
        Redirect('index.php');
    exit;
?>
