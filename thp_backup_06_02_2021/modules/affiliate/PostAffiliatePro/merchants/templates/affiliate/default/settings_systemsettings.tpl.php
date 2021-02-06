    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter2(3, L_G_SYSTEMSETTINGS); ?>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_URL_TO_MAIN_SITE;?></td>
      <td colspan=2 valign=top><input type=text size=70 name=main_site_url value="<?php echo $_POST['main_site_url']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2 valign=top><?php showHelp('L_G_HLPURL_TO_MAIN_SITE'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr> 

    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_EXPORTDIR;?></td>
      <td colspan=2 valign=top><input type=text size=70 name=export_dir value="<?php echo $_POST['export_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2 valign=top><?php showHelp('L_G_HLPEXPORTDIR'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_EXPORTURL?></td>
      <td valign=top colspan=2><input type=text size=70 name=export_url value="<?php echo $_POST['export_url']?>"></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
<?php if (AFF_PROGRAM_TYPE == PROG_TYPE_PRO) { ?>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_RESOURCESDIR;?></td>
      <td colspan=2 valign=top><input type=text size=70 name=resources_dir value="<?php echo $_POST['resources_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2 valign=top><?php showHelp('L_G_HLPRESOURCESDIR'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
<?php } ?>

    <tr><td colspan=3>&nbsp;</td></tr>
    <tr>
      <td class=formBText valign=top><?php echo L_G_BANNERSDIR;?></td>
      <td valign=top colspan=2><input type=text size=70 name=banners_dir value="<?php echo $_POST['banners_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPBANNERSDIR'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_BANNERSURL?></td>
      <td valign=top colspan=2><input type=text size=70 name=banners_url value="<?php echo $_POST['banners_url']?>"></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr> 
    
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_URLTOSCRIPTSDIR?></td>
      <td valign=top colspan=2><input type=text size=70 name=scripts_url value="<?php echo $_POST['scripts_url']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPURLTOSCRIPTSDIR'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr> 

    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_SIGNUPURL?></td>
      <td valign=top colspan=2><input type=text size=70 name=signup_url value="<?php echo $_POST['signup_url']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPSIGNUPURL'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr> 
    
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPSYSTEMEMAIL'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr> 

    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_SYSTEMCURRENCY;?></td>
      <td valign=top><input type=text size=3 name=system_currency value="<?php echo $_POST['system_currency']?>"></td>
      <td valign=top><?php showHelp('L_G_HLPSYSTEMCURRENCY'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_CURRENCY_AT_NUMBER_POSITION;?></td>
      <td valign=top>
        <select name=currency_left_position>
          <option value='0' selected><?php echo L_G_RIGHT?></option>
          <option value='1' <?php echo $_POST['currency_left_position'] == 1 ? 'selected' : ''?>><?php echo L_G_LEFT?></option>
        </select>
      </td>
      <td valign=top><?php showHelp('L_G_HLPDISPLAYCURRENCY'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>

    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_ROUND_NUMBERS;?></td>
      <td valign=top>
        <select name=round_numbers>
          <option value='0' <?php echo $_POST['round_numbers'] == 0 ? 'selected' : ''?>>0</option>
          <option value='1' <?php echo $_POST['round_numbers'] == 1 ? 'selected' : ''?>>1</option>
          <option value='2' <?php echo $_POST['round_numbers'] == 2 ? 'selected' : ''?>>2</option>
          <option value='3' <?php echo $_POST['round_numbers'] == 3 ? 'selected' : ''?>>3</option>
          <option value='4' <?php echo $_POST['round_numbers'] == 4 ? 'selected' : ''?>>4</option>
        </select>
      </td>
      <td valign=top><?php showHelp('L_G_HLPROUND_NUMBERS'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>

    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_SYSTEMLANGUAGE;?></td>
      <td valign=top>
      <select name=default_lang>
<?php    while($data=$this->a_list_data->getNextRecord()) { ?>
        <option value="<?php echo $data?>" <?php echo ($_POST['default_lang'] == $data ? 'selected' : '')?>><?php echo $data?></option>
<?php    } ?>
      </select><br>
      </td>
      <td valign=top rowspan=2><?php showHelp('L_G_HLPSYSTEMLANGUAGE'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_ALLOWSELECTLANGUAGE;?></td>
      <td valign=top colspan=2><input type=checkbox name=allow_choose_lang value=1 <?php echo ($_POST['allow_choose_lang'] == 1 ? 'checked' : '')?>></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>

    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_SHOWMINIHELP?></td>
      <td valign=top><input type=checkbox name=show_minihelp value=1 <?php echo ($_POST['show_minihelp'] == 1 ? 'checked' : '')?>></td>
      <td valign=top><?php showHelp('L_G_HLPSHOWMINIHELP', true); ?></td>
    </tr>
    </table>
