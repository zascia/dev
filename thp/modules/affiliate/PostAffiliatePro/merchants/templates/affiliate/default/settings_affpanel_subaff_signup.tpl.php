<?php $settings = $GLOBALS['Auth']->getSettings(); ?>
<form action="index.php" method="POST">
<table cellpadding="2" cellspacing="0" border="0" width="780">
<tr><td>
    <?php echo $this->a_panel_desc?><br><br></td>
</tr>
</table>
    <table class="listing" width="780" border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(3, $this->a_panel_name); ?>
    <tr>
        <td width="25" align="left" style="padding-left:10px;">
            <input type="checkbox" name="showsection" <?php echo ($settings['Aff_menu_item_'.$this->a_menu_item.'_show'] == 'true' || isset($_REQUEST['showsection']))? 'checked' : ''?>>
            <input type="hidden" name="menuitem" value="<?php echo $this->a_menu_item?>">
            <?php echo L_G_SHOWSECTION?><?php showQuickHelp(L_G_HLP_DISPLAYSECTIONTOAFFS); ?>
        </td>
    </tr>

    <tr>
        <td style="padding-left:10px;">
            <br>
            <input type="checkbox" name="showdescription" <?php echo ($settings['Aff_settings_'.$this->a_panel_type.'_show_description'] == 'true')? 'checked' : ''?>>
            <?php echo L_G_SHOWDESCRIPTION?><?php showQuickHelp(L_G_HLPDISPLAY_BUILDINDESC); ?>
            <br>
            <table width="100%" border=0 style="border: #aaaaaa 1px solid;">
            <tr>
                <td align=left valign=top>
                <?php echo $this->a_panel_aff_desc?>
                </td>
            </tr></table>
        </td>
    </tr>
    <tr>
        <td align="left" style="padding-left:10px;">
            <br>
            <?php echo L_G_SIGNUPURL?>
        </td>
    </tr>
    <tr>
        <td align="left" style="padding-left:10px;">
            <input type="text" name="signup_page_url" size="140" value="<?php echo $_REQUEST['signup_page_url']?>">
        </td>
    </tr>
    <tr>
        <td align="left" style="padding-left:10px;">
            <br><br>
            <input type="checkbox" name="showcustomdescription" <?php echo ($settings['Aff_settings_'.$this->a_panel_type.'_show_customdescription'] == 'true')? 'checked' : ''?>>
            &nbsp;<?php echo L_G_SHOWCUSTOMDESCRIPTION?><?php showQuickHelp(L_G_HLPDISPLAY_CUSTOMDESC); ?>
            <br><br>
            <b><?php echo L_G_CUSTOMDESCRIPTION?><b><br><br>
            <textarea rows="10" cols="139" name="customdescription"><?php echo $settings['Aff_settings_'.$this->a_panel_type.'_customdescription']?></textarea><br>
        </td>
    </tr>
    <tr>
        <td align="center">
            <br>
            <input type="hidden" name="savesettings" value="true">
            <input type="hidden" name="paneltype" value="<?php echo $this->a_panel_type?>">
            <input type="hidden" name="md" value="Affiliate_Merchants_Views_AffPanelSettings">
            <input type="hidden" name="showpanel" value="<?php echo $this->a_panel_type?>">
            <?php if ($this->a_this->checkPermissions('edit')) { ?>
                <input type="submit" class="formbutton" value="<?php echo L_G_SAVECHANGES?>">
             <?php } else { ?>
                <input class=formbutton type=button value="<?php echo L_G_YOU_DONT_HAVE_RIGHTS_TO_EDIT?>">
             <?php } ?>
            <br><br>
        </td>
    </tr>
    </table>
</form>
