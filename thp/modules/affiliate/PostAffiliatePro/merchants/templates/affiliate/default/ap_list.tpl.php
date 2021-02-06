<script>
function manualPayment(ID)
{
    document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliatePayments&ap_userid="+ID+"&action=manualpay"+
        "&ap_showlist=0&<?php echo SID?>";
}

<?php if($this->a_show_invoices_url != '') { ?>
	var wnd = window.open("<?php echo $this->a_show_invoices_url?>","Invoice","scrollbars=1,menubar=1,resizable=1,toolbar=1, top=100, left=100, width=800, height=800, status=0");
	wnd.focus();
<?php } ?>

</script>
    <form name=FilterForm action=index.php method=get>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliatePayments'>
    <input type=hidden name=reporttype value='transactions'>
    <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">
<table cellpadding="0" cellspacing="0" border="0" width="1%">
<tr><td valign="top"><?php echo L_G_PAYAFFILIATES_DESCRIPTION?><br><br>
<?php if($_REQUEST['exportFileName'] != '') { ?>
        <table class=listing border=0 cellspacing=0 cellpadding=2>
        <?php QUnit_Templates::printFilter(10, L_G_EXPORTFILE); ?>
        <tr>
            <td align=center>
            <?php echo L_G_DOWNLOADCSV?> <br><a class=mainlink href="<?php echo QUnit_GlobalFuncs::makePath($this->a_Auth->getSetting('Aff_export_url'), $_REQUEST['exportFileName'])?>"><b><?php echo $_REQUEST['exportFileName']?></b></a>
            </td>
        </tr>
        </table>
        <br><br>
<?php } ?>
<?php if($this->a_process_payments_url != '') { ?>
		<div align="center">
    	<iframe src="<?php echo $this->a_process_payments_url?>" width="500" height="120"></iframe>
    	</div>
    	<br><br>
<?php } ?>
    </td>
    <td></td></tr>
<tr><td align="left" colspan="2" valign="bottom"><?php QUnit_Global::includeTemplate('ap_filter.tpl.php'); ?></td></tr>
<tr><td align="left" colspan="2">
    </form>
    <form name=ResultsForm id=ResultsForm action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=1 width="780">
    <tr class=listheader>
    <td class=listheader width="1%" nowrap><input type="checkbox" id=checkItemsButton OnClick="checkAllItems();"></td>

<?php
    QUnit_Templates::printHeader(L_G_AFFILIATEID, '');
    QUnit_Templates::printHeader(L_G_NAME2, 'name');
    QUnit_Templates::printHeader(L_G_AMOUNT, 'amount');

    if($this->a_Auth->getSetting('Aff_min_payout_options') != '')
        QUnit_Templates::printHeader(L_G_MINPAYOUT, '');

    QUnit_Templates::printHeader(L_G_PAYOUTMETHOD, '');
    QUnit_Templates::printHeader(L_G_PAYMENTDATA, '');
    QUnit_Templates::printHeader(L_G_ADDRESS, '');
    QUnit_Templates::printHeader(L_G_ACTIONS, '');
?>
    </tr>
