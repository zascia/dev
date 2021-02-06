<script>
function selectAffiliate(selectID, event)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateSelect&selectForm=FilterForm&selectID="+selectID,"Affiliate",
	           "scrollbars=1, resizable=1, top="+event.screenY+", left="+event.screenX+", width=350, height=210, status=0");
    wnd.focus();
}
</script>
<table cellpadding="2" cellspacing="0" border="0">
<tr><td valign=top nowrap <?php echo ($this->a_affselect_caption == '') ? 'width="95"' : 'width="150"'?>>
        &nbsp;<?php echo ($this->a_affselect_caption == '') ? '<b>'.L_G_AFFILIATE.'</b>' : $this->a_affselect_caption?><?php showQuickHelp(L_G_HLP_AFFILIATE); ?><br>
        &nbsp;<a href="javascript:;" class="simplelink" onclick="javascript:selectAffiliate('<?php echo $this->a_form_preffix?>userid', event);"><?php echo L_G_SELECTAFFILIATE?></a>
        </td>
    <td valign="top" nowrap>
        <select name="<?php echo $this->a_form_preffix?>userid">
            <option value="_"><?php echo L_G_ALL?></option>
        <?php while($data=$this->a_list_users->getNextRecord()) { ?>
            <option value="<?php echo $data['userid']?>" <?php echo ($_REQUEST[$this->a_form_preffix.'userid'] == $data['userid'] ? 'selected' : '')?>>
            <?php echo $data['userid'].': '.(($data['name']!='' || $data['surname']!='') ? $data['surname'].' '.$data['name'] : $data['username'])?>
            <?php echo $data['rstatus']==AFFSTATUS_NOTAPPROVED ? ' - '.strtoupper(L_G_PENDING) : ''?>
            <?php echo $data['rstatus']==AFFSTATUS_SUPPRESSED ? ' - '.strtoupper(L_G_SUPPRESSED) : ''?>
            </option>
        <?php } ?>      
        </select>
        <a href="javascript:;" class="simplelink" onclick="javascript:selectAffiliate('<?php echo $this->a_form_preffix?>userid', event);"><img src="<?php echo $this->a_this->getImage('user_select.png')?>" title="<?php echo L_G_SELECTAFFILIATE?>" alt="<?php echo L_G_SELECTAFFILIATE?>" align="right"></a>
    </td></tr>
<tr><td nowrap colspan="2">
        
    </td></tr>
</table>