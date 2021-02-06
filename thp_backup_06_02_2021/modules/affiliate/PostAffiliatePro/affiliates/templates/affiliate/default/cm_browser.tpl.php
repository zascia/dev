<script>
function viewBanners(ID)
{
	document.location.href = "index.php?md=Affiliate_Affiliates_Views_AffBannerManager&campaign="+ID;
}

function joinCamp(ID)
{
	document.location.href = "index.php?md=Affiliate_Affiliates_Views_AffCampaignBrowserNetwork&action=join_camp&campaign="+ID+"&r=<?php echo $_REQUEST['r']?>";
}

function showDeclineReason(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffCampaignBrowserNetwork&action=show_decline_reason&campaign="+ID,"Affiliate","scrollbars=1, top=100, left=100, width=500, height=300, status=0")
    wnd.focus(); 
}

function showDetails(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffCampaignBrowserNetwork&action=details&campaign="+ID,"AffiliateDetails","scrollbars=1, top=100, left=100, width=500, height=300, status=0")
    wnd.focus(); 
}
</script>
    <form name=FilterForm action=index.php method=get>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Affiliates_Views_AffCampaignBrowserNetwork'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">    
    <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">      
    <table border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td><?php echo $this->a_category_tree_content?></td>
    </tr>
    </table>
    
    <br>
    
    <table border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td class=formBText colspan=10 align=center><?php echo L_G_LISTOFCAMPAIGNS?>&nbsp;<?php print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
     </tr>
<?php
    while($data=$this->a_list_data->getNextRecord())
    {
?>      
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td valign=top nowrap>&nbsp;<?php if($data['banner_url'] != '') { ?><img src='<?php echo $data['banner_url']?>' width=50 height=30><?php } ?>&nbsp;</td>
      <td align=left valign=top nowrap>&nbsp;&nbsp;&nbsp;<?php echo $data['name']?>&nbsp;&nbsp;&nbsp;</td>
      <td align=left valign=top>
      <table border=0 cellspacing=0>
      <tr>
        <td style="padding-left: 3px; padding-right: 3px;" align=left valign=top>
            <?php echo (strlen($data['shortdescription']) < 50 ? $data['shortdescription'] : substr($data['shortdescription'], 0, 50).' ...')?>&nbsp;
        </td>
      </tr>
      </table>
      </td>
      <td nowrap align=left valign=top>
        <?php $this->a_this->drawCommissionField($data); ?>
      &nbsp;&nbsp;&nbsp;
      </td>
      <td valign=top nowrap>&nbsp;&nbsp;&nbsp;<?php echo '<b>'.L_G_BANNERS.'&nbsp;:&nbsp;</b>'.$data['bannercount']?>&nbsp;</td>
      <td valign=top nowrap>&nbsp;&nbsp;&nbsp;
<?php
   if($data['rstatus'] == AFFSTATUS_SUPPRESSED) { ?>
        <a href="javascript:showDeclineReason('<?php echo $data['campaignid']?>');">
<?php }
   if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
   else if($data['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
   else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED.'</a>';
   else print L_G_NOTJOINED;
?>
      &nbsp;&nbsp;&nbsp;
      </td>
      <td valign=top nowrap>&nbsp;
        <a href="javascript:showDetails('<?php echo $data['campaignid']?>');"><?php echo L_G_DETAILS?></a>&nbsp;
      </td>
      <td valign=top nowrap>&nbsp;
      <?php if($data['rstatus'] == AFFSTATUS_APPROVED) { ?>
           <a href="javascript:showDetails('<?php echo $data['campaignid']?>');"><?php echo L_G_VIEWBANNERS?></a>&nbsp;
      <?php } else if($data['rstatus'] == '') { ?>
           <a href="javascript:joinCamp('<?php echo $data['campaignid']?>');"><?php echo L_G_JOINCAMPAIGN?></a>&nbsp;
      <?php } ?>           
      </td>
    </tr>
    <tr>
      <td colspan=10><hr></td>
    </tr>
<?php
    }
?>
  </table>
  </form>
