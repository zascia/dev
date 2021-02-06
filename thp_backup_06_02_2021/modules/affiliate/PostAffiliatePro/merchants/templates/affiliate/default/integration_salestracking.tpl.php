
    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter(2, L_G_SALESTRACKING); ?>
    <tr class="detailrow0"><td colspan="2"><?php echo L_G_SALESTRACKING_DESCRIPTION?></td></tr>
    <tr class="detailrow1"><td width="10%"><b><?php echo L_G_INTEGRATIONMETHOD?></b></td>
        <td align="left">
            <table>
            <tr>
                <td>
                <select name="integration_method" onchange="javascript: document.forms['myForm'].submit();">
                <?php $selectedIntegration = '';
                while($data=$this->a_list_intmethods->getNextRecord()) {
                    if ($_POST['integration_method'] == $data['integrationid'])
                        $selectedIntegration = $data; ?>
                        <option value="<?php echo $data['integrationid']?>" <?php echo ($_POST['integration_method'] == $data['integrationid']) ? 'selected' : ''?>>
                            <?php echo defined($data['integrationlangconst']) ? constant($data['integrationlangconst']) : $data['integrationname']?></option>
                <?php } ?>
                </select>
                </td>
                </td>
                <td><input type="checkbox" name="integration_secure" value="1" <?php echo  $_POST['integration_secure'] == '1' ? 'checked' : '' ?> onchange="javascript: document.forms['myForm'].submit();"><strong><?php echo  L_G_SECURE_CONNECTION?></strong></td>
            </tr>
            </table>
        </td>
    </tr>
    <tr class="detailrow1"><td colspan="2"><hr class="filterLine" width="100%"></td></tr>
<?php if ($selectedIntegration != '') {
    $_rc = 1;
?>
    <tr class="detailrow<?php echo ($_rc = 1 - $_rc)?>"><td colspan="2"><h3><?php echo defined($selectedIntegration['integrationlangconst']) ? constant($selectedIntegration['integrationlangconst']) : $selectedIntegration['integrationname']?></h3></td></tr>
    <tr class="detailrow<?php echo ($_rc = 1 - $_rc)?>"><td colspan="2"><?php echo $this->a_translator->translate($selectedIntegration['textbefore'])?></td></tr>
    <?php $i = 1;
       while($data=$this->a_list_intsteps->getNextRecord()) { ?>
        <tr class="detailrow<?php echo ($_rc = 1 - $_rc)?>"><td valign="top"><b><?php echo $i?>.</b></td>
            <td valign="top">
                <?php echo $this->a_translator->translate($data['textbefore'])?><?php echo ($data['textbefore'] != '') ? '<br><br>' : ''?>
                <?php if ($data['textarea'] != '') { ?>
                    <textarea cols="114" rows="7" readonly><?php echo $this->a_translator->translate($data['textarea'])?></textarea><br>
                <?php } ?>
                <?php echo ($data['textafter'] != '') ? '<br>' : ''?>
                <?php echo $this->a_translator->translate($data['textafter'])?>
            </td></tr>
    <?php  $i++;
       } ?>
    <tr class="detailrow<?php echo ($_rc = 1 - $_rc)?>"><td colspan="2"><?php echo $this->a_translator->translate($selectedIntegration['textafter'])?></td></tr>
<?php } ?>
    </table>
