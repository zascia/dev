<?php

//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

header('Content-Type: application/x-javascript');

require_once('../settings/globalConst.php');

?>

function getCookie() 
{
    var name = "<?php echo COOKIE_NAME?>";
    var nameequals = name+"=";
    var beginpos = 0;
    var beginpos2 = 0;
    while (beginpos < document.cookie.length) 
    { 
        beginpos2 = beginpos + name.length + 1;
        if (document.cookie.substring(beginpos, beginpos2) == nameequals) 
        { 
            var endpos = document.cookie.indexOf (";", beginpos2);
            if (endpos == -1) 
                endpos = document.cookie.length;
            return unescape('<?php echo $_REQUEST['lid']?>_'+document.cookie.substring(beginpos2, endpos));
        }
        beginpos = document.cookie.indexOf(" ", beginpos) + 1;
        if (beginpos == 0) 
            break;
    }
    return '<?php echo $_COOKIE[COOKIE_NAME]?>_<?php echo $_REQUEST['lid']?>';
}