<?php
    while($data=$this->a_list_data->getNextRecord())
    {
?>
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="<?php echo $data['userid']?>" <?php echo (is_array($_POST['itemschecked']) ? (in_array($data['userid'], $_POST['itemschecked']) ? 'checked' : '') : '')?>></td>
      <td class=listresult nowrap>&nbsp;<?php echo $data['userid']?></td>
      <td class=listresult align="left" nowrap>
        &nbsp;<?php echo $data['name']?>
        <?php showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affalldetails&aid=".$data['userid'], 300);?>
      </td>
      <td class=listresult nowrap>&nbsp;<?php echo $this->a_objMerchBlSettings->showCurrency(_rnd($data['approved']))?>&nbsp;</td>
<?php    if($this->a_Auth->getSetting('Aff_min_payout_options') != '') { ?>
        <td class=listresult nowrap>&nbsp;<?php echo ($data['minpayout'] == 0 || $data['minpayout'] == '' ? L_G_NOTSPECIFIED : $this->a_objMerchBlSettings->showCurrency(_rnd($data['minpayout'])))?></td>
<?php    } ?>
      <td class=listresult nowrap>&nbsp;<?php echo $data['payment_type']?><input type=hidden name="payout_type_<?php echo $data['userid']?>" value="<?php echo $data['db_payout_type']?>"></td>
      <td class=listresultnocenter nowrap align=left>&nbsp;<?php echo  (strlen($data['payment_data']) > 100) ? substr($data['payment_data'],0,47).'...' :$data['payment_data'] ?></td>
      <td class=listresultnocenter nowrap align=left>&nbsp;<?php echo $data['address']?></td>
      <td class=listresult nowrap>&nbsp;
        <?php if($this->a_this->checkPermissions('approvepayment')) { ?>
        <input class="formbutton" type="submit" onclick="javascript:manualPayment('<?php echo $data['userid']?>'); return false;" value="<?php echo L_G_MANUALPAYMENT?>">&nbsp;
        <?php } ?>
      </td>
    </tr>
<?php
    }


    if($this->a_transdata>0)
    {
?>
    <tr class=listresult>
      <td class=listresult colspan=11 align=center><br>
      <?php echo L_G_PAYMENTNOTE?><br>
      <textarea name=accounting_note rows=2 cols=70></textarea>
      </td>
    </tr>
<?php  } else { ?>
    <tr class=listresult>
      <td class=listresult colspan=11 align=center><b><?php echo L_G_NORECORDSFOUND?></b>
      </td>
    </tr>
<?php  } ?>

    <tr class=listresult>
      <td class=listresultnocenter colspan=11 align=left nowrap>
      <input type=hidden name=date1 value='<?php echo $_REQUEST['ap_year1'].'-'.$_REQUEST['ap_month1'].'-'.$_REQUEST['ap_day1']?>'>
      <input type=hidden name=date2 value='<?php echo $_REQUEST['ap_year2'].'-'.$_REQUEST['ap_month2'].'-'.$_REQUEST['ap_day2']?>'>
      <input type=hidden name=ap_year1 value='<?php echo $_REQUEST['ap_year1']?>'>
      <input type=hidden name=ap_month1 value='<?php echo $_REQUEST['ap_month1']?>'>
      <input type=hidden name=ap_day1 value='<?php echo $_REQUEST['ap_day1']?>'>
      <input type=hidden name=ap_year2 value='<?php echo $_REQUEST['ap_year2']?>'>
      <input type=hidden name=ap_month2 value='<?php echo $_REQUEST['ap_month2']?>'>
      <input type=hidden name=ap_day2 value='<?php echo $_REQUEST['ap_day2']?>'>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliatePayments'>
      <input type=hidden name=postaction id=postaction value=approvepayment>
      <input type=hidden name=aid id=aid value=_>
      <input type=hidden name=rtype value=trans>

      <?php if($this->a_this->checkPermissions('denypayment')) { ?>
      <input class=formbutton type=button value='<?php echo L_G_PAYDENIED; ?>'  onclick="javascript:document.getElementById('postaction').value='denypayment'; document.getElementById('ResultsForm').submit();">&nbsp;&nbsp;
      <?php } ?>
      <?php if($this->a_this->checkPermissions('generateexport')) { ?>
      <input class=formbutton type=button value='<?php echo L_G_GENERATEEXPORTFILE?>'  onclick="javascript:document.getElementById('postaction').value='generateexport'; document.getElementById('ResultsForm').submit();">&nbsp;&nbsp;
      <?php } ?>
      <?php if($this->a_this->checkPermissions('approvepayment')) { ?>
      <input class=formbutton type=submit value='<?php echo L_G_PAYDONE; ?>'>&nbsp;&nbsp;<br>
      <input class=formbutton type=button value='<?php echo L_G_MARKASPAIDANDSENDINVOICES?>' onclick="javascript:document.getElementById('postaction').value='approvepayment_mailinvoices'; document.getElementById('ResultsForm').submit();">
      <select name="send_invoice_to">
      		<option value="<?php echo SEND_TO_MERCHANT?>" <?php echo $_REQUEST['send_invoice_to'] == SEND_TO_MERCHANT ? 'selected' : ''?>>
      			<?php echo L_G_SEND_TO_MERCHANT?></option>
      		<option value="<?php echo SEND_TO_AFFILIATE?>" <?php echo $_REQUEST['send_invoice_to'] == SEND_TO_AFFILIATE ? 'selected' : ''?>>
      			<?php echo L_G_SEND_TO_AFFILIATE?></option>
      		<option value="<?php echo SEND_TO_MERCHANTANDAFFILIATE?>" <?php echo $_REQUEST['send_invoice_to'] == SEND_TO_MERCHANTANDAFFILIATE ? 'selected' : ''?>>
      			<?php echo L_G_SEND_TO_MERCHANTANDAFFILIATE?></option>
      </select>&nbsp;&nbsp;<br>
      <?php } ?>
      <input class=formbutton type=button value='<?php echo L_G_VIEWPRINTINVOICES?>' onclick="javascript:document.getElementById('postaction').value='view_selected_invoices'; document.getElementById('ResultsForm').submit();">
      </td>
    </tr>
    </table>
</td></tr>
</table>
    </form>
    <br>

