<table border=0 cellspacing=0 cellpadding=0 width="780" class="listing" style="border-top: 0px; border-bottom: 0px;">
<?php QUnit_Templates::printFilter2(L_G_IMPRESSIONS.' '.L_G_SORTEDBYUNIQUE); ?>
<tr>
  <td height=150 valign=bottom>
  <table border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td align=center valign=top>
    <?php echo $this->a_impstop_graph?>
    </td><td align=center valign=top>
    <?php echo $this->a_impstopunique_graph?>
    </td>
  </tr><tr>
    <td align=center valign=middle bgcolor="#FFFFFF"><?php echo L_G_ALL?></td>
    <td align=center valign=middle bgcolor="#FFFFFF"><?php echo L_G_UNIQUE?></td>
  </tr>
  </table>
  </td>
</tr>
<tr>
  <td align=center><b><?php echo $this->a_period?></b></td>
</tr>
<tr>
  <td align=center bgcolor="#FFFFFF">
  <br/><br/>
  <table class=listing border=0 cellspacing=0 cellpadding=1 style="border-top: 0px; border-bottom: 0px;" width="80%" align=center>
    <tr>
        <td class=listheaderLineTop>&nbsp;</td>
        <td class=listheaderLineTop><?php echo L_G_AFFILIATE?></td>
        <td class=listheaderLineTop width="10%"><?php echo L_G_IMPRESSIONS?> <?php echo '('.L_G_ALL.' / '.L_G_UNIQUE.')'?></td>
    </tr>
  <?php foreach($this->a_impstop_data as $k => $data) {
        if($data['userid'] == '0' && $data['all'] == 0) continue; // skip empty others
  ?>

        <tr class="listrow<?php echo ($k++)%2?>">
            <td class=listresultnocenter align=center valign=middle><table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#<?php echo $this->a_seriesColor[count($this->a_impstop_data)-$k]?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td></tr></table></td>
            <td class=listresultnocenter align=left>
                    <font color="#0000ff">&nbsp;<?php echo $data['surname'].($data['name'] != '' ? ', ' : '').$data['name']?></font>
                    <?php  if($data['userid'] != '' && $data['userid'] != '0') {
                            showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affalldetails&aid=".$data['userid'], 300);
                        }
                    ?>
            </td>
            <td class=listresultnocenter align=right>&nbsp;<?php echo $data['all']?>&nbsp;/&nbsp;<?php echo $data['unique']?>&nbsp;</td>
        </tr>
  <?php }
     if(count($this->a_impstop_data) == 1 && $this->a_impstop_data[0][userid] == 0) {
?>
        <tr class="listrow2">
            <td class=listresultnocenter colspan=3 align=center>
            <?php echo L_G_NODATA?>
            </td>
        </tr>
<?php
     }
  ?>
  </table>
  <br/><br/>
  </td>
</tr>
</table>

<?php if($this->a_cpmSupported) { ?>
<table border=0 cellspacing=0 cellpadding=0 width="780" class="listing" style="border-top: 0px; border-bottom: 0px;">
<?php QUnit_Templates::printFilter2(L_G_MILIONIMPRESSIONS.' '.L_G_CPMCOMMISSIONTRANSACTIONS); ?>
<tr>
  <td height=150 valign=bottom>
  <?php echo $this->a_cpmtop_graph?>
  </td>
</tr>
<tr>
  <td align=center><b><?php echo $this->a_period?></b></td>
</tr>
<tr>
  <td align=center bgcolor="#FFFFFF">
  <br/><br/>
  <table class=listing border=0 cellspacing=0 cellpadding=1 style="border-top: 0px; border-bottom: 0px;" width="80%" align=center>
    <tr>
        <td class=listheaderLineTop>&nbsp;</td>
        <td class=listheaderLineTop><?php echo L_G_AFFILIATE?></td>
        <td class=listheaderLineTop width="10%"><?php echo L_G_CPM?></td>
    </tr>
  <?php foreach($this->a_cmptop_data as $k => $data) {
        if($data['userid'] == '0' && $data['count'] == 0) continue; // skip empty others
  ?>

        <tr class="listrow<?php echo ($k++)%2?>">
            <td class=listresultnocenter align=center valign=middle><table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#<?php echo $this->a_seriesColor[count($this->a_clickstop_data)-$k]?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td></tr></table></td>
            <td class=listresultnocenter align=left>
                    <font color="#0000ff">&nbsp;<?php echo $data['surname'].($data['name'] != '' ? ', ' : '').$data['name']?></font>
                    <?php  if($data['userid'] != '' && $data['userid'] != '0') {
                            showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affalldetails&aid=".$data['userid'], 300);
                        }
                    ?>
            </td>
            <td class=listresultnocenter align=right>&nbsp;<?php echo $data['count']?>&nbsp;</td>
        </tr>
  <?php }
     if(count($this->a_cmptop_data) == 1 && $this->a_cmptop_data[0][userid] == 0) {
?>
        <tr class="listrow2">
            <td class=listresultnocenter colspan=3 align=center>
            <?php echo L_G_NODATA?>
            </td>
        </tr>
<?php
     }
  ?>
  </table>
  <br/><br/>
  </td>
</tr>
</table>
<?php } ?>

