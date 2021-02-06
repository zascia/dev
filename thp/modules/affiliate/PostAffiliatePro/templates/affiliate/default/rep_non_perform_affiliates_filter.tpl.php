<?php function filter($topic,$name,$topic1,$topic2,$topic3) { ?>
    <td align=left>
        <table border="0" cellpadding="0" cellspacing="2">
        <tr>
            <td><b><?php echo $topic?></b><td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="<?php echo $name?>" id="<?php echo $name?>_any" value="any" onclick="javascript:toggleDisable('<?php echo $name?>_less_input',true)"<?php echo ($_REQUEST[$name] == 'any')? " checked" : ""?>>
                <label for="<?php echo $name?>_any"><?php echo $topic3?></label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="<?php echo $name?>" id="<?php echo $name?>_zero" value="0" onclick="javascript:toggleDisable('<?php echo $name?>_less_input',true)"<?php echo ($_REQUEST[$name] == '0')? " checked" : ""?>>
                <label for="<?php echo $name?>_zero"><?php echo $topic1?></label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="<?php echo $name?>" id="<?php echo $name?>_less" value="less" onclick="javascript:toggleDisable('<?php echo $name?>_less_input',false)"<?php echo ($_REQUEST[$name] == 'less')? " checked" : ""?>>
                <label for="<?php echo $name?>_less"><?php echo $topic2?></label>
                <input type="text" name="<?php echo $name?>_less" id="<?php echo $name?>_less_input" size="4" value="<?php echo $_REQUEST[$name.'_less']?>"<?php echo ($_REQUEST[$name] == 'less')? "" : " disabled"?>>
            </td>
        </tr>
        </table>  
    </td>      
<?php } ?>

<?php function dateInput(&$a_this, $day, $month, $year) {

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
    <table cellpadding="2" cellspacing="0" border="0">
    <tr>
        <td><select name="<?php echo $a_this->a_form_preffix.$day?>">
         <?php for($i=1; $i<=31; $i++) { ?>
                <option value="<?php echo $i?>" <?php echo ($_REQUEST[$a_this->a_form_preffix.$day] == $i) ? "selected" : ""?>><?php echo $i?></option>
         <?php } ?>
            </select>
        </td>
        <td><select name="<?php echo $a_this->a_form_preffix.$month?>">
         <?php for($i=1; $i<=12; $i++) { ?>
                <option value="<?php echo $i?>" <?php echo ($_REQUEST[$a_this->a_form_preffix.$month] == $i) ? "selected" : ""?>><?php echo $months[$i]?></option>
         <?php } ?>
            </select>
        </td>
        <td><select name="<?php echo $a_this->a_form_preffix.$year?>">
         <?php $curyear = date("Y");
            for($i=PAP_STARTING_YEAR; $i<=$curyear+1; $i++) { ?>
                <option value="<?php echo $i?>" <?php echo ($_REQUEST[$a_this->a_form_preffix.$year] == $i) ? "selected" : ""?>><?php echo $i?></option>
         <?php } ?>
            </select>
        </td>
        <td>&nbsp;<script type="text/javascript" language="JavaScript">
                <!--
                calendar('<?php echo $a_this->a_form_name?>', '<?php echo $a_this->a_form_preffix.$day?>', '<?php echo $a_this->a_form_preffix.$month?>', '<?php echo $a_this->a_form_preffix.$year?>',  '<?php echo $a_this->a_this->getImage('cal.gif')?>');
                //-->
            </script>
        </td>
    </tr>
    </table>
<?php } ?>

<?php
if (!defined('CALENDAR_JS_FUNCTIONS')) {
    define('CALENDAR_JS_FUNCTIONS', '1');
?>
<script language="JavaScript" src="<?php echo $GLOBALS['WEB_INCLUDE_PATH']?>/QUnit/calendar.js"></script>
<script>
function enableTimePreset(formName, formPreffix) {
    changeTimeControls(false, formName, formPreffix);
}

function disableTimePreset(formName, formPreffix) {
    changeTimeControls(true, formName, formPreffix);
}

function changeTimeControls(state, formName, formPreffix) {
    document.forms[formName].elements[formPreffix+'timepreset'].disabled = state;
    document.forms[formName].elements[formPreffix+'day1'].disabled   = !state;
    document.forms[formName].elements[formPreffix+'day2'].disabled   = !state;
    document.forms[formName].elements[formPreffix+'month1'].disabled = !state;
    document.forms[formName].elements[formPreffix+'month2'].disabled = !state;
    document.forms[formName].elements[formPreffix+'year1'].disabled  = !state;
    document.forms[formName].elements[formPreffix+'year2'].disabled  = !state;
}
</script>
<?php } ?>

