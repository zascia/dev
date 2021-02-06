<script>

function Delete(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETECAT?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_CampaignManager&cid="+ID+"&action=delete"+"&<?php echo SID?>";
}

function addCampaign()
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_CampaignManager&action=add"+"&<?php echo SID?>";
}

function viewCampaign(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_CampaignManager&action=view"+"&<?php echo SID?>";
}

function editCampaign(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_CampaignManager&action=edit&cid="+ID+"&<?php echo SID?>";
}

function viewBanners(ID)
{
    document.location.href = "index.php?md=Affiliate_Merchants_Views_BannerManager&filtered=1&bs_campaign="+ID+"&<?php echo SID?>";
}

function viewEmails(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_EmailManager&campaign="+ID+"&<?php echo SID?>";
}

function massDeleteCampaign() {
    if(confirm("<?php echo L_G_CONFIRMMASSDELETECAT?>")) {
        document.getElementById('massaction').value='delete'
        FilterForm.submit();
    }
}

</script>

<form name=FilterForm id=FilterForm action=index.php method=get>
<input type=hidden name=filtered value=1>
<input type=hidden name=md value='Affiliate_Merchants_Views_CampaignManager'>
<input type=hidden name=type value='all'>
<input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>
<input type=hidden id=action name=action value=''>
<input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
<input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">
<input type=hidden name=commited value='yes'>
<table cellpadding="0" cellspacing="0" border="0" >
<tr><td valign="top"><?php echo L_G_CAMPAIGN_DESCRIPTION?><br><br></td></tr>
</table>
<br>
<table cellpadding="0" cellspacing="0" border="0" width="780">
<tr><td align="left" valign="bottom" width="480">
        <?php QUnit_Global::includeTemplate('cm_filter.tpl.php'); ?>
    </td>
    <td align="left" valign="top" width="300">
    	<b><?=L_G_DEFAULTCAMPAIGNFORDYNAMICLINK?></b><br><br>
    	<select name="default_campaign">
    	<option value="_"><?php echo L_G_NODEFAULTCAMPAIGN?></option>
    	<?php
    	    if (count($this->a_campaigns) > 0) {
    	        foreach ($this->a_campaigns as $campaign)
    	        {
    	            if ($campaign['status'] != AFF_CAMP_PUBLIC) continue;
    	            echo '<option value="'.$campaign['campaignid'].'" '.($_REQUEST['default_campaign'] == $campaign['campaignid'] ? 'selected' : '').'>'.$campaign['name'].'</option>';
    	        }
    	    }
    	?>
    	</select>
    	<br><br>
    	<input type="submit" onclick="document.getElementById('action').value = 'savedefaultcampaign';" value="<?php echo L_G_SAVEDEFAULTCAMPAIGN?>">
    	<br><br>
    	<?php showHelp(L_G_HLP_DEFAULTCAMPAIGNFORDYNAMICLINK); ?>
    </td>
    </tr>
<tr><td align="left" colspan="2">
	<table class=listing border=0 cellspacing=0 cellpadding=1 width="100%">
	<tr>
		<td align="left" colspan=9 class=listheader nowrap>
			<?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
		</td>
	</tr>
	<tr class=listheader>
            <?php $this->a_this->printMassAction('listheaderLeft'); ?>
    </tr>
	<tr class=listheader>
			<?php $this->a_this->printListHeader(); ?>
	</tr>
<?php  while($row = $this->a_list_data->getNextRecord()) { ?>
	       <?php $this->a_this->printListRow($row); ?>
<?php	} ?>  
    <tr class=listheader>
        <?php $this->a_this->printMassAction('listheaderLeft', true); ?>
    </tr>
    </table>
  
</td></tr>
</table>
  
</form>