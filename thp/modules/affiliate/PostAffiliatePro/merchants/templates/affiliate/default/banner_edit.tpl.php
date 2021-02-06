
    <form enctype="multipart/form-data" action=index.php method=post>
    <table border=0 cellspacing=0 cellpadding=3 width="780">
    <tr><td><?php echo $this->a_hlp?><br><br></td></tr>
    </table>
    <table border=0 class=listing cellspacing=0 cellpadding=3 width="780">
    <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td width="5%" class=formText nowrap>&nbsp;<?php echo L_G_BANNERTYPE?></td>
      <td>
        <b><?php echo $this->a_type_text?></b>
      </td>
    </tr>
    <tr>
      <td width="5%" class=formText nowrap>&nbsp;<?php echo L_G_BANNERNAME?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_BANNERNAME); ?></td>
      <td>
        <input type=text name=name size=100 maxlength="100" value="<?php echo $_POST['name']?>">
      </td>
    </tr>
    <tr>
      <td width="5%" class=formText nowrap>&nbsp;<?php echo L_G_HIDDENBANNER?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_HIDDENBANNER); ?></td>
      <td>
        <input type="checkbox" name=hidden value="1" <?php echo ($_POST['hidden'] == '1') ? 'checked' : ''?>>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <?php $this->a_this->assign('a_disable_all_campaigns', true);
           QUnit_Global::includeTemplate('filter_campaign.tpl.php'); ?>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <?php QUnit_Global::includeTemplate('filter_bannercategory.tpl.php'); ?>
      </td>
    </tr>
<?php  if ($this->a_hide_banner_size != '1') { ?>
    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_BANNERSIZE;?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_BANNERSIZE); ?></td>
      <td class=formText nowrap><input type=radio name=window_size_type value='0' checked>
          <?php echo L_G_NOTDEFINED?> <?php echo $this->a_size_msg?>
      </td>
    </tr>
    <tr>
      <td class=formText nowrap>&nbsp;</td>
      <td class=formText nowrap><input type=radio name=window_size_type value='<?php echo WINDOWSIZE_PREDEFINED?>' <?php echo ($_POST['window_size_type'] == WINDOWSIZE_PREDEFINED ? ' checked' : '')?>>
          &nbsp;<?php echo L_G_PREDEFINED?>&nbsp;<select name=window_size>
            <?php  $sizes = explode(';', $GLOBALS['Auth']->getSetting('Aff_acct_predefined_bannersizes'));
                if(count($sizes) > 0) {
                    foreach ($sizes as $size) { ?>
                        <option value='<?php echo $size?>' <?php echo ($_POST['window_size'] == $size ? ' selected' : '')?>><?php echo str_replace('_', 'x', $size)?></option>
            <?php      }
                } ?>
          </select>&nbsp;
      </td>
    </tr>
	<tr>
      <td class=formText nowrap>&nbsp;</td>
      <td class=formText nowrap><input type=radio name=window_size_type value='<?php echo WINDOWSIZE_OWN?>' <?php echo ($_POST['window_size_type'] == WINDOWSIZE_OWN ? ' checked' : '')?>>
          <?php echo L_G_OWN?>&nbsp;<?php echo L_G_WIDTH?>&nbsp;<input type=text name=rwidth size=2 value="<?php echo $_POST['rwidth']?>">
          &nbsp;x&nbsp;<?php echo L_G_HEIGHT?>&nbsp;<input type=text name=rheight size=2 value="<?php echo $_POST['rheight']?>">
      </td>
    </tr>
<?php  } ?>
    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_DESTURL;?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_DESTINATIONURL); ?></td>
      <td>
        <input type=text name=desturl size=100 value="<?php echo $_POST['desturl']?>">&nbsp;*
      </td>
    </tr>
         <?php QUnit_Global::includeTemplate($this->a_bannertemplate); ?>
    <tr>
      <td class=formText colspan=2 align=left>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='<?php echo $this->a_md?>'>
      <input type=hidden name=action value=<?php echo $_REQUEST['action']?>>
      <input type=hidden name=cid value=<?php echo $_REQUEST['cid']?>>
      <input type=hidden name=bid value=<?php echo $_REQUEST['bid']?>>
      <input class=formbutton type=submit value='<?php echo L_G_SUBMIT; ?>'>
      </td>
    </tr>
    </table>
    </form>
<?php if($this->a_example != '') { ?> 
    <table border=0 cellspacing=0 cellpadding=3 width="780">
    <tr>
      <td align=left><?php echo $this->a_example?></td>
    </tr>
    </table>
<?php } ?>
