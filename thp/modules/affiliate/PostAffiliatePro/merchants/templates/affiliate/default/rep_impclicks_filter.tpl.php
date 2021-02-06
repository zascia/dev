<table border="0" cellspacing="0" cellpading="0" width="780" >
    <tr>
	<td align="left" valign="top"><?php echo L_G_IMPCLICKSREPORT_DESCRIPTION ?><br><br></td>
    </tr>
</table>
<br>
<form name=FilterForm id=FilterForm  action=index.php method=get>
<!-- added advanced filter  -->
<table class=listing border=0 cellspacing=0 cellpadding=2 width="780" style="border-bottom: 0px;">
<?php QUnit_Templates::printAdvancedFilter(1, L_G_IMPRESSIONCLICKS, $this->a_form_preffix, $this->a_form_name); ?>
<tr class="listheaderNoLineLeft">
  <td valign=top align=left>
  <table border=0 cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td>
        <div id="<?php echo $this->a_form_preffix?>standard_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? 'style="display:none;"' : ''?>>
        </div>
        <div id="<?php echo $this->a_form_preffix?>advanced_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? '' : 'style="display:none;"'?>>
        <br>
        <table cellpadding="2" cellspacing="0" border="0" width="100%">
	<tr>
            <td valign="top">
                <?php QUnit_Global::includeTemplate('filter_transtype.tpl.php'); ?>
                <hr class="filterline">
                <?php QUnit_Global::includeTemplate('filter_status.tpl.php'); ?>
		<hr class="filterline">
		<?php QUnit_Global::includeTemplate('filter_transaction_date.tpl.php');  ?>
		<hr class="filterline">
		<?php $this->a_this->assign('a_affselect_caption', '<b>'.L_G_PARENTAFFILIATE.'</b>');
		   QUnit_Global::includeTemplate('filter_affiliate.tpl.php') ?>
            </td>
        </tr>
        </table>
        <hr class="filterline">
        </div>
    </td>
  </tr> 
  <tr>
      <td align=left>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='<?php echo $this->a_md?>'>
      <input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'> 
      <input type=hidden name=reporttype value='impclicks'>
      <input type=hidden name=sortby value='<?php echo $_REQUEST['sortby']?>'>
      <input type=hidden name=sortorder value='<?php echo $_REQUEST['sortorder']?>'>
      <input type=hidden name=filtered value="1" >
      </td>
  </tr>
  <tr><td>
        <?php QUnit_Global::includeTemplate('filter_campaign.tpl.php') ?>
        <hr class="filterline">
        <?php QUnit_Global::includeTemplate('filter_time.tpl.php') ?>
        &nbsp;&nbsp;<input type="submit" class="formbutton" value="<?php echo L_G_APPLYFILTER?>"><br></td></tr>
  </table>
</td></tr>
</table>