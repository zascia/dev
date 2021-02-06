<?php
$data=$this->a_list_data->getNextRecord();
?>
<center>
<table width=100% border=0 cellspacing=0 cellpadding=5>
 <tr>
  <td>
    <table class=listing width=100% border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(2, $_POST['header']) ?>
    <tr>
      <td class=formBText>&nbsp;<?php echo L_G_CAMPAIGN_NAME;?>&nbsp;</td>
      <td class=formText><?php echo $data['name']?></td>
    </tr>
    <tr>
      <td class=formBText colspan=2 valign=top>&nbsp;<?php echo L_G_DESCRIPTION;?>&nbsp;</td>
    </tr>
      <td class=formText colspan=2><?php echo $data['description']?></td>
    </tr>
    <tr>
      <td class=formBText colspan=2>&nbsp;<?php echo L_G_DECLINE_REASON;?>&nbsp;</td>
    </tr>
      <td class=formText colspan=2>
        <?php echo ($data['declinereason'] == '' ? L_G_REASON_NOT_SPECIFIED : $data['declinereason']) ?>
      </td>
    </tr>    
    <tr>
      <td class=dir_form colspan=2 align=center>
        <input type=button class=formbutton value='<?php echo L_G_CLOSE?>' onClick='javascript:window.close();'>
      </td>
    </tr>
    </table>
   </td>
  </tr>
</table>
</center>
