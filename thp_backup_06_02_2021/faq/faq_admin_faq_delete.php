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

<title>FAQMasterFlexPlus: <?php echo $faq_del_head ?></title>

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
   opener.location='faq_admin.php?category=<?php echo "$category&cat_name=$cat_name" ?>';
}
// -->
</script>
</head>
<body <?php
$id = isset($_POST['delete']) ? $_POST['delete'] : $_GET['delete'];
$yes = isset($_POST['yes']) ? $_POST['yes'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : $_GET['category'];
$cat_name = isset($_POST['cat_name']) ? $_POST['cat_name'] : $_GET['cat_name'];
$remove = isset($_POST['remove']) ? $_POST['remove'] : '';

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
	<td valign="top" style="padding: 1em" class="maincontent" height="170">

	<h2><?php echo $faq_del ?></h2>

        <?php
        
        
         if ($remove) {
            $result = mysql_query("DELETE FROM faqs WHERE id = '$id'") or die(mysql_error()); 
            print "<h3>" . $faq_del_sucess . "</h3>\n";
         }
         else {
            print "<form action=\"$PHP_SELF\" method=\"post\">\n";
            print "<p>" . $faq_del_ques . "</p>\n";
            print "<input type=\"hidden\" name=\"delete\" value=\"$id\">\n";
            print "<input type=\"hidden\" name=\"category\" value=\"$category\">\n";
            print "<input type=\"hidden\" name=\"cat_name\" value=\"$cat_name\">\n";
            print "<input type=\"hidden\" name=\"yes\" value=\"close\">\n";
            print "<input type=\"submit\" name=\"remove\" value=\"" . $s_yes . "\" class=\"submit\">\n";
            print "<input type=\"submit\" name=\"no\" value=\"" . $s_no . "\" class=\"submit\" onclick=\"self.close()\">\n";
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
