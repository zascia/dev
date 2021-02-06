<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

//require_once 'Services/PayPal.php';
//require_once 'Services/PayPal/Profile/API.php';
//require_once 'Services/PayPal/Profile/Handler.php';
//require_once 'lib/functions.inc.php';

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');

class Affiliate_Merchants_Views_TabPayoutMethods extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------
	
    function process($data)
    {
        $parts = explode(';', $data['min_payout_options']);
        $count = 0;
        $isOneOf = false;
        foreach($parts as $part)
        {
            $part = trim($part);
            if(is_numeric($part) && $part>0)
                $count++;
            
            if($data['initial_min_payout'] != '')
                if($data['initial_min_payout'] == $part)
                    $isOneOf = true;
        }
        
        checkCorrectness($_POST['min_payout_options'], $data['min_payout_options'], L_G_MINPAYOUTOPTIONS, CHECK_ALLOWED);
        checkCorrectness($_POST['initial_min_payout'], $data['initial_min_payout'], L_G_INITIALMINPAYOUT, CHECK_ALLOWED);
        checkCorrectness($_POST['pp_username'], $data['pp_username'], L_G_PAYPALUSERNAME, CHECK_ALLOWED);
        checkCorrectness($_POST['pp_password'], $data['pp_password'], L_G_PAYPALPASSWORD, CHECK_ALLOWED);
        checkCorrectness($_POST['pp_password'], $data['pp_password'], L_G_PAYPALPASSWORD, CHECK_ALLOWED);
        checkCorrectness($_POST['pp_currency'], $data['pp_currency'], L_G_PAYPALCURRENCY1, CHECK_ALLOWED);
        checkCorrectness($_POST['pp_emailsubject'], $data['pp_emailsubject'], L_G_PAYPALEMAILSUBJECT, CHECK_ALLOWED);
        //checkCorrectness($_POST['pp_dayofpay'], $data['pp_dayofpay'], L_G_DAYOFPAYMENT, CHECK_NUMBER);
        
        if ($data['pp_periodicity'] == PERIODICITY_WEEKLY) {
            $data['pp_dayofpay'] = $data['pp_weekdayofpay'];
        } else {
            $data['pp_dayofpay'] = $data['pp_monthdayofpay1'].';'.
                                   $data['pp_monthdayofpay2'].';'.
                                   $data['pp_monthdayofpay3'].';'.
                                   $data['pp_monthdayofpay4'];
        }

        if($data['initial_min_payout'] != '' && !$isOneOf)
            QUnit_Messager::setErrorMessage(L_G_INITIALPAYOUTMUSTBEFROMTHELIST);
        
        // import certificate
        $params = array('username'       => $data['pp_username'],
                        'password'       => $data['pp_password'],
                        'cert_save_path' => $GLOBALS['PROJECT_ROOT_PATH']."/exports/",
                        'cert_file'      => 'cert_'.$GLOBALS['Auth']->getAccountID().'.cert');
        
        if ($this->processCertificate($params) === true) {
            $this->createAPIProfile($params);
        }
            
        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_apply_from_banner' => $data['apply_from_banner'],
                            'Aff_min_payout_options' => $data['min_payout_options'],
                            'Aff_initial_min_payout' => $data['initial_min_payout'],
                            'Aff_pp_username' => $data['pp_username'],
                            'Aff_pp_password' => $data['pp_password'],
                            'Aff_pp_periodicity' => $data['pp_periodicity'],
                            'Aff_pp_dayofpay' => $data['pp_dayofpay'],
                            'Aff_pp_currency' => $data['pp_currency'],
                            'Aff_pp_emailsubject' => $data['pp_emailsubject'],
                            );
        }

        return false;
    }
    
    //------------------------------------------------------------------------
    
	function demoProcess($data)
	{
		return array();
	}
	
	//------------------------------------------------------------------------
	
	function show($parent)
	{
		$parent->loadPayoutMethods();
		if ($_POST['pp_periodicity'] == PERIODICITY_WEEKLY) {
		    $_POST['pp_weekdayofpay'] == $_POST['pp_dayofpay'];
		} else {
		    $tmp = explode(";", $_POST['pp_dayofpay']);
		    for ($i = 1; $i <= 4; $i++) {
		        $_POST['pp_monthdayofpay'.$i] = ($tmp[$i-1] == '') ? 0 : $tmp[$i-1];
		    }
		}
		return $parent->temporaryFetch($this->template);
	}
	
	//------------------------------------------------------------------------
	
	function processCertificate($params) {
	    $dir = $params['cert_save_path'];
        $file = $params['cert_file'];
        $uploadfile = $dir.$file;
        
	    if(is_uploaded_file($_FILES['pp_certificate']['tmp_name'])) {
	        $oUpload = QUnit_Global::newObj('QUnit_Net_FileUpload',  $dir, $_FILES['pp_certificate'], $file);

            $oUpload->setAllowedTypes($GLOBALS['UPLOAD_ALLOWED_FILE_TYPES']);

            if($oUpload->handleUpload() === false) {
                return false;
            }
            
            QUnit_Messager::setOkMessage(L_G_FILESUCCESSFULLYUPLOADED.": ".$_FILES['pp_certificate']['name']);

	        return true;
        }
        
        return false;
	}
	
	//------------------------------------------------------------------------
	
	function createAPIProfile($params) {
	    $error = '';
	    $cert_save_path = $params['cert_save_path'];
	    $cert_file = $params['cert_file'];

	    $handlerinst =& _getHandlerInstance('File', array('path' => $cert_save_path));

	    if(!Services_PayPal::isError($handlerinst))
	    {
	        $pid = ProfileHandler::generateID();

	        $profile = new APIProfile($pid, $handlerinst);

	        $profile->setAPIUsername($params['username']);
            $profile->setSubject($params['subject']);
            $profile->setEnvironment('live');

	        $profile->setCertificateFile($cert_save_path.$cert_file);

	        $result = $profile->save();

	        if(Services_PayPal::isError($result)) {
	            $error = L_G_COULDNOTCREATEPAYPALPROFILE.": ".$result->getMessage();
	        } else {
	            @unlink($cert_save_path.'cert_'.$GLOBALS['Auth']->getAccountID().'.ppd');
	            @rename($cert_save_path.$result.'.ppd', $cert_save_path.'cert_'.$GLOBALS['Auth']->getAccountID().'.ppd');
	            @unlink($cert_save_path.$result.'.ppd');
	        }
	    }
	    else
	    {
	        $error = L_G_COULDNOTCREATEPAYPALPROFILEHANDLER.": ".$handlerinst->getMessage();
	    }
	    
	    if ($error != '') {
	        QUnit_Messager::setErrorMessage($error);
	    } else {
	        QUnit_Messager::setOkMessage(L_G_PAYPALPROFILECREATED);
	    }
	}
	
}

?>