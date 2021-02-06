<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>
<?php
   switch ($this->user_type) {
       case USERTYPE_USER : echo "Affiliates"; break;
       case USERTYPE_ADMIN : echo "Merchants"; break;
       case USERTYPE_SUPERADMIN : echo "Super Admins"; break;
   }
?></title>
<link href="styles.php?md=Affiliate_Merchants_Views_LayoutSettings&showstyles=1" type="text/css" rel="stylesheet">
<SCRIPT language=JavaScript src="<?php echo $GLOBALS['WEB_INCLUDE_PATH'].$_SESSION[SESSION_PREFIX.'javascript']?>"></SCRIPT>
</head>
<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0"  bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<?php initQuickHelp() ?>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td valign=top align=center>

        <!--Begin error message-->
        <?php QUnit_Global::includeTemplate('error_msg.tpl.php'); ?>
        <!--End error message-->

        <!--Begin content-->
        <?php echo  $this->content ?>
        <!--End content-->
        <br>
      </td>
    </tr>
  </table>
</body>
</html>
