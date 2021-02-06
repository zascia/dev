<?php
// set month names
$months = array(1  => L_G_JAN,
                2  => L_G_FEB,
                3  => L_G_MAR,
                4  => L_G_APR,
                5  => L_G_MAY,
                6  => L_G_JUN,
                7  => L_G_JUL,
                8  => L_G_AUG,
                9  => L_G_SEP,
                10 => L_G_OCT,
                11 => L_G_NOV,
                12 => L_G_DEC);
?>
<?php
if (!defined('CALENDAR_JS_FUNCTIONS')) {
    define('CALENDAR_JS_FUNCTIONS', '1');
?>
<script language="JavaScript" src="<?php echo $GLOBALS['WEB_INCLUDE_PATH']?>/QUnit/calendar.js"></script>
<?php
}
?>
<form id="FilterForm" name="FilterForm" action=index.php method=get>
<?php if ($this->a_list_users != '') { ?>
<table border="0" cellspacing="0" cellpadding="0" width="780">
<tr><td><?php echo L_G_TRAFFICANDSALES_DESCRIPTION?><br><br></td></tr>
</table>
<?php } ?>
<!-- added advanced filter,table and filter_transaction_date.tpl.php  -->
<table class=listing border=0 cellspacing=0 cellpadding=2 width="780" style="border-bottom:0px;">
<?php QUnit_Templates::printAdvancedFilter(6, L_G_TRAFFIC, $this->a_form_preffix, $this->a_form_name); ?>
    <tr class="listheader">    
    <td align="left" valign="top">
    <div id="<?php echo $this->a_form_preffix?>standard_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? 'style="display:none;"' : '' ?>>
    </div>
    
    <div id="<?php echo $this->a_form_preffix?>advanced_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? '' : 'style="display:none;"'  ?>>
	    <?php QUnit_Global::includeTemplate('filter_transaction_date.tpl.php'); ?>
	    <hr class="filterline">
    </div>
    </td>
    </tr>
</table>
<!-- end added  -->
<table class="listing" border="0" cellspacing="0" cellpadding="2" width="780" style="border-bottom:0px;border-top:0px;">
    <tr class="listheader">
      <td align=left colspan="5">
         <?php QUnit_Global::includeTemplate('filter_campaign.tpl.php'); ?>
      </td>
      <td align=left width="50%">
      </td>
    </tr>
    <tr class="listheader">
      <td align=left colspan="5">
         <?php if ($this->a_list_users != '')
                QUnit_Global::includeTemplate('filter_affiliate.tpl.php'); ?>
      </td>
      <td align=left width="50%">
      </td>
    </tr>
    <tr class="listheader">
      <td align=left>
        <b><?php echo L_G_TIMEPERIOD?>&nbsp;<?php showQuickHelp(L_G_HLP_TIMEPERIOD_TRAFFIC); ?></b>
      </td>
      <td align=left>
        <input type=radio name=rt_reporttype value=perday <?php echo ($_REQUEST['rt_reporttype']=='perday' ? "checked" : "")?>>
        &nbsp;
        <?php echo L_G_HORLYINDAY?>
      </td>
      <td align=left>
        <select name=rt_pd_day>
          <option value="_" <?php echo ($_REQUEST['rt_pd_day'] == '_') ? "selected" : ""?>><?php echo L_G_ALL?></option>
<?php      for($i=1; $i<=31; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rt_pd_day'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>
      </td>
      <td align=left>
        <select name=rt_pd_month>
          <option value="_" <?php echo ($_REQUEST['rt_pd_month'] == '_') ? "selected" : ""?>><?php echo L_G_ALL?></option>
<?php      for($i=1; $i<=12; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rt_pd_month'] ? "selected" : "")?>><?php echo $months[$i]?></option>
<?php      } ?>
        </select>
      </td>
      <td align=left valign="middle">
        <select name=rt_pd_year>
          <option value="_" <?php echo ($_REQUEST['rt_pd_year'] == '_') ? "selected" : ""?>><?php echo L_G_ALL?></option>
<?php      for($i=PAP_STARTING_YEAR; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rt_pd_year'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>
        &nbsp;<script type="text/javascript" language="JavaScript">
                <!--
                calendar('<?php echo $this->a_form_name?>', '<?php echo $this->a_form_preffix?>pd_day', '<?php echo $this->a_form_preffix?>pd_month', '<?php echo $this->a_form_preffix?>pd_year',  '<?php echo $this->a_this->getImage('cal.gif')?>');
                //-->
              </script>
      </td>
      <td align=left width="50%">
      </td>
    </tr>
    <tr class="listheader">
      <td></td>
      <td align=left>
        <input type=radio name=rt_reporttype value=perweek <?php echo ($_REQUEST['rt_reporttype']=='perweek' ? "checked" : "")?>>
        &nbsp;
        <?php echo L_G_DAILYINWEEK?>
      </td>
      <td align=left>
      </td>
      <td align=left>
        <select name=rt_pw_week>
          <option value="_" <?php echo ($_REQUEST['rt_pw_week'] == '_') ? "selected" : ""?>><?php echo L_G_ALL?></option>
<?php      for($i=1; $i<=53; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rt_pw_week'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>
      </td>
      <td align=left>
        <select name=rt_pw_year>
          <option value="_" <?php echo ($_REQUEST['rt_pw_year'] == '_') ? "selected" : ""?>><?php echo L_G_ALL?></option>
<?php      for($i=PAP_STARTING_YEAR; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rt_pw_year'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>
      </td>
      <td align=left>
      </td>
    </tr>
    <tr class="listheader">
      <td></td>
      <td align=left>
        <input type=radio name=rt_reporttype value=permonth <?php echo ($_REQUEST['rt_reporttype']=='permonth' ? "checked" : "")?>>
        &nbsp;
        <?php echo L_G_DAILYINMONTH?>
      </td>
      <td align=left>
      </td>
      <td align=left>
        <select name=rt_pm_month>
          <option value="_" <?php echo ($_REQUEST['rt_pm_month'] == '_') ? "selected" : ""?>><?php echo L_G_ALL?></option>
<?php      for($i=1; $i<=12; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rt_pm_month'] ? "selected" : "")?>><?php echo $months[$i]?></option>
<?php      } ?>
        </select>
      </td>
      <td align=left>
        <select name=rt_pm_year>
          <option value="_" <?php echo ($_REQUEST['rt_pm_year'] == '_') ? "selected" : ""?>><?php echo L_G_ALL?></option>
<?php      for($i=PAP_STARTING_YEAR; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rt_pm_year'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>
      </td>
      <td align=left>
      </td>
    </tr>
    <tr class="listheader">
      <td></td>
      <td align=left>
        <input type=radio name=rt_reporttype value=peryear <?php echo ($_REQUEST['rt_reporttype']=='peryear' ? "checked" : "")?>>
        &nbsp;
        <?php echo L_G_MONTHLYINYEAR?>
      </td>
      <td align=left>
      </td>
      <td align=left>
      </td>
      <td align=left>
        <select name=rt_py_year>
          <option value="_" <?php echo ($_REQUEST['rt_py_year'] == '_') ? "selected" : ""?>><?php echo L_G_ALL?></option>
<?php      for($i=PAP_STARTING_YEAR; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rt_py_year'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>
      </td>
      <td align=left>
      </td>
    </tr>
    <tr class="listheader">
      <td align=left colspan=6>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='<?php echo $this->a_md?>'>
      <input type=hidden name=reporttype value='traffic'>
      <input class=formbutton type=submit value='<?php echo L_G_APPLYFILTER?>'>      
      </td>
  </tr>
</table>
</form>
