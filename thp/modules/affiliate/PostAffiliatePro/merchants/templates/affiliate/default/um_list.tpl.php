<script>
function ChangeState(ID, action)
{
  if(action == "suppress")
  {
	if(confirm("<?php echo L_G_CONFIRMSUPPRESSAFF?>"))
		document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&aid="+ID+"&action="+action+"&<?php echo SID?>";
  }
  else if(action == "approve")
  {
	if(confirm("<?php echo L_G_CONFIRMAPPROVEAFF?>"))
	  document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&aid="+ID+"&action="+action+"&<?php echo SID?>";
  }
  else if(action == "pending")
  {
	if(confirm("<?php echo L_G_CONFIRMPENDINGAFF?>"))
	  document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&aid="+ID+"&action="+action+"&<?php echo SID?>";
  }
}

function Delete(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETEAFF?>"))
	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&aid="+ID+"&action=delete"+"&<?php echo SID?>";
}

function showTree()
{
 	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=showtree"+"&<?php echo SID?>";
}

function accountingDetails(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=accounting&aid="+ID+"&<?php echo SID?>";
}

function viewUser(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=view&aid="+ID+"&<?php echo SID?>","AddUser","scrollbars=1, top=100, left=100, width=450, height=500, status=0";
}

function editUser(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=edit&aid="+ID+"&<?php echo SID?>","AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0";
}

function changeCommCat(ID)
{
    document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=changecommcat&aid="+ID+"&<?php echo SID?>","AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0";
}

function addUser()
{
	//var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateManager&action=add"+"&<?php echo SID?>","AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
	//wnd.focus();
	document.location.href= "index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=add"+"&<?php echo SID?>";
}

function InviteIntoCampaign(ID)
{
  document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=invite&aid="+ID+"&";
  //var wnd = window.open("index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=invite&aid="+ID,"AddUser","scrollbars=1, top=100, left=100, width=400, height=300, status=0")
  //wnd.focus(); 
}

</script>

<form name=FilterForm id=FilterForm action=index.php method=get>
<input type=hidden name=filtered value=1>
<input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateManager'>
<input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>
<input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
<input type=hidden id=action name=action value=''>
<input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">

<table cellpadding="5" cellspacing="0" border="0" width="780">
<tr>
	<td valign=top><?php echo L_G_AFFILIATE_DESCRIPTION?><br><br>
	<?php QUnit_Global::includeTemplate('um_actions.tpl.php'); ?>
	</td>
	<td width="1%" align="right" valign="top">
		<?php showLoadedDataDiv("index_cache.php?md=Affiliate_Merchants_Views_AffiliateManager&action=showaffstats", true); ?>
	<br></td></tr>
</table>
<br>
<?php
if($this->a_exportFileName != '') { ?>

	<table class=listing border=0 cellspacing=0 cellpadding=1>
		<tr>
			<td align=center><?php echo L_G_DOWNLOADCSV?> <br><a class=mainlink
				href="<?php echo $this->a_Auth->getSetting('Aff_export_url').$this->a_exportFileName?>"><b><?php echo $this->a_exportFileName?></b></a></td>
		</tr>
	</table>
	<br><br>
<?php } ?>
<table cellpadding="0" cellspacing="0" border="0" width="1%">
<tr><td align="left" valign="bottom" width="780" colspan="2">
		<?php QUnit_Global::includeTemplate('um_filter.tpl.php'); ?></td>
	 </tr>
<tr><td align="left" colspan="2">
	<table class=listingClosed border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td class=listPaging align=right>
		<table width="100%" border="0" height="18" cellspacing="0" cellpadding="0">
		<tr>
			<td align="left" class=listheaderNoLine nowrap>
				<?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
			</td>
            <td class=listheaderNoLine width="1%" nowrap>
                &nbsp;
                <a class=simplelink href="javascript:showListOptions();"><?php echo L_G_LISTOPTIONS?></a>
                &nbsp;
            </td>
        </tr>
        </table>

        <div id="view_av_options" style="display:none;">
        <table width="100%"  height="18" cellspacing="0" cellpadding="0">
        <tr>
            <td class=listViewLineRight>
				<?php $this->a_this->printAvailableViews('Affiliate_Merchants_Views_AffiliateManager'); ?>
			</td>
		</tr>
		</table>

		</div>
		</td>
	</tr>
	<tr>
		<td align=left>
		<table width="100%" cellspacing="0" cellpadding="1">
</form>
<form name=ListForm id=ListForm action=index.php method=post>
		<tr class=listheader>
			<?php $this->a_this->printMassAction('listheaderLeft'); ?>
		</tr>
		<tr class=listheader>
			<?php $this->a_this->printListHeader(); ?>
        </tr>

<?php
		if($this->a_allcount == 0) {
			$this->a_this->printNoRecords();
		} else {
			while($row = $this->a_list_data->getNextRecord())
			{
?>
			<tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
				<?php $this->a_this->printListRow($row); ?>
			</tr>
<?php
			}
		}
?>
		</table>
		</td>
    </tr>
    <td class=listheader nowrap>
        <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?></td>
    </tr>
    <tr class=listheader>
        <?php $this->a_this->printMassAction('listheaderLeft', true); ?>
    </tr>
    </table>
</td></tr>
</table>

<input type=hidden name=fromprofile value="<?php echo $_REQUEST['fromprofile']?>">
<input type=hidden name=umprof_status value="<?php echo $_REQUEST['umprof_status']?>">
<input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateManager'>
<input type=hidden name=commited value='yes'>
<input type="hidden" name="massaction" id="massaction" value="">
</form>
