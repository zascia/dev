    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter2(3, L_G_EDITCUSTOMIZATION); ?>
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_AFFAPPROVAL?></b></td>
      <td class=listresult2 align=left valign=top>
        <select name=affiliateapproval>
          <option value="<?php echo APPROVE_AUTOMATIC?>" <?php echo ($_POST['affiliateapproval'] == APPROVE_AUTOMATIC ? 'selected' : '')?>><?php echo L_G_AUTOMATIC?></option>
          <option value="<?php echo APPROVE_MANUAL?>" <?php echo ($_POST['affiliateapproval'] == APPROVE_MANUAL ? 'selected' : '')?>><?php echo L_G_MANUAL?></option>
        </select>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPAFFAPPROVAL'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_LOGOUTURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=afflogouturl value="<?php echo $_POST['afflogouturl']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPLOGOUTURL'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_POSTSIGNUPURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=affpostsignupurl value="<?php echo $_POST['affpostsignupurl']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPPOSTSIGNUPURL'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SEND_NONREFERREDAFF_TO;?></b></td>
      <td valign=top colspan=2>
        <select name=nonreferred_signup>
          <option value='_' <?php echo $_POST['nonreferred_signup'] == '_' ? 'selected' : ''?>><?php echo L_G_NOBODY?></option>
          <option value=''  <?php echo ($_POST['nonreferred_signup'] == '' ? ' selected' : '')?>><?php echo L_G_CHOOSE_AFFILIATE?></option>
        <?php while($data=$this->a_list_data->getNextRecord()) { ?>
             <option value='<?php echo $data['userid']?>' <?php echo ($_POST['nonreferred_signup'] == $data['userid'] ? ' selected' : '')?>><?php echo $data['userid'].' : '.$data['name'].' '.$data['surname']?></option>
        <?php } ?>
        </select>
      </td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_TIERS_VISIBLE_TO_AFFILIATE;?></b></td>
      <td valign=top>
        <select name=tiers_visible_to_user>
          <option value='999999' <?php echo $_POST['tiers_visible_to_user'] == '999999' ? 'selected' : ''?>><?php echo L_G_ALL?></option>
        <?php for($i = 1; $i <= 10; $i++) { ?>
             <option value='<?php echo $i?>' <?php echo ($_POST['tiers_visible_to_user'] == $i ? ' selected' : '')?>><?php echo $i?></option>
        <?php } ?>
        </select>
      </td>
      <td>
      	<?php echo  showHelp('L_G_HLP_TIERS_VISIBLE_TO_AFFILIATE'); ?>
      </td>
    </tr>
    
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>
<?php if (1){ ///if($GLOBALS['Auth']->getSetting('AffPlanet_account_type') > ACCOUNT_LITE) { 
?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_JOIN_CAMPAIGN?></b></td>
      <td valign=top><input type=checkbox name=join_campaign value=1 <?php echo ($_POST['join_campaign'] == 1 ? 'checked' : '')?>></td>
      <td><?php showHelp('L_G_HLPJOINCAMPAIGN'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>
<?php } else { ?>
    <input type="hidden" name="join_campaign" value="0">
<?php } ?>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_DISPLAY_NEWS?></td>
      <td valign=top><input type=checkbox name=display_news value=1 <?php echo ($_POST['display_news'] == 1 ? 'checked' : '')?>></td>
      <td><?php showHelp('L_G_HLPDISPLAY_NEWS'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_DISPLAY_RESOURCES?></td>
      <td valign=top><input type=checkbox name=display_resources value=1 <?php echo ($_POST['display_resources'] == 1 ? 'checked' : '')?>></td>
      <td><?php showHelp('L_G_HLPDISPLAY_RESOURCES'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_DISPLAY_BANNER_STATISTICS_ALL?></td>
      <td valign=top><input type=checkbox name=display_banner_stats_all value=1 <?php echo ($_POST['display_banner_stats_all'] == 1 ? 'checked' : '')?>></td>
      <td><?php showHelp('L_G_HLPDISPLAY_BANNER_STATISTICS_ALL'); ?></td>
    </tr>
    <?php QUnit_Templates::printFilter2(3, L_G_MATRIXSETTINGS); ?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_USE_FORCED_MATRIX?></b></td>
      <td valign=top><input type=checkbox name=use_forced_matrix value=1 <?php echo ($_POST['use_forced_matrix'] == 1 ? 'checked' : '')?>></td>
      <td><?php showHelp('L_G_HLPUSE_FORCED_MATRIX'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_MATRIX_HEIGHT?></b></td>
      <td valign=top><input type=text name=matrix_height value='<?php echo ($_POST['matrix_height'] < 0 ? '0' : $_POST['matrix_height'])?>' style='width: 30px' maxlength='3'></td>
      <td><?php showHelp('L_G_HLPMATRIX_HEIGHT'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_MATRIX_WIDTH?></b></td>
      <td valign=top><input type=text name=matrix_width value='<?php echo ($_POST['matrix_width'] < 0 ? '0' : $_POST['matrix_width'])?>' style='width: 30px' maxlength='3'></td>
      <td><?php showHelp('L_G_HLPMATRIX_WIDTH'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SEND_SPILLOVER_TO;?></b></td>
      <td valign=top colspan=2>
        <select name=matrix_forced_user>
          <option value='<?php echo MATRIX_ACTUAL_SPONSOR?>' <?php echo $_POST['matrix_forced_user'] == MATRIX_ACTUAL_SPONSOR ? 'selected' : ''?>><?php echo L_G_ACTUAL_SPONSOR?></option>
          <option value='<?php echo MATRIX_NO_SPONSOR?>' <?php echo $_POST['matrix_forced_user'] == MATRIX_NO_SPONSOR ? 'selected' : ''?>><?php echo L_G_NO_SPONSOR?></option>
          <option value=''><?php echo L_G_CHOOSE_FORCED_AFFILIATE?></option>
        <?php while($data=$this->a_list_data1->getNextRecord()) { ?>
             <option value='<?php echo $data['userid']?>' <?php echo ($_POST['matrix_forced_user'] == $data['userid'] ? ' selected' : '')?>><?php echo $data['userid'].' : '.$data['name'].' '.$data['surname']?></option>
        <?php } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign=top colspan=2><?php showHelp('L_G_HLPSEND_SPILLOVER_TO'); ?></td>
    </tr>
    </table>
