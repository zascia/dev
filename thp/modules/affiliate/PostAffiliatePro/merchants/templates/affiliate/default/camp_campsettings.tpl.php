<table border=0 cellspacing=0 cellpadding=3 width="100%">
        <tr class="detailrow0">
          <td class=dir_form valign=top nowrap>
          <?php echo L_G_COOKIELIFETIME;?>
          </td>
          <td valign=top width="35%"><input class="forminput" type=text name=cookielifetime size=2 value="<?php echo $_POST['cookielifetime']?>">*&nbsp;<?php echo L_G_DAYS?>&nbsp;&nbsp;<br>
          <?php showMsgNoBR(L_G_COOKIEMSG,'ok'); ?>
          </td>
          <td class=dir_form valign=top>&nbsp;</td>
          <td valign=top width="35%">&nbsp;</td>
        </tr>
        <tr class="detailrow0">
          <td class=dir_form valign=top nowrap>
          <?php echo L_G_TRANSCLICKAPPROVAL;?>
          </td>
          <td valign=top>      
          <select class="forminput" name=clickapproval>
            <option value="<?php echo APPROVE_AUTOMATIC?>" <?php print ($_POST['clickapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?php echo L_G_AUTOMATIC?></option>
            <option value="<?php echo APPROVE_MANUAL?>" <?php print ($_POST['clickapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?php echo L_G_MANUAL?></option>
          </select>
          </td>
          <td class=dir_form valign=top nowrap>
          <?php echo L_G_TRANSSALEAPPROVAL;?>
          </td>
          <td valign=top>
          <select class="forminput" name=saleapproval>
            <option value="<?php echo APPROVE_AUTOMATIC?>" <?php print ($_POST['saleapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?php echo L_G_AUTOMATIC?></option>
            <option value="<?php echo APPROVE_MANUAL?>" <?php print ($_POST['saleapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?php echo L_G_MANUAL?></option>
          </select>
          &nbsp;&nbsp;
          </td>
        </tr>
        <?php if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1') { ?>
        <tr class="detailrow0">
          <td class=detailrow0 valign=top nowrap>
          <?php echo L_G_AFFILIATE_APPROVAL;?>
          </td>
          <td class="detailrow0" valign=top>      
          <select class="forminput" name=affapproval>
            <option value="<?php echo APPROVE_AUTOMATIC?>" <?php print ($_POST['affapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?php echo L_G_AUTOMATIC?></option>
            <option value="<?php echo APPROVE_MANUAL?>" <?php print ($_POST['affapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?php echo L_G_MANUAL?></option>
          </select>
          </td>
          <td class="detailrow0" valign=top nowrap><?php echo L_G_STATUS;?></td>
          <td class="detailrow0" valign=top>
            <select class="forminput" name=status>
              <option value="<?php echo AFF_CAMP_PUBLIC?>" <?php print ($_POST['status'] == AFF_CAMP_PUBLIC ? 'selected' : '');?>><?php echo L_G_PUBLIC?></option>
              <option value="<?php echo AFF_CAMP_PRIVATE?>" <?php print ($_POST['status'] == AFF_CAMP_PRIVATE ? 'selected' : '');?>><?php echo L_G_PRIVATE?></option>
            </select>
            &nbsp;&nbsp;
          </td>
        </tr>
        <tr>
          <td class="detailrow0" class=dir_form valign=top><?php echo L_G_SIGNUP_BONUS?></td>
          <td class="detailrow0" valign=top>
          <?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
                print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
          ?>
          <input class="forminput" type=text name=signup_bonus size=5 value="<?php echo $_POST['signup_bonus']?>">
          <?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
                print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
          ?>
          </td>
          <td class="detailrow0" colspan=2>&nbsp;</td>
        </tr>
        <?php } ?>
        
<?php if($this->a_Auth->getSetting('Aff_forcecommfromproductid') == 'yes') { ?>         
        <tr class="detailrow<?php echo ($_rc = 1 - $_rc)?>">
          <td class=dir_form valign=top colspan=4>
          <?php echo L_G_ALLOWEDPRODUCTS?>&nbsp;<?php showQuickHelp(L_G_HLPALLOWEDPRODUCTS); ?>
          </td>
        </tr>
        <tr class="detailrow<?php echo ($_rc = 1 - $_rc)?>">
          <td class=dir_form valign=top colspan=4>
          <textarea name=products cols=86 rows=2><?php echo $_POST['products']?></textarea>
          </td>
        </tr>
<?php } ?>

        </table>