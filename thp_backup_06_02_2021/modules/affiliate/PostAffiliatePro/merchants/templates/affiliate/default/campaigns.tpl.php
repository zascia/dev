<?php echo L_G_CAMPAIGN_DESCRIPTION?><br><br>
<script>
function changeSheet(action, sheet)
{
    document.myForm.sheet.value = sheet;
    document.myForm.submit();
}
</script>

<form action="index.php" name="myForm" method="post">
    <table class="listing" border="0" cellspacing="0" cellpadding="0" width="780">
    <?php QUnit_Templates::printFilter(2, L_G_CAMPAIGNEDIT); ?>
        <tr>
            <td align=left>

                <table border=0 cellspacing=0 cellpadding=5>
                    <tr class="detailrow<?php echo ($_rc = 1 - $_rc)?>">
                        <td align=left nowrap>
                            <b><?php echo L_G_PCNAME;?></b>
                        </td>
                        <td align=left width="50%">
                            <input class="forminput" type=text name=cname size=44 value="<?php echo $_POST['cname']?>">*
                        </td>
                    </tr>
                    <tr class="detailrow<?php echo ($_rc = 1 - $_rc)?>">
                        <td align=left nowrap>
                            <?php echo L_G_COMPLETE_URL_BANNERS_IMAGE;?>
                        </td>
                        <td align=left>
                            <input class="forminput" type=text name=banner_url size=44 value="<?php echo $_POST['banner_url']?>">
                        </td>
                    </tr>

                <?php if($_POST['action'] != 'add' && $this->a_Auth->getProgramType() == PROG_TYPE_NETWORK) { ?>
                    <tr class="detailrow<?php echo ($_rc = 1 - $_rc)?>">
                        <td class=formBText valign=top nowrap><?php echo L_G_PUT_CAMPAIGN_INTO_CATEGORY;?>&nbsp;</td>
                        <td valign=top>

                        <?php if ((int)$this->a_numrows > 0) { ?>
                            <select class="forminput" name=network_categories[] multiple>
                            <?php while ($data=$this->a_list_data->getNextRecord()) { ?>
                                <option value='<?php echo $data['catid']?>' <?php echo (in_array($data['catid'], $this->a_network_categories_selected) ? ' selected' : '')?>><?php echo $data['tab'].$data['name']?></option>
                            <?php } ?>
                            </select>&nbsp;
                        <?php
                            } else {
                                print L_G_NO_AVAILABLE_CATEGORY;
                        ?>
                        <input type=hidden name=network_categories value='-1'>
                        <?php
                            }
                        ?>
                        </td>
                    </tr>
                <?php } ?>

                    <tr class="detailrow<?php echo ($_rc = 1 - $_rc)?>">
                        <td align=left valign=top><?php echo L_G_CAMPAIGNSHORTDESCRIPTION?>&nbsp;&nbsp;</td>
                        <td><input class="forminput" type=text name=shortdescription size=44 value='<?php echo $_POST['shortdescription']?>'></td>
                    </tr>
                    <tr class="detailrow<?php echo ($_rc = 1 - $_rc)?>">
                        <td align=left valign=top><?php echo L_G_CAMPAIGNDESCRIPTION?>&nbsp;&nbsp;</td>
                        <td><textarea class="forminput" name=description cols=70 rows=4><?php echo $_POST['description']?></textarea></td>
                    </tr>

                </table>
                <br>
            </td>
        </tr>
        <tr>
            <td align="left">
            <?php
                // include tabs
                //QUnit_Templates::drawTabs($this->a_tabs, $this->a_selectedTab, 1);
                QUnit_Templates::drawDivTabs($this->a_tabs, "campaign_tab_", 4, 780, true, false);
            ?>
            <br>
            </td>
        </tr>
        <tr>
            <td align=left>
        <?php
            if($_POST['action'] != 'add') {
                echo $this->a_tabcontent;
            }
        ?>

                <table border=0 cellspacing=0 cellpadding=5>
                    <tr>
                        <td>
                            <input type="hidden" name=commited value=yes>
                            <input type="hidden" name=md value='Affiliate_Merchants_Views_CampaignManager'>
                            <input type="hidden" name=action id=action value=<?php echo $_POST['action']?>>
                            <input type="hidden" name=subact value=<?php echo $_POST['subact']?>>
                            <input type="hidden" name=cid value=<?php echo $_POST['cid']?>>
                            <input type="hidden" name=postaction value=<?php echo $_POST['postaction']?>>
                            <input type="hidden" name=sheet id=sheet value='<?php echo $_REQUEST['sheet']?>'>
                            <input type="hidden" name=subact value='<?php echo $_REQUEST['sheet']?>'>
                            <?php if($_REQUEST['sheet'] != 'performance_rules') { ?>
                                <input class="formbutton" type="submit" value="<?php echo L_G_SUBMIT; ?>">

                                <?php if (!empty($_POST['cid'])) { ?>
                                    <input class="formbutton" type="submit" name="gotobanners" value="<?php echo L_G_GOTOBANNERS; ?>">
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>