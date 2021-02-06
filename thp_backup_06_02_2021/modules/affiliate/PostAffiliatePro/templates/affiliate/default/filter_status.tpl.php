<?php
    $name = ($this->a_status_name == '') ? 'status' : $this->a_status_name;
    $caption = ($this->a_status_caption == '') ? L_G_STATUS : $this->a_status_caption;
    $help = ($this->a_status_help == '') ? L_G_HLP_STATUS : $this->a_status_help;
?>
<table cellpadding="2" cellspacing="0" border="0">
<tr><td valign=top width="125">&nbsp;<b><?php echo $caption?></b>&nbsp;<?php showQuickHelp($help); ?><br>
        &nbsp;<?php echo L_G_SELSELECT?> <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix.$name?>[]', true);"><?php echo L_G_SELALL?></a>
        / <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix.$name?>[]', false);"><?php echo L_G_SELNONE?></a></td>
    <td valign="top" nowrap>
        <input type="hidden" name="<?php echo $name?>_comitted" value="1">
        <?php if ($this->a_list_users != '' || ($_POST['allow_pending_trans'] == 'allow')) { ?>
        <input type="checkbox" name=<?php echo $this->a_form_preffix.$name?>[] value="<?php echo AFFSTATUS_NOTAPPROVED?>"
            <?php echo (@in_array(AFFSTATUS_NOTAPPROVED, $_REQUEST[$this->a_form_preffix.$name])) ? 'checked' : ''?>>
        <?php echo L_G_WAITINGAPPROVAL?>&nbsp;&nbsp;</td>
        <?php } ?>
    </td>
    <td valign="top" nowrap>
        <input type="checkbox" name=<?php echo $this->a_form_preffix.$name?>[] value="<?php echo AFFSTATUS_APPROVED?>"
            <?php echo (@in_array(AFFSTATUS_APPROVED, $_REQUEST[$this->a_form_preffix.$name])) ? 'checked' : ''?>>
        <?php echo L_G_APPROVED?>&nbsp;&nbsp;
    </td>
    <td valign="top" nowrap>
        <?php if ($this->a_list_users != '' || ($_POST['allow_declined_trans'] == 'allow')) { ?>
        <input type="checkbox" name=<?php echo $this->a_form_preffix.$name?>[] value="<?php echo AFFSTATUS_SUPPRESSED?>"
            <?php echo (@in_array(AFFSTATUS_SUPPRESSED, $_REQUEST[$this->a_form_preffix.$name])) ? 'checked' : ''?>>    
        <?php echo L_G_SUPPRESSED?>&nbsp;&nbsp;
        <?php } ?>
    </td></tr>
</table>