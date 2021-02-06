  <table border=0 cellspacing=0 cellpadding=2 width=780>
  <tr><td><?php echo L_G_TRANSACTION_CREATE_DESCRIPTION?></td></tr>
  </table>
  <br><br>
    
  <form id=FilterForm name=FilterForm action=index.php method=post>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <?php QUnit_Templates::printFilter(3, L_G_CREATETRANSACTION); ?>
    <tr>
      <td colspan=2>
        <?php QUnit_Global::includeTemplate('filter_affiliate.tpl.php'); ?>
      </td>
    </tr>
    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_FOR?> <?php echo L_G_CAMPAIGN?></td>
     <td align=left>
        <select name=<?php echo $this->a_form_preffix?>campaignid>
<?php      while($data=$this->a_list_data1->getNextRecord()) { ?>
          <option value='<?php echo $data['campaignid']?>' <?php echo ($_REQUEST[$this->a_form_preffix.'campaignid'] == $data['campaignid'] ? 'selected' : '')?>><?php echo $data['name']?></option>
<?php      } ?>
      </select>
     </td>
    </tr>

    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_TYPE?></td>
     <td align=left>
        <?php $this->a_Auth->getCommissionTypeSelect($this->a_form_preffix.'transtype', $_REQUEST[$this->a_form_preffix.'transtype'], false, false, false, false); ?>
     </td>
    </tr>

    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_TOTALCOST?></td>
     <td align=left>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
        <input type=text name=<?php echo $this->a_form_preffix?>totalcost size=6 value='<?php echo $_POST[$this->a_form_preffix.'totalcost']?>'>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
             print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
     </td>
    </tr>

    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_ORDERID?></td>
     <td align=left>
        <input type=text name=<?php echo $this->a_form_preffix?>orderid size=30 value='<?php echo $_POST[$this->a_form_preffix.'orderid']?>'>
     </td>
    </tr>

    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_PRODUCTID?></td>
     <td align=left>
        <input type=text name=<?php echo $this->a_form_preffix?>productid size=30 value='<?php echo $_POST[$this->a_form_preffix.'productid']?>'>
     </td>
    </tr>
    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_DATA1?></td>
     <td align=left>
        <input type=text name=<?php echo $this->a_form_preffix?>data1 size=30 maxlength=80 value='<?php echo $_POST[$this->a_form_preffix.'data1']?>'>
     </td>
    </tr>
    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_DATA2?></td>
     <td align=left>
        <input type=text name=<?php echo $this->a_form_preffix?>data2 size=30 maxlength=80 value='<?php echo $_POST[$this->a_form_preffix.'data2']?>'>
     </td>
    </tr>
    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_DATA3?></td>
     <td align=left>
        <input type=text name=<?php echo $this->a_form_preffix?>data3 size=30 maxlength=80 value='<?php echo $_POST[$this->a_form_preffix.'data3']?>'>
     </td>
    </tr>

    <tr>
      <td colspan=2>&nbsp;</td>
    </tr>

    <tr>
     <td align=left nowrap colspan=2>
     <table border=0 cellspacing=0 cellpadding=2>
     <tr>
       <td valign=top><input type=radio name=<?php echo $this->a_form_preffix?>createtype value=manual <?php echo ($_POST[$this->a_form_preffix.'createtype'] == 'manual' ? 'checked' : '')?>></td>
       <td align=left nowrap colspan=2>
        <b><?php echo L_G_TRANSCREATEMANUALLY?></b>
        <br>
        <?php echo L_G_HLPCREATETRANSACTION?>
       </td>
     </tr>
     <tr>
       <td></td>
       <td align=left nowrap>
        <?php echo L_G_COMMISSION?>
       </td>
       <td align=left nowrap>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
        <input type=text name=<?php echo $this->a_form_preffix?>commission size=6 value='<?php echo $_POST[$this->a_form_preffix.'commission']?>'>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
             print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
       </td>
     </tr>
     <tr>
       <td></td>
       <td align=left valign=top nowrap>
        <?php echo L_G_STATUS?>
       </td>
       <td align=left nowrap>
        <select name=<?php echo $this->a_form_preffix?>rstatus>
          <option value=<?php echo AFFSTATUS_NOTAPPROVED?> <?php print ($_REQUEST[$this->a_form_preffix.'rstatus'] == AFFSTATUS_NOTAPPROVED ? 'selected' : '');?>><?php echo L_G_WAITINGAPPROVAL?></option>
          <option value=<?php echo AFFSTATUS_APPROVED?> <?php print ($_REQUEST[$this->a_form_preffix.'rstatus'] == AFFSTATUS_APPROVED ? 'selected' : '');?>><?php echo L_G_APPROVED?></option>
          <option value=<?php echo AFFSTATUS_SUPPRESSED?> <?php print ($_REQUEST[$this->a_form_preffix.'rstatus'] == AFFSTATUS_SUPPRESSED ? 'selected' : '');?>><?php echo L_G_SUPPRESSED?></option>
        </select>
        <br><br>
       </td>

     </tr>
     <tr>
       <td valign=top><input type=radio name=<?php echo $this->a_form_preffix?>createtype value=auto <?php echo ($_POST[$this->a_form_preffix.'createtype'] == 'auto' ? 'checked' : '')?>></td>
       <td align=left nowrap colspan=2>
        <b><?php echo L_G_TRANSCREATEAUTOMATICALLY?></b>
        <br>
        <?php echo L_G_HLPTRANSCREATEAUTOMATICALLY?>
       </td>
     </tr>
     </table>
     <br><br>
     </td>
    </tr>      

    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_TransactionManager'>
      <input type=hidden name=action value='create'>
      <input type=hidden name=postaction value='create'>
      <input class=formbutton type=submit value="<?php echo L_G_CREATE?>">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
