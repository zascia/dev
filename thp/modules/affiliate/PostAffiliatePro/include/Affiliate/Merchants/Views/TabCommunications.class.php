<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabCommunications extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------

    function process($data)
    {
        checkCorrectness($_POST['system_email_name'], $data['system_email_name'], L_G_SYSTEMEMAILNAME, CHECK_ALLOWED);
        checkCorrectness($_POST['system_email'], $data['system_email'], L_G_SYSTEMEMAIL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['mail_send_type'], $data['mail_send_type'], L_G_MAIL_SEND_TYPE, CHECK_EMPTYALLOWED | CHECK_NUMERIC);
        checkCorrectness($_POST['mail_type'], $data['mail_type'], L_G_MAIL_TYPE, CHECK_EMPTYALLOWED | CHECK_NUMERIC);

        if($data['mail_send_type'] == EMAILBY_SMTP) {
            checkCorrectness($_POST['smtp_server'], $data['smtp_server'], L_G_SERVER, CHECK_EMPTY);
        }

        checkCorrectness($_POST['smtp_server'], $data['smtp_server'], L_G_SERVER, CHECK_ALLOWED);
        checkCorrectness($_POST['smtp_server_port'], $data['smtp_server_port'], L_G_SMTPSERVER_PORT, CHECK_ALLOWED);
        checkCorrectness($_POST['smtp_server_tls'], $data['smtp_server_tls'], L_G_SMTPSERVER_TLS, CHECK_ALLOWED);
        
        checkCorrectness($_POST['smtp_username'], $data['smtp_username'], L_G_USER_NAME, CHECK_ALLOWED);
        checkCorrectness($_POST['smtp_password'], $data['smtp_password'], L_G_PASSWORD, CHECK_ALLOWED);

        checkCorrectness($_POST['mail_charset'], $data['mail_charset'], L_G_CHARSET, CHECK_EMPTY);
        if($data['mail_charset'] == 'other') {
        	checkCorrectness($_POST['mail_charset_other'], $data['mail_charset_other'], L_G_OTHER, CHECK_EMPTY);
        	$data['mail_charset'] = $data['mail_charset_other'];
        }

        if(QUnit_Messager::getErrorMessage() == '')
        {
            $ret =  array(
                         'Aff_system_email_name' => $data['system_email_name'],
                         'Aff_system_email' => $data['system_email'],
                         'Aff_mail_send_type' => $data['mail_send_type'],
                         'Aff_mail_type' => $data['mail_type'],
                         'Aff_mail_charset' => $data['mail_charset'],
                         'Aff_mail_charset_other' => $data['mail_charset_other'],
                         'Aff_smtp_server' => $data['smtp_server'],
                         'Aff_smtp_server_port' => $data['smtp_server_port'],
                         'Aff_smtp_server_tls' => $data['smtp_server_tls'],
                         'Aff_smtp_username' => $data['smtp_username'],
                         'Aff_mail_encode_subject' => $data['mail_encode_subject']
                        );
            if (strlen(str_replace('_', '', $data['smtp_password'])) > 0) {
                $ret['Aff_smtp_password'] = $data['smtp_password'];
            }
            return $ret; 
        }

        return false;
    }

    //------------------------------------------------------------------------

    function show($parent)
	{
		$charsets = array();
		$charsets[] = 'UTF-8';
		$charsets[] = 'UTF-16';
		for ($i=1; $i<10; $i++) {
			$charsets[] = 'iso-8859-'.$i;
		}
		$charsets[] = 'windows-1250';
		$charsets[] = 'windows-1251';
		$charsets[] = 'windows-1252';
		
		if (!$_REQUEST['test_msg']) {
		    $smtp_password = $_POST['smtp_password'];
		    $_POST['smtp_password'] = '';
		    for ($i=0; $i<strlen($smtp_password); $i++) {
		        $_POST['smtp_password'] .= '_';
		    }
		}

		$parent->temporaryAssign('a_charsets', $charsets);

		return parent::show($parent);
	}

    //------------------------------------------------------------------------

	function demoProcess($data)
	{
		return array();
	}
}

?>