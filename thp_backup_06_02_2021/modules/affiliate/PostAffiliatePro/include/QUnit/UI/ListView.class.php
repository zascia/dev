<?php

class QUnit_UI_ListView
{
    var $columns;
    var $name;
    var $dbid;
    
    //------------------------------------------------------------------------
    
    function setColumns($columns) 
    {
        $this->columns = $columns;
    }
    
    //------------------------------------------------------------------------
    
    function setName($name) 
    {
        $this->name = $name;
    }

    //------------------------------------------------------------------------
    
    function getName() 
    {
        return $this->name;
    }
    
    //------------------------------------------------------------------------
    
    function isColumnUsed($column) 
    {
        return in_array($column, $this->columns);
    }    
}
?>
