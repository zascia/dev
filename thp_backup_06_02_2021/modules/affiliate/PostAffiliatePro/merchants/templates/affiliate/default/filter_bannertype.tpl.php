<table cellpadding="2" cellspacing="0" border="0">
<tr><td valign=top width="110">&nbsp;<b><?php echo L_G_BANNERTYPE?></b>&nbsp;<?php showQuickHelp(L_G_BANNERTYPEFILTER); ?><br>
        &nbsp;<?php echo L_G_SELSELECT?> <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix?>bannertype[]', true);"><?php echo L_G_SELALL?></a>
        / <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix?>bannertype[]', false);"><?php echo L_G_SELNONE?></a></td>
    <td valign="top" nowrap>
        <input type="hidden" name="bannertype_comitted" value="1">
        <input type="checkbox" name=<?php echo $this->a_form_preffix?>bannertype[] value="<?php echo BANNERTYPE_HTML?>"
            <?php echo (@in_array(BANNERTYPE_HTML, $_REQUEST[$this->a_form_preffix.'bannertype'])) ? 'checked' : ''?>>
        <?php echo L_G_BANNERTYPE_HTML?></td>
    <td valign="top" nowrap>
        <input type="checkbox" name=<?php echo $this->a_form_preffix?>bannertype[] value="<?php echo BANNERTYPE_TEXT?>"
            <?php echo (@in_array(BANNERTYPE_TEXT, $_REQUEST[$this->a_form_preffix.'bannertype'])) ? 'checked' : ''?>>
        <?php echo L_G_BANNERTYPE_TEXT?></td>
    <td valign="top" nowrap>
        <input type="checkbox" name=<?php echo $this->a_form_preffix?>bannertype[] value="<?php echo BANNERTYPE_IMAGE?>"
            <?php echo (@in_array(BANNERTYPE_IMAGE, $_REQUEST[$this->a_form_preffix.'bannertype'])) ? 'checked' : ''?>>
        <?php echo L_G_BANNERTYPE_IMAGE?></td>
    <td valign="top" nowrap>
        <input type="checkbox" name=<?php echo $this->a_form_preffix?>bannertype[] value="<?php echo BANNERTYPE_POPUP?>"
            <?php echo (@in_array(BANNERTYPE_POPUP, $_REQUEST[$this->a_form_preffix.'bannertype'])) ? 'checked' : ''?>>
        <?php echo L_G_BANNERTYPE_POPUP?></td>
    <td valign="top" nowrap>
        <input type="checkbox" name=<?php echo $this->a_form_preffix?>bannertype[] value="<?php echo BANNERTYPE_POPUNDER?>"
            <?php echo (@in_array(BANNERTYPE_POPUNDER, $_REQUEST[$this->a_form_preffix.'bannertype'])) ? 'checked' : ''?>>
        <?php echo L_G_BANNERTYPE_POPUNDER?></td>
    <td valign="top" nowrap>
        <input type="checkbox" name=<?php echo $this->a_form_preffix?>bannertype[] value="<?php echo BANNERTYPE_ROTATOR?>"
            <?php echo (@in_array(BANNERTYPE_ROTATOR, $_REQUEST[$this->a_form_preffix.'bannertype'])) ? 'checked' : ''?>>
        <?php echo L_G_BANNERTYPE_ROTATOR?></td></tr>
</table>