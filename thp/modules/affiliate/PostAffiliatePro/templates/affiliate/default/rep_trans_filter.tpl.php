<?php if ($this->a_list_users != '') { ?>
<form action=index.php method=get>
<table border="0" cellspacing="0" cellpadding="0" width="780">
<tr>
    <td align="left" valign="top"><?php echo L_G_TRANSACTIONREPORT_DESCRIPTION?><br><br></td>
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
                    <input type=hidden name=reporttype value="transactions">
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
<form name=FilterForm id=FilterForm  action=index.php method=get>
<table class=listing border=0 cellspacing=0 cellpadding=2 width="780" style="border-bottom: 0px;">
<?php QUnit_Templates::printAdvancedFilter(1, L_G_TRANSACTIONS, $this->a_form_preffix, $this->a_form_name); ?>
<tr class="listheaderNoLineLeft">
  <td valign=top align=left>
  <table border=0 cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td>
        <div id="<?php echo $this->a_form_preffix?>standard_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? 'style="display:none;"' : ''?>>
        </div>
        <div id="<?php echo $this->a_form_preffix?>advanced_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? '' : 'style="display:none;"'?>>
        <br>
        <table cellpadding="2" cellspacing="0" border="0" width="100%">
        <tr>
        	<td valign="top" colspan="2">
                <?php if ($this->a_list_users != '') {
                       QUnit_Global::includeTemplate('filter_affiliate.tpl.php'); ?>
                       <hr class="filterline">
                <?php } ?>
            </td>
        </tr>
        <tr>
        	<td valign="top">
                <table cellpadding="0" cellspacing="0">
                <tr><td align="right">&nbsp;<?php echo L_G_SHOWRESULTSWHERE?>&nbsp;</td>
                    <td><select name="<?php echo $this->a_form_preffix?>custom1">
                        <?php foreach($this->a_filterColumns as $key => $value) { ?>
                            <option value="<?php echo $key?>" <?php echo ($_REQUEST[$this->a_form_preffix.'custom1'] == $key) ? 'selected' :''?>><?php echo $value?></option>
                        <?php } ?>
                        </select>&nbsp;</td>
                    <td>&nbsp;<?php echo L_G_ISLIKE?>&nbsp;</td>
                    <td><input type=text name="<?php echo $this->a_form_preffix?>custom1data" size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'custom1data']?>"></td></tr>
                <tr><td align="right">&nbsp;<?php echo L_G_AND?>&nbsp;</td>
                    <td><select name="<?php echo $this->a_form_preffix?>custom2">
                        <?php foreach($this->a_filterColumns as $key => $value) { ?>
                            <option value="<?php echo $key?>" <?php echo ($_REQUEST[$this->a_form_preffix.'custom2'] == $key) ? 'selected' :''?>><?php echo $value?></option>
                        <?php } ?>
                        </select>&nbsp;</td>
                    <td>&nbsp;<?php echo L_G_ISLIKE?>&nbsp;</td>
                    <td><input type=text name="<?php echo $this->a_form_preffix?>custom2data" size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'custom2data']?>"></td>
                </tr>
                <tr><td align="right">&nbsp;<?php echo L_G_AND?>&nbsp;</td>
                    <td><select name="<?php echo $this->a_form_preffix?>custom3">
                        <?php foreach($this->a_filterColumns as $key => $value) { ?>
                            <option value="<?php echo $key?>" <?php echo ($_REQUEST[$this->a_form_preffix.'custom3'] == $key) ? 'selected' :''?>><?php echo $value?></option>
                        <?php } ?>
                        </select>&nbsp;</td>
                    <td>&nbsp;<?php echo L_G_ISLIKE?>&nbsp;</td>
                    <td><input type=text name="<?php echo $this->a_form_preffix?>custom3data" size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'custom3data']?>"></td>
                </tr>
                </table>
            </td>
            <td valign="top">
                <?php QUnit_Global::includeTemplate('filter_transtype.tpl.php'); ?>
                <hr class="filterline">
                <?php QUnit_Global::includeTemplate('filter_status.tpl.php'); ?>
		<!-- added filerline and new filter  -->
		<hr class="filterline">
		<?php QUnit_Global::includeTemplate('filter_transaction_date.tpl.php'); ?>
		<?php if( $this->a_list_users != '') { ?>
		<hr class="filterline">
		<table>
		<tr>
		    <td>
			<b><?php echo L_G_VIRTUALAFFILIATE?><b>&nbsp; <?php showQuickHelp(L_G_VIRTUALAFFILIATEINFO); ?>
		    </td>
		    <td>
			<input type="checkbox" name="<?php echo $this->a_form_preffix?>flags" value="<?php echo VIRTUAL_AFFILIATE?>" <?php echo ($_REQUEST[$this->a_form_preffix.'flags']==VIRTUAL_AFFILIATE) ? 'checked' : '' ?>>
		    </td>
		</tr>
		</table>
		<?php } ?>
            </td>
        </tr>
        </table>
        <hr class="filterline">
        </div>
    </td>
  </tr> 
  <tr>
      <td align=left>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='<?php echo $this->a_md?>'>
      <input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'> 
      <input type=hidden name=reporttype value='transactions'>
      <input type=hidden name=filtered value="1" >
      </td>
  </tr>
  <tr><td>
        <?php QUnit_Global::includeTemplate('filter_campaign.tpl.php') ?>
        <hr class="filterline">
        <?php QUnit_Global::includeTemplate('filter_time.tpl.php') ?>
        &nbsp;&nbsp;<input type="submit" class="formbutton" value="<?php echo L_G_APPLYFILTER?>"><br></td></tr>
  </table>
</td></tr>
</table>