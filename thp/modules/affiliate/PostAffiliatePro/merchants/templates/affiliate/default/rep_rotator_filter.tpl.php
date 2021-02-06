 <table border=0 width="780">
   <tr><td align=left>
        <?php echo L_G_ROTATORREPORT_DESCRIPTION?><br><br>
        </td>
   </tr>
</table>

  <form name=FilterForm id=FilterForm action=index.php method=post>
  <table class=listing border=0 cellspacing=0 cellpadding=3 width="780">
  <?php QUnit_Templates::printFilter(1, L_G_FILTER); ?>
  <tr class="listheader">
    <td>
      <table width=100% border=0 cellspacing=0 cellpading=0>
      <tr>
<?php  if (!$this->a_affPanel) { ?>
      <td align=left width=1% nowrap valign="top">
        <?php echo L_G_BANNER?>
      </td>
      <td align=left width=50% valign="top">&nbsp;
        <select name=rq_banner>
          <option value='_'><?php echo L_G_ALL?></option>
<?php        if (count($this->a_banners) != 0) { 
            foreach ($this->a_banners as $bannerID => $bannerData) { ?>
                <option value='<?php echo $bannerID?>' <?php echo ($_REQUEST['rq_banner'] == $bannerID ? 'selected' : '')?>><?php echo $bannerID.': '.$bannerData['name']?></option>
<?php          }
          } ?>          
      </select>&nbsp;&nbsp;
      </td>
<?php  } ?>
      </tr>
      </table>
    </td>
    </tr>
    <tr class="listheader">
      <td align=left>
        <?php QUnit_Global::includeTemplate('filter_time.tpl.php') ?>
      </td>
    </tr>
    <tr class="listheader">
      <td align=left>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_RotatorReport'>
      <input class=formbutton type=submit value='<?php echo L_G_APPLYFILTER?>'>      
      </form>
      </td>
    </tr>
  </table>
  </form>
  <br>
  
  <?php if ($this->a_no_data == 1) { ?>
    <?php echo L_G_NOBANNERS?>
  <?php } ?>

