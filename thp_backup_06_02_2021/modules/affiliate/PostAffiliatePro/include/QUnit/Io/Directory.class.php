<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright (c) 2004 Quality Unit s.r.o.
*   @package QUnit
*   @since Version 0.1a
*   $Id: Directory.class.php,v 1.1.1.1 2005/04/22 10:13:33 jsujan Exp $
*/

class QUnit_Io_Directory {

    function create($path) {
        return QUnit_Io_Directory::_create($path);
    }
    
    function _create($path) {
        if(empty($path)) {
            return false;
        }
        if(is_dir($path)) {
            return true;
        }
        $subPath = dirname($path);
        if(!QUnit_Io_Directory::_create($subPath)) {
            return false;
        }
        return mkdir($path);
    }
    
    function delete($path) {
        if(!is_dir($path)) {
            return false;
        }
        return rmdir($path);
    }
}

?>