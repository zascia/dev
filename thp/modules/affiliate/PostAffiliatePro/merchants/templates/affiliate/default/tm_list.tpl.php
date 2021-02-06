<script>
function addTransaction()
{
//	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TransactionManager&action=create&type=all","Transaction","scrollbars=1, top=100, left=100, width=500, height=500, status=0");
//    wnd.focus();
  document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&action=create&type=all"+"&<?php echo SID?>";
}

function editTransaction(ID)
{
  document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&action=edit&tid="+ID+"&<?php echo SID?>";
//  var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TransactionManager&action=edit&tid="+ID,"Transaction","scrollbars=1, top=100, left=100, width=500, height=500, status=0");
//  wnd.focus();
}

function createRefundTransaction(ID)
{
  document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&loaddata=1&tm_transtype=<?php echo TRANSTYPE_REFUND?>&action=createrefundchargeback&tid="+ID+"&<?php echo SID?>";
//  var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TransactionManager&action=createrefund&tid="+ID,"Refund transaction","scrollbars=1, top=100, left=100, width=300, height=200, status=0");
//  wnd.focus();
}

function createChargebackTransaction(ID)
{
  document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&loaddata=1&tm_transtype=<?php echo TRANSTYPE_CHARGEBACK?>&action=createrefundchargeback&tid="+ID+"&<?php echo SID?>";
//  var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TransactionManager&action=createchargeback&tid="+ID,"Refund transaction","scrollbars=1, top=100, left=100, width=300, height=200, status=0");
//  wnd.focus();
}

function ChangeState(ID, action)
{
  if(action == "suppress")
  {
    if(confirm("<?php echo L_G_CONFIRMSUPPRESSTRANS?>"))
     	document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all&tid="+ID+"&action="+action+"&<?php echo SID?>";
  }
  else if(action == "approve")
  {
    if(confirm("<?php echo L_G_CONFIRMAPPROVETRANS?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all&tid="+ID+"&action="+action+"&<?php echo SID?>";
  }
  else if(action == "pending")
  {
    if(confirm("<?php echo L_G_CONFIRMPENDINGTRANS?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all&tid="+ID+"&action="+action+"&<?php echo SID?>";
  }
}

function Delete(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETETRANS?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all&tid="+ID+"&action=delete"+"&<?php echo SID?>";
}

function ViewIPInfo(IP)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TransactionManager&action=ipinfo&ip="+IP, "<?php echo L_G_IPDETAILS?>" ,"scrollbars=1, top=100, left=100, width=320, height=220, resizable=1, status=0")
    wnd.focus();
}

function massDeleteTransaction() {
    if(confirm("<?php echo L_G_CONFIRMMASSDELETETRANSACTION?>")) {
        document.getElementById('massaction').value='delete'
        document.getElementById('ListForm').submit();
    }
}
</script>

<form name=FilterForm id=FilterForm action=index.php method=get>
<input type=hidden name=filtered value=1>
<input type=hidden name=md value='Affiliate_Merchants_Views_TransactionManager'>
<input type=hidden name=type value='all'>
<input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>
<input type=hidden id=action name=action value=''>
<input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
<input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">
<table cellpadding="0" cellspacing="0" border="0" width="780">
<tr><td valign="top"><?php echo L_G_TRANSACTION_DESCRIPTION?><br><br>
    <?php
    if($this->a_exportFileName != '') { ?>
        <table class=listing border=0 cellspacing=0 cellpadding=1>
            <tr>
                <td align=center><?php echo L_G_DOWNLOADCSV?> <br><a class=mainlink
                    href="<?php echo $this->a_Auth->getSetting('Aff_export_url').$this->a_exportFileName?>"><b><?php echo $this->a_exportFileName?></b></a></td>
            </tr>
        </table>
        <br><br>
    <?php } ?>
</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td width="1%" align="right"><?php showLoadedDataDiv("index_cache.php?md=Affiliate_Merchants_Views_TransactionManager&action=showtransactionstats", true); ?></td></tr>
</table>
<br>
<table cellpadding="0" cellspacing="0" border="0" width="1%">
<tr><td align="left" valign="bottom" width="780" colspan="2">
        <?php QUnit_Global::includeTemplate('tm_filter.tpl.php'); ?></td>
     </tr>
<tr><td align="left" colspan="2">
   <table class=listingClosed border=0 cellspacing=0 cellpadding=0>
    <tr>
        <td class=listPaging align=right>
        <table width="100%" border="0" height="18" cellspacing="0" cellpadding="0">
        <tr>
            <td class=listheaderNoLineNoBold nowrap>
                <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
            </td>
            <td class=listheaderNoLine width="1%" nowrap>
                &nbsp;
                <a class=simplelink href="javascript:showListOptions();"><?php echo L_G_LISTOPTIONS?></a>
                &nbsp;
            </td>
        </tr>
        </table>

        <div id="view_av_options" style="display:none;">
        <table width="100%"  height="18" cellspacing="0" cellpadding="0">
        <tr>
            <td class=listViewLineRight>
                <?php $this->a_this->printAvailableViews('Affiliate_Merchants_Views_TransactionManager'); ?>
            </td>
        </tr>
        </table>

        </div>
        </td>
    </tr>
    <tr>
        <td align=left>
        <table width="100%" cellspacing="0" cellpadding="1">
</form>
<form name="ListForm" id="ListForm" action=index.php method=post>
        <tr class=listheader>
            <?php $this->a_this->printMassAction('listheaderLeft'); ?>
        </tr>
        <tr class=listheader>
            <?php $this->a_this->printListHeader(); ?>
        </tr>

<?php
        if($this->a_allcount == 0) {
            $this->a_this->printNoRecords();
        } else {
            while($row = $this->a_list_data->getNextRecord())
            {
?>
            <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
                <?php $this->a_this->printListRow($row); ?>
            </tr>
<?php
            }
        }
?>
        </table>
        </td>
    </tr>
    <td class=listheader nowrap>
        <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?></td>
    </tr>
    <tr class=listheader>
        <?php $this->a_this->printMassAction('listheaderLeft', true); ?>
    </tr>
    </table>
</td></tr>
</table>

<input type=hidden name=tmdl_status value="<?php echo $_REQUEST['tmdl_status']?>">
<input type=hidden name=md value='Affiliate_Merchants_Views_TransactionManager'>
<input type=hidden name=commited value='yes'>
</form>

<br><br>

