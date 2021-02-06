<?php  

session_start();
include "header.php";
include "faq_config.php";

$AUTH_USER = isset($_POST['userid']) ? $_POST['userid'] : '';
$AUTH_PW = isset($_POST['pwd']) ? $_POST['pwd'] : ''; 

$username = 'temp';
$password = 'temp';

if ($AUTH_USER != '') {

$result = mysql_query("SELECT * FROM `users` WHERE `userid` = '$AUTH_USER'") or die(mysql_error());
$row = mysql_fetch_array($result);

$username = $row[0];
$password = $row[1];
}

if (($AUTH_USER != "$username") || ($AUTH_PW != "$password")) {

?>
<h1> Admin Login</h1>

<form action="<?php echo $PHP_SELF ?>" method="post">
<table width="100%" align="center">
 <tr><td align="right"><b>Name:</b></td><td><input name="userid" size=35></td></tr>
 <tr><td align="right"><b>Password:</b></td><td><input name="pwd" size=35></td></tr>
 <tr><td colspan=2><input type="submit" name="submit" value="Submit"></td></tr>
</table>
</form>


<?php
}else{

print "<b>Login Successful!<b>";

$_SESSION['log_ok'] = "yes";

$var1 = "http://" . $_SERVER['SERVER_NAME'] . substr($PHP_SELF, 0, strlen($PHP_SELF)-9 ) . "faq_admin.php";

echo '<META http-equiv="refresh" content="3; URL=' . $var1 . '">';

}


//echo "http://" . $_SERVER['SERVER_NAME'] . substr($PHP_SELF, 0, strlen($PHP_SELF)-9 );
include "footer.php";
?>