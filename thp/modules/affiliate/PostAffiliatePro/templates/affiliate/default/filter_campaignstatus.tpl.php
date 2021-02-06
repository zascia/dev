<table cellpadding="2" cellspacing="0" border="0">
<tr><td valign=top width="125">&nbsp;<b><?php echo L_G_CAMPAIGNSTATUS?></b>&nbsp;<?php showQuickHelp(L_G_HLP_CAMPAIGNSTATUS); ?><br>
        &nbsp;<?php echo L_G_SELSELECT?> <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix?>campstatus[]', true);"><?php echo L_G_SELALL?></a>
        / <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix?>campstatus[]', false);"><?php echo L_G_SELNONE?></a></td>
    <td valign="top" nowrap>
        <input type="hidden" name="campstatus_comitted" value="1">
        <input type="checkbox" name=<?php echo $this->a_form_preffix?>campstatus[] value="<?php echo AFF_CAMP_PUBLIC?>"
            <?php echo (@in_array(AFF_CAMP_PUBLIC, $_REQUEST[$this->a_form_preffix.'campstatus'])) ? 'checked' : ''?>>
        <?php echo L_G_PUBLIC?>&nbsp;&nbsp;</td>
    </td>
    <td valign="top" nowrap>
        <input type="checkbox" name=<?php echo $this->a_form_preffix?>campstatus[] value="<?php echo AFF_CAMP_PRIVATE?>"
            <?php echo (@in_array(AFF_CAMP_PRIVATE, $_REQUEST[$this->a_form_preffix.'campstatus'])) ? 'checked' : ''?>>
        <?php echo L_G_PRIVATE?>&nbsp;&nbsp;
    </td></tr>
</table>