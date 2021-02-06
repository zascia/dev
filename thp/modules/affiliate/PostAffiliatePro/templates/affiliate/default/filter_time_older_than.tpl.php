<?php
// set default timeselect if nothing is selected
if (($_REQUEST[$this->a_form_preffix.'timeselect'] != TIME_PRESET) && ($_REQUEST[$this->a_form_preffix.'timeselect'] != TIME_CUSTOM)) {
    ($_REQUEST[$this->a_form_preffix.'timeselect'] = TIME_PRESET);
}
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
<script>
function enableTimeFilter(formName, formPreffix) {
    radioarray = document.forms[formName].elements[formPreffix+'timeselect'];
    timepreset = true;
    for (i = 0; i < radioarray.length; i++) {
        radioarray[i].disabled = false;
        if (radioarray[i].checked) {
            timepreset = (radioarray[i].value == '<?php echo TIME_PRESET?>');
        }
    }
    if (timepreset)
        enableTimePreset(formName, formPreffix);
    else
        disableTimePreset(formName, formPreffix);
}

function disableTimeFilter(formName, formPreffix) {
    radioarray = document.forms[formName].elements[formPreffix+'timeselect'];
    for (i = 0; i < radioarray.length; i++) {
        radioarray[i].disabled = true;
    }
    enableTimePreset(formName, formPreffix);
    document.forms[formName].elements[formPreffix+'timepreset'].disabled = true;
}

function enableTimePreset(formName, formPreffix) {
    changeTimeControls(false, formName, formPreffix);
}

function disableTimePreset(formName, formPreffix) {
    changeTimeControls(true, formName, formPreffix);
}

function changeTimeControls(state, formName, formPreffix) {
    document.forms[formName].elements[formPreffix+'timepreset'].disabled = state;
    document.forms[formName].elements[formPreffix+'day1'].disabled   = !state;
    document.forms[formName].elements[formPreffix+'month1'].disabled = !state;
    document.forms[formName].elements[formPreffix+'year1'].disabled  = !state;
}
</script>
<?php
}
?>
<table cellpadding="2" cellspacing="0" border="0">
<tr><td valign=top rowspan="2" nowrap <?php echo ($this->a_timeselect_caption_width != '') ? 'width="'.$this->a_timeselect_caption_width.'"' : ''?>>
        &nbsp;<?php echo ($this->a_timeselect_caption == '') ? '<b>'.L_G_TIMEPERIOD.'</b>' : $this->a_timeselect_caption?>
        &nbsp;<?php showQuickHelp(L_G_TIMEPRESETHELP); ?>&nbsp;&nbsp;</td>
    <td valign="top" nowrap>
        <input type="radio" name="<?php echo $this->a_form_preffix?>timeselect" value="<?php echo TIME_PRESET?>"
            <?php echo ($_REQUEST[$this->a_form_preffix.'timeselect'] == TIME_PRESET) ? 'checked' : ''?>
            onclick="enableTimePreset('<?php echo $this->a_form_name?>', '<?php echo $this->a_form_preffix?>');"></td>
    <td valign="top" nowrap>
        <select name="<?php echo $this->a_form_preffix?>timepreset" <?php echo ($_REQUEST[$this->a_form_preffix.'timeselect'] == TIME_PRESET) ? '' : 'disabled'?>>
            <option value="<?php echo TIME_OLDER_THAN_WEEK?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_OLDER_THAN_WEEK) ? 'selected' : ''?>>
                <?php echo L_G_TIME_OLDER_THAN_WEEK?></option>
            <option value="<?php echo TIME_OLDER_THAN_MONTH?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_OLDER_THAN_MONTH) ? 'selected' : ''?>>
                <?php echo L_G_TIME_OLDER_THAN_MONTH?></option>
            <option value="<?php echo TIME_OLDER_THAN_TWOMONTH?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_OLDER_THAN_TWOMONTH) ? 'selected' : ''?>>
                <?php echo L_G_TIME_OLDER_THAN_TWOMONTH?></option>
            <option value="<?php echo TIME_OLDER_THAN_THREEMONTH?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_OLDER_THAN_THREEMONTH) ? 'selected' : ''?>>
                <?php echo L_G_TIME_OLDER_THAN_THREEMONTH?></option>
        </select>
        </td>
    <?php echo ($this->a_timeselect_tworows == '1') ? '</tr><tr>' : ''?>
    <td valign="top" nowrap>
        <input type="radio" name="<?php echo $this->a_form_preffix?>timeselect" value="<?php echo TIME_CUSTOM?>"
            <?php echo ($_REQUEST[$this->a_form_preffix.'timeselect'] == TIME_CUSTOM) ? 'checked' : ''?>
            onclick="disableTimePreset('<?php echo $this->a_form_name?>', '<?php echo $this->a_form_preffix?>');"></td>
    <td valign="top" nowrap>
        <table cellpadding="0" cellspacing="0" border="0">
        <tr><td><select name="<?php echo $this->a_form_preffix?>day1" <?php echo ($_REQUEST[$this->a_form_preffix.'timeselect'] == TIME_CUSTOM) ? '' : 'disabled'?>>
             <?php for($i=1; $i<=31; $i++) { ?>
                    <option value="<?php echo $i?>" <?php echo ($_REQUEST[$this->a_form_preffix.'day1'] == $i) ? "selected" : ""?>><?php echo $i?></option>
             <?php } ?>
                </select>
            </td>
            <td><select name="<?php echo $this->a_form_preffix?>month1" <?php echo ($_REQUEST[$this->a_form_preffix.'timeselect'] == TIME_CUSTOM) ? '' : 'disabled'?>>
             <?php for($i=1; $i<=12; $i++) { ?>
                    <option value="<?php echo $i?>" <?php echo ($_REQUEST[$this->a_form_preffix.'month1'] == $i) ? "selected" : ""?>><?php echo $months[$i]?></option>
             <?php } ?>
                </select>
            </td>
            <td><select name="<?php echo $this->a_form_preffix?>year1" <?php echo ($_REQUEST[$this->a_form_preffix.'timeselect'] == TIME_CUSTOM) ? '' : 'disabled'?>>
             <?php $curyear = date("Y");
                for($i=PAP_STARTING_YEAR; $i<=$curyear+1; $i++) { ?>
                    <option value="<?php echo $i?>" <?php echo ($_REQUEST[$this->a_form_preffix.'year1'] == $i) ? "selected" : ""?>><?php echo $i?></option>
             <?php } ?>
                </select>
            </td>
            <td>&nbsp;<script type="text/javascript" language="JavaScript">
                    <!--
                    calendar('<?php echo $this->a_form_name?>', '<?php echo $this->a_form_preffix?>day1', '<?php echo $this->a_form_preffix?>month1', '<?php echo $this->a_form_preffix?>year1',  '<?php echo $this->a_this->getImage('cal.gif')?>');
                    //-->
                </script></td>
        </tr>
        </table>
        </td>
    </tr>
</table>