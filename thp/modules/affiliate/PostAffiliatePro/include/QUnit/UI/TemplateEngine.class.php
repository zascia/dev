<?php
QUnit_Global::includeFile("Savant/Savant2.php");

class QUnit_UI_TemplateEngine extends Savant2
{
    function QUnit_UI_TemplateEngine() 
    {
    
        $searchPath = array();
    
        $opts = array(
            'template_path' => $searchPath
            );

        parent::Savant2($opts);
    }
}

?>
