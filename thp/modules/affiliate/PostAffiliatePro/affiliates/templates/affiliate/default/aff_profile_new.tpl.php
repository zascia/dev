<?php 
function getFieldRow($code, $caption, $settings) {    
    if($settings['Aff_signup_'.$code] == "1") {
        if($settings['Aff_signup_'.$code.'_mandatory'] === "true") {
            $caption = "<b>$caption</b>";
            $mandatSign = "*";
        } else {
            $mandatSign = "";
        }        
        return "<tr>\n" .
             "<td class=dir_form>&nbsp; $caption&nbsp;</td>\n" .
             "<td><input type=text name=$code size=44 value=\"".$_POST[$code]."\">$mandatSign&nbsp;</td>" .
             "</tr>";             
    }
} ?>
    <form action=index.php method=post>
<table class=listing border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(2, $_POST['header']) ?>
<tr><td valign="top" height="100%" width="50%">
    <table class=listing border=0 cellspacing=0 cellpadding=2 width="100%">
    <?php echo  getFieldRow('refid', L_G_REFID, $this->settings)?>
    <tr>
      <td class=dir_form>&nbsp;
      <b><?php echo L_G_USERNAME;?></b>
      </td>
      <td><input type=text name=uname size=44 value="<?php echo $_POST['uname']?>">*</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;
      <b><?php echo L_G_PWD1;?></b>
      </td>
      <td><input type=password name=pwd1 size=22 value="<?php echo $_POST['pwd1']?>">*</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;
      <b><?php echo L_G_PWD2;?></b>
      </td>
      <td><input type=password name=pwd2 size=22 value="<?php echo $_POST['pwd2']?>">*</td>
    </tr>
    <?php echo  getFieldRow('name', L_G_NAME, $this->settings)?>
    <?php echo  getFieldRow('surname', L_G_SURNAME, $this->settings)?>
    <?php echo  getFieldRow('company_name', L_G_COMPANYNAME, $this->settings)?>
    <?php echo  getFieldRow('street', L_G_STREET, $this->settings)?>
    <?php echo  getFieldRow('city', L_G_CITY, $this->settings)?>
    <?php echo  getFieldRow('state', L_G_STATE, $this->settings)?>    
    <tr>
      <td class=dir_form>&nbsp;
      <b><?php echo L_G_COUNTRY;?></b>
      </td>
      <td>
        <select name=country>*
        <option value=""></option>
        <?php
          while($data=$this->a_list_data2->getNextRecord()) {
            echo "<option value=\"$data\" ".($_POST['country'] == $data ? "selected" : "").">$data</option>\n"; 
          }
        ?>
        </select>*
      </td>
    </tr>    
    <?php echo  getFieldRow('zipcode', L_G_ZIPCODE, $this->settings)?>
    <?php echo  getFieldRow('phone', L_G_PHONE, $this->settings)?>
    <?php echo  getFieldRow('weburl', L_G_WEBURL, $this->settings)?>
    <?php echo  getFieldRow('fax', L_G_FAX, $this->settings)?>
    <?php echo  getFieldRow('tax_ssn', L_G_TAXSSN, $this->settings)?>
    <?php echo  getFieldRow('data1', $this->settings['Aff_signup_data1_name'], $this->settings)?>
    <?php echo  getFieldRow('data2', $this->settings['Aff_signup_data2_name'], $this->settings)?>
    <?php echo  getFieldRow('data3', $this->settings['Aff_signup_data3_name'], $this->settings)?>
    <?php echo  getFieldRow('data4', $this->settings['Aff_signup_data4_name'], $this->settings)?>
    <?php echo  getFieldRow('data5', $this->settings['Aff_signup_data5_name'], $this->settings)?>     
    
</table>
</td><td valign="top" height="100%" width="50%">
<table class=listing border=0 cellspacing=0 cellpadding=2 width="100%">    
    
    <tr>
      <td colspan=2 align=center><b><?php echo L_G_PAYOUTMETHOD?></b></td>
    </tr>
    
    <?php while($data=$this->a_list_data4->getNextRecord()) { ?>
      <tr><td colspan=2><hr></td></tr>     
      <tr>
        <td valign=top align=left colspan=2>&nbsp;
          <input type=radio name=payout_type value='<?php echo $data['payoptid']?>' <?php echo ($_POST['payout_type'] == $data['payoptid'] ? 'checked' : '')?>>
          <font size=-2><?php echo (defined($data['langid']) ? constant($data['langid']) : $data['name'])?></font>
        </td>
      </tr>
      <?php if(is_array($this->a_list_data5[$data['payoptid']])) {
           foreach($this->a_list_data5[$data['payoptid']] as $field) { ?>
            <tr>
              <td class=dir_form>&nbsp;<?php echo (defined($field['langid']) ? constant($field['langid']) : $field['name'])?></td>
              <td>
                <?php if($field['rtype'] == PAYOUTFIELD_TYPE_SELECT) { ?>
                  <select name='<?php echo 'field'.$field['payfieldid']?>'>
                    <?php if(is_array($field['availablevalues_array'])) {
                         foreach($field['availablevalues_array'] as $value) { ?>
                           <option value='<?php echo $value?>' <?php echo ($value == $_POST['field'.$field['payfieldid']] ? ' selected' : '')?>><?php echo $value?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                <?php } else { ?>
                  <input type=text name='<?php echo 'field'.$field['payfieldid']?>' size=44 value="<?php echo $_POST['field'.$field['payfieldid']]?>">
                <?php } ?>
              </td>
            </tr>
        <?php } ?>
      <?php } ?>
    <?php } ?>

    <tr>
      <td colspan=2><hr></td>
    </tr>

<?php if($this->a_Auth->getSetting('Aff_min_payout_options') != '') { ?>
    <tr>
      <td class=dir_form>&nbsp;
      <b><?php echo L_G_MINPAYOUT;?></b>
      </td>
      <td>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
           print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
        <select name=minpayout>
<?php        while($data=$this->a_list_data1->getNextRecord()) { ?>
            <option value='<?php echo $data?>' <?php echo ($_POST['minpayout'] == $data ? 'selected' : '')?>><?php echo $data?></option>
    
<?php        } ?>      
        </select>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
           print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
      *</td>
    </tr>
<?php } ?>

<?php if ($GLOBALS['Auth']->getSetting('Aff_enable_vat_invoicing') == '1') { ?>
	<tr>
      <td colspan=2><hr></td>
    </tr>
	<tr colspan=2>
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
<?php } ?>
    
<?php if($_POST['parentuseridtext'] != '' && $_POST['parentuseridtext'] != '0') { ?>
    <tr>
      <td class=dir_form>&nbsp;
      <?php echo L_G_PARENTAFFILIATE;?>
      </td>
      <td valign=top>
      <input type=text name=db_parentuserid size=44 value="<?php echo $_POST['parentuseridtext']?>" readonly>
      <input type=hidden name=parentuserid size=10 value="<?php echo $_POST['parentuserid']?>">
      </td>
    </tr>    
<?php } ?>
    </table>
</td></tr>
<tr><td colspan="2" align="center">
      <br><br>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Affiliates_Views_AffiliateProfile'>
      <input type=hidden name=action value=<?php echo $_POST['action']?>>
      <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
      <input type=hidden name=max_campaigns value="1">
      <input type=submit class=formbutton value='<?php echo L_G_SUBMIT; ?>'>
    </td></tr>
</table>    

    </form>

