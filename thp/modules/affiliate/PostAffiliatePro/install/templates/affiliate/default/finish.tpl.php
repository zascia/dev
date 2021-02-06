
<form action=index.php method=post>
  <center>
    <table class=tableresult width=100% border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=header align=center colspan=3><?php echo  $this->msgHeader?></td>
      </tr>
      <tr>
        <td align=left colspan=3 style="padding: 7px";>
        <center><?php echo  $this->msgFinished?></center>
        <br><br>
        <b><?php echo L_G_TODO?></b><br><br>
        <font color=#ff0000><?php echo L_G_CRONJOB?></font><br><br>
        <div align="center">
        <input type=text readonly size=100 value="/usr/local/bin/php -q <?php echo $this->scriptsDir?>jobs.php"><br><br>
        
        <br><center><?php echo L_G_SAMPLECRONINCPANEL?></center><br>
        <img src="<?php echo  QUnit_UI_TemplatePage::getImage('cron1.gif') ?>" style="border:1px solid #a0a0a0" border="0">
        </div>
        <br><br>
        <?php echo $this->msgNextSteps?>
        <br><br>
        <center><a href="../merchants/" target=new><font color=#ff0000>Click here to get to your merchant panel</font></a></center>
        </td>
      </tr>
      <tr>
        <td class=commcat align=left valign=top colspan=3>&nbsp;</td>
      </tr>
    </table>
  </center>
</form>
<? if($this->track == 1) { ?>
<img src="http://install.supportcenterpro.com/scripts/sale.php?ProductID=papslinstall" width="0" height="0">
<? } ?>
