<table width=100% border=0 cellspacing=0 cellpadding=2>
    <?php echo  $this->fieldRow->getFieldRow('refid', L_G_REFID)?>
    <?php echo  $this->fieldRow->trWithBgColor(); ?>
      <td class=formText>&nbsp;<b><?php echo L_G_USERNAME;?></b>&nbsp;</td><td width=10></td>
      <td><?php echo $_POST['uname']?>&nbsp;</td>
    </tr>
    <?php echo  $this->fieldRow->getFieldRow('name', L_G_NAME)?>
    <?php echo  $this->fieldRow->getFieldRow('surname', L_G_SURNAME)?>
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
    <?php if (!empty($_POST['lastlogindate'])) { ?>
        <?php echo  $this->fieldRow->trWithBgColor();?><td colspan="2"><?php echo L_G_LASTLOGINDATE?></td><td align="left"><?php echo $_POST['lastlogindate']?></td></tr>
        <?php echo  $this->fieldRow->trWithBgColor();?><td colspan="2"><?php echo L_G_LOGINCOUNT?></td><td align="left"><?php echo $_POST['logincount']?></td></tr>
    <?php } ?>
    <tr>
      <td colspan=3>&nbsp;</td>
    </tr>
    </table>
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align=left><a class=SimpleLink href=index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=view&aid=<?php echo $_POST['aid']?>><b><?php echo L_G_VIEWPROFILE?></b></a></td>
    <td align="right"><a class="SimpleLink" href=<?php echo  '"index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=edit&aid='.$_POST['aid'].'"' ?>><b><?php echo  L_G_EDIT?></b></a></td></tr>
<tr><td align="left"><a class="SimpleLink" href=<?php echo '"index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all&list_page=0&action=&sortby=&sortorder=&tm_advanced_filter_show=1&tm_userid='.$_POST['aid'].'&transtype_comitted=1&tm_transtype%5B%5D=32&tm_transtype%5B%5D=1&tm_transtype%5B%5D=2&tm_transtype%5B%5D=4&tm_transtype%5B%5D=8&status_comitted=1&tm_status%5B%5D=1&tm_status%5B%5D=2&tm_status%5B%5D=3&tm_orderid=&tm_custom1=productid&tm_custom1data=&tm_custom2=productid&tm_custom2data=&tm_timeselect=1&tm_timepreset=10&numrows=20&list_view=_"'?>><b><?php echo  L_G_VIEW_TRANSACTIONS?></b></a></td>
    <td align="right"><a class=SimpleLink href=index.php?md=Affiliate_Merchants_Views_BroadcastMessage&userid=<?php echo $_POST['aid']?>><b><?php echo L_G_SENDEMAIL?></b></a></td></tr>
</table>
