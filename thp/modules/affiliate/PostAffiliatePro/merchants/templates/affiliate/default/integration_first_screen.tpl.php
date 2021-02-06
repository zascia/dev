<script>

var update_requester;

function showUpdateStatus() {
    var msg = 'ERROR';
    if (update_requester.readyState == 4) { 
        if (update_requester.status == 200) {
            msg = update_requester.responseText;
        } else { 
            msg = "false";
        }
    } 
    if (msg == 'false') {
        document.getElementById("update_status").innerHTML = '<?php echo L_G_NOUPDATESAVALAIBLE?>';
        return;
    } 
    if (msg == 'true') {
        document.getElementById("update_status").innerHTML = '<?php echo L_G_UPDATEAVALAIBLE?><br> ' +
            '<input type="button" class="formbutton" value="<?php echo L_G_DOWNLOADUPDATE?>" onclick="document.location.href=\'index.php?md=Affiliate_Merchants_Views_IntegrationWizard&action=update\'">';
        return;
    }
    //document.getElementById('infoDivTextRow').innerHTML = msg;
    return true;
}

function checkUpdate() {
    try { 
        update_requester = new XMLHttpRequest(); 
    } 
    catch (error) { 
        try { 
            update_requester = new ActiveXObject("Microsoft.XMLHTTP");
        } 
        catch (error) { 
            return;
        } 
    }
    update_requester.open("GET", "index_popup2.php?md=Affiliate_Merchants_Views_IntegrationWizard&action=checkversion", true);
    update_requester.send(null);
    update_requester.onreadystatechange = showUpdateStatus;
    msg = "Loading ...";
}

function go(url)
{
    document.location.href = url;
}

checkUpdate();

</script>
<table width="620" border=0 cellspacing=0 cellpadding=0>
<tr>
  <td align=left valign=top>
    <?php echo L_G_INTEGRATIONWIZARD_DESCRIPTION?>
    <br>
  </td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td width=280 align=right valign=top>
  <table width=280 class=listing border=0 cellspacing=0 cellpadding=2>
  <?php QUnit_Templates::printFilter(2, L_G_UPDATESTATUS); ?>
  <tr>
      <td style="padding: 7px;" align=center colspan=2><div id="update_status"><?php echo L_G_LOADINGUPDATESTATUS?></div>
      </td>
  </tr>
 </table>
 <br/>
  <table class=listing border=0 cellspacing=0 cellpadding=2>
  <?php QUnit_Templates::printFilter(2, L_G_FULLINTEGRATION); ?>
  <tr>
      <td style="padding: 7px;" align=left colspan=2><?php echo L_G_FULLINTEGRATIONDESC?>
      <br><br>
      <a class="biggerRedLink" href="http://www.qualityunit.com/postaffiliatepro/pap-full-integration.html" target="_blank"><?php echo L_G_FULLINTEGRATIONMOREINFO?></a></td>
  </tr>
 </table>
  </td>
</tr>
</table>
<br/><br/>

<table width="620" class=listing border=0 cellspacing=0 cellpadding=2>
<tr>
  <td align=left valign=top width="55">
    <a href="index.php?md=Affiliate_Merchants_Views_IntegrationWizard&integration_tab_sheet=trackingparams"><img src="<?php echo $this->a_this->getImage('icon_trackparams.gif') ?>"></a>
  </td>
  <td>&nbsp;&nbsp;</td>
  <td align=left valign=top width="100%">
    <a href="index.php?md=Affiliate_Merchants_Views_IntegrationWizard&integration_tab_sheet=trackingparams"><b><?php echo L_G_STEP?> 1. <?php echo L_G_TRACKINGPARAMSNAMES?></b></a>
    <br>
    <?php echo L_G_TRACKINGPARAMSNAMES_SHORT_DESCRIPTION?>
  </td>
</tr>
</table>
<br>

<table width="620" class=listing border=0 cellspacing=0 cellpadding=2>
<tr>
  <td align=left valign=top width="55">
    <a href="index.php?md=Affiliate_Merchants_Views_IntegrationWizard&integration_tab_sheet=clickstracking"><img src="<?php echo $this->a_this->getImage('icon_clicktracking.gif') ?>"></a>
  </td>
  <td>&nbsp;&nbsp;</td>
  <td align=left valign=top width="100%">
    <a href="index.php?md=Affiliate_Merchants_Views_IntegrationWizard&integration_tab_sheet=clickstracking"><b><?php echo L_G_STEP?> 2. <?php echo L_G_CLICKSTRACKING?></b></a>
    <br>
    <?php echo L_G_CLICKSTRACKING_SHORT_DESCRIPTION?>
  </td>
</tr>
</table>
<br>

<table width="620" class=listing border=0 cellspacing=0 cellpadding=2>
<tr>
  <td align=left valign=top width="55">
    <a href="index.php?md=Affiliate_Merchants_Views_IntegrationWizard&integration_tab_sheet=salestracking"><img src="<?php echo $this->a_this->getImage('icon_shoppingcart.gif') ?>"></a>
  </td>
  <td>&nbsp;&nbsp;</td>
  <td align=left valign=top>
    <a href="index.php?md=Affiliate_Merchants_Views_IntegrationWizard&integration_tab_sheet=salestracking"><b><?php echo L_G_STEP?> 3. <?php echo L_G_SALESTRACKING?></b></a>
    <br>
    <?php echo L_G_SALESTRACKING_SHORT_DESCRIPTION?>
  </td>
</tr>
</table>
<br>


