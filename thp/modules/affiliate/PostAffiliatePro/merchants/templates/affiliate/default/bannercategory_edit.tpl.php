
    <form enctype="multipart/form-data" action=index.php method=post>
    <table border=0 cellspacing=0 cellpadding=3 width="780">
    <tr><td><?php echo L_G_HLP_BANNERCATEGORY?><br><br></td></tr>
    </table>
    <table border=0 class=listing cellspacing=0 cellpadding=3 width="780">
    <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td width="5%" class=formText nowrap><?php echo L_G_BANNERCATEGORYNAME?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_BANNERCATEGORYNAME); ?></td>
      <td>
        <input type=text name=name size=100 maxlength="100" value="<?php echo $_POST['name']?>">
      </td>
    </tr>
    <tr>
      <td class=formText colspan=2 align=left>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='<?php echo $this->a_md?>'>
      <input type=hidden name=action value=<?php echo $_REQUEST['action']?>>
      <input type=hidden name=bannercategoryid value=<?php echo $_REQUEST['bannercategoryid']?>>
      <input class=formbutton type=submit value='<?php echo L_G_SUBMIT; ?>'>
      </td>
    </tr>
    </table>
    </form>

