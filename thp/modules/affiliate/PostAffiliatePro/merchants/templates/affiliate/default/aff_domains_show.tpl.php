<script>
function ChangeState(ID, action)
{
  if(action == "suppress")
  {
    if(confirm("<?php echo L_G_CONFIRMSUPPRESSAFFDOMAIN?>"))
     	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateDomains&did="+ID+"&action="+action+"&<?php echo SID?>";
  }    
  else if(action == "approve")
  {
    if(confirm("<?php echo L_G_CONFIRMAPPROVEAFFDOMAIN?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateDomains&did="+ID+"&action="+action+"&<?php echo SID?>";
  }
}
</script>

    <form name=FilterForm action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td align=left colspan=10>
      </td>
    </tr>
    <tr class=header>
      <td class=listheader colspan=10 align=center><?php echo L_G_LISTOFAFFILIATEDOMAINS?>&nbsp;<?php print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
    </tr>
    <tr class=listheader>
      <td class=listheader width=1% nowrap><input type=button id=checkItemsButton value='[X]' OnClick="checkAllItems();"></td>
<?php
    QUnit_Templates::printHeader(L_G_ID, 'd.domainid');
    QUnit_Templates::printHeader(L_G_URL, 'd.url');
    QUnit_Templates::printHeader(L_G_NAME, 'a.name');
    QUnit_Templates::printHeader(L_G_SURNAME, 'a.surname');
    QUnit_Templates::printHeader(L_G_CREATED, 'd.dateinserted');
    QUnit_Templates::printHeader(L_G_STATUS, 'd.rstatus');
    QUnit_Templates::printHeader(L_G_ACTIONS);
?>    
    </tr>
    </form>
    <form action=index.php method=post>

<?php
    
    while($data=$this->a_list_data->getNextRecord())
    {
?>
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult><input type=checkbox id=itemschecked name='itemschecked[]' value='<?php echo $data['domainid']?>'></td>
      <td class=listresultnocenter align=left nowrap>&nbsp;<?php echo $data['domainid']?>&nbsp;</td>
      <td class=listresultnocenter align=left nowrap>&nbsp;<?php echo $data['url']?>&nbsp;</td>
      <td class=listresultnocenter align=left nowrap>&nbsp;<?php echo $data['name']?>&nbsp;</td>
      <td class=listresultnocenter align=left nowrap>&nbsp;<?php echo $data['surname']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?php echo $data['dateinserted']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;
      <?php 
        if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
        else if($data['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
        else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED
      ?> &nbsp;
      </td>
      <td class=listresult>
        <select name=action_select OnChange="performAction(this);">
          <option value="-">------------------------</option>
          <?php if($data['rstatus'] == AFFSTATUS_APPROVED) { ?>
              <option value="javascript:ChangeState('<?php echo $data['domainid']?>','suppress');"><?php echo L_G_SUPPRESS?></option>
          <?php } else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) { ?>
              <option value="javascript:ChangeState('<?php echo $data['domainid']?>','approve');"><?php echo L_G_APPROVE?></option>
          <?php } else { ?>
              <option value="javascript:ChangeState('<?php echo $data['domainid']?>','suppress');"><?php echo L_G_SUPPRESS?></option>
              <option value="javascript:ChangeState('<?php echo $data['domainid']?>','approve');"><?php echo L_G_APPROVE?></option>
          <?php } ?>
        </select>
      </td>
    </tr>    
<?php
    }
?>
    <tr class=listheader>
      <td class=listresultnocenter colspan=10 align=left>&nbsp;<?php echo L_G_SELECTED;?>&nbsp;
        <select name=massaction>
          <option value=""><?php echo L_G_CHOOSEACTION?></option>
          <option value="suppress"><?php echo L_G_SUPPRESS?></option>
          <option value="approve"><?php echo L_G_APPROVE?></option>
        </select>
        &nbsp;&nbsp;
        <input type=submit value="<?php echo L_G_SUBMITMASSACTION?>">
      </td>
    </tr>
    </table>
    <input type=hidden name=commited value='yes'>
    <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateDomains'>
    <input type=hidden id=action name=action value=''>
    <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">
    </form>
