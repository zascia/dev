  <form action=index.php method=post>
  <table border=0>
  <tr>
    <td align=center>
      <table class=listing width=100% border=0 cellspacing=0 cellpadding=3>
      <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
      <tr>
        <td align=center>
        <table border=0 cellspacing=0 cellpadding=3>
        <tr>
          <td class=formBText colspan=4 valign=top align=left><?php echo L_G_PCNAME;?>&nbsp;&nbsp;
            <input type=text name=cname size=44 value="<?php echo $_POST['cname']?>">*
          </td>
        </tr>
        <tr>
          <td colspan=4>&nbsp;</td>
        </tr>
        <tr>
          <td class=formText colspan=4 valign=top align=left><?php echo L_G_BANNERSURL;?>&nbsp;&nbsp;
            <input type=text name=banner_url size=44 value="<?php echo $_POST['banner_url']?>">
          </td>
        </tr>
        <tr>
          <td colspan=4>&nbsp;</td>
        </tr>
        <tr>
          <td colspan=4 align=left valign=top><?php echo L_G_SHORTDESCRIPTION?>&nbsp;&nbsp;
            <input type=text name=shortdescription size=44 value='<?php echo $_POST['shortdescription']?>'>
          </td>
        </tr>
        <tr>
          <td class=formText valign=top align=left><?php echo L_G_DESCRIPTION;?>&nbsp;&nbsp;</td>
          <td class=formText colspan=3 valign=top align=left>
            <textarea name=description cols=70 rows=4><?php echo $_POST['description']?></textarea>
          </td>
        </tr>
        <tr>
          <td colspan=4>&nbsp;</td>
        </tr>
        <tr>
          <td class=formText valign=top>
          <?php echo L_G_COOKIELIFETIME;?>
          </td>
          <td valign=top><input type=text name=cookielifetime size=2 value="<?php echo $_POST['cookielifetime']?>">*&nbsp;<?php echo L_G_DAYS?>&nbsp;&nbsp;<br>
          <?php showMsgNoBR(L_G_COOKIEMSG,'ok'); ?>
          </td>
          <td align=left valign=top nowrap>
            <b><?php echo L_G_CAMPAIGNTYPE;?></b>
          </td>
          <td align=left valign=top>
            <table border=0 cellspacing=1 cellpadding=0>
            <?php if($this->a_Auth->getSetting('Aff_support_cpm_commissions') == '1') { ?>
            <tr>
                <td><input type=checkbox name="commtype[]" value="<?php echo TRANSTYPE_CPM?>" <?php echo (is_array($_POST['commtype']) ? (in_array(TRANSTYPE_CPM, $_POST['commtype']) ? 'checked' : '') : '')?>></td>
                <td>&nbsp;<?php echo L_G_TYPECPM?></td>
            </tr>
            <?php } ?>
            <?php if($this->a_Auth->getSetting('Aff_support_click_commissions') == '1') { ?>
            <tr>
                <td><input type=checkbox name="commtype[]" value="<?php echo TRANSTYPE_CLICK?>" <?php echo (is_array($_POST['commtype']) ? (in_array(TRANSTYPE_CLICK, $_POST['commtype']) ? 'checked' : '') : '')?>></td>
                <td>&nbsp;<?php echo L_G_PERCLICK?></td>
            </tr>
            <?php } ?>
            <?php if($this->a_Auth->getSetting('Aff_support_sale_commissions') == '1' && $this->a_Auth->getSetting('Aff_support_lead_commissions') == '1') { ?>
            <tr>
                <td><input type=checkbox name="commtype[]" value="_" <?php echo (is_array($_POST['commtype']) ? (in_array('_', $_POST['commtype']) ? 'checked' : '') : '')?>></td>
                <td><select name="commtype2">
                    <option value="<?php echo TRANSTYPE_SALE?>" <?php echo ($_POST['commtype2'] == TRANSTYPE_SALE ? 'selected' : '')?>><?php echo L_G_PERSALE?></option>
                    <option value="<?php echo TRANSTYPE_LEAD?>" <?php echo ($_POST['commtype2'] == TRANSTYPE_LEAD ? 'selected' : '')?>><?php echo L_G_PERLEAD?></option>
                    </select>
                </td>
            </tr>
            <?php } else if($this->a_Auth->getSetting('Aff_support_sale_commissions') == '1') { ?>
            <tr>
                <td><input type=checkbox name="commtype[]" value="_" <?php echo (is_array($_POST['commtype']) ? (in_array('_', $_POST['commtype']) ? 'checked' : '') : '')?>></td>
                <td>&nbsp;<?php echo L_G_PERSALE?><input type=hidden name="commtype2" value="<?php echo TRANSTYPE_SALE?>"></td>
            </tr>
            <?php } else if($this->a_Auth->getSetting('Aff_support_lead_commissions') == '1') { ?>
            <tr>
                <td><input type=checkbox name="commtype[]" value="_" <?php echo (is_array($_POST['commtype']) ? (in_array('_', $_POST['commtype']) ? 'checked' : '') : '')?>></td>
                <td>&nbsp;<?php echo L_G_PERLEAD?><input type=hidden name="commtype2" value="<?php echo TRANSTYPE_LEAD?>"></td>
            </tr>
            <?php } ?>
            </table>
          </td>
        </tr>
        <tr>
          <td class=formText valign=top>
          <?php echo L_G_TRANSCLICKAPPROVAL;?>
          </td>
          <td valign=top>
          <select name=clickapproval>
            <option value="<?php echo APPROVE_AUTOMATIC?>" <?php print ($_POST['clickapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?php echo L_G_AUTOMATIC?></option>
            <option value="<?php echo APPROVE_MANUAL?>" <?php print ($_POST['clickapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?php echo L_G_MANUAL?></option>
          </select>
          </td>
          <td class=formText valign=top>
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
          <td class=formText valign=top>
          <?php echo L_G_AFFILIATE_APPROVAL;?>
          </td>
          <td valign=top>
          <select name=affapproval>
            <option value="<?php echo APPROVE_AUTOMATIC?>" <?php print ($_POST['affapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?php echo L_G_AUTOMATIC?></option>
            <option value="<?php echo APPROVE_MANUAL?>" <?php print ($_POST['affapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?php echo L_G_MANUAL?></option>
          </select>
          </td>
          <?php if($this->a_Auth->getSetting('Aff_join_campaign') == '1') { ?>
          <td class=formText valign=top><?php echo L_G_STATUS;?></td>
          <td valign=top>
            <select name=status>
              <option value="<?php echo AFF_CAMP_PUBLIC?>" <?php print ($_POST['status'] == AFF_CAMP_PUBLIC ? 'selected' : '');?>><?php echo L_G_PUBLIC?></option>
              <option value="<?php echo AFF_CAMP_PRIVATE?>" <?php print ($_POST['status'] == AFF_CAMP_PRIVATE ? 'selected' : '');?>><?php echo L_G_PRIVATE?></option>
            </select>
            &nbsp;&nbsp;
          </td>
          <?php } else { ?>
          <td colspan=2>&nbsp;</td>
          <?php } ?>
        </tr>
        <?php if($this->a_Auth->getSetting('Aff_join_campaign') == '1') { ?>
        <tr>
          <td class=formText valign=top><?php echo L_G_SIGNUP_BONUS;?></td>
          <td valign=top colspan=3>
            <input type=text name=signup_bonus value="<?php echo $_POST['signup_bonus']?>">
          </td>
        </tr>
        <?php } ?>
<?php if($this->a_Auth->getSetting('Aff_forcecommfromproductid') == 'yes') { ?>
        <tr>
          <td class=formText valign=top colspan=4>
          <?php echo L_G_ALLOWEDPRODUCTS?>&nbsp;<?php showPopupHelp(G_HLPALLOWEDPRODUCTS); ?>
          </td>
        </tr>
        <tr>
          <td class=formText valign=top colspan=4>
          <textarea name=products cols=86 rows=2><?php echo $_POST['products']?></textarea>
          </td>
        </tr>
<?php } ?>

        </table>
        </td>
      </tr>

<?php
if($_POST['action'] != 'add')
{
    echo $this->a_commissions;
}
?>
        <tr>
          <td colspan=4 align=center >
             <input type=hidden name=commited value=yes>
             <input type=hidden name=md value='Affiliate_Merchants_Views_CampaignManager'>
             <input type=hidden name=action value=<?php echo $_POST['action']?>>
             <input type=hidden name=cid value=<?php echo $_POST['cid']?>>
             <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
             <input class=formbutton type=submit value='<?php echo L_G_SUBMIT; ?>'>
          </td>
        </tr>
      </table>

      </form>

<?php if($_POST['postaction'] != 'addcampaign') { ?>
      <br>
      <table class=tableresult width=100% border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=header align=center colspan=2><?php echo L_G_COMMISIONS?></td>
      </tr>
      <tr>
        <td align=center>
<?php
echo $this->a_campcategories;
?>
        </td>
      </tr>
      </table>
      <br><br>

<?php } ?>

    </td>
  </tr>
  </table>


