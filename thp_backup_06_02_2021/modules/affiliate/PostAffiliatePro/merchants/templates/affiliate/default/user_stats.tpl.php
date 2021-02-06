        <table border=0 class=listing cellspacing=0 cellpadding=2 width=100% style="margin-bottom: 4px">
        <?php QUnit_Templates::printFilter(4, L_G_AFFSTATS); ?>
        <?php $this->fieldRow->useRowParity = true; ?>
        <?php $this->fieldRow->resetRowParity(); ?>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText><b>&nbsp;</b></td>
          <td class=formText align="center"><b>Today</b></td>
          <td class=formText align="center"><b>This month</b></td>
          <td class=formText align="center"><b>All</b></td>
        </tr>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText align="left">&nbsp;<b><?php echo L_G_IMPRESSIONS;?></b>&nbsp;</td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[0]['impressions'];?></td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[1]['impressions'];?></td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[2]['impressions'];?></td>
        </tr>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText align="left">&nbsp;<b><?php echo L_G_CLICKS;?></b>&nbsp;</td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[0]['clicks'];?></td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[1]['clicks'];?></td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[2]['clicks'];?></td>
        </tr>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText align="left">&nbsp;<b><?php echo L_G_SALES;?></b>&nbsp;</td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[0]['sales'];?></td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[1]['sales'];?></td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[2]['sales'];?></td>
        </tr>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText align="left">&nbsp;<b><?php echo L_G_LEADS;?></b>&nbsp;</td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[0]['leads'];?></td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[1]['leads'];?></td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[2]['leads'];?></td>
        </tr>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText align="left">&nbsp;<b><?php echo L_G_RATIO?></b>&nbsp;</td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[0]['ratio'];?></td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[1]['ratio'];?></td>
          <td class=formText align="center">&nbsp;<?php echo $this->stats[2]['ratio'];?></td>
        </tr>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText align="left">&nbsp;<b><?php echo L_G_SALES_CLICKS_RATIO;?></b>&nbsp;</td>
          <td class=formText align="center">&nbsp;<?php echo ($this->stats[0]['clicks'] == 0.0 ? '0.0' : _rnd(($this->stats[0]['sales']/$this->stats[0]['clicks'])*100.0));?></td>
          <td class=formText align="center">&nbsp;<?php echo ($this->stats[1]['clicks'] == 0.0 ? '0.0' : _rnd(($this->stats[1]['sales']/$this->stats[1]['clicks'])*100.0));?></td>
          <td class=formText align="center">&nbsp;<?php echo ($this->stats[2]['clicks'] == 0.0 ? '0.0' : _rnd(($this->stats[2]['sales']/$this->stats[2]['clicks'])*100.0));?></td>
        </tr>
        <?php echo  $this->fieldRow->trWithBgColor(); ?>
          <td class=formText align="left">&nbsp;<b><?php echo L_G_REVENUE?></b>&nbsp;</td>
          <td class=formText align="center">&nbsp;<?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->stats[0]['revenue_approved']);?></td>
          <td class=formText align="center">&nbsp;<?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->stats[1]['revenue_approved']);?></td>
          <td class=formText align="center">&nbsp;<?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->stats[2]['revenue_approved']);?></td>
        </tr>
        </table>