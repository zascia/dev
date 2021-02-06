
    <table class="listing" cellpadding="0" cellspacing="0" border="0" width="780">
    <?php QUnit_Templates::printFilter(5, L_G_ROTATORBANNER." ".$this->a_rotator.": ".$this->a_banner_info[$this->a_rotator]['name']); ?>
    <tr><td class="listheader" valign="top"><?php echo L_G_BANNERID?></td>
        <td class="listheader" valign="top"><?php echo L_G_BANNERTYPE?></td>
        <td class="listheader" valign="top"><?php echo L_G_DESTURL?></td>
        <td class="listheader" valign="top"><?php echo L_G_IMPRESSIONS."<br>".L_G_UNIQUE." / ".L_G_ALL?></td>
        <td class="listheader" valign="top"><?php echo L_G_CLICKS?></td></tr>
<?php  foreach ($this->a_data as $bannerID => $bannerData) { ?>
    <tr><td class="listresult"><?php echo $bannerID.': '.$this->a_banner_info[$bannerID]['name']?></td>
        <td class="listresult"><?php echo $this->a_banner_info[$bannerID]['type_text']?></td>
        <td class="listresult"><a href="<?php echo $this->a_banner_info[$bannerID]['destinationurl']?>" target="new"><?php echo $this->a_banner_info[$bannerID]['destinationurl']?></a></td>
        <td class="listresult"><?php echo $bannerData['unique_imps_count']." / ".$bannerData['all_imps_count']?></td>
        <td class="listresult"><?php echo $bannerData['clicks']?></td></tr>
<?php  } ?>
    </table>
<br>