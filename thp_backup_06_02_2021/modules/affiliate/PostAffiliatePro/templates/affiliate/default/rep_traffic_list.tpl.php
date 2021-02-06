<table class="listing" border=0 cellspacing=0 cellpadding=1 style="border-top: 0px; border-bottom: 0px;" width="780">
<?php QUnit_Templates::printFilter2(50, L_G_SUMMARY); ?>
<tr class="listrow<?php echo ($j++)%2?>">
  <td width=20% align=left valign=top>&nbsp;<b><?php echo $this->a_impData['xtitle']?></b>&nbsp;</td>
  <td width=20% align=right valign=top nowrap>&nbsp;<b><?php echo L_G_IMPRESSIONS?><br><?php echo L_G_IMPUNIQUEALL?></b>&nbsp;</td>
<?php if($this->a_cpmSupported) { ?>  
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?php echo L_G_MILIONIMPRESSIONS1?></b>&nbsp;</td>
<?php } ?>
<?php if($this->a_clickSupported) { ?>
  <td width=20% align=right valign=top nowrap>&nbsp;<b><?php echo L_G_CLICKS?></b>&nbsp;</td>
<?php } ?>
<?php if($this->a_saleSupported) { ?>  
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?php echo L_G_SALES?></b>&nbsp;</td>
<?php } ?>
<?php if($this->a_leadSupported) { ?>  
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?php echo L_G_LEADS?></b>&nbsp;</td>
<?php } ?>
  <td width=20% align=right valign=top nowrap>&nbsp;<b><?php echo L_G_REVENUE?></b>&nbsp;</td>
<?php if($this->a_clickSaveSupported) { ?>
  <td width=20% align=right valign=top nowrap>&nbsp;<b><?php echo L_G_CLICKS.'<br>/ '.L_G_IMPRESSIONS?></b>&nbsp;</td>
<?php } ?>
<?php if($this->a_clickSupported) { ?>  
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?php echo L_G_REVENUE.'<br>/ '.L_G_CLICKS?></b>&nbsp;</td>
<?php } ?>

<?php if($this->a_saleSupported) { ?>  
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?php echo L_G_SALES.'<br>/ '.L_G_IMPRESSIONS?></b>&nbsp;</td>
    <?php if($this->a_clickSaveSupported) { ?>
        <td width=20% align=right valign=top nowrap>&nbsp;<b><?php echo L_G_SALES.'<br>/ '.L_G_CLICKS?></b>&nbsp;</td>
    <?php } ?>
<?php } ?>

<?php if($this->a_leadSupported) { ?>
    <td width=20% align=right valign=top nowrap>&nbsp;<b><?php echo L_G_LEADS.'<br>/ '.L_G_IMPRESSIONS?></b>&nbsp;</td>
    <?php if($this->a_clickSaveSupported) { ?>
        <td width=20% align=right valign=top nowrap>&nbsp;<b><?php echo L_G_LEADS.'<br>/ '.L_G_CLICKS?></b>&nbsp;</td>
    <?php } ?>
<?php } ?>
  <td>&nbsp;&nbsp;</td>
</tr>
<?php for($i=$this->a_periodMin; $i<=$this->a_periodMax; $i++) { ?>
<tr class="listrow<?php echo ($j++)%2?>">
  <td align=left>&nbsp;
<?php switch($this->a_reportType) {
    case 'monthly':
        print constant($GLOBALS['wd_monthname'][$i]);
        break;
    case 'weekly':
        print constant($GLOBALS['wd_dayname'][$i]);
        break;
    default:
        print $i;
        break;
   } ?>
    &nbsp;&nbsp;
  </td>
  <td align=right nowrap><?php echo $this->a_trendData['imps'][$i]['unique']?> / <?php echo $this->a_trendData['imps'][$i]['all']?>&nbsp;&nbsp;</td>
<?php if($this->a_cpmSupported) { ?>  
    <td align=right nowrap><?php echo $this->a_trendData['cpm'][$i]?>&nbsp;&nbsp;</td>
<?php } ?>
<?php if($this->a_clickSupported) { ?>
  <td align=right nowrap><?php echo $this->a_trendData['clicks'][$i]?>&nbsp;&nbsp;</td>
<?php } ?>
<?php if($this->a_saleSupported) { ?>  
    <td align=right nowrap><?php echo $this->a_trendData['sales'][$i]?>&nbsp;&nbsp;</td>
<?php } ?>
<?php if($this->a_leadSupported) { ?>  
    <td align=right nowrap><?php echo $this->a_trendData['leads'][$i]?>&nbsp;&nbsp;</td>
<?php } ?>
  <td align=right nowrap><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->a_trendData['revenue'][$i])?>&nbsp;&nbsp;</td>
<?php if($this->a_clickSaveSupported) { ?>
  <td align=right nowrap><?php echo ($this->a_trendData['imps'][$i]['unique'] <= 0 ? '0' : _r(100*$this->a_trendData['clicks'][$i]/$this->a_trendData['imps'][$i]['unique']))?> %&nbsp;&nbsp;</td>
<?php } ?>

