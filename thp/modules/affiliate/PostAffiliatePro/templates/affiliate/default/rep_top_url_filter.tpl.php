<form id="FilterForm" name="FilterForm" action="index.php" method="get">
<?php if ($this->a_list_users != '') { ?>
<table border=0 cellspacing=0 cellpadding=2 width="780">
<tr><td><?php echo L_G_TOPREFERRINGURLS_DESCRIPTION?><br><br></td></tr>
</table>
<?php } ?>
<table class=listing border=0 cellspacing=0 cellpadding=2 width="780" style="border-bottom: 0px;">
<?php QUnit_Templates::printAdvancedFilter(1, L_G_TOPREFERRINGURLS, $this->a_form_preffix, $this->a_form_name); ?>
<tr class="listheaderNoLineLeft">
  <td valign=top align=left>
  <table border=0 width="100%">
  <tr><td valign="top">
        <div id="<?php echo $this->a_form_preffix?>standard_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? 'style="display:none;"' : ''?>>
        </div>
        <div id="<?php echo $this->a_form_preffix?>advanced_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? '' : 'style="display:none;"'?>>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td align="left" valign="top" width="1%" nowrap>
<?php  if (!$this->a_affPanel) { ?>
            
                <?php if ($this->a_list_users != '')
                       QUnit_Global::includeTemplate('filter_affiliate.tpl.php'); ?>
            
<?php  } ?>
<!--
            <b><?php echo L_G_NUMBEROFVALUESINGRAPH?>:</b>
            <select name="<?php echo $this->a_form_preffix?>numgraphvalues">
                <option value="10" <?php echo ($_REQUEST[$this->a_form_preffix.'numgraphvalues']) == 10 ? 'selected' : ''?>>10</option>
                <option value="20" <?php echo ($_REQUEST[$this->a_form_preffix.'numgraphvalues']) == 20 ? 'selected' : ''?>>20</option>
                <option value="30" <?php echo ($_REQUEST[$this->a_form_preffix.'numgraphvalues']) == 30 ? 'selected' : ''?>>30</option>
                <option value="50" <?php echo ($_REQUEST[$this->a_form_preffix.'numgraphvalues']) == 50 ? 'selected' : ''?>>50</option>
            </select>
-->
            <br>
            </td>
            <td align="left" valign=top width="1%" nowrap>
                <?php QUnit_Global::includeTemplate('filter_transtype.tpl.php'); ?>
	       </td>
        </tr>
        </table>
        <hr class="filterline">
        </div>
      </td></tr>
  <tr class="listheaderNoLineLeft"><td align=left>
          <?php QUnit_Global::includeTemplate('filter_time.tpl.php'); ?>
      </td>
  </tr>
  <tr><td align=left class="listheaderNoLineLeft">
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='<?php echo $this->a_md?>'>
      <input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>
      <input type=hidden name=reporttype value='transactions'>
      <input class=formbutton type=submit value='<?php echo L_G_APPLYFILTER?>'>      
      </td>
  </tr>
  </table>
</tr>
</table>
