<table width="100%" border=0 cellspacing=0 cellpadding=3>
<?php QUnit_Templates::printFilter2(2, L_G_AFFLOGIN); ?> 
<tr><td><b><?php echo L_G_USECUSTOMLOGINSCREEN?></b> <?php showQuickHelp(L_G_HLP_USECUSTOMLOGINSCREEN); ?></td>
    <td><input type="checkbox" name="use_custom_login" value="1" <?php echo ($_POST['use_custom_login'] == 1) ? 'checked' : ''?>></td>
</tr>
<tr><td valign="top"><b><?php echo L_G_CUSTOMHEADER?></b> <?php showQuickHelp(L_G_HLP_CUSTOMHEADER); ?></td>
    <td><textarea name="custom_header" cols="110" rows="15"><?php echo $_POST['custom_header']?></textarea></td>
</tr>
<tr><td valign="top"><b><?php echo L_G_CUSTOMFOOTER?></b> <?php showQuickHelp(L_G_HLP_CUSTOMFOOTER); ?></td>
    <td><textarea name="custom_footer" cols="110" rows="15"><?php echo $_POST['custom_footer']?></textarea></td>
</tr>
</table>