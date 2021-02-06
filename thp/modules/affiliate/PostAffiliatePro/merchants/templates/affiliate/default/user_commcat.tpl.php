
    <form action=index_popup.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(2, L_G_CHANGECOMMCATEGORYLONG); ?> 
    <tr align=left>
        <td class=listresult colspan=2>
            <?php echo L_G_AFFILIATE?><br>
            <?php echo L_G_USERNAME;?>: <b><?php echo $_POST['uname']?></b>&nbsp;&nbsp;&nbsp;
            <?php echo L_G_CONTACTNAME;?>: <b><?php echo $_POST['name'].' '.$_POST['surname']?></b>
            <br><br>
        </td>
    </tr>    
    <tr class=listresult>
        <td class=listheader><b><?php echo L_G_CAMPAIGN?></b></td>
        <td class=listheader><b><?php echo L_G_COMMCATEGORY?></b></td>
    </tr>
<?php  
    while($data=$this->a_list_data->getNextRecord()) {
      if($this->a_Auth->getSetting('Aff_join_campaign') == '1'
          && $this->a_CampaignData[$data['campaignid']][SETTINGTYPEPREFIX_AFF_CAMP.'status'] == AFF_CAMP_PRIVATE
          && $this->a_AffiliateCategories[$data['campaignid']] == ''
        ) {
            continue;
      }
?>
    <tr>
        <td class=listresult>
        &nbsp;<?php echo $data['name'];?>&nbsp;
        </td>
        <td align=left class=listresultnocenter >
        <select name="affcategoryid<?php echo $data['campaignid'];?>">
            <option value=''><?php echo L_G_NO_CHANGE?></option>
<?php    
        // get categories for this campaign
        $viewCampaignManager = QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');
        foreach($this->a_campaignCategories[$data['campaignid']] as $cat) {
           echo '<option value="'.$cat['campcategoryid'].'" '.($cat['campcategoryid'] == $this->a_AffiliateCategories[$data['campaignid']] ? 'selected' : '').'>';
           $viewCampaignManager->drawCommissionOption($cat);
?>
                </option>
<?php    } ?>      
            </select>*
        </td>
    </tr>
    
<?php  } ?>      
    
    <tr>
        <td class=dir_form colspan=2 align=center>
            <input type=hidden name=commited value=yes>
            <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateManager'>
            <input type=hidden name=action value=<?php echo $_POST['action']?>>
            <input type=hidden name=aid value=<?php echo $_POST['aid']?>>
            <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
            <input type=submit class=formbutton value='<?php echo L_G_SUBMIT; ?>'>
        </td>
    </tr>
    </table>
    </form>

