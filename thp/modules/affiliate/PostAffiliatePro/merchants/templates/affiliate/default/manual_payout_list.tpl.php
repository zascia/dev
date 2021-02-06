<form name=FilterForm id=FilterForm  action=index.php method=get>
    <table class=listing border=0 cellspacing=0 cellpadding=1 width=780 style="border-top-width: 0">
    <tr>
      <td colspan=10 align=center>
        <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
      </td>
    </tr>
    <tr><td class=settingsLine colspan=10><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
    <tr align="center">
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_TRANSID?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_CAMOUNT?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_TOTALCOST?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_ORDERID?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_CREATED?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_TYPE?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_IP?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_DATA1?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_DATA2?></b></td>
        <td class="listresult2" width=1% nowrap><b><?php echo L_G_DATA3?></b></td>
    </tr>
    <tr><td class=settingsLine colspan=10><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>

        <?php
        $i = 0;
        while($data=$this->a_list_data->getNextRecord())
        {
        ?>
            <tr class="listrow<?php echo ($i++)%2?>">
            <td class="listresult2" align="right">&nbsp;<?php echo $data['transid']?><?php showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_TransactionManager&action=transdetails&tid=".$data['transid'], 300);?></td>
            <td class="listresult2<?php echo ($data['commission'] < 0) ? ' minusCost' : ''?>" align=right nowrap><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['commission']))?>&nbsp;</td>
            <td class="listresult2" align=right nowrap><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['totalcost']))?>&nbsp;</td>
            <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $data['orderid']?>&nbsp;</td>
            <td class="listresult2" align="right" nowrap>&nbsp;<?php echo $data['datecreated']?>&nbsp;</td>
            <td class="listresult2" align="center" nowrap>&nbsp;
            <?php
            if($data['transkind'] > TRANSKIND_SECONDTIER)
                print L_G_SECONDTIER.' ';

            print $GLOBALS['Auth']->getComposedCommissionTypeString($data['transtype']);
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
        </table>
    <input type=hidden name=commited value=yes>
    <input type=hidden name=md value='<?php echo $this->a_md?>'>
    <input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>
    <input type=hidden name=action value=manualpay>
    <input type=hidden name=showlist value=1>
</form>