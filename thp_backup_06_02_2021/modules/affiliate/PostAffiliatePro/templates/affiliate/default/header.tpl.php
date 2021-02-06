<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td class="headerLogo"><img src="<?php echo ($logo=$GLOBALS['Auth']->getSetting('Aff_style_logo_url')) != '' ? $logo : $this->a_this->getImage('web_logo.gif') ?>" class="logo333" border="0"></td>
  <td class="headerLogo" width="200">
          <!--Start logged field-->
        <?php echo  $this->a_this->fetchTemplate('logged_field') ?>
        <!--End logged field-->
  </td>
</tr>
<tr>
  <td class="topMenuLine" colspan="2"></td>
</tr>

</table>

