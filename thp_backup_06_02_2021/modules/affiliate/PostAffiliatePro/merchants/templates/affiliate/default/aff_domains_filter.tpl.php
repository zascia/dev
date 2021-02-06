
    <form name=FilterForm action=index.php method=get>
    <table class=listing border=0 cellspacing=0>
    <?php QUnit_Templates::printFilter(2, L_G_FILTER); ?>
    <tr>
      <td>&nbsp;<?php echo L_G_AFFILIATE?>&nbsp;</td>
      <td>
        <select name=ad_affiliate>
          <option value='_'><?php echo L_G_ALL?></option>
          <?php while($data=$this->a_list_data->getNextRecord()) { ?>
            <option value='<?php echo $data['userid']?>' <?php echo ($_REQUEST['ad_affiliate'] == $data['userid'] ? 'selected' : '');?>><?php echo $data['name'].' '.$data['surname']?></option>
          <?php } ?>
        </select>&nbsp;
      </td>
    </tr>
    <tr>
      <td>&nbsp;<?php echo L_G_STATUS?>&nbsp;</td>
      <td>
        <select name=ad_status>
          <option value='_'><?php echo L_G_ALLSTATES?></option>
          <option value=<?php echo AFFSTATUS_NOTAPPROVED?> <?php print ($_REQUEST['ad_status'] == AFFSTATUS_NOTAPPROVED ? 'selected' : '');?>><?php echo L_G_WAITINGAPPROVAL?></option>
          <option value=<?php echo AFFSTATUS_APPROVED?> <?php print ($_REQUEST['ad_status'] == AFFSTATUS_APPROVED ? 'selected' : '');?>><?php echo L_G_APPROVED?></option>
          <option value=<?php echo AFFSTATUS_SUPPRESSED?> <?php print ($_REQUEST['ad_status'] == AFFSTATUS_SUPPRESSED ? 'selected' : '');?>><?php echo L_G_SUPPRESSED?></option>
        </select>&nbsp;
      </td>
    </tr>
    <tr>
      <td colspan=2 align=center>&nbsp;<input type=submit class=formbutton value='Search'>&nbsp;</td>
        <input type=hidden name=commited value='yes'>
        <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateDomains'>
        <input type=hidden id=action name=action value=''>
        <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
        <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">
    </tr>
    <tr>
      <td colspan=2>&nbsp;</td>
    </tr>
    </table>

    <br>
