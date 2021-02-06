<center>
<br>
    <form method='post' action='affsignup.php'>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <tr>
      <td class=dir_form><?php echo L_G_REFERERID?></td>
      <td><input type=text name=refid size=44 value="<?php echo $_POST['refid']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td><?php showHelp('L_G_HLP_YOUCANCHOOSEYOUROWNREFERERID'); ?></td>
    </tr>
    <tr>
      <td class=dir_form><b><?php echo L_G_EMAIL?></b></td>
      <td><input type=text name=username size=44 value="<?php echo $_POST['username']?>">&nbsp;*</td>
    </tr>
    <tr>
      <td class=dir_form><b><?php echo L_G_NAME?></b></td>
      <td><input type=text name=name size=44 value="<?php echo $_POST['name']?>">&nbsp;*</td>
    </tr>
    <tr>
      <td class=dir_form><b><?php echo L_G_SURNAME?></b></td>
      <td><input type=text name=surname size=44 value="<?php echo $_POST['surname']?>">&nbsp;*</td>
    </tr>
    <tr>
      <td class=dir_form><?php echo L_G_COMPANYNAME?></td>
      <td><input type=text name=company_name size=44 value="<?php echo $_POST['company_name']?>"></td>
    </tr>
    <tr>
      <td class=dir_form><b><?php echo L_G_WEBURL?></b></td>
      <td><input type=text name=weburl size=44 value="<?php echo $_POST['weburl']?>">&nbsp;*</td>
    </tr>
    <tr>
      <td class=dir_form><b><?php echo L_G_STREET?></b></td>
      <td><input type=text name=street size=44 value="<?php echo $_POST['street']?>">&nbsp;*</td>
    </tr>
    <tr>
      <td class=dir_form><b><?php echo L_G_CITY?></b></td>
      <td><input type=text name=city size=44 value="<?php echo $_POST['city']?>">&nbsp;*</td>
    </tr>
    <tr>
      <td class=dir_form><?php echo L_G_STATE?></td>
      <td><input type=text name=state size=44 value="<?php echo $_POST['state']?>"></td>
    </tr>
    <tr>
      <td class=dir_form><b><?php echo L_G_COUNTRY?></b></td>
      <td>
        <select name=country>&nbsp;*
        <?php if($country == '') $country = 'United States';
           foreach($GLOBALS['countries'] as $item_country) { ?>
            <option value="<?php echo $item_country?>" <?php if($item_country == $country) echo ' selected'; ?>><?php echo $item_country?></option>
        <?php } ?>
        </select>&nbsp;*
      </td>
    </tr>
    <tr>
      <td class=dir_form><b><?php echo L_G_ZIPCODE?></b></td>
      <td><input type=text name=zipcode size=44 value="<?php echo $_POST['zipcode']?>">&nbsp;*</td>
    </tr>
    <tr>
      <td class=dir_form><?php echo L_G_PHONE?></td>
      <td><input type=text name=phone size=44 value="<?php echo $_POST['phone']?>"></td>
    </tr>
    <tr>
      <td class=dir_form><?php echo L_G_FAX?></td>
      <td><input type=text name=fax size=44 value="<?php echo $_POST['fax']?>"></td>
    </tr>
    <tr>
      <td class=dir_form><?php echo L_G_TAXSSN?></td>
      <td><input type=text name=tax_ssn size=44 value="<?php echo $_POST['tax_ssn']?>"></td>
    </tr>
    <tr>
      <td colspan=2><hr></td>
    </tr>
<?php if($_REQUEST['pid'] == '' && (!isset($_COOKIE[COOKIE_NAME]) || $_COOKIE[COOKIE_NAME] == '')) { ?>
    <tr>
      <td class=dir_form><?php echo L_G_AFFTOLDABOUTAFFPROGRAM?></td>
      <td valign=top><input type=text name=parentaffiliateid size=10 value="<?php echo $_POST['parentaffiliateid']?>"></td>
    </tr>
<?php } else { ?>
    <input type=hidden name=pid value="<?php echo $_REQUEST['pid']?>">
<?php } ?>
    <tr>
      <td class=dir_form colspan=2 align=center>
      <?php echo L_G_IAGREEWITH?> <a href='./termsofservice.htm' target='_new'><?php echo L_G_TERMSOFSERVICE?></a>
      <input type='checkbox' name='tos' value='1' >
      </td>
    </tr>
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
