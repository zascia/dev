<?php
    function printFieldType($i, $columns) { ?>
        <select name="field<?php echo $i?>_type">
            <option value="___">________________</option>
        <?php  foreach ($columns as $key => $value) { ?>
            <option value="<?php echo $key?>" <?php echo ($_POST['field'.$i.'_type'] == $key) ? 'selected' : ''?>><?php echo $value['description']?></option>
        <?php  } ?>
        </select>
<?php  } ?>
<script>
    function enableFileRadio(p) {
        document.getElementById('file_fromexport').disabled = p;
        document.getElementById('file_fromupload').disabled = !p;
    }
</script>
<form name=FilterForm id=FilterForm action=index.php method=post enctype="multipart/form-data">
<input type=hidden name=md value='<?php echo $this->a_md?>'>
<input type=hidden name=commited value='yes'>
<table cellpadding="0" cellspacing="0" border="0" width="780">
<tr><td><h5><?php echo $this->a_title?></h5><?php echo $this->a_description?><br><br></td></tr>
</table>
<table class="listing" cellpadding="2" cellspacing="0" width="780">
<?php QUnit_Templates::printFilter(2, $this->a_title); ?>
<tr><td width="50%" align="left" valign="top">
        <table class="listing" cellpadding="2" cellspacing="0" width="100%">
        <?php QUnit_Templates::printFilter(2, L_G_FILE_FIELDS); ?>
<?php      for ($i = 0; $i < count($this->a_columns); $i++) { ?>
            <tr class="listrow<?php echo $i%2?>"><td><b><?php echo L_G_FIELD.' '.($i+1)?></b></td>
                <td><?php printFieldType($i, $this->a_columns); ?></td></tr>
<?php      
        } ?>
        </table>
    </td>
    <td width="50%" align="left" valign="top">
        <table class="listing" cellpadding="2" cellspacing="0" width="100%">
        <?php QUnit_Templates::printFilter(2, L_G_IMPORTFILE); ?>
        <tr><td class="listheaderNoLineLeft" valign=top width="10%" nowrap>
                &nbsp;<b><?php echo L_G_SEPARATOR?></b>&nbsp;<?php showQuickHelp(L_G_HLP_SEPARATOR); ?></td>
            <td class="listheaderNoLineLeft" valign=top>
                <select name="separator" onchange="document.getElementById('separator_other').disabled = (this.value != 'other');">
                    <option value=","     <?php echo $_POST['separator'] == ',' ? 'selected' : ''?>>,</option>
                    <option value=";"     <?php echo $_POST['separator'] == ';' ? 'selected' : ''?>>;</option>
                    <option value="tab"   <?php echo $_POST['separator'] == 'tab' ? 'selected' : ''?>>TAB</option>
                    <option value="other" <?php echo $_POST['separator'] == 'other' ? 'selected' : ''?>><?php echo L_G_OTHER?></option>
                </select>
                &nbsp;&nbsp;
                <input type="text" id="separator_other" name="separator_other" size="3" maxlength="20"
                    value="<?php echo $_POST['separator_other']?>" <?php echo ($_POST['separator'] == 'other') ? '' : 'disabled'?>>
            </td></tr>
        <tr><td class="listheaderNoLineLeft" valign=top nowrap>&nbsp;<b><?php echo L_G_IMPORTFILE?></b>&nbsp;</td>
            <td class="listheaderNoLineLeft" valign=top>
                <input type="radio" name="file_radio" value="1" <?php echo ($_POST['file_radio'] == '1') ? 'checked' : ''?>
                    onclick="enableFileRadio(true);">&nbsp;<?php echo L_G_UPLOADFILE?>
                    <?php showQuickHelp(L_G_HLP_UPLOADFILE); ?><br>
                <input type="file" name="file_fromupload" size="35" <?php echo ($_POST['file_radio'] == '2') ? 'disabled' : ''?>>
            </td></tr>
        <tr><td class="listheaderNoLineLeft" valign=top nowrap></td>
            <td class="listheaderNoLineLeft" valign=top>
                <input type="radio" name="file_radio" value="2" <?php echo ($_POST['file_radio'] == '2') ? 'checked' : ''?>
                    onclick="enableFileRadio(false);">&nbsp;<?php echo L_G_FILEFROMEXPORTSDIR?>
                    <?php showQuickHelp(L_G_HLP_FILEFROMEXPORTSDIR); ?><br>
                <input type="text" name="file_fromexport" value="<?php echo $_POST['file_fromexport']?>"
                    size="45" <?php echo ($_POST['file_radio'] == '1') ? 'disabled' : ''?>>
            </td></tr>
        <tr><td class="listheaderNoLineLeft" valign=top nowrap>
                &nbsp;<b><?php echo L_G_SKIPFIRSTROW?></b>&nbsp;<?php showQuickHelp(L_G_HLP_SKIPFIRSTROW); ?></td>
            <td class="listheaderNoLineLeft" valign=top>
                <input type="checkbox" name="skipfirstrow" value="1" <?php echo ($_POST['skipfirstrow'] == '1') ? 'checked' : ''?>>
            </td></tr>
        <?php if($this->a_showTranstype == '1') { ?>
        <tr><td class="listheaderNoLineLeft" valign=top nowrap>
            &nbsp;<b><?php echo L_G_TRANSTYPE?></b>&nbsp;<?php showQuickHelp(L_G_HLP_IMPORT_TRANSTYPE); ?></td>
            <td class="listheaderNoLineLeft" valign=top>
                <?php $this->a_Auth->getCommissionTypeSelect('transtype', $_REQUEST['transtype'], false, false, false, true, false); ?>
            </td></tr>
        <?php } ?>
        <tr class="listheaderNoLineLeft"><td colspan="2" align="center"><input type="submit" value="<?php echo L_G_IMPORT?>"></td></tr>
        </table>
        <?php if ($this->a_additionalSettingsTemplate != '') QUnit_Global::includeTemplate($this->a_additionalSettingsTemplate); ?>
    </td></tr>
</table>
</form>