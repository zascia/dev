<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Merchants_Bl_TemplateCompiler {

    var $content;
    var $errorMessage = '';
    var $tags = array();
  
    //--------------------------------------------------------------------------
    
    function Affiliate_Merchants_Bl_TemplateCompiler() {
    }
  
    //--------------------------------------------------------------------------
    
    function setContent($content) {
        $this->content = $content;
    }
  
    //--------------------------------------------------------------------------
    
    function addTag($name, $comp_pattern, $comp_replacement, $decomp_pattern, $decomp_replacement, $needed = false) {
        $this->tags[$name]['comp_pattern'] = $comp_pattern;
        $this->tags[$name]['comp_replacement'] = $comp_replacement;
        $this->tags[$name]['decomp_pattern'] = $decomp_pattern;
        $this->tags[$name]['decomp_replacement'] = $decomp_replacement;
        $this->tags[$name]['needed'] = $needed;
    }
      
    //--------------------------------------------------------------------------
    
    function initTags() {
        $this->tags = array();
        $this->addTag('php_start', '\<\?', '', '', '');
        $this->addTag('php_end', '\?\>', '', '', '');
    }
  
    //--------------------------------------------------------------------------
        
    function getPattern($tag, $type = 'comp') {
        return $this->tags[$tag][$type.'_pattern'];        
    }
  
    //--------------------------------------------------------------------------
    
    function getReplacement($tag, $type = 'comp') {
        return $this->tags[$tag][$type.'_replacement'];        
    }
  
    //--------------------------------------------------------------------------
      
    function isNeeded($tag) {
        return $this->tags[$tag]['needed'];
    }
    
    //--------------------------------------------------------------------------
    
    function addErrorMessage($msg) {
        $this->errorMessage .= $msg.'<br>';
    }
    
    //--------------------------------------------------------------------------
    
    function setErrorMessage($msg) {
        $this->errorMessage = $msg;
    }
    
    //--------------------------------------------------------------------------
    
    function getErrorMessage() {
        return $this->errorMessage;
    }
    
    //--------------------------------------------------------------------------
    
    function compile() {        
        foreach($this->tags as $tag => $dummy) {            
            $this->content = preg_replace('/'.$this->tags[$tag]['comp_pattern'].'/', $this->tags[$tag]['comp_replacement'],  $this->content);
        }
        return $this->content;
    }
  
    //--------------------------------------------------------------------------
    
    function decompile() {
        foreach($this->tags as $tag => $dummy) {
            if($this->getReplacement($tag, 'decomp') != '') {
                $this->content = preg_replace('/'.$this->getPattern($tag, 'decomp').'/', $this->getReplacement($tag, 'decomp'), $this->content);
            }
        }
        return $this->content;    
    }
  
    //--------------------------------------------------------------------------
  
    function check() {
        $correct = true;
        if(trim($this->content) == '') {
            $this->addErrorMessage(L_G_TEMPLATE.' '.L_G_EMPTY);
            $correct = false;
        }
        foreach($this->tags as $tag => $dummy) {
            if($this->isNeeded($tag)) {
                if(!preg_match('/'.$this->getPattern($tag).'/', $this->content)) {
                    $this->addErrorMessage(htmlentities($tag).' '.L_G_SHOULDBEINTPL);
                    $correct = false;
                }
            }
        }
        return $correct;
    }    
}
?>
