<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Post Affiliate</title>
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
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td colspan="2">
  <!--Start header-->
  <?php echo  $this->a_this->fetchTemplate('header_notlogged') ?>
  <!--End header-->
  </td>
</tr>
<tr>
  <td align="center">
      <br>
      <!--Begin error message-->
      <?php echo  $this->a_this->fetchTemplate('error_msg') ?>
      <!--End error message-->
  </td>
</tr>
<tr height="100%">
  <td class="contents">
      <!--Begin content--> 
      <?php echo  $this->content ?>
      <!--end content--> 
      <br>
  </td>
</tr>

<tr>
  <td colspan="2">
  <!--Begin footer-->
  <?php echo  $this->a_this->fetchTemplate('footer') ?>  
  <!--End footer-->
  </td>
</tr>
</table>

</body> 
</html>  
