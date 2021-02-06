        <table border=0 class=listing cellspacing=0 cellpadding=2 width=100%>
        <?php QUnit_Templates::printFilter(4, L_G_PAYOUTMETHOD); ?>

        <?php while($data=$this->a_list_data4->getNextRecord()) { ?>
          <tr>
            <td valign=top align=left colspan=2>&nbsp;
              <input type=radio name=payout_type value='<?php echo $data['payoptid']?>' <?php echo ($_POST['payout_type'] == $data['payoptid'] ? 'checked' : '')?>>
              <b><?php echo (defined($data['langid']) ? constant($data['langid']) : $data['name'])?></b>&nbsp;
            </td>
          </tr>
          <?php if(is_array($this->a_list_data5[$data['payoptid']])) {
               foreach($this->a_list_data5[$data['payoptid']] as $field) { ?>
                <tr>
                  <td class=dir_form nowrap>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (defined($field['langid']) ? constant($field['langid']) : $field['name'])?>&nbsp;</td>
                  <td>
                    <?php if($field['rtype'] == PAYOUTFIELD_TYPE_SELECT) { ?>
                      <select name='<?php echo 'field'.$field['payfieldid']?>'>
                        <?php if(is_array($field['availablevalues_array'])) {
                             foreach($field['availablevalues_array'] as $value) { ?>
                               <option value='<?php echo $value?>' <?php echo ($value == $_POST['field'.$field['payfieldid']] ? ' selected' : '')?>><?php echo $value?></option>
                          <?php }
                           } ?>
                      </select>&nbsp;
                    <?php } else { ?>
                      <input type=text name='<?php echo 'field'.$field['payfieldid']?>' size=44 value="<?php echo $_POST['field'.$field['payfieldid']]?>">&nbsp;
                    <?php } ?>
                  </td>
                </tr>
            <?php }
             } ?>
          <tr><td class=settingsLine colspan=2><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
        <?php } ?>

        <?php if($this->a_Auth->getSetting('Aff_min_payout_options') != '') { ?>
                <tr>
                  <td class=dir_form nowrap>&nbsp;<b><?php echo L_G_MINPAYOUT;?></b>&nbsp;</td>
                  <td>
                  <?php echo $this->a_Auth->getSetting('Aff_system_currency')?>&nbsp;<select name=minpayout>
        <?php    while($data=$this->a_list_data2->getNextRecord()) { ?>
                    <option value='<?php echo $data?>' <?php echo ($_POST['minpayout'] == $data ? 'selected' : '')?>><?php echo $data?></option>

        <?php    } ?>
                  </select>
                  *&nbsp;</td>
                </tr>
        <?php } ?>
                <tr>
                  <td class=dir_form>&nbsp;<?php echo L_G_PARENTAFFILIATE;?>&nbsp;</td>
                  <td>
                  <?php $this->a_this->assign('a_affselect_no_caption', true);
                     $this->a_this->assign('a_affselectname', 'parentuserid');
                     $this->a_this->assign('a_list_users', $this->a_list_data3);
                     $this->a_this->assign('a_affselecet_all_disabled', '1');
                     $this->a_this->assign('a_affselecet_none_enabled', '1');
                     $this->a_this->assign('a_affselect_form_name', 'user_edit_form');
                     $form_preffix = $this->a_form_preffix;
                     $this->a_this->assign('a_form_preffix', '');
                     $_REQUEST['parentuserid'] = $_POST['parentuserid'];
                     QUnit_Global::includeTemplate('filter_affiliate.tpl.php');
                     $this->a_this->assign('a_form_preffix', $form_preffix); ?>
                  &nbsp;
                  </td>
                </tr>
       </table>
       
<?php if ($GLOBALS['Auth']->getSetting('Aff_enable_vat_invoicing') == '1') { ?>
	<table border=0 class=listing cellspacing=0 cellpadding=2 width=100% style="margin-top:2px;">
    	<?php QUnit_Templates::printFilter(4, L_G_VATINVOICING); ?>
        <tr>
            <td colspan="4">
            	<b><?php echo L_G_ISAFFILIATECOMPANY?></b>
            	<input type="checkbox" name="vat_is_company" value="1" <?php echo ($_POST['vat_is_company'] == '1') ? 'checked' : ''; ?>
            		onclick="javascript: document.getElementById('vat_details').style.display = this.checked ? 'block' : 'none';">
            	<div id="vat_details" style="display: <?php echo ($_POST['vat_is_company'] == '1') ? 'block' : 'none'; ?>;">
            		<table cellpadding="0" cellspacing="5">
            		<tr><td><b><?php echo L_G_VATPERCENTAGE?></b></td>
            			<td><input type="text" name="vat_percentage" size="5" value="<?php echo $_POST['vat_percentage']?>"></td></tr>
            		<tr><td><?php echo L_G_VATNUMBER?></td>
            			<td><input type="text" name="vat_number" size="40" value="<?php echo $_POST['vat_number']?>"></td></tr>
            		<tr><td><?php echo L_G_AMOUNTOFCAPITAL?></td>
            			<td><input type="text" name="vat_amountofcapital" size="40" value="<?php echo $_POST['vat_amountofcapital']?>"></td></tr>
            		<tr><td><?php echo L_G_REGISTRATIONNUMBER?></td>
            			<td><input type="text" name="vat_registrationnumber" size="40" value="<?php echo $_POST['vat_registrationnumber']?>"></td></tr>
            		
            		</table>
            	</div>
            </td>
        </tr>
    </table>
<?php } ?>