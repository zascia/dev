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
    <td align=center valign=middle bgcolor="#F3F3F3"><?php echo L_G_ALL?></td>
    <td align=center valign=middle bgcolor="#F3F3F3"><?php echo L_G_UNIQUE?></td>
  </tr>
  </table>
  </td>
</tr>
<tr>
  <td align=center><b><?php echo $this->a_period?></b></td>
</tr>
<tr>
  <td align=center bgcolor="#F3F3F3">
  <br/><br/>
  <table class=listing border=0 cellspacing=0 cellpadding=1 style="border-top: 0px; border-bottom: 0px;" width="80%" align=center>
    <tr>
        <td class=listheaderLineTop>&nbsp;</td>
        <td class=listheaderLineTop><?php echo L_G_COUNTRY?></td>
        <td class=listheaderLineTop width="10%"><?php echo L_G_IMPRESSIONS?> <?php echo '('.L_G_ALL.' / '.L_G_UNIQUE.')'?></td>
    </tr>  
  <?php $k = 0;
     if(count($this->a_impstop_all_data) > 0) {
     foreach($this->a_impstop_all_data as $country => $data) { 
  ?>
      
        <tr class="listrow<?php echo ($k++)%2?>">
            <td class=listresultnocenter align=center valign=middle>
                <table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#<?php echo $this->a_seriesColor[count($this->a_impstop_all_data)-$k]?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td></tr></table>
            </td>
            <td class=listresultnocenter align=left>
                    <font color="#0000ff">&nbsp;<?php echo $this->a_found_countries[$country]['countryname']?></font>
            </td>
            <td class=listresultnocenter align=right><?php echo $this->a_impstop_all_data[$country]?>&nbsp;/&nbsp;<?php echo $this->a_impstop_unique_data[$country]?></td>
        </tr>
  <?php }
     } else {
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
</table>
<?php } ?>


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
  <td align=center bgcolor="#F3F3F3">
  <br/><br/>
  <table class=listing border=0 cellspacing=0 cellpadding=1 style="border-top: 0px; border-bottom: 0px;" width="80%" align=center>
    <tr>
        <td class=listheaderLineTop>&nbsp;</td>
        <td class=listheaderLineTop><?php echo L_G_COUNTRY?></td>
        <td class=listheaderLineTop width="10%"><?php echo L_G_CLICKS?></td>
    </tr>  
  <?php $k=0;
     if(count($this->a_clickstop_data['labels']) > 0) {
     foreach($this->a_clickstop_data['labels'] as $key => $data) { 
  ?>
      
        <tr class="listrow<?php echo ($k++)%2?>">
            <td class=listresultnocenter align=center valign=middle><table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#<?php echo $this->a_seriesColor[count($this->a_clickstop_data['labels'])-$k]?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td></tr></table></td>
            <td class=listresultnocenter align=left>
                    <font color="#0000ff">&nbsp;<?php echo $this->a_clickstop_data['labels'][$key]?></font>
            </td>
            <td class=listresultnocenter align=right><?php echo $this->a_clickstop_data['values'][$key]?></td>
        </tr>
  <?php } 
     } else {
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
  <td align=center bgcolor="#F3F3F3">
  <br/><br/>
  <table class=listing border=0 cellspacing=0 cellpadding=1 style="border-top: 0px; border-bottom: 0px;" width="80%" align=center>
    <tr>
        <td class=listheaderLineTop>&nbsp;</td>
        <td class=listheaderLineTop><?php echo L_G_COUNTRY?></td>
        <td class=listheaderLineTop width="10%"><?php echo L_G_SALES?></td>
    </tr>  
  <?php $k = 0;
     if(count($this->a_salestop_data['labels']) > 0) {
     foreach($this->a_salestop_data['labels'] as $key => $data) { 
  ?>
      
        <tr class="listrow<?php echo ($k++)%2?>">
            <td class=listresultnocenter align=center valign=middle>
            <table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#<?php echo $this->a_seriesColor[count($this->a_salestop_data['labels'])-$k]?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td></tr></table></td>
            <td class=listresultnocenter align=left>
                    <font color="#0000ff">&nbsp;<?php echo $this->a_salestop_data['labels'][$key]?></font>
            </td>
            <td class=listresultnocenter align=right><?php echo $this->a_salestop_data['values'][$key]?></td>
        </tr>
  <?php } 
     } else {
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
  <td align=center bgcolor="#F3F3F3">
  <br/><br/>
  <table class=listing border=0 cellspacing=0 cellpadding=1 style="border-top: 0px; border-bottom: 0px;" width="80%" align=center>
    <tr>
        <td class=listheaderLineTop>&nbsp;</td>
        <td class=listheaderLineTop><?php echo L_G_COUNTRY?></td>
        <td class=listheaderLineTop width="10%"><?php echo L_G_LEADS?></td>
    </tr>  
  <?php $k = 0;
     if(count($this->a_leadstop_data['labels']) > 0) {
     foreach($this->a_leadstop_data['labels'] as $key => $data) { 
  ?>
      
        <tr class="listrow<?php echo ($k++)%2?>">
            <td class=listresultnocenter align=center valign=middle><table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#<?php echo $this->a_seriesColor[count($this->a_leadstop_data['labels'])-$k]?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td></tr></table></td>
            <td class=listresultnocenter align=left>
                    <font color="#0000ff"><?php echo $this->a_leadstop_data['labels'][$key]?></font>
            </td>
            <td class=listresultnocenter align=right><?php echo $this->a_leadstop_data['values'][$key]?></td>
        </tr>
  <?php } 
     } else {
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
  <td align=center bgcolor="#F3F3F3">
  <br/><br/>
  <table class=listing border=0 cellspacing=0 cellpadding=1 style="border-top: 0px; border-bottom: 0px;" width="80%" align=center>
    <tr>
        <td class=listheaderLineTop>&nbsp;</td>
        <td class=listheaderLineTop><?php echo L_G_COUNTRY?></td>
        <td class=listheaderLineTop width="10%">&nbsp;<?php echo L_G_REVENUES?>&nbsp;</td>
    </tr>  
  <?php $k=0;
     if(count($this->a_revenuetop_data['labels']) > 0) {
     foreach($this->a_revenuetop_data['labels'] as $key => $data) { 
  ?>
      
        <tr class="listrow<?php echo ($k++)%2?>">
            <td class=listresultnocenter align=center valign=middle><table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#<?php echo $this->a_seriesColor[count($this->a_revenuetop_data['labels'])-$k]?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td></tr></table></td>
            <td class=listresultnocenter align=left>
                    <font color="#0000ff">&nbsp;<?php echo $this->a_revenuetop_data['labels'][$key]?></font>
            </td>
            <td class=listresultnocenter align=right><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->a_revenuetop_data['values'][$key])?></td>
        </tr>
  <?php } 
     } else {
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