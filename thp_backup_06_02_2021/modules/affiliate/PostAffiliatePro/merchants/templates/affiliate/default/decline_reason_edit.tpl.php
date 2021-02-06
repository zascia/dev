
    <center>
    <form action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_DECLINE_REASON;?></b>&nbsp;</td>
      <td><input type=text name=decline_reason size=44 value="<?php echo $_POST['decline_reason']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form colspan=2 align=center>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='<?php echo $this->a_md?>'>
        <input type=hidden name=action value='<?php echo $_POST['action']?>'>
        <input type=hidden name=itemschecked value='<?php echo $_POST['itemschecked']?>'>
        <input type=hidden name=postaction value='<?php echo $_POST['postaction']?>'>
        <input type=hidden name=show_no_popup value='1'>
        <input type=submit class=formbutton value='<?php echo L_G_SUBMIT?>'>
      </td>
    </tr>
    </table>
    </form>
    </center>
