<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('global_dump.php');

require_once('SimpleCache.class.php');

$cache =& new SimpleCache(CACHE_PATH.LITE_ACCOUNTS_CACHE_FILENAME);
if($cache->openWrite() === false) {
    echo 'Error opening accountid cache file '.CACHE_PATH.LITE_ACCOUNTS_CACHE_FILENAME;
    exit;
}

$sql = "select * from wd_c_liteaccounts";

$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

if (!$rs) {
    echo "DBERROR";
    exit;
}

while (!$rs->EOF) {
    $data = $rs->fields['dbhost'].';'.$rs->fields['dbuname'].';'.$rs->fields['dbpwd'].';'.$rs->fields['dbname'];
    $cache->replace($rs->fields['liteaccountid'], $data);
    $rs->MoveNext();
}

$cache->close();

?>
OK
