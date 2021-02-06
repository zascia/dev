<?php 
if(count($this->okMessages) > 0) { ?>
    
    <table class="okMsgTable" border=0 cellspacing=0 cellpadding=2>
    <tr>
        <td class="okMessageHeader">
        <img src="<?php echo  $this->a_this->getImage('success.png') ?>" border="10">&nbsp;
        <?php echo L_G_SUCCESS?>
        </td>
    </tr>
    <tr>
        <td class="okMessage" align=left valign=top>
        <ul class="okMessage2">
<?php      foreach($this->okMessages as $msg) { ?>
            <li class="okMessage"><?php echo $msg?></li>
<?php      } ?>
        </ul>
        </td>
    </tr>
    </table>
    <br>
<?php } 

if(count($this->errorMessages) > 0) { ?>
    
    <table class="errorMsgTable" border=0 cellspacing=0 cellpadding=2>
    <tr>
        <td class="errorMessageHeader">
        <img src="<?php echo  $this->a_this->getImage('exclamation.png') ?>" border="10">&nbsp;
        <?php echo L_G_ERROR?>
        </td>
    </tr>
    <tr>
        <td class="errorMessage" align=left valign=top>
        <ul class="errorMessage">
<?php      foreach($this->errorMessages as $msg) { ?>
            <li class="errorMessage"><?php echo $msg?></li>
<?php      } ?>
        </ul>
        </td>
    </tr>
    </table>
    <br>
<?php } ?>