<?php if($this->a_clickSupported) { ?>  
    <td width=20% align=right valign=top nowrap><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(($this->a_trendData['revenue'][$i] <= 0 || $this->a_trendData['clicks'][$i] <= 0 ? '0' : _r($this->a_trendData['revenue'][$i]/$this->a_trendData['clicks'][$i])))?>&nbsp;&nbsp;</b>&nbsp;</td>
<?php } ?>
  
<?php if($this->a_saleSupported) { ?>  
  <td align=right nowrap><?php echo ($this->a_trendData['sales'][$i] <= 0 || $this->a_trendData['imps'][$i]['unique'] <= 0 ? '0' : _r(100*$this->a_trendData['sales'][$i]/$this->a_trendData['imps'][$i]['unique']))?> %&nbsp;&nbsp;</td>
  <?php if($this->a_clickSaveSupported) { ?>
    <td align=right nowrap><?php echo ($this->a_trendData['clicks'][$i] <= 0 || $this->a_trendData['clicks'][$i] <= 0 ? '0' : _r(100*$this->a_trendData['sales'][$i]/$this->a_trendData['clicks'][$i]))?> %&nbsp;&nbsp;</td>
  <?php } ?>
<?php } ?>

<?php if($this->a_leadSupported) { ?>  
  <td align=right nowrap><?php echo ($this->a_trendData['leads'][$i] <= 0 || $this->a_trendData['imps'][$i]['unique'] <= 0 ? '0' : _r(100*$this->a_trendData['leads'][$i]/$this->a_trendData['imps'][$i]['unique']))?> %&nbsp;&nbsp;</td>
  <?php if($this->a_clickSaveSupported) { ?>
    <td align=right nowrap><?php echo ($this->a_trendData['clicks'][$i] <= 0 || $this->a_trendData['clicks'][$i] <= 0 ? '0' : _r(100*$this->a_trendData['leads'][$i]/$this->a_trendData['clicks'][$i]))?> %&nbsp;&nbsp;</td>
  <?php } ?>
<?php } ?>
  <td>&nbsp;&nbsp;</td>
</tr>
<?php } ?>
</table>
<table class="listing" border=0 cellspacing=0 cellpadding=0 style="border-top: 0px; border-bottom: 0px;" width="780">
<?php QUnit_Templates::printFilter2(L_G_IMPRESSIONS); ?>
<tr>
  <td height=150 valign=bottom>
  <?php echo $this->a_impstrend_graph?>
  </td>
</tr>
<tr>
  <td align=center bgcolor="#F3F3F3"><b><?php echo $this->a_period?></b></td>
</tr>
</table>

<?php if($this->a_cpmSupported) { ?>  
<table border=0 cellspacing=0 cellpadding=0 class="listing" style="border-top: 0px; border-bottom: 0px;" width="780">
<?php QUnit_Templates::printFilter2(L_G_MILIONIMPRESSIONS.' '.L_G_CPMCOMMISSIONTRANSACTIONS); ?>
<tr>
  <td height=150 valign=bottom>
  <?php echo $this->a_cpmstrend_graph?>
  </td>
</tr>
<tr>
  <td align=center bgcolor="#F3F3F3"><b><?php echo $this->a_period?></b></td>
</tr>
</table>
<?php } ?>

<?php if($this->a_clickSupported) { ?>
<table border=0 cellspacing=0 cellpadding=0 class="listing" style="border-top: 0px; border-bottom: 0px;" width="780">
<?php QUnit_Templates::printFilter2(L_G_CLICKS); ?>
<tr>
  <td height=150 valign=bottom>
  <?php echo $this->a_clickstrend_graph?>
  </td>
</tr>
<tr>
  <td align=center bgcolor="#F3F3F3"><b><?php echo $this->a_period?></b></td>
</tr>
</table>
<?php } ?>

<?php if($this->a_saleSupported) { ?>  
<table border=0 cellspacing=0 cellpadding=0 class="listing" style="border-top: 0px; border-bottom: 0px;" width="780">
<?php QUnit_Templates::printFilter2(L_G_SALES); ?>
<tr>
  <td height=150 valign=bottom>
  <?php echo $this->a_salestrend_graph?>
  </td>
</tr>
<tr>
  <td align=center bgcolor="#F3F3F3"><b><?php echo $this->a_period?></b></td>
</tr>
</table>
<?php } ?>

<?php if($this->a_leadSupported) { ?>
<table border=0 cellspacing=0 cellpadding=0 class="listing" style="border-top: 0px; border-bottom: 0px;" width="780">
<?php QUnit_Templates::printFilter2(L_G_LEADS); ?>
<tr>
  <td height=150 valign=bottom>
  <?php echo $this->a_leadstrend_graph?>
  </td>
</tr>
<tr>
  <td align=center bgcolor="#F3F3F3"><b><?php echo $this->a_period?></b></td>
</tr>
</table>
<?php } ?>

<table border=0 cellspacing=0 cellpadding=0 class="listing" style="border-top: 0px;" width="780">
<?php QUnit_Templates::printFilter2(L_G_REVENUE.' '.L_G_IN.' '.$this->a_Auth->getSetting('Aff_system_currency')); ?>
<tr>
  <td height=150 valign=bottom>
  <?php echo $this->a_revenuetrend_graph?>
  </td>
</tr>
<tr>
  <td align=center bgcolor="#F3F3F3"><b><?php echo $this->a_period?></b></td>
</tr>
</table>
