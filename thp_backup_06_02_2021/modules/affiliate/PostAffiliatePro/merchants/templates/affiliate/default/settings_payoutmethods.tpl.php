<script>
function addPayoutmethod()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_PayoutSettings&action=add_new_payout_method"+"&<?php echo SID?>","Payoutmethod","scrollbars=1, top=100, left=100, width=600, height=450, status=0")
    wnd.focus(); 
}

function editPayoutmethod(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_PayoutSettings&action=edit_payout_method&pid="+ID+"&<?php echo SID?>","Payoutmethod","scrollbars=1, top=100, left=100, width=600, height=450, status=0")
    wnd.focus(); 
}

function deletePayoutmethod(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETEPAYOUTMETHOD?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_PayoutSettings&pid="+ID+"&action=delete_payout_methods"+"&<?php echo SID?>";
}

function addPayoutmethodField(pID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_PayoutSettings&action=add_new_payout_field&pid="+pID+"&<?php echo SID?>","Payoutmethod","scrollbars=1, top=100, left=100, width=450, height=350, status=0")
    wnd.focus(); 
}

function editPayoutmethodField(pID,fID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_PayoutSettings&action=edit_payout_field&pid="+pID+"&fid="+fID+"&<?php echo SID?>","Payoutmethod","scrollbars=1, top=100, left=100, width=450, height=350, status=0")
    wnd.focus(); 
}

