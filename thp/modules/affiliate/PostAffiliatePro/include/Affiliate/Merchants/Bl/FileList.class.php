<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Merchants_Bl_FileList {

    var $path = '';
    var $filters = array();
	
    function Affiliate_Merchants_Bl_FileList() {
        $this->addFilter('.*');
    }
    
    //--------------------------------------------------------------------------
    
    function getPath() {
        return $this->path;
    }
    
    //--------------------------------------------------------------------------
    
    function setPath($path) {
        $this->path = $path;
    }
    
    //--------------------------------------------------------------------------
    
    function addFilter($filter) {
        $this->filters[] = $filter;
    }        
    
    //--------------------------------------------------------------------------
    
    function setFilter($filter) {
        $this->filters = $filter;
    }        
    
    //--------------------------------------------------------------------------
    
    function clearFilters() {
        $this->filters = array();
    }
    
    //--------------------------------------------------------------------------
	
    function getFiles() {
        if (!is_dir($this->getPath())) {
            QUnit_Messager::setErrorMessage(L_G_CANTOPENACCOUNTDIR);
            return false;
        }
        
        if ( ($dh = opendir($this->getPath())) === false) {
            QUnit_Messager::setErrorMessage(L_G_CANTOPENACCOUNTDIR);
            return false;
        }
        
        while (($file = readdir($dh)) !== false) {
            if($this->isSupportedType($file)) {
                    $files[] = $file;
            }
        }
        closedir($dh);
        
        return $files;    
    }    
    
    //--------------------------------------------------------------------------
    
    function isSupportedType($fileName) {
        foreach($this->filters as $filter) {
            if(preg_match('/'.$filter.'/', $fileName)) {
                return true;
            }
        }
        return false;
    }        
    
    //--------------------------------------------------------------------------
    
/*    function processDeleteFile() {
        if(!isset($_REQUEST['file']) ||  $_REQUEST['file'] == '') {
            return false;
        }
        
        if(($dir = $this->getAccountDir()) === false) {
            return false;
        }
        $file = ROOT_PATH."/".$dir.'/'.$_REQUEST['file'];
        if(!file_exists($file) || !is_file($file) || !$this->isSupportedType($file) || !@unlink($file)) {
            QUnit_Messager::setErrorMessage(L_G_FILECANTBEREMOVED);
            return false;
        }
        QUnit_Messager::setOkMessage(L_G_FILESUCCESSFULLYREMOVED.": ".basename($file));
        return true;        
    }    */
 
}
?>
