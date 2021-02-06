
    <form action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter(2, L_G_ACCOUNTINGDETAILS); ?>
    <tr>
      <td class=dir_form>
      <b><?php echo L_G_ACCOUNTINGID?></b>
      </td>
      <td><?php echo $_POST['accountingid']?></td>
    </tr>
    <tr>
      <td class=dir_form>
      <b><?php echo L_G_CREATED?></b>
      </td>
      <td><?php echo $_POST['dateinserted']?></td>
    </tr>
    <tr>
      <td class=dir_form>
      <b><?php echo L_G_PERIODFROM?></b>
      </td>
      <td><?php echo $_POST['datefrom']?></td>
    </tr>
    <tr>
      <td class=dir_form>
      <b><?php echo L_G_PERIODTO?></b>
      </td>
      <td><?php echo $_POST['dateto']?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top>
      <b><?php echo L_G_NOTE;?></b>
      </td>
      <td><textarea rows=3 cols=50 name=note><?php echo $_POST['note']?></textarea></td>
    </tr>
    <tr>
      <td class=dir_form colspan=2 align=center>
      <?php if($this->a_action_permission['savedetails']) { ?>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Merchants_Views_Accounting'>
        <input type=hidden name=action value='savedetails'>
        <input type=hidden name=aid value=<?php echo $_POST['accountingid']?>>
        <input type=submit class=formbutton value='<?php echo L_G_SAVENOTE?>'>
      <?php } ?>
      </td>
    </tr>
    </table>
    </form>
    <br>
    <table class=listing width=60% border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td class=listheader align=center colspan=5><b><?php echo L_G_PAYMENTSLIST?></b></td>
    </tr>
    <tr class=listheader>
<?php
    QUnit_Templates::printHeader(L_G_AFFILIATEID, '');
    QUnit_Templates::printHeader(L_G_NAME, '');
    QUnit_Templates::printHeader(L_G_SURNAME, '');
    QUnit_Templates::printHeader(L_G_AMOUNT, '');
    QUnit_Templates::printHeader(L_G_PAYOUTMETHOD, '');
?>
    </tr>
<?php
    while($data=$this->a_list_data->getNextRecord())
    {
?>
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult nowrap>&nbsp;<?php echo $data['userid']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?php echo $data['name']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?php echo $data['surname']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['commission']))?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;
      <?php echo $this->a_payout_methods[$data['payout_type']]['name']?>
      </td>
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