function deletePayoutmethodField(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETEPAYOUTMETHODFIELD?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_PayoutSettings&fid="+ID+"&action=delete_payout_fields"+"&<?php echo SID?>";
}
</script>
<?php echo L_G_PAYOUTSETTINGS_DESC?>
<br><br>
<table width="780" border=0 cellspacing=0 cellpadding=0>
<tr><td>
    <form action=index.php method=post>
    <table width="780" class="listing" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter(3, L_G_PAYOUTMETHODSGENERAL); ?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_MINPAYOUTOPTIONS;?></b></td>
      <td colspan=2><input type=text size=70 name=min_payout_options value="<?php echo $_POST['min_payout_options']?>"></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td colspan=2><?php showHelp('L_G_HLPMINPAYOUTOPTIONS'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_INITIALMINPAYOUT?></b></td>
      <td colspan=2><input type=text size=20 name=initial_min_payout value="<?php echo $_POST['initial_min_payout']?>"></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td colspan=2><?php showHelp('L_G_HLPINITIALMINPAYOUT'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_ENABLEVATINVOICING?></b></td>
      <td colspan=2><input type=checkbox id=enable_vat_invoicing name=enable_vat_invoicing value="1" <?php echo ($_POST['enable_vat_invoicing'] == '1') ? 'checked' : ''?>>
      <?php showHelp('L_G_HLP_ENABLEVATINVOICING'); ?>
      </td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_PAYOUTINVOICESUBJECT;?></b></td>
      <td><input name=payout_invoice_subject size=88 value="<?php echo $_POST['payout_invoice_subject']?>">&nbsp;</td>
      <td rowspan="4" valign="top">
      	<b><?php echo L_G_ALLOWEDCONSTANTS?></b><br>
      	<?php echo L_G_ALLOWEDINVOICECONSTANTSLIST?>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_PAYOUTINVOICE;?></b></td>
      <td><textarea name=payout_invoice cols=88 rows=14><?php echo $_POST['payout_invoice']?></textarea>&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_VATPAYOUTINVOICESUBJECT;?></b></td>
      <td><input name=payout_invoice_subject_vat size=88 value="<?php echo $_POST['payout_invoice_subject_vat']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_VATPAYOUTINVOICE;?></b></td>
      <td><textarea name=payout_invoice_vat cols=88 rows=14><?php echo $_POST['payout_invoice_vat']?></textarea>&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td colspan=2><?php showHelp('L_G_HLPPAYOUTINVOICE'); ?>
          <a class=helplink href="http://www.qualityunit.com/help/index.php?pcid=_&psid=0acd82b535&iid=2967c5dfce" target="_blank"><?php echo L_G_HLPCLICKHEREFORMOREHELP?></a>
      </td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
    <tr>
      <td colspan=3>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value="Affiliate_Merchants_Views_PayoutSettings">
      <input type=hidden name=action value="edit">
      <?php if($this->a_this->checkPermissions("edit")) { ?>
      <input class=formbutton type=submit value='<?php echo L_G_SUBMIT; ?>'>
      <?php } ?>
      </td>
    </tr>
    </table>
    </form>

    <table width="780" class="listing" border=0 cellspacing=0 cellpadding=3 style="margin: 10px 0px">
    <?php QUnit_Templates::printFilter(4, L_G_PAYOUTMETHODS); ?>
    <tr>
      <td colspan=3><?php showHelp('L_G_HLPPAYOUTMETHODS'); ?></td>
    </tr>
    <tr>
        <td colspan=3>
          <table class='' border=0 cellspacing=0 cellpadding=1>
            <tr>
              <td class='' align=left colspan=4>
                <?php if($this->a_this->checkPermissions("edit")) { ?>
                &nbsp;<b><a class='mainlink' href="javascript:addPayoutmethod();"><?php echo L_G_ADD_PAYOUT_METHOD?></a></b>
                <?php } ?>
              </td>
            </tr>    
        <?php while($data=$this->a_list_data1->getNextRecord()) { ?>
            <tr class='' class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
              <td class='' align=left nowrap>&nbsp;<b><?php echo $data['name']?></b>&nbsp;&nbsp;&nbsp;</td>
              <td class='' align=left nowrap>&nbsp;&nbsp;<?php echo $data['langid']?>&nbsp;&nbsp;&nbsp;</td>
              <td nowrap>&nbsp;</td>
              <td nowrap>&nbsp;</td>
              <td class='' align=center nowrap>&nbsp;&nbsp;&nbsp;<?php if($data['disabled'] == STATUS_ENABLED) echo L_G_ENABLED;
                                             else echo L_G_DISABLED;?> &nbsp;</td>
              <td class=''>
                <?php if($this->a_this->checkPermissions("edit")) { ?>
                <b><a class='mainlink' href="javascript:editPayoutmethod('<?php echo $data['payoptid']?>');"><?php echo L_G_EDIT?></a></b>&nbsp;&nbsp;
                <b><a class='mainlink' href="javascript:deletePayoutmethod('<?php echo $data['payoptid']?>');"><?php echo L_G_DELETE?></a></b>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td class='' align=left colspan=3>
                <?php if($this->a_this->checkPermissions("edit")) { ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='mainlink' href="javascript:addPayoutmethodField('<?php echo $data['payoptid']?>');"><?php echo L_G_ADD_PAYOUT_FIELD?></a>
                <?php } ?>
              </td>
            </tr>
            <?php if(is_array($this->a_list_data2[$data['payoptid']])) { ?>
                <?php foreach($this->a_list_data2[$data['payoptid']] as $field) { ?>
                    <tr class='' class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
                      <td class='' align=left nowrap>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $field['name']?>&nbsp;&nbsp;</td>
                      <td class='' align=left nowrap>&nbsp;&nbsp;<?php echo $field['langid']?>&nbsp;&nbsp;</td>
                      <td class='' align=left nowrap>&nbsp;&nbsp;<?php echo $field['code']?>&nbsp;&nbsp;</td>
                      <td class='' align=center nowrap>&nbsp;&nbsp;<?php if($field['rtype'] == PAYOUTFIELD_TYPE_TEXT) echo L_G_TYPE_TEXT;
                                                     else echo L_G_SELECT;?> &nbsp;&nbsp;</td>
                      <td class='' align=center nowrap>&nbsp;&nbsp;<?php if($field['mandatory'] == STATUS_ENABLED) echo L_G_MANDATORY;
                                                     else echo L_G_NO_MANDATORY;?> &nbsp;&nbsp;</td>

                      <td class='' align=right>
                        <?php if($this->a_this->checkPermissions("edit")) { ?>
                        <a class='mainlink' href="javascript:editPayoutmethodField('<?php echo $data['payoptid']?>','<?php echo $field['payfieldid']?>');"><?php echo L_G_EDIT?></a>&nbsp;&nbsp;
                        <a class='mainlink' href="javascript:deletePayoutmethodField('<?php echo $field['payfieldid']?>');"><?php echo L_G_DELETE?></a>
                        <?php } ?>
                      </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            
            <tr>
              <td class='' align=left colspan=3>
                &nbsp;
              </td>
            </tr>
            
        <?php } ?>
          </table>
        </td>
    </tr>
    </table>
</td></tr>
</table>
