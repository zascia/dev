
<form action=index.php method=post>
  <center>
    <table class=tableresult width=100% border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=commcat align=left valign=top colspan=3>
        <?php echo L_G_SETTINGSCHECKOUTHELP?>
        <br></td>
      </tr>
      <tr>
        <td class=commcat align=center valign=top colspan=3 style="font-size: 14px; color: #FF0000;">
        <br>
        <b><?php echo L_G_BACKUPBEFOREUPDATE?></b>
        <br><br>
        </td>
      </tr>
<?php if($this->check != 'ok') { ?>
      <tr>
        <td class=commcat align=center colspan=3>
        <font color=#ff0000><?php echo L_G_ERROR?></font>
        </td>
      </tr>
<?php } else { ?>
      <tr>
        <td class=commcat align=center colspan=3>
        <font color=#00aa00><?php echo L_G_ALLOK?></font>
        <input type=hidden name=check value=ok>
        </td>
      </tr>
<?php } ?>      
      <tr>
        <td class=header align=center colspan=3><?php echo L_G_SETTINGSCHECKOUT?></td>
      </tr>
      <tr>
        <td width=50% class=theader align=right><?php echo L_G_DBHOSTNAME?></td>
        <td width=5></td>
        <td width=50% align=left>
        <?php echo DB_HOSTNAME?>
        </td>
      </tr>
      <tr>
        <td class=theader align=right><?php echo L_G_DBNAME?></td>
        <td width=5></td>
        <td align=left>
        <?php echo DB_DATABASE?>
        </td>
      </tr>
      <tr>
        <td class=theader align=right><?php echo L_G_DBUSERNAME?></td>
        <td width=5></td>
        <td align=left>
        <?php echo DB_USERNAME?>
        </td>
      </tr>
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
<input type=hidden name=action value="SettingsCheckout">
</form>

