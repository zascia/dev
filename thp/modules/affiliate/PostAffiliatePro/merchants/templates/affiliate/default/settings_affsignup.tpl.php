<?php
   if(!function_exists('getRadioButtons') && !function_exists('getFieldRow')) {
    function getRadioButtons($name) {
        return '<input type="radio" name="'.$name.'_mandatory" value="hide"  '.($_POST[$name] != '1'  ? 'checked' : '').'>'.L_G_HIDETHISFIELD.'&nbsp;&nbsp;'.
               '<input type="radio" name="'.$name.'_mandatory" value="true"  '.($_POST[$name] == '1' && $_POST[$name."_mandatory"] == 'true'  ? 'checked' : '').'>'.L_G_MANDATORY.'&nbsp;&nbsp;'.
               '<input type="radio" name="'.$name.'_mandatory" value="false" '.($_POST[$name] == '1' && $_POST[$name."_mandatory"] == 'false' ? 'checked' : '').'>'.L_G_OPTIONAL;
    }

    function getFieldRow($code, $caption, &$i) {
        return
            "<tr class=\"listrow".(($i++)%2)."\"><td>$caption</td>\n".
            "<td colspan=2 nowrap>".getRadioButtons("signup_$code")."</td>\n".
            "</tr>";
    }
   }
?>
<table width="100%" border=0 cellspacing=0 cellpadding=7>
<?php QUnit_Templates::printFilter2(2, L_G_AFFSIGNUPFORMAT); ?>
<tr>
    <td valign="top">
        <b><?php echo L_G_POSTSIGNUPURL?></b>&nbsp;<?php showQuickHelp(L_G_HLP_POSTSIGNUPURL); ?>
        <br>
		<input type="text" name="affpostsignupurl" size="80" value="<?php echo $_POST['affpostsignupurl']?>">
    </td>
</tr>
<tr>
    <td valign="top">
    	<input type="checkbox" name="newsletter_signup_enabled" value="1" <?php echo ($_POST['newsletter_signup_enabled'] == '1') ? 'checked' : ''?>>
        <b><?php echo L_G_SIGNUPTONEWSLETTER?></b>&nbsp;<?php showQuickHelp(L_G_HLP_SIGNUPTONEWSLETTER); ?>
    </td>
</tr>
<tr>
    <td valign="top">
        <b><?php echo L_G_NEWSLETTEREMAIL?></b>
        <br>
		<input type="text" name="newsletter_signup_email" size="80" value="<?php echo $_POST['newsletter_signup_email']?>">
    </td>
</tr>
<tr>
    <td valign="top">
		<b><?php echo  L_G_AFFSIGNUPFORMAT_TOS?></b>&nbsp;<?php showQuickHelp(L_G_HLP_TERMS_AND_CONDITIONS); ?>
        <br/>
		<input type="checkbox" name="signup_display_terms" value="1" <?php echo  (($_POST['signup_display_terms'] == "1") ? "checked" :"") ?>>
		<?php echo  L_G_AFFSIGNUPFORMAT_TOS_SHOW?><br>
		<input type="checkbox" name="signup_force_acceptance" value="1" <?php echo  (($_POST['signup_force_acceptance'] == "1") ? "checked" :"") ?>>
		<?php echo  L_G_AFFSIGNUPFORMAT_TOS_FORCE?>
        <br>
		<textarea rows="10" cols="80" name="signup_terms_conditions"><?php echo  $_POST['signup_terms_conditions']?></textarea>
	</td>
</tr>
<tr><td valign="top">
		<b><?php echo L_G_AFFSIGNUPFORMAT_DESCRIPTION?></b>&nbsp;<?php showQuickHelp(L_G_HLP_AFFSIGNUP_DESCRIPTION); ?>
        <br/>
		<input type="checkbox" name="signup_display_description" value="1" <?php echo  (($_POST['signup_display_description'] == "1") ? "checked" :"") ?>>
		<?php echo L_G_AFFSIGNUPFORMAT_DESCRIPTION_SHOW?><br>
		<br>
		<textarea rows="10" cols="80" name="signup_description"><?php echo  $_POST['signup_description']?></textarea>
	</td>
</tr>
</table>
<?php $i=0; ?>
<table width="100%" border=0 cellspacing=0 cellpadding=7>
<?php QUnit_Templates::printFilter2(3, L_G_AFFSIGNUPFORMAT_FORMFIELDS); ?>
<tr class="listrow<?php echo ($i++)%2?>">
    <td colspan="3"><?php echo L_G_FORMFIELSDESCRIPTION?></td>
<tr class="listrow<?php echo ($i++)%2?>">
    <td width=120><?php echo  L_G_EMAIL?></td>
    <td colspan="2"><?php echo L_G_MANDATORY?></td>
</tr>
<tr class="listrow<?php echo ($i++)%2?>"><td width=120><?php echo  L_G_NAME?><br></td>
    <td colspan="2"><?php echo L_G_MANDATORY?></td>
</tr>
<tr class="listrow<?php echo ($i++)%2?>"><td width=120><?php echo  L_G_SURNAME?></td>
    <td colspan="2"><?php echo L_G_MANDATORY?></td>
</tr>
<?php echo  getFieldRow('country',L_G_COUNTRY, $i)?>
<?php echo  getFieldRow('refid',L_G_REFERERID, $i)?>
<?php echo  getFieldRow('company_name',L_G_COMPANYNAME, $i)?>
<?php echo  getFieldRow('street',L_G_STREET, $i)?>
<?php echo  getFieldRow('city',L_G_CITY, $i)?>
<?php echo  getFieldRow('state',L_G_STATE, $i)?>
<?php echo  getFieldRow('zipcode',L_G_ZIPCODE, $i)?>
<?php echo  getFieldRow('weburl',L_G_WEBURL, $i)?>
<?php echo  getFieldRow('phone',L_G_PHONE, $i)?>
<?php echo  getFieldRow('fax',L_G_FAX, $i)?>
<?php echo  getFieldRow('tax_ssn',L_G_TAXSSN, $i)?>

<br>

<?php for($j=1;$j<=5;$j++) {?>
<tr class="listrow<?php echo ($i++)%2?>"><td><?php echo  L_G_AFFSIGNUPFORMAT_DATAFIELD.$j ?></td>
	<td><?php echo  getRadioButtons("signup_data".$j); ?></td>
	<td nowrap><?php echo  L_G_AFFSIGNUPFORMAT_FIELDNAME?> <input type="textfield" name="signup_data<?php echo $j?>_name" value="<?php echo  $_POST["signup_data{$j}_name"]?>"></td>
</tr>
<?php } ?>

</table>
<input type="hidden" name="signup_affect_editing" value="1">
<input type=hidden name="signup_automatic_form" value="1">