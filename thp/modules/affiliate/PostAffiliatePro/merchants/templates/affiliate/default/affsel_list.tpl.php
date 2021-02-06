<?php
function getStrippedString($string, $length) {
    if(strlen($string) > $length) {
        return substr($string, 0, $length-3).'<font title="'.$string.'">...</font>';
    }
    return $string;
}
?>
<script>
function selectUser(ID) {
    this.opener.document.forms['<?php echo $_REQUEST['selectForm']?>'].elements['<?php echo $_REQUEST['selectID']?>'].value = ID;
    window.close();
}
</script>
<br>
<form name=FilterForm id=FilterForm action=index_popup.php method=get>
<input type="hidden" id="list_page" name="list_page" value="<?php echo $_REQUEST['list_page']?>">
<input type="hidden" name="md" value="Affiliate_Merchants_Views_AffiliateSelect">
<input type="hidden" name="commited" value="1">
<input type="hidden" name="selectID" value="<?php echo $_REQUEST['selectID']?>">
<input type="hidden" name="selectForm" value="<?php echo $_REQUEST['selectForm']?>">
<table cellpadding="2" cellspacing="0" border="0" width="95%" class="listing">
<?php QUnit_Templates::printFilter(5, L_G_AFFILIATES); ?>
<tr><td colspan="5" align="center" class="listheader"><?php QUnit_Templates::printSimplePaging($this->a_list_page, $this->a_list_pages, $this->a_allcount, $this->a_numrows) ?></td></tr>
<?php while($data = $this->a_list_data->getNextRecord()) { ?>    
<tr><td nowrap class="listresultnocenter"><?php echo $data['userid']?></td>
    <td nowrap class="listresultnocenter"><?php echo getStrippedString($data['username'], 20)?></td>
    <td nowrap class="listresultnocenter"><?php echo getStrippedString($data['surname'].' '.$data['name'], 20)?></td>
    <td nowrap class="listresult">
        <?php switch ($data['rstatus_numeric']) {
            case AFFSTATUS_APPROVED:    $img = 'sphore_active.png'; break;
            case AFFSTATUS_NOTAPPROVED: $img = 'sphore_pending.png'; break;
            case AFFSTATUS_SUPPRESSED:  $img = 'sphore_declined.png'; break;
            default:                    $img = ''; break;
           }
        ?>
        <img src="<?php echo $this->a_this->getImage($img)?>" title="<?php echo $data['rstatus']?>" alt="<?php echo $data['rstatus']?>"></td>
    <td nowrap class="listresult"><a href="javascript:selectUser('<?php echo $data['userid']?>');"><img src="<?php echo $this->a_this->getImage('select.png')?>" alt="<?php echo L_G_SELECT?>" title="<?php echo L_G_SELECT?>""></a></td></tr>
<?php } ?>
<tr><td colspan="5" align="center" class="listheaderNoLine">
    <input type="button" class="formbutton" value="<?php echo L_G_BACK?>" onclick="javascript:document.location.href='index_popup.php?md=<?php echo $this->a_md?>';">
</td></tr>
</table>
</form>
