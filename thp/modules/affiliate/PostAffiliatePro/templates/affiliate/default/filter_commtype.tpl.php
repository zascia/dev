<?php $columnCount = 3; ?>
<table cellpadding="2" cellspacing="0" border="0">
<tr><td valign=top width="125" nowrap>&nbsp;<b><?php echo L_G_CAMPAIGNTYPE?></b>&nbsp;<?php showQuickHelp(L_G_HLP_TRANSTYPE); ?> <br>
        &nbsp;<?php echo L_G_SELSELECT?> <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix?>transtype[]', true);"><?php echo L_G_SELALL?></a>
        / <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix?>transtype[]', false);"><?php echo L_G_SELNONE?></a></td>
    <td valign="top" nowrap>
        <input type="hidden" name="transtype_comitted" value="1">
        <table cellpadding="0" cellspacing="0" border="0">
     <?php $comm = $this->a_Auth->getSupportedCommissions(false);
        reset($comm);
        for ($row=0; $row < ceil(count($comm)/$columnCount); $row++) { ?>
            <tr>
     <?php     for ($column=0; $column < $columnCount; $column++) { 
            if (current($comm) == '') { ?>
                <td></td>
     <?php         continue;
            } ?>       
            <td><input type="checkbox" name="<?php echo $this->a_form_preffix?>transtype[]" value="<?php echo key($comm)?>"
                   <?php echo (@in_array(key($comm), $_REQUEST[$this->a_form_preffix.'transtype'])) ? 'checked' : ''?>>
                &nbsp;<?php echo current($comm)?>&nbsp;&nbsp;</td>
     <?php     next($comm);
            } ?>
            </tr>
     <?php } ?>
        </table>
    </td></tr>
</table>
