<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
// StormPay callback script
//============================================================================

// include files
require_once('global.php');

DebugMsg("StormPay callback: started, params status='".$_REQUEST['status']."', user1='".$_REQUEST['user1']."', amount='".$_REQUEST['amount']."', transaction_id='".$_REQUEST['transaction_id']."', transaction_ref='".$_REQUEST['transaction_ref']."'", __FILE__, __LINE__);
    

if(isset($_REQUEST['subscription']) && ($_REQUEST['subscription']=="YES" || $_REQUEST['subscription']=="Y")){
	// it is subscription (recurring) payment
    
	$ABid = preg_replace('/[\'\"\ ]/', '', $_REQUEST['user1']);
	$TotalCost = preg_replace('/[^0-9\.]/', '', $_REQUEST['amount']);
	$SubscriptionID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['subscription_id']);
	$ProductID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['transaction_ref']);
	
	
	if(isset($_REQUEST['cancel_command']) && ($_REQUEST['cancel_command'] == 'SYSTEM' || $_REQUEST['cancel_command'] == 'SUBSCRIBER' || $_REQUEST['cancel_command'] == 'ADMIN')){
		
		$recComm = QUnit_Global::newObj('Affiliate_Scripts_Bl_RecurringCommissions');
		$recComm->cancelRecurring($SubscriptionID);
		$errorMsg = "StormPay callback: subscription was cancelled. SubscriptionID=".$SubscriptionID;
	    DebugMsg($errorMsg, __FILE__, __LINE__);    
	    return; // subscription was cancelled
	}
	
	
	if($_REQUEST['status'] != 'SUCCESS')
	{
	    $errorMsg = "StormPay callback: transaction was not in SUCCESS state";
	    LogError($errorMsg, __FILE__, __LINE__);    
	    return; // transaction was cancelled
	}
	
	
	DebugMsg("StormPay callback: Start registering subscription (recurring) payment, custom field: ".$ABid, __FILE__, __LINE__);
    
    $saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');;

    // register sale
    $saleReg->setdefaultAccountID();
    if($saleReg->findPaymentBySubscriptionID($SubscriptionID))
    {
        // we got affiliate id and campaign id filled by findPaymentBySubscriptionID() function
        
        // it is recurring call
        $saleReg->setSaleTypeAndKind(TRANSTYPE_RECURRING, TRANSKIND_RECURRING);
        $saleReg->registerSale($TotalCost, $SubscriptionID, $ProductID, true);
    }
    else
    {
        // it is first subscription call
        if($saleReg->decodeData($ABid))
        {
            DebugMsg("StormPay callback: Start registering sale, params TotalCost='".$TotalCost."', OrderID='".$SubscriptionID."', ProductID='".$ProductID."'", __FILE__, __LINE__);
            
            $saleReg->registerSale($TotalCost, $SubscriptionID, $ProductID, true);
            
            DebugMsg("StormPay callback: End registering sale", __FILE__, __LINE__);
        }
        else
        {
            DebugMsg("StormPay callback: SaleRegistrator->decodeData returned false", __FILE__, __LINE__);                
        }
    }
    
    DebugMsg("StormPay callback: End registering subscription (recurring) payment", __FILE__, __LINE__);

	
} else {
	// normal single purchase
	
	if($_REQUEST['status'] != 'SUCCESS')
	{
	    $errorMsg = "StormPay callback: transaction was not in SUCCESS state";
	    LogError($errorMsg, __FILE__, __LINE__);    
	    return; // transaction was cancelled
	}
	    
	if($_REQUEST['user1'] == '')
	{
	    DebugMsg("StormPay callback: no affiliate parameter given, customer was not referred by any affiliate, or error in passed parameters", __FILE__, __LINE__);
	    return; // no affiliate parameter given, customer was not referred by any affilliate
	}
	
	$ABid = preg_replace('/[\'\"\ ]/', '', $_REQUEST['user1']);
	$TotalCost = preg_replace('/[^0-9\.]/', '', $_REQUEST['amount']);
	$OrderID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['transaction_id']);
	$ProductID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['transaction_ref']);
	
	$saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');
	
	// register sale
	DebugMsg("StormPay callback: Start registering sale, params TotalCost='".$TotalCost."', OrderID='".$OrderID."', ProductID='".$ProductID."'", __FILE__, __LINE__);
	                
	if($saleReg->decodeData($ABid))
	    $saleReg->registerSale($TotalCost, $OrderID, $ProductID, true);
	else
	    DebugMsg("StormPay callback: Data not decoded, failed to save sale", __FILE__, __LINE__);
	
	DebugMsg("StormPay callback: End registering sale", __FILE__, __LINE__);
}
header("HTTP/1.1 202 Accepted");
?>