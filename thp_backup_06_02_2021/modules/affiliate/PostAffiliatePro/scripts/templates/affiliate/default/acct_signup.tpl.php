<center>
<br>
    <form method='post' action='signup_acct.php'>
    <table border=0 cellspacing=0 cellpadding=2>
    <tr>
        <td><br><h3><?php echo L_G_ACCOUNT?></h3><br></td>
    </tr>
    <?php echo  $this->model->getFieldRow('account_name', L_G_ACCOUNT . " " . L_G_NAME)?>
    <?php echo  $this->model->getFieldRow('account_description', L_G_DESCRIPTION)?>

    <tr>
        <td><br><h3><?php echo L_G_ACCOUNT?> <?php echo L_G_SETTINGS?></h3><br></td>
    </tr>
    <tr>
      <td class=dir_form><b><?php echo L_G_COUNTRY?></b></td>
      <td>
        <select name=country>&nbsp;*
        <?php if($_POST['country'] == '') $_POST['country'] = 'United States';
           foreach($GLOBALS['countries'] as $item_country) { ?>
            <option value="<?php echo $item_country?>" <?php if($item_country == $_POST['country']) echo ' selected'; ?>><?php echo $item_country?></option>
        <?php } ?>
        </select>&nbsp;*
      </td>
    </tr>
    <?php echo  $this->model->getFieldRow('company_name', L_G_COMPANYNAME)?>
    <?php echo  $this->model->getFieldRow('street', L_G_STREET)?>
    <?php echo  $this->model->getFieldRow('city', L_G_CITY)?>
    <?php echo  $this->model->getFieldRow('state', L_G_STATE)?>            
    <?php echo  $this->model->getFieldRow('zipcode', L_G_ZIPCODE)?>
    <?php echo  $this->model->getFieldRow('phone', L_G_PHONE)?>
    <?php echo  $this->model->getFieldRow('weburl', L_G_WEBURL)?>
    <?php echo  $this->model->getFieldRow('fax', L_G_FAX)?>
    <?php echo  $this->model->getFieldRow('tax_ssn', L_G_TAXSSN)?>
    <?php echo  $this->model->getFieldRow('data1', $this->settings['Glob_acct_signup_data1_name'])?>
    <?php echo  $this->model->getFieldRow('data2', $this->settings['Glob_acct_signup_data2_name'])?>
    <?php echo  $this->model->getFieldRow('data3', $this->settings['Glob_acct_signup_data3_name'])?>
    <?php echo  $this->model->getFieldRow('data4', $this->settings['Glob_acct_signup_data4_name'])?>
    <?php echo  $this->model->getFieldRow('data5', $this->settings['Glob_acct_signup_data5_name'])?>        
    
    <tr>
        <td><br><h3><?php echo L_G_ADMIN?></h3><br></td>
    </tr>
    <?php echo  $this->model->getFieldRow('username', L_G_EMAIL)?>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_PWD1;?></b>&nbsp;</td>
      <td><input type=password name=pwd1 size=22 value="<?php echo $_POST['pwd1']?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_PWD2;?></b>&nbsp;</td>
      <td><input type=password name=pwd2 size=22 value="<?php echo $_POST['pwd2']?>">&nbsp;*&nbsp;</td>
    </tr>    
    <?php echo  $this->model->getFieldRow('name', L_G_NAME)?>
    <?php echo  $this->model->getFieldRow('surname', L_G_SURNAME)?>

    
    <tr>
      <td colspan=2><hr></td>
    </tr>
        <?php if($this->settings['Glob_acct_signup_display_terms'] == "1") { ?>
        <tr>
          <td class=dir_form colspan=2 align=center>
           <?php echo L_G_TERMSOFSERVICE?><br>
           <textarea readonly cols="50" rows="6"><?php echo  $this->settings['Glob_acct_signup_terms_conditions']?></textarea><br>
            <?php if($this->settings['Glob_acct_signup_force_acceptance'] == "1") { ?>
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
      <input type=hidden name=upid value='<?php echo $_REQUEST['upid']?>'>
      <input type=hidden name=commited value='yes'>
      <input type=submit value='<?php echo L_G_SUBMIT?>'>
      </td>
    </tr>
    </table>
    </form>
    <br>
    <font size=2 color=#888888><?php echo L_G_POWEREDBY?> <a target=_blank href="http://www.qualityunit.com/">PostAffiliate Pro</a></font>
    </center>
