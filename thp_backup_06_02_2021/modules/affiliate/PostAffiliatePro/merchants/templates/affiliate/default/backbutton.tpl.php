<?php if($this->redirect_modul != '' ) { ?>
    <input type=button class=formbutton value='<?php echo L_G_BACK?>' onClick='javascript:document.location.href="index.php?md=<?php echo $this->redirect_modul?>&<?php echo SID?>";'>
<?php } else { ?>
    <input type=button class=formbutton value='<?php echo L_G_BACK?>' onClick='javascript:history.go(-1);'>
<?php } ?>
