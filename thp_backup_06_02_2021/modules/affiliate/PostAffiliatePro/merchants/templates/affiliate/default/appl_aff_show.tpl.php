<script>
function ChangeState(ID, action)
{
  if(action == "suppress")
  {
    if(confirm("<?php echo L_G_CONFIRMSUPPRESSAFFCAMP?>"))
     	document.location.href = "index.php?md=Affiliate_Merchants_Views_AppliedAffiliate&acid="+ID+"&action="+action+"&<?php echo SID?>";
  }    
  else if(action == "approve")
  {
    if(confirm("<?php echo L_G_CONFIRMAPPROVEAFFCAMP?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_AppliedAffiliate&acid="+ID+"&action="+action+"&<?php echo SID?>";
  }
  else if(action == "pending")
  {
    if(confirm("<?php echo L_G_CONFIRMPENDINGAFFCAMP?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_AppliedAffiliate&acid="+ID+"&action="+action+"&<?php echo SID?>";
  }
}

function Delete(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETEAFFCAMP?>"))
  	document.location.href = "index.php?md=Affiliate_Merchants_Views_AppliedAffiliate&acid="+ID+"&action=delete&<?php echo SID?>";
}
</script>
<?php QUnit_Global::includeTemplate('appl_aff_filter.tpl.php'); ?>
    <table class=listingClosed cellspacing=0 cellpadding=1 width="780">
    <tr class=header>
      <td class=listheader colspan=10 align=center><?php echo L_G_LISTOFAPPLIEDAFFILIATES?>&nbsp;<?php print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
    </tr>
    <tr class=header>
        <td align="left" class=listheader colspan="10" nowrap>
           <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
        </td>
    </tr>
    <tr class=listheader>
      <td class=listheader width=1% nowrap><input type=button id=checkItemsButton value='[X]' OnClick="checkAllItems();"></td>
<?php
    QUnit_Templates::printHeader(L_G_ID, 'a.userid');
    QUnit_Templates::printHeader(L_G_AFFILIATE, 'a.name');
    QUnit_Templates::printHeader(L_G_AFFILIATESTATUS, 'affstatus');
    QUnit_Templates::printHeader(L_G_CAMPAIGN_NAME, 'camp_name');
    QUnit_Templates::printHeader(L_G_CAMPAIGNSTATUS, 'campstatus');
    QUnit_Templates::printHeader(L_G_COMMISIONTYPES, 'c.commtype');
    QUnit_Templates::printHeader(L_G_CREATED, 'c.dateinserted');
    QUnit_Templates::printHeader(L_G_AFFILIATESTATUSINCAMPAIGN, 'ac.rstatus');
    QUnit_Templates::printHeader(L_G_ACTIONS);
?>    
    </tr>
<?php
    
    while($data=$this->a_list_data->getNextRecord())
    {
?>
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult><input type=checkbox id=itemschecked name='itemschecked[]' value='<?php echo $data['affcampid']?>'></td>
      <td class=listresultnocenter align=left nowrap>&nbsp;<?php echo $data['userid']?>&nbsp;</td>
      <td class=listresultnocenter align=left nowrap>
            &nbsp;<?php echo $data['name'].' '.$data['surname']?>&nbsp;
            <?php showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affdetails&aid=".$data['userid'], 300); ?>
      </td>
      <td class=listresultnocenter align=left nowrap>&nbsp;
        <?php if($data['affstatus'] == AFFSTATUS_NOTAPPROVED) print '<img src="'.$this->a_this->getImage('sphore_pending.png').'" title="'.L_G_WAITINGAPPROVAL.'" alt="'.L_G_WAITINGAPPROVAL.'"> '.L_G_WAITINGAPPROVAL;
           else if($data['affstatus'] == AFFSTATUS_APPROVED) print '<img src="'.$this->a_this->getImage('sphore_active.png').'" title="'.L_G_APPROVED.'" alt="'.L_G_APPROVED.'"> '.L_G_APPROVED;
           else if($data['affstatus'] == AFFSTATUS_SUPPRESSED) print '<img src="'.$this->a_this->getImage('sphore_declined.png').'" title="'.L_G_SUPPRESSED.'" alt="'.L_G_SUPPRESSED.'"> '.L_G_SUPPRESSED;
         ?>&nbsp;</td>
      <td class=listresultnocenter align=left nowrap>
            &nbsp;<?php echo $data['camp_name']?>&nbsp;
            <?php showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_CampaignManager&action=campdetails&cid=".$data['campaignid'], 300); ?>
      </td>
      <td class=listresultnocenter align=left nowrap>&nbsp;
        <?php echo ($data['campstatus'] == AFF_CAMP_PUBLIC) ? L_G_PUBLIC : L_G_PRIVATE?>&nbsp;</td>
      <td class=listresultnocenter align=left nowrap>&nbsp;
        <?php echo $GLOBALS['Auth']->getComposedCommissionTypeString($data['commtype'])?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?php echo $data['dateinserted']?>&nbsp;</td>
      <td class=listresultnocenter align="left" nowrap>&nbsp;
        <?php if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print '<img src="'.$this->a_this->getImage('sphore_pending.png').'" title="'.L_G_WAITINGAPPROVAL.'" alt="'.L_G_WAITINGAPPROVAL.'"> '.L_G_WAITINGAPPROVAL;
           else if($data['rstatus'] == AFFSTATUS_APPROVED) print '<img src="'.$this->a_this->getImage('sphore_active.png').'" title="'.L_G_APPROVED.'" alt="'.L_G_APPROVED.'"> '.L_G_APPROVED;
           else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print '<img src="'.$this->a_this->getImage('sphore_declined.png').'" title="'.L_G_SUPPRESSED.'" alt="'.L_G_SUPPRESSED.'"> '.L_G_SUPPRESSED;
         ?> &nbsp;
      </td>
      <td class=listresult width="1%">
        <?php $actions = array();
           $i = 0;
           if($data['rstatus'] != AFFSTATUS_APPROVED && $this->a_this->checkPermissions('approve')) {
               $actions[$i] = array('id'     => 'approve',
                                    'img'    => 'icon_approve.gif',
                                    'desc'   => L_G_APPROVE,
                                    'action' => "ChangeState('".$data['affcampid']."','approve');");
           }
           if($data['rstatus'] != AFFSTATUS_SUPPRESSED && $this->a_this->checkPermissions('decline')) {
               $actions[$i+1] = array('id'     => 'suppress',
                                      'img'    => 'icon_suppress.gif',
                                      'desc'   => L_G_SUPPRESS,
                                      'action' => "ChangeState('".$data['affcampid']."','suppress');");
           }
           if($data['rstatus'] != AFFSTATUS_NOTAPPROVED && $this->a_this->checkPermissions('decline')) {
               $actions[$i+2] = array('id'     => 'pending',
                                      'img'    => 'icon_pending.gif',
                                      'desc'   => L_G_PENDING,
                                      'action' => "ChangeState('".$data['affcampid']."','pending');");
           }
           $i += 3;
           if ($this->a_this->checkPermissions('delete')) {
                $actions[$i++] = array('id'     => 'delete',
                                       'img'    => 'icon_delete.gif',
                                       'desc'   => L_G_DELETE,
                                       'action' => "Delete('".$data['affcampid']."');" );
           }
           $this->a_this->assign('a_actions', $actions);                        
           $this->a_this->assign('a_action_count', $i);
         ?>
         <?php QUnit_Global::includeTemplate('actions_icon.tpl.php'); ?>
      </td>
    </tr>    
<?php
    }
?>
    <tr class=listheader>
      <td class=listresultnocenter colspan=10 align=left>&nbsp;<?php echo L_G_SELECTED;?>&nbsp;
        <input type="hidden" name="massaction" id="massaction">
        <?php if ($this->a_this->checkPermissions('decline')) { ?>
        <input type="submit" value="<?php echo L_G_SUPPRESS?>"
            onclick="javascript:document.getElementById('massaction').value='suppress'">
        <?php } ?>
        <?php if ($this->a_this->checkPermissions('approve')) { ?>
        <input type="submit" value="<?php echo L_G_APPROVE?>"
            onclick="javascript:document.getElementById('massaction').value='approve'">
        <?php } ?>
        <?php if ($this->a_this->checkPermissions('decline')) { ?>
        <input type="submit" value="<?php echo L_G_PENDING?>"
            onclick="javascript:document.getElementById('massaction').value='pending'">
        <?php } ?>
        <?php if ($this->a_this->checkPermissions('delete')) { ?>
        <input type="submit" value="<?php echo L_G_DELETE?>"
            onclick="javascript:document.getElementById('massaction').value='delete'">
        <?php } ?>
      </td>
    </tr>
    </table>
    <input type=hidden name=commited value='yes'>
    <input type=hidden name=md value='Affiliate_Merchants_Views_AppliedAffiliate'>
    <input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>
    <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">
    </form>