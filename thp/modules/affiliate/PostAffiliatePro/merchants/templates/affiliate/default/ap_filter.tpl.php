<table class=listing border=0 cellspacing=0 cellpadding=2 style="border-bottom: 0px;" width="780">
<?php QUnit_Templates::printFilter(1, L_G_FILTER); ?>
<tr><td class="listheaderNoLineLeft">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr><td colspan="2">
            <?php QUnit_Global::includeTemplate('filter_payout.tpl.php'); ?>
        <?php if($this->a_Auth->getSetting('Aff_min_payout_options') != '') { ?>     
                <hr class="filterline">
                &nbsp;<input type=checkbox name=ap_reachedminpayout value='yes' <?php echo ($_REQUEST['ap_reachedminpayout'] == 'yes' ? 'checked' : '')?>>&nbsp;
                <?php echo L_G_SHOWREACHEDMINPAYOUT?>&nbsp;<br>
                
            </td>
        <?php } ?>  
        </tr>
        <tr><td colspan="2">
            &nbsp;<input type="checkbox" name="ap_virtual_affiliates" value="yes"<?php echo ($_REQUEST['ap_virtual_affiliates'] == 'yes')? 'checked' : ''?>>&nbsp;
            <?php echo L_G_INCLUDEVIRTUALAFFILIATES?>&nbsp;<br>
            </td></tr>  
        </table>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr><td colspan="2"><hr class="filterline"></td></tr>  
        <tr>
            <td align=left>
                &nbsp;<input type=radio name=ap_showtype value='allunpaid' <?php echo ($_REQUEST['ap_showtype'] == 'allunpaid' ? 'checked' : '')?>>&nbsp;
            </td>
            <td align="left">
                <?php echo L_G_SHOWALLUNPAID?>&nbsp;
            </td>
        </tr>
        <tr>
            <td align=left valign="top">
                &nbsp;<input type=radio name=ap_showtype value='daterange' <?php echo ($_REQUEST['ap_showtype'] == 'daterange' ? 'checked' : '')?>>&nbsp;<br>
            </td>
            <td align="left">
                <?php echo L_G_SHOWDATERANGE?>&nbsp;
                <?php QUnit_Global::includeTemplate('filter_time.tpl.php') ?>
            </td>
        </tr>
        </table>
        <hr class="filterline">
    </td></tr>
<tr><td class="listheaderNoLineLeft">
        &nbsp;&nbsp;
        <input type="hidden" name="submited" value="yes">
        <input type="submit" class="formbutton" value="<?php echo L_G_APPLYFILTER?>"><br></td></tr>
</table>