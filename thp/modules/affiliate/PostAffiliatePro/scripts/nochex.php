<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('global.php');

DebugMsg("Nochex callback: started", __FILE__, __LINE__);

$t = 0;

foreach ($_POST as $key => $value) 
{
    $value = urlencode(stripslashes($value));
    if($t!=0) {$req .= "&$key=$value";}
    else {$req = "$key=$value";}
    
    $t++;
}

// post back to Nochex system to validate
$header .= "POST /nochex.dll/apc/apc HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.nochex.com', 443, $errno, $errstr, 30);

DebugMsg("Nochex callback: post back to Nochex", __FILE__, __LINE__);

if (!$fp) 
{
    // HTTP ERROR
    LogError("Nochex callback: HTTP error, cannot post back. Error number: $errno, Error msg: $errstr", __FILE__, __LINE__);
} 
else 
{
    fputs ($fp, $header.$req);
    while (!feof($fp)) 
    {
        // assign posted variables to local variables
        $from_email = $_POST['From_email'];
        $order_id = $_POST['order_id'];
        $array = explode("-",$order_id);
        $custom = $array[0];
        $item_number = $array[1];
        $payment_status = $_POST['status'];
        $payment_amount = $_POST['amount'];
        $txn_id = $_POST['transaction_id'];
        
            
        $res = fgets ($fp, 1024);
        if (strcmp ($res, "AUTHORISED") == 0) 
        {
            DebugMsg("Nochex callback: returned AUTHORISED", __FILE__, __LINE__);

            $postvars = '';
            foreach($_POST as $k=>$v)
                $postvars .= "$k=$v;";
            DebugMsg("Nochex callback: POST variables: $postvars", __FILE__, __LINE__);
                
            if($custom == '')
            {
                DebugMsg("Nochex callback: custom field is empty", __FILE__, __LINE__);                
            }
            
            
            DebugMsg("Nochex callback: Start registering sale, custom field: $custom", __FILE__, __LINE__);
            
            $saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');
            
            // register sale
            if($saleReg->decodeData($custom))
            {
                DebugMsg("Nochex callback: Start registering sale, params TotalCost='".$payment_amount."', OrderID='".$txn_id."', ProductID='".$item_number."'", __FILE__, __LINE__);
                
                $saleReg->registerSale($payment_amount, $txn_id, $item_number, true);
                
                DebugMsg("Nochex callback: End registering sale", __FILE__, __LINE__);
            }
            else
            {
                DebugMsg("Nochex callback: SaleRegistrator->decodeData returned false", __FILE__, __LINE__);                
            }
            
            DebugMsg("Nochex callback: End registering sale", __FILE__, __LINE__);
        
        }
        else if (strcmp ($res, "DECLINED") == 0) 
        {
            // log for manual investigation
            LogError("Nochex callback: returned DECLINED. Transaction: $txn_id, payer email: $from_email", __FILE__, __LINE__);
        }
    }
    
    fclose ($fp);
}
?>