<script type="text/javascript">
    function toggleDisable(element_id,state) {
        document.getElementById(element_id).disabled = state;
    }

    function toggleDateInput(state, day, month, year) {
        document.forms['<?php echo $this->a_form_name?>'].elements['<?php echo $this->a_form_preffix?>'+day].disabled   = !state;
        document.forms['<?php echo $this->a_form_name?>'].elements['<?php echo $this->a_form_preffix?>'+month].disabled = !state;
        document.forms['<?php echo $this->a_form_name?>'].elements['<?php echo $this->a_form_preffix?>'+year].disabled  = !state;
    }
</script>

<form name=<?php echo $this->a_form_name?> action=index.php method=get>
<table border=0 cellspacing=0 cellpadding=2 width="780">
    <tr>
        <td><?php echo L_G_NONPERFORMAFFILIATES_DESCRIPTION?><br><br></td>
    </tr>
</table>
<table class=listing cellspacing=0 cellpadding=2 width="780" style="border-bottom: 0px;">
<?php QUnit_Templates::printFilter(1, L_G_NONPERFORMAFFILIATES); ?>
<tr>
    <td valign=top align=left>
        <table border=0 cellpadding="2" cellspacing="2" width="100%">
        <tr>
            <td align="left" colspan="4">
                <table border="0" cellpadding="0" cellspacing="2">
                <tr>
                    <td colspan="2"><b><?php echo L_G_LASTLOGGEDBEFORE?></b></td>
                    <td width="25"></td>
                    <td colspan="2"><b><?php echo L_G_REGISTEREDBEFORE?></b></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="np_loginFilter" onclick="javascript:toggleDateInput(this.checked, 'day', 'month', 'year')"<?php echo ($_REQUEST['np_loginFilter'])? 'checked' : ''?>>
                    </td>
                    <td>
                        <?php dateInput($this, 'day', 'month', 'year');?>
                        <script type="text/javascript">toggleDateInput(<?php echo ($_REQUEST['np_loginFilter'])? 'true' : 'false'?>, 'day', 'month', 'year');</script>
                    </td>
                    <td width="25"></td>
                    <td>
                        <input type="checkbox" name="np_registerFilter" onclick="javascript:toggleDateInput(this.checked, 'regday', 'regmonth', 'regyear')"<?php echo ($_REQUEST['np_registerFilter'])? 'checked' : ''?>>
                    </td>
                    <td>
                        <?php dateInput($this, 'regday', 'regmonth', 'regyear');?>
                        <script type="text/javascript">toggleDateInput(<?php echo ($_REQUEST['np_registerFilter'])? 'true' : 'false'?>, 'regday', 'regmonth', 'regyear');</script>
                    </td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" colspan="4">
                <?php QUnit_Global::includeTemplate('filter_time.tpl.php'); ?>
            </td>
        </tr>
        <tr>
        <?php filter(L_G_IMPRESSIONS,'np_impressions',L_G_NONE2,L_G_LESSEQTHAN,L_G_ANY)?>
        <?php filter(L_G_CLICKS,'np_clicks',L_G_NONE2,L_G_LESSEQTHAN,L_G_ANY)?>
        <?php filter(L_G_SALES,'np_sales',L_G_NONE2,L_G_LESSEQTHAN,L_G_ANY)?>
        <?php filter(L_G_LEADS,'np_leads',L_G_NONE2,L_G_LESSEQTHAN,L_G_ANY)?>
        </tr>
        <tr>
            <td colspan="4">
                <b><?php echo L_G_SORTBY?></b>
                <br>
                <select name="np_sortby">
                    <option value="affiliate"<?php echo ($_REQUEST['np_sortby'] == 'affiliate')? 'selected' : ''?>><?php echo L_G_AFFILIATE?></option>
                    <option value="impressions"<?php echo ($_REQUEST['np_sortby'] == 'impressions')? 'selected' : ''?>><?php echo L_G_IMPRESSIONS?></option>
                    <option value="clicks"<?php echo ($_REQUEST['np_sortby'] == 'clicks')? 'selected' : ''?>><?php echo L_G_CLICKS?></option>
                    <option value="sales"<?php echo ($_REQUEST['np_sortby'] == 'sales')? 'selected' : ''?>><?php echo L_G_SALES?></option>
                    <option value="leads"<?php echo ($_REQUEST['np_sortby'] == 'leads')? 'selected' : ''?>><?php echo L_G_LEADS?></option>
                    <option value="timelastlogin"<?php echo ($_REQUEST['np_sortby'] == 'timelastlogin')? 'selected' : ''?>><?php echo L_G_LASTLOGINDATE?></option>
                    <option value="logincount"<?php echo ($_REQUEST['np_sortby'] == 'logincount')? 'selected' : ''?>><?php echo L_G_LOGINCOUNT?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td align=left colspan="4">
              <input type="hidden" name="np_campaignid" value="<?php echo DEFAULT_CAMPAIGN?>">
              <input type=hidden name=commited value=yes>
              <input type=hidden name=md value='<?php echo Affiliate_Merchants_Views_NonPerformAffiliates?>'>
              <input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>
              <input class=formbutton type=submit value='<?php echo L_G_APPLYFILTER?>'>
            </td>
        </tr>
        </table>
    </td>
</tr>
</table>
