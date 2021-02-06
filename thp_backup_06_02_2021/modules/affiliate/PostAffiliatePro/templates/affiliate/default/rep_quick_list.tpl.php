<?php
  $data=$this->a_data;
?>
  </td>
</tr>
<?php QUnit_Templates::printFilter2(1, L_G_SUMMARY, L_G_HLP_SUMMARY); ?>
<tr>
    <td valign=top align=left>
  <table width=100% cellspacing=0 cellpadding=3 border=0>
    <tr>
<?php if($this->a_clickSupported) { ?>
      <td valign="top">
      &nbsp;<?php echo L_G_TOTALCLICKS?>&nbsp; 
      <b><?php echo $data['clicks']/*+$data['st_clicks']*/?></b><br><br>
      </td>
<?php } ?>
      <td valign="top">
<?php if($this->a_saleSupported) { ?>
      &nbsp;<?php echo L_G_TOTALAPPROVEDSALES?>&nbsp; 
      <b><?php echo $data['sales_approved']+$data['st_sales_approved']?></b><br>
      
      &nbsp;<?php echo L_G_TOTALWAITINGSALES?>&nbsp; 
      <b><?php echo $data['sales_waitingapproval']+$data['st_sales_waitingapproval']?></b><br>
      
      &nbsp;<?php echo L_G_TOTALDECLINEDSALES?>&nbsp; 
      <b><?php echo $data['sales_declined']+$data['st_sales_declined']?></b><br>

      &nbsp;<?php echo L_G_TOTALREFUNDSALES?>&nbsp; 
      <b><?php echo $data['sales_refund']+$data['st_sales_refund']?></b><br><br>
<?php } ?>
      </td>
      <td valign="top">
<?php if($this->a_leadSupported) { ?>
      &nbsp;<?php echo L_G_TOTALAPPROVEDLEADS?>&nbsp; 
      <b><?php echo $data['leads_approved']+$data['st_leads_approved']?></b><br>
      
      &nbsp;<?php echo L_G_TOTALWAITINGLEADS?>&nbsp; 
      <b><?php echo $data['leads_waitingapproval']+$data['st_leads_waitingapproval']?></b><br>
      
      &nbsp;<?php echo L_G_TOTALDECLINEDLEADS?>&nbsp; 
      <b><?php echo $data['leads_declined']+$data['st_leads_declined']?></b><br>
      
      &nbsp;<?php echo L_G_TOTALREFUNDLEADS?>&nbsp; 
      <b><?php echo $data['leads_refund']+$data['st_leads_refund']?></b><br><br>
<?php } ?>
      </td>
      <td valign="top">
      &nbsp;<?php echo L_G_TOTALAPPROVEDCOMM?>&nbsp; 
      <b><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(floatval($data['revenue_approved']+$data['st_revenue_approved']))?></b><br>
      
      &nbsp;<?php echo L_G_TOTALWAITINGCOMM?>&nbsp; 
      <b><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_waitingapproval']+$data['st_revenue_waitingapproval'])?></b><br>
      
      &nbsp;<?php echo L_G_TOTALDECLINEDCOMM?>&nbsp; 
      <b><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_declined']+$data['st_revenue_declined'])?></b><br>
      
      &nbsp;<?php echo L_G_TOTALPAIDCOMM?>&nbsp; 
      <b><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_paid']+$data['st_revenue_paid'])?></b><br>

      &nbsp;<?php echo L_G_TOTALREFUNDCOMM?>&nbsp; 
      <b><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_refund']+$data['st_revenue_refund'])?></b><br>
      </td>
    </tr>
  </table>
  <br>  
  </td>
</tr>  
<?php QUnit_Templates::printFilter2(1, L_G_COUNTS, L_G_HLP_COUNTS); ?>
<?php $i = 0; ?>
<tr>
    <td valign=top align=left>

  <table width=100% cellspacing=0 cellpadding=3 border=0>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td width="20%">&nbsp;</td>
      <td width="20%"><b><?php echo L_G_APPROVED?></b></td>
      <td width="20%"><b><?php echo L_G_WAITINGAPPROVAL?></b></td>
      <td width="20%"><b><?php echo L_G_SUPPRESSED?></b></td>
      <td width="20%"><b><?php echo L_G_REFUNDS_CHARGEBACKS?></b></td>
    </tr>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_IMPRESSIONS?> <?php echo L_G_IMPUNIQUEALL?></b></td>
      <td><?php echo $data['unique_impressions']?> / <?php echo $data['impressions']?></td>
      <td>-</td>
      <td>-</td>
      <td>-</td>
    </tr>
