<script>
function selectAffiliate(selectID, event)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateSelect&selectForm=FilterForm&selectID="+selectID,"Affiliate",
	           "scrollbars=1, top="+event.screenY+", left="+event.screenX+", width=350, height=210, status=0");
    wnd.focus();
}
</script>
    
    <table border=0 cellspacing=0 cellpadding=2 width=780>
    <tr><td><?php echo L_G_TRANSACTION_EDIT_DESCRIPTION?></td></tr>
    </table>
    <br><br>
    
    <form id="FilterForm" name="FilterForm" action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_STATUS;?></b>&nbsp;<?php showQuickHelp(L_G_HLP_TRANSACTION_STATUS); ?></td>
      <td>
        <select name=rstatus>
        <?php
          if($_POST['rstatus'] == '') $_POST['rstatus'] = AFFSTATUS_APPROVED;
          echo "<option value=\"".AFFSTATUS_NOTAPPROVED."\" ".($_POST['rstatus'] == AFFSTATUS_NOTAPPROVED ? ' selected' : '').">".L_G_WAITINGAPPROVAL."</option>\n";
          echo "<option value=\"".AFFSTATUS_APPROVED."\" ".($_POST['rstatus'] == AFFSTATUS_APPROVED ? 'selected' : '').">".L_G_APPROVED."</option>\n";
          echo "<option value=\"".AFFSTATUS_SUPPRESSED."\" ".($_POST['rstatus'] == AFFSTATUS_SUPPRESSED ? 'selected' : '').">".L_G_SUPPRESSED."</option>\n";
        ?>
        </select>*&nbsp;
      </td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_TRANSTYPE;?></b>&nbsp;<?php showQuickHelp(L_G_HLP_TRANSACTION_TYPE); ?></td>
      <td>
        <select name=transtype>
        <?php
          if($_POST['transtype'] == '') $_POST['transtype'] = TRANSTYPE_CLICK;
          echo "<option value=\"".TRANSTYPE_CLICK."\" ".($_POST['transtype'] == TRANSTYPE_CLICK ? "selected" : "").">".L_G_CLICK."</option>\n";
          echo "<option value=\"".TRANSTYPE_LEAD."\" ".($_POST['transtype'] == TRANSTYPE_LEAD ? "selected" : "").">".L_G_LEAD."</option>\n";
          echo "<option value=\"".TRANSTYPE_SALE."\" ".($_POST['transtype'] == TRANSTYPE_SALE ? "selected" : "").">".L_G_SALE."</option>\n";
          echo "<option value=\"".TRANSTYPE_RECURRING."\" ".($_POST['transtype'] == TRANSTYPE_RECURRING ? "selected" : "").">".L_G_TYPE_RECURRING."</option>\n";
          echo "<option value=\"".TRANSTYPE_SIGNUP."\" ".($_POST['transtype'] == TRANSTYPE_SIGNUP ? "selected" : "").">".L_G_TYPE_SIGNUP."</option>\n";
          echo "<option value=\"".TRANSTYPE_CPM."\" ".($_POST['transtype'] == TRANSTYPE_CPM ? "selected" : "").">".L_G_CPM."</option>\n";
          echo "<option value=\"".TRANSTYPE_REFERRAL."\" ".($_POST['transtype'] == TRANSTYPE_REFERRAL ? "selected" : "").">".L_G_REFERRAL."</option>\n";
          echo "<option value=\"".TRANSTYPE_REFUND."\" ".($_POST['transtype'] == TRANSTYPE_REFUND ? "selected" : "").">".L_G_REFUND."</option>\n";
          echo "<option value=\"".TRANSTYPE_CHARGEBACK."\" ".($_POST['transtype'] == TRANSTYPE_CHARGEBACK ? "selected" : "").">".L_G_CHARGEBACK."</option>\n";
        ?>
        </select>*&nbsp;
      </td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_TRANSKIND;?></b>&nbsp;<?php showQuickHelp(L_G_HLP_TRANSACTION_KIND); ?></td>
      <td>
        <select name=transkind>
        <?php
          if($_POST['transkind'] == '') $_POST['transkind'] = TRANSKIND_NORMAL;
          echo "<option value=\"".TRANSKIND_NORMAL."\" ".($_POST['transkind'] == TRANSKIND_NORMAL ? "selected" : "").">".L_G_NORMAL."</option>\n";
          echo "<option value=\"".TRANSKIND_RECURRING."\" ".($_POST['transkind'] == TRANSKIND_RECURRING ? "selected" : "").">".L_G_TYPE_RECURRING."</option>\n";
          for($i=2; $i <= (($this->a_Auth->getSetting('Aff_maxcommissionlevels') != '') ? $this->a_Auth->getSetting('Aff_maxcommissionlevels') : 10); $i++)
            echo "<option value=\"".(TRANSKIND_SECONDTIER+$i)."\" ".($_POST['transkind'] == (TRANSKIND_SECONDTIER+$i) ? "selected" : "").">".$i." ".L_G_TIER."</option>\n";
        ?>
        </select>*&nbsp;
      </td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_PAYOUT_STATUS;?></b>&nbsp;<?php showQuickHelp(L_G_HLP_PAYOUT_STATUS); ?></td>
      <td>
        <select name=payoutstatus>
        <?php
          if($_POST['payoutstatus'] == '') $_POST['payoutstatus'] = AFFSTATUS_APPROVED;
          echo "<option value=\"".AFFSTATUS_NOTAPPROVED."\" ".($_POST['payoutstatus'] == AFFSTATUS_NOTAPPROVED ? ' selected' : '').">".L_G_WAITINGAPPROVAL."</option>\n";
          echo "<option value=\"".AFFSTATUS_APPROVED."\" ".($_POST['payoutstatus'] == AFFSTATUS_APPROVED ? ' selected' : '').">".L_G_APPROVED."</option>\n";
          echo "<option value=\"".AFFSTATUS_SUPPRESSED."\" ".($_POST['payoutstatus'] == AFFSTATUS_SUPPRESSED ? ' selected' : '').">".L_G_SUPPRESSED."</option>\n";
        ?>
        </select>*&nbsp;
      </td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_TOTAL_COST;?></b>&nbsp;<?php showQuickHelp(L_G_HLP_TOTALCOST); ?></td>
      <td><input type=text name=totalcost size=8 value="<?php echo $_POST['totalcost']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_REFERRER_URL;?></b>&nbsp;<?php showQuickHelp(L_G_HLP_REFERRERURL); ?></td>
      <td><input type=text name=refererurl size=44 value="<?php echo $_POST['refererurl']?>">&nbsp;</td>
    </tr>
    <tr>
      <td><?php $name = 'affiliate';
             $_REQUEST['affiliate'] = $_POST['affiliate']; ?>
          &nbsp;<b><?php echo L_G_AFFILIATE?>&nbsp;<?php showQuickHelp(L_G_HLP_AFFILIATE); ?></b><br>
          <a href="javascript:;" class="simplelink" onclick="javascript:selectAffiliate('<?php echo $name?>', event);">
          <img src="<?php echo $this->a_this->getImage('user_select.png')?>" title="<?php echo L_G_SELECTAFFILIATE?>" alt="<?php echo L_G_SELECTAFFILIATE?>" align="absmiddle"><?php echo L_G_SELECTAFFILIATE?></a>
      </td>
      <td>
            <select name="<?php echo $name?>" id="<?php echo $name?>">
            <?php while($data=$this->a_list_users->getNextRecord()) { ?>
                <option value="<?php echo $data['userid']?>" <?php echo ($_REQUEST[$name] == $data['userid'] ? 'selected' : '')?>>
                <?php echo $data['userid'].': '.(($data['name']!='' || $data['surname']!='') ? $data['surname'].' '.$data['name'] : $data['username'])?>
                <?php echo $data['rstatus']==AFFSTATUS_NOTAPPROVED ? ' - '.strtoupper(L_G_PENDING) : ''?>
                <?php echo $data['rstatus']==AFFSTATUS_SUPPRESSED ? ' - '.strtoupper(L_G_SUPPRESSED) : ''?>
                </option>
            <?php } ?>      
            </select>
      </td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_PARENTTRANS;?></b>&nbsp;<?php showQuickHelp(L_G_HLP_TRANSACTION_PARENT); ?></td>
      <td><input type=text name=parenttrans size=6 value="<?php echo $_POST['parenttrans']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_COMMISSION;?></b>&nbsp;<?php showQuickHelp(L_G_HLP_COMMISSION); ?></td>
      <td>
          <?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
          ?>
          <input type=text name=commission size=6 value="<?php echo $_POST['commission']?>">
          <?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
               print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
             print '*&nbsp';
          ?>
      </td>  
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_IP;?></b>&nbsp;</td>
      <td><input type=text name=ip size=15 value="<?php echo $_POST['ip']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_PRODUCTID;?></b>&nbsp;</td>
      <td><input type=text name=productid size=44 value="<?php echo $_POST['productid']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_EXTRA_FIELD;?>1</b>&nbsp;</td>
      <td><input type=text name=data1 size=44 value="<?php echo $_POST['data1']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_EXTRA_FIELD;?>2</b>&nbsp;</td>
      <td><input type=text name=data2 size=44 value="<?php echo $_POST['data2']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_EXTRA_FIELD;?>3</b>&nbsp;</td>
      <td><input type=text name=data3 size=44 value="<?php echo $_POST['data3']?>">&nbsp;</td>
    </tr>

    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_TransactionManager'>
      <input type=hidden name=action value=<?php echo $_POST['action']?>>
      <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
      <input type=hidden name=tid value=<?php echo $_POST['tid']?>>
      <input type=submit class=formbutton value='<?php echo L_G_SUBMIT; ?>'>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    </table>
    </form>
