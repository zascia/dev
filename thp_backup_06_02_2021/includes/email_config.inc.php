<?php  
 


if (isset($config['smtpHost']) && $config['smtpHost'] != "") {
	$mail->Host = $config['smtpHost'];
} else {
	$mail->Host = "localhost";
}

if ($config['mailMethod'] == "smtp") {
	$mail->IsSMTP();
	if ($config['smtpAuth'] == "TRUE") {
		$mail->SMTPAuth = TRUE;
		$mail->Username = $config['smtpUsername'];
		$mail->Password = $config['smtpPassword'];
	}
} else {
	$mail->IsMail();
}

$mail->IsHTML(true);

?>