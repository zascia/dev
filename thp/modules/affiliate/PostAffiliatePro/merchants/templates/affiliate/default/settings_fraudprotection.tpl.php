    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter2(3, L_G_FRAUDPROTECTION); ?>
    <tr>
      <td class=listresult2 align=left colspan=3>
        <input type=checkbox name=declinefrequentclicks value=1 <?php echo ($_POST['declinefrequentclicks']==1 ? 'checked' : '')?>>
        <b><?php echo L_G_DECLINEFREQUENTCLICKS?>
        <input type=text name=clickfrequency size=3 value='<?php echo $_POST['clickfrequency']?>'>
        <?php echo L_G_SECONDS?> <?php echo L_G_DECLINEFREQUENTCLICKS2?>
        </b>
      </td>
    </tr>
    <tr>
      <td class=listresult2 align=left colspan=3>&nbsp;<b><?php echo L_G_WHATTODO_REPEATING_CLICKS?></b>
        <select name=frequentclicks>
          <option value="1" <?php echo ($_POST['frequentclicks'] == '1' ? 'selected' : '')?>><?php echo L_G_DECLINE?></option>
          <option value="2" <?php echo ($_POST['frequentclicks'] == '2' ? 'selected' : '')?>><?php echo L_G_DONOT_SAVE?></option>
        </select>
      </td>
    </tr>
    <tr>
      <td class=listresult2 align=left colspan=3>
        <input type=checkbox name=declinefrequentsales value=1 <?php echo ($_POST['declinefrequentsales']==1 ? 'checked' : '')?>>
        <b><?php echo L_G_DECLINEFREQUENTSALES?>
        <input type=text name=salefrequency size=3 value='<?php echo $_POST['salefrequency']?>'>
        <?php echo L_G_SECONDS?> <?php echo L_G_DECLINEFREQUENTSALES2?>
        </b>
      </td>
    </tr>
    <tr>
      <td class=listresult2 align=left colspan=3>&nbsp;<b><?php echo L_G_WHATTODO_REPEATING_SALES?></b>
        <select name=frequentsales>
          <option value="1" <?php echo ($_POST['frequentsales'] == '1' ? 'selected' : '')?>><?php echo L_G_DECLINE?></option>
          <option value="2" <?php echo ($_POST['frequentsales'] == '2' ? 'selected' : '')?>><?php echo L_G_DONOT_SAVE?></option>
        </select>    
      </td>
    </tr>
    <tr>
      <td align=left colspan=3>
      <input type=checkbox name=declinesameorderid value=1 <?php echo ($_POST['declinesameorderid']==1 ? 'checked' : '')?>>
      <b>
      <?php echo L_G_DECLINESALESSAMEORDERID?>
      <input type=text name=saleorderidfrequency size=3 value='<?php echo $_POST['saleorderidfrequency']?>'>
        <?php echo L_G_HOURS?> <?php echo L_G_DECLINEFREQUENTSALES2?>
      </b>
      </td>
    </tr>
<?php if(1==0/*$GLOBALS['Auth']->getSetting('AffPlanet_account_type') > ACCOUNT_LITE*/) { ?>
    <tr>
      <td class=listresult2 align=left colspan=3>
        <input type="checkbox" name="blockimps" value="1" <?php echo ($_POST['blockimps']==1 ? 'checked' : '')?>>
        <b><?php echo L_G_BLOCKIMPRESSIONS?>
        <input type="text" name="blockimps_time" size="3" value='<?php echo $_POST['blockimps_time']?>'>
        <select name="blockimps_timeunit">
            <option value="1" 
            <?php echo ($_POST['blockimps_timeunit'] == '1' ? 'selected' : '')?>>
            <?php echo L_G_HOURS?></option>
            <option value="2" <?php echo ($_POST['blockimps_timeunit'] == '2' ? 'selected' : '')?>><?php echo L_G_MINUTES?></option>
            <option value="3" <?php echo ($_POST['blockimps_timeunit'] == '3' ? 'selected' : '')?>><?php echo L_G_SECONDS?></option>
        </select>
        <?php echo L_G_TIME?>
        </b>
      </td>
    </tr>
<?php } else { ?>
    <input type="hidden" name="blockimps" value="0">
<?php } ?>
    <tr><td colspan=3>&nbsp;</td></tr>     
    <?php QUnit_Templates::printFilter2(3, L_G_LOGINPROTECTION); ?>
    <tr>
      <td class=dir_form valign=top><b><?php echo L_G_LOGINPROTECTIONRETRIES;?></b></td>
      <td valign=top><input type=text size=3 name=login_protection_retries value="<?php echo $_POST['login_protection_retries']?>"><br><br></td>
      <td valign=top><?php showHelp('L_G_HLPLOGINPROTECTIONRETRIES'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top><b><?php echo L_G_LOGINPROTECTIONDELAY;?></b></td>
      <td valign=top><input type=text size=3 name=login_protection_delay value="<?php echo $_POST['login_protection_delay']?>"><br><br></td>
      <td valign=top><?php showHelp('L_G_HLPLOGINPROTECTIONDELAY'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>    
    </table>    
