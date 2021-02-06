<script>
function addDomain()
{
<?php if($_POST['show_no_popup'] == '1') { ?>
	document.location.href = "index.php?md=Affiliate_Affiliates_Views_AffDomains&action=add_new&<?php echo SID?>";
<?php } else { ?>
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffDomains&action=add_new&<?php echo SID?>","Domain","scrollbars=1, top=100, left=100, width=500, height=300, status=0")
    wnd.focus();
<?php } ?>
}

function editDomain(ID)
{
<?php if($_POST['show_no_popup'] == '1') { ?>
	document.location.href = "index.php?md=Affiliate_Affiliates_Views_AffDomains&action=edit&did="+ID+"&<?php echo SID?>";
<?php } else { ?>
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffDomains&action=edit&did="+ID+"&<?php echo SID?>","Domain","scrollbars=1, top=100, left=100, width=500, height=300, status=0")
    wnd.focus();
<?php } ?>
}

function deleteDomain(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETEDOMAIN?>"))
	document.location.href = "index.php?md=Affiliate_Affiliates_Views_AffDomains&action=delete&did="+ID+"&<?php echo SID?>";
}

function showDeclineReason(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffDomains&action=show_decline_reason&campaign="+ID+"&<?php echo SID?>","Affiliate","scrollbars=1, top=100, left=100, width=500, height=300, status=0")
    wnd.focus();
}
</script>
    <form name=FilterForm action=index.php method=get>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Affiliates_Views_AffDomains'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">    
    <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">      
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td class=actionheader align=left colspan=9>
        &nbsp;<b><a class=mainlink href="javascript:addDomain();"><?php echo L_G_ADD_DOMAIN?></a></b>
      </td>
    </tr>
    <tr class=header>
      <td class=listheader colspan=10 align=center><?php echo L_G_LISTOFDOMAINS?>&nbsp;<?php print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
    </tr>
    <tr class=listheader>
<?php
      QUnit_Templates::printHeader(L_G_URL, 'd.url');
      QUnit_Templates::printHeader(L_G_STATUS, 'd.rstatus');
      QUnit_Templates::printHeader(L_G_ADDED, 'd.dateinserted');
      QUnit_Templates::printHeader(L_G_ACTIONS);
?>    
    </tr>    
<?php
    while($data=$this->a_list_data->getNextRecord())
    {
?>      
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresultnocenter align=left valign=top nowrap>&nbsp;<?php echo $data['url']?></td>
      <td class=listresult valign=top nowrap>&nbsp;
<?php
   if($data['rstatus'] == AFFSTATUS_SUPPRESSED) { ?>
        <a href="javascript:showDeclineReason('<?php echo $data['domainid']?>');">
<?php }
   if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
   else if($data['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
   else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED.'</a>';
?>
      &nbsp;
      </td>
      <td class=listresultnocenter align=left valign=top nowrap>&nbsp;<?php echo $data['dateinserted']?>&nbsp;</td>
      <td class=listresult valign=top>
        <select name=action_select OnChange="performAction(this);">
          <option value="-">------------------------</option>
          <option value="javascript:editDomain('<?php echo $data['domainid']?>');"><?php echo L_G_EDIT?></option>
          <option value="javascript:deleteDomain('<?php echo $data['domainid']?>');"><?php echo L_G_DELETE?></option>
        </select>
      </td>
    </tr>
<?php
    }
?>
  </table>
  </form>
