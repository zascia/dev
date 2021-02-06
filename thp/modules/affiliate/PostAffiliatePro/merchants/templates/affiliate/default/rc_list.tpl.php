<script>
function ChangeState(ID, action)
{
  if(action == "suppress")
  {
    if(confirm("<?php echo L_G_CONFIRMSUPPRESSRC?>"))
     	document.location.href = "index.php?md=Affiliate_Merchants_Views_RecurringManager&id="+ID+"&action="+action+"&<?php echo SID?>";
  }    
  else if(action == "approve")
  {
    if(confirm("<?php echo L_G_CONFIRMAPPROVERC?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_RecurringManager&id="+ID+"&action="+action+"&<?php echo SID?>";
  }
}

function Delete(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETERC?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_RecurringManager&id="+ID+"&action=delete"+"&<?php echo SID?>";
}
</script>
<form name=FilterForm action=index.php method=post>
<table cellpadding="0" cellspacing="0" border="0" width="1%">
<tr><td align="left" valign="bottom" width="780">
        <?php QUnit_Global::includeTemplate('rc_filter.tpl.php'); ?></td>
     </tr>
<tr><td align="left">
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td class=listheader colspan=14 align=center><?php echo L_G_LISTOFRECURRINGCOMMISSIONS?>&nbsp;<?php print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
    </tr>
    <tr class=listheader>
      <td class=listheader width=1% nowrap><input type=button id=checkItemsButton value='[X]' OnClick="checkAllItems();"></td>
<?php
    QUnit_Templates::printHeader(L_G_RECCOMID, 't.recurringcommid');
    QUnit_Templates::printHeader(L_G_PCNAME, 'cc.campaignid');
    QUnit_Templates::printHeader(L_G_AFFILIATE, 'affiliateid');
    QUnit_Templates::printHeader(L_G_ORDERID, 't.orderid');
    QUnit_Templates::printHeader(L_G_ORDERDATE, 'r.dateinserted');
    QUnit_Templates::printHeader(L_G_COMMISSION, 'r.commission');
    QUnit_Templates::printHeader(L_G_MULTITIERCOMMISSION);
    QUnit_Templates::printHeader(L_G_STATUS, 'r.rstatus');    
    QUnit_Templates::printHeader(L_G_ACTIONS);
    QUnit_Templates::printHeader(L_G_PAYMENTDAY);
    QUnit_Templates::printHeader(L_G_COMMDATETYPE, 'r.datetype');    
?>
    </tr>    
<?php
    while($data=$this->a_list_data->getNextRecord())
    {
?>    
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult><input type=checkbox id=itemschecked name="itemschecked[]" value="<?php echo $data['recurringcommid']?>"></td>
      <td class=listresult><?php echo $data['recurringcommid']?></td>
      <td class=listresult nowrap>&nbsp;<?php echo $this->a_campaigns[$data['campaignid']]['name']?></td>
      <td class=listresultNoCenter align="left" nowrap>
        &nbsp;<?php echo $data['affiliateid'].' : '.$this->a_affiliates[$data['affiliateid']]['name'].' '.$this->a_affiliates[$data['affiliateid']]['surname']?>
        <?php showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affdetails&aid=".$data['affiliateid'], 300); ?>
        </td>
      <td class=listresult nowrap>&nbsp;<?php echo $data['orderid']?></td>
      <td class=listresult nowrap>&nbsp;<?php echo $data['dateinserted']?></td>
      <td class=listresult nowrap>&nbsp;
<?php    if($data['commission'] != '')
      {
        if($data['commtype'] == '%')
          print $data['commission'].' %';
        else
          print Affiliate_Merchants_Bl_Settings::showCurrency($data['commission']);
      }
?>      
      </td>
      <td class=listresult nowrap>&nbsp;
<?php    if($data['st2commission'] != '' && $data['st2commission'] != 0)
        print L_G_YES;
      else
        print L_G_NO;
?>      
      </td>
      <td class=listresult nowrap>&nbsp;
<?php
      if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
      else if($data['rstatus'] == AFFSTATUS_APPROVED) print L_G_ACTIVE;
      else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED;      
?>
      &nbsp;</td>
      <td class=listresult>
<?php
        $actions = array();
        $i = 0;
        if($this->a_action_permission['approve']) {
            if (!in_array($row['transtype'], array(TRANSTYPE_REFUND, TRANSTYPE_CHARGEBACK))) {
                if($data['rstatus'] != AFFSTATUS_APPROVED) {
                    $actions[$i] = array('id'     => 'approve',
                                         'img'    => 'icon_approve.gif',
                                         'desc'   => L_G_APPROVE,
                                         'action' => "ChangeState('".$data['recurringcommid']."','approve');");
                }
                if($data['rstatus'] != AFFSTATUS_SUPPRESSED) {
                    $actions[$i+1] = array('id'     => 'suppress',
                                           'img'    => 'icon_suppress.gif',
                                           'desc'   => L_G_SUPPRESS,
                                           'action' => "ChangeState('".$data['recurringcommid']."','suppress');");
                }
            }
            $i += 2;
        }
        if($this->a_action_permission['delete']) {
            $actions[$i++] = array('id'     => 'delete',
                                   'img'    => 'icon_delete.gif',
                                   'desc'   => L_G_DELETE,
                                   'action' => "Delete('".$data['recurringcommid']."');" );
        }
        $this->a_this->assign('a_actions', $actions);
        $this->a_this->assign('a_action_count', $i);
        
        QUnit_Global::includeTemplate('actions_icon.tpl.php');
?>
      </td>
      <td class=listresult nowrap>&nbsp;
<?php
      // get next payment day (compute from day of order and period)
      $nextPaymentDate = getNextPaymentDate($data['dayofmonth'], $data['dayofweek'], $data['month'], $data['week'],$data['year'], $data['datetype']);
      print $nextPaymentDate;
?>
      </td>
      <td class=listresult nowrap>&nbsp;
<?php
      switch($data['datetype'])
      {
          case RECURRINGTYPE_WEEKLY: print L_G_WEEKLY; break;
          case RECURRINGTYPE_MONTHLY: print L_G_MONTHLY; break;
          case RECURRINGTYPE_QUARTERLY: print L_G_QUARTERLY; break;
          case RECURRINGTYPE_BIANNUALLY: print L_G_BIANNUALLY; break;
          case RECURRINGTYPE_YEARLY: print L_G_YEARLY; break;
      }
?>
      </td>
  </tr>      
<?php
    }
?>
    <tr class=listheader>
      <td class=listresultnocenter colspan=14 align=left>&nbsp;<?php echo L_G_SELECTED;?>&nbsp;
        <input type="hidden" name="massaction" id="massaction">
        <?php if($this->a_action_permission['approve']) { ?>
          <input type="submit" value="<?php echo L_G_SUPPRESS?>"
              onclick="javascript:document.getElementById('massaction').value='suppress'">
          <input type="submit" value="<?php echo L_G_APPROVE?>"
              onclick="javascript:document.getElementById('massaction').value='approve'">
        <?php } ?>
        <?php if($this->a_action_permission['delete']) { ?>
          <input type="submit" value="<?php echo L_G_DELETE?>"
              onclick="javascript:document.getElementById('massaction').value='delete'">
        <?php } ?>
      </td>
    </tr>
  </table>
</td></tr>
</table>

<input type=hidden name=filtered value=1>
<input type=hidden name=md value='Affiliate_Merchants_Views_RecurringManager'>
<input type=hidden name=action value=action value=''>
<input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
<input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">

</form>
