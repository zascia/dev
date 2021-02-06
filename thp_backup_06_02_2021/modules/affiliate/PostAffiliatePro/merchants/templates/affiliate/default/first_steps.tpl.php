<h5>First steps</h5>
Follow the 10 steps below to configure and run your affiliate program.
<br>
There are also examples of periodic tasks which you should do from time to time.
<br><br>

<?php if (($this->a_warnings != '') && (count($this->a_warnings) > 0)) { ?>
    <table class="errorMsgTable" border=0 cellspacing=0 cellpadding=2>
    <tr>
        <td class="errorMessageHeader">
            <img src="<?php echo  $this->a_this->getImage('exclamation.png') ?>" border="10">&nbsp;
            <?php echo L_G_WARNINGS?>
        </td>
    </tr>
    <tr>
        <td class="errorMessage" align=left valign=top>
        <ul class="errorMessage">
<?php      foreach($this->a_warnings as $msg) { ?>
            <li class="errorMessage"><?php echo $msg?></li>
<?php      } ?>
        </ul>
        </td>
    </tr>
    </table>
<?php } ?>
<br><br>
<table class="tableOpened" id="firststeps" cellspacing="0" cellpadding="0">
<tr>
  <td class="firstStepsHeader" onclick="openItem('firststeps');">First steps with your affiliate program <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>

<table class="tableClosed" id="brainstorm" cellspacing="0" cellpadding="2">
<tr>
  <td class="firstStepsHeader2" onclick="openItem('brainstorm');">1. Brainstorming <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  <p>
  Think about your program and plan what you want to achieve. How big commissions do you want to provide? 
  <br/>
  Will they be attractive to potential affiliates compared with your competition?
  <br/>
  How do you want to attract your affiliates to join?
  </p>
  <br>
  </DIV>
  </td>
</tr>
</table>

<table class="tableClosed" id="settings" cellspacing="0" cellpadding="2">
<tr>
  <td class="firstStepsHeader2" onclick="openItem('settings');">2. Review your settings <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  <p>
  It is important to review all the settings and check that they are correct.<br>
  Affiliate software has many configuration options that influence it's work. After clean install, 
  the system is preconfigured with the most common settings and it shoudl be able to run.
  </p>
  <p>
  <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_Settings">Settings</a> to check:<br>
  <b>Communication</b> - here you set up your email address and the way how emails are sent by the system
  <br>
  in <b>Commissions</b> you can define which commission types you want to use
  </p>
  <br>
  </DIV>
  </td>
</tr>
</table>

<table class="tableClosed" id="campaigns" cellspacing="0" cellpadding="2">
<tr>
  <td class="firstStepsHeader2" onclick="openItem('campaigns');">3. Define your commissions <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  <p>
  To set up commissions, you have to create a <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_CampaignManager">campaign</a>. You can create multiple campaigns, and define different commissions for each of it.
  <br><br>
  <img src="<?php echo QUnit_UI_TemplatePage::getImage('ssh_campaign.gif')?>" border="0">
  <br/><br>
  Every campaign will contain its own banners, links and other promotional materials as well as commissions.
  </p>
  <br>
  </DIV>
  </td>
</tr>
</table>

<table class="tableClosed" id="banners" cellspacing="0" cellpadding="2">
<tr>
  <td class="firstStepsHeader2" onclick="openItem('banners');">4. Create your banners or text links <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  <p>
  Banners and links always belong to some campaign. For better organisation, they can be grouped into categories. 
  <br><br>
  <img src="<?php echo QUnit_UI_TemplatePage::getImage('ssh_banner.gif')?>" border="0">
  <br/><br>
  When you create new <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_BannerManager">banner</a>, it will become visible in affiliate's panel and they can start using it. 
  </p>
  <br>
  </DIV>
  </td>
</tr>
</table>

<table class="tableClosed" id="emailtemps" cellspacing="0" cellpadding="2">
<tr>
  <td class="firstStepsHeader2" onclick="openItem('emailtemps');">5. Set up your email templates <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  <p>
  System sends some automatic emails (for example after affiliate signup), which are generated from predefined templates. 
  <br><br>
  <img src="<?php echo QUnit_UI_TemplatePage::getImage('ssh_emailtemps.gif')?>" border="0">
  <br/><br>
  Edit the <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_AffEmailTemplates">templates</a> to customize the message and add personal touch. 
  </p>
  <br>
  </DIV>
  </td>
</tr>
</table>

<table class="tableClosed" id="signup" cellspacing="0" cellpadding="2">
<tr>
  <td class="firstStepsHeader2" onclick="openItem('signup');">6. Customize your Affiliate Signup Form <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  <p>
  You can choose between two signup form types:<br>
  First is <b>standard</b> signup form - <a href="../affsignup.php" target=_blank>/affiliate/affsignup.php</a> (or sample <a href="../affsignup_sample.php" target=_blank>affsignup_sample.php</a>). 
  <br>
  Design of this signup form can be changed by directly editing the file affsignup.php and files header.htm and footer.htm
  <br/><br>
  <a href="../scripts/signup.php" target=_blank><img src="<?php echo QUnit_UI_TemplatePage::getImage('ssh_signup_standard.gif')?>" border="0"></a>
  <br/><br>
  Second is <b>automatically generated</b> signup form - <a href="..//scripts/signup.php" target=_blank>/affiliate/scripts/signup.php</a>. 
  This form is generated according to settings in <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_SignupSettings">Affiliate signup</a>.
  <br>There you can choose which fields are displayed, which are hidden, which are mandatory or optional.
  <br/><br>
  <a href="../scripts/signup.php" target=_blank><img src="<?php echo QUnit_UI_TemplatePage::getImage('ssh_signup_generated.gif')?>" border="0"></a>
  <br/><br>
  </p>
  <p>
  Note that checking for fields in both types of forms are controlled by <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_SignupSettings">Affiliate Signup</a> settings. So if you want some field to be mandatory, only check it there.
  You can also add up to 5 custom fields which can contain your own data. 
  </p>
  <p>
  How to use it - simply choose if you want to use standard or automatically generated signup form, and then put link to this signup form to your website.
  </p>
  <br>
  </DIV>
  </td>
