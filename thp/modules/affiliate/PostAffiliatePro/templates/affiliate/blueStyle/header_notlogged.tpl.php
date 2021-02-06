<?php $GLOBALS['Auth']->loadSettings(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td class="headerLogo"><img src="<?php echo ($logo=$GLOBALS['Auth']->getSetting('Aff_style_logo_url')) != '' ? $logo : $this->a_this->getImage('web_logo.gif') ?>" class="logo333" border="0"></td>    
    <td class="headerLogo" width="100%" align="right" valign="top"></td>
</tr>
<tr>
  <td class="topMenuLine" colspan="2"></td>
</tr>
<tr>
  <td class="topMenuLineAboveContent" colspan="2"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" width="1" height="1" border="0"></td>
</tr>
</table>