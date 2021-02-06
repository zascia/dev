
<table class=listing border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(1, L_G_SUBID); ?>
<tr>
  <td valign=top align=left>

  <form name=FilterForm action=index.php method=get>
  <table border=0>
  <tr>
    <td colspan=2>
    <table width=100% border=0 cellspacing=0 cellpading=0>
    <tr>
      <td align=left width=1% nowrap>
        <?php echo L_G_PCNAME?>
      </td>
      <td align=left width=50%>&nbsp;
        <select name=rq_campaign>
          <option value='_'><?php echo L_G_ALL?></option>
<?php      while($data=$this->a_list_data1->getNextRecord()) { ?>
          <option value='<?php echo $data['campaignid']?>' <?php echo ($_REQUEST['rq_campaign'] == $data['campaignid'] ? 'selected' : '')?>><?php echo $data['name']?></option>
<?php      } ?>          
      </select>&nbsp;&nbsp;
      </td>
      </tr>
      </table>
      </td>
    </tr>
    <tr>
        <td colspan="2">
            <br>
            &nbsp;<?php echo L_G_DATA1?>&nbsp;&nbsp;<input type="text" name="rq_data1" value="<?php echo $_REQUEST['rq_data1']?>">
            &nbsp;<?php echo L_G_DATA2?>&nbsp;&nbsp;<input type="text" name="rq_data2" value="<?php echo $_REQUEST['rq_data2']?>">
            &nbsp;<?php echo L_G_DATA3?>&nbsp;&nbsp;<input type="text" name="rq_data3" value="<?php echo $_REQUEST['rq_data3']?>">
        </td>
    </tr>
    
    <tr>
      <td align=left colspan=2>
        <br>
        <?php echo L_G_TIMEPERIOD?>
      </td>
    </tr>
    
    <tr>
      <td align=left colspan="2">
        <input type=radio name=rq_reporttype value=today <?php echo ($_REQUEST['rq_reporttype']=='today' ? "checked" : "")?>>
        &nbsp;
        <?php echo L_G_TODAY?>
      </td>
    </tr>
    <tr>
      <td align=left colspan="2">
        <input type=radio name=rq_reporttype value=thisweek <?php echo ($_REQUEST['rq_reporttype']=='thisweek' ? "checked" : "")?>>
        &nbsp;
        <?php echo L_G_THISWEEK?>
      </td>
    </tr>
    <tr>
      <td align=left colspan="2">
        <input type=radio name=rq_reporttype value=thismonth <?php echo ($_REQUEST['rq_reporttype']=='thismonth' ? "checked" : "")?>>
        &nbsp;
        <?php echo L_G_THISMONTH?>
      </td>
    </tr>
    <tr>
      <td align=left>
        <input type=radio name=rq_reporttype value=timerange <?php echo ($_REQUEST['rq_reporttype']=='timerange' ? "checked" : "")?>>
        &nbsp;
        <?php echo L_G_TIMERANGE?>
      </td>
      <td align=left>
        &nbsp;
        <b><?php echo L_G_FROM?></b>
        &nbsp;<?php echo L_G_DAY?>&nbsp;
        <select name=rq_day1>
<?php      for($i=1; $i<=31; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rq_day1'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>
        &nbsp;<?php echo L_G_MONTH?>&nbsp;
        <select name=rq_month1>
<?php      for($i=1; $i<=12; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rq_month1'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>
        &nbsp;<?php echo L_G_YEAR?>&nbsp;
        <select name=rq_year1>
<?php      for($i=PAP_STARTING_YEAR; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rq_year1'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>

        &nbsp;<b><?php echo L_G_TO?></b>&nbsp;

        &nbsp;<?php echo L_G_DAY?>&nbsp;
        <select name=rq_day2>
<?php      for($i=1; $i<=31; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rq_day2'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>
        &nbsp;<?php echo L_G_MONTH?>&nbsp;
        <select name=rq_month2>
<?php      for($i=1; $i<=12; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rq_month2'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>
        &nbsp;<?php echo L_G_YEAR?>&nbsp;
        <select name=rq_year2>
<?php      for($i=PAP_STARTING_YEAR; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?php echo $i?>' <?php echo ($i == $_REQUEST['rq_year2'] ? "selected" : "")?>><?php echo $i?></option>
<?php      } ?>
        </select>
        
      </td>
    </tr>    
    <tr><td align=left nowrap><?php echo L_G_ROWSPERPAGE?></td>
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
      <td align=center colspan=2>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_MerchantReports'>
      <input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'> 
      <input type=hidden name=reporttype value='subid'>
      <input class=formbutton type=submit value='<?php echo L_G_SUBMIT; ?>'>      
      </form>
      </td>
    </tr>
  </table>
  </form>


