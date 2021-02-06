<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<?php 
$print = isset($_GET['print']) ? $_GET['print'] : false;
$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : $_GET['category_id'];
$cat_name = isset($_POST['cat_name']) ? $_POST['cat_name'] : $_GET['cat_name'];
$answer = isset($_POST['answer']) ? $_POST['answer'] : 0;


include "faq_config.php";

?>

<title><?php echo "$cat_name" ?></title>

<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<link rel="stylesheet" type="text/css" href="style.css">

<style>
a {text-decoration: none}
</style>

<script language="JavaScript">
<!--

  function submit_faq(obj_id){
   var ob_name = "quest" + obj_id;
   var obj = document.getElementById(ob_name);
   obj.submit();
   }

var howManySeconds = 1

//--This is the function that pauses, then calls your custom function.
function pause() {
   myTimer=setTimeout("whatToDo()",howManySeconds*1000)
}

//-- This is the function that's executed after the delay time is up.
function whatToDo() {
   window.print()
}
//-->
</script>

</head>

<body <?php if ($print) { print "onload=\"pause()\""; } ?>>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
	<td class="poptop" height="15"><img src="images/spacer.gif" width="3" height="3"></td>
   </tr>
   <tr>
	<td class="hrz_line"><img src="images/spacer.gif" width="1" height="1"></td>
   </tr>
   <tr>
	<td style="background: #ffffff; padding: 5px" valign="middle"><h1 style="margin-top: 0; margin-bottom: 0"><?php echo "$cat_name" ?></h1></td>
   </tr>
   <tr>
	<td class="hrz_line"><img src="images/spacer.gif" width="1" height="1"></td>
   </tr>
   <tr>
	<td valign="top" style="padding: 1em" class="maincontent" height="400">
	
	<p><?php echo $faq_instruct; ?></p>
	<p><a href="<?php echo "$PHP_SELF?print=true&cat_name=$cat_name&category_id=$category_id" ?>"><?php echo "$s_print_faq" ?></a></p>
		
		
	<table width="100%" border="0" cellpadding="8" cellspacing="0">
		
		<?php		
		
                $result = mysql_query("SELECT * FROM faqs WHERE category_id = '$category_id'") or die(mysql_error());                 
                
                
                while ($row = mysql_fetch_array($result)) {
                              
                    if (($answer == "$row[id]") || ($print == "true")) {

                       print "<tr>
		                  <td class=\"QA\" valign=\"top\">Q </td>";
		                  
            print "<form name=\"quest\" id=\"quest\" action=\"$PHP_SELF\" method=\"post\">\n";
            print "<input type=\"hidden\" name=\"category_id\" value=\"$category_id\"></p>\n";
            print "<input type=\"hidden\" name=\"cat_name\" value=\"$cat_name\">\n";
            print "<input type=\"hidden\" name=\"answer\" value=\"0\">\n";
            print "</form>\n<td><pre class=\"question\"><a href=\"javascript:submit_faq('');\">$row[question]</a></pre>";
            print "</td></tr>\n";

                        print "<tr>
		                  <td class=\"QA\" valign=\"top\">A</td>
		                  <td><pre class=\"answer\">$row[answer]</pre>
                                  <br>
                                  <a href=\"$PHP_SELF?answer=0&cat_name=$cat_name&category_id=$category_id#$answer\">" . $s_close . "</a><br></td>
                              </tr>\n";
                    }


                    else {

                     print "<tr>
                                <td class=\"QA\" valign=\"top\">Q <a name=\"$row[id]\"></td>
                                <td>";
            print "<form name=\"quest$row[id]\" id=\"quest$row[id]\" action=\"$PHP_SELF\" method=\"post\">\n";
            print "<input type=\"hidden\" name=\"category_id\" value=\"$category_id#$row[id]\"></p>\n";
            print "<input type=\"hidden\" name=\"cat_name\" value=\"$cat_name\">\n";
            print "<input type=\"hidden\" name=\"answer\" value=\"$row[id]\">\n";
            print "</form>\n
<pre class=\"question\"><a href=\"javascript:submit_faq($row[id]);\">$row[question]</a></pre></td>
                              </tr>\n";
                    }
                    
                    
               }

		
		mysql_close($link);
		
		?>
		
       </table>

	</td>
   </tr>
   <tr>
	<td class="hrz_line"><img src="images/spacer.gif" width="1" height="1"></td>
   </tr>
   <tr>
	<td height="20" class="popbot"><a href="javascript:window.close()"><?php echo "$s_close" ?></a></td>
   </tr>
</table>

</body>
</html>
