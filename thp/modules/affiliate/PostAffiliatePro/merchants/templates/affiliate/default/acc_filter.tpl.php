<script>
function Details(ID)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_Accounting&aid="+ID+"&action=details"+"&<?php echo SID?>";
}

</script>

<form name=FilterForm id=FilterForm action=index.php method=post>
<input type=hidden name=filtered value=1>
<input type=hidden name=md value='Affiliate_Merchants_Views_Accounting'>
<input type=hidden name=rtype value='all'>
<input type=hidden id=action name=action value=''>
<input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
<input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">
<table class=listing border=0 cellspacing=0 cellpadding=2 style="border-bottom: 0px;">
<?php QUnit_Templates::printFilter(1, L_G_FILTER); ?>
<tr><td class="listheaderNoLineLeft">
        <?php QUnit_Global::includeTemplate('filter_affiliate.tpl.php'); ?>
        <hr class="filterline">
        <table cellpadding="0" cellspacing="0">
        <tr><td>&nbsp;&nbsp;<?php echo L_G_FILTERBY?>&nbsp;</td>
            <td><b><?php echo L_G_NOTE?></b>&nbsp;</td>
            <td><?php echo L_G_WHEREVALUEISLIKE?>&nbsp;</td>
            <td><input type=text name="<?php echo $this->a_form_preffix?>note" size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'note']?>"></td>
        </tr>
        </table>
        <hr class="filterline">
        <?php QUnit_Global::includeTemplate('filter_time.tpl.php') ?>
        <hr class="filterline">
        &nbsp;&nbsp;<input type="submit" class="formbutton" value="<?php echo L_G_APPLYFILTER?>"><br>
</td></tr>
</table>
</form>


