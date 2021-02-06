<?php
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Settings');
?>
    <table class=listing border=0 cellspacing=0 cellpadding=1 width="780">
    <tr>
      <td class=listheader colspan=11 align=center><?php echo L_G_ACCOUNTINGRECORDS?>&nbsp;<?php print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
    </tr>
    <tr class=listheader>
<?php
    QUnit_Templates::printHeader(L_G_ACCOUNTINGID, 'accountingid');
    QUnit_Templates::printHeader(L_G_CREATED, 'dateinserted');
    QUnit_Templates::printHeader(L_G_PERIODFROM, 'datefrom');
    QUnit_Templates::printHeader(L_G_PERIODTO, 'dateto');
    QUnit_Templates::printHeader(L_G_PAIDTOTAL);
    QUnit_Templates::printHeader(L_G_ACTIONS);
    QUnit_Templates::printHeader(L_G_NOTE, 'note');
?>
    </tr>
<?php
    while($data=$this->a_list_data->getNextRecord())
    {
?>
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult><?php echo $data['accountingid']?></td>
      <td class=listresult nowrap><?php echo $data['dateinserted']?></td>
      <td class=listresult nowrap><?php echo $data['datefrom']?></td>
      <td class=listresult nowrap><?php echo $data['dateto']?></td>
      <td class=listresultnocenter align=right nowrap>&nbsp;<?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['paid']))?>&nbsp;</td>
      <?php $this->a_this->printListRowActions($data);?>
      <td class=listresult nowrap>&nbsp;<?php echo $data['note']?>&nbsp;</td>
    </tr>
<?php
    }
?>
  </table>
  </form>
