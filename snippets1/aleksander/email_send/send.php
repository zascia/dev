<?php
// sent data
$name = trim(strip_tags($_POST['name']));
$email = trim(strip_tags($_POST['email']));
$message = htmlentities($_POST['message']);

// set your email address here
$subject = "Email from my contact form";
$to = 'alek3@vavok.net';
//$to = 'youremail@address.com';

$headers = "From: $email\r\n";
$headers .= "Content-type: text/html\r\n";

// send the email
mail($to, $subject, $message, $headers);

// show message
echo 'Email has been sent!';
?>