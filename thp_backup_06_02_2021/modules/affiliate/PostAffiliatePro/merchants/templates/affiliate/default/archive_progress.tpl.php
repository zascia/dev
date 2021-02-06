<br>
<table class=listing border=0 cellspacing=0 cellpadding=2 width="90%">
<?php QUnit_Templates::printFilter(1, L_G_ARCHIVE); ?>
<tr>
  <td class=dir_form valign=top align="center" nowrap>
    <br>
    <?php if ($this->a_progress == 1) { ?>
            <table>
            <tr><td><b><?php echo L_G_UNOPTIMIZEDROWS?>:</b> </td><td><?php echo $this->a_archiveResult['unoptimizedCount']?></td></tr>
            <tr><td><b><?php echo L_G_OPTIMIZEDROWS?>:</b>   </td><td><?php echo $this->a_archiveResult['optimizedCount']?></td></tr>
            </table>
            <br>
    		<input class=formbutton type=submit value='<?php echo L_G_ARCHIVE?>'  onClick='javascript: document.location.href ="index_popup.php?md=Affiliate_Merchants_Views_Archive&action=processarchive&start=yes"'>
    		<br><br>
    		<input class=formbutton type=button value='<?php echo L_G_CLOSE?>'  onClick='javascript: window.close();'>
    <?php } elseif ($this->a_progress >= 2 && $this->a_progress <= 5) { ?>
            <img src="<?php echo $this->a_this->getImage('icon_hour_anim.gif') ?>">
            <br>
    		<b><?php echo L_G_PLEASEWAIT?></b><br>
    		<?php echo L_G_STEP.' '.($this->a_progress-1).' '.L_G_OF.' 4'?>
    		<br><br>
    		<b style="color: red; font-size: 20px;"><?php echo L_G_DONTCLOSETHISWINDOW?></b>
    		<?php if (QUnit_Messager::getErrorMessage() == '') { ?>
    		<script>
    		    function refresh() {
                    document.location.href="index_popup.php?md=Affiliate_Merchants_Views_Archive&action=processarchive";
    		    }
    		    setTimeout('refresh()', 3000);
            </script>
            <?php } ?>
    <?php } else { ?>
            <b><?php echo L_G_ALLDONE?></b><br><br>
    		<input class=formbutton type=button value='<?php echo L_G_CLOSE?>'  onClick='javascript: window.close();'>
    <?php } ?>
    <br><br>
  </td>
</tr>
</table>
