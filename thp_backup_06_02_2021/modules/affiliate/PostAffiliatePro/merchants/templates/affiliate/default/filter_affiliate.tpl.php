<script>
function selectAffiliate(selectID, event)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateSelect&selectForm=<?php echo ($this->a_affselect_form_name != '') ? $this->a_affselect_form_name : 'FilterForm'?>&selectID="+selectID,"Affiliate",
	           "scrollbars=1, resizable=1, top="+event.screenY+", left="+event.screenX+", width=350, height=210, status=0");
    wnd.focus();
}
</script>
<table cellpadding="2" cellspacing="0" border="0">
<tr><?php if (!$this->a_affselect_no_caption) { ?>
    <td valign=top nowrap <?php echo ($this->a_affselect_caption == '') ? 'width="95"' : 'width="150"'?>>&nbsp;<?php echo ($this->a_affselect_caption == '') ? '<b>'.L_G_AFFILIATE.'</b>' : $this->a_affselect_caption?>&nbsp;<?php showQuickHelp(L_G_HLP_AFFILIATE); ?></td>
    <?php } ?>
    <td valign="top" nowrap>
        <?php $name = $this->a_form_preffix.(($this->a_affselectname == '' ) ? 'userid' : $this->a_affselectname); ?>
        <select name="<?php echo $name?>">
        <?php if($this->a_affselecet_all_disabled != '1') { ?>
            <option value="_"><?php echo L_G_ALL?></option>
        <?php } ?>
        <?php if($this->a_affselecet_none_enabled == '1') { ?>
            <option value=""><?php echo L_G_NONE2?></option>
        <?php } ?>
        <?php while($data=$this->a_list_users->getNextRecord()) { ?>
            <option value="<?php echo $data['userid']?>" <?php echo ($_REQUEST[$name] == $data['userid'] ? 'selected' : '')?>>
            <?php echo $data['userid'].': '.(($data['name']!='' || $data['surname']!='') ? $data['surname'].' '.$data['name'] : $data['username'])?>
            <?php echo $data['rstatus']==AFFSTATUS_NOTAPPROVED ? ' - '.strtoupper(L_G_PENDING) : ''?>
            <?php echo $data['rstatus']==AFFSTATUS_SUPPRESSED ? ' - '.strtoupper(L_G_SUPPRESSED) : ''?>
            </option>
        <?php } ?>      
        </select>
    </td>
    <td nowrap>
        <a href="javascript:;" class="simplelink" onclick="javascript:selectAffiliate('<?php echo $name?>', event);">
        <img src="<?php echo $this->a_this->getImage('user_select.png')?>" title="<?php echo L_G_SELECTAFFILIATE?>" alt="<?php echo L_G_SELECTAFFILIATE?>" align="absmiddle"><?php echo L_G_SELECTAFFILIATE?></a>
    </td></tr>
</table>