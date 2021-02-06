<form name=FilterForm id=FilterForm action=index.php method=post>
<table class=listing border=0 cellspacing=0 cellpadding=3 width="750">
<?php QUnit_Templates::printAdvancedFilter(1, L_G_FILTER, 'bs_', 'FilterForm'); ?>
<tr class="listheader"><td>
  <div id="<?php echo $this->a_form_preffix?>standard_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? 'style="display:none;"' : ''?>>
  </div>
  <div id="<?php echo $this->a_form_preffix?>advanced_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? '' : 'style="display:none;"'?>>
  <table width="100%">
   <tr>
      <td>
        <table cellpadding="2" cellspacing="0" border="0">
        <tr><td valign=top width="150">&nbsp;<b><?php echo L_G_BANNERNAME?></b>&nbsp;<?php showQuickHelp(L_G_HLP_BANNERNAMEFILTER); ?><br></td>
            <td align="left">
             <input type="text" name="bs_name" size="35" value="<?php echo $_REQUEST['bs_name']?>"></td></tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table cellpadding="2" cellspacing="0" border="0">
        <tr><td valign=top width="150">&nbsp;<b><?php echo L_G_BANNERSIZE?></b>&nbsp;<?php showQuickHelp(L_G_HLP_BANNERSIZEFILTER); ?><br></td>
            <td align="left">
             <select name=bs_window_size>
              <option value="_" <?php echo ($_REQUEST['bs_window_size'] == '_' || $_REQUEST['bs_window_size'] == '') ? 'checked' : ''?>><?php echo L_G_ALL?></option>
              <option value='n' <?php echo $_REQUEST['bs_window_size'] == 'n' ? 'selected' : ''?>><?php echo L_G_NOTDEFINED?></option>
          <?php if (count($this->a_bannersizes)) {
                foreach ($this->a_bannersizes as $size) { ?>
                    <option value='<?php echo $size?>'  <?php echo ($_REQUEST['bs_window_size'] == $size  ? ' selected' : '')?>><?php echo str_replace('_', 'x', $size)?></option>
          <?php    }
             } ?>
             </select></td></tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align=left>
        <?php QUnit_Global::includeTemplate('filter_bannertype.tpl.php'); ?>
      </td>
    </tr>
    <tr>
      <td align=left>
        <?php 
            $this->a_this->assign('a_form_preffix', 'bs_created_');
            $this->a_this->assign('a_timeselect_caption', '<b>'.L_G_BANNERSCREATEDIN.'</b>');
            $this->a_this->assign('a_timeselect_caption_width', 150);
            QUnit_Global::includeTemplate('filter_time.tpl.php');
            $this->a_this->assign('a_form_preffix', 'bs_');
        ?>
        <hr width="100%">
      </td>
    </tr> 
   </table>
   </div>
  </td></tr>
<tr class="listheader"><td>
  <table width="100%" border=0>
   <tr>
      <td align=left colspan=2>
        <?php QUnit_Global::includeTemplate('filter_campaign.tpl.php'); ?>
      </td>
    </tr> 
    <tr>
      <td align=left colspan=2>
        <?php QUnit_Global::includeTemplate('filter_affiliate.tpl.php'); ?>
      </td>
    </tr> 
    <tr>
      <td>
        <table cellpadding="2" cellspacing="0" border="0">
        <tr><td valign=top width="150">&nbsp;<b><?php echo L_G_SORTBY?></b>&nbsp;<?php showQuickHelp(L_G_HLP_SORTYBY); ?><br></td>
            <td align=left>
            <select name="bs_sortby">
                <option value='unique_impressions_period' <?php echo ($_REQUEST['bs_sortby'] == 'unique_impressions_period') ? 'selected' : ''?>><?php echo L_G_IMPRESSIONSUNIQUE.' '.L_G_PERIOD?></option>
                <option value='unique_impressions_all' <?php echo ($_REQUEST['bs_sortby'] == 'unique_impressions_all') ? 'selected' : ''?>><?php echo L_G_IMPRESSIONSUNIQUE.' '.L_G_ALL2?></option>
                <option value='clicks_period' <?php echo ($_REQUEST['bs_sortby'] == 'clicks_period') ? 'selected' : ''?>><?php echo L_G_CLICKS.' '.L_G_PERIOD?></option>
                <option value='clicks_all' <?php echo ($_REQUEST['bs_sortby'] == 'clicks_all') ? 'selected' : ''?>><?php echo L_G_CLICKS.' '.L_G_ALL2?></option>
                <option value='ratio_period' <?php echo ($_REQUEST['bs_sortby'] == 'ratio_period') ? 'selected' : ''?>><?php echo L_G_RATIO.' '.L_G_PERIOD?></option>
                <option value='ratio_all' <?php echo ($_REQUEST['bs_sortby'] == 'ratio_all') ? 'selected' : ''?>><?php echo L_G_RATIO.' '.L_G_ALL2?></option>
                <option value='campaignname' <?php echo ($_REQUEST['bs_sortby'] == 'campaignname') ? 'selected' : ''?>><?php echo L_G_PRODUCT_CATEGORY?></option>
                <option value='destinationurl' <?php echo ($_REQUEST['bs_sortby'] == 'destinationurl') ? 'selected' : ''?>><?php echo L_G_DESTURL?></option>
                <option value='bannertype' <?php echo ($_REQUEST['bs_sortby'] == 'bannertype') ? 'selected' : ''?>><?php echo L_G_BANNERTYPE?></option>
                <option value='dateinserted' <?php echo ($_REQUEST['bs_sortby'] == 'dateinserted') ? 'selected' : ''?>><?php echo L_G_DATECREATED?></option>
                <option value='name' <?php echo ($_REQUEST['bs_sortby'] == 'name') ? 'selected' : ''?>><?php echo L_G_NAME2?></option>
                <option value='bannerid' <?php echo ($_REQUEST['bs_sortby'] == 'bannerid') ? 'selected' : ''?>><?php echo L_G_BANNERID?></option>
                <option value='bannercategory' <?php echo ($_REQUEST['bs_sortby'] == 'bannercategory') ? 'selected' : ''?>><?php echo L_G_BANNERCATEGORY?></option>
            </select>&nbsp;&nbsp;&nbsp;
            <select name="bs_sortorder">
                <option value='sort_asc'  <?php echo ($_REQUEST['bs_sortorder'] == 'sort_asc')  ? 'selected' : ''?>><?php echo L_G_ASCENDING?></option>
                <option value='sort_desc' <?php echo ($_REQUEST['bs_sortorder'] == 'sort_desc') ? 'selected' : ''?>><?php echo L_G_DESCENDING?></option>
            </select></td></tr>
        </table>
     </td>
   </tr>
   <tr>
      <td align=left colspan=2>
        <?php  $this->a_this->assign('a_timeselect_caption', '<b>'.L_G_BANNERSTATSPERIOD.'</b>');
            QUnit_Global::includeTemplate('filter_time.tpl.php'); ?>
      </td>
    </tr> 
   <tr>
     <td colspan=2 align=left>
      <input type=hidden name=filtered value=1>
      <input type=hidden name=list_page value="<?php echo $_REQUEST['list_page']?>">
      <input type=hidden name=md value='Affiliate_Merchants_Views_BannerManager'>
      <input type=submit class=formbutton value="<?php echo L_G_FILTER?>">
     </td>
   </tr>  
  </table>
</td></tr>
</table>
</form>
