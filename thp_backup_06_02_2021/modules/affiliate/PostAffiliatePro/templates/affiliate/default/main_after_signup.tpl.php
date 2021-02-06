<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php echo L_G_AFFSIGNUPFORM?></title>
<link href="styles.php?md=Affiliate_Merchants_Views_LayoutSettings&showstyles=1" type="text/css" rel="stylesheet">
<SCRIPT language=JavaScript src="<?php echo $GLOBALS['WEB_INCLUDE_PATH'].$_SESSION[SESSION_PREFIX.'javascript']?>"></SCRIPT>
<script>
// function for checking or unchecking all items
var checkedAllItems = false;

// preload images
//...
</script>
</head>

<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0"  bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<div align="center">
<table height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td colspan="2" align="left">
      <?php $GLOBALS['Auth']->loadSettings(); ?>
      <img src="<?php echo ($logo=$GLOBALS['Auth']->getSetting('Aff_style_logo_url')) != '' ? $logo : $this->a_this->getImage('web_logo.gif') ?>" class="logo333" border="0">
  </td>
</tr>
<tr height="100%">
  <td class="contents" align="left">
      <!--Begin error message-->
      <?php echo  $this->a_this->fetchTemplate('error_msg') ?>
      <!--End error message-->
      <!--Begin content-->
            <center>
            <br>
            Thank you for joining.
            </center>
      <!--end content-->
      <br>
  </td>
</tr>

</table>
</div>
</body> 
</html>  
