<?php
include_once('../Global.class.php');
/**
*
*   @author Andrej Harsani
*   @copyright Copyright © 2004
*   @package QUnit
*   @since Version 0.1a
*   $Id: run.php,v 1.1.1.1 2005/04/22 10:13:37 jsujan Exp $
*/

$namespaceRunner = QUnit_Global::newObj('QUnit_TestNamespaceRunner');
$namespaceRunner->run('QUnit');
?>