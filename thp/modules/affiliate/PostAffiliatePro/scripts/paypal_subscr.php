<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//
// script for handling PayPal subscriptions payments
//============================================================================

$data = explode('_', $_POST['custom'], 3);
$_REQUEST['lid'] = $data[2];

// include files
require_once('global.php');

if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_PRO || $GLOBALS['Auth']->getProgramType() == PROG_TYPE_ECOMMAGNET) {
    $GLOBALS['Auth']->setAccountID(DEFAULT_ACCOUNT);
} else {
    if($GLOBALS['Auth']->getAccountID() == '') {
        QCore_History::log(WLOG_ERROR, "PayPal: Cannot recognize account from domain '".getHostName()."'", __FILE__, __LINE__);
        return;
    }
}

$debugSales = ($GLOBALS['Auth']->getSettingForScripts('Aff_debug_sales') == 1 ? true : false);
QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: started", __FILE__, __LINE__);

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) 
{
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: post back to PayPal", __FILE__, __LINE__);

if (!$fp) 
{
    // HTTP ERROR
    QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: HTTP error, cannot post back. Error number: $errno, Error msg: $errstr", __FILE__, __LINE__);
} 
else 
{
    fputs ($fp, $header.$req);  
    $res = '';
    
    while (!feof($fp)) {
    	
        $res .= fgets ($fp, 1024);
    }
    
    fclose ($fp);

    // assign posted variables to local variables
    $item_name = $_POST['item_name'];
    $custom = $data[0]."_".$data[1];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $txn_type = $_POST['txn_type'];
    $subscr_id = $_POST['subscr_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];

    QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: response = $res", __FILE__, __LINE__);

    if (strpos($res, "VERIFIED") !== false) 
    {
       QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: returned VERIFIED", __FILE__, __LINE__);
        
        $postvars = '';
        foreach($_POST as $k=>$v)
            $postvars .= "$k=$v;";
            
        QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: POST variables: $postvars", __FILE__, __LINE__);

        $saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');;
        $saleReg->setAccountID($GLOBALS['Auth']->getAccountID());

        if(strpos($txn_type, 'subscr') === false)
        {
            if($payment_status == "Completed")
            {
                // it is normal payment
                QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: Start registering payment, custom field: $custom", __FILE__, __LINE__);

                // register sale
                if($saleReg->decodeData($custom))
                {
                    QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: Start registering sale, params TotalCost='".$payment_amount."', OrderID='".$txn_id."', ProductID='".$item_number."'", __FILE__, __LINE__);

                    $saleReg->registerSale($payment_amount, $txn_id, $item_number, true);

                    QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: End registering sale", __FILE__, __LINE__);
                }
                else
                {
                    QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: SaleRegistrator->decodeData returned false", __FILE__, __LINE__);
                }
                QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: End registering payment", __FILE__, __LINE__);
            }
            else
            {
                QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: payment status is not COMPLETED. Transaction: $txn_id, payer email: $payer_email", __FILE__, __LINE__);
            }
        }
        else if($txn_type == 'subscr_payment')
        {
            if($payment_status == "Completed")
            {
	            // it is subscription (recurring) payment
	            QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: Start registering subscription (recurring) payment, custom field: $custom", __FILE__, __LINE__);
	
	            // register sale
	            if($saleReg->findPaymentBySubscriptionID($subscr_id))
	            {
	                // we got affiliate id and campaign id filled by findPaymentBySubscriptionID() function
	
	                // it is recurring call
	                $saleReg->setSaleTypeAndKind(TRANSTYPE_RECURRING, TRANSKIND_RECURRING);
	                $saleReg->registerSale($payment_amount, $subscr_id, $item_number, true);
	            }
	            else
	            {
	                // it is first subscription call
	                if($saleReg->decodeData($custom))
	                {
	                    QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: Start registering sale, params TotalCost='".$payment_amount."', OrderID='".$txn_id."', ProductID='".$item_number."'", __FILE__, __LINE__);
	
	                    $saleReg->registerSale($payment_amount, $subscr_id, $item_number, true);
	
	                    QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: End registering sale", __FILE__, __LINE__);
	                }
	                else
	                {
	                   QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: SaleRegistrator->decodeData returned false", __FILE__, __LINE__);
	                }
	            }
	
	            QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: End registering subscription (recurring) payment", __FILE__, __LINE__);
            }
            else
            {
                QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: payment status is not COMPLETED. Transaction: $txn_id, payer email: $payer_email", __FILE__, __LINE__);
            }
        }
    }
    else if (strpos($res, "INVALID") !== false) 
    {
        // log for manual investigation
        QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: returned INVALID. Transaction: $txn_id, payer email: $payer_email", __FILE__, __LINE__);
    } else {
	 // unknown response 
        QCore_History::logWithCondition($debugSales, WLOG_DEBUG, "PayPal callback: unknown response $res", __FILE__, __LINE__);

    }
}
?>