<?php if($this->a_clickSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_CLICKS?></b></td>
      <td><?php echo $data['clicks_approved']?></td>
      <td><?php echo $data['clicks_waitingapproval']?></td>
      <td><?php echo $data['clicks_declined']?></td>
      <td><?php echo $data['clicks_refund']?></td>
    </tr>
<?php } ?>
<?php if($this->a_saleSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_SALES?></b></td>
      <td><?php echo $data['sales_approved']?></td>
      <td><?php echo $data['sales_waitingapproval']?></td>
      <td><?php echo $data['sales_declined']?></td>
      <td><?php echo $data['sales_refund']?></td>
    </tr>
<?php } ?>
<?php if($this->a_leadSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_LEADS?></b></td>
      <td><?php echo $data['leads_approved']?></td>
      <td><?php echo $data['leads_waitingapproval']?></td>
      <td><?php echo $data['leads_declined']?></td>
      <td><?php echo $data['leads_refund']?></td>
    </tr>
<?php } ?>
    
<?php if($this->a_Auth->getSetting('Aff_support_recurring_commissions') == 1) { ?>    
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_RECURRING?></b></td>
      <td><?php echo $data['recurring_approved']?></td>
      <td><?php echo $data['recurring_waitingapproval']?></td>
      <td><?php echo $data['recurring_declined']?></td>
      <td><?php echo $data['recurring_refund']?></td>
    </tr>
<?php } ?>       
<?php if($this->a_Auth->getSetting('Aff_maxcommissionlevels') > 1) { ?> 
    <tr class="listrow<?php echo ($i++)%2?>">
     <td colspan=5 align=center><b><?php echo L_G_SECONDTIER?></b></td>
    </tr>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td>&nbsp;</td>
      <td><b><?php echo L_G_APPROVED?></b></td>
      <td><b><?php echo L_G_WAITINGAPPROVAL?></b></td>
      <td><b><?php echo L_G_SUPPRESSED?></td>
      <td><b><?php echo L_G_REFUNDS_CHARGEBACKS?></b></td>
    </tr>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_CLICKS?></b></td>
      <td><?php echo $data['st_clicks_approved']?></td>
      <td><?php echo $data['st_clicks_waitingapproval']?></td>
      <td><?php echo $data['st_clicks_declined']?></td>
      <td><?php echo $data['st_clicks_refund']?></td>
    </tr>
<?php if($this->a_saleSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_SALES?></b></td>
      <td><?php echo $data['st_sales_approved']?></td>
      <td><?php echo $data['st_sales_waitingapproval']?></td>
      <td><?php echo $data['st_sales_declined']?></td>
      <td><?php echo $data['st_sales_refund']?></td>
    </tr>
<?php } ?>
<?php if($this->a_leadSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_LEADS?></b></td>
      <td><?php echo $data['st_leads_approved']?></td>
      <td><?php echo $data['st_leads_waitingapproval']?></td>
      <td><?php echo $data['st_leads_declined']?></td>
      <td><?php echo $data['st_leads_refund']?></td>
    </tr>
<?php } ?>    
<?php } // end if max comission levels?>
  </table>
  </td>
</tr>  
<?php QUnit_Templates::printFilter2(1, L_G_REVENUES, L_G_HLP_REVENUES); ?>
<?php $i = 0; ?>
<tr>
    <td valign=top align=left>
    
  <table width=100% cellspacing=0 cellpadding=3 border=0>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td width="20%">&nbsp;</td>
      <td width="16%"><b><?php echo L_G_PAID?></b></td>
      <td width="16%"><b><?php echo L_G_APPROVED?></b></td>
      <td width="16%"><b><?php echo L_G_WAITINGAPPROVAL?></b></td>
      <td width="16%"><b><?php echo L_G_SUPPRESSED?></b></td>
      <td width="16%"><b><?php echo L_G_REFUNDS_CHARGEBACKS?></b></td>
    </tr>
<?php if($this->a_signupSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_SIGNUPBONUS?></b></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_signup_paid'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_signup_approved'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_signup_waitingapproval'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_signup_declined'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_signup_refund'])?></td>
    </tr>
<?php } ?>

