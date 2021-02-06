<script>
function editRule(ID)
{
    document.myForm.editrid.value = ID;
    document.myForm.submit();
}

function deleteRule(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETERULE?>"))
  {
    document.myForm.rid.value = ID;
    document.myForm.action.value = 'deleteRule';
    document.myForm.postaction.value = '';
    document.myForm.submit();
  }
}

function moveRule(ID, direction)
{
  document.myForm.rid.value = ID;
  document.myForm.direction.value = direction;
  document.myForm.action.value = 'moveRule';
  document.myForm.postaction.value = '';
  document.myForm.submit();
}

</script>
    <table border=0 cellspacing=0 cellpadding=3 width="100%">
      <tr class="detailrow0">
        <td class=formBText valign=top nowrap><?php echo L_G_PUT_AFFILIATE_SPECIAL_CATEGORY;?>&nbsp;</td>
        <td valign=top width="70%">
          <select class="forminput" name=cond_action_value>
          <?php if(is_array($this->a_campaigns))
               foreach($this->a_campaigns as $key => $value) {
          ?>
                 <option value='<?php echo $key?>' <?php echo ($_POST['cond_action_value'] == $key ? ' selected' : '')?>><?php echo ((($value == UNASSIGNED_USERS) && defined($value)) ? constant($value) : $value)?></option>
          <?php } ?>
          </select>
          <input type=hidden name=cond_action value='L_G_PUT_AFFILIATE_SPECIAL_CATEGORY'>
        </td>
      </tr>
      <tr class="detailrow0">
        <td class=formBText valign=top nowrap><?php echo L_G_WHEN;?></td>
        <td valign=top>
          <select class="forminput" name=cond_when>
            <option value='<?php echo RULE_NUMBER_OF_SALES?>' <?php echo $_POST['cond_when'] == RULE_NUMBER_OF_SALES ? 'selected' : ''?>><?php echo L_G_NUMBER_OF_SALES?></option>
            <option value='<?php echo RULE_AMOUNT_OF_COMMISSIONS?>' <?php echo $_POST['cond_when'] == RULE_AMOUNT_OF_COMMISSIONS ? 'selected' : ''?>><?php echo L_G_AMOUNT_OF_COMMISSIONS?></option>
            <option value='<?php echo RULE_AMOUNT_OF_TOTAL_COST?>' <?php echo $_POST['cond_when'] == RULE_AMOUNT_OF_TOTAL_COST ? 'selected' : ''?>><?php echo L_G_AMOUNT_OF_TOTAL_COST?></option>
          </select>
        </td>
      </tr>
      <tr class="detailrow0">
        <td class=formBText valign=top nowrap><?php echo L_G_IN;?></td>
        <td valign=top>
          <select class="forminput" name=cond_in>
            <option value='<?php echo RULE_ACTUAL_MONTH?>' <?php echo $_POST['cond_in'] == RULE_ACTUAL_MONTH ? 'selected' : ''?>><?php echo L_G_ACTUAL_MONTH?></option>
            <option value='<?php echo RULE_ACTUAL_YEAR?>' <?php echo $_POST['cond_in'] == RULE_ACTUAL_YEAR ? 'selected' : ''?>><?php echo L_G_ACTUAL_YEAR?></option>
            <option value='<?php echo RULE_LAST_WEEK?>' <?php echo $_POST['cond_in'] == RULE_LAST_WEEK ? 'selected' : ''?>><?php echo L_G_LAST_WEEK?></option>
            <option value='<?php echo RULE_LAST_TWOWEEKS?>' <?php echo $_POST['cond_in'] == RULE_LAST_TWOWEEKS ? 'selected' : ''?>><?php echo L_G_LAST_TWO_WEEKS?></option>
            <option value='<?php echo RULE_LAST_MONTH?>' <?php echo $_POST['cond_in'] == RULE_LAST_MONTH ? 'selected' : ''?>><?php echo L_G_LAST_MONTH?></option>
            <option value='<?php echo RULE_LAST_YEAR?>' <?php echo $_POST['cond_in'] == RULE_LAST_YEAR ? 'selected' : ''?>><?php echo L_G_LAST_YEAR?></option>
            <option value='<?php echo RULE_ALL?>' <?php echo $_POST['cond_in'] == RULE_ALL ? 'selected' : ''?>><?php echo L_G_ALL?></option>
          </select>
        </td>
      </tr>
      <tr class="detailrow0">
        <td class=formBText valign=top nowrap><input type=radio name=cond_is_type value='<?php echo RULE_IS?>' checked>&nbsp;<?php echo L_G_IS;?></td>
        <td class=formBText valign=top>
          <select class="forminput" name=cond_is>
            <option value='<?php echo RULE_LOWER?>' <?php echo $_POST['cond_is'] == RULE_LOWER ? 'selected' : ''?>><?php echo L_G_LOWER?></option>
            <option value='<?php echo RULE_HIGHER?>' <?php echo $_POST['cond_is'] == RULE_HIGHER ? 'selected' : ''?>><?php echo L_G_HIGHER?></option>
          </select>
          &nbsp;<?php echo strtolower(L_G_THAN)?>&nbsp;<input class="forminput" type=text name='cond_value1' value=<?php echo $_POST['cond_value1']?>>
        </td>
      </tr>
      <tr class="detailrow0">
        <td class=formBText valign=top nowrap><input type=radio name=cond_is_type value='<?php echo RULE_IS_BETWEEN?>' <?php echo ($_POST['cond_is_type'] == RULE_IS_BETWEEN ? ' checked' : '')?>>&nbsp;<?php echo L_G_IS_BETWEEN;?></td>
        <td class=formBText><input type=text class="forminput" name='cond_value2' value=<?php echo $_POST['cond_value2']?>>
          &nbsp;<?php echo L_G_AND?>&nbsp;<input class="forminput" type=text name='cond_value3' value=<?php echo $_POST['cond_value3']?>>
        </td>
      </tr>
      <tr class="detailrow0">
        <td align=center>
            <input type="hidden" name="saveRule" id="saveRule" value="0">
            <input class="formbutton" type=submit value='<?php echo L_G_SAVE_RULE?>' onclick="javascript: document.myForm.saveRule.value='1'"></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="detailrow0">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>

    <table class=listingBorderTopRight border=0 cellspacing=0 cellpadding=2 width="100%">
      <tr class="detailrow1">
        <td class="listresultNoCenter formBText" colspan=7>&nbsp;<?php echo L_G_LISTOFRULES?>&nbsp;</td>
      </tr>
