    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter2(3, L_G_TROUBLESHOOTING); ?>
    <tr>
      <td colspan=3 valign=top><?php showHelp('L_G_HLPTROUBLESHOOTING'); ?></td>
    </tr>
    <tr>
        <td colspan=3>&nbsp;</td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap width="15%">&nbsp;<?php echo L_G_LOG_LEVEL?>&nbsp;</td>
      <td valign=top align="left" width="15%">
        <input type=checkbox name=log_level_element[] value=<?php echo WLOG_DBERROR?> <?php echo (($_POST['log_level'] & WLOG_DBERROR) == WLOG_DBERROR ? ' checked' : '')?>><?php echo L_G_LOG_DBERROR?></td>
      <td></td></tr>
    <tr>
      <td class=formBText valign=top nowrap width="15%"></td>
      <td valign=top align="left" width="15%">
        <input type=checkbox name=log_level_element[] value=<?php echo WLOG_ERROR?> <?php echo (($_POST['log_level'] & WLOG_ERROR) == WLOG_ERROR ? ' checked' : '')?>><?php echo L_G_LOG_ERROR?></td>
      <td></td></tr>
    <tr>
      <td class=formBText valign=top nowrap width="15%"></td>
      <td valign=top align="left" width="15%">
        <input type=checkbox name=log_level_element[] value=<?php echo WLOG_ACTIONS?> <?php echo (($_POST['log_level'] & WLOG_ACTIONS) == WLOG_ACTIONS ? ' checked' : '')?>><?php echo L_G_LOG_ACTIONS?></td>
      <td></td></tr>
    <tr>
      <td class=formBText valign=top nowrap width="15%"></td>
      <td valign=top align="left" width="15%">
        <input type=checkbox id="debug_check" name=log_level_element[] value=<?php echo WLOG_DEBUG?> <?php echo (($_POST['log_level'] & WLOG_DEBUG) == WLOG_DEBUG ? ' checked' : '')?>
             onclick="javascript: document.getElementById('actions_to_debug').style.display = this.checked ? 'block' : 'none';">
            <?php echo L_G_LOG_DEBUG?></td>
      <td class=formText valign=top nowrap align="left" width="70%">
        <div id="actions_to_debug" style="display: <?php echo (($_POST['log_level'] & WLOG_DEBUG) == WLOG_DEBUG) ? 'block' : 'none'?>">
        <?php echo L_G_ACTIONS_TO_DEBUG?>
        <br><input type=checkbox name=debug_emails value=1 <?php echo ($_POST['debug_emails'] == '1' ? ' checked' : '')?>><?php echo L_G_EMAILS?>
        <br><input type=checkbox name=debug_impressions value=1 <?php echo ($_POST['debug_impressions'] == '1' ? ' checked' : '')?>><?php echo strtolower(L_G_IMPRESSIONS)?>
        <br><input type=checkbox name=debug_clicks value=1 <?php echo ($_POST['debug_clicks'] == '1' ? ' checked' : '')?>><?php echo strtolower(L_G_CLICKS)?>
        <br><input type=checkbox name=debug_sales value=1 <?php echo ($_POST['debug_sales'] == '1' ? ' checked' : '')?>><?php echo L_G_SALESLEADS?>
        </div>
      </td>
    </tr>
    </table>    
