
<form action=index.php method=post>
  <center>
    <table width=100% border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=commcat align=left valign=top colspan=3>
        <?php echo L_G_SETTINGSHELP?>
        <br><br></td>
      </tr>
      <tr>
        <td class=header align=center colspan=3><?php echo L_G_CHOOSEDESIGN?></td>
      </tr>
      <tr>
        <td align=center colspan=3>
        <table border=0 cellpadding=5>
        <tr>
          <td align=center valign=top><a href="./templates/affiliate/default/images/design_default.gif" target=_blank><img src="<?php echo  QUnit_UI_TemplatePage::getImage('design_default_small.gif') ?>" style="border:1px solid #a0a0a0" border="0"></a></td>
          <td>&nbsp;&nbsp;</td>
          <td align=center valign=top><a href="./templates/affiliate/default/images/design_blue_top.gif" target=_blank><img src="<?php echo  QUnit_UI_TemplatePage::getImage('design_blue_top_small.gif') ?>" style="border:1px solid #a0a0a0" border="0"></a></td>
        </tr>
        <tr>
          <td align=center valign=top>
          <input type=radio name="design" value='default'>&nbsp;<b>Blue (default)</b>
          <br>Default design with menu on the left
          </td>
          <td>&nbsp;&nbsp;</td>
          <td align=center valign=top>
          <input type=radio name="design" value='blueStyle'>&nbsp;<b>Dark Menu Top</b>
          <br>Skin with blue top menu
          </td>
        </tr>
        <tr>
          <td colspan=3 align=left>
          <br>
          <?php echo L_G_SKINHELP?>
          </td>
        </table>
        </td>
      </tr>

      <tr>
        <td class=header align=center colspan=3><?php echo L_G_SETTINGS?></td>
      </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_EXPORTDIR;?></b></td>
      <td colspan=2 valign=top><input type=text size=70 name=export_dir value="<?php echo $_POST['export_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2 valign=top><?php showHelp('L_G_HLPEXPORTDIR', true); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_EXPORTURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=export_url value="<?php echo $_POST['export_url']?>">
      &nbsp;&nbsp;
<?php if($_POST['export_url'] != '') { ?>
    <a href="<?php echo $_POST['export_url']?>" target=new><font color=#ff0000 size=-1><?php echo L_G_CHECKIT?></font></a>
<?php } ?>
      </td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top><b><?php echo L_G_BANNERSDIR;?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=banners_dir value="<?php echo $_POST['banners_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPBANNERSDIR', true); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_BANNERSURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=banners_url value="<?php echo $_POST['banners_url']?>">
      &nbsp;&nbsp;
<?php if($_POST['banners_url'] != '') { ?>
    <a href="<?php echo $_POST['banners_url']?>" target=new><font color=#ff0000 size=-1><?php echo L_G_CHECKIT?></font></a>
<?php } ?>
      </td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top><b><?php echo L_G_DIRECTORYFORREPLICATION;?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=replication_dir value="<?php echo $_POST['replication_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPDIRECTORYFORREPLICATION', true); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_URLTODIRECTORYFORREPLICATION?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=replication_url value="<?php echo $_POST['replication_url']?>">
      &nbsp;&nbsp;
<?php if($_POST['replication_url'] != '') { ?>
    <a href="<?php echo $_POST['replication_url']?>" target=new><font color=#ff0000 size=-1><?php echo L_G_CHECKIT?></font></a>
<?php } ?>
      </td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_URLTOSCRIPTSDIR?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=scripts_url value="<?php echo $_POST['scripts_url']?>">
      &nbsp;&nbsp;
<?php if($_POST['scripts_url'] != '') { ?>
    <a href="<?php echo $_POST['scripts_url']?>" target=new><font color=#ff0000 size=-1><?php echo L_G_CHECKIT?></font></a>
<?php } ?>
      </td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPURLTOSCRIPTSDIR', true); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SIGNUPURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=signup_url value="<?php echo $_POST['signup_url']?>">
      &nbsp;&nbsp;
<?php if($_POST['signup_url'] != '') { ?>
    <a href="<?php echo $_POST['signup_url']?>" target=new><font color=#ff0000 size=-1><?php echo L_G_CHECKIT?></font></a>
<?php } ?>
      </td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPSIGNUPURL', true); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top><b><?php echo L_G_CACHEDIR;?></b></td>
      <td valign=top colspan=2><?php echo $_POST['cache_dir']?></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPCACHEDIR', true); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_CACHEURL?></b></td>
      <td valign=top colspan=2><?php echo $_POST['cache_url']?>
      &nbsp;&nbsp;
      </td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SYSTEMEMAIL;?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=system_email value="<?php echo $_POST['system_email']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPSYSTEMEMAIL', true); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_MAINSITEURL;?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=main_site_url value="<?php echo $_POST['main_site_url']?>"></td>
    </tr>

      <tr>
        <td class=commcat align=left valign=top colspan=3>&nbsp;</td>
      </tr>
      <tr>
        <td class=theader align=right valign=top colspan=3>
        <input type=submit class=formbutton name=submit value="<?php echo L_G_NEXT?>">
        </td>
      </tr>
    </table>
  </center>
<input type=hidden name=installmethod value="<?php echo $_POST['installmethod']?>">
<input type=hidden name=action value="Settings">
</form>

