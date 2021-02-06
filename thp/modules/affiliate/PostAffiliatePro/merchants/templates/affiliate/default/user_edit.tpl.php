<script>
    function GoBack(prevwnd) {
        if (prevwnd == "edit")
            document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager";
        else
            history.go(-1);
    }
</script>

<?php $this->fieldRow->trParams = ' class="dir_form"'; ?>
    
    <form action=index.php method=post id=user_edit_form>
    <table border=0 cellspacing=0 cellpadding=2 width=780>
    <tr><td><?php echo L_G_AFFILIATE_EDIT_ADD_DESCRIPTION?>
    </td></tr>
    </table>
    <br>

    <table border=0 class=listing cellspacing=0 cellpadding=2 align=left width=780>
    <tr valign="top">
      <td width=50%>

        <table border=0 class=listing cellspacing=0 cellpadding=2 width=100%>
        <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
        <?php echo  $this->fieldRow->getFieldRow('refid', L_G_REFID, $this->settings)?>
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
        <tr>
          <td class=dir_form>&nbsp;<b><?php echo L_G_NAME;?></b>&nbsp;</td>
          <td><input type=text name=name size=22 value="<?php echo $_POST['name']?>">*&nbsp;</td>
        </tr>
        <tr>
          <td class=dir_form>&nbsp;<b><?php echo L_G_SURNAME;?></b>&nbsp;</td>
          <td><input type=text name=surname size=22 value="<?php echo $_POST['surname']?>">*&nbsp;</td>
        </tr>
        <?php echo  $this->fieldRow->getFieldRow('company_name', L_G_COMPANYNAME, $this->settings)?>
        <?php echo  $this->fieldRow->getFieldRow('street', L_G_STREET, $this->settings)?>
        <?php echo  $this->fieldRow->getFieldRow('city', L_G_CITY, $this->settings)?>
        <?php echo  $this->fieldRow->getFieldRow('state', L_G_STATE, $this->settings)?>

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
        <?php echo  $this->fieldRow->getFieldRow('zipcode', L_G_ZIPCODE, $this->settings)?>
        <?php echo  $this->fieldRow->getFieldRow('phone', L_G_PHONE, $this->settings)?>
        <?php echo  $this->fieldRow->getFieldRow('weburl', L_G_WEBURL, $this->settings)?>
        <?php echo  $this->fieldRow->getFieldRow('fax', L_G_FAX, $this->settings)?>
        <?php echo  $this->fieldRow->getFieldRow('tax_ssn', L_G_TAXSSN, $this->settings)?>
        <?php echo  $this->fieldRow->getFieldRow('data1', $this->fieldRow->settings['Aff_signup_data1_name'])?>
        <?php echo  $this->fieldRow->getFieldRow('data2', $this->fieldRow->settings['Aff_signup_data2_name'])?>
        <?php echo  $this->fieldRow->getFieldRow('data3', $this->fieldRow->settings['Aff_signup_data3_name'])?>
        <?php echo  $this->fieldRow->getFieldRow('data4', $this->fieldRow->settings['Aff_signup_data4_name'])?>
        <?php echo  $this->fieldRow->getFieldRow('data5', $this->fieldRow->settings['Aff_signup_data5_name'])?>

        <tr>
          <td colspan=2>&nbsp;</td>
        </tr>
        </table>
        <table border=0 class=listing cellspacing=0 cellpadding=2 width=100% style="margin-top:2px;">
        <?php QUnit_Templates::printFilter(1, L_G_COOKIESETTINGS); ?>
        <tr>
        	<?php if ($_POST['overwrite_cookie'] == '') $_POST['overwrite_cookie'] = AFF_OVERWRITE_COOKIE_DEFAULT; ?>
            <td><b><?php echo L_G_OVERWRITECOOKIES?></b>&nbsp<br>
            	<input type="radio" name="overwrite_cookie" value="<?php echo AFF_OVERWRITE_COOKIE_DEFAULT?>"
            		<?php echo ($_POST['overwrite_cookie'] == AFF_OVERWRITE_COOKIE_DEFAULT) ? 'checked' : ''?>>
            		<?php echo L_G_AFF_OVERWRITE_COOKIE_DEFAULT?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	<input type="radio" name="overwrite_cookie" value="<?php echo AFF_OVERWRITE_COOKIE_ON?>"
            		<?php echo ($_POST['overwrite_cookie'] == AFF_OVERWRITE_COOKIE_ON) ? 'checked' : ''?>>
            		<?php echo L_G_AFF_OVERWRITE_COOKIE_ON?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	<input type="radio" name="overwrite_cookie" value="<?php echo AFF_OVERWRITE_COOKIE_OFF?>"
            		<?php echo ($_POST['overwrite_cookie'] == AFF_OVERWRITE_COOKIE_OFF) ? 'checked' : ''?>>
            		<?php echo L_G_AFF_OVERWRITE_COOKIE_OFF?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
        <?php QUnit_Templates::printFilter(1, L_G_AFFILIATE_SETTINGS); ?>
        <tr>
            <td><b><?php echo L_G_STATUS?></b>&nbsp;
                <select name="status">
                    <option value="<?php echo AFFSTATUS_NOTAPPROVED?>" <?php echo ($_POST['status'] == AFFSTATUS_NOTAPPROVED) ? 'selected' : ''?>><?php echo L_G_PENDING?></option>
                    <option value="<?php echo AFFSTATUS_APPROVED?>"    <?php echo ($_POST['status'] == AFFSTATUS_APPROVED)    ? 'selected' : ''?>><?php echo L_G_APPROVED?></option>
                    <option value="<?php echo AFFSTATUS_SUPPRESSED?>"  <?php echo ($_POST['status'] == AFFSTATUS_SUPPRESSED)  ? 'selected' : ''?>><?php echo L_G_SUPPRESSED?></option>
                </select>&nbsp;
                <?php  if(($_POST['status'] == AFFSTATUS_APPROVED) && ($_POST['dateapproved'] != '')) { ?>
                        <?php echo L_G_APPROVEDAT.' '.$_POST['dateapproved']?>
                <?php  } ?>
                </td>
        </tr>
        <tr>
            <td><input type="checkbox" name="flags" value="<?php echo VIRTUAL_AFFILIATE?>"<?php echo ($_POST['flags'] == VIRTUAL_AFFILIATE)? 'checked' : ''?>>&nbsp;<?php echo L_G_VIRTUALAFFILIATE?>
                <?php showQuickHelp(L_G_VIRTUALAFFILIATEINFO); ?></td>
        </tr>
        </table>
        <?php if ($_POST['action'] == 'add' || ($_POST['action'] == 'edit' && $_POST['status'] == AFFSTATUS_NOTAPPROVED)) { ?>
            <table border=0 class=listing cellspacing=0 cellpadding=2 width=100% style="margin-top:2px;">
            <?php QUnit_Templates::printFilter(1, L_G_AFFILIATE_SIGNUP_OPTIONS); ?>
            <tr>
                <td><input type="checkbox" name="notifymail" value="yes"<?php echo ($_POST['notifymail'] == 'yes')? 'checked' : ''?>>&nbsp;<?php echo L_G_NOTIFYMAIL?>
                    <?php showQuickHelp(L_G_NOTIFYMAILINFO); ?></td>
            </tr>
<?php if ($_POST['action'] == 'add' && $GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1') { ?>            
            <tr>
                <td><?php echo L_G_ASSIGNAFFILIATETOCAMPAIGN?><?php showQuickHelp(L_G_HLP_ASSIGNAFFILIATETOCAMPAIGN); ?>
                	<select name="add_campaign_id">
            			<option value="_"><?php echo L_G_NONE?></option>
        			<?php while($data=$this->a_list_campaigns->getNextRecord()) { ?>
            			<option value="<?php echo $data['campaignid']?>" <?php echo ($_REQUEST['add_campaign_id'] == $data['campaignid'] ? 'selected' : '')?>>
            				<?php echo $data['campaignid'].': '.$data['name']?>
            			</option>
        			<?php } ?>      
        			</select>
                </td>
            </tr>
<?php } ?>
            </table>
        <?php } ?>
      </td>
      
      <td>
        <?php QUnit_Global::includeTemplate('user_edit_payout.tpl.php'); ?>
      </td>
    </tr>

    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateManager'>
      <input type=hidden name=action value=<?php echo $_POST['action']?>>
      <input type=hidden name=userid value=<?php echo $_POST['aid']?>>
      <input type=hidden name=aid value=<?php echo $_POST['aid']?>>
      <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
      <input type=hidden name=max_campaigns value="1">
      <input type=hidden name=prevwnd value="edit">
      <input type=button class=formbutton onclick="javascript:GoBack('<?php echo $_POST['prevwnd']?>')" value='<?php echo L_G_BACK; ?>'>
      <input type=submit class=formbutton value='<?php echo L_G_SUBMIT; ?>'>
      </td>
    </tr>
    </table>
    </form>
