<?php if ($this->a_list_users != '') { ?>
<form action=index.php method=get>
<table border="0" cellspacing="0" cellpadding="0" width="780">
<tr>
    <td align="left" valign="top"><?php echo L_G_QUICKREPORT_DESCRIPTION?><br><br></td>
    <td align="right" valign="top">
        <table class="listing" border="0" cellpadding="2" cellspacing="0">
            <tr><td class="tableheader" colspan="2"><b><?php echo L_G_TRANSACTIONSALLOWEDTOVIEWBYAFFILIATES?></b></td></tr>
            <tr>
                <td colspan="2"><?php echo L_G_TRANSACTIONVIEWDESCRIPTION?></td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="allow_declined_trans" <?php echo ($_POST['allow_declined_trans'] == 'allow' ? 'checked' : '');?>>&nbsp;<?php echo L_G_DENYED?>&nbsp;
                    <input type="checkbox" name="allow_pending_trans" <?php echo ($_POST['allow_pending_trans'] == 'allow' ? 'checked' : '');?>>&nbsp;<?php echo L_G_PENDING?>
                </td>
                <td align="right">
                    <input type=hidden name=md value='<?php echo $this->a_md?>'>
                    <input type=hidden name=reporttype value="quick">
                    <input type="hidden" name="aff_trans_report_settings" value="true">
                    <input type="submit" class="formbutton" value="<?php echo L_G_SET?>">
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
</form>
<br>
<?php } ?>
<form id="FilterForm" name="FilterForm" action=index.php method=get>
<table class=listing border=0 cellspacing=0 cellpadding=0 width="780">
<?php QUnit_Templates::printFilter(1, L_G_QUICK); ?>
<tr class="listheaderNoLineLeft">
  <td valign=top align=left>
  <table border=0>
    <tr>
      <td align=left nowrap colspan="2">
        <?php if ($this->a_list_users != '')
              QUnit_Global::includeTemplate('filter_affiliate.tpl.php'); ?>
      </td>
    </tr>
    <tr>
      <td align=left colspan="2" nowrap>
        <input type="hidden" name=rq_campaign value="<?php echo DEFAULT_CAMPAIGN?>">
      </td>
    </tr>
    <tr>
      <td align="left" colspan="2" nowrap>
        <?php QUnit_Global::includeTemplate('filter_time.tpl.php'); ?>
      </td>
    </tr>
    <tr>
      <td align=left colspan=2>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='<?php echo $this->a_md?>'>
      <input type=hidden name=reporttype value='quick'>
      <input class=formbutton type=submit value='<?php echo L_G_APPLYFILTER?>'>      
      </form>
      </td>
    </tr>
  </table>
  </form>

  </td>
</tr>
