<html>
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
<title>PAP Installation</title> 
<style type="text/css">
<?php echo  $this->a_this->fetchTemplate('styles-custom') ?>
</style>
<SCRIPT language=JavaScript src="<?php echo $GLOBALS['WEB_INCLUDE_PATH'].$_SESSION[SESSION_PREFIX.'javascript']?>"></SCRIPT>
<script>
// function for checking or unchecking all items
var checkedAllItems = false;

// preload images
//...
</script>
</head>

<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0"  bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<table class=tableresult width="780" height="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
  <td align=left>
  <!--Start header-->
  <?php echo  $this->a_this->fetchTemplate('header') ?>
  <!--End header-->
  </td>
</tr>
<tr height="100%">
  <td class="contents">
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td valign="top" align="center" height="1%">
    <br>
    
      <!--Begin error message-->
      <?php echo  $this->a_this->fetchTemplate('error_msg') ?>
      <!--End error message-->
    </td>
  </tr>
  <tr>
    <td valign="top" align="left">
      <!--Begin content--> 
      <?php echo  $this->content ?>
      <!--end content--> 
    </td>
  </tr>
  </table>
  </td>
</tr>

<tr>
  <td>
  <!--Begin footer-->
  <?php echo  $this->a_this->fetchTemplate('footer') ?>  
  <!--End footer-->
  </td>
</tr>
</table>

</body> 
</html>  
