        <table border=0 cellspacing=0 cellpadding=3>
        <tr>
          <td class=dir_form valign=top>
          <?php echo L_G_COOKIELIFETIME;?>
          </td>
          <td valign=top><input type=text name=cookielifetime size=2 value="<?php echo $_POST['cookielifetime']?>">*&nbsp;<?php echo L_G_DAYS?>&nbsp;&nbsp;<br>
          <?php showMsgNoBR(L_G_COOKIEMSG,'ok'); ?>
          </td>
          <td class=dir_form valign=top>&nbsp;</td>
          <td valign=top>&nbsp;</td>
        </tr>
        <tr>
          <td class=dir_form valign=top>
          <?php echo L_G_TRANSCLICKAPPROVAL;?>
          </td>
          <td valign=top>      
          <select name=clickapproval>
            <option value="<?php echo APPROVE_AUTOMATIC?>" <?php print ($_POST['clickapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?php echo L_G_AUTOMATIC?></option>
            <option value="<?php echo APPROVE_MANUAL?>" <?php print ($_POST['clickapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?php echo L_G_MANUAL?></option>
          </select>
          </td>
          <td class=dir_form valign=top>
          <?php echo L_G_TRANSSALEAPPROVAL;?>
          </td>
          <td valign=top>
          <select name=saleapproval>
            <option value="<?php echo APPROVE_AUTOMATIC?>" <?php print ($_POST['saleapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?php echo L_G_AUTOMATIC?></option>
            <option value="<?php echo APPROVE_MANUAL?>" <?php print ($_POST['saleapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?php echo L_G_MANUAL?></option>
          </select>
          &nbsp;&nbsp;
          </td>
        </tr>
        <tr>
          <td class=dir_form valign=top>
          <?php echo L_G_AFFILIATE_APPROVAL;?>
          </td>
          <td valign=top>      
          <select name=affapproval>
            <option value="<?php echo APPROVE_AUTOMATIC?>" <?php print ($_POST['affapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?php echo L_G_AUTOMATIC?></option>
            <option value="<?php echo APPROVE_MANUAL?>" <?php print ($_POST['affapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?php echo L_G_MANUAL?></option>
          </select>
          </td>
          <td class=dir_form valign=top>
          <?php echo L_G_STATUS;?>
          </td>
          <td valign=top>
          <select name=status>
            <option value="<?php echo AFF_CAMP_PUBLIC?>" <?php print ($_POST['status'] == AFF_CAMP_PUBLIC ? 'selected' : '');?>><?php echo L_G_PUBLIC?></option>
            <option value="<?php echo AFF_CAMP_PRIVATE?>" <?php print ($_POST['status'] == AFF_CAMP_PRIVATE ? 'selected' : '');?>><?php echo L_G_PRIVATE?></option>
          </select>
          &nbsp;&nbsp;
          </td>
        </tr>
        <tr>
          <td class=dir_form valign=top>
          <?php echo L_G_OVERWRITE_COOKIE;?>
          </td>
          <td valign=top>
          <input type=checkbox name=overwrite_cookie value='1' <?php echo ($_POST['overwrite_cookie'] == true ? ' checked' : '')?>>
          </td>
          <?php if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1') { ?>
            <td class=dir_form valign=top>
            <?php echo L_G_SIGNUP_BONUS;?>
            </td>
            <td valign=top>      
            <input type=text name=signup_bonus value="<?php echo $_POST['signup_bonus']?>">
            &nbsp;&nbsp;
            </td>
          <?php } else { ?>
            <td class=dir_form valign=top colspan=2>&nbsp;</td>
          <?php } ?>
        </tr>
        
<?php if($this->a_Auth->getSetting('Aff_forcecommfromproductid') == 'yes') { ?>         
        <tr>
          <td class=dir_form valign=top colspan=4>
          <?php echo L_G_ALLOWEDPRODUCTS?>&nbsp;<?php showPopupHelp(G_HLPALLOWEDPRODUCTS); ?>
          </td>
        </tr>
        <tr>
          <td class=dir_form valign=top colspan=4>
          <textarea name=products cols=86 rows=2><?php echo $_POST['products']?></textarea>
          </td>
        </tr>
<?php } ?>

        </table>
