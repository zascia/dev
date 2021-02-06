<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright (c) 2004 Quality Unit s.r.o.
*   @package QUnit
*   @since Version 0.1a
*   $Id: Dictionary.class.php,v 1.1.1.1 2005/04/22 10:13:37 jsujan Exp $
*/

class QUnit_Data_Dictionary {
    var $_dictionary = array();
    
    function set($dictionary) {
        $this->_dictionary = $dictionary;
    }

    function getValue($key) {
        if(array_key_exists($key, $this->_dictionary)) {
            return $this->_dictionary[$key];
        }
        return false;
    }
    function add($id, $value) {
        $this->_dictionary[$id] = $value;
    }   
}

?>