<?php
    $i = 0;
    $j = 0;
    while($data=$this->a_list_data->getNextRecord())
    {
?>

      <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
        <td class=listresultNoRightLine align=center nowrap>&nbsp;<?php if(defined($data['cond_action'])) eval("echo ".$data['cond_action'].";"); else echo $data['cond_action'];?></td>
        <td class=listresultNoRightLine align=center nowrap>&nbsp;<?php echo (defined($data['special_campaign_name']) ? constant($data['special_campaign_name']) : $data['special_campaign_name'])?></td>
        <td class=listresultNoRightLine align=center nowrap>&nbsp;<?php echo strtolower(L_G_WHEN).'&nbsp;';?>
        	<?php
            if($data['cond_when'] == RULE_NUMBER_OF_SALES) print L_G_NUMBER_OF_SALES;
            else if($data['cond_when'] == RULE_AMOUNT_OF_COMMISSIONS) print L_G_AMOUNT_OF_COMMISSIONS;
            else if($data['cond_when'] == RULE_AMOUNT_OF_TOTAL_COST) print L_G_AMOUNT_OF_TOTAL_COST;
          ?></td>
        <td class=listresultNoRightLine align=center nowrap><?php
            if($data['cond_in'] == RULE_ACTUAL_MONTH) print '&nbsp;'.strtolower(L_G_IN).'&nbsp;'.L_G_ACTUAL_MONTH;
            else if($data['cond_in'] == RULE_ACTUAL_YEAR) print '&nbsp;'.strtolower(L_G_IN).'&nbsp;'.L_G_ACTUAL_YEAR;
            else if($data['cond_in'] == RULE_LAST_WEEK) print '&nbsp;'.strtolower(L_G_IN).'&nbsp;'.L_G_LAST_WEEK;
            else if($data['cond_in'] == RULE_LAST_TWOWEEKS) print '&nbsp;'.strtolower(L_G_IN).'&nbsp;'.L_G_LAST_TWO_WEEKS;
            else if($data['cond_in'] == RULE_LAST_MONTH) print '&nbsp;'.strtolower(L_G_IN).'&nbsp;'.L_G_LAST_MONTH;
            else if($data['cond_in'] == RULE_LAST_YEAR) print '&nbsp;'.strtolower(L_G_IN).'&nbsp;'.L_G_LAST_YEAR;
            //else if($data['cond_in'] == RULE_ALL) print L_G_ALL;
          ?></td>
        <td class=listresultNoRightLine align=center nowrap>&nbsp;<?php
            if($data['cond_is_type'] == RULE_IS) {
                print strtolower(L_G_IS).'&nbsp;';
                if($data['cond_is'] == RULE_LOWER) print L_G_LOWER;
                else if($data['cond_is'] == RULE_HIGHER) print L_G_HIGHER;
            }
            else if($data['cond_is_type'] == RULE_IS_BETWEEN) {
                print strtolower(L_G_IS_BETWEEN).'&nbsp;';
            }
          ?></td>
        <td class=listresult align=center nowrap>&nbsp;<?php
            if($data['cond_is_type'] == RULE_IS) {
                print strtolower(L_G_THAN).' '.$data['cond_value1'];
            }
            else {
                print $data['cond_value1'].' '.L_G_AND.' '.$data['cond_value2'];
            }
          ?></td>
        <td class="listresult">
        <?php
            $actions = array();
            $actions[0] = array('id'     => 'edit',
                                'img'    => 'icon_edit.gif',
                                'desc'   => L_G_EDIT,
                                'action' => "editRule('".$data['ruleid']."');" );
            $actions[1] = array('id'     => 'delete',
                                'img'    => 'icon_delete.gif',
                                'desc'   => L_G_DELETE,
                                'action' => "deleteRule('".$data['ruleid']."');" );
            if ($j>0) {                                   
                $actions[2] = array('id'     => 'moveup',
                                    'img'    => 'sort_up.gif',
                                    'desc'   => L_G_MOVEUP,
                                    'action' => "moveRule('".$data['ruleid']."', '-1');" );
            }
            if ($j < $this->a_numrows-1) {
                $actions[3] = array('id'     => 'movedown',
                                    'img'    => 'sort_down.gif',
                                    'desc'   => L_G_MOVEDOWN,
                                    'action' => "moveRule('".$data['ruleid']."', '1');" );
            }
            $this->assign('a_actions', $actions);
            $this->assign('a_action_count', 4);

            QUnit_Global::includeTemplate('actions_icon.tpl.php');
        ?>
        </td>
      </tr>
<?php  $j++;
    } ?>
    </table>
    <input type=hidden name=rid id=rid value='<?php echo $_POST['ruleid']?>'>
    <input type=hidden name=direction id=direction value=''>
    <input type=hidden name=editrid id=editrid value=''>