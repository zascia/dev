<table class=listing border=0 cellspacing=0 cellpadding=2 width="780" style="border-right:0;border-bottom:0">
    <tr>
        <td class=listheader colspan=8 align=center>
            <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
        </td>
    </tr>
    <tr>
        <td class=listheader><?php echo L_G_AFFILIATE?></td>
        <td class=listheader width="10%"><?php echo L_G_IMPRESSIONS?></td>
        <td class=listheader width="10%"><?php echo L_G_CLICKS?></td>
        <td class=listheader width="10%"><?php echo L_G_SALES?></td>
        <td class=listheader width="10%"><?php echo L_G_LEADS?></td>
        <td class=listheader width="15%"><?php echo L_G_LASTLOGINDATE?></td>
        <td class=listheader width="5%"><?php echo L_G_LOGINCOUNT?></td>
        <td class=listheader width="15%"><?php echo L_G_DATE_INSERTED?></td>
    </tr>
    <?php if (empty($this->a_this->results)) { ?>
    <tr>
        <td class=listresult colspan=8 align=center><?php echo L_G_NORESULTS?></td>
    </tr>
    <?php } else { ?>
        <?php foreach($this->a_this->results as $key => $result) { ?>
            <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
                <td class=listresultnocenter align=left>
                    <font color="#0000ff">&nbsp;<?php echo $result['surname'].', '.$result['name']?></font>
                    <?php showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affalldetails&aid=".$result['userid'], 300);?>
                </td>
                <td class=listresultnocenter align=right><?php echo $result['impressions']?></td>
                <td class=listresultnocenter align=right><?php echo $result['clicks']?></td>
                <td class=listresultnocenter align=right><?php echo $result['sales']?></td>
                <td class=listresultnocenter align=right><?php echo $result['leads']?></td>
                <td class=listresultnocenter align=center><?php echo $result['lastlogindate']?></td>
                <td class=listresultnocenter align=right><?php echo $result['logincount']?></td>
                <td class=listresultnocenter align="center"><?php echo $result['datejoined']?></td>
            </tr>
        <?php } ?>
    <?php } ?>
</form>
<form name="ListForm" id="ListForm" action=index.php method=post>
    <tr>
        <td class=listheader colspan=8 align=center>
            <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
        </td>
    </tr>
</table>
</form>
