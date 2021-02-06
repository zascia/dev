<script>
function viewBanners(ID)
{
	document.location.href = "index.php?md=Affiliate_Affiliates_Views_AffBannerManager&campaign="+ID;
}

function showDeclineReason(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffCampaignManagerNetwork&action=show_decline_reason&campaign="+ID,"Affiliate","scrollbars=1, top=100, left=100, width=500, height=300, status=0")
    wnd.focus(); 
}

function showDetails(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffCampaignManagerNetwork&action=details&campaign="+ID,"AffiliateDetails","scrollbars=1, top=100, left=100, width=500, height=300, status=0")
    wnd.focus(); 
}
</script>
    <form name=FilterForm action=index.php method=get>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Affiliates_Views_AffCampaignManagerNetwork'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">    
    <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">      
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <tr class=header>
      <td class=listheader colspan=10 align=center><?php echo L_G_LISTOFCAMPAIGNS?>&nbsp;<?php print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
     </tr>
    <tr class=listheader>
<?php
      QUnit_Templates::printHeader(L_G_BANNER);
      QUnit_Templates::printHeader(L_G_NAME, 'name');
      QUnit_Templates::printHeader(L_G_SHORT_DESCRIPTION, 'shortdescription');
      QUnit_Templates::printHeader(L_G_CAMPAIGNTYPE, 'commtype');   
      QUnit_Templates::printHeader(L_G_COMMISSIONS);
      QUnit_Templates::printHeader(L_G_BANNERS);
      QUnit_Templates::printHeader(L_G_STATUS);
      QUnit_Templates::printHeader(L_G_ACTIONS);
?>    
    </tr>    
<?php
    while($data=$this->a_list_data->getNextRecord())
    {
?>      
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult valign=top>&nbsp;<?php if($data['banner_url'] != '') { ?><img src='<?php echo $data['banner_url']?>' width=50 height=30><?php } ?></td>
      <td class=listresultnocenter align=left valign=top nowrap>&nbsp;<?php echo $data['name']?>&nbsp;</td>
      <td class=listresultnocenter valign=top align=left>
      <table border=0 cellspacing=0>
      <tr>
        <td style="padding-left: 3px; padding-right: 3px;" align=left valign=top>
            <?php echo (strlen($data['shortdescription']) < 50 ? $data['shortdescription'] : substr($data['shortdescription'], 0, 50).' ...')?>&nbsp;
        </td>
      </tr>
      </table>
      </td>
      <td class=listresult valign=top>&nbsp;
      <?php
        print $GLOBALS['Auth']->getComposedCommissionTypeString($data['commtype']);
      ?> &nbsp;
      </td>
      <td class=listresultnocenter nowrap align=left>
        <?php $this->a_this->drawCommissionField($data); ?>
      &nbsp;
      </td>
      <td class=listresult valign=top>&nbsp;<?php echo $data['bannercount']?>&nbsp;</td>
      <td class=listresult valign=top nowrap>&nbsp;
<?php
   if($data['rstatus'] == AFFSTATUS_SUPPRESSED) { ?>
        <a href="javascript:showDeclineReason('<?php echo $data['campaignid']?>');">
<?php }
   if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
   else if($data['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
   else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED.'</a>';
   else print L_G_NOTJOINED;
?>
      &nbsp;
      </td>
      <td class=listresult valign=top>
        <select name=action_select OnChange="performAction(this);">
        <option value="-">------------------------</option>
        <option value="javascript:showDetails('<?php echo $data['campaignid']?>');"><?php echo L_G_DETAILS?></option>
<?php if($data['rstatus'] == AFFSTATUS_APPROVED) { ?>
        <option value="javascript:viewBanners('<?php echo $data['campaignid']?>');"><?php echo L_G_VIEWBANNERS?></option>
<?php } ?>
        </select>
      </td>
    </tr>
<?php
    }
?>
  </table>
  </form>
