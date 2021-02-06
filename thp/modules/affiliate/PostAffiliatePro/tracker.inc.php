<?php 
/*
+--------------------------------------------------------------------------
|   CubeCart v3.0.10
|   ========================================
|   by Alistair Brookbanks
|	CubeCart is a Trade Mark of Devellion Limited
|   Copyright Devellion Limited 2005 - 2006. All rights reserved.
|   Devellion Limited,
|   22 Thomas Heskin Court,
|   Station Road,
|   Bishops Stortford,
|   HERTFORDSHIRE.
|   CM23 3EE
|   UNITED KINGDOM
|   http://www.devellion.com
|	UK Private Limited Company No. 5323904
|   ========================================
|   Web: http://www.cubecart.com
|   Date: Tuesday, 14th March 2006
|   Email: info (at) cubecart (dot) com
|	License Type: CubeCart is NOT Open Source Software and Limitations Apply 
|   Licence Info: http://www.cubecart.com/site/faq/license.php
+--------------------------------------------------------------------------
|	tracker.php
|   ========================================
|	Tracking code for PostAffiliatePro	
+--------------------------------------------------------------------------
*/
$module = fetchDbConfig("PostAffiliatePro");
$affCode = "<!-- begin PostAffiliatePro Affiliate Tracker -->\r\n";
$affCode .= "<img border='0' src='".$module['URL']."/scripts/sale.php?TotalCost=".sprintf("%.2f", $order[0]['prod_total'])."&OrderID=".$basket['cart_order_id']."' width='0' height='0'' />\r\n";
$affCode .= "<!-- end PostAffiliatePro Affiliate Tracker -->\r\n";
?>
