<form enctype="multipart/form-data" name=myForm id=myForm action=index.php method=post>
<table class=listing33 border=0 width="780" cellspacing=0 cellpadding=0>
<tr>
  <td align="left" valig=="top">
      <?php echo L_G_SETTINGS_DESCRIPTION?><br/><br/>
  </td>
</tr>
<tr>
  <td align="left" valig=="top">
      <?php QUnit_Templates::drawDivTabs($this->a_tabs, 'setting_tab_');?>    
  </td>
</tr>

<tr><td height="5" class="sideborders"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1" height="1"></td></tr>

<tr>
    <td class=settings align=left>
    <?php
    //  foreach ($this->a_tabs as $tab) {
    //        echo $tab['content']."<br><br><br>";
    //    }
    ?>
    </td>
</tr>
<tr>
    <td align=left class="settingtab">
    &nbsp;&nbsp;
             <input type=hidden name=commited value=yes>
             <input type=hidden name=md value="Affiliate_Merchants_Views_Settings">
             <input type=hidden name=sheet value="">
             <input type=hidden name=action value="edit">
             <input class=formbutton type=submit value='<?php echo L_G_SUBMIT; ?>'>
             <br><br>
    </td>
</tr>
</table>
</form>

