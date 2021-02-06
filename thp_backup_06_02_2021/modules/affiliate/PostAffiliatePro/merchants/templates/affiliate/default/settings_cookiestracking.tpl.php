<script language="javascript">
    function showNewStyleRow(show) {
        var row = document.getElementById("newstylerow");
        if (show) {
            if(ns4 || ns6) {
                row.style.display = "table-row";
            } else {
                row.style.display = "inline";
            }
        } else {
            row.style.display = "none";
        }
    }
</script>

    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter2(3, L_G_LINKSTYLE); ?>
   <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_LINKSTYLE;?></b></td>
      <td colspan=2>
      <select name=link_style onchange="javascript: showNewStyleRow(this.value==<?php echo LINK_STYLE_NEW?>);">
        <option value="<?php echo LINK_STYLE_OLD?>" <?php echo ($_POST['link_style'] == LINK_STYLE_OLD ? 'selected' : '')?>><?php echo L_G_LINKSTYLE_OLD?></option>
        <option value="<?php echo LINK_STYLE_NEW?>" <?php echo ($_POST['link_style'] == LINK_STYLE_NEW ? 'selected' : '')?>><?php echo L_G_LINKSTYLE_NEW?></option>
      </select>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td colspan=2><?php showHelp('L_G_HLPLINKSTYLE'); ?></td>
    </tr>

    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_PERMANENT_REDIRECT?></b></td>
      <td valign=top>
      <input type=checkbox name=permanent_redirect value=1 <?php echo ($_POST['permanent_redirect'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <?php showHelp('L_G_HLPPERMANENT_REDIRECT'); ?>
      </td>
    </tr>

    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_TRACKREFSBYSESSION?></b></td>
      <td valign=top>
      <input type=checkbox name=track_by_session value=1 <?php echo ($_POST['track_by_session'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <?php showHelp('L_G_HLPTRACKREFSBYSESSION'); ?>
      </td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_TRACKREFSBYIP?></b></td>
      <td valign=top>
      <input type=checkbox name=track_by_ip value=1 <?php echo ($_POST['track_by_ip'] == 1 ? 'checked' : '')?>
        onchange="javascript: document.getElementById('track_by_browser').disabled = !this.checked;">
      </td>
      <td valign=top rowspan=3>
      <?php showHelp('L_G_HLPTRACKREFSBYIP'); ?>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_USEBROWSERINFO?></b></td>
      <td valign=top>
      <input type=checkbox id=track_by_browser name=track_by_browser value=1 <?php echo ($_POST['track_by_browser'] == 1 ? 'checked' : '')?>
        <?php echo ($_POST['track_by_ip'] == 1 ? '' : 'disabled')?>>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_IPADDRESSVALIDITY?></b></td>
      <td valign=top>
      <input type=text size=5 name=ip_validity value="<?php echo $_POST['ip_validity']?>">
      &nbsp;
      <select name=ip_validity_type>
        <option value="minutes" <?php echo ($_POST['ip_validity_type'] == 'minutes' ? 'selected' : '')?>><?php echo L_G_MINUTES?></option>
        <option value="hours" <?php echo ($_POST['ip_validity_type'] == 'hours' ? 'selected' : '')?>><?php echo L_G_HOURS?></option>
        <option value="days" <?php echo ($_POST['ip_validity_type'] == 'days' ? 'selected' : '')?>><?php echo L_G_DAYS?></option>
        <option value="years" <?php echo ($_POST['ip_validity_type'] == 'years' ? 'selected' : '')?>><?php echo L_G_YEARS?></option>
      </select><br>
      </td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_OVERWRITE_COOKIE?></b></td>
      <td valign=top>
      <input type=checkbox name=overwrite_cookie value=1 <?php echo ($_POST['overwrite_cookie'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <?php showHelp('L_G_HLPOVERWRITECOOKIE'); ?>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_DELETE_COOKIE?></b></td>
      <td valign=top>
      <input type=checkbox name=delete_cookie value=1 <?php echo ($_POST['delete_cookie'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <?php showHelp('L_G_HLPDELETECOOKIE'); ?>
      </td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_REFERRED_AFFILIATE?></b></td>
      <td valign=top>
      <input type=checkbox name=referred_affiliate_allow value=1 <?php echo ($_POST['referred_affiliate_allow'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <?php showHelp('L_G_HLPREFERREDAFFILIATE'); ?>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_CHOOSE_REFERRED_AFFILIATE;?></b></td>
      <td valign=top colspan=2>
        <select name=referred_affiliate>
        <?php while($data=$this->a_list_data->getNextRecord()) { ?>
             <option value='<?php echo $data['userid']?>' <?php echo ($_POST['referred_affiliate'] == $data['userid'] ? ' selected' : '')?>><?php echo $data['userid'].' : '.$data['name'].' '.$data['surname']?></option>
        <?php } ?>
        </select>
      </td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>
    
    <?php QUnit_Templates::printFilter2(3, L_G_DYNAMICLINKSETTINGS); ?>
    <tr><td valign="top"><b><?php echo L_G_ALLOWEDDOMAINSFORDYNAMICLINK?></b></td>
        <td><textarea name="dynamic_link_domains" cols="40" rows="4"><?php echo $_POST['dynamic_link_domains']?></textarea></td>
        <td valign="top"><?php showHelp('L_G_HLP_ALLOWEDDOMAINSFORDYNAMICLINK'); ?></td></tr>
    <tr><td colspan=3>&nbsp;</td></tr>

    <?php QUnit_Templates::printFilter2(3, L_G_P3PPOLICY); ?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_URLTOP3PPOLICYXML?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=p3p_xml value="<?php echo $_POST['p3p_xml']?>"></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_COMPACTP3PPOLICY?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=p3p_compact value="<?php echo $_POST['p3p_compact']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPP3P'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>

    </table>
