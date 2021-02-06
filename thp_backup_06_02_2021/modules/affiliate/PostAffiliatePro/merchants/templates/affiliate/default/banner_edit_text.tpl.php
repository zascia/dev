    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_TITLE;?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_TEXT_TITLE); ?></td>
      <td><input type=text name=sourceurl size=100 value="<?php echo $_POST['sourceurl']?>">&nbsp;*</td>
    </tr>
    <tr>
      <td class=formText nowrap valign=top>&nbsp;<?php echo L_G_BANNERTEXT;?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_TEXT_TEXT); ?></td>
      <td>
      <textarea name=desc rows=4 cols=100><?php echo $_POST['desc']?></textarea>
      </td>
    </tr>
