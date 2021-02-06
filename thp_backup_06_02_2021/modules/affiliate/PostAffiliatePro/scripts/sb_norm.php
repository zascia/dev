<?php

require_once('global_optimized.php');

$bannerViewer = QUnit_Global::newObj('Affiliate_Scripts_Bl_BannerViewerOptimized');
$bannerViewer->setDb($GLOBALS['dbObj']);
$bannerViewer->process();

?>
