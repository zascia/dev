<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Post Affiliate</title>
<link href="styles.php?md=Affiliate_Merchants_Views_LayoutSettings&showstyles=1" type="text/css" rel="stylesheet">
<SCRIPT language=JavaScript src="<?php echo $GLOBALS['WEB_INCLUDE_PATH'].$_SESSION[SESSION_PREFIX.'javascript']?>"></SCRIPT>
<script>
// function for checking or unchecking all items
var checkedAllItems = false;
</script>
</head>
<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0"  bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<?php initQuickHelp() ?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td>
  <!--Start header-->
  <?php QUnit_Global::includeTemplate('header.tpl.php'); ?>
  <!--End header-->
  </td>
</tr>
<tr height="100%">
  <td align=left valign=top height="100%">
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="leftMenu" bgcolor=ffffff height="100%">
      <!--Begin left menu-->
      <?php QUnit_Global::includeTemplate('left_menu.tpl.php'); ?>
      <!--End left menu-->
    </td>
    <td width="100%" class="contents">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <!--Begin navigation path-->
    <tr>
      <td class=topSmallNavigation width="5" colspan=2>&nbsp;</td>
      <td class=topSmallNavigation id=pam_null align="left" valign="middle"><div id="pam_navigation" style="padding:2px; height:18px;"></div></td>
    </tr>
    <!--End navigation path-->

    <!--Begin left menu-->
    <?php QUnit_Global::includeTemplate('general_aff_link.tpl.php'); ?>
    <!--End left menu-->

    <tr>
      <td class="leftMenuBorder">&nbsp;&nbsp;</td>
      <td width="5">&nbsp;&nbsp;&nbsp;</td>
      <td align="left" valign="top">
      <br>
      
      <?php if($this->a_Auth->isLogged()) { ?>  
        <!--Begin error message-->
        <?php QUnit_Global::includeTemplate('error_msg.tpl.php'); ?>
        <!--End error message-->
      <?php } ?>

      <!--Begin content--> 
      <?php echo  $this->content ?>
      <!--end content--> 
      </td>
    </tr>
    </table>
    </td>
  </tr>
  </table>
  </td>
</tr>
<tr>
  <td colspan="3">
  <!--Begin footer-->
  <?php QUnit_Global::includeTemplate('footer.tpl.php'); ?>
  <!--End footer-->
  </td>
</tr>
</table>

<?php if (!empty($GLOBALS['navigation'])) { ?>
<script>
    navigationSet("<?php echo str_replace('&nbsp;&nbsp;', '', $GLOBALS['navigation'])?>");
</script>
<?php } ?>
</body> 
</html>  
