<?php 
QUnit_Global::includeTemplate('expenses_filter.tpl.php');

if($this->a_exportFileName != '') { ?>

    <table class=listing border=0 cellspacing=0 cellpadding=1>
        <tr>
            <td align=center><?php echo L_G_DOWNLOADCSV?> <br><a class=mainlink
                href="<?php echo $this->a_Auth->getSetting('Aff_export_url').$this->a_exportFileName?>"><b><?php echo $this->a_exportFileName?></b></a></td>
        </tr>
    </table>
    <br><br>
<?php } ?>


   <table class=listingClosed border=0 cellspacing=0 cellpadding=0>
    <tr>
        <td class=actionheader align=left>
          <?php if($this->a_action_permission['create']) { ?>
            <b><a class=mainlink href="javascript:addExpense();"><?php echo L_G_CREATEEXPENSE?></a></b>
            &nbsp;&nbsp;|&nbsp;&nbsp;
          <?php } ?>
          <?php if($this->a_action_permission['view']) { ?>
            <b><a class=mainlink href="javascript:FilterForm.action.value='exportcsv'; FilterForm.submit();"><?php echo L_G_EXPORTTOCSV?></a></b>
          <?php } ?>
        </td>
    </tr>    
    <tr>
        <td class=listPaging align=right>
        <table width="100%" border="0" height="18" cellspacing="0" cellpadding="0">
        <tr>
            <td class=listheaderNoLineLeft width="30%" nowrap>
                &nbsp;
                <a class=simplelink href="javascript:showListOptions();"><?php echo L_G_LISTOPTIONS?></a>
                &nbsp;
            </td>
            <td width="40">&nbsp;</td>
            <td align="left" class=listheaderNoLineLeft nowrap>
                <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
            </td>
        </tr>
        </table>
        
        <div id="view_av_options" style="display:none;">
        <table width="100%"  height="18" cellspacing="0" cellpadding="0">
        <tr>
            <td class=listViewLine>
                <?php $this->a_this->printAvailableViews('Affiliate_Merchants_Views_ExpensesManager'); ?>
            </td>
        </tr>
        </table>
        
        </div>
        </td>
    </tr>
    <tr>
        <td align=left>
        <table width="100%" cellspacing="0" cellpadding="1">
        <tr class=listheader>
            <?php $this->a_this->printListHeader(); ?>
        </tr>
</form>
<form action=index.php method=post>
<?php
        while($row = $this->a_list_data->getNextRecord())
        {
?>    
        <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
            <?php $this->a_this->printListRow($row); ?>
        </tr>
<?php
    }
?>
        </table>
        </td>
    </tr>
<!--    <tr class=listheader>
        <?php $this->a_this->printMassAction($row); ?>
    </tr>-->
    </table>

<input type=hidden name=tmdl_status value="<?php echo $_REQUEST['tmdl_status']?>">
<input type=hidden name=md value='Affiliate_Merchants_Views_ExpensesManager'>
<input type=hidden name=commited value='yes'>
</form>

<br><br>

