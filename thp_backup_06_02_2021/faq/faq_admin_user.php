<?php  

     if (session_id() == ""){ session_start();}
     if (!isset($_SESSION['log_ok'])) {
       HEADER( "location: login.php");
     } 
        include "faq_config.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>

<title>FAQMasterFlexPlus: <?php echo $user_edit_head ?></title>

<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<link rel="stylesheet" type="text/css" href="style.css">

<script>
<!--
function wait(delay){
   string="pauseforalert("+delay+");";
   setTimeout(string,delay);
}

function pauseforalert(delay){
   this.window.close();
   opener.location='faq_admin.php';
}
// -->
</script>

</head>
<body <?php
$update = isset($_POST['update']) ? $_POST['update'] : '';
$select = isset($_POST['select']) ? $_POST['select'] : '';
$edit = isset($_POST['edit']) ? $_POST['edit'] : '';
$yes = isset($_POST['yes']) ? $_POST['yes'] : '';
$passwrd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
$uid = isset($_POST['uid']) ? $_POST['uid'] : '';

if ($yes) {
   print "onload=\"wait(2000);\"";
}

?>>


<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
	<td class="poptop" height="15"><img src="images/spacer.gif" width="3" height="3"></td>
   </tr>
   <tr>
	<td class="hrz_line"><img src="images/spacer.gif" width="1" height="1"></td>
   </tr>
   <tr>
	<td style="background: #ffffff; padding: 5px" valign="middle"><h1 style="margin-top: 0; margin-bottom: 0">FAQMasterFlex</h1></td>
   </tr>
   <tr>
	<td class="hrz_line"><img src="images/spacer.gif" width="1" height="1"></td>
   </tr>
   <tr>
	<td valign="top" style="padding: 1em" class="maincontent" height="200">
	

	<h2><?php echo $user_edit_head ?></h2>

        <?php
        
       
         if ($update) {
            $result = mysql_query("UPDATE `users` SET `userid` = '$uid', `passwrd` = '$passwrd' WHERE `userid` = '$uid'") or die(mysql_error());
            print "<h3>" . $user_edit_success . "</h3>\n";
         }
         elseif ($select) {
            $result = mysql_query("SELECT * FROM users WHERE userid = '$edit'") or die(mysql_error());
            $row = mysql_fetch_array($result);

            print "<form action=\"$PHP_SELF\" method=\"post\">\n";
            print "<input name=\"uid\" value=\"$row[userid]\">\n";
            print "<input name=\"pwd\" value=\"$row[passwrd]\">\n";
            print "<input type=\"hidden\" name=\"yes\" value=\"close\">\n";
            print "<input type=\"submit\" name=\"update\" value=\"" . $s_update . "\" class=\"submit\">\n";
            print "<input type=\"submit\" name=\"cancel\" value=\"" . $s_cancel . "\" class=\"submit\" onclick=\"self.close()\">\n";
            print "</form>\n";
         }
         else {
            $result = mysql_query("SELECT * FROM users ORDER BY userid") or die(mysql_error()); 
            print "<form action=\"$PHP_SELF\" method=\"post\">\n";
            print "<p><nobr><strong>User:</strong>\n";
            print "<select class=\"drop2\" name=\"edit\">\n";

            while ($row = mysql_fetch_array($result)) {
               print "<option value=\"$row[userid]\">$row[userid]</option>\n";
            }
            
            print "</select>\n";
            print "<input type=\"submit\" name=\"select\" value=\"" . $s_edit . "\" class=\"submit\">\n";
            print "<input type=\"submit\" name=\"cancel\" value=\"" . $s_cancel . "\" class=\"submit\" onclick=\"self.close()\">\n";
            print "</nobr></p>\n";
            print "</form>\n";
         }
         
         mysql_close($link);
        

        ?>

	</td>
   </tr>
   <tr>
	<td class="hrz_line"><img src="images/spacer.gif" width="1" height="1"></td>
   </tr>
   <tr>
	<td height="20" class="popbot"><a href="javascript:window.close()"><?php echo $s_close ?></a></td>
   </tr>
</table>

</body>
</html>
