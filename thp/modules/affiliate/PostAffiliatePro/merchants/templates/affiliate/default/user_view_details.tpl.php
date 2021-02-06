<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td><b><?php echo L_G_USERNAME?></b></td>
    <td><a href="index.php?md=Affiliate_Merchants_Views_BroadcastMessage&action=sendmsg&userid=<?php echo $_POST['aid']?>"><?php echo $_POST['uname']?></a></td></tr>
<tr><td><b><?php echo L_G_NAME?></b></td>
    <td><?php echo $_POST['name']." ".$_POST['surname']?></td></tr>
<tr><td><b><?php echo L_G_WEBURL?></b></td>
    <td><a href="<?php echo $_POST['weburl']?>" target="new"><?php echo $_POST['weburl']?></a></td></tr>

<tr><td align=left><a class=SimpleLink href=index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=view&aid=<?php echo $_POST['aid']?>><b><?php echo L_G_VIEWPROFILE?></b></a></td>
    <td align=right><a class=SimpleLink href=index.php?md=Affiliate_Merchants_Views_BroadcastMessage&userid=<?php echo $_POST['aid']?>><b><?php echo L_G_SENDEMAIL?></b></a></td></tr>
</table>