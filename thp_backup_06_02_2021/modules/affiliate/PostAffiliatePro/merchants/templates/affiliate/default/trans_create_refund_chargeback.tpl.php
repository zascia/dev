  
  <table border=0 cellspacing=0 cellpadding=2 width=780>
  <tr><td><?php echo L_G_TRANSACTION_CREATE_REFUND_CHARGEBACK_DESCRIPTION?></td></tr>
  </table>
  <br><br>
    
  <form id=FilterForm name=FilterForm action=index.php method=post>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <?php QUnit_Templates::printFilter(3, L_G_CREATEREFUNDCHARGEBACKTRANSACTION); ?>
    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_FOR?> <?php echo L_G_AFFILIATE?></td>
     <td align=left>
        <input type="hidden" name="tm_userid" value="<?php echo $_POST['tm_userid']?>">
        <input type="hidden" name="affiliatename" value="<?php echo $_POST['affiliatename']?>">
        <?php echo $_POST['affiliatename']?>
        <input type="hidden" name="tm_campaignid" value="<?php echo $_POST['tm_campaignid']?>">
        <input type="hidden" name="tm_campaignname" value="<?php echo $_POST['tm_campaignname']?>">
     </td>
    </tr>
    
    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_TYPE?>&nbsp;<?php showQuickHelp(L_G_HLP_REFUND_CHARGEBACK_TYPE); ?></td>
     <td align=left>
        <input type="radio" name="tm_transtype" value="<?php echo TRANSTYPE_REFUND?>" <?php echo (($_REQUEST['tm_transtype'] == TRANSTYPE_REFUND) ? 'checked' : '')?>>
          <?php echo L_G_REFUND?><br>
        <input type="radio" name="tm_transtype" value="<?php echo TRANSTYPE_CHARGEBACK?>" <?php echo (($_REQUEST['tm_transtype'] == TRANSTYPE_CHARGEBACK) ? 'checked' : '')?>>
          <?php echo L_G_CHARGEBACK?>
     </td>
    </tr>   

    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_TOTALCOST?>&nbsp;<?php showQuickHelp(L_G_HLP_TOTALCOST); ?></td>
     <td align=left>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
        <input type=text name=tm_totalcost size=6 value='<?php echo $_POST['tm_totalcost']?>'>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
             print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
     </td>
    </tr>      

    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_ORDERID?></td>
     <td align=left>
        <input type=text name=tm_orderid size=30 value='<?php echo $_POST['tm_orderid']?>'>
     </td>
    </tr>

    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_PRODUCTID?></td>
     <td align=left>
        <input type=text name=tm_productid size=30 value='<?php echo $_POST['tm_productid']?>'>
     </td>
    </tr>
    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_DATA1?></td>
     <td align=left>
        <input type=text name=tm_data1 size=30 maxlength=80 value='<?php echo $_POST['tm_data1']?>'>
     </td>
    </tr>
    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_DATA2?></td>
     <td align=left>
        <input type=text name=tm_data2 size=30 maxlength=80 value='<?php echo $_POST['tm_data2']?>'>
     </td>
    </tr>
    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_DATA3?></td>
     <td align=left>
        <input type=text name=tm_data3 size=30 maxlength=80 value='<?php echo $_POST['tm_data3']?>'>
     </td>
    </tr>
    
    <tr>
      <td align=left nowrap>
        <?php echo L_G_COMMISSION?>&nbsp;<?php showQuickHelp(L_G_HLP_COMMISSION); ?>
      </td>
      <td align=left nowrap>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
        <input type=text name=tm_commission size=6 value='<?php echo $_POST['tm_commission']?>'>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
             print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
      </td>
    </tr>

    <tr>
      <td colspan=2 align=center>
      <input type=hidden name=tm_rstatus value=<?php echo AFFSTATUS_APPROVED?>>
      <input type=hidden name=tm_createtype value=manual>
      <input type=hidden name=tid value='<?php echo $_REQUEST['tid']?>'>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_TransactionManager'>
      <input type=hidden name=action value='createrefundchargeback'>
      <input type=hidden name=postaction value='create'>
      <input class=formbutton type=submit value="<?php echo L_G_CREATE?>">     
      </td>
    </tr> 
    </table>
 </td>
 </tr>
 </table>
 </form>
