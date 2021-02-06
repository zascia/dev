<table cellpadding="0" cellspacing="0" border="0">
<tr><td valign=top nowrap width="105">
        &nbsp;<?php echo L_G_BANNERCATEGORY?><?php showQuickHelp(L_G_HLP_BANNERCATEGORY2); ?><br>
        </td>
    <td valign="top" nowrap>
        <select name="<?php echo $this->a_form_preffix?>bannercategory">
            <option value="_">---</option>
        <?php while($data = $this->bannerCategories->FetchRow()) { ?>
            <option value="<?php echo $data['bannercategoryid']?>" <?php echo ($_REQUEST[$this->a_form_preffix.'bannercategory'] == $data['bannercategoryid'] ? 'selected' : '')?>>
            <?php echo $data['name']?>
            </option>
        <?php } ?>
        </select>
    </td></tr>
</table>
