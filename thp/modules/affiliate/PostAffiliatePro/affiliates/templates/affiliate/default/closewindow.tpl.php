<center>
<?php if($this->redirect_modul != '' ) { ?>
    <input type=button class=formbutton value='<?php echo L_G_CLOSE?>' onClick='javascript:window.opener.document.location.href="index.php?md=<?php echo $this->redirect_modul?>&<?php echo SID?>"; window.close();'>
<?php } else { ?>
    <input type=button class=formbutton value='<?php echo L_G_CLOSE?>' onClick='window.close();'>
<?php } ?>
</center>
