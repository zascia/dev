    <form action="index.php" method="POST">
    <table class="listing" width="780" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter(3, L_G_LOGINSCREENSETTINGS); ?>
    <tr><td width="12%"><b><?php echo L_G_DISPLAY?></b><?php showQuickHelp(L_G_HLP_DISPLAYTOAFFILIATE); ?></td>
        <td><input type="checkbox" name="display_welcome" value="1" <?php echo ($_POST['display_welcome'] == '1') ? 'checked' : ''?>>
            <?php echo L_G_DISPLAYWELCOMEMESSAGE?></td>
    </tr>  
    <tr><td></td>
        <td><input type="checkbox" name="display_statistics" value="1" <?php echo ($_POST['display_statistics'] == '1') ? 'checked' : ''?>>
            <?php echo L_G_DISPLAYSTATISTICS?></td>
    </tr> 
    <tr><td></td>
        <td><input type="checkbox" name="display_trendgraph" value="1" <?php echo ($_POST['display_trendgraph'] == '1') ? 'checked' : ''?>>
            <?php echo L_G_DISPLAYTRENDGRAPH?></td>
    </tr>  
    <tr><td></td>
        <td><input type="checkbox" name="display_manager" value="1" <?php echo ($_POST['display_manager'] == '1') ? 'checked' : ''?>>
            <?php echo L_G_DISPLAYAFFILIATEMANAGER?></td>
    </tr>   
    <tr><td></td>
        <td><input type="checkbox" name="display_news" value="1" <?php echo ($_POST['display_news'] == '1' ? 'checked' : '')?>>
            <?php echo L_G_DISPLAYNEWS?><?php showQuickHelp(L_G_HLPDISPLAY_NEWS); ?></td>
    </tr>
    <tr><td></td>
        <td><input type="checkbox" name="display_resources" value="1" <?php echo ($_POST['display_resources'] == '1' ? 'checked' : '')?>>
            <?php echo L_G_DISPLAYRESOURCES?><?php showQuickHelp(L_G_HLPDISPLAY_RESOURCES); ?></td>
    </tr>
    <tr><td></td>
        <td><input type="checkbox" name="display_forum" value="1" <?php echo ($_POST['display_forum'] == '1' ? 'checked' : '')?> <?php echo ($this->a_forum_installed != 1) ? 'disabled' : ''?>>
            <?php echo L_G_DISPLAYFORUM?><?php showQuickHelp(L_G_HLPDISPLAY_FORUM); ?></td>
    </tr>
    <tr><td colspan="2">
            <b><?php echo L_G_WELCOMEMESSAGE?></b><?php showQuickHelp(L_G_HLP_WELCOMEMESSAGE); ?><br><br>
            <textarea name="welcome_msg" cols="149" rows="20"><?php echo $_POST['welcome_msg']?></textarea>
         </td>
    </tr>
    <tr><td colspan="2">
            <b><?php echo L_G_WELCOMEMESSAGE?></b><?php showQuickHelp(L_G_HLP_WELCOMEMESSAGE); ?><br><br>
            <textarea name="welcome_msg" cols="149" rows="20"><?php echo $_POST['welcome_msg']?></textarea>
         </td>
    </tr>
    <tr><td colspan="2">
            <input type=hidden name=commited value=yes>
            <input type=hidden name=md value='Affiliate_Merchants_Views_AffLoginSettings'>
            <input class=formbutton type=submit value="<?php echo L_G_SAVECHANGES?>">
         </td>
    </tr>
    </table>
    </form>
