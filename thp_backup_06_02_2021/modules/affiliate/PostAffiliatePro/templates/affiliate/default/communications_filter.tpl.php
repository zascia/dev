
    <form name=FilterForm action=index.php method=post>
    <table class=listing border=0 width=600 cellspacing=0>
    <?php QUnit_Templates::printFilter(4); ?>
    <tr>
      <td width=1% nowrap>&nbsp;<?php echo L_G_TITLE?>&nbsp;</td>
      <td nowrap>&nbsp;<input type=text name=c_title size=35 value="<?php echo $_REQUEST['c_title']?>"></td>
      <td width=1% nowrap>&nbsp;<?php echo L_G_MESSAGE_TEXT?>&nbsp;</td>
      <td nowrap>&nbsp;<input type=text name=c_text size=35 value="<?php echo $_REQUEST['c_text']?>"></td>
    </tr>
    <tr>
      <td width=1% nowrap>&nbsp;<?php echo L_G_EMAIL?>&nbsp;</td>
      <td nowrap>&nbsp;<input type=text name=c_email size=35 value="<?php echo $_REQUEST['c_email']?>"></td>
      <?php if (($this->a_md == 'Affiliate_Merchants_Views_Communications') && ($this->a_Auth->getSetting('Aff_display_news') == '1')) { ?>
        <td width=1% nowrap>&nbsp;<?php echo L_G_HISTORYTYPE?>&nbsp;</td>
       	<td nowrap>&nbsp;
       		<select name=c_type>	
          		<option value='_'><?php echo L_G_ALL?></option>
	       		<option value=<?php echo MESSAGETYPE_EMAIL?> <?php print ($_REQUEST['c_type'] == MESSAGETYPE_EMAIL ? 'selected' : '');?>><?php echo L_G_EMAIL?></option>
           		<option value=<?php echo MESSAGETYPE_NEWS?> <?php print ($_REQUEST['c_type'] == MESSAGETYPE_NEWS ? 'selected' : '');?>><?php echo L_G_NEWS?></option>
       		</select>
       	</td>
      <?php } elseif (($this->a_md == 'AffEnt_SuperAdmins_Views_Communications') && ($this->a_Auth->getSetting('Merch_display_news') == '1')) { ?>
      	<td width=1% nowrap>&nbsp;<?php echo L_G_HISTORYTYPE?>&nbsp;</td>
       	<td nowrap>&nbsp;
       		<select name=c_type>	
          		<option value='_'><?php echo L_G_ALL?></option>
	       		<option value=<?php echo SA_MESSAGETYPE_EMAIL?> <?php print ($_REQUEST['c_type'] == SA_MESSAGETYPE_EMAIL ? 'selected' : '');?>><?php echo L_G_EMAIL?></option>
           		<option value=<?php echo SA_MESSAGETYPE_NEWS?> <?php print ($_REQUEST['c_type'] == SA_MESSAGETYPE_NEWS ? 'selected' : '');?>><?php echo L_G_NEWS?></option>
       		</select>
       	</td>
  	  <?php } else { ?>
       	<td colspan=2 nowrap>&nbsp;</td>
      <?php } ?>
    </tr>
    <tr>
      <td align=left>&nbsp;<?php echo L_G_FROM?>&nbsp;</td>
      <td colspan=3>&nbsp;
      <?php
        print L_G_DAY;
        echo "&nbsp;<select name=c_day1>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['c_day1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select name=c_month1>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['c_month1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select name=c_year1>";
        for($i=PAP_STARTING_YEAR; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['c_year1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>
      &nbsp;&nbsp;&nbsp;<?php echo L_G_TO?>&nbsp;
      <?php
        print L_G_DAY;
        echo "&nbsp;<select name=c_day2>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['c_day2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select name=c_month2>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['c_month2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select name=c_year2>";
        for($i=PAP_STARTING_YEAR; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['c_year2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>      
      </td>
    </tr>
    <tr><td align=left nowrap>&nbsp;<?php echo L_G_ROWSPERPAGE?></td>
      <td colspan=3>&nbsp;
      <select name=c_numrows onchange="javascript:FilterForm.list_page.value=0;">
        <option value=10 <?php print ($_REQUEST['c_numrows']==10 ? "selected" : ""); ?>>10</option>
        <option value=20 <?php print ($_REQUEST['c_numrows']==20 ? "selected" : ""); ?>>20</option>
        <option value=30 <?php print ($_REQUEST['c_numrows']==30 ? "selected" : ""); ?>>30</option>
        <option value=50 <?php print ($_REQUEST['c_numrows']==50 ? "selected" : ""); ?>>50</option>
        <option value=100 <?php print ($_REQUEST['c_numrows']==100 ? "selected" : ""); ?>>100</option>
        <option value=200 <?php print ($_REQUEST['c_numrows']==200 ? "selected" : ""); ?>>200</option>
        <option value=500 <?php print ($_REQUEST['c_numrows']==500 ? "selected" : ""); ?>>500</option>
        <option value=1000000 <?php print ($_REQUEST['c_numrows']==1000000 ? "selected" : ""); ?>><?php echo L_G_ALL?></option>
      </select>
      </td>
    </tr>        
    <tr>
      <td align=center colspan=4>&nbsp;<input class="formbutton" type=submit value='Search'><br>&nbsp;</td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='<?php echo $this->a_md?>'>
    <input type=hidden id=action name=action value=''>
    <input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>      
    <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">

<br>
