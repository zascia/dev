<?php
session_start();

echo $_SESSION['graphData'][$_REQUEST['uniq']];
unset($_SESSION['graphData'][$_REQUEST['uniq']]);
?>
