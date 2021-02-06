<?php if (!defined('CALENDAR_JS_FUNCTIONS')) {
    define('CALENDAR_JS_FUNCTIONS', '1'); ?>
<script language="JavaScript" src="<?php echo $GLOBALS['WEB_INCLUDE_PATH']?>/QUnit/calendar.js"></script>
<?php } ?>
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
<table cellpadding="4" cellspacing="0" border="0" width="100%">
<tr class="listrow1">
    <td align="left" valign="top" width="20%"><b><?php echo L_G_NEWS_STATUS?></b><?php showQuickHelp(L_G_HLP_NEWS_STATUS); ?></td>
    <td align="left">
        <input type="radio" name="br_news_status" value="1" <?php echo ($_POST['br_news_status'] == '1' ? 'checked' : '')?>><?php echo L_G_ACTIVE?><br>
        <input type="radio" name="br_news_status" value="0" <?php echo ($_POST['br_news_status'] == '0' ? 'checked' : '')?>><?php echo L_G_INACTIVE?><br>
    </td></tr>
<tr class="listrow0">
    <td align="left" valign="top" width="20%"><b><?php echo L_G_NEWS_VALID?></b><?php showQuickHelp(L_G_HLP_NEWS_VALID); ?></td>
    <td align="left">
        <table cellpadding="0" cellspacing="0" border="0">
           <tr><td>&nbsp;<?php echo L_G_FROM?>&nbsp;&nbsp;&nbsp;</td>
               <td>
        	   <select name=br_day1>
			   <?php for($i=1; $i<=31; $i++) { ?>
          		  	<option value='<?php echo $i?>' <?php echo ($i == $_POST['br_day1'] ? "selected" : "")?>><?php echo $i?></option>
			   <?php } ?>
        	   </select>
        	   </td>
        	   <td>
        	   <select name=br_month1>
			   <?php for($i=1; $i<=12; $i++) { ?>
          	     		<option value='<?php echo $i?>' <?php echo ($i == $_POST['br_month1'] ? "selected" : "")?>><?php echo $months[$i]?></option>
			     <?php } ?>
        	   </select>
        	   </td>
        	   <td>
        	   <select name=br_year1>
			     <?php for($i=PAP_STARTING_YEAR, $t = getdate(); $i<=$t['year']+2; $i++) { ?>
          		    	<option value='<?php echo $i?>' <?php echo ($i == $_POST['br_year1'] ? "selected" : "")?>><?php echo $i?></option>
			     <?php } ?>
        	   </select>
        	   </td>
        	   <td>
        	   &nbsp;
        	   <script type="text/javascript" language="JavaScript">
                 <!--
                    calendar('FilterForm', 'br_day1', 'br_month1', 'br_year1', '<?php echo $this->a_this->getImage('cal.gif')?>');
                    //-->
                </script>
               </td>
               <td>&nbsp;&nbsp;&nbsp;<b><?php echo L_G_TO?>&nbsp;&nbsp;&nbsp;</b></td>
               <td>
        	   <select name=br_day2>
			   <?php for($i=1; $i<=31; $i++) { ?>
          		  	<option value='<?php echo $i?>' <?php echo ($i == $_POST['br_day2'] ? "selected" : "")?>><?php echo $i?></option>
			   <?php } ?>
        	   </select>
        	   </td>
        	   <td>
        	   <select name=br_month2>
			   <?php for($i=1; $i<=12; $i++) { ?>
          	     		<option value='<?php echo $i?>' <?php echo ($i == $_POST['br_month2'] ? "selected" : "")?>><?php echo $months[$i]?></option>
			     <?php } ?>
        	   </select>
        	   </td>
        	   <td>
        	   <select name=br_year2>
			     <?php for($i=PAP_STARTING_YEAR, $t = getdate(); $i<=$t['year']+2; $i++) { ?>
          		    	<option value='<?php echo $i?>' <?php echo ($i == $_POST['br_year2'] ? "selected" : "")?>><?php echo $i?></option>
			     <?php } ?>
        	   </select>
        	   </td>
        	   <td>
        	   &nbsp;
        	   <script type="text/javascript" language="JavaScript">
                 <!--
                    calendar('FilterForm', 'br_day2', 'br_month2', 'br_year2', '<?php echo $this->a_this->getImage('cal.gif')?>');
                    //-->
                </script>
               </td></tr>
        </table>
    </td></tr>
<tr class="listrow1">
    <td align="left" valign="top" width="20%"><b><?php echo L_G_NEWS_SHOWTO?></b><?php showQuickHelp(L_G_HLP_NEWS_SHOWTO); ?></td>
    <td align="left">
        <input type="radio" id="br_show_all" name="br_news_show" value="1" <?php echo ($_POST['br_news_show'] == '1' ? 'checked' : '')?>><?php echo L_G_ALL?><br>
        <input type="radio" name="br_news_show" value="0" <?php echo ($_POST['br_news_show'] == '0' ? 'checked' : '')?>><?php echo L_G_SELECTED?><br>
    </td></tr>
<?php if($_POST['action'] == 'edit') { ?>
<tr class="listrow1">
    <td align="left" width="20%" colspan="2">
        <input type="checkbox" name="show_again" value="1" <?php echo ($_POST['show_again'] == '1') ? 'checked' : ''?>>
        <?php echo L_G_SHOWAGAINTOAUSERSWHOREADTHISMESSAGE?>
    </td></tr>
<?php } ?>
<tr class="listrow0" colspan="2"><td align=left nowrap>&nbsp;<b><?php echo L_G_INSERTVALUETOTEXT?></b>&nbsp;<?php showQuickHelp(L_G_HLP_INSERTVALUETOTEXT); ?></td></tr>
    <tr class="listrow0">
      <td width="100">&nbsp;</td>
      <td align=left nowrap>
        <select name="brn_insert_text" id="brn_insert_text">
        <?php  $const = explode("<br>",  L_G_HLP_AFF_EMAIL_GLOBAL_CONSTANTS);
          	foreach ($const as $cst) { ?>
          	 <option value="<?php echo $cst?>"><?php echo @constant("L_G_CONST_".strtoupper(substr($cst, 1)))?> (<?php echo $cst?>)</option>
        <?php	} ?>
        </select>
        <input type="button" onclick="javascript: insertValue(this.form.emailtext, this.form.brn_insert_text);" value="<?php echo L_G_INSERT?>">
      </td>
    </tr>
</table>
