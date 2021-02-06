
    <center>
    <form action=index_popup.php method=post>
    <table class=listing cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?php echo L_G_NAME;?></b>&nbsp;</td>
      <td><input type=text name=name size=44 value="<?php echo $_POST['name']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?php echo L_G_LANGUAGE_CODE;?></b>&nbsp;</td>
      <td><input type=text name=langid size=44 value="<?php echo $_POST['langid']?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left">
      <?php showHelp('L_G_HLPLANGUAGE_CODE'); ?>
      </td>
    </tr>
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?php echo L_G_STATUS;?></b>&nbsp;</td>
      <td>
        <select name=disabled>
        <?php
          if($_POST['disabled'] == '') $_POST['disabled'] = STATUS_ENABLED;
          echo "<option value=\"".STATUS_ENABLED."\" ".($_POST['disabled'] == STATUS_ENABLED ? "selected" : "").">".L_G_ENABLED."</option>\n";
          echo "<option value=\"".STATUS_DISABLED."\" ".($_POST['disabled'] == STATUS_DISABLED ? "selected" : "").">".L_G_DISABLED."</option>\n"; 
        ?>
        </select>*&nbsp;
      </td>
    </tr>
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?php echo L_G_ORDER?></b>&nbsp;</td>
      <td><input type=text name=rorder size=4 value="<?php echo ($_POST['rorder'] == '' ? '1' : $_POST['rorder'])?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;<b><?php echo L_G_EXPORTFORMAT;?></b>&nbsp;</td>
      <td><textarea name=exportformat cols=88 rows=2><?php echo $_POST['exportformat']?></textarea>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left">
      <?php showHelp('L_G_HLPEXPORTFORMAT'); ?>
      <a class=helplink href="http://www.qualityunit.com/help/index.php?pcid=_&psid=0acd82b535&iid=2967c5dfce" target="_blank"><?php echo L_G_HLPCLICKHEREFORMOREHELP?></a>
      </td>
    </tr>    
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;<b><?php echo L_G_BUTTONFORMAT;?></b>&nbsp;</td>
      <td><textarea name=buttonformat cols=88 rows=5><?php echo $_POST['buttonformat']?></textarea>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left">
      <?php showHelp('L_G_HLPBUTTONFORMAT'); ?>
      <a class=helplink href="http://www.qualityunit.com/help/index.php?pcid=_&psid=0acd82b535&iid=2967c5dfce" target="_blank"><?php echo L_G_HLPCLICKHEREFORMOREHELP?></a>
      </td>
    </tr>    
    <tr>
      <td class=dir_form colspan=2 align=center>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Merchants_Views_PayoutSettings'>
        <input type=hidden name=action value=<?php echo $_POST['action']?>>
        <input type=hidden name=pid value=<?php echo $_POST['pid']?>>
        <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
        <input type=submit class=formbutton value='<?php echo L_G_SUBMIT; ?>'>
      </td>
    </tr>
    </table>
    </form>
    </center>
