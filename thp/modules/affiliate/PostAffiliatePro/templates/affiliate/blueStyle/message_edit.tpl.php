
    <form action=index_popup.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=0>
    <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td colspan=2>&nbsp;</td>
    </tr>
    <tr>
      <td align=left nowrap>&nbsp;<b><?php echo L_G_TYPE?></b>&nbsp;
      <td align=left nowrap><?php echo ($_POST['rtype'] == MESSAGETYPE_EMAIL ? L_G_EMAIL : L_G_NEWS)?>
        &nbsp;<br>&nbsp;
      </td>
    </tr>

    <tr>
      <td align=left nowrap>&nbsp;<b><?php echo L_G_TITLE?></b>&nbsp;</td>
      <td align=left><input type=text size=60 name=title value='<?php echo str_replace("'",'',$_POST['title'])?>'></td>
    </tr>
    <tr>
      <td align=left valign=top nowrap>&nbsp;<b><?php echo L_G_MESSAGE_TEXT?></b>&nbsp;</td>
      <td align=left>
        <textarea name=rtext rows=15 cols=80><?php echo $_POST['rtext']?></textarea>&nbsp;
      </td>
    </tr>    
    <tr>
      <td colspan=2 align=center>&nbsp;<br>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='<?php echo $this->a_md?>'>
        <input type=hidden name=action value='edit'>
        <input type=hidden name=postaction value='edit'>
        <input type=hidden name=mid value='<?php echo $_POST['mid']?>'>
        <input class=formbutton type=submit value='<?php echo L_G_SUBMIT; ?>'>     
        <br>&nbsp;
      </td>
    </tr>    
    </table>
    </form>
