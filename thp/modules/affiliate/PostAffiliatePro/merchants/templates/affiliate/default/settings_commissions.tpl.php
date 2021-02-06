    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter2(3, L_G_COMMISSIONS); ?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_COMMISSIONTYPES?></b></td>
      <td valign=top colspan="2">
      <input type=checkbox name=support_signup_commissions value=1 <?php echo ($_POST['support_signup_commissions'] == 1 ? 'checked' : '')?>>
      &nbsp;<?php echo L_G_PERSIGNUP?><br>
      <input type=checkbox name=support_referral_commissions value=1 <?php echo ($_POST['support_referral_commissions'] == 1 ? 'checked' : '')?>>
      &nbsp;<?php echo L_G_PERREFERRAL?><br>
<?php if (GLOBAL_DB_ENABLED != 1) { ?>
      <input type=checkbox name=support_cpm_commissions value=1 <?php echo ($_POST['support_cpm_commissions'] == 1 ? 'checked' : '')?>>
      &nbsp;<?php echo L_G_PERCPM?><br>
<?php } ?>
      <table border=0 cellspacing=0 cellpadding=0>
      <tr>
        <td><input type=checkbox name=support_click_commissions value=1 <?php echo ($_POST['support_click_commissions'] == 1 ? 'checked' : '')?>></td>
        <td>&nbsp;<?php echo L_G_PERCLICK?>,&nbsp;&nbsp;<?php echo L_G_IFNOTSUPPORTED?></td>
        <td>&nbsp;
        <select name=dont_save_click_transaction>
            <option value='0' <?php echo ($_POST['dont_save_click_transaction'] != 1 ? 'selected' : '')?>><?php echo L_G_DONTDISPLAYCLICKSINREPORTS?></option>
            <option value='1' <?php echo ($_POST['dont_save_click_transaction'] == 1 ? 'selected' : '')?>><?php echo L_G_DONTSAVECLICKS?></option>
        </select>
        </td>
      </tr>
      </table>
      <input type=checkbox name=support_sale_commissions value=1 <?php echo ($_POST['support_sale_commissions'] == 1 ? 'checked' : '')?>>
      &nbsp;<?php echo L_G_PERSALE?><br>
      <input type=checkbox name=support_lead_commissions value=1 <?php echo ($_POST['support_lead_commissions'] == 1 ? 'checked' : '')?>>
      &nbsp;<?php echo L_G_PERLEAD?><br>
