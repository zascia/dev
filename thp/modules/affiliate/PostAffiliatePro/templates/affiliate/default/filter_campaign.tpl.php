<?php if ($GLOBALS['Auth']->getProgramType() == PROG_TYPE_LITE) { ?>
    <input type="hidden" name="<?php echo $this->a_form_preffix?>campaign" value="<?php echo DEFAULT_CAMPAIGN?>">
<?php } else { ?>
<table cellpadding="0" cellspacing="0" border="0">
<tr><td valign=top nowrap width="105">
        &nbsp;<b><?php echo L_G_CAMPAIGN?></b><?php showQuickHelp(L_G_HLP_CAMPAIGN); ?><br>
        </td>
    <td valign="top" nowrap>
        <select name="<?php echo $this->a_form_preffix?>campaign">
        <?php if(!$this->a_disable_all_campaigns) { ?>
            <option value="_"><?php echo L_G_ALL?></option>
        <?php } ?>
        <?php while($data=$this->a_list_campaigns->getNextRecord()) { ?>
            <option value="<?php echo $data['campaignid']?>" <?php echo ($_REQUEST[$this->a_form_preffix.'campaign'] == $data['campaignid'] ? 'selected' : '')?>>
            <?php echo $data['campaignid'].': '.$data['name']?>
            </option>
        <?php } ?>      
        </select>
    </td></tr>
</table>
<?php } ?>