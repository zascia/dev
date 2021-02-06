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
             "<td class=dir_form>&nbsp;$caption&nbsp;</td>\n" .
             "<td><input type=text name=$code size=44 value=".$_POST[$code].">$mandatSign&nbsp;</td>" .
             "</tr>";             
    }
} ?>

    <center>
    <form action=index_popup.php method=post>
    <table border=0 class=listing cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_REFID;?></b>&nbsp;</td>
      <td><input type=text name=refid size=44 value="<?php echo $_POST['refid']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_USERNAME;?></b>&nbsp;</td>
      <td><input type=text name=uname size=44 value="<?php echo $_POST['uname']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_PWD1;?></b>&nbsp;</td>
      <td><input type=password name=pwd1 size=22 value="<?php echo $_POST['pwd1']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_PWD2;?></b>&nbsp;</td>
      <td><input type=password name=pwd2 size=22 value="<?php echo $_POST['pwd2']?>">*&nbsp;</td>
    </tr>    
    <?php echo  getFieldRow('name', L_G_NAME, $this->settings)?>
    <?php echo  getFieldRow('surname', L_G_SURNAME, $this->settings)?>
    <?php echo  getFieldRow('company_name', L_G_COMPANYNAME, $this->settings)?>
    <?php echo  getFieldRow('street', L_G_STREET, $this->settings)?>
    <?php echo  getFieldRow('city', L_G_CITY, $this->settings)?>
    <?php echo  getFieldRow('state', L_G_STATE, $this->settings)?>    
    
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_COUNTRY;?></b>&nbsp;</td>
      <td>
        <select name=country>*
        <option value=""></option>
        <?php
          if($_POST['country'] == '') $_POST['country'] = 'United States';
          
          while($data=$this->a_list_data->getNextRecord())
          {
            echo "<option value=\"$data\" ".($_POST['country'] == $data ? "selected" : "").">$data</option>\n"; 
          }
        ?>
        </select>*&nbsp;
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

    <tr>
      <td colspan=2><hr></td>
    </tr>    
    <tr>
      <td colspan=2 align=center>&nbsp;<b><?php echo L_G_PAYOUTMETHOD?></b>&nbsp;</td>
    </tr>
    
    <?php while($data=$this->a_list_data4->getNextRecord()) { ?>
      <tr><td colspan=2><hr></td></tr>     
      <tr>
        <td valign=top align=left colspan=2>&nbsp;
          <input type=radio name=payout_type value='<?php echo $data['payoptid']?>' <?php echo ($_POST['payout_type'] == $data['payoptid'] ? 'checked' : '')?>>
          <font size=-2><?php echo (defined($data['langid']) ? constant($data['langid']) : $data['name'])?></font>&nbsp;
        </td>
      </tr>
      <?php if(is_array($this->a_list_data5[$data['payoptid']])) {
           foreach($this->a_list_data5[$data['payoptid']] as $field) { ?>
            <tr>
              <td class=dir_form>&nbsp;<?php echo (defined($field['langid']) ? constant($field['langid']) : $field['name'])?>&nbsp;</td>
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
         }
       } ?>

<?php if($this->a_Auth->getSetting('Aff_min_payout_options') != '') { ?>
    <tr>
      <td colspan=2><hr></td>
    </tr>       
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_MINPAYOUT;?></b>&nbsp;</td>
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
      <select name=parentuserid>
        <option value=""><?php echo L_G_NONE2?></option>
<?php    while($data=$this->a_list_data3->getNextRecord()) {
        if($_POST['action'] == 'edit' && $data['userid'] == $_POST['aid']){
          continue;
        }
?>
        <option value="<?php echo $data['userid']?>" <?php echo ($_POST['parentuserid'] == $data['userid'] ? 'selected' : '')?>><?php echo $data['userid'].': '.$data['name'].' '.$data['surname']?></option>
<?php    } ?>
      </select>&nbsp;
      </td>
    </tr>    
    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateManager'>
      <input type=hidden name=action value=<?php echo $_POST['action']?>>
      <input type=hidden name=userid value=<?php echo $_POST['aid']?>>
      <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
      <input type=hidden name=max_campaigns value="1">
      <input type=submit class=formbutton value='<?php echo L_G_SUBMIT; ?>'>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    </table>
    </form>
    </center>
