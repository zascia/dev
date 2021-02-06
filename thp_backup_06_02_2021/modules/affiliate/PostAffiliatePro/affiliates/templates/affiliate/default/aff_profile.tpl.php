
    <form action=index.php method=post>
<table class=listing border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(2, $_POST['header']) ?>
<tr><td valign="top" height="100%" width="50%">
    <table class=listing border=0 cellspacing=0 cellpadding=2 width="100%">
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_REFID;?></b>&nbsp;</td>
      <td><input type=text name=refid size=44 value="<?php echo $_POST['refid']?>">*&nbsp;</td>
    </tr>
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
    <tr>
      <td class=dir_form>&nbsp;
      <b><?php echo L_G_NAME;?></b>
      </td>
      <td><input type=text name=name size=44 value="<?php echo $_POST['name']?>">*</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;
      <b><?php echo L_G_SURNAME;?></b>
      </td>
      <td><input type=text name=surname size=44 value="<?php echo $_POST['surname']?>">*</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;
      <?php echo L_G_COMPANYNAME;?>
      </td>
      <td><input type=text name=company_name size=44 value="<?php echo $_POST['company_name']?>"></td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;
      <b><?php echo L_G_WEBURL;?></b>
      </td>
      <td><input type=text name=weburl size=44 value="<?php echo $_POST['weburl']?>">*</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;
      <b><?php echo L_G_STREET;?></b>
      </td>
      <td><input type=text name=street size=44 value="<?php echo $_POST['street']?>">*</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;
      <b><?php echo L_G_CITY;?></b>
      </td>
      <td><input type=text name=city size=44 value="<?php echo $_POST['city']?>">*</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;
      <?php echo L_G_STATE;?>
      </td>
      <td><input type=text name=state size=44 value="<?php echo $_POST['state']?>"></td>
    </tr>    
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
    <tr>
      <td class=dir_form>&nbsp;
      <b><?php echo L_G_ZIPCODE;?></b>
      </td>
      <td><input type=text name=zipcode size=44 value="<?php echo $_POST['zipcode']?>">*</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;
      <?php echo L_G_PHONE;?>
      </td>
      <td><input type=text name=phone size=44 value="<?php echo $_POST['phone']?>"></td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;
      <?php echo L_G_FAX;?>
      </td>
      <td><input type=text name=fax size=44 value="<?php echo $_POST['fax']?>"></td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;
      <?php echo L_G_TAXSSN;?>
      </td>
      <td><input type=text name=tax_ssn size=44 value="<?php echo $_POST['tax_ssn']?>"></td>
    </tr>    
    
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
<?php } else { ?>
    <tr>
      <td class=dir_form>
      <?php echo L_G_PARENTAFFILIATE;?>
      </td>
      <td valign=top><input type=text name=parentuserid size=10 value="<?php echo $_POST['parentuserid']?>"></td>
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
