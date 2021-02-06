<form name=myForm action=index.php method=post>
<table class=listing33 border=0 cellspacing=0 cellpadding=0 width="780">
<tr>
    <td class=settings align=left>
        <?php echo $this->a_tabcontent?>
    </td>
</tr>

<tr><td height="5"></td></tr>

<tr>
    <td align=left>
    &nbsp;&nbsp;
             <input type=hidden name=commited value=yes>
             <input type=hidden name=md value="Affiliate_Merchants_Views_SignupSettings">
             <input type=hidden name=action value="<?php echo $_REQUEST['action']?>">
<!--             <input type=hidden name=subact value=<?php echo $_POST['subact']?>>-->
             <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
             <input type=hidden name=sheet id=sheet value='<?php echo $_REQUEST['sheet']?>'>
             <input type=hidden name=subact value='<?php echo $_REQUEST['sheet']?>'>
             <?php if ($this->a_this->checkPermissions('edit')) { ?>
                <input class=formbutton type=submit value='<?php echo L_G_SUBMIT; ?>'>
             <?php } else { ?>
                <input class=formbutton type=button value="<?php echo L_G_YOU_DONT_HAVE_RIGHTS_TO_EDIT?>">
             <?php } ?>
             <br><br>
    </td>
</tr>
</table>
</form>

