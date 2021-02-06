<br>
<form action="index_popup.php" method="POST">
<input type="hidden" name="md" value="Affiliate_Merchants_Views_AffiliateSelect">
<input type="hidden" name="commited" value="1">
<input type="hidden" name="selectID" value="<?php echo $_REQUEST['selectID']?>">
<input type="hidden" name="selectForm" value="<?php echo $_REQUEST['selectForm']?>">
<table cellpadding="2" cellspacing="0" border="0" width="95%" class="listing">
<?php QUnit_Templates::printFilter(4, L_G_SHOWAFFILIATESWHERE); ?>
<tr class="listheaderNoLine"><td></td>
    <td><input type="hidden" name=affsel_custom1 value="a.name">
        <b><?php echo L_G_NAME?></b></td>
    <td nowrap><?php echo L_G_ISLIKE?></td>
    <td><input type=text name=affsel_custom1data size=12 value="<?php echo $_REQUEST['affsel_custom1data']?>"></td>
</tr>
<tr class="listheaderNoLine"><td><?php echo L_G_AND?></td>
    <td><input type="hidden" name=affsel_custom2 value="a.surname">
        <b><?php echo L_G_SURNAME?></b></td>
    <td nowrap><?php echo L_G_ISLIKE?></td>
    <td><input type=text name=affsel_custom2data size=12 value="<?php echo $_REQUEST['affsel_custom2data']?>"></td>
</tr>
<?php for ($i = 3; $i < 3+$this->a_customFieldsNo; $i++) { ?>
<tr class="listheaderNoLine"><td><?php echo ($i != 1) ? L_G_AND : ''?></td>
    <td>&nbsp;<select name=affsel_custom<?php echo $i?>>
        <?php foreach($this->a_filterColumns as $key => $value) {
               print "<option value='$key' ".($_REQUEST['affsel_custom'.$i] == $key ? 'selected' :'').">$value</option>";
            } 
        ?>
        </select></td>
    <td nowrap><?php echo L_G_ISLIKE?></td>
    <td><input type=text name=affsel_custom<?php echo $i?>data size=12 value="<?php echo $_REQUEST['affsel_custom'.$i.'data']?>"></td>
</tr>
<?php } ?>
<tr class="listheaderNoLine"><td colspan="4"><br></td></tr>
<tr class="listheaderNoLine"><td colspan="4" align="center">
        <input type="submit" class="formbutton" value="<?php echo L_G_SHOWAFFILIATES?>"><br><br></td>
</tr>
</table>
</form>