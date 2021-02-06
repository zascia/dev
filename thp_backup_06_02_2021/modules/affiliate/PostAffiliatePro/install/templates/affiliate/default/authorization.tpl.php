<form action=index.php method=post>
<table border=0 width=100% cellspacing=0 cellpadding=0>
<? if($this->checkspecial == 'ok') { ?>
    <tr>
        <td class=header><br/>Your license was verified
        <br/><br/>
        </td>
    </tr>
<? } else if($this->checkspecial == 'ok') { ?>
    <tr>
        <td class=header><br/>Your license was not verified!
        <br/><br/>
        </td>
    </tr>
<? } else { ?>
    <tr>
        <td class=commcat><?php echo L_G_LICENSEHELP?>
        <br/><br/>
        </td>
    </tr>
    <tr>
        <td class=header align=center><?php echo L_G_AUTHORIZATION?></td>
    </tr>
    <tr>
        <td align="center"><br><b><?php echo L_G_AUTHINSERTCODE?></b><input type="text" name="auth_code" value=""><br/><br/></td>
    </tr>
    <tr>
        <td align="center"><img src="<?php echo  QUnit_UI_TemplatePage::getImage('dprotect.gif') ?>" style="border:1px solid #a0a0a0" border="0"></td>
    </tr>
<? } ?>    
    <tr>
        <td class=theader align=right valign=top>
        <input type=submit class=formbutton name=submit value="<?php echo L_G_NEXT?>">
        </td>
    </tr>
</table>  
<input type=hidden name=action value="Authorization">
</form> 
