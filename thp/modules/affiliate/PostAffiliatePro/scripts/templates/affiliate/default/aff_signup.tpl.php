<br>
<table class="listing" cellpadding="4" cellspacing="0" border="0">
<?php QUnit_Templates::printFilter(2, L_G_AFFILIATESIGNUP); ?>
<tr>
<?php if($this->settings['Aff_signup_display_description'] == "1") { ?>
<td width="280" valign="top" class="listheaderLineRight">
    <?php echo $this->settings['Aff_signup_description']?>
</td>
<?php } else { ?>
<td width="0"></td>
<?php } ?>
<td width="500" valign="top">
    <form method='post' action='signup.php'>
    <table border=0 cellspacing=0 cellpadding=2 width="100%">
    <tr><td colspan="2" align=center><span style="font-size: 16px; font-weight: bold"><?php echo L_G_AFFSIGNUPFORM?></span><br/><br></td></tr>
    <?php QUnit_Templates::printFilter3(2, L_G_ACCOUNTINFO); ?>
    <?php echo  $this->model->getFieldRow('refid', L_G_REFERERID)?>
    <?php echo  $this->model->getFieldRow('username', L_G_EMAIL)?>
    <?php echo  $this->model->getFieldRow('weburl', L_G_WEBURL)?>

    <tr><td colspan="2"><br></td></tr>
    <?php QUnit_Templates::printFilter3(2, L_G_PERSONALINFO); ?>
    <?php echo  $this->model->getFieldRow('name', L_G_NAME)?>
    <?php echo  $this->model->getFieldRow('surname', L_G_SURNAME)?>
    <?php echo  $this->model->getFieldRow('company_name', L_G_COMPANYNAME)?>
    <?php echo  $this->model->getFieldRow('street', L_G_STREET)?>
    <?php echo  $this->model->getFieldRow('city', L_G_CITY)?>
    <?php echo  $this->model->getFieldRow('state', L_G_STATE)?>


    <?php    if($this->settings['Aff_signup_country'] == "1") {
            if($this->settings['Aff_signup_country_mandatory'] === "true") {
                $caption = "<b>".L_G_COUNTRY."</b>";
                $mandatSign = "*";
            } else {
                $caption = L_G_COUNTRY;
                $mandatSign = "";
            }
    ?>
            <tr>
                <td class=dir_form><?php echo  $caption?></td>
                <td>
                    <select name=country>&nbsp;*
                    <?php if($_POST['country'] == '') $_POST['country'] = 'United States';
                    foreach($GLOBALS['countries'] as $item_country) { ?>
                        <option value="<?php echo $item_country?>" <?php if($item_country == $_POST['country']) echo ' selected'; ?>><?php echo $item_country?></option>
                    <?php } ?>
                    </select>&nbsp;<?php echo  $mandatSign?>
                </td>
            </tr>

    <?php  } ?>

    <?php echo  $this->model->getFieldRow('zipcode', L_G_ZIPCODE)?>
    <?php echo  $this->model->getFieldRow('phone', L_G_PHONE)?>

    <?php echo  $this->model->getFieldRow('fax', L_G_FAX)?>
    <?php echo  $this->model->getFieldRow('tax_ssn', L_G_TAXSSN)?>

<?php if ($this->model->isDisplayed(array('data1', 'data2', 'data3', 'data4', 'data5'))) { ?>
    <tr><td colspan="2"><br></td></tr>
    <?php QUnit_Templates::printFilter3(2, L_G_ADDITIONALINFO); ?>
    <?php echo  $this->model->getFieldRow('data1', $this->settings['Aff_signup_data1_name'])?>
    <?php echo  $this->model->getFieldRow('data2', $this->settings['Aff_signup_data2_name'])?>
    <?php echo  $this->model->getFieldRow('data3', $this->settings['Aff_signup_data3_name'])?>
    <?php echo  $this->model->getFieldRow('data4', $this->settings['Aff_signup_data4_name'])?>
    <?php echo  $this->model->getFieldRow('data5', $this->settings['Aff_signup_data5_name'])?>
<?php } ?>
    <tr>
      <td colspan=2><hr></td>
    </tr>
<?php if($_REQUEST['pid'] == '' && (!isset($_COOKIE[COOKIE_NAME]) || $_COOKIE[COOKIE_NAME] == '')) { ?>
    <tr>
      <td class=dir_form><?php echo L_G_AFFTOLDABOUTAFFPROGRAM?></td>
      <td valign=top><input type=text name=parentuserid size=10 value="<?php echo $_POST['parentuserid']?>"></td>
    </tr>
<?php } else { ?>
    <input type=hidden name=pid value="<?php echo $_REQUEST['pid']?>">
<?php } ?>
        <?php if($this->settings['Aff_signup_display_terms'] == "1") { ?>
        <tr>
          <td class=dir_form colspan=2 align=center>
           <?php echo L_G_TERMSOFSERVICE?><br>
           <textarea readonly cols="92" rows="6"><?php echo  $this->settings['Aff_signup_terms_conditions']?></textarea><br>
            <?php if($this->settings['Aff_signup_force_acceptance'] == "1") { ?>
                <input type='checkbox' name='tos' value='1'><?php echo L_G_IAGREEWITH?>
            <?php } ?>
          </td>
        </tr>
        <?php } ?>
    <tr>
      <td class=dir_form colspan=2 align=center><b><?php echo L_G_AFFPASSWORDSENTTOEMAILADDRESS?></b></td>
    </tr>    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=l value='<?php echo $_REQUEST['l']?>'>
      <input type=hidden name=aid value='<?php echo $_REQUEST['aid']?>'>
      <input type=hidden name=commited value='yes'>
      <input type=submit value='<?php echo L_G_SUBMIT?>'>
      </td>
    </tr>
    <tr><td align="right" colspan="2">
            <font size=1 color=#888888><?php echo L_G_POWEREDBY?> <a target=_blank href="http://www.qualityunit.com/postaffiliatepro/">Post Affiliate Pro 3</a></font>
        </td></tr>
    </table>
    </form>
</td></tr>
</table>
