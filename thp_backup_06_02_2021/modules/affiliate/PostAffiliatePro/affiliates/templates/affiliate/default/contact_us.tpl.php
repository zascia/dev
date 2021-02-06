  <form action=index.php method=post>
  <table class=listing cellspacing=0 cellpadding=2 border=0>
    <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td align=left nowrap>&nbsp;<b><?php echo L_G_TITLE?></b></td>
      <td align=left><input type=text size=60 name=emailsubject value='<?php echo str_replace("'",'',$_POST['emailsubject'])?>'></td>
    </tr>
    <tr>
      <td colspan=2 align=left nowrap>&nbsp;<b><?php echo L_G_MESSAGE_TEXT?></b></td>
    </tr>   
    <tr>
      <td colspan=2>&nbsp;
        <textarea name=emailtext rows=15 cols=80><?php echo $_POST['emailtext']?></textarea>&nbsp;
      </td>
    </tr>
    <tr>
      <td colspan=2 align=center>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Affiliates_Views_ContactUs'>
        <input type=hidden name=action value=<?php echo $_POST['action']?>>
        <input type=submit class=formbutton value='<?php echo L_G_SEND?>'>
      </td>
    </tr>
  </table>
  </form>

  <br>
