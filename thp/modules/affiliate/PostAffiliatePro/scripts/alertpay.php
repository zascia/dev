<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('global.php');

DebugMsg("Alertpay callback: started", __FILE__, __LINE__);

// assign posted variables to local variables
$custom = $_POST['apc_6'];
$purchase_type = $_POST['ap_purchasetype'];
$txn_id = $_POST['ap_referencenumber'];
$item_number = $_POST['ap_itemname'];
$payment_amount = $_POST['ap_totalamount'];
$payment_status = $_POST['ap_status'];

$postvars = '';
foreach($_POST as $k=>$v)
    $postvars .= "$k=$v;";
DebugMsg("Alertpay callback: POST variables: $postvars", __FILE__, __LINE__);
    
if($custom == '')
{
    DebugMsg("Alertpay callback: custom field is empty", __FILE__, __LINE__);                
}

if($purchase_type=="Item" && $payment_status=="Success"){
	
	DebugMsg("Alertpay callback: Start registering sale, custom field: $custom", __FILE__, __LINE__);
	
	$saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');
	
	// register sale
	if($saleReg->decodeData($custom))
	{
	    DebugMsg("Alertpay callback: Start registering sale, params TotalCost='".$payment_amount."', OrderID='".$txn_id."', ProductID='".$item_number."'", __FILE__, __LINE__);
	    
	    $saleReg->registerSale($payment_amount, $txn_id, $item_number, true);
	    
	    DebugMsg("Alertpay callback: End registering sale", __FILE__, __LINE__);
	}
	else
	{
	    DebugMsg("Alertpay callback: SaleRegistrator->decodeData returned false", __FILE__, __LINE__);                
	}
	
	DebugMsg("Alertpay callback: End registering sale", __FILE__, __LINE__);
}


?>



