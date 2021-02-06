	<tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_TYPE;?>&nbsp;*&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_POP_TYPE); ?></td>
      <td class=formText nowrap><input type=radio name=rtype value='<?php echo BANNERTYPE_POPUP?>' checked><?php echo L_G_POPUP?></td>
    </tr>
	<tr>
      <td class=formText nowrap>&nbsp;</td>
      <td class=formText nowrap><input type=radio name=rtype value='<?php echo BANNERTYPE_POPUNDER?>' <?php echo ($_POST['rtype'] == BANNERTYPE_POPUNDER ? ' checked' : '')?>><?php echo L_G_POPUNDER?></td>
    </tr>
    <tr>
      <td class=formText colspan=2 nowrap>&nbsp;</td>
    </tr>
	<tr>
      <td class=formText nowrap valign="top">&nbsp;<?php echo L_G_DISPLAY;?>&nbsp;*&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_POP_DISPLAY); ?></td>
      <td class=formText nowrap><input type=radio name=display value='<?php echo URL_OWN?>' checked>
          <?php echo L_G_MY_OWN_URL?>&nbsp;<input type=text name=sourceurl size=54 value="<?php echo $_POST['sourceurl']?>">
          &nbsp;&nbsp;<?php showHelp(L_G_POPUPOWNURLHELP); ?>
      </td>
    </tr>
	<tr>
      <td class=formText nowrap>&nbsp;</td>
      <td class=formText nowrap><input type=radio name=display value='<?php echo URL_EXIST?>' <?php echo ($_POST['display'] == URL_EXIST ? ' checked' : '')?>>
          <?php echo L_G_EXISTING_BANNER_LINK?>&nbsp;
          <select name=exist_banner>
            <?php while($data=$this->a_list_data2->getNextRecord()) { ?>
              <option value='<?php echo $data['bannerid']?>' <?php echo ($_POST['exist_banner'] == $data['bannerid'] ? 'selected' : '')?>><?php echo $data['type_text'].', ID:'.$data['bannerid'].', Dest:'.$data['destinationurl']?></option>
            <?php } ?>
          </select>&nbsp;
      </td>
    </tr>
    <tr>
      <td class=formText colspan=2 nowrap>&nbsp;</td>
    </tr>
	<tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_WINDOW_SIZE;?>&nbsp;*&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_POP_WINDOWSIZE); ?></td>
      <td class=formText nowrap><input type=radio name=window_size_type value='<?php echo WINDOWSIZE_PREDEFINED?>' checked>
          &nbsp;<?php echo L_G_PREDEFINED?>&nbsp;<select name=window_size>
            <option value='100_40' selected>100x40</option>
            <option value='200_80' <?php echo ($_POST['window_size'] == '200_80' ? ' selected' : '')?>>200x80</option>
            <option value='300_120' <?php echo ($_POST['window_size'] == '300_120' ? ' selected' : '')?>>300x120</option>
            <option value='500_200' <?php echo ($_POST['window_size'] == '500_200' ? ' selected' : '')?>>500x200</option>
            <option value='750_250' <?php echo ($_POST['window_size'] == '750_250' ? ' selected' : '')?>>750x250</option>
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
    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_WINDOW_RESIZABLE;?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_POP_WINDOWRESIZABLE); ?></td>
      <td class=formText nowrap>
        <input type=radio name=window_resizable value='<?php echo SWITCH_TRUE?>' <?php echo ($_POST['window_resizable'] == SWITCH_TRUE ? ' checked' : '')?>><?php echo strtolower(L_G_YES)?>&nbsp;&nbsp;&nbsp;&nbsp;
        <input type=radio name=window_resizable value='<?php echo SWITCH_FALSE?>' <?php echo (($_POST['window_resizable'] == SWITCH_FALSE || $_POST['window_resizable'] == '') ? ' checked' : '')?>><?php echo strtolower(L_G_NO)?>&nbsp;
      </td>
    </tr>
    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_WINDOW_STATUS_FIELD;?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_POP_WINDOWSTATUSFIELD); ?></td>
      <td class=formText nowrap>
        <input type=radio name=window_status value='<?php echo SWITCH_TRUE?>' <?php echo ($_POST['window_status'] == SWITCH_TRUE ? ' checked' : '')?>><?php echo L_G_SHOW?>&nbsp;
        <input type=radio name=window_status value='<?php echo SWITCH_FALSE?>' <?php echo (($_POST['window_status'] == SWITCH_FALSE || $_POST['window_status'] == '') ? ' checked' : '')?>><?php echo L_G_HIDE?>&nbsp;
      </td>
    </tr>
    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_WINDOW_TOOLBAR;?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_POP_WINDOWTOOLBAR); ?></td>
      <td class=formText nowrap>
        <input type=radio name=window_toolbar value='<?php echo SWITCH_TRUE?>' <?php echo ($_POST['window_toolbar'] == SWITCH_TRUE ? ' checked' : '')?>><?php echo L_G_SHOW?>&nbsp;
        <input type=radio name=window_toolbar value='<?php echo SWITCH_FALSE?>' <?php echo (($_POST['window_toolbar'] == SWITCH_FALSE || $_POST['window_toolbar'] == '') ? ' checked' : '')?>><?php echo L_G_HIDE?>&nbsp;
      </td>
    </tr>
    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_WINDOW_LOCATION;?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_POP_WINDOWLOCATION); ?></td>
      <td class=formText nowrap>
        <input type=radio name=window_location value='<?php echo SWITCH_TRUE?>' <?php echo ($_POST['window_location'] == SWITCH_TRUE ? ' checked' : '')?>><?php echo L_G_SHOW?>&nbsp;
        <input type=radio name=window_location value='<?php echo SWITCH_FALSE?>' <?php echo (($_POST['window_location'] == SWITCH_FALSE || $_POST['window_location'] == '') ? ' checked' : '')?>><?php echo L_G_HIDE?>&nbsp;
      </td>
    </tr>
    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_WINDOW_DIRECTORIES;?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_POP_WINDOWDIRECTORIES); ?></td>
      <td class=formText nowrap>
        <input type=radio name=window_directories value='<?php echo SWITCH_TRUE?>' <?php echo ($_POST['window_directories'] == SWITCH_TRUE ? ' checked' : '')?>><?php echo L_G_SHOW?>&nbsp;
        <input type=radio name=window_directories value='<?php echo SWITCH_FALSE?>' <?php echo (($_POST['window_directories'] == SWITCH_FALSE || $_POST['window_directories'] == '') ? ' checked' : '')?>><?php echo L_G_HIDE?>&nbsp;
      </td>
    </tr>
    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_WINDOW_MENUBAR;?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_POP_WINDOWMENUBAR); ?></td>
      <td class=formText nowrap>
        <input type=radio name=window_menubar value='<?php echo SWITCH_TRUE?>' <?php echo ($_POST['window_menubar'] == SWITCH_TRUE ? ' checked' : '')?>><?php echo L_G_SHOW?>&nbsp;
        <input type=radio name=window_menubar value='<?php echo SWITCH_FALSE?>' <?php echo (($_POST['window_menubar'] == SWITCH_FALSE || $_POST['window_menubar'] == '') ? ' checked' : '')?>><?php echo L_G_HIDE?>&nbsp;
      </td>
    </tr>
    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_WINDOW_SCROLLBARS;?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_POP_WINDOWSCROLLBARS); ?></td>
      <td class=formText nowrap>
        <input type=radio name=window_scrollbars value='<?php echo SWITCH_TRUE?>' <?php echo ($_POST['window_scrollbars'] == SWITCH_TRUE ? ' checked' : '')?>><?php echo L_G_SHOW?>&nbsp;
        <input type=radio name=window_scrollbars value='<?php echo SWITCH_FALSE?>' <?php echo (($_POST['window_scrollbars'] == SWITCH_FALSE || $_POST['window_scrollbars'] == '') ? ' checked' : '')?>><?php echo L_G_HIDE?>&nbsp;
      </td>
    </tr>
