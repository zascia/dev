<table cellpadding="2" cellspacing="0" border="0" width="780">
<tr><td>
    <?php echo L_G_PANELSETTINGSDESC?><br><br></td>
</tr>
<tr><td>
    <?php $columnCount = 2; ?>
    <table cellpadding="2" cellspacing="0" border="0">
     <?php $links = $this->a_setting_links;
        reset($links);
        for ($row=0; $row < ceil(count($links)/$columnCount); $row++) { ?>
            <tr>
     <?php     for ($column=0; $column < $columnCount; $column++) {
                $link = current($links);
                if ($link == '') { ?>
                    <td></td>
        <?php         continue;
                } ?>
                <td width="50%" valign=top><table cellpadding="3" cellspacing="0" border="0">
                    <tr>
                        <td colspan="3">                        <a href="<?php echo $link['url']?>">
                        <b><?php echo $link['name']?></b></a></td></tr>
                    <tr><td width="122" valign=top><a href="<?php echo $link['url']?>"><img src="<?php echo $this->a_this->getImage($link['img']) ?>"></a></td>
                        <td valign=top><?php echo $link['desc']?><br><br></td>
                        <td width="30"></td>
                    </tr>
                    </table>
                </td>
        <?php     next($links);
            } ?>
            </tr>
     <?php } ?>
    </table></td>
</tr>
</table>