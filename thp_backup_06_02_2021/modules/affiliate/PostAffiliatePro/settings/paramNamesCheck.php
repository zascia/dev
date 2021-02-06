<?php
    $error = true;
    
    if (defined("NAME_A_AID") && defined("NAME_A_BID") && defined("NAME_DATA1") &&
        defined("NAME_DATA2") && defined("NAME_DATA3") && defined("NAME_DESTURL") ) {
            $error = false;
        }
    
    if (!$error) {
        $paramNames = array(NAME_A_AID, NAME_A_BID, NAME_DATA1, NAME_DATA2, NAME_DATA3, NAME_DESTURL);
        foreach ($paramNames as $name) {
            if ($name == '')
                $error = true;
        }
        if (array_unique($paramNames) != $paramNames)
            $error = true;
    }
    
    if ($error) {
        define('PARAM_A_AID',   'a_aid');
        define('PARAM_A_BID',   'a_bid');
        define('PARAM_DATA1',   'data1');
        define('PARAM_DATA2',   'data2');
        define('PARAM_DATA3',   'data3');
        define('PARAM_DESTURL', 'desturl');
    } else {
        define('PARAM_A_AID',   NAME_A_AID);
        define('PARAM_A_BID',   NAME_A_BID);
        define('PARAM_DATA1',   NAME_DATA1);
        define('PARAM_DATA2',   NAME_DATA2);
        define('PARAM_DATA3',   NAME_DATA3);
        define('PARAM_DESTURL', NAME_DESTURL);
    }    
?>