    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter2(3, L_G_EMAILNOTIFICATIONS); ?>    
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_ONAFFSIGNUP?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_onaffsignup value=1 <?php echo ($_POST['email_onaffsignup'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPONAFFSIGNUP'); ?></td>       
    </tr>
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_ONSALE?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_onsale value=1 <?php echo ($_POST['email_onsale'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPONSALE'); ?></td>      
    </tr>
    
    <!-- Daily reports -->
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_DAILYREPORT?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_merch_dailyreport value=1 <?php echo ($_POST['email_merch_dailyreport'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top rowspan="2"><?php showHelp('L_G_HLPSUPPORTREPORTS'); ?></td>
    </tr>
    <tr>
      <td class=listresult2 valign=top>&nbsp;&nbsp;<?php echo L_G_ALLOWFORAFFILIATES?> <?php showQuickHelp(L_G_HLP_ALLOWREPORTSFORAFFILIATES); ?></td>
      <td class=listresult2 align=left>
      <input type=checkbox name=email_dailyreport value=1 <?php echo ($_POST['email_dailyreport'] == 1 ? 'checked' : '')?>>  
      </td>
    </tr>
    
    <!-- Weekly reports -->
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_WEEKLYREPORT?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_merch_weeklyreport value=1 <?php echo ($_POST['email_merch_weeklyreport'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top rowspan="4"><?php showHelp('L_G_HLPWEEKLYREPORT'); ?></td>
    </tr>
    <tr>
      <td class=listresult2 valign=top>&nbsp;&nbsp;<?php echo L_G_ALLOWFORAFFILIATES?> <?php showQuickHelp(L_G_HLP_ALLOWREPORTSFORAFFILIATES); ?></td>
      <td class=listresult2 align=left>
      <input type=checkbox name=email_weeklyreport value=1 <?php echo ($_POST['email_weeklyreport'] == 1 ? 'checked' : '')?>>
      </td>
    </tr>
    <tr>
      <td class=listresult2 valign=top>&nbsp;&nbsp;<?php echo L_G_WEEKSTARTS?> <?php showQuickHelp(L_G_HLP_WEEKSTARTS); ?></td>
      <td class=listresult2 align=left>
        <select name="email_weekstarts">
            <option value="0" <?php echo ($_POST['email_weekstarts'] == 0) ? 'selected' : ''?>><?php echo L_G_SUNDAY?></option>
            <option value="1" <?php echo ($_POST['email_weekstarts'] == 1) ? 'selected' : ''?>><?php echo L_G_MONDAY?></option>
            <option value="2" <?php echo ($_POST['email_weekstarts'] == 2) ? 'selected' : ''?>><?php echo L_G_TUESDAY?></option>
            <option value="3" <?php echo ($_POST['email_weekstarts'] == 3) ? 'selected' : ''?>><?php echo L_G_WEDNESDAY?></option>
            <option value="4" <?php echo ($_POST['email_weekstarts'] == 4) ? 'selected' : ''?>><?php echo L_G_THURSDAY?></option>
            <option value="5" <?php echo ($_POST['email_weekstarts'] == 5) ? 'selected' : ''?>><?php echo L_G_FRIDAY?></option>
            <option value="6" <?php echo ($_POST['email_weekstarts'] == 6) ? 'selected' : ''?>><?php echo L_G_SATURDAY?></option>
        </select>
      </td>
    </tr>
    <tr>
      <td class=listresult2 valign=top>&nbsp;&nbsp;<?php echo L_G_SENDAY?> <?php showQuickHelp(L_G_HLP_WEEKSENDDAY); ?></td>
      <td class=listresult2 align=left>
        <select name="email_weeklysendday">
            <option value="0" <?php echo ($_POST['email_weeklysendday'] == 0) ? 'selected' : ''?>><?php echo L_G_SUNDAY?></option>
            <option value="1" <?php echo ($_POST['email_weeklysendday'] == 1) ? 'selected' : ''?>><?php echo L_G_MONDAY?></option>
            <option value="2" <?php echo ($_POST['email_weeklysendday'] == 2) ? 'selected' : ''?>><?php echo L_G_TUESDAY?></option>
            <option value="3" <?php echo ($_POST['email_weeklysendday'] == 3) ? 'selected' : ''?>><?php echo L_G_WEDNESDAY?></option>
            <option value="4" <?php echo ($_POST['email_weeklysendday'] == 4) ? 'selected' : ''?>><?php echo L_G_THURSDAY?></option>
            <option value="5" <?php echo ($_POST['email_weeklysendday'] == 5) ? 'selected' : ''?>><?php echo L_G_FRIDAY?></option>
            <option value="6" <?php echo ($_POST['email_weeklysendday'] == 6) ? 'selected' : ''?>><?php echo L_G_SATURDAY?></option>
        </select>
      </td>
    </tr>
    
    <!-- Monthly reports -->
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_MONTHLYREPORT?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_merch_monthlyreport value=1 <?php echo ($_POST['email_merch_monthlyreport'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top rowspan="3"><?php showHelp('L_G_HLPMONTHLYREPORT'); ?></td>
    </tr>
    <tr>
      <td class=listresult2 valign=top>&nbsp;&nbsp;<?php echo L_G_ALLOWFORAFFILIATES?> <?php showQuickHelp(L_G_HLP_ALLOWREPORTSFORAFFILIATES); ?></td>
      <td class=listresult2 align=left>
      <input type=checkbox name=email_monthlyreport value=1 <?php echo ($_POST['email_monthlyreport'] == 1 ? 'checked' : '')?>>
      </td>
    </tr>
    <tr>
      <td class=listresult2 valign=top>&nbsp;&nbsp;<?php echo L_G_SENDAY?> <?php showQuickHelp(L_G_HLP_MONTHSENDDAY); ?></td>
      <td class=listresult2 align=left>
        <select name="email_monthlysendday">
        <?php for($i=1; $i<=31; $i++) { ?>
            <option value="<?php echo $i?>" <?php echo ($_POST['email_monthlysendday'] == $i) ? 'selected' : ''?>><?php echo $i?></option>
        <?php } ?>
        </select>
      </td>

    </tr>
    
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_ONRECURRINGTRANSGENERATED?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_recurringtrangenerated value=1 <?php echo ($_POST['email_recurringtrangenerated'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top colspan="2"><?php showHelp('L_G_HLPRECURRINGTRANGENERATED'); ?></td>       
    </tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_EMAILFORSENDINGNOTIFICATIONS;?></b></td>
      <td valign=top colspan=3><input type=text size=50 name=notifications_email value="<?php echo $_POST['notifications_email']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=4><?php showHelp('L_G_HLPEMAILFORSENDINGNOTIFICATIONS'); ?></td>
    </tr>
    </table>
