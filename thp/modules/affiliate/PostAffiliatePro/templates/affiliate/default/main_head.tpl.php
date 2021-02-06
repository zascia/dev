<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Post Affiliate</title>
<style type="text/css">
<?php echo  $this->a_this->fetchTemplate('styles-'.DEFAULT_STYLE) ?>
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

<?php initQuickHelp() ?>

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td colspan="3">
  <!--Start header-->
  <?php echo  $this->a_this->fetchTemplate('header') ?>
  <!--End header-->
  </td>
</tr>
<tr height="100%">

<?php if($this->a_Auth->isLogged()) { ?>
  <td class="leftMenu" bgcolor=ffffff height="100%">
    <table width="182" height="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="leftMenuContentBorder"></td>    
      <td class="leftMenuMain" valign="bottom">

      <!--Begin left menu-->
      <?php echo  $this->menu_left ?>
      <!--End left menu-->
      
      </td>
      <td class="leftMenuContentBorder"></td>
      <td class="leftMenuBorder"></td>
    </tr>
    </table>
  </td>
<?php } ?>
  
  <td width="5">&nbsp;&nbsp;&nbsp;</td>
  <td class="contents">
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td valign="top" align="left">
    <br>
        