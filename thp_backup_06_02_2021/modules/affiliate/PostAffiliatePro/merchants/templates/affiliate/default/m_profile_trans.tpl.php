<?php $data = $this->a_data; ?>    
    <table width="430" class=listing border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(8, L_G_STATISTICS); ?>
    <tr>
        <td class=theader align=right>&nbsp;<?php echo L_G_AFFWAITINGAPPROVAL?></td><td width=5></td>
        <td align=right>
            <?php echo ($this->a_aff_waiting > 0 ? '<a class=textlink href="index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1&umprof_status='.AFFSTATUS_NOTAPPROVED.'">'.$this->a_aff_waiting.'</a>' : 0)?>
        </td>
        <td width=30></td>
        <td class=theader align=right>&nbsp;<?php echo L_G_TRANSAPPLICATIONS?></td><td width=5></td>
        <td align=right>
            <?php echo ($this->a_trans_waiting > 0 ? '<a class=textlink href="javascript:approveTransactions();">'.$this->a_trans_waiting.'</a>' : 0)?>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan=7></td></tr>
        <tr>
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALCLICKS?></td><td width=5></td>
            <td align=right>
            <?php echo $data['clicks_approved']?>
            </td>
          <td width=30></td>
          <td class=theader align=right><?php echo L_G_TOTALIMPRESSIONS?> <?php echo L_G_IMPUNIQUEALL?></td><td width=5></td>
            <td align=right>
            <?php echo $data['unique_impressions']?> / <?php echo $data['impressions']?>
            </td>
        <td>&nbsp;</td>
        </tr>
        
<?php if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') == 1) { ?>
    <tr>
<?php      if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1)
        { 
?>        
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALAPPROVEDSALES?></td><td width=5></td>
          <td align=right>
            <?php echo $data['sales_approved']?>
          </td>
          <td width=30></td>
<?php      } 
        
        if($this->a_Auth->getSetting('Aff_support_lead_commissions') == 1)
        { 
?>
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALAPPROVEDLEADS?></td><td width=5></td>
          <td align=right>
            <?php echo $data['leads_approved']?>
          </td>
<?php
        }

        if($this->a_Auth->getSetting('Aff_support_sale_commissions') != 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') != 1) 
        {
?>
          <td colspan=4>&nbsp;</td>

<?php      } ?>
    </tr>
    <tr>
<?php      if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1)
        { 
?>        
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALWAITINGSALES?></td><td width=5></td>
          <td align=right>
            <?php echo $data['sales_waitingapproval']?>
          </td>
          <td width=30></td>
<?php      } 
        
        if($this->a_Auth->getSetting('Aff_support_lead_commissions') == 1)
        { 
?>
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALWAITINGLEADS?></td><td width=5></td>
          <td align=right>
            <?php echo $data['leads_waitingapproval']?>
          </td>
<?php
        }

        if($this->a_Auth->getSetting('Aff_support_sale_commissions') != 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') != 1) 
        {
?>
          <td colspan=4>&nbsp;</td>

<?php      } ?>
    </tr>
    <tr>
<?php      if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1)
        { 
?>        
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALDECLINEDSALES?></td><td width=5></td>
          <td align=right>
            <?php echo $data['sales_declined']?>
          </td>
          <td width=30></td>
<?php      } 
        
        if($this->a_Auth->getSetting('Aff_support_lead_commissions') == 1)
        { 
?>
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALDECLINEDLEADS?></td><td width=5></td>
          <td align=right>
            <?php echo $data['leads_declined']?>
          </td>
<?php
        }

        if($this->a_Auth->getSetting('Aff_support_sale_commissions') != 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') != 1) 
        {
?>
          <td colspan=4>&nbsp;</td>

<?php      } ?>
    </tr>
<?php } ?>

<?php if($this->a_Auth->getSetting('Aff_maxcommissionlevels') > 1) { ?>
<?php if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') == 1) { ?>
    <tr><td colspan="8" align="center"><b><?php echo L_G_SECONDTIER?><b></td></tr>
    <tr>
<?php      if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1)
        { 
?>        
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALAPPROVEDSALES?></td><td width=5></td>
          <td align=right>
            <?php echo $data['st_sales_approved']?>
          </td>
          <td width=30></td>
<?php      } 
        
        if($this->a_Auth->getSetting('Aff_support_lead_commissions') == 1)
        { 
?>
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALAPPROVEDLEADS?></td><td width=5></td>
          <td align=right>
            <?php echo $data['st_leads_approved']?>
          </td>
<?php
        }

        if($this->a_Auth->getSetting('Aff_support_sale_commissions') != 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') != 1) 
        {
?>
          <td colspan=4>&nbsp;</td>

<?php      } ?>
    </tr>
    <tr>
<?php      if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1)
        { 
?>        
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALWAITINGSALES?></td><td width=5></td>
          <td align=right>
            <?php echo $data['st_sales_waitingapproval']?>
          </td>
          <td width=30></td>
<?php      } 
        
        if($this->a_Auth->getSetting('Aff_support_lead_commissions') == 1)
        { 
?>
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALWAITINGLEADS?></td><td width=5></td>
          <td align=right>
            <?php echo $data['st_leads_waitingapproval']?>
          </td>
<?php
        }

        if($this->a_Auth->getSetting('Aff_support_sale_commissions') != 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') != 1) 
        {
?>
          <td colspan=4>&nbsp;</td>

<?php      } ?>
    </tr>
    <tr>
<?php      if($this->a_Auth->getSetting('Aff_support_sale_commissions') == 1)
        { 
?>        
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALDECLINEDSALES?></td><td width=5></td>
          <td align=right>
            <?php echo $data['st_sales_declined']?>
          </td>
          <td width=30></td>
<?php      } 
        
        if($this->a_Auth->getSetting('Aff_support_lead_commissions') == 1)
        { 
?>
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALDECLINEDLEADS?></td><td width=5></td>
          <td align=right>
            <?php echo $data['st_leads_declined']?>
          </td>
<?php
        }

        if($this->a_Auth->getSetting('Aff_support_sale_commissions') != 1 || $this->a_Auth->getSetting('Aff_support_lead_commissions') != 1) 
        {
?>
          <td colspan=4>&nbsp;</td>

<?php      } ?>
    </tr>
<?php } ?>
<?php } ?>

    <tr><td>&nbsp;</td></tr>
    
    <?php QUnit_Templates::printFilter2(8, L_G_TODAYREVENUES); ?>

        <tr>
          <td class=theader align=right><?php echo L_G_TOTALAPPROVEDCOMM?></td><td width=5></td>
          <td align=right>
            <?php echo $this->a_settings->showCurrency($data['revenue_approved']+$data['st_revenue_approved'])?>
            &nbsp;
          </td>
          <td colspan=5>&nbsp;</td>
        </tr>
        <tr>
          <td class=theader align=right><?php echo L_G_TOTALWAITINGCOMM?></td><td width=5></td>
          <td align=right>
            <?php echo $this->a_settings->showCurrency($data['revenue_waitingapproval']+$data['st_revenue_waitingapproval'])?>
            &nbsp;
          </td>
          <td colspan=5>&nbsp;</td>
        </tr>
        <tr>
          <td class=theader align=right><?php echo L_G_TOTALDECLINEDCOMM?></td><td width=5></td>
          <td align=right>
            <?php echo $this->a_settings->showCurrency($data['revenue_declined']+$data['st_revenue_declined'])?>
            &nbsp;
          </td>
          <td colspan=5>&nbsp;</td>
        </tr>
    </table>
