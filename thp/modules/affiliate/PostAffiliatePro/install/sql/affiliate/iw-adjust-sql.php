<?php

$f = fopen('iw_update.sql', 'r');
$str = fread($f, filesize('iw_update.sql'));
fclose($f);

$str = str_replace('$LID_URL', '', $str);
$str = str_replace('$LID_JS', '', $str);

$f = fopen('iw_update.sql', 'w');
fwrite($f, $str);
fclose($f);

?>