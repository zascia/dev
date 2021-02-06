<table width=780 border=0 cellspacing=0 cellpadding=0>
<tr>
  <td class=biggerText align=left valign=top>
    <h5>First steps with your affiliate program</h5>
    <p>
    <b>1. Review your  <a class="biggerLink" href="index.php?md=Affiliate_Merchants_Views_Settings">settings</a></b><br/>
    It is important to review all the settings and check that they are correct.<br/>
    You have to set up your SMTP server for sending emails, otherwise emails will be not sent from the system.
    </p>
    <p>
    <b>2. Define your <a class="biggerLink" href="index.php?md=AffLite_Merchants_Views_Commissions">commissions</a></b><br/>
    You can define percentage or fixed commissions for your sales.
    </p>
    <p>
    <b>3. Create your <a class="biggerLink" href="index.php?md=Affiliate_Merchants_Views_BannerManager">banners or text links</a></b><br/>
    After creation affiliates will see these banners and their code for copy & paste in their own affiliate panel.
    </p>
    <p>
    <b>4. Set up your <a class="biggerLink" href="index.php?md=Affiliate_Merchants_Views_AffEmailTemplates">email templates</a></b><br/>
    This enables you to customize emails which are sent after signup or sale.
    </p>
    <p>
    <b>5. Customize your <a class="biggerLink" href="index.php?md=Affiliate_Merchants_Views_SignupSettings">Affiliate Signup Form</a></b><br/>
    You have full control over look of your affiliate signup form.
    </p>    
    <p>
    <b>6. Customize the look of your <a class="biggerLink" href="index.php?md=Affiliate_Merchants_Views_AffPanelSettings">Affiliate Panel</a></b><br/>
    Using this wizard you can add your own descriptive text to every page displayed in your panel for affiliates.
    You can also disable some of the pages if you think your affiliates don't need to see it.
    </p>    
    <p>
    <b>7. <a class="biggerLink" href="index.php?md=Affiliate_Merchants_Views_IntegrationWizard">Integrate</a> affiliate system with your website</b><br/>
    Use Integration Wizard to enable affiliate system tracking of your clicks and sales.
    </p>
    <p>
    <b>8. Test your integration</b><br/>
    To test it, try to simulate affiliate's behavior.<br/> Sign up as a new affiliate, put some banner on a test page and click on it.
    Then make a (test) purchase and check if both click and sales were registered in the system.
    <br/><br/>
    If you have any problems, look at the <a class="biggerLink" href="index.php?md=Affiliate_Merchants_Views_History">History log</a> for the reason of failure.
    <br/>
    If you have turned on debugging, then all actions are logged into the history log. 
    </p>
    <p>
    After you succesfuly tested integration of affiliate system with your website, 
    everything is ready to start up promoting your new affiliate program.
    </p>
    
    <br/><br/>
<table class=listing width="500" border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(2, 'Important URLs'); ?>
  <td align=left colspan=2>
  <table border=0 width="100%" cellpadding=0 cellspacing=5>
  <tr>
    <td align=left valign=top>
    <p>
    <b>Your Affiliate Signup Form</b><br/>
    This is the link that you should publish on your pages. Your visitors (potential affiliates) have to fill the signup form 
    and upon approval they'll become your affiliates.
    <br/>
    <a class="simplelink" href="http://www.affplanet.com/s/signup.php?lid=<?php echo $this->a_Auth->getLiteAccountID()?>" target=_blank>http://www.affplanet.com/s/signup.php?lid=<?php echo $this->a_Auth->getLiteAccountID()?></a>
    </p>

    <p>
    <b>Your Affiliate Login Form (only for non-Free account type)</b><br/>
    If you have non-Free account, you can give your affiliates this link to log-in. 
    Thus, they don't need to go to www.AffPlanet.com main page to log in to their panel.
    <br/>
    <a class="simplelink" href="http://www.affplanet.com/a/index.php?lid=<?php echo $this->a_Auth->getLiteAccountID()?>" target=_blank>http://www.affplanet.com/a/index.php?lid=<?php echo $this->a_Auth->getLiteAccountID()?></a>
    </p>
    </td>
  </tr>
  </table>
  </td>
</tr>
</table>

    
  </td>
  <td nowrap>&nbsp;&nbsp;&nbsp;</td>
  <td align=left valign=top>

<table class=listing width="240" border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(2, L_G_QUICKLINKS); ?>
  <td align=left colspan=2>
  <table border=0 width="100%" cellpadding=0 cellspacing=5>
<?php  $accountType = ($this->a_settings['AffPlanet_account_type'] != '' ? $this->a_settings['AffPlanet_account_type'] : ACCOUNT_FREE);
    if($accountType == ACCOUNT_FREE) {?>
  <tr>
    <td class="biggerText" align=center valign=top>
    <p>
    <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_About">Update Account</a><br/><br/>
    </p>
  </tr>
<?php } ?>    
  <tr>
    <td class="biggerText" align=left valign=top>
    <p>
    View <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_MerchantProfile">today's statistics</a>
    </p>
    <p>
    Define your <a class="textlink" href="index.php?md=AffLite_Merchants_Views_Commissions">commissions</a>
    </p>
    <p>
    Review and manage your  <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_AffiliateManager">affiliates</a>.
    </p>
    <p>
    Check and approve your pending <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_TransactionManager&tmdl_status=allpending">transactions</a> (clicks, sales, leads,...).
    </p>
    <p>
    Edit your <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_Settings">transactions</a> (commissions - clicks, sales, leads,...)
    </p>
    <p>
    Create and modify your <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_BannerManager">banners</a>
    </p>
    <p>
    <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_AffiliatePayments">Pay</a> your affiliates
    </p>
    <p>
    Check <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_History">History log</a>
    </p>
    <p>
    Send <a class="textlink" href="index.php?md=Affiliate_Merchants_Views_BroadcastMessage">email or news</a> to your affiliates
    </p>
    </td>
  </tr>
  </table>
  </td>
</tr>
</table>

    </td>
</tr>
</table>
