
	<table class=listing border=0 cellspacing=0 cellpadding=1 width="780">
    <tr>
	  <td colspan=11 align=center>
        <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
      </td>
    </tr>  
    <tr><td class=settingsLine colspan=11><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>        
    <tr align="center">
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_TRANSID?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_CAMOUNT?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_TOTALCOST?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_ORDERID?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_CREATED?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_TYPE?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_IP?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_STATUS?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_DATA1?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_DATA2?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_DATA3?></b></td>
    </tr>
    <tr><td class=settingsLine colspan=11><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
        
        <?php
        $i = 0;
		while($data=$this->a_list_data->getNextRecord())
        {
        ?>    
			<tr class="listrow<?php echo ($i++)%2?>">
            <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $data['transid']?>&nbsp;
                <?php showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_TransactionManager&action=transdetails&tid=".$data['transid'], 300);?></td>
            <td class="listresult2<?php echo ($data['commission'] < 0) ? ' minusCost' : ''?>" align=right nowrap><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['commission']))?>&nbsp;</td>
            <td class="listresult2" align=right nowrap><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['totalcost']))?>&nbsp;</td>
            <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $data['orderid']?>&nbsp;</td>
            <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $data['datecreated']?>&nbsp;</td>
            <td class="listresult2" align="center" nowrap>&nbsp;
            <?php      
            if($data['transkind'] > TRANSKIND_SECONDTIER)
                print L_G_SECONDTIER.' ';
            
            print $GLOBALS['Auth']->getComposedCommissionTypeString($data['transtype']);
            if ($data['count'] > 1) print ' * '.$data['count'];            
            ?>  
            &nbsp;</td>
            <td class="listresult2" align="left">&nbsp;
            <?php if($this->a_geo_allowed && ($data['ip'] != '') && ($this->a_country_info[$data['countrycode']]['countryname'] != '')) {
                   print substr($data['ip'], 0, 5)."&nbsp;&nbsp;<a name=\"row_".$data['transid']."_caption\" id=\"c4\" title=\"more\"
                         href=\"javascript: showInfoRow('c4', 'row_".$data['transid']."', '&nbsp;<b>".L_G_IP."</b> ".$data['ip']." &nbsp;&nbsp;&nbsp;<b>".L_G_COUNTRY.":</b> ".$this->a_country_info[$data['countrycode']]['countryname']."',
                                '<img src=".$this->a_this->getImage('icon_more.gif').">', '<img src=".$this->a_this->getImage('icon_less.gif').">');\"><img src=".$this->a_this->getImage('icon_more.gif')."></a>";
               } else {
                   print $data['ip'];
            } ?>&nbsp;</td>
            <td class="listresult2" nowrap>&nbsp;
            <?php      
            if($data['payoutstatus'] == AFFSTATUS_APPROVED)
            {
                print '<img src="'.$this->a_this->getImage('sphore_active.png').'" title="'.L_G_PAID.'" alt="'.L_G_PAID.'"> '.L_G_PAID;
                $totalPaid += $data['commission'];
            }
            else
            {
                if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print '<img src="'.$this->a_this->getImage('sphore_pending.png').'" title="'.L_G_WAITINGAPPROVAL.'" alt="'.L_G_WAITINGAPPROVAL.'"> '.L_G_WAITINGAPPROVAL;
                else if($data['rstatus'] == AFFSTATUS_APPROVED) print '<img src="'.$this->a_this->getImage('sphore_active.png').'" title="'.L_G_APPROVED.'" alt="'.L_G_APPROVED.'"> '.L_G_APPROVED;
                else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print '<img src="'.$this->a_this->getImage('sphore_declined.png').'" title="'.L_G_SUPPRESSED.'" alt="'.L_G_SUPPRESSED.'"> '.L_G_SUPPRESSED;
                
                if($data['rstatus'] == AFFSTATUS_SUPPRESSED || $data['payoutstatus'] == AFFSTATUS_SUPPRESSED)
                $totalDeclined += $data['commission'];
                else
                $totalWaiting += $data['commission'];
            }
            ?>
            &nbsp;</td>
            <td class="listresult2">&nbsp;
            <?php if (strlen($data['data1']) > 10) {
                   print substr($data['data1'], 0, 5)."&nbsp;&nbsp;<a name=\"row_".$data['transid']."_caption\" id=\"c1\" title=\"more\"
                         href=\"javascript: showInfoRow('c1', 'row_".$data['transid']."', '&nbsp;<b>".L_G_DATA1.":</b>".$data['data1']."',
                                '<img src=".$this->a_this->getImage('icon_more.gif').">', '<img src=".$this->a_this->getImage('icon_less.gif').">');\"><img src=".$this->a_this->getImage('icon_more.gif')."></a>";
               } else {
                   print $data['data1'];
               } ?>&nbsp;</td>
            <td class="listresult2">&nbsp;
            <?php if (strlen($data['data2']) > 10) {
                   print substr($data['data2'], 0, 5)."&nbsp;&nbsp;<a name=\"row_".$data['transid']."_caption\" id=\"c2\" title=\"more\"
                         href=\"javascript: showInfoRow('c2', 'row_".$data['transid']."', '&nbsp;<b>".L_G_DATA2.":</b>".$data['data2']."',
                                '<img src=".$this->a_this->getImage('icon_more.gif').">', '<img src=".$this->a_this->getImage('icon_less.gif').">');\"><img src=".$this->a_this->getImage('icon_more.gif')."></a>";
               } else {
                   print $data['data2'];
               } ?>&nbsp;</td>
            <td class="listresult2">&nbsp;
            <?php if (strlen($data['data3']) > 10) {
                   print substr($data['data3'], 0, 5)."&nbsp;&nbsp;<a name=\"row_".$data['transid']."_caption\" id=\"c3\" title=\"more\"
                         href=\"javascript: showInfoRow('c3', 'row_".$data['transid']."', '&nbsp;<b>".L_G_DATA3.":</b>".$data['data3']."',
                                '<img src=".$this->a_this->getImage('icon_more.gif').">', '<img src=".$this->a_this->getImage('icon_less.gif').">');\"><img src=".$this->a_this->getImage('icon_more.gif')."></a>";
               } else {
                   print $data['data3'];
               } ?>&nbsp;</td>
            </tr>
            <tr id="row_<?php echo $data['transid']?>" style="display: none;" class="listrow<?php echo ($i+1)%2?>">
                <td id="row_<?php echo $data['transid']?>_td" class="listresult2" colspan="11" align="right"></td>
            </tr>
            <?php
        }
        ?>
        <?php if($i == 0) { ?>
            <tr><td class=listresult2 colspan=11>&nbsp;<b><?php echo L_G_NODATA?></b></td></tr>
        <?php } ?>
        <tr><td class=settingsLine colspan=11><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
        <tr>
        <td class=listresult2 width=1% nowrap>&nbsp;<b><?php echo L_G_SUMMARY?></b></td>
        <td class=listresult2 width=1% align=right nowrap><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_summaries['paid']+$this->a_summaries['approved']+$this->a_summaries['pending']+$this->a_summaries['reversed']))?>&nbsp;</td>
        <td class=listresult2 width=1% align=right nowrap><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_summaries['totalcost']))?>&nbsp;</td>
        <td class=listresultBorderRight width=1% colspan=8></td>
        </tr>      
        <tr>
        <td class=listresult2 width=1%>&nbsp;<b><?php echo L_G_WAITING?></b></td>
        <td class=listresult2 width=1% align=right nowrap><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_summaries['pending']))?>&nbsp;</td>
        <td class=listresult2 width=1%>&nbsp;</td>
        <td class=listresultBorderRight width=1% colspan=8></td>
        </tr>      
        <tr>
        <td class=listresult2 width=1%>&nbsp;<b><?php echo L_G_APPROVED?></b></td>
        <td class=listresult2 width=1% align=right nowrap><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_summaries['approved']))?>&nbsp;</td>
        <td class=listresult2 width=1%>&nbsp;</td>
        <td class=listresultBorderRight width=1% colspan=8></td>
        </tr>      
        <tr>
        <td class=listresult2 width=1%>&nbsp;<b><?php echo L_G_PAID?></b></td>
        <td class=listresult2 width=1% align=right nowrap><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_summaries['paid']))?>&nbsp;</td>
        <td class=listresult2 width=1%>&nbsp;</td>
        <td class=listresultBorderRight width=1% colspan=8></td>
        </tr>      
        <tr>
        <td class=listresult2 width=1%>&nbsp;<b><?php echo L_G_SUPPRESSED?></b></td>
        <td class=listresult2 width=1% align=right nowrap><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_summaries['reversed']))?>&nbsp;</td>
        <td class=listresult2 width=1%>&nbsp;</td>
        <td class=listresultBorderRight width=1% colspan=8></td>
        </tr>      
        </table>
<br>
</form>
