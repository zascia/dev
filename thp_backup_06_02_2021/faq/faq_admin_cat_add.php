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

<title>FAQMasterFlexPlus: <?php echo $Cat_add_head ?></title>

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
$add = isset($_POST['add']) ? $_POST['add'] : '';
$yes = isset($_POST['yes']) ? $_POST['yes'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';

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
	<td valign="top" style="padding: 1em" class="maincontent" height="190">


	<h2><?php echo $Cat_add ?></h2>

        <?php
        
        
         if ($add) {
         
            if (!$category) {
               print $s_go_back;
            }

            else {
               $result = mysql_query("INSERT INTO faqcategories (category) VALUES ('$category')") or die(mysql_error()); 
               print "<h3>" . $cat_success . "</h3>\n";
            }

         }
        
        
         else {
            print "<form action=\"$PHP_SELF\" method=\"post\">\n";
            print "<p><strong>" . $cat_dis_name . ":</strong> <input type=\"text\" name=\"category\" class=\"textfield\" size=\"40\"></p>\n";
            print "<input type=\"hidden\" name=\"yes\" value=\"close\">\n";
            print "<input type=\"submit\" name=\"add\" value=\"" . $s_add . "\" class=\"submit\">\n";
            print "<input type=\"submit\" name=\"cancel\" value=\"" . $s_cancel . "\" class=\"submit\" onclick=\"self.close()\">\n";
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
