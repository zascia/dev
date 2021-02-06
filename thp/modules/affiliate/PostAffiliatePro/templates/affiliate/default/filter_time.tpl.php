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
<?php
}
?>
<?php
if (!defined('TIMEFILTER_JS_FUNCTIONS')) {
    define('TIMEFILTER_JS_FUNCTIONS', '1');
?>
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
    document.forms[formName].elements[formPreffix+'day2'].disabled   = !state;
    document.forms[formName].elements[formPreffix+'month1'].disabled = !state;
    document.forms[formName].elements[formPreffix+'month2'].disabled = !state;
    document.forms[formName].elements[formPreffix+'year1'].disabled  = !state;
    document.forms[formName].elements[formPreffix+'year2'].disabled  = !state;
}
</script>
<?php
}
?>

<script language="JavaScript">
    var months = new Array('<?php echo L_G_JAN?>', '<?php echo L_G_FEB?>', '<?php echo L_G_MAR?>', '<?php echo L_G_APR?>', '<?php echo L_G_MAY?>', '<?php echo L_G_JUN?>',
                           '<?php echo L_G_JUL?>', '<?php echo L_G_AUG?>', '<?php echo L_G_SEP?>', '<?php echo L_G_OCT?>', '<?php echo L_G_NOV?>', '<?php echo L_G_DEC?>');
    var days   = new Array('<?php echo L_G_SUN?>', '<?php echo L_G_MON?>', '<?php echo L_G_TUE?>', '<?php echo L_G_WED?>',
                           '<?php echo L_G_THU?>', '<?php echo L_G_FRI?>', '<?php echo L_G_SAT?>');
</script>
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
            <option value="<?php echo TIME_TODAY?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_TODAY) ? 'selected' : ''?>>
                <?php echo L_G_TIME_TODAY?></option>
            <option value="<?php echo TIME_YESTERDAY?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_YESTERDAY) ? 'selected' : ''?>>
                <?php echo L_G_TIME_YESTERDAY?></option>
            <option value="<?php echo TIME_LAST7DAYS?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_LAST7DAYS) ? 'selected' : ''?>>
                <?php echo L_G_TIME_LAST7DAYS?></option>
            <option value="<?php echo TIME_THISWEEK?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_THISWEEK) ? 'selected' : ''?>>
                <?php echo L_G_TIME_THISWEEK?></option>
            <option value="<?php echo TIME_LASTWEEK?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_LASTWEEK) ? 'selected' : ''?>>
                <?php echo L_G_TIME_LASTWEEK?></option>
            <option value="<?php echo TIME_LASTWORKWEEK?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_LASTWORKWEEK) ? 'selected' : ''?>>
                <?php echo L_G_TIME_LASTWORKWEEK?></option>
            <option value="<?php echo TIME_THISMONTH?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_THISMONTH) ? 'selected' : ''?>>
                <?php echo L_G_TIME_THISMONTH?></option>
            <option value="<?php echo TIME_LASTMONTH?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_LASTMONTH) ? 'selected' : ''?>>
                <?php echo L_G_TIME_LASTMONTH?></option>
            <option value="<?php echo TIME_THISYEAR?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_THISYEAR) ? 'selected' : ''?>>
                <?php echo L_G_TIME_THISYEAR?></option>
            <option value="<?php echo TIME_ALL?>"
                <?php echo ($_REQUEST[$this->a_form_preffix.'timepreset'] == TIME_ALL) ? 'selected' : ''?>>
                <?php echo L_G_TIME_ALL?></option>
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
                for($i=2003; $i<=$curyear+1; $i++) { ?>
                    <option value="<?php echo $i?>" <?php echo ($_REQUEST[$this->a_form_preffix.'year1'] == $i) ? "selected" : ""?>><?php echo $i?></option>
             <?php } ?>
                </select>
            </td>
            <td>&nbsp;<script type="text/javascript" language="JavaScript">
                    <!--
                    calendar('<?php echo $this->a_form_name?>', '<?php echo $this->a_form_preffix?>day1', '<?php echo $this->a_form_preffix?>month1', '<?php echo $this->a_form_preffix?>year1',  '<?php echo $this->a_this->getImage('cal.gif')?>');
                    //-->
                </script></td>
            <td>&nbsp;-&nbsp;</td>
            <td><select name="<?php echo $this->a_form_preffix?>day2" <?php echo ($_REQUEST[$this->a_form_preffix.'timeselect'] == TIME_CUSTOM) ? '' : 'disabled'?>>
             <?php for($i=1; $i<=31; $i++) { ?>
                    <option value="<?php echo $i?>" <?php echo ($_REQUEST[$this->a_form_preffix.'day2'] == $i) ? "selected" : ""?>><?php echo $i?></option>
             <?php } ?>
                </select>
            </td>
            <td><select name="<?php echo $this->a_form_preffix?>month2" <?php echo ($_REQUEST[$this->a_form_preffix.'timeselect'] == TIME_CUSTOM) ? '' : 'disabled'?>>
             <?php for($i=1; $i<=12; $i++) { ?>
                    <option value="<?php echo $i?>" <?php echo ($_REQUEST[$this->a_form_preffix.'month2'] == $i) ? "selected" : ""?>><?php echo $months[$i]?></option>
             <?php } ?>
                </select>
            </td>
            <td><select name="<?php echo $this->a_form_preffix?>year2" <?php echo ($_REQUEST[$this->a_form_preffix.'timeselect'] == TIME_CUSTOM) ? '' : 'disabled'?>>
             <?php $curyear = date("Y");
                for($i=2003; $i<=$curyear+1; $i++) { ?>
                    <option value="<?php echo $i?>" <?php echo ($_REQUEST[$this->a_form_preffix.'year2'] == $i) ? "selected" : ""?>><?php echo $i?></option>
             <?php } ?>
                </select>
            </td>
            <td>&nbsp;<script type="text/javascript" language="JavaScript">
                    <!--
                    calendar('<?php echo $this->a_form_name?>', '<?php echo $this->a_form_preffix?>day2', '<?php echo $this->a_form_preffix?>month2', '<?php echo $this->a_form_preffix?>year2',  '<?php echo $this->a_this->getImage('cal.gif')?>');
                    //-->
                </script>
            </td></tr>
        </table>
        </td>
    </tr>
</table>
