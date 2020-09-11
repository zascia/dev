<?php
// Do not access the frontpage directly
//if( substr($_SERVER['REQUEST_URI'], -4) == ".php") { header("Location: /404.php"); exit; }


// If the users wants to send and email and contact SMARTLainat
if( array_key_exists('action', $_POST) && $_POST['action'] == 'sendMail')
{

	// Only allow ajax requests
    if( !isset($_SERVER["HTTP_REFERER"]) || !isset($_SERVER["HTTP_X_REQUESTED_WITH"]) || strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) != "xmlhttprequest" ) {

		///exit("N - not allowed");
		/*print_r($_REQUEST);
		exit();*/

	}

	$msg = !empty($_POST['msg']) ? trim(strip_tags($_POST['msg'])) : null;
	$name = !empty($_POST['name']) ? trim(strip_tags($_POST['name'])) : null;
	$from = !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : null;

	$headers = "From: " . strip_tags($from) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	if( !empty($msg) && !empty($from) ) {

        $send = mail("s.rezni4encko@gmail.com", "Вопрос по ремонтам", $name ."<br>". $msg, $headers);
        //$send = mail("zascia@ukr.net", "Вопрос с сайта ремонтов", $name ."<br>". $msg, $headers);
		if( $send ) {

			exit("Y");

		} else {

			exit("N");

		}

	} else {
        echo '<pre>';
        print_r($_POST['email']);
        echo '</pre>';
		exit("empty value");

	}


}
echo 'nothing exists';
echo '<pre>';
        print_r($_POST['email']);
        echo '</pre>';
?>