<?php if($this->a_clickSupported) { ?>
<table border=0 cellspacing=0 cellpadding=0 width="780" class="listing" style="border-top: 0px; border-bottom: 0px;">
<?php QUnit_Templates::printFilter2(L_G_CLICKS); ?>
<tr>
  <td height=150 valign=bottom>
  <?php echo $this->a_clickstop_graph?>
  </td>
</tr>
<tr>
  <td align=center><b><?php echo $this->a_period?></b></td>
</tr>
<tr>
  <td align=center bgcolor="#FFFFFF">
  <br/><br/>
  <table class=listing border=0 cellspacing=0 cellpadding=1 style="border-top: 0px; border-bottom: 0px;" width="80%" align=center>
    <tr>
        <td class=listheaderLineTop>&nbsp;</td>
        <td class=listheaderLineTop><?php echo L_G_AFFILIATE?></td>
        <td class=listheaderLineTop width="10%"><?php echo L_G_CLICKS?></td>
    </tr>
  <?php foreach($this->a_clickstop_data as $k => $data) {
        if($data['userid'] == '0' && $data['count'] == 0) continue; // skip empty others
  ?>

        <tr class="listrow<?php echo ($k++)%2?>">
            <td class=listresultnocenter align=center valign=middle><table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#<?php echo $this->a_seriesColor[count($this->a_clickstop_data)-$k]?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td></tr></table></td>
            <td class=listresultnocenter align=left>
                    <font color="#0000ff">&nbsp;<?php echo $data['surname'].($data['name'] != '' ? ', ' : '').$data['name']?></font>
                    <?php  if($data['userid'] != '' && $data['userid'] != '0') {
                            showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affalldetails&aid=".$data['userid'], 300);
                        }
                    ?>
            </td>
            <td class=listresultnocenter align=right>&nbsp;<?php echo $data['count']?>&nbsp;</td>
        </tr>
  <?php }
     if(count($this->a_clickstop_data) == 1 && $this->a_clickstop_data[0][userid] == 0) {
?>
        <tr class="listrow2">
            <td class=listresultnocenter colspan=3 align=center>
            <?php echo L_G_NODATA?>
            </td>
        </tr>
<?php
     }
  ?>
  </table>
  <br/><br/>
  </td>
</tr>
</table>
<?php } ?>

<?php if($this->a_saleSupported) { ?>
<table border=0 cellspacing=0 cellpadding=0 width="780" class="listing" style="border-top: 0px; border-bottom: 0px;">
<?php QUnit_Templates::printFilter2(L_G_SALES); ?>
<tr>
  <td height=150 valign=bottom>
  <?php echo $this->a_salestop_graph?>
  </td>
</tr>
<tr>
  <td align=center><b><?php echo $this->a_period?></b></td>
</tr>
<tr>
  <td align=center bgcolor="#FFFFFF">
  <br/><br/>
  <table class=listing border=0 cellspacing=0 cellpadding=1 style="border-top: 0px; border-bottom: 0px;" width="80%" align=center>
    <tr>
        <td class=listheaderLineTop>&nbsp;</td>
        <td class=listheaderLineTop><?php echo L_G_AFFILIATE?></td>
        <td class=listheaderLineTop width="10%"><?php echo L_G_SALES?></td>
    </tr>
  <?php foreach($this->a_salestop_data as $k => $data) {
        if($data['userid'] == '0' && $data['count'] == 0) continue; // skip empty others
  ?>

        <tr class="listrow<?php echo ($k++)%2?>">
            <td class=listresultnocenter align=center valign=middle>
            <table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#<?php echo $this->a_seriesColor[count($this->a_salestop_data)-$k]?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td></tr></table></td>
            <td class=listresultnocenter align=left>
                    <font color="#0000ff">&nbsp;<?php echo $data['surname'].($data['name'] != '' ? ', ' : '').$data['name']?></font>
                    <?php  if($data['userid'] != '' && $data['userid'] != '0') {
                            showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affalldetails&aid=".$data['userid'], 300);
                        }
                    ?>
            </td>
            <td class=listresultnocenter align=right>&nbsp;<?php echo $data['count']?>&nbsp;</td>
        </tr>
  <?php }
     if(count($this->a_salestop_data) == 1 && $this->a_salestop_data[0][userid] == 0) {
?>
        <tr class="listrow2">
            <td class=listresultnocenter colspan=3 align=center>
            <?php echo L_G_NODATA?>
            </td>
        </tr>
<?php
     }
  ?>
  </table>
  <br/><br/>
  </td>
</tr>
</table>
<?php } ?>

