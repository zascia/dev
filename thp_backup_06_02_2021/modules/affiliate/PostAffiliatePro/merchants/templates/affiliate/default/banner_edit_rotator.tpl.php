    
    <form enctype="multipart/form-data" name="myform" action=index.php method=post>
    <table border=0 cellspacing=0 cellpadding=3 width="780">
    <tr><td><?php echo L_G_ROTATORBANNERHELP?><br><br></td></tr>
    </table>
    <table border=0 class=listing cellspacing=0 cellpadding=3 width="780">
    <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td width="5%" class=formText nowrap>&nbsp;<?php echo L_G_BANNERTYPE?></td>
      <td>&nbsp;
        <b><?php echo L_G_BANNERTYPE_ROTATOR?></b>
      </td>
    </tr> 
    <tr>
      <td width="5%" class=formText nowrap>&nbsp;<?php echo L_G_BANNERNAME?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_BANNERNAME); ?></td>
      <td>
        <input type=text name=name size=60 maxlength="100" value="<?php echo $_POST['name']?>">
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
    <tr>
      <td colspan="2"><hr width="100%"></td>
    </tr>
    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_ADDBANNER?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_ROTATOR_ADDSUBBANNER); ?></td>
      <td>
        <select name=addbanner_id>
        <?php $bannerInfo = array();
           while($data=$this->a_list_data_banners->getNextRecord()) { ?>
          <option value='<?php echo $data['bannerid']?>' <?php echo ($_POST['exist_banner'] == $data['bannerid'] ? 'selected' : '')?>><?php echo $data['type_text'].', ID:'.$data['bannerid'].', Name: '.$data['name'].', Dest:'.$data['destinationurl']?></option>
        <?php  $bannerInfo[$data['bannerid']] = $data['type_text'].', ID:'.$data['bannerid'].', Name: '.$data['name'].', Dest:'.$data['destinationurl'];
           } ?>
        </select>&nbsp;&nbsp;&nbsp;
            <?php $rank = (count($this->a_selected_banners) > 0) ? round(100/(count($this->a_selected_banners)+1)) : 100; ?>
            <?php echo L_G_RANK?>:&nbsp;&nbsp;<input type="text" name="addbanner_rank" size="3" value="<?php echo $rank?>">
        &nbsp;&nbsp;&nbsp;<input class="formbutton" name="submit_add" type="submit" value="<?php echo L_G_ADD?>">
      </td>
    </tr>
    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_BANNERLIST?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_ROTATOR_BANNERLIST); ?></td>
      <td><input type="hidden" name="desc" value="<?php echo $_POST['desc']?>">
          <table class=listing border=0 cellspacing=0 cellpadding=1>
          <tr class=listheader>
              <td class=listheader width=1% nowrap rowspan="2"><?php echo L_G_BANNER?></td>
              <td class=listheader width=1% nowrap colspan="2"><?php echo L_G_IMPRESSIONS?></td>
              <td class=listheader width=1% nowrap rowspan="2"><?php echo L_G_CLICKS?></td>
              <td class=listheader width=1% nowrap rowspan="2"><?php echo L_G_CTR?></td>
              <td class=listheader width=1% nowrap rowspan="2"><?php echo L_G_RANK?></td>
              <td class=listheader width=1% nowrap rowspan="2"><?php echo L_G_ACTIONS?></td>
          </tr>    
          <tr class=listheader>
              <td class=listheader width=1% nowrap><?php echo L_G_ALL?></td>
              <td class=listheader width=1% nowrap><?php echo L_G_UNIQUE?></td>
          </tr>    
          <?php 
          if (count($this->a_selected_banners) != 0) {
              foreach ($this->a_selected_banners as $bannerID => $bannerData) { ?>
                 <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
                      <td class="listresultnocenter" align="left" nowrap>&nbsp;<?php echo $bannerInfo[$bannerID]?></td>
                      <td class="listresult"><?php echo $bannerData['all_imps']?></td>
                      <td class="listresult"><?php echo $bannerData['uniq_imps']?></td>
                      <td class="listresult"><?php echo $bannerData['clicks']?></td>
                      <td class="listresult"><?php echo ($bannerData['all_imps'] == 0) ? 0 : round($bannerData['clicks']/$bannerData['all_imps']*100, 2)?> %</td>
                      <td class="listresult">
                        <?php  if ($_POST['edit_rank_id'] == $bannerID) { ?>
                                <input type="hidden" name="edit_rank_id" value="<?php echo $_POST['edit_rank_id']?>">
                                <input type="text" size="5" name="edit_rank_value" value="<?php echo ($_POST['edit_rank_value'] == '') ? $bannerData['rank'] : $_POST['edit_rank_value']?>">
                        <?php  } else {
                                echo $bannerData['rank'];
                            }
                        ?>
                      </td>
                      <td class="listresult">
                          <?php  if ($_POST['edit_rank_id'] == $bannerID) {
                              ?>&nbsp;<input class="formbutton" name="save_rank" type="submit" value="<?php echo L_G_SAVE.' '.L_G_RANK?>"><?php
                              } else {
                              ?>&nbsp;<input class="formbutton" name="editrank_<?php echo $bannerID?>" type="submit" value="<?php echo L_G_EDIT.' '.L_G_RANK?>"><?php
                              } ?>&nbsp;&nbsp;<input class="formbutton" name="delete_<?php echo $bannerID?>" type="submit" value="<?php echo L_G_DELETE?>">&nbsp;
                      </td>
                 </tr>
          <?php    }
          } else { ?>
                <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
                    <td class="listresult" colspan="7"><b><?php echo L_G_NOBANNERSINROTATOR?></b></td>
                </tr>
          <?php 
          } ?>   
          <tr class=listheader>
              <td class=listresultnocenter nowrap colspan="7" align="left">
                &nbsp;<input class="formbutton" name="reset_stats" type="submit" value="<?php echo L_G_RESETSTATS?>">
                &nbsp;&nbsp;&nbsp;<input class="formbutton" name="reset_rank" type="submit" value="<?php echo L_G_RESETRANK?>">
              </td>
          </tr>    
          </table>
      </td>
    </tr>
    <tr>
      <td class=formText>&nbsp;</td>
      <td class="errorMessage"><?php echo L_G_ROTATORBANNERWARNING?></td>
    </tr>
    <tr>
      <td class=formText nowrap>&nbsp;<?php echo L_G_SELFOPTIMIZATION?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_ROTATOR_SELFOPTIMIZATION); ?></td>
      <td><select name="sourceurl">
          <option value="<?php echo SELFOPTIMIZATION_NONE?>" <?php echo ($_POST['sourceurl'] == SELFOPTIMIZATION_NONE) ? 'selected' : ''?>><?php echo L_G_NOSELFOPTIMIZATION?></option>
          <option value="<?php echo SELFOPTIMIZATION_CLICKS?>" <?php echo ($_POST['sourceurl'] == SELFOPTIMIZATION_CLICKS) ? 'selected' : ''?>><?php echo L_G_CLICKS?></option>
          <option value="<?php echo SELFOPTIMIZATION_CTR?>" <?php echo ($_POST['sourceurl'] == SELFOPTIMIZATION_CTR) ? 'selected' : ''?>><?php echo L_G_CTR?></option>
          </select>
      </td>
    </tr>
    <tr>
      <td class=formText colspan=2 align=left>
      <input type=hidden name=desturl value="<?php echo $_POST['desturl']?>">
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='<?php echo $this->a_md?>'>
      <input type=hidden name=action value=<?php echo $_REQUEST['action']?>>
      <input type=hidden name=cid value=<?php echo $_REQUEST['cid']?>>
      <input type=hidden name=bid value=<?php echo $_REQUEST['bid']?>>
      <input class=formbutton name="submit" type=submit value='<?php echo L_G_SUBMIT; ?>'>
      </td>
    </tr>
    </table>
    </form>

