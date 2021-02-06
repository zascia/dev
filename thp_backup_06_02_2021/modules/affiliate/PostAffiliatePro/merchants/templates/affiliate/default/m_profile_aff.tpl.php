
    <table width="430" class=listing border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(2, L_G_AFFSTATS); ?>
    <tr>
        <td align=center colspan=2><b><?php echo L_G_ALLAFFILIATES?> &nbsp;[</b><a class=textlink href='index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1'><?php echo $this->a_aff_all?></a><b>]</b></td>
    </tr>
    <tr>
        <td align=left colspan=2>
        <?php echo $this->a_affstats_graph?>
        <br>
        </td>
    </tr>
    </table>

