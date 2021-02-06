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

function validate_selects(form)
{
  form.geo_selectedcountries.value = codeSelected(form.chosencountries);
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
</script>
<table width="100%" border=0 cellspacing=0 cellpadding=3>
<?php QUnit_Templates::printFilter2(1, L_G_GEOIPSETTINGS); ?>
<tr>
  <td>
  	<b><?php echo L_G_SELECTCOUNTRIES?></b>
  </td>
</tr>
<tr>
  <td valign=top colspan="3" nowrap>
    <input type=radio name=geo_allow_ban_trafic value='<?php echo ALLOW_TRAFFIC?>' <?php echo ($_POST['geo_allow_ban_trafic'] == ALLOW_TRAFFIC ? ' checked' : '')?>> <?php echo L_G_ALLOWTRAFFIC?><br>
    <input type=radio name=geo_allow_ban_trafic value='<?php echo BAN_TRAFFIC?>' <?php echo ($_POST['geo_allow_ban_trafic'] == BAN_TRAFFIC ? ' checked' : '')?>> <?php echo L_G_BANTRAFFIC?>
  </td>
</tr>
</tr>
<tr>
      <td align=left>
        <table border=0>
          <tr>
            <td class=artdata nowrap>
              <?php echo L_G_ALL?><br>
              &nbsp;<input type="hidden" name="geo_selectedcountries" value="<?php echo $_POST['geo_selectedcountries']?>">
              <select multiple name='allcountries' size=5>
                <option value=0>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </option>
<?php
              while($data1=$this->a_list_data1->getNextRecord()) {
                echo "<option value=".$data1['countrycode'].">".$data1['countryname']."</option>\n";
              }
?>
              </select>
            </td>
            <td class=artdata align=center nowrap>
              <INPUT TYPE="button" class=formbutton VALUE=">" onClick="moveFromSelectToSelect(this.form.allcountries,this.form.chosencountries); validate_selects(this.form)"><br><font size=1>&nbsp;</font><br>
              <INPUT TYPE="button" class=formbutton VALUE="<" onClick="moveFromSelectToSelect(this.form.chosencountries,this.form.allcountries); validate_selects(this.form)"><br>
            </td>
            <td class=artdata nowrap>
              <?php echo L_G_SELECTED?><br>
              &nbsp;<select multiple name='chosencountries' size=5>
                <option value=0>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </option>
<?php
              if($_POST['action'] == 'edit') {
                while($data2=$this->a_list_data2->getNextRecord()) {
				  echo "<option value=".$data2['countrycode'].">".$data2['countryname']."</option>\n";
                }
              }
?>
              </select>
              &nbsp;&nbsp;<a href=cat_add.php><?php print $lu_addnewcat; ?></a>
            </td>
          </tr>
        </table>
        <br>
      </td>
</tr>
<tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
<tr>
  <td valign=top>
  	<b><?php echo L_G_WHATTODO_WHENCOUNTRYISBANNED?><b><br>
  </td>
</tr>
<tr>
  <td valign=top>
	<input type=checkbox name=geo_dont_register_imp value=1 <?php echo ($_POST['geo_dont_register_imp'] == 1 ? 'checked' : '')?>> <?php echo L_G_DONTREGISTERIMPRESSION?>
  </td>
</tr>
<tr>
  <td valign=top>
	<input type=checkbox name=geo_dont_register_click value=1 <?php echo ($_POST['geo_dont_register_click'] == 1 ? 'checked' : '')?>> <?php echo L_G_DONTREGISTERCLICK?>
  </td>
</tr>
<tr>
  <td valign=top>
	<input type=checkbox name=geo_dont_register_sale value=1 <?php echo ($_POST['geo_dont_register_sale'] == 1 ? 'checked' : '')?>><?php echo L_G_DONTREGISTERSALE?>
  </td>
</tr>
<tr>
  <td valign=top>
    <br><b><?php echo L_G_AFTERCLICKREDIRECTTO?></b>
  </td>
</tr>
<tr>
  <td valign=top>
  	<input type=radio name=geo_after_click_action value='<?php echo AC_DEFAULT_DEST?>' <?php echo ($_POST['geo_after_click_action'] == AC_DEFAULT_DEST ? ' checked' : '')?>> <?php echo L_G_DEFAULTDEST?><br>
    <input type=radio name=geo_after_click_action value='<?php echo AC_SIGNUP_FORM?>' <?php echo ($_POST['geo_after_click_action'] == AC_SIGNUP_FORM ? ' checked' : '')?>> <?php echo L_G_REDIRECTTOSIGNUPFORM?><br>
    <input type=radio name=geo_after_click_action value='<?php echo AC_CUSTOM_DEST?>' <?php echo ($_POST['geo_after_click_action'] == AC_CUSTOM_DEST ? ' checked' : '')?>> <?php echo L_G_CUSTOMDEST?>
    &nbsp;<input type=text name=geo_custom_dest size=50 maxlength=80 value='<?php echo $_POST['geo_custom_dest']?>'>
    <br><br>
  </td>
</tr>
</table>
