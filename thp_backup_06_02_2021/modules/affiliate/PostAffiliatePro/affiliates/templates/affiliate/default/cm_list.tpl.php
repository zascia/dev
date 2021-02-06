<script>
function viewBanners(ID)
{
	document.location.href = "index.php?md=Affiliate_Affiliates_Views_AffBannerManager&show_campaign_banners="+ID+"&<?php echo SID?>";
}

function joinCamp(ID)
{
	document.location.href = "index.php?md=Affiliate_Affiliates_Views_AffCampaignManager&action=join_camp&campaign="+ID+"&<?php echo SID?>";
}

function showDeclineReason(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffCampaignManager&action=show_decline_reason&campaign="+ID+"&<?php echo SID?>","Affiliate","scrollbars=1, top=100, left=100, width=500, height=300, status=0")
    wnd.focus();
}

function showDetails(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffCampaignManager&action=details&campaign="+ID+"&<?php echo SID?>","AffiliateDetails","scrollbars=1, top=100, left=100, width=500, height=300, status=0")
    wnd.focus();
}
</script>

    <form name=FilterForm action=index.php method=get>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Affiliates_Views_AffCampaignManager'>
    <input type=hidden id=action name=action value=''>
    <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">
    <?php $noCampaigns = true; ?>
    <?php while($data=$this->a_list_data->getNextRecord()) { ?>
        <?php $noCampaigns = false; ?>
        <div class="campaignRow">
            <div class="actions">
            <?php if($data['rstatus'] == AFFSTATUS_APPROVED || $GLOBALS['Auth']->getSetting('Aff_join_campaign') != '1') { ?>
                <a class=mainlink href="#" onClick="javascript:viewBanners('<?php echo $data['campaignid']?>');"><?php echo L_G_VIEWBANNERS?></a>
            <?php } else if($data['rstatus'] == '') { ?>
                <a class=mainlink href="#" onClick="javascript:joinCamp('<?php echo $data['campaignid']?>');"><?php echo L_G_JOINCAMPAIGN?></a>
            <?php } ?>
            </div>
            <div class="campaignName"><strong><?php echo L_G_CAMPAIGN_NAME?></strong>: <?php echo $data['name']?></div>
            <?php if($data['banner_url'] != '') { ?>
                <div class="banner detailrow0"><img src='<?php echo $data['banner_url']?>' width=50 height=30></div>
            <?php } ?>
            <div class="panel detailrow1">
                <div class="lpanel">
                    <div class="campaignType"><strong><?php echo L_G_CAMPAIGNTYPE?></strong>: <?php echo $GLOBALS['Auth']->getComposedCommissionTypeString($data['commtype'])?></div>
                    <div class="commissions" style="float:left"><strong><?php echo L_G_COMMISSIONS?></strong>: 
                        <?php showQuickDetails("index_popup.php?md=Affiliate_Affiliates_Views_AffCampaignManager&action=details&campaign=".$data['campaignid']); ?>
                    </div>
                    <br/>
                    <div style="margin-left:50%;"><?php echo $this->a_this->drawCommissionField($data)?></div>
                </div>
                <div class="rpanel">
                    <div class="bannerCount"><strong><?php echo L_G_BANNERS?></strong>: <?php echo $data['bannercount']?></div>
                    <?php if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1') { ?>
                        <div class="status"><strong><?php echo L_G_STATUS?></strong>:
                        <?php if($data['rstatus'] == AFFSTATUS_SUPPRESSED) { ?>
                            <a href="javascript:showDeclineReason('<?php echo $data['campaignid']?>');">
                        <?php }
                            if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
                            else if($data['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
                            else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED.'</a>';
                            else print L_G_NOTJOINED;
                        ?>
                        </div>
                    <?php } ?>
                    <?php if($data['rstatus'] == AFFSTATUS_SUPPRESSED) { ?>
                        <div class="declineReason"><strong><?php echo L_G_DECLINE_REASON?></strong>: <?php echo ($data['declinereason'] == '' ? L_G_REASON_NOT_SPECIFIED : $data['declinereason']) ?></div>
                    <?php } ?>
                </div>
                <div style="clear: both;"></div>
                <div class="shortDescription">
                    <strong><?php echo L_G_SHORT_DESCRIPTION?></strong>: <?php echo $data['shortdescription']?>
                </div>
            </div>
            <div class="description detailrow0">
                <strong><?php echo L_G_DESCRIPTION?></strong>: <?php echo $data['description']?>
            </div>
        </div>
    <?php } ?>
    
    <?php if ($noCampaigns) { ?>
        <b><?php echo L_G_NOCAMPAIGSNDEFINED?></b>
    <?php } ?>


      <!--td class=listresult valign=top>
        <select name=action_select OnChange="performAction(this);">
        <option value="-">------------------------</option>
        <option value="javascript:showDetails('<?php echo $data['campaignid']?>');"><?php echo L_G_DETAILS?></option>
<?php if($data['rstatus'] == AFFSTATUS_APPROVED || $GLOBALS['Auth']->getSetting('Aff_join_campaign') != '1') { ?>
        <option value="javascript:viewBanners('<?php echo $data['campaignid']?>');"><?php echo L_G_VIEWBANNERS?></option>
<?php } else if($data['rstatus'] == '') { ?>
        <option value="javascript:joinCamp('<?php echo $data['campaignid']?>');"><?php echo L_G_JOINCAMPAIGN?></option>
<?php } ?>
        </select>
      </td>
    </tr>
  </table -->
  </form>
