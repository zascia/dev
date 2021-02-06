<?php $columnCount = 6;
   $none_method = false; ?>
<table cellpadding="2" cellspacing="0" border="0">
<tr><td valign=top>&nbsp;<b><?php echo L_G_PAYOUTMETHOD?></b>&nbsp;<?php echo  showQuickHelp(L_G_HLP_PAYOUTMETHODS);?><br>
        &nbsp;<?php echo L_G_SELSELECT?> <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix?>payout_type[]', true);"><?php echo L_G_SELALL?></a>
        / <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix?>payout_type[]', false);"><?php echo L_G_SELNONE?></a></td>
    <td valign="top" nowrap>
        <table cellpadding="0" cellspacing="0" border="0">
     <?php $ptype = $this->a_payout_methods;
        reset($ptype);
        for ($row=0; $row < ceil(count($ptype)/$columnCount); $row++) { ?>
            <tr>
     <?php     for ($column=0; $column < $columnCount; $column++) { 
            if (current($ptype) == '') {
                if (!$none_method) {
                    $none_method = true; ?>
                    <td>
                        <input type="checkbox" name="<?php echo $this->a_form_preffix?>payout_type[]" value="none"
                        <?php echo (@in_array('none', $_REQUEST[$this->a_form_preffix.'payout_type'])) ? 'checked' : ''?>>
                        &nbsp;<?php echo L_G_NOMETHODCHOOSEN?>&nbsp;&nbsp;
                    </td>
     <?php         } else { ?>
                <td></td>
     <?php         } ?>
     <?php         continue;
            } 
            $p = current($ptype); ?>       
            <td><input type="checkbox" name="<?php echo $this->a_form_preffix?>payout_type[]" value="<?php echo $p['payoptid']?>"
                   <?php echo (@in_array($p['payoptid'], $_REQUEST[$this->a_form_preffix.'payout_type'])) ? 'checked' : ''?>>
                &nbsp;<?php echo (defined($p['langid']) ? constant($p['langid']) : $p['name']) ?>&nbsp;&nbsp;</td>
     <?php     next($ptype);
            } ?>
            </tr>
     <?php } ?>
        </table>
    </td></tr>
</table>