<?php if($this->a_leadSupported) { ?>
<table border=0 cellspacing=0 cellpadding=0 width="780" class="listing" style="border-top: 0px; border-bottom: 0px;">
<?php QUnit_Templates::printFilter2(L_G_LEADS); ?>
<tr>
  <td height=150 valign=bottom>
  <?php echo $this->a_leadstop_graph?>
  </td>
</tr>
<tr>
  <td align=center><b><?php echo $this->a_period?></b></td>
</tr>
<tr>
  <td align=center bgcolor="#FFFFFF">
  <br/><br/>
  <table class=listing border=0 cellspacing=0 cellpadding=1 style="border-top: 0px; border-bottom: 0px;" width="80%" align=center>
    <tr>
        <td class=listheaderLineTop>&nbsp;</td>
        <td class=listheaderLineTop><?php echo L_G_AFFILIATE?></td>
        <td class=listheaderLineTop width="10%"><?php echo L_G_LEADS?></td>
    </tr>
  <?php foreach($this->a_leadstop_data as $k => $data) {
        if($data['userid'] == '0' && $data['count'] == 0) continue; // skip empty others
  ?>

        <tr class="listrow<?php echo ($k++)%2?>">
            <td class=listresultnocenter align=center valign=middle><table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#<?php echo $this->a_seriesColor[count($this->a_leadstop_data)-$k]?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td></tr></table></td>
            <td class=listresultnocenter align=left>
                    <font color="#0000ff">&nbsp;<?php echo $data['surname'].($data['name'] != '' ? ', ' : '').$data['name']?></font>
                    <?php  if($data['userid'] != '' && $data['userid'] != '0') {
                            showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affalldetails&aid=".$data['userid'], 300);
                        }
                    ?>
            </td>
            <td class=listresultnocenter align=right>&nbsp;<?php echo $data['count']?>&nbsp;</td>
        </tr>
  <?php }
     if(count($this->a_leadstop_data) == 1 && $this->a_leadstop_data[0][userid] == 0) {
?>
        <tr class="listrow2">
            <td class=listresultnocenter colspan=3 align=center>
            <?php echo L_G_NODATA?>
            </td>
        </tr>
<?php
     }
  ?>
  </table>
  <br/><br/>
  </td>
</tr>
</table>
<?php } ?>

<table border=0 cellspacing=0 cellpadding=0 width="780" class="listing" style="border-top: 0px;">
<?php QUnit_Templates::printFilter2(L_G_REVENUES.' '.L_G_IN.' '.$this->a_Auth->getSetting('Aff_system_currency')); ?>
<tr>
  <td height=150 valign=bottom>
  <?php echo $this->a_revenuetop_graph?>
  </td>
</tr>
<tr>
  <td align=center><b><?php echo $this->a_period?></b></td>
</tr>
<tr>
  <td align=center bgcolor="#FFFFFF">
  <br/><br/>
  <table class=listing border=0 cellspacing=0 cellpadding=1 style="border-top: 0px; border-bottom: 0px;" width="80%" align=center>
    <tr>
        <td class=listheaderLineTop>&nbsp;</td>
        <td class=listheaderLineTop><?php echo L_G_AFFILIATE?></td>
        <td class=listheaderLineTop width="10%">&nbsp;<?php echo L_G_REVENUES?>&nbsp;</td>
    </tr>
  <?php foreach($this->a_revenuetop_data as $k => $data) {
        if($data['userid'] == '0' && $data['sum'] == 0) continue; // skip empty others
  ?>

        <tr class="listrow<?php echo ($k++)%2?>">
            <td class=listresultnocenter align=center valign=middle><table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#<?php echo $this->a_seriesColor[count($this->a_revenuetop_data)-$k]?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td></tr></table></td>
            <td class=listresultnocenter align=left>
                    <font color="#0000ff">&nbsp;<?php echo $data['surname'].($data['name'] != '' ? ', ' : '').$data['name']?></font>
                    <?php  if($data['userid'] != '' && $data['userid'] != '0') {
                            showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affalldetails&aid=".$data['userid'], 300);
                        }
                    ?>
            </td>
            <td class=listresultnocenter align=right>&nbsp;<?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['sum'])?>&nbsp;</td>
        </tr>
  <?php }
     if(count($this->a_revenuetop_data) == 1 && $this->a_revenuetop_data[0][userid] == 0) {
?>
        <tr class="listrow2">
            <td class=listresultnocenter colspan=3 align=center>
            <?php echo L_G_NODATA?>
            </td>
        </tr>
<?php
     }
  ?>
  </table>
  <br/><br/>
  </td>
</tr>
</table>
<br><br>