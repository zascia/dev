<?php
/**
*
*   @author Maros Fric
*   @copyright Copyright (c) quality unit
*   All rights reserved
*
*   @package global
*   @since Version 1.0
*
*   Special version of engie which allows using affiliate links in form
*   www.yorsite.com/affname
*   
*   For support contact info@webradev.com
*/

QUnit_Global::includeClass('QUnit_SplitRun_Web_Engine');

class QUnit_SplitRun_Web_EngineAffLinks extends QUnit_SplitRun_Web_Engine {

    /*
    * page was probably called using affiliate link, display index.html 
    * and add affiliate link
    */
    function redirect() {
        return false;
    }
    
    function loadContent() {
        $this->_includeWebSettings();
        
        $page = $this->_getPageToLoad();
        
        if($page == false) {
            return $this->_processAffiliateCall();
        }
        
        $this->_loadWebSettings($page);
        $content = $this->_loadPath($page);
        if($content) {
            $GLOBALS['pzContent'] = $content;
            return $this->_generatePage();
        }
        
        $this->_show404File();
    }
    
    /*
    * page was probably called using affiliate link, display index.html 
    * and add affiliate link
    */
    function _processAffiliateCall() {
        $page = $this->_getRequestedFile();
        $GLOBALS['pzAffLink'] = str_replace('/', '', $this->_getRequestedFile());
        $page = 'index.html';
        
        $this->_loadWebSettings($page);
        $content = $this->_loadPath($page);
        if($content) {
            $GLOBALS['pzContent'] = $content;
            return $this->_generatePage();
        }
        
        $this->_show404File();
    }
}

?>
