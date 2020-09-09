<?php
// Do not access the frontpage directly
//if( substr($_SERVER['REQUEST_URI'], -4) == ".php") { header("Location: /404.php"); exit; }


// If the users wants to send and email and contact SMARTLainat
if( array_key_exists('action', $_REQUEST) && $_REQUEST['action'] == 'sendMail')
{

	// Only allow ajax requests
    if( !isset($_SERVER["HTTP_REFERER"]) || !isset($_SERVER["HTTP_X_REQUESTED_WITH"]) || strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) != "xmlhttprequest" ) {

		///exit("N - not allowed");
		/*print_r($_REQUEST);
		exit();*/

	}

	$msg = !empty($_REQUEST['msg']) ? trim(strip_tags($_REQUEST['msg'])) : null;
	$name = !empty($_REQUEST['name']) ? trim(strip_tags($_REQUEST['name'])) : null;
	$from = !empty($_REQUEST['email']) && filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL) ? filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL) : null;

	$headers = "From: " . strip_tags($from) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	if( !empty($msg) && !empty($from) ) {

        //$send = mail("s.rezni4encko@gmail.com", "Вопрос с сайта ремонтов", $name ."<br>". $msg, $headers);
        $send = mail("zascia@ukr.net", "Вопрос с сайта ремонтов", $name ."<br>". $msg, $headers);
		if( $send ) {

			exit("Y");

		} else {

			exit("N");

		}

	} else {

		exit("empty value");

	}


}
?>