
<form action=index.php method=post>
  <center>
    <table class=tableresult width=100% border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=commcat align=left valign=top colspan=3>
        <?php echo L_G_DBCONFIGHELP?>
        <pre>
        Customize to match your database_name, database_user, and database_password.
        mysql> CREATE DATABASE database_name;
        mysql> GRANT ALL PRIVILEGES ON database_name.* 
               TO database_user@localhost IDENTIFIED BY
               "database_password" WITH GRANT OPTION;</pre>
        <?php echo L_G_DBCONFIGHELP2?>
        <br><br>
        </td>
      </tr>
<?php if($GLOBALS['errorMsg'] != '') { ?>
      <tr>
        <td class=commcat align=center colspan=3><font color=#ff0000><?php echo $GLOBALS['errorMsg']?></font></td>
      </tr>
<?php } ?>      
      <tr>
        <td class=header align=center colspan=3><?php echo L_G_DBCONFIG?></td>
      </tr>
      <tr>
        <td class=theader align=right width="50%"><?php echo L_G_DBTYPE?></td>
        <td width=5></td>
        <td align=left width="50%">
        <input type=hidden name=dbtype value="mysql">
        <?php echo L_G_MYSQL?>
        </td>
      </tr>      
      <tr>
        <td class=theader align=right><?php echo L_G_DBHOSTNAME?></td>
        <td width=5></td>
        <td align=left>
        <input type=textbox name=dbhostname value="<?php echo (!empty($_POST['dbhostname']) ? $_POST['dbhostname']: "localhost")?>">
        </td>
      </tr>
      <tr>
        <td class=theader align=right><?php echo L_G_DBNAME?></td>
        <td width=5></td>
        <td align=left>
        <input type=textbox name=dbname value="<?php echo $_POST['dbname']?>">
        </td>
      </tr>
      <tr>
        <td class=theader align=right><?php echo L_G_DBUSERNAME?></td>
        <td width=5></td>
        <td align=left>
        <input type=textbox name=dbusername value="<?php echo $_POST['dbusername']?>">
        </td>
      </tr>
      <tr>
        <td class=theader align=right><?php echo L_G_DBPWD?></td>
        <td width=5></td>
        <td align=left>
        <input type=password name=dbpwd value="<?php echo $_POST['dbpwd']?>">
        </td>
      </tr>
      <tr>
        <td class=commcat align=left valign=top colspan=3>&nbsp;</td>
      </tr>
      <tr>
        <td class=theader align=right valign=top colspan=3>
        <input type=submit class=formbutton name="submit" value="<?php echo L_G_NEXT?>">
        </td>
      </tr>
    </table>
  </center>
<input type=hidden name=installmethod value="<?php echo $_POST['installmethod']?>">
<input type=hidden name=action value="DbConfig">
</form>

