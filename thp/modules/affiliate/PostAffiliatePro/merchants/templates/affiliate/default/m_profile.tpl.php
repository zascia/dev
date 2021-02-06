<?php
    $data = $this->a_data;
?>
<script>
function approveTransactions()
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&tmdl_status=allpending"+"&<?php echo SID?>";
}

function approveURLs()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ApprovalManager&type=urls"+"&<?php echo SID?>","EditCustomization","scrollbars=1, top=100, left=100, width=550, height=260, status=0")
    wnd.focus();
}
</script>
<table border=0>
<tr>
    <td align=left valign=top>
    
    <?php if((GLOBAL_DB_ENABLED == '1' && ($this->a_news_count>0 || ($this->a_news_count == 0 && $this->a_old_news_exist)))) { ?>
    <table class=listing width="450" cellspacing=0 cellpadding=3 border=1>
    <?php QUnit_Templates::printFilter(2, L_G_NEWS_LIST); ?>
    <tr>
        <td class=actionheader align=right colspan=2>&nbsp;
        <a class=mainlink href="index.php?md=Affiliate_Merchants_Views_MerchantProfile&view_old=1"><?php echo L_G_VIEW_OLD?></a>
        </td>
    </tr>
    <?php while($news=$this->a_list_data->getNextRecord()) { ?>
    <tr>
      <td align=left width="5%" nowrap>&nbsp;<?php echo $news['dateinserted']?>&nbsp;</td>
      <td align=left nowrap>&nbsp;<a href='index.php?md=Affiliate_Merchants_Views_News&nid=<?php echo $news['messageid']?>&view_old=<?php echo $_REQUEST['view_old']?>'><b><?php echo $news['title']?></b></a>&nbsp;</td>
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
    
    <?php showLoadedDataDiv("index_cache.php?md=Affiliate_Merchants_Views_MerchantProfile&action=showtransstats", false, true); ?>
	<br>
	
    <?php showLoadedDataDiv("index_cache.php?md=Affiliate_Merchants_Views_MerchantProfile&action=showaffstats", false, true); ?>
    <br>
    
    <table border=0 cellspacing=0 cellpadding=0 width="430">
    <tr>
      <td align=left>
      <p>
    <span style="color: #3333cc; font-size: 14px; font-weight: bold; font-family: Tahoma;">Getting Started</span>
    </p>
    <p>
    Welcome to your affiliate program. 
    <br/><br/>
   
      </td>
    </tr>
    </table>
  </td>
  <td>&nbsp;&nbsp;&nbsp;</td>
  <td align=left valign=top>
  
<table class=listing width="240" border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(2, 'Documentation'); ?>
  <tr>
    <td class="biggerText" align=left valign=top>
    <table border=0 cellspacing=0 cellpadding=2>
    <tr>
      <td align=left>&nbsp;&nbsp;<a class="biggerRedLink" href="index.php?md=home&action=firststeps"><img src="<?php echo QUnit_UI_TemplatePage::getImage('ie-icon.gif')?>" border="0"></a>&nbsp;&nbsp;</td>
      <td align=left colspan=2><a class="biggerRedLink" href="index.php?md=home&action=firststeps"><?php echo L_G_FIRSTSTEPS?></a></td>
    </tr>
    <tr>
      <td></td>
      <td align=left>How to start with the system, first 10 steps and periodic tasks. First brief help.</td>
    </tr>
    <tr>
      <td colspan=2></td>
    </tr>
    
    <tr>
      <td align=left>&nbsp;&nbsp;<a class="biggerRedLink" href="http://www.qualityunit.com/doc/papdoc_30.pdf" target=_blank><img src="<?php echo QUnit_UI_TemplatePage::getImage('get_acrobat-reader-small.gif')?>" border="0"></a></td>
      <td align=left><a class="biggerRedLink" href="http://www.qualityunit.com/doc/papdoc_30.pdf" target=_blank>PAP 3 User's Guide</a> (download)</td>
    </tr>
    <tr>
      <td></td>
      <td align=left>Complete documentation. Getting started info, installation, integration with shopping carts and setup</td>
    </tr>
    </table>
    <div align=center>
    <a class="textlink" href="http://www.adobe.com/products/acrobat/readstep2.html" target=_blank><img src="<?php echo QUnit_UI_TemplatePage::getImage('getacrobatreader.gif')?>" border="0"></a>
    </span>
    </td>
  </tr>
</table>
<br/>

<table class=listing width="240" border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(2, L_G_QUICKLINKS); ?>
  <td align=left colspan=2>
  <table border=0 width="100%" cellpadding=0 cellspacing=11>
  <tr>
    <td class="biggerText" align=center valign=top>
    <a class="biggerRedLink" href="http://www.qualityunit.com/postaffiliatepro/pap-updates.html?v=<?php echo POSTGLOBAL_VERSION?>" target="_blank">Check for Updates</a><br/>
    </td>
  </tr>
  <tr>
    <td class="biggerText" align=left valign=top>
    View <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_MerchantProfile">today's statistics</a>
    </td>
  </tr>
  <tr>
    <td class="biggerText" align=left valign=top>
    Define your <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_CampaignManager">campaigns & commissions</a>
    </td>
  </tr>
  <tr>
    <td class="biggerText" align=left valign=top>
    Review and manage your  <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_AffiliateManager">affiliates</a>.
    </td>
  </tr>
  <tr>
    <td class="biggerText" align=left valign=top>
    Check and approve your pending <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_TransactionManager&tmdl_status=allpending">transactions</a> (clicks, sales, leads,...).
    </td>
  </tr>
  <tr>
    <td class="biggerText" align=left valign=top>
    Edit your <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_Settings">transactions</a> (commissions - clicks, sales, leads,...)
    </td>
  </tr>
  <tr>
    <td class="biggerText" align=left valign=top>
    Create and modify your <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_BannerManager">banners</a>
    </td>
  </tr>
  <tr>
    <td class="biggerText" align=left valign=top>
    <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_AffiliatePayments">Pay</a> your affiliates
    </td>
  </tr>
  <tr>
    <td class="biggerText" align=left valign=top>
    Check <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_History">History log</a>
    </td>
  </tr>
  <tr>
    <td class="biggerText" align=left valign=top>
    Send <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_BroadcastMessage">email or news</a> to your affiliates
    </td>
  </tr>
  </table>
  </td>
</tr>
</table>

<br>
<table class=listing width="240" border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(2, L_G_ADDITIONALSERVICES); ?>
  <td align=left colspan=2>
  <table border=0 width="100%" cellpadding=0 cellspacing=11>
  <tr>
    <td class="biggerText" align=center valign=top>
    <a class="biggerRedLink" href="http://www.qualityunit.com/affsubmit/" target="_blank"><img src="<?php echo QUnit_UI_TemplatePage::getImage('affsubmit.gif')?>" border="0"></a><br/>
    <b>Affiliate Directory Submission service</b>
    <br>
    Publish your program for thousands of experienced affiliates.
    </td>
  </tr>
  <tr>
    <td class="biggerText" align=center valign=top>
    <a class="biggerRedLink" href="http://www.qualityunit.com/postaffiliatepro/papalert/" target="_blank"><img src="<?php echo QUnit_UI_TemplatePage::getImage('pap_alert_anim.gif')?>" border="0"></a><br/>
    <b>PAP Alert</b> (optional)
    <br>
    Notification app for you and your affiliates
    </td>
  </tr>  
  </table>
  </td>
</tr>
</table>
  

  </td>
</tr>
</table>
