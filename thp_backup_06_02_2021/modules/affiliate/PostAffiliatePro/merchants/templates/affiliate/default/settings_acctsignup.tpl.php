<?php
   if(!function_exists('getCombo') && !function_exists('getFieldRow')) {
    function getCombo($name) {
        return "<select name='{$name}_mandatory'>\n".
              "<option value='true' ".(($_POST[$name.'_mandatory'] == 'true') ? "selected" :"").">mandatory</option>".
              "<option value='false' ".(($_POST[$name.'_mandatory'] == 'false') ? "selected" :"").">optional</option>\n".
              "</select>";        
    }
   }
   if(!function_exists('getFieldRow')) {
    function getFieldRow($code, $caption) {
        return 
            "<tr>\n" .
            "<td>\n" . 
            "<input type='checkbox' name='acct_signup_$code' value='1'".(($_POST['acct_signup_'.$code] == "1") ? "checked" :"").">\n" .
            "$caption</td>" .
            "<td colspan=2>".getCombo("acct_signup_$code")."</td>" .
            "</tr>";
    }
   }
?>
<table width="100%" border=0 cellspacing=0 cellpadding=3>
<?php QUnit_Templates::printFilter2(3, L_G_ACCTSIGNUPFORMAT); ?> 
<tr><td>
<h4><?php echo  L_G_AFFSIGNUPFORMAT_TOS?></h4>

<textarea rows="6" cols="50" name="acct_signup_terms_conditions"><?php echo  $_POST['acct_signup_terms_conditions']?></textarea>
<br>
<input type="checkbox" name="acct_signup_display_terms" value="1" <?php echo  (($_POST['acct_signup_display_terms'] == "1") ? "checked" :"") ?>>
<?php echo  L_G_AFFSIGNUPFORMAT_TOS_SHOW?><br>
<input type="checkbox" name="acct_signup_force_acceptance" value="1" <?php echo  (($_POST['acct_signup_force_acceptance'] == "1") ? "checked" :"") ?>>
<?php echo  L_G_AFFSIGNUPFORMAT_TOS_FORCE?><br>
<br>

<h4><?php echo L_G_ACCTSIGNUP_ACCOUNT_FIELDS?></h4>

<table width="40%" cellpadding="2">
<tr>
<td>
<input type="checkbox" name="acct_signup_account_name" value="1" checked disabled><?php echo L_G_ACCOUNT?> <?php echo L_G_NAME?>
</td>
</tr>
<?php echo  getFieldRow('account_description',L_G_DESCRIPTION)?>
<tr>
<td>
    <br>
    <h4><?php echo L_G_ACCTSIGNUP_ADMIN_FIELDS?></h4>
</td>
</tr>
<tr>
<td>
<input type="checkbox" name="acct_signup_email" value="1" checked disabled><?php echo L_G_EMAIL?>
</td>
<td></td>
</tr>
<tr>
<td><input type="checkbox" name="name" value="1" checked disabled><?php echo L_G_NAME?><br></td>
<td></td>
</tr>
<tr>
<td><input type="checkbox" name="surname" value="1" checked disabled><?php echo L_G_SURNAME?></td>
<td></td>
</tr>
<tr>
<td><input type="checkbox" name="country" value="1" checked disabled><?php echo L_G_COUNTRY?></td>
<td></td>
</tr>
<?php echo  getFieldRow('company_name',L_G_COMPANYNAME)?>
<?php echo  getFieldRow('street',L_G_STREET)?>
<?php echo  getFieldRow('city',L_G_CITY)?>
<?php echo  getFieldRow('state',L_G_STATE)?>
<?php echo  getFieldRow('zipcode',L_G_ZIPCODE)?>
<?php echo  getFieldRow('weburl',L_G_WEBURL)?>
<?php echo  getFieldRow('phone',L_G_PHONE)?>
<?php echo  getFieldRow('fax',L_G_FAX)?>
<?php echo  getFieldRow('tax_ssn',L_G_TAXSSN)?>
</table>

<br>

<table width="80%" cellpadding="3">
<?php for($i=1;$i<=5;$i++) {?>
<tr>
<td><input type="checkbox" name="acct_signup_data<?php echo  $i?>" value="1" <?php echo  (($_POST['acct_signup_data'.$i] == "1") ? "checked" :"") ?>>
<?php echo  L_G_AFFSIGNUPFORMAT_DATAFIELD.$i ?></td>
<td><?php echo  getCombo("acct_signup_data".$i); ?></td>
<td><?php echo  L_G_AFFSIGNUPFORMAT_FIELDNAME?> <input type="textfield" name="acct_signup_data<?php echo  $i?>_name" value="<?php echo  $_POST["acct_signup_data{$i}_name"]?>"></td>
</tr>
<?php } ?>
</table>

</td></tr></table>