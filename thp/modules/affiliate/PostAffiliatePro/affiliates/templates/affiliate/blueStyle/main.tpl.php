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
<?php initQuickHelp() ?>

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td colspan="4">
  <!--Start header-->
  <?php echo  $this->a_this->fetchTemplate('header') ?>
  <?php echo  $this->a_this->fetchTemplate("traffic_bar") ?>  
  <?php if ($GLOBALS['resourcesLeftMenu']) { ?>
      <?php echo  $this->a_this->fetchTemplate("resource_menu") ?>
  <?php } ?>
  <!--End header-->
  </td>
</tr>
<tr height="100%">
  <td width="5">&nbsp;&nbsp;</td>
   <?php
      $align = $GLOBALS['Auth']->getSetting('Aff_style_page_position');
      $align = (in_array($align, array("left", "center"))) ? $align : 'left';
  ?>
  <td class="contents" width="780" align="<?php echo $align?>">
      <br>
      <?php echo  $this->a_this->fetchTemplate("error_msg").$this->content?>
  </td>
  <td width="5">&nbsp;&nbsp;</td>
  <td align="right" valign="top"></td>
</tr>
<tr>
  <td colspan="4" align=center>
  </td>
</tr>
<tr>
  <td colspan="4">
  <!--Begin footer-->
  <?php echo  $this->a_this->fetchTemplate('footer') ?>
  <!--End footer-->
  </td>
</tr>
</table>
<?php if (!empty($GLOBALS['navigation'])) { ?>
<script>
    navigationSet("<?php echo $GLOBALS['navigation']?>");
</script>
<?php } ?>
</body>
</html>
