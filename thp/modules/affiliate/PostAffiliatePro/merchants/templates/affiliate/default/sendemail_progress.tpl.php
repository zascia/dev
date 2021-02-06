<br>
<table class=listing border=0 cellspacing=0 cellpadding=2 width="90%">
<?php QUnit_Templates::printFilter(1, L_G_SENDINGEMAILS); ?>
<tr>
  <td class=dir_form valign=top align="center" nowrap>
    <br>
    <?php if ($this->a_message == 'end') { ?>
    		<?php echo L_G_ALLDONE?><br><br>
    		<input class=formbutton type=submit value='<?php echo L_G_CLOSE?>'  onClick='javascript:window.opener.document.location.href="index.php?md=Affiliate_Merchants_Views_BroadcastMessage&action=showresults"; window.close();'>
    <?php } else { ?>
    		<?php echo $this->a_message?><br><br>
    		<?php echo L_G_PLEASEWAIT?>
    <?php } ?>
    <br><br>
  </td>
</tr>
</table>
