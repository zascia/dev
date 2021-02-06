
<table border=0 cellspacing=0 cellpadding=1 width="780">
<tr><td><?php echo L_G_AFFCOUNT_DESCRIPTION?></td></tr>
</table>
<br>
<table class=listing border=0 cellspacing=0 cellpadding=2 width="780">
<?php QUnit_Templates::printFilter(4, L_G_AFFILIATECOUNTS); ?>
<form id="FilterForm" action=index.php method=get>
<tr class="listheader">
    <td align=left>
        <b><?php echo L_G_TIMEPERIOD?></b>
    </td>
    <td align=left>
        &nbsp;
        <?php echo L_G_PER.' '.L_G_YEAR?>
    </td>
    <td align=left>
        <select name=rac_py_year>
<?php      for($i=PAP_STARTING_YEAR; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rac_py_year'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>
    </td>
    <td width="70%"></td>
</tr>
<tr class="listheader">
    <td align=left colspan=4>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Merchants_Views_MerchantReports'>
        <input type=hidden name=reporttype value='affiliatecounts'>
        <input class=formbutton type=submit value='<?php echo L_G_APPLYFILTER?>'>      
    </td>
</tr>
</table>
</form>