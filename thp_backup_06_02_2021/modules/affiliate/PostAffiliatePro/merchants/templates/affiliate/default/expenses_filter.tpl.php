<script>
function addExpense()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ExpensesManager&action=create&type=all"+"&<?php echo SID?>","Expense","scrollbars=1, top=100, left=100, width=500, height=500, status=0");
    wnd.focus(); 
}
</script>
<form name=FilterForm id=FilterForm action=index.php method=get>
    <table class=listing border=0 width=600 cellspacing=0>
    <?php QUnit_Templates::printFilter(10); ?>
    <tr>
      <td width=1% nowrap>&nbsp;<?php echo L_G_AFFILIATE?>&nbsp;</td>
      <td>
      <select name=exp_affiliateid>
        <option value="_"><?php echo L_G_ALL?></option>
<?php    while($data=$this->a_list_users->getNextRecord()) { ?>
        <option value="<?php echo $data['userid']?>" <?php echo ($_REQUEST['exp_affiliateid'] == $data['userid'] ? 'selected' : '')?>><?php echo (($data['name']!='' || $data['surname']!='') ? $data['name'].' '.$data['surname'] : $data['username'])?></option>
<?php    } ?>      
      </select>
      </td>
      <td align=left><?php echo L_G_PCNAME?></td>
      <td align=left>
        <select name=exp_campaign>
          <option value='_'><?php echo L_G_ALL?></option>
<?php      while($data=$this->a_list_campaings->getNextRecord()) { ?>
          <option value='<?php echo $data['campaignid']?>' <?php echo ($_REQUEST['exp_campaign'] == $data['campaignid'] ? 'selected' : '')?>><?php echo $data['name']?></option>
<?php      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
    <tr>
        <td>&nbsp;<?php echo L_G_CHANNEL?>&nbsp;</td>
        <td><input type=text name=exp_channel size=10 value="<?php echo $_REQUEST['exp_channel']?>"></td>
        <td>&nbsp;<?php echo L_G_EPISODE?>&nbsp;</td>
        <td><input type=text name=exp_episode size=10 value="<?php echo $_REQUEST['exp_episode']?>"></td>
    </tr>
    <tr>
        <td>&nbsp;<?php echo L_G_TIMESLOT?>&nbsp;</td>
       <td><input type=text name=exp_timeslot size=10 value="<?php echo $_REQUEST['exp_timeslot']?>"></td>
        <td>&nbsp;<?php echo L_G_EXIT?>&nbsp;</td>
       <td><input type=text name=exp_exit size=10 value="<?php echo $_REQUEST['exp_exit']?>"></td>
    </tr>
    <tr>
      <td colspan=4 nowrap>&nbsp;<?php echo L_G_FROM?>&nbsp;
      <?php
        print L_G_DAY;
        echo "&nbsp;<select name=exp_day1>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['exp_day1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select name=exp_month1>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['exp_month1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select name=exp_year1>";
        for($i=PAP_STARTING_YEAR; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['exp_year1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>
      &nbsp;&nbsp;&nbsp;<?php echo L_G_TO?>&nbsp;
      <?php
        print L_G_DAY;
        echo "&nbsp;<select name=exp_day2>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['exp_day2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select name=exp_month2>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['exp_month2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select name=exp_year2>";
        for($i=PAP_STARTING_YEAR; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['exp_year2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>      
      </td>
    </tr>
    <tr>
      <td align=left nowrap>&nbsp;<?php echo L_G_ROWSPERPAGE?></td>
      <td>&nbsp;
      <select name=numrows onchange="javascript:FilterForm.list_page.value=0;">
        <option value=10 <?php print ($_REQUEST['numrows']==10 ? "selected" : ""); ?>>10</option>
        <option value=20 <?php print ($_REQUEST['numrows']==20 ? "selected" : ""); ?>>20</option>
        <option value=30 <?php print ($_REQUEST['numrows']==30 ? "selected" : ""); ?>>30</option>
        <option value=50 <?php print ($_REQUEST['numrows']==50 ? "selected" : ""); ?>>50</option>
        <option value=100 <?php print ($_REQUEST['numrows']==100 ? "selected" : ""); ?>>100</option>
        <option value=200 <?php print ($_REQUEST['numrows']==200 ? "selected" : ""); ?>>200</option>
        <option value=500 <?php print ($_REQUEST['numrows']==500 ? "selected" : ""); ?>>500</option>
        <option value=1000 <?php print ($_REQUEST['numrows']==1000 ? "selected" : ""); ?>>1000</option>
        <option value=100000000 <?php print ($_REQUEST['numrows']==100000000 ? "selected" : ""); ?>><?php echo L_G_ALL?></option>
      </select>
      </td>
    </tr>       
    <tr>
      <td colspan=4 width=50% align=center>&nbsp;<input type=submit class=formbutton value='Search'></td>
    </tr>
    <tr>
      <td colspan=4>&nbsp;</td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_ExpensesManager'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">

<br>
