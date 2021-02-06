    <table width="100%" border=0 cellspacing=0 cellpadding=5>
    <?php QUnit_Templates::printFilter(2, L_G_TRACKINGPARAMSNAMES); ?>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_AFFILIATEID_REFERERID?></td>
      <td valign=top><input type=text size=20 name=name_a_aid value="<?php echo $_POST['name_a_aid']?>">
                     <?php showQuickHelp('L_G_HLP_NAME_AFFILIATEID'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_BANNERID?></td>
      <td valign=top><input type=text size=20 name=name_a_bid value="<?php echo $_POST['name_a_bid']?>">
                     <?php showQuickHelp('L_G_HLP_NAME_BANNERID'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_DATA1?></td>
      <td valign=top><input type=text size=20 name=name_data1 value="<?php echo $_POST['name_data1']?>">
                     <?php showQuickHelp('L_G_HLP_NAME_DATA'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_DATA2?></td>
      <td valign=top><input type=text size=20 name=name_data2 value="<?php echo $_POST['name_data2']?>">
                     <?php showQuickHelp('L_G_HLP_NAME_DATA'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_DATA3?></td>
      <td valign=top><input type=text size=20 name=name_data3 value="<?php echo $_POST['name_data3']?>">
                     <?php showQuickHelp('L_G_HLP_NAME_DATA'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_DESTURL?></td>
      <td valign=top><input type=text size=20 name=name_desturl value="<?php echo $_POST['name_desturl']?>">
                     <?php showQuickHelp('L_G_HLP_NAME_DESTURL'); ?></td>
    </tr>

    </table>
