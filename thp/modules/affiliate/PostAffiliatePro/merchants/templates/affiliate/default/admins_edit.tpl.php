<script>
function moveFromSelectToSelect(from,to)
{
  for(i=1; i<from.options.length; i++)
  {
    if(from.options[i].selected == true)
    {
      var option0 = new Option(from.options[i].text,from.options[i].value);
      from.options[i] = null;
      to.options[to.options.length++] = option0;
      i--;
    }
  }
}

function moveUpInSelect(select)
{
  for(i=2; i<select.options.length; i++)
  {
    if(select.options[i].selected == true)
    {
      var tmp1 = new Option(select.options[i-1].text, select.options[i-1].value);
      var tmp2 = new Option(select.options[i].text,   select.options[i].value);

      select.options[i-1] = tmp2;
      select.options[i] = tmp1;

      select.options[i-1].selected = true;
      select.options[i].selected = false;

      return;
    }
  }
}

function moveDownInSelect(select)
{
  for(i=1; i<select.options.length-1; i++)
  {
    if(select.options[i].selected == true)
    {
      var tmp1 = new Option(select.options[i].text,   select.options[i].value);
      var tmp2 = new Option(select.options[i+1].text, select.options[i+1].value);

      select.options[i] = tmp2;
      select.options[i+1] = tmp1;

      select.options[i+1].selected = true;
      select.options[i].selected = false;

      return;
    }
  }
}



function moveAllFromSelectToSelect(from,to)
{
  for(i=1; i<from.options.length; i++)
  {
      var option0 = new Option(from.options[i].text,from.options[i].value);
      from.options[i] = null;
      to.options[to.options.length++] = option0;
      i--;
  }
}

function validate_selects(form)
{
  form.selected_info.value = codeSelected(form.selected);
}

function codeSelected(select_object)
{
  codedString = '';
  for (i=1; i<select_object.options.length; i++)
  {
    codedString = codedString + ',' + select_object.options[i].value;
  }
  return codedString.substring(1,codedString.length);
}

function validate(form)
{
  if(form.selected.options.length==1)
  {
    alert("<?php echo L_G_ERRNOAFFILIATES?>");
    return false;
  }

  validate_selects(form);
}

</script>

    <table cellpadding="0" cellspacing="0" border="0" width="780">
    <tr>
        <td valign=top><?php echo $_POST['description']?><br><br>
        </td>
    </table>
    <br>

    <form action=index.php method=post enctype="multipart/form-data" onsubmit="return validate(this)">
<table class=listing border=0 cellspacing=0 cellpadding=2 width="780">
    <?php QUnit_Templates::printFilter(3, $_POST['header']); ?>
<tr><td width="50%" align="left" valign="top">
    <table border=0 cellspacing=0 cellpadding=2>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_USERNAME;?></b>&nbsp;</td>
      <td><input type=text name=username size=44 value="<?php echo $_POST['username']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_PWD1;?></b>&nbsp;</td>
      <td><input type=password name=pwd1 size=22 value="<?php echo $_POST['pwd1']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_PWD2;?></b>&nbsp;</td>
      <td><input type=password name=pwd2 size=22 value="<?php echo $_POST['pwd2']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_NAME;?></b>&nbsp;</td>
      <td><input type=text name=name size=44 value="<?php echo $_POST['name']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_SURNAME;?></b>&nbsp;</td>
      <td><input type=text name=surname size=44 value="<?php echo $_POST['surname']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_USER_PROFILE;?></b>&nbsp;</td>
      <td>
        <select name=userprofile>
        <?php
            while($data=$this->a_list_data->getNextRecord()) {
              echo '<option value="'.$data['userprofileid'].'" '.($_POST['userprofile'] == $data['userprofileid'] ? ' selected' : '').'>'.$data['name'].'</option>';
            }
        ?>
        </select>*&nbsp;
      </td>
    </tr>
    <?php if($this->a_Auth->getUserID() != $_POST['aid']) { ?>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_STATUS;?></b>&nbsp;</td>
      <td>
        <select name=rstatus>
        <?php
          if($_POST['rstatus'] == '') $_POST['rstatus'] = STATUS_ENABLE;
          echo "<option value=\"".STATUS_ENABLED."\" ".($_POST['rstatus'] == STATUS_ENABLED ? "selected" : "").">".L_G_ENABLE."</option>\n";
          echo "<option value=\"".STATUS_DISABLED."\" ".($_POST['rstatus'] == STATUS_DISABLED ? "selected" : "").">".L_G_DISABLE."</option>\n";
        ?>
        </select>*&nbsp;
      </td>
    </tr>
    <?php } ?>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_ICQ?></b>&nbsp;</td>
      <td><input type=text name=icq size=44 value="<?php echo $_POST['icq']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_MSN?></b>&nbsp;</td>
      <td><input type=text name=msn size=44 value="<?php echo $_POST['msn']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_SKYPE?></b>&nbsp;</td>
      <td><input type=text name=skype size=44 value="<?php echo $_POST['skype']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_YAHOOMESSENGER?></b>&nbsp;</td>
      <td><input type=text name=yahoomessenger size=44 value="<?php echo $_POST['yahoomessenger']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_GOOGLETALK?></b>&nbsp;</td>
      <td><input type=text name=googletalk size=44 value="<?php echo $_POST['googletalk']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form valign="top">&nbsp;<b><?php echo L_G_OTHER?></b>&nbsp;</td>
      <td><table cellpadding="2" cellspacing="0" border="0">
          <tr><td width="60"><b><?php echo L_G_OTHER_NAME?></b></td>
              <td>&nbsp;<input type=text name=other_name size=30 value="<?php echo $_POST['other_name']?>">&nbsp;</td></tr>
          <tr><td><b><?php echo L_G_OTHER_CONTACT?></b></td>
              <td>&nbsp;<input type=text name=other_contact size=30 value="<?php echo $_POST['other_contact']?>">&nbsp;</td></tr>
          </table>
      </td>
    </tr>

    </table></td>
    <td width="2%"></td>
    <td width="48%" align="left" valign="top">
    <table cellpadding="2" cellspacing="0" border="0">
    <tr><td><b><?php echo L_G_PHOTO?></b></td>
        <td><?php if ($_POST['photo_url'] != '') { ?>
                <img src="<?php echo $_POST['photo_url']?>">
            <?php } else { ?>
                <?php echo L_G_NOPHOTO?>
            <?php } ?>
        </td>
    </tr>
    <tr><td><b><?php echo L_G_PHOTOURL?></b>&nbsp;&nbsp;</td>
        <td><input type="text" name="photo_url" size="44" value="<?php echo $_POST['photo_url']?>"></td>
    </tr>
    <tr><td><?php echo L_G_OR?></td>
        <td></td>
    </tr>
    <tr><td><b><?php echo L_G_UPLOADPHOTO?></b>&nbsp;&nbsp;</td>
        <td><input type="file" name="photo_file" size="34"></td>
    </tr>
    </table>
    </td></tr>
