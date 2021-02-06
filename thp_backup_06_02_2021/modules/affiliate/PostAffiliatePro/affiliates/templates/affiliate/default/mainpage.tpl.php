<?php
    $data = $this->a_data;
?>

<table border=0>
<tr>
    <td align=left valign="top">

<?php if($this->a_Auth->getSetting('Aff_login_display_welcome') == '1') { ?>
    <table border=0 width="460">
    <tr><td><?php echo $this->a_Auth->getSetting('Aff_login_welcome_msg')?></td></tr>
    </table>
    <br>
<?php } ?>

<?php if($this->a_Auth->getSetting(Aff_display_news) == '1' && ($this->a_news_count>0 || ($this->a_news_count == 0 && $this->a_old_news_exist))) { ?>
    <table class=listing width="460" cellspacing=0 cellpadding=3 border=0>
    <?php QUnit_Templates::printFilter(2, L_G_NEWS_LIST); ?>
    <tr>
        <td class=actionheader align=right colspan=2>&nbsp;
        <a class=mainlink href="index.php?md=Affiliate_Affiliates_Views_MainPage&view_old=1"><?php echo L_G_VIEW_OLD?></a>
        </td>
    </tr>
    <?php while($news=$this->a_list_data->getNextRecord()) { ?>
    <tr>
      <td align=left width="5%" nowrap>&nbsp;<?php echo $news['dateinserted']?>&nbsp;</td>
      <td align=left nowrap>&nbsp;
        <?php if($_REQUEST['nid'] != $news['messageid']) { ?>
            <a href='index.php?md=Affiliate_Affiliates_Views_News&nid=<?php echo $news['messageid']?>&view_old=<?php echo $_REQUEST['view_old']?>'>
        <?php } ?>
        <b><?php echo $news['title']?></b>
        <?php if($_REQUEST['nid'] != $news['messageid']) { ?></a>
        <?php } ?>&nbsp;</td>
    </tr>
    <?php } ?>
    <?php if($this->a_news_count < 1) { ?>
    <tr>
      <td align=left colspan=2 nowrap>&nbsp;<?php echo L_G_NO_AVAILABLE_NEWS?>&nbsp;</td>
    </tr>
    <?php } ?>
    </table>

    <br>
<?php } ?>

<?php if($this->a_Auth->getSetting('Aff_login_display_statistics') == '1') { ?>

    <table class=listing width="460" border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(7, L_G_STATISTICS); ?>
    <tr><td colspan=7></td></tr>
        <tr>
          <td class=theader align=right>&nbsp;<?php echo L_G_TOTALCLICKS?></td><td width=5></td>
            <td align=right>
            <?php echo $data['clicks_approved']?>
            </td>
          <td width=30></td>
          <td class=theader align=right nowrap><?php echo L_G_TOTALIMPRESSIONS?> <?php echo L_G_IMPUNIQUEALL?></td><td width=5></td>
            <td align=right nowrap>
            <?php echo $data['unique_impressions']?> / <?php echo $data['impressions']?>
            </td>
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

    <?php QUnit_Templates::printFilter2(7, L_G_TODAYREVENUES); ?>

        <tr>
          <td class=theader align=right><?php echo L_G_TOTALAPPROVEDCOMM?></td><td width=5></td>
          <td align=right nowrap>
            <?php echo $this->a_settings->showCurrency($data['revenue_approved']+$data['st_revenue_approved'])?>
          </td>
          <td colspan=5>&nbsp;</td>
        </tr>
<?php        if($this->a_Auth->getSetting('Aff_allow_pending_trans') != 'deny') { ?>
        <tr>
          <td class=theader align=right><?php echo L_G_TOTALWAITINGCOMM?></td><td width=5></td>
          <td align=right nowrap>
            <?php echo $this->a_settings->showCurrency($data['revenue_waitingapproval']+$data['st_revenue_waitingapproval'])?>
          </td>
          <td colspan=5>&nbsp;</td>
        </tr>
<?php } ?>
<?php        if($this->a_Auth->getSetting('Aff_allow_declined_trans') != 'deny') { ?>
        <tr>
          <td class=theader align=right><?php echo L_G_TOTALDECLINEDCOMM?></td><td width=5></td>
          <td align=right nowrap>
            <?php echo $this->a_settings->showCurrency($data['revenue_declined']+$data['st_revenue_declined'])?>
          </td>
          <td colspan=5>&nbsp;</td>
        </tr>
<?php } ?>
    </table>
    <br>
<?php } ?>
</td>
<td width="10"></td>
<td align="left" valign="top">
<?php if($this->a_Auth->getSetting('Aff_login_display_manager') == '1') { ?>
    <table class="listing" cellpadding="2" cellspacing="0" width="250">
    <?php QUnit_Templates::printFilter(2, L_G_AFFILIATEMANAGER); ?>
    <tr>
      <td align=left valign=top>
      <table border=0 cellspacing=0 cellpadding=3>
      <?php echo $this->a_admin_info?>
      </table>
      </td>
    </tr>
    </table>
<?php } ?>
</td>
</tr>

