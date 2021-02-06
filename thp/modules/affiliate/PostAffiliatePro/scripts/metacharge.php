<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//
// script for handling Metacharge payments
//============================================================================

// include files
require_once('global.php');


// assign posted variables to local variables
$intStatus = $_POST['intStatus'];
$intTestMode = $_POST['intTestMode'];

if($intStatus>0 && $intTestMode=="0"){
	
	DebugMsg("Metacharge callback: started", __FILE__, __LINE__);

	$postvars = '';
    foreach($_POST as $k=>$v)
        $postvars .= "$k=$v;";
	DebugMsg("Metacharge callback: POST variables: $postvars", __FILE__, __LINE__);
	
	
	if(isset($_POST['intScheduleID'])){
		// subscription payment/notification
		
		if(!isset($_POST['fltAmount'])){
			// notification about starting subscription or about cancelled subscription
			// if $intStatus==1 just inform us about new started subscription, we can ignore it
			
			if($intStatus==2 || $intStatus==3){
				// subscription was cancelled or termed out
				
				$OrderID = preg_replace('/[\'\"\ ]/', '', $_POST['intScheduleID']);
				$recComm = QUnit_Global::newObj('Affiliate_Scripts_Bl_RecurringCommissions');
				$recComm->cancelRecurring($OrderID); 
				
			}
			
		} else {
			// subscription payment
			
			if($intStatus=="1" && isset($_POST['fltAmount'])){
				
				DebugMsg("Metacharge callback: Start registering subscription (recurring) payment, custom field: ".$_POST['PT_custom'], __FILE__, __LINE__);
				
				
				if(!isset($_POST['PT_custom']) || $_POST['PT_custom']== '')
	            {
	                DebugMsg("Metacharge callback: custom field is empty", __FILE__, __LINE__);                
	            }
	            
	            
	            
	            $saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');;
        
	            // register sale
	            if($saleReg->findPaymentBySubscriptionID($_POST['intScheduleID']))
	            {
	                // we got affiliate id and campaign id filled by findPaymentBySubscriptionID() function
	                
	                // it is recurring call
	                $saleReg->setSaleTypeAndKind(TRANSTYPE_RECURRING, TRANSKIND_RECURRING);
	                $saleReg->registerSale($_POST['fltAmount'], $_POST['intScheduleID'], $_POST['strCartID'], true);
	            }
	            else
	            {
	                // it is first subscription call
	                if($saleReg->decodeData($_POST['PT_custom']))
	                {
	                	DebugMsg("Metacharge callback: Start registering sale, params TotalCost='".$_POST['fltAmount']."', OrderID='".$_POST['intTransID']."', ProductID='".$_POST['strCartID']."'", __FILE__, __LINE__);
            
			            $saleReg->registerSale($_POST['fltAmount'], $_POST['intScheduleID'], $_POST['strCartID'], true);
			            
			            DebugMsg("Metacharge callback: End registering sale", __FILE__, __LINE__);
	                }
	                else
	                {
	                    DebugMsg("Metacharge callback: SaleRegistrator->decodeData returned false", __FILE__, __LINE__);                
	                }
	            }
	            
	            DebugMsg("Metacharge callback: End registering subscription (recurring) payment", __FILE__, __LINE__);
		            
	            
				
				
			}
			
		}
		
	}
	else {
		// one time payment
		
		if(!isset($_POST['PT_custom']) || $_POST['PT_custom']== '')
        {
            DebugMsg("Metacharge callback: PT_custom field is empty", __FILE__, __LINE__);                
        }
        
        DebugMsg("Metacharge callback: Start registering payment, custom field: ".$_POST['PT_custom'], __FILE__, __LINE__); 
		
        $saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');;
        
        if($saleReg->decodeData($_POST['PT_custom']))
        {
            DebugMsg("Metacharge callback: Start registering sale, params TotalCost='".$_POST['fltAmount']."', OrderID='".$_POST['intTransID']."', ProductID='".$_POST['strCartID']."'", __FILE__, __LINE__);
            
            $saleReg->registerSale($_POST['fltAmount'], $_POST['intTransID'], $_POST['strCartID'], true);
            
            DebugMsg("Metacharge callback: End registering sale", __FILE__, __LINE__);
        }
        else
        {
            DebugMsg("Metacharge callback: SaleRegistrator->decodeData returned false", __FILE__, __LINE__);                
        }
        
        DebugMsg("Metacharge callback: End registering payment", __FILE__, __LINE__); 
        
	}
	
}


header("HTTP/1.1 200 OK");

?>



