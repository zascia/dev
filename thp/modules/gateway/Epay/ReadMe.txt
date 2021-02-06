******************************************************************
*                           MOD INFO
****************************************************************
* Target     : CubeCart version 3.0.x
*              --------------------------------------------------
*
* File info  : DIBS payment gateway
*              (c) Milos Homola aka convict 2006
*
* Author     : Milos Homola aka conVict
* Contact    : info@convict.sk
* Downloaded from : http://www.cc3.biz
* Last update: Feb 24 2006
* Estimated time: 1-2 Minutes
*
* Special notes: Always backup your files!
* Author takes no responsibility for any damages (real or imagined)
* that occur as a result of using these modifications.
*
* Do not distribute this code in any manner without written approval
* by author! It is illegal to re-distribute this code freely or to 
* resale the code without permission.
****************************************************************/

NEW FILES:
admin/modules/gateway/Dibs/index.php
admin/modules/gateway/Dibs/logo.gif
modules/gateway/Dibs/call_back.php
modules/gateway/Dibs/transfer.inc.php

FILES TO EDIT:
includes/content/confirmed.inc.php

*******************************
BEGIN INSTALLATION INSTRUCTIONS
*******************************

############################
STEP 1 UPLOAD NEW FILES
############################

Please UPLOAD ALL files with folder structure from package (folder admin 
and modules) to your CubeCart root folder. The store root folder is the one 
that contains files named admin, classes, docs, extra, images, includes, js,
language, modules, pear and skins.

Simply COPY the admin file and the module file from this package to your
store's root. This will not overwrite files at the store, it will add new files.

If you receive an overwrite warning during upload, accept the warnings. You may need
to check "Yes to All"

############################
STEP 2 EDIT EXISTING FILE
############################

OPEN includes/content/confirmed.inc.php


FIND ABOUT line 59
------------------

} elseif(!isset($basket['gateway'])){


ADD BEFORE
----------

// DIBS CALLBACK FIX by convict -->
} elseif(isset($_POST['cb_dibs'])) {
 $basket['gateway'] = "Dibs";
// <--


#############################
save, close, upload your file includes/content/confirmed.inc.php
#############################

Notice:

The final code about modified one looks like this (CubeCart v3.0.10)

if(isset($_GET['pg']) && !empty($_GET['pg'])){
	
	$pg = base64_decode($_GET['pg']);
	
	if(ereg("Authorize|WorldPay|Protx|SECPay|BluePay",$pg)){
		$basket['gateway'] = $pg;
	}

############################################################################################
// Following lines added for Sir William's PayPal AutoReturn Fix
} elseif(isset($_GET['tx']) && isset($_GET['st'])) {
 $basket['gateway'] = "PayPal";
############################################################################################
// DIBS CALLBACK FIX by convict -->
} elseif(isset($_POST['cb_dibs'])) {
 $basket['gateway'] = "Dibs";
// <--
} elseif(!isset($basket['gateway'])){
	echo "Error: No payment gateway variable is set!";
	exit;
}



#############################
STEP 3 CONFIGURE & ACTIVATE MOD
#############################

Run CC Admin Control Panel->Modules->Gateways->Dibs configure

Set your values and activate gateway module.


#############################
#  END
############################

*** CUSTOMER SERVICE ***

Please sign-in to your account and open a HelpDesk ticket at CC3.biz for service issues and bug reports.
Thank you for purchasing this product!
