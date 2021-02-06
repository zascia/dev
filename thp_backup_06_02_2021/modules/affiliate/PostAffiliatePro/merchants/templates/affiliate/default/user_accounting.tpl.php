    <table border=0 cellspacing=0 cellpadding=2 width=780>
    <tr><td><?php echo L_G_AFFILIATE_ACCOUNTING_DESCRIPTION?></td></tr>
    </table>
    <br><br>
    
    <table class=listing border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter(3, L_G_AFFDETAILS); ?>
    <tr>
      <td class=dir_form><?php echo L_G_USERNAME;?></td><td width=10></td>
      <td><?php echo $_POST['uname']?></td>
    </tr>
    <tr>
      <td class=dir_form><?php echo L_G_CONTACTNAME;?></td><td width=10></td>
      <td><?php echo $_POST['name'].' '.$_POST['surname']?></td>
    </tr>    
    <tr>
      <td class=dir_form><?php echo L_G_COMPANYNAME;?></td><td width=10></td>
      <td><?php echo $_POST['company_name']?></td>
    </tr>
    <tr>
      <td colspan=3 align=center><br><b><?php echo L_G_PAYOUTMETHOD?></b></td>
    </tr>
<?php
    while($data=$this->a_list_data2->getNextRecord())
    {
        if($_POST['payout_type'] == $data['payoptid'])
        {
            $payoutTypeSet = true;
    ?>
        <tr>
          <td colspan=3><hr></td>
        </tr>
        <tr>
          <td valign=top align=left class=formText colspan=4>&nbsp;&nbsp;&nbsp;&nbsp;
            <b><?php echo (defined($data['langid']) ? constant($data['langid']) : $data['name'])?></b>&nbsp;
          </td>
        </tr>
        <?php if(is_array($this->a_list_data3[$data['payoptid']])) {
             foreach($this->a_list_data3[$data['payoptid']] as $field) { ?>
               <tr>
                 <td class=formText>&nbsp;<?php echo (defined($field['langid']) ? constant($field['langid']) : $field['name'])?>&nbsp;</td>
                 <td width=10></td>
                 <td colspan=2><?php echo $_POST['field'.$field['payfieldid']]?>&nbsp;</td>
               </tr>
<?php           }
          }
       }
    }  ?>

<?php if(!$payoutTypeSet) { ?>
    <tr>
      <td colspan=3><hr></td>
    </tr>
    <tr>
      <td valign=top align=center colspan=3><font size=-2 color=#ff0000><?php echo L_G_NOTSET?></font></td>
    </tr>  
<?php } ?>    
    
    </table>
    <br>
    <table class=listing width=60% border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td align=center class=listheader colspan=7><b><?php echo L_G_AFFPAYMENTSLIST?></b></td>
    </tr>
    <tr class=listheader>
<?php
    QUnit_Templates::printHeader(L_G_ACCOUNTINGID);
    QUnit_Templates::printHeader(L_G_CREATED);
    QUnit_Templates::printHeader(L_G_PERIODFROM);
    QUnit_Templates::printHeader(L_G_PERIODTO);
    QUnit_Templates::printHeader(L_G_EXPORTFILES);
    QUnit_Templates::printHeader(L_G_PAIDTOTAL);
    QUnit_Templates::printHeader(L_G_NOTE);
?>  
    </tr>    
<?php
    while($data=$this->a_list_data1->getNextRecord())
    {
?>    
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult><?php echo $data['accountingid']?></td>
      <td class=listresult nowrap><?php echo $data['dateinserted']?></td>
      <td class=listresult nowrap><?php echo $data['datefrom']?></td>
      <td class=listresult nowrap><?php echo $data['dateto']?></td>
      <td class=listresult nowrap>&nbsp;
      <?php
        $export = '';
        if($data['paypalfile'])
        {
            if($export != '') $export .= ', ';
            $export .= L_G_FORPAYPAL;
        }
        else if($data['mbfile'])
        {
            if($export != '') $export .= ', ';
            $export .= L_G_FORMONEYBOOKERS;
        }
        else if($data['wirefile'])
        {
            if($export != '') $export .= ', ';
            $export .= L_G_CHECKWIRE;
        }
      
        print $export;
      ?>&nbsp;</td>
      <td class=listresultnocenter align=right nowrap>&nbsp;<?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['commission'])?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?php echo $data['note']?>&nbsp;</td>
    </tr>      
<?php
    }
?>
    </table>
    
    <br><br>
    <form action=''>
    <table width="60%" border=0 cellspacing=0 cellpadding=0>
    <tr align=center><td>
      <input type=button class=formbutton value='<?php echo L_G_BACK?>' onClick='javascript:history.go(-1);'>
    </td></tr>
    </table>
    </form>