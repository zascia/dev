<script>
function ChangeState(ID, action)
{
  if(action == "suppress")
  {
    if(confirm("<?php echo L_G_CONFIRMSUPPRESSAFF?>"))
     	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&aid="+ID+"&action="+action+"&prevwnd=view&<?php echo SID?>";
  }
  else if(action == "approve")
  {
    if(confirm("<?php echo L_G_CONFIRMAPPROVEAFF?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&aid="+ID+"&action="+action+"&prevwnd=view&<?php echo SID?>";
  }
}
</script>

    <?php $this->fieldRow->setTdParams(' class=formText'); ?>
    <table border=0 cellspacing=0 cellpadding=2 width=780>
    <tr><td><?php echo L_G_AFFILIATE_VIEW_DESCRIPTION?></td></tr>
    </table>
    <br><br>

    <table border=0 class=listing cellspacing=0 cellpadding=2 align=left width=780>
    <tr valign="top">
      <td width=50%>

        <table class=listing width=100% border=0 cellspacing=0 cellpadding=2>
        <?php QUnit_Templates::printFilter(3, L_G_AFFILIATEPROFILE); ?>
        <?php echo  $this->fieldRow->getFieldRow('refid', L_G_REFID)?>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText>&nbsp;<b><?php echo L_G_USERNAME;?></b>&nbsp;</td><td width=10></td>
          <td><?php echo $_POST['uname']?>&nbsp;</td>
        </tr>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText>&nbsp;<b><?php echo L_G_PWD1;?></b>&nbsp;</td><td width=10></td>
          <td><?php echo $_POST['pwd1']?>&nbsp;</td>
        </tr>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText>&nbsp;<b><?php echo L_G_NAME;?></b>&nbsp;</td><td width=10></td>
          <td><?php echo $_POST['name']?>&nbsp;</td>
        </tr>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText>&nbsp;<b><?php echo L_G_SURNAME;?></b>&nbsp;</td><td width=10></td>
          <td><?php echo $_POST['surname']?>&nbsp;</td>
        </tr>
        <?php echo  $this->fieldRow->getFieldRow('company_name', L_G_COMPANYNAME)?>
        <?php echo  $this->fieldRow->getFieldRow('weburl', L_G_WEBURL)?>
        <?php echo  $this->fieldRow->getFieldRow('street', L_G_STREET)?>
        <?php echo  $this->fieldRow->getFieldRow('city', L_G_CITY)?>
        <?php echo  $this->fieldRow->getFieldRow('state', L_G_STATE)?>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText>&nbsp;<b><?php echo L_G_COUNTRY;?></b>&nbsp;</td><td width=10></td>
          <td><?php echo $_POST['country']?>&nbsp;</td>
        </tr>
        <?php echo  $this->fieldRow->getFieldRow('zipcode', L_G_ZIPCODE)?>
        <?php echo  $this->fieldRow->getFieldRow('phone', L_G_PHONE)?>
        <?php echo  $this->fieldRow->getFieldRow('fax', L_G_FAX)?>
        <?php echo  $this->fieldRow->getFieldRow('tax_ssn', L_G_TAXSSN)?>
        <?php echo  $this->fieldRow->getFieldRow('data1', $this->fieldRow->settings['Aff_signup_data1_name'])?>
        <?php echo  $this->fieldRow->getFieldRow('data2', $this->fieldRow->settings['Aff_signup_data2_name'])?>
        <?php echo  $this->fieldRow->getFieldRow('data3', $this->fieldRow->settings['Aff_signup_data3_name'])?>
        <?php echo  $this->fieldRow->getFieldRow('data4', $this->fieldRow->settings['Aff_signup_data4_name'])?>
        <?php echo  $this->fieldRow->getFieldRow('data5', $this->fieldRow->settings['Aff_signup_data5_name'])?>
        <tr>
          <td colspan=3>&nbsp;</td>
        </tr>
        </table>
      </td>

      <td>
        <?php QUnit_Global::includeTemplate('user_stats.tpl.php'); ?>

        <table border=0 class=listing cellspacing=0 cellpadding=2 width=100% style="margin-bottom: 4px">
        <?php QUnit_Templates::printFilter(1, 'Actions'); ?>
        <tr>
          <td><a class="mainlink" href=<?php echo  '"index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=edit&aid='.$_POST['aid'].'"' ?>><b><?php echo  L_G_EDIT?></b></a></td>
        </tr>
        <tr>
          <td><a class="mainlink" href=<?php echo '"index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all&list_page=0&action=&sortby=&sortorder=&tm_advanced_filter_show=1&tm_userid='.$_POST['aid'].'&transtype_comitted=1&tm_transtype%5B%5D=32&tm_transtype%5B%5D=1&tm_transtype%5B%5D=2&tm_transtype%5B%5D=4&tm_transtype%5B%5D=8&status_comitted=1&tm_status%5B%5D=1&tm_status%5B%5D=2&tm_status%5B%5D=3&tm_orderid=&tm_custom1=productid&tm_custom1data=&tm_custom2=productid&tm_custom2data=&tm_timeselect=1&tm_timepreset=10&numrows=20&list_view=_"'?>><b><?php echo  L_G_VIEW_TRANSACTIONS?></b></a></td>
        </tr>  
        <tr>
          <?php if ($_POST['status'] == AFFSTATUS_APPROVED) { ?>
            <td><a class="mainlink" href="JavaScript:ChangeState('<?php echo $_POST['aid']?>','suppress');"><b><?php echo  L_G_SUPPRESS ?></b></a></td>
          <?php } else { ?>
            <td><a class="mainlink" href="JavaScript:ChangeState('<?php echo $_POST['aid']?>','approve');"><b><?php echo  L_G_APPROVE ?></b></a></td>
          <?php } ?>
        </tr>
        </table>
        
        <?php QUnit_Global::includeTemplate('user_view_payout.tpl.php'); ?>
      </td>
    </tr>
    <tr>
      <td class=formText colspan=2 align=center>
      <form action="">
        <input type=button class=formbutton value='<?php echo L_G_BACK?>' onClick='javascript:history.go(-1);'>
      </form>
      </td>
    </tr>
    </table>
