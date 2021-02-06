<table>
<tr><td align=left valign=top>

<table border=0 cellspacing=0 cellpadding=5>
<tr>
    <td colspan=2 align=left><h5><?php echo L_G_TRAFFICBAREXPLAINED?></td>
</tr><tr>    
    <td align=left valign=top nowrap>
    Traffic bar displays the number of transactions you have spent and the ones you have available.
    <br/><br/>
    Your total available traffic this month is computed as <br>
    <b>
    <?php if($this->a_settings['Acct_limit_bonus_enabled'] == 1) { ?>
    <?php echo L_G_TRAFFICAVAILABLE.' + '.L_G_TRAFFICBONUS.' + '.L_G_TRAFFICBOUGHT?>
    <?php } else { ?>
    <?php echo L_G_TRAFFICAVAILABLE.' + '.L_G_TRAFFICBOUGHT?>
    <?php } ?>
    </b>    
    </td>
    <td align=left>
    <table border=0 cellspacing=0 cellpadding=3>
    <tr>
      <td><table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#A5C3E1">&nbsp;</td></tr></table></td>
      <td>&nbsp; <?php echo L_G_TRAFFICSPENT?></td>
    </tr><tr>
      <td><table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#DAC0DE">&nbsp;</td></tr></table></td>
      <td>&nbsp; <?php echo L_G_TRAFFICAVAILABLE?></td>
<?php if($this->a_settings['Acct_limit_bonus_enabled'] == 1) { ?>
    </tr><tr>
      <td><table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#ABCA94">&nbsp;</td></tr></table></td>
      <td>&nbsp; <?php echo L_G_TRAFFICBONUS?></td>
<?php } ?>
    </tr><tr>
      <td><table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#FFC258">&nbsp;</td></tr></table></td>
      <td>&nbsp; <?php echo L_G_TRAFFICBOUGHT?></td>
    </tr>
    </tr>
    </table>
    </td>
</tr>
</table>

<hr>

<table border=0 cellspacing=0 cellpadding=5>
<tr>
    <td align=left><h5><?php echo L_G_WEBACCOUNTTYPE?>    
    <i>
<?php
  if($this->a_settings['AffPlanet_account_type'] == ACCOUNT_FREE) echo L_G_ACCOUNT_FREE;
  else if($this->a_settings['AffPlanet_account_type'] == ACCOUNT_LITE) echo L_G_ACCOUNT_LITE;
  else echo L_G_ACCOUNT_FREE;
?>
    </h5>
    </td>
</tr>
</table>


<table border=0 cellspacing=0 cellpadding=5>
<?php  if($this->a_settings['AffPlanet_account_type'] == ACCOUNT_FREE) {?>
<tr>
    <td align=left width=700>
        <form method="POST" action="../al/scripts/payment_redirect.php" target="_blank">
        <input type="hidden" name="lid" value="<?php echo $GLOBALS['Auth']->getLiteAccountID()?>">
        <input type="hidden" name="type" value="<?php echo PAYMENT_LITE_ACCOUNT?>">
        <input type='hidden' name='quantity' value='1' >
        <input name="submit" type='submit' value='Upgrade to Lite Account' ><br>
        </form>
        <br/>
        Upgrade to Lite account for higher level of traffic, your own affiliate program branding and removal of advertisements.
    </td>
</tr>
<tr>
    <td align=left width=350>
    
    <b>Advantages of Lite account<b>
    <table border=0 width="100%" cellpadding=3>
    <tr>
      <td>&nbsp;+&nbsp;&nbsp;</td>
      <td align=left valign=top>
      monthly fee starting at $8
      </td>
    </tr><tr>
      <td>&nbsp;+&nbsp;&nbsp;</td>
      <td align=left valign=top>
      traffic starting at 5,000 transactions (clicks + sales + leads) per month
      </td>
    </tr><tr>
      <td>&nbsp;+&nbsp;&nbsp;</td>
      <td align=left valign=top>
      removed advertisement area in merchant and affiliate panels
      </td>
    </tr><tr>
      <td>&nbsp;+&nbsp;&nbsp;</td>
      <td align=left valign=top>
      removed 'Powered by' button from affiliate signup form
      </td>
    </tr><tr>
      <td>&nbsp;+&nbsp;&nbsp;</td>
      <td align=left valign=top>
      possibility of having your own domain for your affiliate system (in preparation, will be available for all Lite accounts from 1st of March)
      </td>
    </tr><tr>
      <td>&nbsp;+&nbsp;&nbsp;</td>
      <td align=left valign=top>
      possibility of having your own login screen for affiliates (in preparation, will be available for all Lite accounts from 1st of March)
      </td>
    </tr>
    </table>    
    <br/>
    
    <table border=0 cellpadding=3>
    <tr>
      <td align=center colspan=2><b>Pricing<b> (monthly recurring)</td>
    </tr><tr>
      <td align=left>10,000 transactions traffic (default)</td>
      <td align=right>&nbsp;&nbsp;$9</td>
    </tr><tr>
      <td align=left>50,000 transactions traffic</td>
      <td align=right>&nbsp;&nbsp;$19</td>
    </tr><tr>
      <td align=left>100,000 transactions traffic</td>
      <td align=right>&nbsp;&nbsp;$29</td>
    </tr><tr>
      <td align=left>200,000 transactions traffic</td>
      <td align=right>&nbsp;&nbsp;$44</td>
    </tr><tr>
      <td align=left>need more traffic?</td>
      <td align=right>&nbsp;&nbsp;Contact us</td>
    </tr>
    </table>
    
    <br/><br/>
    
<?php  } ?>
    </td>
</tr>
<tr>
    <td align=left width=700>
    <hr>
    
        <form method="POST" action="../al/scripts/payment_redirect.php" target="_blank">
        <input type="hidden" name="lid" value="<?php echo $GLOBALS['Auth']->getLiteAccountID()?>">
        <input type="hidden" name="type" value="<?php echo PAYMENT_ADDITIONAL_TRAFFIC?>">
        <input type='hidden' name='quantity' value='1' >
        <input name="submit" type='submit' value='Buy Additional Traffic' ><br>
        </form>
                
        <br/>
        Buy additional traffic. This new additional traffic will be added to your traffic limit. 
        It will be used only after you spent your free traffic and (optional) bonus traffic from previous month.
        <br/>
        One time payment, no monthly fee. It will be transferred to next months if it is not spent.
        <br/><br/>

    <table border=0 cellpadding=3>
    <tr>
      <td align=center colspan=2><b>Pricing<b> (one time fee)</td>
    </tr><tr>
      <td align=left>50,000 transactions traffic (default)</td>
      <td align=right>&nbsp;&nbsp;$15</td>
    </tr>
    </table>
        
    </td>
</tr>
<tr>
    <td align=left width=700>
    <br>
    <hr>
    Payments handled by <br/>
    <img src="<?php echo  $this->a_this->getImage('2checkout.gif') ?>" border="0">
    </td>
</tr>
</table>
</td></tr></table>
