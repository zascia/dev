
	<table class=listing border=0 cellspacing=0 cellpadding=1 width="780">
    <tr>
	  <td colspan=11 align=center>
        <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
      </td>
    </tr>  
    <tr height=1><td class=settingsLine colspan=11 height=1><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>        
    <tr class=listheader align="center">
        <?php QUnit_Templates::printHeader(L_G_ID, 'userid'); ?>
        <?php QUnit_Templates::printHeader(L_G_NAME2, 'name'); ?>
        <?php QUnit_Templates::printHeader(L_G_STATUS, 'rstatus'); ?>
        <?php QUnit_Templates::printHeader(L_G_ALLIMPRESSIONS2, 'imps_all'); ?>
        <?php QUnit_Templates::printHeader(L_G_UNIQUEIMPRESSIONS2, 'imps_unique'); ?>
        <?php if($this->a_clickSaveSupported) { ?>
            <?php QUnit_Templates::printHeader(L_G_CLICKS, 'clicks'); ?>
        <?php } ?>
        <?php QUnit_Templates::printHeader(L_G_SALESLEADS2, 'sales'); ?>
        
        <?php QUnit_Templates::printHeader(L_G_COMMISSION, 'commission'); ?>
        <?php QUnit_Templates::printHeader(L_G_TOTALCOST, 'totalcost'); ?>
        
        <?php if($this->a_clickSaveSupported) { ?>
            <?php QUnit_Templates::printHeader(L_G_CLICKS.' / '.L_G_IMPRESSIONS, 'clicks_imps'); ?>
            <?php QUnit_Templates::printHeader(L_G_SALESLEADS2.' / '.L_G_CLICKS, 'sales_clicks'); ?>
        <?php } ?>
    </tr>
      
        <?php
        $i = 0;
        
        while(($i++<$_REQUEST['list_page']*$_REQUEST['numrows']) && $data=$this->a_list_data->getNextRecord());
        
		while($data=$this->a_list_data->getNextRecord())
        {
        ?>    
			<tr class="listrow<?php echo ($i++)%2?>">
            <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $data['userid']?>&nbsp;</td>
            <td class="listresult2" align="left" nowrap>&nbsp;<?php echo $data['name']?>&nbsp;
                <?php showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affalldetails&aid=".$data['userid'], 300); ?></td>
            <td class="listresult2" align="left" nowrap>&nbsp;
                <?php  if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print '<img src="'.$this->a_this->getImage('sphore_pending.png').'" title="'.L_G_WAITINGAPPROVAL.'" alt="'.L_G_WAITINGAPPROVAL.'"> '.L_G_WAITINGAPPROVAL;
                    else if($data['rstatus'] == AFFSTATUS_APPROVED) print '<img src="'.$this->a_this->getImage('sphore_active.png').'" title="'.L_G_APPROVED.'" alt="'.L_G_APPROVED.'"> '.L_G_APPROVED;
                    else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print '<img src="'.$this->a_this->getImage('sphore_declined.png').'" title="'.L_G_SUPPRESSED.'" alt="'.L_G_SUPPRESSED.'"> '.L_G_SUPPRESSED;
                ?>&nbsp;</td>
            <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $data['imps_all']?>&nbsp;</td>
            <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $data['imps_unique']?>&nbsp;</td>
            <?php if($this->a_clickSaveSupported) { ?>
                <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $data['clicks']?>&nbsp;</td>
            <?php }?>
            <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $data['sales']?>&nbsp;</td>            
            <td class="listresult2" align="right" nowrap>&nbsp;<?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['commission'])?>&nbsp;</td>
            <td class="listresult2" align="right" nowrap>&nbsp;<?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['totalcost'])?>&nbsp;</td>
            <?php if($this->a_clickSaveSupported) { ?>
                <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $data['clicks_imps']?> %&nbsp;</td>
                <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $data['sales_clicks']?> %&nbsp;</td>
            <?php } ?>
            </tr>
            <?php
            if ($i > ($_REQUEST['list_page']+1)*$_REQUEST['numrows']) break;
        }
        ?>
        <?php if($i == 0) { ?>
            <tr><td class=listresult2 colspan=9>&nbsp;<b><?php echo L_G_NODATA?></b></td></tr>
        <?php } ?>
        <tr><td class=settingsLine colspan=11><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
        <tr>
        <td class="listresult2" width=1% nowrap colspan="3">&nbsp;<b><?php echo L_G_SUMMARY?></b></td>
        <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $this->a_summaries['imps_all']?>&nbsp;</td>
        <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $this->a_summaries['imps_unique']?>&nbsp;</td>
        <?php if($this->a_clickSupported) { ?>
            <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $this->a_summaries['clicks']?>&nbsp;</td>
        <?php } ?> 
        <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $this->a_summaries['sales']?>&nbsp;</td>
        <td class="listresult2" align="right" nowrap>&nbsp;<?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->a_summaries['commission'])?>&nbsp;</td>
        <td class="listresult2" align="right" nowrap>&nbsp;<?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->a_summaries['totalcost'])?>&nbsp;</td>  
        <td class=listresultBorderRight width=1% colspan=2></td>          
        </tr>      
        </table>
<br>
</form>
