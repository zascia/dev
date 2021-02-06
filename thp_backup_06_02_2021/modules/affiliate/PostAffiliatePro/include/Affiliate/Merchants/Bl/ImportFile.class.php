<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================


class Affiliate_Merchants_Bl_ImportFile
{
    var $format;
    var $separator;
    var $fp;
    var $error_fp;
    var $line;
    
    //--------------------------------------------------------------------------
    
    function Affiliate_Merchants_Bl_ImportFile() {
        $this->format = array();
        $this->separator = ',';
    }
    
    //--------------------------------------------------------------------------
    
    function open($filename) {
        if (($this->fp = fopen($filename, "r")) === false)
            return false;
        if (($this->error_fp = fopen($filename."_ERROR", "w")) === false) {
            fclose($this->fp);
            return false;
        }
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function close() {
        fclose($this->fp);
        fclose($this->error_fp);
    }
    
    //--------------------------------------------------------------------------
    
    function addField($position, $name) {
        $this->format[$position] = $name;
    }
    
    //--------------------------------------------------------------------------
    
    function setSeparator($separator) {
        $this->separator = $separator;
    }
    
    //--------------------------------------------------------------------------
    
    function getNextRecord() {
        if (feof($this->fp))
            return false;
        
        if (($this->line = fgets($this->fp)) == false) {
            return false;
        }
        
        $fields = explode($this->separator, $this->line);
        
        $row = array();
        foreach ($this->format as $pos => $name) {
            if (!isset($fields[$pos]))
                return $name;
            $row[$name] = trim(trim($fields[$pos]), "\"'");
        }
        return $row;
    }
    
    //--------------------------------------------------------------------------
    
    function saveLineToErrorFile() {
        fputs($this->error_fp, $this->line);
    }
    
    //--------------------------------------------------------------------------
    
    function setPosition($pos) {
        fseek($this->fp, $pos);
    }
    
    //--------------------------------------------------------------------------
    
    function getPosition() {
        return ftell($this->fp);
    }
}
?>
