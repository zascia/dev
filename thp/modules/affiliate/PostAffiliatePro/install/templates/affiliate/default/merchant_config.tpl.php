
<form action=index.php method=post>
  <center>
    <table width=100% border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=commcat align=left valign=top colspan=3>
        <?php echo L_G_MERCHANTCONFIGHELP?>
        <br><br></td>
      </tr>
      <tr>
        <td class=header align=center colspan=3><?php echo L_G_MERCHANTCONFIG?></td>
      </tr>
      <tr>
        <td class=theader align=right><?php echo L_G_MUSERNAME?></td>
        <td width=5></td>
        <td align=left>
        <input type=textbox name=username value="<?php echo $_POST['username']?>">
        </td>
      </tr>
      <tr>
        <td class=theader align=right><?php echo L_G_MPWD?></td>
        <td width=5></td>
        <td align=left>
        <input type=password name=pwd1 value="<?php echo $_POST['pwd1']?>">
        </td>
      </tr>
      <tr>
        <td class=theader align=right><?php echo L_G_VERIFYMPWD?></td>
        <td width=5></td>
        <td align=left>
        <input type=password name=pwd2 value="<?php echo $_POST['pwd2']?>">
        </td>
      </tr>
      <tr>
        <td class=commcat align=left valign=top colspan=3>&nbsp;</td>
      </tr>
      <tr>
        <td class=theader align=right valign=top colspan=3>
        <input type=submit class=formbutton name=submit value="<?php echo L_G_NEXT?>">
        </td>
      </tr>
    </table>
  </center>
<input type=hidden name=installmethod value="<?php echo $_POST['installmethod']?>">
<input type=hidden name=action value="MerchantConfig">
</form>

