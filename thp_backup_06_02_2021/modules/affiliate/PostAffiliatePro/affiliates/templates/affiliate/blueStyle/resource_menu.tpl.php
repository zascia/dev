<div>
      <table width="780" cellpadding="2" cellspacing="0" border=0 class="traffic">
      <tr>
        <td width="10%" class=trafficCell align=left valign=top>&nbsp;&nbsp;&nbsp;<b><?php echo L_G_RESOURCES?>:</b></td>
   <?php $width = floor(90 / count($GLOBALS['leftMenuResources']));
      foreach ($GLOBALS['leftMenuResources'] as $header => $submenu) { ?>
        <td class=trafficCell valign="top" width="<?php echo $width?>%">
        <?php foreach ($submenu as $itemID => $item) { ?>
            <?php echo $item[1]?><br>
        <?php } ?>
        </td>
   <?php } ?>
      <td class="trafficCellBorderRight">&nbsp;</td>
      </tr>
      </table>
 </div>