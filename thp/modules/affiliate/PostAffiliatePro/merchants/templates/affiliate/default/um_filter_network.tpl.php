<script>
function ChangeCommCat(ID)
{
    document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManagerNetwork&aid="+ID+"&action=changecommcat"+"&<?php echo SID?>";
}

function showTree()
{
 	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManagerNetwork&action=showtree"+"&<?php echo SID?>";
}

function accountingDetails(ID)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManagerNetwork&aid="+ID+"&action=accounting"+"&<?php echo SID?>";
}

function viewUser(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateManagerNetwork&action=view&aid="+ID+"&<?php echo SID?>","AddUser","scrollbars=1, top=100, left=100, width=450, height=500, status=0")
    wnd.focus(); 
}
</script>

    <form name=FilterForm id=FilterForm action=index.php method=get>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(10); ?>
    <tr>
      <td>&nbsp;<?php echo L_G_NAME?>&nbsp;</td>
      <td><input type=text name=um_name size=20 value="<?php echo $_REQUEST['um_name']?>"></td>
      <td>&nbsp;<?php echo L_G_SURNAME?>&nbsp;</td>
      <td><input type=text name=um_surname size=20 value="<?php echo $_REQUEST['um_surname']?>">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;<?php echo L_G_AFFILIATEID?>&nbsp;</td>
      <td><input type=text name=um_aid size=20 value="<?php echo $_REQUEST['um_aid']?>"></td>
      <td><?php echo L_G_STATUS?>&nbsp;</td>
      <td>
        <select name=um_status>
          <option value='_'><?php echo L_G_ALLSTATES?></option>
          <option value=<?php echo AFFSTATUS_NOTAPPROVED?> <?php print ($_REQUEST['um_status'] == AFFSTATUS_NOTAPPROVED ? 'selected' : '');?>><?php echo L_G_WAITINGAPPROVAL?></option>
          <option value=<?php echo AFFSTATUS_APPROVED?> <?php print ($_REQUEST['um_status'] == AFFSTATUS_APPROVED ? 'selected' : '');?>><?php echo L_G_APPROVED?></option>
          <option value=<?php echo AFFSTATUS_SUPPRESSED?> <?php print ($_REQUEST['um_status'] == AFFSTATUS_SUPPRESSED ? 'selected' : '');?>><?php echo L_G_SUPPRESSED?></option>
        </select>
      </td>
    </tr>
    <tr><td align=left nowrap>&nbsp;<?php echo L_G_ROWSPERPAGE?>&nbsp;</td>
      <td>
      <select name=numrows onchange="javascript:FilterForm.list_page.value=0;">
        <option value=10 <?php print ($_REQUEST['numrows']==10 ? "selected" : ""); ?>>10</option>
        <option value=20 <?php print ($_REQUEST['numrows']==20 ? "selected" : ""); ?>>20</option>
        <option value=30 <?php print ($_REQUEST['numrows']==30 ? "selected" : ""); ?>>30</option>
        <option value=50 <?php print ($_REQUEST['numrows']==50 ? "selected" : ""); ?>>50</option>
        <option value=100 <?php print ($_REQUEST['numrows']==100 ? "selected" : ""); ?>>100</option>
        <option value=200 <?php print ($_REQUEST['numrows']==200 ? "selected" : ""); ?>>200</option>
        <option value=500 <?php print ($_REQUEST['numrows']==500 ? "selected" : ""); ?>>500</option>
        <option value=1000 <?php print ($_REQUEST['numrows']==1000 ? "selected" : ""); ?>>1000</option>
        <option value=100000000 <?php print ($_REQUEST['numrows']==100000000 ? "selected" : ""); ?>><?php echo L_G_ALL?></option>
      </select>
      </td>
    </tr>       
    <tr>
      <td colspan=4 align=center>&nbsp;<input type=submit class=formbutton value='Search'></td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateManagerNetwork'>
    <input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>
    <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
    <input type=hidden id=action name=action value=''>
    <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">

    <br>
