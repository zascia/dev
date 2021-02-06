
<form action=index.php method=post>
  <center>
    <table class=tableresult width=100% border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=commcat align=left valign=top colspan=3><?php echo L_G_DBCONVERTHELP?><br><br></td>
      </tr>
<?php flush(); ?>      

      <tr>
        <td class=header align=center colspan=3><?php echo L_G_DBCONVERT?></td>
      </tr>
<?php if($this->check == 'ok') { ?>
      <tr>
        <td class=theader align=center colspan=3>
            <?php echo L_G_DBCONVERSIONSUCCESS?>
        </td>
      </tr>
<?php } else { ?>
      <tr>
        <td class=commcat align=center colspan=3>
            <?php echo L_G_ERROR?>
        </td>
      </tr>
<?php } ?>
      <tr>
        <td class=commcat align=left valign=top colspan=3>&nbsp;</td>
      </tr>
      <tr>
        <td class=theader align=right valign=top colspan=3>
        <input type=hidden name=check value=<?php echo $this->check?>>
        <input type=submit class=formbutton name=submit value="<?php echo L_G_NEXT?>">
        </td>
      </tr>
    </table>
  </center>
<input type=hidden name=installmethod value="<?php echo $_POST['installmethod']?>">
<input type=hidden name=action value="<?php echo $this->action?>">
</form>

