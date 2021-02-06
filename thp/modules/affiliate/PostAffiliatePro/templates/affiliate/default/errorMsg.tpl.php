<?php  if( QUnit_Messager::getErrorMessage() != '') { ?>
        <center><span class='error'><?php echo QUnit_Messager::getErrorMessage()?></span></center><br>
<?php  }
    if( QUnit_Messager::getOkMessage() != '') { ?>
        <center><span class='ok'><?php echo QUnit_Messager::getOkMessage()?></span></center><br>
<?php
        QUnit_Messager::resetMessages();
    } 
?>