</tr>
</table>

<table class="tableClosed" id="panel" cellspacing="0" cellpadding="2">
<tr>
  <td class="firstStepsHeader2" onclick="openItem('panel');">7. Customize the look of your Affiliate Panel <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  <p>
  You are in full control over affiliate's panel. By setting <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_AffPanelSettings">Affiliate panel</a> you can add your own descriptive text to every page displayed 
 in your panel for affiliates. You can also disable some of the pages if you think your affiliates don't need to see it. 
  </p>
  <br>
  </DIV>
  </td>
</tr>
</table>

<table class="tableClosed" id="integrate" cellspacing="0" cellpadding="2">
<tr>
  <td class="firstStepsHeader2" onclick="openItem('integrate');">8. Integrate affiliate system with your website & shopping cart <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  <p>
  Use <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_IntegrationWizard">Integration Wizard</a> to enable affiliate system tracking of your clicks and sales and integrate it with your shopping cart. 
  <br>
  It is easy to use, step-by-step wizard that will tell you exactly what you have to do to integrate PAP with your website.
  </p>
  <br>
  </DIV>
  </td>
</tr>
</table>

<table class="tableClosed" id="testit" cellspacing="0" cellpadding="2">
<tr>
  <td class="firstStepsHeader2" onclick="openItem('testit');">9. Test It <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  <p>
    To test the functionality, try to simulate affiliate's behavior.<br/> Sign up as a new affiliate, put some banner on a test page and click on it.
    Then make a (test) purchase and check if both click and sales were registered in the system.
    <br/><br/>
    If you have any problems, look at the <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_History">History log</a> for the reason of failure.
    <br/>
    If you have turned on debugging, then all actions are logged into the history log. 
    </p>
  </p>
  <br>
  </DIV>
  </td>
</tr>
</table>

<table class="tableClosed" id="promoteit" cellspacing="0" cellpadding="2">
<tr>
  <td class="firstStepsHeader2" onclick="openItem('promoteit');">10. Promote your program <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  <p>
    After you succesfully tested integration of affiliate system with your website, 
    everything is ready to start up promoting your new affiliate program so that you'll attract new affiliats to join it.
  </p>
  <p>
   It is a must to put link to your affiliate program information or signup form to your own website. Name the link like <b>Affiliate program</b>, <b>Webmasters make money</b>, 
   <b>Affiliates</b> etc. This will attract the visitors of your site and can convert them to your affiliates.
  </p>
  <p>
  To reach much more potential affiliates, submit your program to affiliate directories. There are tens of affiliate directories on the web, visited 
  by thousands of experienced affiliates every day.
  </p>
  <p>
    Do you want to outsource the manual submission work? We can do it for you<br><br>
    
    <table border=0 cellspacing=0 cellpadding=0 align=center>
    <tr><td align=center><a class="biggerRedLink" href="http://www.qualityunit.com/affsubmit/" target="_blank"><img src="<?php echo QUnit_UI_TemplatePage::getImage('affsubmit.gif')?>" border="0"></a><br/>
    <b>Affiliate Directory Submission service</b>
    <br>
    Publish your program for thousands of experienced affiliates.
    </td></tr></table>
  </p>
  <br>
  </DIV>
  </td>
</tr>
</table>


  </DIV>
  </td>
</tr>
</table>

<br><br>
<table class="tableClosed" id="periodic" cellspacing="0" cellpadding="0">
<tr>
  <td class="firstStepsHeader" onclick="openItem('periodic');">Periodic tasks <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  
<table class="tableClosed" id="approve" cellspacing="0" cellpadding="2">
<tr>
  <td class="firstStepsHeader2" onclick="openItem('approve');">Review and approve new affiliates, clicks, or sales <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  <p>
  This is necessary only if you turned off automatic approval. All your pending transactions are indicated on the Home page 
  <br>
  <a href="index.php?md=home" target=_blank><img src="<?php echo QUnit_UI_TemplatePage::getImage('ssh_pending.gif')?>" border="0"></a>
  
  </p>
  <br>
  </DIV>
  </td>
</tr>
</table>

<table class="tableClosed" id="sendnews" cellspacing="0" cellpadding="2">
<tr>
  <td class="firstStepsHeader2" onclick="openItem('sendnews');">Send periodic newsletter to your affiliates <img src="<?php echo QUnit_UI_TemplatePage::getImage('icon_opendown.gif')?>" border="0"></td>
</tr><tr>
  <td class="leftMenuTop"></td>
</tr><tr>
  <td valign="top" align="left">
  <DIV class=firstStepsText>
  <p>
  Keep contact with your affiliates. You should send them newsletter at least once a month. 
  Use <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_BroadcastMessage">Send message</a> to send mass emails or display news in their panel.
  <br>
  Or better, configure monthly or weekly email newsletter that will be sent automatically every week of month. You can set up sending these newsletters in 
  <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_Settings">Settings</a> and you can customize the emails sent in 
  <a class="biggerRedLink" href="index.php?md=Affiliate_Merchants_Views_AffEmailTemplates">Email templates</a>.
  </p>
  <br>
  </DIV>
  </td>
</tr>
</table>

  </DIV>
  </td>
</tr>
</table>

