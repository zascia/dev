<?php  
 
     if (session_id() == ""){ session_start();}
     include "faq_config.php";
     if (!isset($_SESSION['log_ok'])) {
       HEADER( "location: login.php");
     } 
      include "header.php"; 

$category = isset($_GET['category']) ? $_GET['category'] : '';
$cat_name = isset($_GET['cat_name']) ? $_GET['cat_name'] : '';
?>


		<!-- MAIN TEXT -->


		<h1><?php echo $faq_admin_head ?></h1>

		<?php
                print "<p style=\"margin-top: -1em\">" . $s_action . ": <a href=\"faq_admin_user.php\" onclick=\"NewWindow(this.href,'cat_user','320','270','no');return false\">" . $set_uid . "</a></p>";
                if ($category) {
                
                   print "<h3>$cat_name</h3>\n";
                   print "<p style=\"margin-top: -1em\"><a href=\"$PHP_SELF\">" . $faq_admin . "</a> | <a href=\"faq_admin_faq_add.php?category=$category&cat_name=$cat_name\" onclick=\"NewWindow(this.href,'FAQ_Add','430','400','no');return false\">" . $s_faq_add . " " . $cat_name . "</a></p>\n";
                   $result = mysql_query("SELECT * FROM faqs WHERE category_id = '$category'") or die(mysql_error());
                   
                   
                   print "<table width=\"100%\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\">\n";


                     while ($row = mysql_fetch_array($result)) {

                       print "<tr>
		                  <td class=\"QA\" valign=\"top\">Q</td>
		                  <td valign=\"top\"><pre class=\"question\">$row[question]</pre></td>
                              </tr>\n";

                       print "<tr>
		                  <td class=\"QA\" valign=\"top\">A</td>
		                  <td valign=\"top\"><pre class=\"answer\">$row[answer]</pre></td>
                              </tr>\n";

                       print "<tr>
		                  <td>&nbsp;</td>
		                  <td class=\"options\" valign=\"top\"><a href=\"faq_admin_faq_edit.php?edit=$row[id]&category=$category&cat_name=$cat_name\" onclick=\"NewWindow(this.href,'FAQ_Edit','430','380','no');return false\">" . $s_edit . "</a> | <a href=\"faq_admin_faq_delete.php?delete=$row[id]&category=$category&cat_name=$cat_name\" onclick=\"NewWindow(this.href,'FAQ_Delete','350','250','no');return false\">" . $s_delete . "</a></td>
                              </tr>\n";

                       print "<tr>
		                  <td colspan=\"2\">&nbsp;</td>
                              </tr>\n";
                     }
                   
                   print "</table>\n";
                
                }
                
                
                
                else {
                
                     print "<h3>" . $s_faq_cats . "</h3>\n";
                     print "<p style=\"margin-top: -1em\">" . $s_action . ": <a href=\"faq_admin_cat_add.php\" onclick=\"NewWindow(this.href,'cat_add','320','270','no');return false\">" . $faq_edit_head . "</a> | <a href=\"faq_admin_cat_edit.php\" onclick=\"NewWindow(this.href,'cat_edit','520','280','no');return false\">" . $cat_edit_head . "</a> |  <a href=\"faq_admin_cat_delete.php\" onclick=\"NewWindow(this.href,'cat_del','520','210','no');return false\">" . $cat_del_head . "</a></p>";

                     $result = mysql_query("SELECT * FROM faqcategories") or die(mysql_error()); 

                     print "<ul>\n";

                     while ($row = mysql_fetch_array($result)) {
                        print "<li class=\"category\"><strong><a href=\"$PHP_SELF?category=$row[id]&cat_name=$row[category]\">$row[category]</a></strong></li>\n";
                     }

                     print "</ul>\n";
                }


		mysql_close($link);
		
		?>


		<!-- END MAIN TEXT -->

		

<?php include "footer.php" ?>
