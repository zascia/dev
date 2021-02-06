<table class=listing border=0 cellspacing=0 cellpadding=2 style="border-bottom: 0px;">
<?php QUnit_Templates::printFilter(1, L_G_FILTER); ?>
<tr><td class="listheaderNoLineLeft">
        <table cellpadding="2" cellspacing="0" border="0" width="100%">
        <tr><td valign="top">
                <table cellpadding="0" cellspacing="0">
                <tr><td>&nbsp;&nbsp;<?php echo L_G_SHOWRESULTSWHERE?>&nbsp;</td>
                    <td><b><?php echo L_G_PCNAME?></b></td>
                    <td>&nbsp;<?php echo L_G_ISLIKE?>&nbsp;</td>
                    <td><input class="forminput" type=text name="<?php echo $this->a_form_preffix?>cname" size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'cname']?>"></td></tr>
                </table>
            </td>
          </tr><tr>
            <td valign="top">
                <?php QUnit_Global::includeTemplate('filter_commtype.tpl.php'); ?>
            </td>
        </tr>
        </table>
        <hr class="filterline">
    </td></tr>
<tr><td class="listheaderNoLineLeft">
        &nbsp;&nbsp;<input type="submit" class="formbutton" value="<?php echo L_G_APPLYFILTER?>"><br></td></tr>
</table>