</tr>
    <td><b>&nbsp;<?php echo  L_G_MAINAFFMANAGER?></b> <input type="checkbox" name="main_affiliate_manager" <?php echo  ($this->is_main_affiliate_manager) ? "checked" : "" ?>></td>
<tr>
<tr>
    <td class=dir_form colspan=3 align=left valign="top">
    <hr width="100%">
    <table cellpadding="2" cellspacing="0" border="0">
    <tr><td valign="top" colspan="2"><?php echo L_G_ADMININFO_DESCRIPTION?><br><br></td></tr>
    <tr><td valign="top"><b><?php echo L_G_WELCOMEMESSAGE?></b><?php showQuickHelp(L_G_HLP_ADMINWELCOMEMESSAGE); ?></td>
        <td>&nbsp;<textarea name="welcome_msg" cols="120" rows="6"><?php echo $_POST['welcome_msg']?></textarea></td></tr>
    <tr><td valign="top"><b><?php echo L_G_CUSTOMHTML?></b><?php showQuickHelp(L_G_HLP_ADMINCUSTOMHTML); ?></td>
        <td>&nbsp;<textarea name="custom_html" cols="120" rows="6"><?php echo $_POST['custom_html']?></textarea></td></tr>
    </table>
    </td>
</tr>
<tr>
    <td class=dir_form colspan="3" align=left valign="top">
    <hr width="100%">
    <b><?php echo L_G_CHOOSEINFORMATIONFORAFFILIATE?></b><?php showQuickHelp(L_G_HLP_ADMININFORMATIONTOSHOW); ?><br><br>
    <table cellpadding="2" cellspacing="0" border="0">
    <tr><td width="94">
        </td>
        <td>
        <input type="hidden" name="selected_info" value="<?php echo $_POST['selected_info']?>">
        <b><?php echo L_G_ALL?></b><br>
        <select multiple name='all' size=5>
                <option value=0>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </option>
<?php
              foreach ($this->a_info_list as $key => $value) {
                if(in_array($key, $this->a_selected)) continue;
                echo "<option value=".$key.">".$value."</option>\n";
              }
?>
              </select>
        </td>
        <td class=dir_form align="center" valign="top" width="10%"><br>
            <INPUT TYPE="button" class=formbutton VALUE=">>" onClick="moveAllFromSelectToSelect(this.form.all,this.form.selected)"><br>
            <INPUT TYPE="button" class=formbutton VALUE=">"  onClick="moveFromSelectToSelect(this.form.all,this.form.selected)"><br><font size=1>&nbsp;</font><br>
            <INPUT TYPE="button" class=formbutton VALUE="<"  onClick="moveFromSelectToSelect(this.form.selected,this.form.all)"><br>
            <INPUT TYPE="button" class=formbutton VALUE="<<" onClick="moveAllFromSelectToSelect(this.form.selected,this.form.all)">
        </td>
        <td class=dir_form align=left valign="top">
        <b><?php echo L_G_SELECTED?></b><br>
        <select multiple name='selected' size=5>
                <option value=0>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </option>

<?php
              foreach ($this->a_selected as $key) {
                echo "<option value=".$key.">".$this->a_info_list[$key]."</option>\n";
              }
?>
              </select>
        </td>
        <td class=dir_form align="left" valign="top"><br>
            <INPUT TYPE="button" class=formbutton VALUE="Move up"   onClick="moveUpInSelect(this.form.selected)"><br><font size=1>&nbsp;</font><br>
            <INPUT TYPE="button" class=formbutton VALUE="Move down" onClick="moveDownInSelect(this.form.selected)"><br>
        </td>
        </tr>
    </table>
    </td>
</tr>

<tr>
    <td class=dir_form colspan=3 align=center>
    <hr width="100%">
    <input type=hidden name=commited value=yes>
    <input type=hidden name=md value='Affiliate_Merchants_Views_AdminsManager'>
    <input type=hidden name=action value=<?php echo $_POST['action']?>>
    <input type=hidden name=aid value=<?php echo $_POST['aid']?>>
    <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
    <input type=hidden name=show_no_popup value='<?php echo $_POST['show_no_popup']?>'>
    <input type=submit class=formbutton value='<?php echo L_G_SUBMIT; ?>'>
    </td>
 </tr>
 </table>
 </form>
