<center>
<br>
    <form method='post' action='acctsignup.php'>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <tr>
      <td colspan=2>&nbsp;<b><?php echo L_G_ACCOUNT?></b>&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_NAME;?></b>&nbsp;</td>
      <td><input type=text name=account_name size=44 value="<?php echo $_POST['account_name']?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form valign=top>&nbsp;<b><?php echo L_G_DESCRIPTION;?></b>&nbsp;</td>
      <td><textarea name=account_description cols=44 rows=5><?php echo $_POST['account_description']?></textarea>&nbsp;</td>
    </tr>

    <tr>
      <td colspan=2><hr></td>
    </tr>
    
    <tr>
      <td colspan=2>&nbsp;<b><?php echo L_G_USER_PROFILE?></b>&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_NAME;?></b>&nbsp;</td>
      <td><input type=text name=userprofile_name size=44 value="<?php echo $_POST['userprofile_name']?>">&nbsp;*&nbsp;</td>
    </tr>

    <tr>
      <td colspan=2><hr></td>
    </tr>
    
    <tr>
      <td colspan=2>&nbsp;<b><?php echo L_G_ADD_FIRST_ACCOUNT_ADMIN?></b>&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_USERNAME;?></b>&nbsp;</td>
      <td><input type=text name=username size=44 value="<?php echo $_POST['username']?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_PWD1;?></b>&nbsp;</td>
      <td><input type=password name=pwd1 size=22 value="<?php echo $_POST['pwd1']?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_PWD2;?></b>&nbsp;</td>
      <td><input type=password name=pwd2 size=22 value="<?php echo $_POST['pwd2']?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_NAME;?></b>&nbsp;</td>
      <td><input type=text name=admin_name size=44 value="<?php echo $_POST['admin_name']?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_SURNAME;?></b>&nbsp;</td>
      <td><input type=text name=surname size=44 value="<?php echo $_POST['surname']?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td colspan=2><hr></td>
    </tr>
    <tr>
      <td class=dir_form colspan=2 align=center>
      <?php echo L_G_IAGREEWITH?> <a href='./termsofservice.htm' target='_new'><?php echo L_G_TERMSOFSERVICE?></a> 
      <input type='checkbox' name='tos' value='1' >      
      </td>
    </tr>
    <tr>
      <td class=dir_form colspan=2 align=center><b><?php echo L_G_PASSWORDSENTTOEMAILADDRESS?></b></td>
    </tr>
    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=l value='<?php echo $_REQUEST['l']?>'>
      <input type=hidden name=commited value='yes'>      
      <input type=submit value='<?php echo L_G_SUBMIT?>'>
      </td>
    </tr>
    </table>
    </form>
    <br>
    <font size=2 color=#888888><?php echo L_G_POWEREDBY?> <a target=_blank href="http://www.qualityunit.com/">PostAffiliate Pro</a></font>
    </center>
