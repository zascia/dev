
    <form action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(3, L_G_EMAILNOTIFICATIONS) ?>
<?php if($this->a_Auth->getSetting('Aff_allow_choose_lang') == 1)
   {
?>
    <tr>
      <td class=listresult2><b><?php echo L_G_LANGOFNOTIFICATIONS?></b></td>
      <td class=listresult2 align=left valign=top colspan=2>
      <select name=aff_notificationlang>
<?php    while($data=$this->a_list_data->getNextRecord()) { ?>
        <option value="<?php echo $data?>" <?php echo ($_POST['aff_notificationlang'] == $data ? 'selected' : '')?>><?php echo $data?></option>
<?php    } ?>
      </select>
      </td>
    </tr>
<?php  } ?>

    <tr>
      <td class=listresult2><b><?php echo L_G_ONSUBAFFSIGNUP?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_affonaffsignup value=1 <?php echo ($_POST['email_affonaffsignup'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPAFFONAFFSIGNUP'); ?></td>
    </tr>
    <tr>
      <td class=listresult2><b><?php echo L_G_ONSALE?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_affonsale value=1 <?php echo ($_POST['email_affonsale'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPONSALE'); ?></td>
    </tr>
    <tr>
      <td class=listresult2><b><?php echo L_G_ONPARENTSALE?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_paraffonsale value=1 <?php echo ($_POST['email_paraffonsale'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPONPARSALE'); ?></td>
    </tr>
<?php if($this->a_Auth->getSetting('Aff_email_dailyreport') == '1') { ?>
    <tr>
      <td class=listresult2><b><?php echo L_G_DAILYREPORT?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_affdailyreport value=1 <?php echo ($_POST['email_affdailyreport'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPDAILYREPORT'); ?></td>
    </tr>
<?php } ?>
<?php if($this->a_Auth->getSetting('Aff_email_weeklyreport') == '1') { ?>
    <tr>
      <td class=listresult2><b><?php echo L_G_WEEKLYREPORT?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_affweeklyreport value=1 <?php echo ($_POST['email_affweeklyreport'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPWEEKLYREPORT'); ?></td>
    </tr>
<?php } ?>
<?php if($this->a_Auth->getSetting('Aff_email_monthlyreport') == '1') { ?>
    <tr>
      <td class=listresult2><b><?php echo L_G_MONTHLYREPORT?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_affmonthlyreport value=1 <?php echo ($_POST['email_affmonthlyreport'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPMONTHLYREPORT'); ?></td>
    </tr>
<?php } ?>
    <tr><td colspan=3>&nbsp;</td></tr>

    <tr>
      <td class=dir_form colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Affiliates_Views_Settings'>
      <input type=hidden name=action value='edit'>
      <input class=formbutton type=submit value="<?php echo L_G_SAVECHANGES?>">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    </table>
    
    </form>
    <br>