<?php if (GLOBAL_DB_ENABLED != 1) { ?>
      <input type=checkbox name=support_recurring_commissions value=1 <?php echo ($_POST['support_recurring_commissions'] == 1 ? 'checked' : '')?>>
      &nbsp;<?php echo L_G_RECURRINGCOMMISSIONS?><br>
<?php } ?>
      <input type=checkbox name=support_refund_commissions value=1 <?php echo ($_POST['support_refund_commissions'] == 1 ? 'checked' : '')?>>
      &nbsp;<?php echo L_G_REFUND?><br>
      <input type=checkbox name=support_chargeback_commissions value=1 <?php echo ($_POST['support_chargeback_commissions'] == 1 ? 'checked' : '')?>>
      &nbsp;<?php echo L_G_CHARGEBACK?><br>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td class=dir_form colspan=2><?php showHelp('L_G_HLPCOMMISSIONTYPES'); ?></td>
    </tr>       
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>
<?php if((GLOBAL_DB_ENABLED != 1) || ((GLOBAL_DB_ENABLED == 1) && ($GLOBALS['Auth']->getSetting('AffPlanet_account_type') > ACCOUNT_LITE))) { ?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_RECURRINGREALCOMMISSIONS;?></b></td>
      <td valign=top><input type=checkbox name=recurringrealcommissions value=1 <?php echo ($_POST['recurringrealcommissions'] == 1 ? 'checked' : '')?>></td>
      <td valign=top><?php showHelp('L_G_HLPRECURRINGREALCOMMISSIONS'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>
<?php } else { ?>
    <input type="hidden" name="recurringrealcommissions" value="0">
<?php } ?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_MAXCOMMISSIONLEVELS?></b></td>
      <td valign=top colspan=2>
      <select name=maxcommissionlevels>
        <option value="1" <?php echo ($_POST['maxcommissionlevels'] == 1 ? 'selected' : '')?>>1 - <?php echo L_G_NOMULTITIERCOMMISSIONS?></option>
<?php      for($i=2; $i<=10; $i++) { ?>
        <option value="<?php echo $i?>" <?php echo ($_POST['maxcommissionlevels'] == $i ? 'selected' : '')?>><?php echo $i.' - '.L_G_TIER?></option>
<?php      } ?>        
      </select>      
      </td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>
<?php  if(1) {// if($GLOBALS['Auth']->getSetting('AffPlanet_account_type') > ACCOUNT_LITE) { ?>
    <tr>
      <td valign=top><b><?php echo L_G_FORCEPRODUCTIDCHOOSING?></b></td>
      <td valign=top colspan=2>
      <select name=forcecommfromproductid>
        <option value="no" <?php echo ($_POST['forcecommfromproductid'] == 'no' ? 'selected' : '')?>><?php echo L_G_NO?></option>
        <option value="yes" <?php echo ($_POST['forcecommfromproductid'] == 'yes' ? 'selected' : '')?>><?php echo L_G_YES?></option>
      </select>      
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td class=dir_form colspan=2><?php showHelp('L_G_HLPFORCEPRODUCTIDCHOOSING'); ?></td>
    </tr>    
    <tr>
      <td valign=top><b><?php echo L_G_APPLYCATFROMBANNER?></b></td>
      <td valign=top colspan=2>
      <input type=checkbox name=apply_from_banner value=1 <?php echo ($_POST['apply_from_banner'] == 1 ? 'checked' : '')?>>
    </tr>
    <tr>
      <td class=listresult2 valign=top nowrap>&nbsp;</td>
      <td class=listresult2 colspan=2><?php showHelp('L_G_HLPAPPLYCATFROMBANNER'); ?></td>
    </tr>    
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>
<?php } else { ?>
    <input type="hidden" name="forcecommfromproductid" value="no">
    <input type="hidden" name="apply_from_banner" value="0">
<?php } ?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_FIXED_COST?></b></td>
      <td valign=top nowrap>
		<select name=fixed_cost_unit>
			<option value='$' <?php print ($_POST['fixed_cost_unit'] == '$' ? 'selected' : ''); ?>><?php echo $this->a_Auth->getSetting('Aff_system_currency')?></option>
			<option value='%' <?php print ($_POST['fixed_cost_unit'] == '%' ? 'selected' : ''); ?>>%</option>
		</select>
		&nbsp;        
        <input type=text name=fixed_cost value='<?php echo ($_POST['fixed_cost'] != '' ? $_POST['fixed_cost'] : '0')?>' size='2'>
      </td>
      <td><?php showHelp('L_G_HLPFIXED_COST'); ?></td>
    </tr>
    
<?php if($_POST['support_signup_commissions'] == 1 || $_POST['support_referral_commissions'] ==  1) { ?>
    
    <tr><td colspan=3>&nbsp;</td></tr>     
    <?php QUnit_Templates::printFilter2(3, L_G_SIGNUPBONUSANDREFERRALCOMMISSION); ?>

<?php if($_POST['support_signup_commissions'] == 1) { ?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_PROGRAM_SIGNUP_BONUS?></b></td>
      <td valign=top nowrap>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
             print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
        <input type=text name=program_signup_bonus value='<?php echo ($_POST['program_signup_bonus'] != '' ? $_POST['program_signup_bonus'] : '0')?>' size='2'>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
             print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
      </td>
      <td><?php showHelp('L_G_HLPPROGRAM_SIGNUP_BONUS'); ?></td>
    </tr>
<?php } else { ?>
    <input type=hidden name=program_signup_bonus value='<?php echo ($_POST['program_signup_bonus'] != '' ? $_POST['program_signup_bonus'] : '0')?>'>
<?php } ?>    

<?php  if($_POST['support_referral_commissions'] == 1) { ?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_REFERRAL_COMMISSION?></b></td>
      <td valign=top nowrap>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
             print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
        <input type=text name=program_referral_commission value='<?php echo ($_POST['program_referral_commission'] != '' ? $_POST['program_referral_commission'] : '0')?>' size='2'>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
             print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
      </td>
      <td><?php showHelp('L_G_HLPREFERRAL_COMMISSION'); ?></td>
    </tr>
    <tr>
      <td colspan=3 align=left><b><?php echo L_G_OFFERSECONDTIERBONUS?></b>
        <table border=0>
<?php      for($i=2; $i<=$this->a_Auth->getSetting('Aff_maxcommissionlevels'); $i++) 
        {
          if(($i-2)%3 == 0) echo "<tr>";
?>
          <td align=right width=120>&nbsp;<?php echo $i.' - '.L_G_TIER?>&nbsp;
          <input type=text name=st<?php echo $i?>userbonuscommission size=2 value='<?php echo $_POST['st'.$i.'userbonuscommission']?>'>
<?php
            if(($i-2)%3 == 2) echo "</tr>";
        } ?>
        </table>
      </td>
    </tr>
    
<?php  } else { ?>
    <input type=hidden name=program_referral_commission value='<?php echo ($_POST['program_referral_commission'] != '' ? $_POST['program_referral_commission'] : '0')?>'>
<?php      for($i=2; $i<=$this->a_Auth->getSetting('Aff_maxcommissionlevels'); $i++) { ?>
    
      <input type=hidden name=st<?php echo $i?>userbonuscommission value='<?php echo $_POST['st'.$i.'userbonuscommission']?>'>

<?php      } ?>

<?php  } ?> 
<?php } else 
   {
        if($_POST['support_signup_commissions'] != 1) 
        { 
?>
    <input type=hidden name=program_signup_bonus value='<?php echo ($_POST['program_signup_bonus'] != '' ? $_POST['program_signup_bonus'] : '0')?>'>
<?php      }

        if($_POST['support_referral_commissions'] != 1) 
        { 
?>
    <input type=hidden name=program_referral_commission value='<?php echo ($_POST['program_referral_commission'] != '' ? $_POST['program_referral_commission'] : '0')?>'>
<?php          for($i=2; $i<=$this->a_Auth->getSetting('Aff_maxcommissionlevels'); $i++) 
            {
?>
              <input type=hidden name=st<?php echo $i?>userbonuscommission value='<?php echo $_POST['st'.$i.'userbonuscommission']?>'>
<?php          } 
        } 
   }        
?>
    
    </table>
