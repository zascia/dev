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

<title>FAQMasterFlexPlus: <?php echo $cat_del_head ?></title>

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
$remove = isset($_POST['remove']) ? $_POST['remove'] : '';
$select = isset($_POST['select']) ? $_POST['select'] : '';
$yes = isset($_POST['yes']) ? $_POST['yes'] : '';
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
	<td valign="top" style="padding: 1em" class="maincontent" height="135">

	<h2>Category Delete</h2>

        <?php
        
        
         if ($remove) {
            $result = mysql_query("DELETE FROM faqcategories WHERE id = '$id'") or die(mysql_error());
            $result2 = mysql_query("DELETE FROM faqs WHERE category_id = '$id'") or die(mysql_error());
            print "<h3><?php echo $cat_del_sucess ?></h3>\n";
         }
         elseif ($select) {
            $result = mysql_query("SELECT * FROM faqcategories WHERE id = '$id'") or die(mysql_error());
            $row = mysql_fetch_array($result);
            
            print "<form action=\"$PHP_SELF\" method=\"post\">\n";
            print "<p><strong>" . $cat_del_ques . " " . $row[1] . "?</strong></p><p>" . $cat_del_ques2 . "</p>\n";
            print "<input type=\"hidden\" name=\"id\" value=\"$row[id]\">\n";
            print "<input type=\"hidden\" name=\"yes\" value=\"close\">\n";
            print "<input type=\"submit\" name=\"remove\" value=\"" . $s_delete . "\" class=\"submit\">\n";
            print "<input type=\"submit\" name=\"cancel\" value=\"" . $s_cancel . "\" class=\"submit\" onclick=\"self.close()\">\n";
            print "</form>\n";
         }
         else {
            $result = mysql_query("SELECT * FROM faqcategories ORDER BY category") or die(mysql_error()); 

            print "<form action=\"$PHP_SELF\" method=\"post\">\n";
            print "<p><nobr><strong>Category:</strong>\n";
            print "<select class=\"drop2\" name=\"id\">\n";

            while ($row = mysql_fetch_array($result)) {
               print "<option value=\"$row[id]\">$row[category]</option>\n";
            }

            print "</select>\n";
            print "<input type=\"submit\" name=\"select\" value=\"" .$s_delete . "\" class=\"submit\">\n";
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
