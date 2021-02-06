<script>

function approveTransactions()
{
	document.location.href = "index.php?md=TransactionManager&type=trans";
}

</script>
<form action=index.php method=post>
  <center>
    <table width=100% border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=commcat align=left valign=top colspan=3><b><?php echo L_G_STEP1HELP?></b><br><br></td>
      </tr>
<?php if($GLOBALS['errorMsg'] != '') { ?>
      <tr>
        <td class=commcat align=center colspan=3><font color=#ff0000><?php echo $GLOBALS['errorMsg']?></font></td>
      </tr>
<?php } ?>      
      <tr>
        <td class=header align=center colspan=3><?php echo L_G_INSTALLATION?></td>
      </tr>
      <tr>
        <td class=theader align=right valign=top><?php echo L_G_INSTALLATIONMETHOD?></td> 
        <td width=5></td>
        <td align=left>
        <input type=radio name=installmethod value='Install' <?php echo ($_POST['installmethod'] == 'Install' ? 'checked' : '')?>><?php echo L_G_IMINSTALL?>
        <br>
        <input type=radio name=installmethod value='UpgradeTo300' <?php echo ($_POST['installmethod'] == 'UpgradeTo300' ? 'checked' : '')?>><?php echo L_G_UPGRADE20?>
        <br>
        <input type=radio name=installmethod value='Upgrade200' <?php echo ($_POST['installmethod'] == 'Upgrade200' ? 'checked' : '')?>><?php echo L_G_UPGRADE14?>
        <br>
        <input type=radio name=installmethod value='Upgrade13x' <?php echo ($_POST['installmethod'] == 'Upgrade13x' ? 'checked' : '')?>><?php echo L_G_UPGRADE13?>
<!--        <br>
        <input type=radio name=installmethod value='Upgrade12x' <?php echo ($_POST['installmethod'] == 'Upgrade12x' ? 'checked' : '')?>><?php echo L_G_UPGRADE122?>
        <br>
        <input type=radio name=installmethod value='Upgradefree' <?php echo ($_POST['installmethod'] == 'Upgradefree' ? 'checked' : '')?>><?php echo L_G_IMUPGRADEFREE?>-->
        </td>
      </tr>
      <tr>
        <td class=commcat align=left valign=top colspan=3>&nbsp;</td>
      </tr>
      <tr>
        <td class=commcat align=right valign=top colspan=3>
        <input type=submit class=formbutton name="submit" value="<?php echo L_G_NEXT?>">
        </td>
      </tr>
    </table>
  </center>
<input type=hidden name=action value="Start">  
</form>

