
    <?php if($_POST['show_no_popup'] == '1') { ?>
         <form action=index.php method=post>
    <?php } else { ?>
        <form action=index_popup.php method=post>
    <?php } ?>
    <form action=index_popup.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=formBText>&nbsp;<?php echo L_G_URL;?>&nbsp;</td>
      <td><input type=text name=url size=60 value="<?php echo $_POST['url']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Affiliates_Views_AffDomains'>
      <input type=hidden name=action value=<?php echo $_POST['action']?>>
      <input type=hidden name=did value=<?php echo $_POST['did']?>>
      <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
      <input type=hidden name=show_no_popup value='<?php echo $_POST['show_no_popup']?>'>
      <input type=submit class=formbutton value='<?php echo L_G_SUBMIT; ?>'>
      </td>
    </tr>
    </table>
    </form>