<?php if($this->a_referralSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_REFERRAL?></b></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_referral_paid'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_referral_approved'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_referral_waitingapproval'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_referral_declined'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_referral_refund'])?></td>
    </tr>
<?php } ?>

<?php if($this->a_cpmSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_CPM?></b></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_cpm_paid'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_cpm_approved'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_cpm_waitingapproval'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_cpm_declined'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_cpm_refund'])?></td>
    </tr>
<?php } ?>

<?php if($this->a_clickRevenueSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_CLICKS?></b></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_clicks_paid'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_clicks_approved'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_clicks_waitingapproval'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_clicks_declined'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_clicks_refund'])?></td>
    </tr>
<?php } ?>
    
<?php if($this->a_saleSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_SALES?></b></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_sales_paid'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_sales_approved'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_sales_waitingapproval'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_sales_declined'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_sales_refund'])?></td>
    </tr>
<?php } ?>

<?php if($this->a_leadSupported) { ?>    
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_LEADS?></b></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_leads_paid'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_leads_approved'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_leads_waitingapproval'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_leads_declined'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_leads_refund'])?></td>
    </tr>
<?php } ?>

<?php if($this->a_Auth->getSetting('Aff_support_recurring_commissions') == 1) { ?>    
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_RECURRING?></b></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_recurring_paid'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_recurring_approved'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_recurring_waitingapproval'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_recurring_declined'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_recurring_refund'])?></td>
    </tr>
<?php } ?>      
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><i><b><?php echo L_G_SUM?></b></i></td>
      <td><i><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_paid'])?></i></td>
      <td><i><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_approved'])?></i></td>
      <td><i><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_waitingapproval'])?></i></td>
      <td><i><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_declined'])?></i></td>
      <td><i><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['revenue_refund'])?></i></td>
    </tr>
<?php if($this->a_Auth->getSetting('Aff_maxcommissionlevels') > 1) { ?>    
    <tr class="listrow<?php echo ($i++)%2?>">
     <td colspan=6 align=center><b><?php echo L_G_SECONDTIER?></b></td>
    </tr>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td width="20%">&nbsp;</td>
      <td width="16%"><b><?php echo L_G_PAID?></b></td>
      <td width="16%"><b><?php echo L_G_APPROVED?></b></td>
      <td width="16%"><b><?php echo L_G_WAITINGAPPROVAL?></b></td>
      <td width="16%"><b><?php echo L_G_SUPPRESSED?></b></td>
      <td width="16%"><b><?php echo L_G_REFUNDS_CHARGEBACKS?></b></td>
    </tr>
<?php if($this->a_referralSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_REFERRAL?></b></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_referral_paid'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_referral_approved'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_referral_waitingapproval'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_referral_declined'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_referral_refund'])?></td>
    </tr>
<?php } ?>

<?php if($this->a_cpmSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_CPM?></b></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_cpm_paid'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_cpm_approved'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_cpm_waitingapproval'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_cpm_declined'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_cpm_refund'])?></td>
    </tr>
<?php } ?>

<?php if($this->a_clickRevenueSupported) { ?>    
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_CLICKS?></b></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_clicks_paid'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_clicks_approved'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_clicks_waitingapproval'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_clicks_declined'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_clicks_refund'])?></td>
    </tr>
<?php } ?>

<?php if($this->a_saleSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_SALES?></b></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_sales_paid'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_sales_approved'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_sales_waitingapproval'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_sales_declined'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_sales_refund'])?></td>
    </tr>
<?php } ?>
    
<?php if($this->a_leadSupported) { ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><b><?php echo L_G_LEADS?></b></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_leads_paid'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_leads_approved'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_leads_waitingapproval'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_leads_declined'])?></td>
      <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_leads_refund'])?></td>
    </tr>
<?php } ?>
    
    <tr class="listrow<?php echo ($i++)%2?>">
      <td><i><b><?php echo L_G_SUM?></b></i></td>
      <td><i><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_paid'])?></i></td>
      <td><i><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_approved'])?></i></td>
      <td><i><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_waitingapproval'])?></i></td>
      <td><i><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_declined'])?></i></td>
      <td><i><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($data['st_revenue_refund'])?></i></td>
    </tr>
<?php } ?>
  </table>

  </td>
</tr>
</table>
<br>
