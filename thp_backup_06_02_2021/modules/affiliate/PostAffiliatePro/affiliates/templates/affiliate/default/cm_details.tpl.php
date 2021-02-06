<?php
$data=$this->a_list_data->getNextRecord();
?>
<center>
<table width=100% border=0 cellspacing=0 cellpadding=5>
    <tr>
      <td class=formBText>&nbsp;<?php echo L_G_CAMPAIGNTYPE;?>&nbsp;</td>
      <td class=formText>
      <?php
        print $this->a_Auth->getComposedCommissionTypeString($data['commtype']);
      ?> &nbsp;
      </td>
    </tr>
    <tr>
      <td class=formBText valign=top>&nbsp;<?php echo L_G_COMMISSIONS;?>&nbsp;</td>
      <td class=formText>
        <?php $this->a_this->drawCommissionField($data, false, true); ?>
      </td>
    </tr>
</table>
</center>
