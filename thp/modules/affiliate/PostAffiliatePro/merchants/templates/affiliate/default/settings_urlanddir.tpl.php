    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter2(3, L_G_URLSANDDIRS); ?>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_URL_TO_MAIN_SITE;?></td>
      <td colspan=2 valign=top><input type=text size=70 name=main_site_url value="<?php echo $_POST['main_site_url']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2 valign=top><?php showHelp('L_G_HLPURL_TO_MAIN_SITE'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr> 

    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_EXPORTDIR;?></td>
      <td colspan=2 valign=top><input type=text size=70 name=export_dir value="<?php echo $_POST['export_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2 valign=top><?php showHelp('L_G_HLPEXPORTDIR'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_EXPORTURL?></td>
      <td valign=top colspan=2><input type=text size=70 name=export_url value="<?php echo $_POST['export_url']?>"></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
<?php if (AFF_PROGRAM_TYPE == PROG_TYPE_PRO) { ?>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_RESOURCESDIR;?></td>
      <td colspan=2 valign=top><input type=text size=70 name=resources_dir value="<?php echo $_POST['resources_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2 valign=top><?php showHelp('L_G_HLPRESOURCESDIR'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
<?php } ?>

    <tr><td colspan=3>&nbsp;</td></tr>
    <tr>
      <td class=formBText valign=top><?php echo L_G_BANNERSDIR;?></td>
      <td valign=top colspan=2><input type=text size=70 name=banners_dir value="<?php echo $_POST['banners_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPBANNERSDIR'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_BANNERSURL?></td>
      <td valign=top colspan=2><input type=text size=70 name=banners_url value="<?php echo $_POST['banners_url']?>"></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr> 
    
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_URLTOSCRIPTSDIR?></td>
      <td valign=top colspan=2><input type=text size=70 name=scripts_url value="<?php echo $_POST['scripts_url']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPURLTOSCRIPTSDIR'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr> 

    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_SIGNUPURL?></td>
      <td valign=top colspan=2><input type=text size=70 name=signup_url value="<?php echo $_POST['signup_url']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPSIGNUPURL'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr> 
    
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPSYSTEMEMAIL'); ?></td>
    </tr>
    </table>
