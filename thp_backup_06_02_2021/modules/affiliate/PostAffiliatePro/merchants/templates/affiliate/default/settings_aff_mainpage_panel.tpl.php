<?php $settings = $GLOBALS['Auth']->getSettings(); ?>

<form action="index.php" method="POST">
<table cellpadding="2" cellspacing="0" border="0" width="780">
<tr><td>
    <?php echo $this->a_panel_desc?><br><br></td>
</tr>
</table>
    <table class="listing" width="780" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter(4, $this->a_panel_name); ?>
    <tr><td colspan="3" style="padding-left:10px;"><?php echo L_G_DISPLAY?></td></tr>
    <tr>
        <td style="padding-left:10px;">
            <input type="checkbox" name="display_statistics" value="1" <?php echo ($settings['Aff_login_display_statistics'] == '1') ? 'checked' : ''?>>
            <?php echo L_G_DISPLAYSTATISTICS?><?php showQuickHelp(L_G_HLPDISPLAY_STATS); ?>
        </td>
        <td>
            <input type="checkbox" name="display_trendgraph" value="1" <?php echo ($settings['Aff_login_display_trendgraph'] == '1') ? 'checked' : ''?>>
            <?php echo L_G_DISPLAYTRENDGRAPH?><?php showQuickHelp(L_G_HLPDISPLAY_TRENDGRAPH); ?>
        </td>
        <td>
            <input type="checkbox" name="display_manager" value="1" <?php echo ($settings['Aff_login_display_manager'] == '1') ? 'checked' : ''?>>
            <?php echo L_G_DISPLAYAFFILIATEMANAGER?><?php showQuickHelp(L_G_HLPDISPLAY_AFFMANAGER); ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left:10px;">
            <input type="checkbox" name="display_news" value="1" <?php echo ($settings['Aff_display_news'] == '1' ? 'checked' : '')?>>
            <?php echo L_G_DISPLAYNEWS?><?php showQuickHelp(L_G_HLPDISPLAY_NEWS); ?>
        </td>

        <td>
        <input type="checkbox" name="display_resources" value="1" <?php echo ($settings['Aff_display_resources'] == '1' ? 'checked' : '')?>>
            <?php echo L_G_DISPLAYRESOURCES?><?php showQuickHelp(L_G_HLPDISPLAY_RESOURCES); ?>
        </td>
        <td>
        <!--
        <input type="checkbox" name="display_forum" value="1" <?php echo ($settings['Aff_display_forum'] == '1' ? 'checked' : '')?> <?php echo ($this->a_forum_installed != 1) ? 'disabled' : ''?>>
            <?php echo L_G_DISPLAYFORUM?><?php showQuickHelp(L_G_HLPDISPLAY_FORUM); ?>
        -->
        </td>
    </tr>
    <tr>
        <td colspan="3" align="left" style="padding-left:10px;">
        <br>
            <input type="checkbox" name="display_welcome" value="1" <?php echo ($settings['Aff_login_display_welcome'] == '1') ? 'checked' : ''?>>
            &nbsp;<?php echo L_G_DISPLAYWELCOMEMESSAGE?><?php showQuickHelp(L_G_HLP_WELCOMEMESSAGE); ?>
            <br><br>
            <b><?php echo L_G_WELCOMEMESSAGE?></b><br><br>
            <textarea name="welcome_msg" cols="139" rows="10"><?php echo $settings['Aff_login_welcome_msg']?></textarea>
        <td>
    </tr>
    <tr>
        <td colspan="3" align="left" style="padding-left:10px;">
        <br>
            <input type="checkbox" name="display_text_in_the_middle" value="1" <?php echo ($settings['Aff_login_display_text_in_the_middle'] == '1') ? 'checked' : ''?>>
            &nbsp;<?php echo L_G_DISPLAYTEXTINTHEMIDDLE?><?php showQuickHelp(L_G_HLP_TEXTINTHEMIDDLE); ?>
            <br><br>
            <b><?php echo L_G_TEXTINTHEMIDDLE?></b><br><br>
            <textarea name="text_in_the_middle_msg" cols="139" rows="10"><?php echo $settings['Aff_login_text_in_the_middle_msg']?></textarea>
        <td>
    </tr>
    <tr>
        <td colspan="3" align="center">
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
