    <table border=0 cellspacing=0>
     <tr>
     <?php if($this->a_action_permission['add']) { ?>
       <td><input type=button class=formbutton value="<?php echo L_G_CREATEAFFILIATE?>"  onclick="javascript:addUser();">&nbsp;&nbsp;&nbsp;</td>
     <?php } ?>
     <?php if($this->a_action_permission['add']) { ?>
       <td><input type=button class=formbutton value="<?php echo L_G_AFFILIATE_IMPORT?>"  onclick="document.location='index.php?md=Affiliate_Merchants_Views_AffiliateImport';">&nbsp;&nbsp;&nbsp;</td>
     <?php } ?>
     <?php if($this->a_action_permission['view']) { ?>
       <td><input type=button class=formbutton value="<?php echo L_G_SHOWTREE?>"  onclick="javascript:showTree();">&nbsp;&nbsp;&nbsp;</td>
     <?php } ?>
     </tr>
     <tr>
        <td>&nbsp;</td>
     </tr>
     </table>
