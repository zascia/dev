<?php 
/*
+--------------------------------------------------------------------------
|   CubeCart v3.0.17
|   ========================================
|   by Alistair Brookbanks
|	CubeCart is a Trade Mark of Devellion Limited
|   Copyright Devellion Limited 2005 - 2006. All rights reserved.
|   Devellion Limited,
|   5 Bridge Street,
|   Bishops Stortford,
|   HERTFORDSHIRE.
|   CM23 2JU
|   UNITED KINGDOM
|   http://www.devellion.com
|	UK Private Limited Company No. 5323904
|   ========================================
|   Web: http://www.cubecart.com
|   Date: Tuesday, 17th July 2007
|   Email: sales (at) cubecart (dot) com
|	License Type: CubeCart is NOT Open Source Software and Limitations Apply 
|   Licence Info: http://www.cubecart.com/site/faq/license.php
+--------------------------------------------------------------------------
|	tracker.php
|   ========================================
|	Tracking code for SmartResponse-Media	
+--------------------------------------------------------------------------
*/
$module = fetchDbConfig("SmartResponse-Media");
$affCode = "<!--begin SmartResponse-Media code copyright 2010 -->\r\n";
$affCode .= "<img 
src='http://partner.smartresponse-media.com/i_track_sale/".$module['acNo']."/".$order[0]['prod_total'])."/".$basket['cart_order_id']."/OPTIONAL_INFORMATION' />\r\n";
$affCode .= "<!--end SmartResponse-Media code -->\r\n";
?>