<?php
require_once('../settings/globalConst.php');

// sb input cache
unlink(CACHE_PATH.SB_CACHE_FILENAME);

// t input cache
unlink(CACHE_PATH.T_CACHE_FILENAME);

// refid->userid cache
unlink(CACHE_PATH.REFID_USERID_CACHE_FILENAME);

// rotator output cache
unlink(CACHE_PATH.ROT_OUT_CACHE_FILENAME);

// bannerid->destinationurl cache
unlink(CACHE_PATH.BANNER_DESTURL_CACHE_FILENAME);

?>
