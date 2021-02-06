<table width="100%" border="0" cellpadding="4" cellspacing="0">
    <tr><td class="listrow1" colspan="2"><b><?php echo L_G_CHOOSEPERIODTOCOMPUTETRAFFIC?></b></td></tr>
    <tr><td class="listrow1" colspan="2">
        <?php if (isset($_POST['emailcategory']) && (in_array($_POST['emailcategory'], array(AFF_EMAIL_AF_DL_REP, AFF_EMAIL_AF_ML_REP)))) { ?>
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
            <table>
              <tr>
                <td align="left" nowrap valign="top">
                    <table cellpadding="0" cellspacing="0" border="0">
                    <tr><td width="110"><b><?php echo L_G_DATEFORDAILYREPORT?>&nbsp;&nbsp;&nbsp;</b></td>
                        <td>
                        <?php if ( ($_POST['emailcategory'] == 'AFF_EMAIL_AF_DL_REP') ) { ?>
                            <select name=rq_day>
                            <?php for($i=1; $i<=31; $i++) { ?>
                                <option value='<?php echo $i?>' <?php echo ($i == $_POST['rq_day'] ? "selected" : "")?>><?php echo $i?></option>
                            <?php } ?>
                            </select>
                        <?php } ?>
                        </td>
                        <td>
                            <select name=rq_month>
                            <?php for($i=1; $i<=12; $i++) { ?>
                                <option value='<?php echo $i?>' <?php echo ($i == $_POST['rq_month'] ? "selected" : "")?>><?php echo $months[$i]?></option>
                            <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name=rq_year>
                            <?php for($i=PAP_STARTING_YEAR, $t = getdate(); $i<=$t['year']; $i++) { ?>
                                <option value='<?php echo $i?>' <?php echo ($i == $_POST['rq_year'] ? "selected" : "")?>><?php echo $i?></option>
                            <?php } ?>
                            </select>
                        </td>
                        <td>
                            &nbsp;
                            <script type="text/javascript" language="JavaScript">
                            <!--
                                calendar('FilterForm', 'rq_day', 'rq_month', 'rq_year', '<?php echo $this->a_this->getImage('cal.gif')?>');
                            //-->
                            </script>
                        </td>
                    </tr>
                    </table>
                </td>
              </tr>
            </table>
        <?php } else { ?>
            <?php  $this->a_this->assign('a_timeselect_caption_width', 100);
                QUnit_Global::includeTemplate('filter_time.tpl.php'); ?>
        <?php } ?>
        </td></tr>
    <tr class="listrow0" colspan="2"><td align=left nowrap>&nbsp;<b><?php echo L_G_INSERTVALUETOTEXT?></b>&nbsp;<?php showQuickHelp(L_G_HLP_INSERTVALUETOTEXT); ?></td></tr>
    <tr class="listrow0">
      <td width="100">&nbsp;</td>
      <td align=left nowrap>
        <select name="br_insert_text" id="br_insert_text">
        <?php  $const = explode("<br>",  L_G_HLP_AFF_EMAIL_GLOBAL_CONSTANTS);
            $stat_const = explode("<br>", L_G_HLP_AFF_EMAIL_STATS_CONSTANTS);
            $const = array_merge($const, $stat_const);
            $const = array_unique($const);
          	foreach ($const as $cst) { ?>
          	 <option value="<?php echo $cst?>"><?php echo @constant("L_G_CONST_".strtoupper(substr($cst, 1)))?> (<?php echo $cst?>)</option>
        <?php	} ?>
        </select>
        <input type="button" onclick="javascript: insertValue(this.form.emailtext, this.form.br_insert_text);" value="<?php echo L_G_INSERT?>">
      </td>
    </tr>
</table>