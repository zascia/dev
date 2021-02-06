
<center>
  <form action=index.php method=post>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <?php QUnit_Templates::printFilter(3, L_G_CREATEEXPENSE); ?>
    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_FOR?> <?php echo L_G_AFFILIATE?></td>
     <td align=left>
        <select name=userid>
<?php      while($data=$this->a_list_data2->getNextRecord()) { ?>
          <option value='<?php echo $data['userid']?>' <?php echo ($_REQUEST['userid'] == $data['userid'] ? 'selected' : '')?>
                ><?php echo (($data['name'] || $data['surname']) ? $data['name'].' '.$data['surname'] : $data['username'])?></option>
<?php      } ?>
      </select>
     </td>
    </tr>   
    
    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_FOR?> <?php echo L_G_CAMPAIGN?></td>
     <td align=left>
        <select name=campaignid>
<?php      while($data=$this->a_list_data1->getNextRecord()) { ?>
          <option value='<?php echo $data['campaignid']?>' <?php echo ($_REQUEST['campaignid'] == $data['campaignid'] ? 'selected' : '')?>><?php echo $data['name']?></option>
<?php      } ?>          
      </select>    
     </td>
    </tr>   

    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_TOTALEXPENSE?></td>
     <td align=left>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
        <input type=text name=totalexpense size=6 value='<?php echo $_POST['totalexpense']?>'>
        <?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
             print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
     </td>
    </tr>      

    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_CHANNEL?></td>
     <td align=left>
        <input type=text name=channel size=30 value='<?php echo $_POST['channel']?>'>
     </td>
    </tr>      
    
    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_EPISODE?></td>
     <td align=left>
        <input type=text name=episode size=30 value='<?php echo $_POST['episode']?>'>
     </td>
    </tr>      

    <tr>
     <td align=left nowrap>&nbsp;<?php echo L_G_TIMESLOT?></td>
     <td align=left>
        <input type=text name=timeslot size=30 value='<?php echo $_POST['timeslot']?>'>
     </td>
    </tr>      
    
    <tr>
      <td align="left">&nbsp;<?php echo L_G_PURCHASEDATE?>&nbsp;</td>
      <td align="left">
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
      </td>
      </tr>
      <tr>
      <td align="left">&nbsp;<?php echo L_G_EXPENSEDATE?>&nbsp;</td>
      <td align="left"><?php
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
      <td colspan=2>&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_ExpensesManager'>
      <input type=hidden name=action value='create'>
      <input type=hidden name=postaction value='create'>
      <input class=formbutton type=submit value="<?php echo L_G_CREATE?>">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