</table>

<p>
<?php if($this->a_Auth->getSetting('Aff_login_display_text_in_the_middle') == '1') { ?>
    <table border=0 width="460">
    <tr><td><?php echo $this->a_Auth->getSetting('Aff_login_text_in_the_middle_msg')?></td></tr>
    </table>
    <br>
<?php } ?>
</p>

<?php if($this->a_Auth->getSetting('Aff_login_display_trendgraph') == '1') { ?>
<table border=0 width="735">
<tr>
    <td align=left>


    <table class=listing border=0 cellspacing=0 cellpadding=2 width="100%">
    <?php QUnit_Templates::printFilter(2, L_G_TRENDS); ?>
    <tr>
        <td align=left colspan=2>
        &nbsp;<b><?php echo L_G_IMPRESSIONS?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td height=150 valign=bottom>
            <?php echo $this->a_impstrend_graph?>
            </td>
        </tr>
        <tr>
            <td align=center><b><?php echo $this->a_period?></b></td>
        </tr>
        </table>
        <br>
        </td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
    <tr>
        <td align=left colspan=2>

<?php if($this->a_cpmSupported) { ?>
        &nbsp;<b><?php echo L_G_MILIONIMPRESSIONS.' '.L_G_CPMCOMMISSIONTRANSACTIONS?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td height=150 valign=bottom>
            <?php echo $this->a_cpmtrend_graph?>
            </td>
        </tr>
        <tr>
            <td align=center><b><?php echo $this->a_period?></b></td>
        </tr>
        </table>
        <br>
        </td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
    <tr>
        <td align=left colspan=2>
<?php } ?>

        &nbsp;<b><?php echo L_G_CLICKS?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td height=150 valign=bottom>
            <?php echo $this->a_clickstrend_graph?>
            </td>
        </tr>
        <tr>
            <td align=center><b><?php echo $this->a_period?></b></td>
        </tr>
        </table>
        <br>
        </td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
    <tr>
        <td align=left colspan=2>

<?php if($this->a_saleSupported) { ?>
        &nbsp;<b><?php echo L_G_SALES?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td height=150 valign=bottom>
            <?php echo $this->a_salestrend_graph?>
            </td>
        </tr>
        <tr>
            <td align=center><b><?php echo $this->a_period?></b></td>
        </tr>
        </table>
        <br>
        </td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
    <tr>
        <td align=left colspan=2>
<?php } ?>

<?php if($this->a_leadSupported) { ?>
        &nbsp;<b><?php echo L_G_LEADS?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td height=150 valign=bottom>
            <?php echo $this->a_leadstrend_graph?>
            </td>
        </tr>
        <tr>
            <td align=center><b><?php echo $this->a_period?></b></td>
        </tr>
        </table>
        <br>
        </td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
    <tr>
        <td align=left colspan=2>
<?php } ?>

        &nbsp;<b><?php echo L_G_REVENUES.' '.L_G_IN.' '.$this->a_Auth->getSetting('Aff_system_currency')?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td height=150 valign=bottom>
            <?php echo $this->a_revenuetrend_graph?>
            </td>
        </tr>
        <tr>
            <td align=center><b><?php echo $this->a_period?></b></td>
        </tr>
        </table>

        </td>
    </tr>
    </table>
    <br>
    </td>
</tr>
</table>
<?php } ?>