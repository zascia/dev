    <table class=listing width=100% border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(4, L_G_PAYOUTMETHOD); ?>
<?php
    $this->fieldRow->resetRowParity();
    $selectedPayoutMethod = false;
    while($data=$this->a_list_data1->getNextRecord())
    {
        if($_POST['payout_type'] == $data['payoptid'])
        {
            $selectedPayoutMethod = true;
    ?>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td valign=top align=left class=formText colspan=4>&nbsp;&nbsp;&nbsp;&nbsp;
            <b><?php echo (defined($data['langid']) ? constant($data['langid']) : $data['name'])?></b>&nbsp;
          </td>
        </tr>
        <?php if(is_array($this->a_list_data2[$data['payoptid']])) {
             foreach($this->a_list_data2[$data['payoptid']] as $field) { ?>
               <?php echo  $this->fieldRow->trWithBgColor(); ?>
                 <td class=formText>&nbsp;<?php echo (defined($field['langid']) ? constant($field['langid']) : $field['name'])?>&nbsp;</td>
                 <td width=10></td>
                 <td colspan=2><?php echo $_POST['field'.$field['payfieldid']]?>&nbsp;</td>
               </tr>
<?php           }
          }
       }
    }

    if(!$selectedPayoutMethod)
    {
?>
        <tr>
          <td colspan=4 align=center><?php echo L_G_PAYOUTMETHODNOTSELECTED?></td>
        </tr>
<?php  }

    if($this->a_Auth->getSetting('Aff_min_payout_options') != '')
    {
?>
    <tr><td class=settingsLine colspan=4><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
    
    <?php $this->fieldRow->resetRowParity(); ?>
    <?php echo  $this->fieldRow->trWithBgColor(); ?>
      <td valign=top align=left class=formText colspan=4>&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo L_G_PAYOUT_STATS;?></b>&nbsp;</td>
    </tr>
    <?php echo  $this->fieldRow->trWithBgColor(); ?>
      <td class=formText>&nbsp;<?php echo L_G_PAID;?>&nbsp;</td>
      <td width=10></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->transData[$_POST['aid']]['paid']);?>&nbsp;</td>
      <td></td>
    </tr>
    <?php echo  $this->fieldRow->trWithBgColor(); ?>
      <td class=formText>&nbsp;<?php echo L_G_WAITINGAPPROVAL;?>&nbsp;</td>
      <td width=10></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->transData[$_POST['aid']]['pending']);?>&nbsp;</td>
      <td></td>
    </tr>
    <?php echo  $this->fieldRow->trWithBgColor(); ?>
      <td class=formText>&nbsp;<?php echo L_G_APPROVED;?>&nbsp;</td>
      <td width=10></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->transData[$_POST['aid']]['approved']);?>&nbsp;</td>
      <td></td>
    </tr>
    <?php echo  $this->fieldRow->trWithBgColor(); ?>
      <td class=formText>&nbsp;<?php echo L_G_SUPPRESSED;?>&nbsp;</td>
      <td width=10></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->transData[$_POST['aid']]['reversed']);?>&nbsp;</td>
      <td></td>
    </tr>

    <tr><td class=settingsLine colspan=4><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
    <tr>
      <td class=formText>&nbsp;<b><?php echo L_G_MINPAYOUT;?></b>&nbsp;</td><td width=10></td>
      <td colspan=2><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(($_POST['minpayout'] == '' ? '0' : $_POST['minpayout']))?>&nbsp;</td>
    </tr>
<?php } ?>
  </table>
