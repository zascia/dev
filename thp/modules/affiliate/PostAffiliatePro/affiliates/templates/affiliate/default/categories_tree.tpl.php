
<table border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printPath($this->a_parents_data, 'index.php?md=Affiliate_Affiliates_Views_AffCampaignBrowserNetwork&action=showtree&r=', 1, L_G_CATEGORIES); ?>
  <tr>
    <td>
      <table border=0 cellspacing=0 cellpadding=2>
      <?php if($this->a_root_data != '' && $this->a_treeData_count > 0) { ?>
        <tr>
          <td align=left nowrap><b><?php echo L_G_SUBCATEGORIES?></b></td>
        </tr>
      <?php } ?>
        <tr>
          <td align=left nowrap>
          <?php
            while($data=$this->a_list_data->getNextRecord())
            {
              if((int)$data['level'] > 2 || (int)$this->a_evaluatedNodes[$data['catid']] <= 0) continue;
              else if((int)$data['level'] == 1)
              {
                $i = 0;
          ?>
            </td>
          </tr>
          <tr>
            <td align=left nowrap>&nbsp;<a href="index.php?md=Affiliate_Affiliates_Views_AffCampaignBrowserNetwork&action=showtree&r=<?php echo $data['catid']?>"><b><?php echo $data['name']?></b></a>&nbsp;</td>
          </tr>
          <tr>
            <td align=left nowrap>
          <?php
              }
              else
              {
                $i++;
                if($i == 4) print '&nbsp;...';
                else if($i < 4) {
                  print '&nbsp;<a href="index.php?md=Affiliate_Affiliates_Views_AffCampaignBrowserNetwork&action=showtree&r='.$data['catid'].'">'.$data['name'].'</a>&nbsp;';
                }
              }
            }
          ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
