<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class QUnit_UI_Menu extends QUnit_UI_TemplatePage {

    var $menu = array();
    var $currentHeader = '';
    var $menuFile = '';
    var $permissions = array();
    
    //--------------------------------------------------------------------------
    
    function QUnit_UI_Menu() {        
        $this->init();
        if(is_object($GLOBALS['Auth'])) {
            $this->permissions = $GLOBALS['Auth']->getPermissions();
        }
    }
    
    
    //--------------------------------------------------------------------------
    
    function setMenuFile($file) {
        $this->menuFile = $file;        
    }
    
    //--------------------------------------------------------------------------

    function addMenuFromFile($classLink = '') {
        if(!file_exists($this->menuFile) || !is_readable($this->menuFile)) {
            return false;            
        }
        
        if(($fp = fopen($this->menuFile, "r")) == false) {
            return false;
        }
        while (!feof($fp)) {
            $line = trim(fgets($fp, 4096));
            if($line != '') $this->addMenuRow($line, $classLink);
        }
        fclose($fp);
                                
    }        
    
    //--------------------------------------------------------------------------
    
    function addMenuRow($row, $classLink = '') {
        $parts = explode('|', $row);
        $type = array_shift($parts);
        switch($type) {
            case 'header':
                if(count($parts) <= 2) {
                    // old header menu style
                    list($name, $caption, $permission) = $parts;
                    $this->createMenuHeader($name, $caption);
                } else {
                    // old header menu style
                    list($name, $link, $caption, $permission, $image) = $parts;
                    if ($classLink != '') {
                        $link = 'index_res.php?md='.$classLink.'&p='.$link;
                    }                    
                    $this->createMenuHeaderNewStyle($name, $link, $caption, $permission, $image);
                }
                break;
            case 'item':
                list($name, $link, $caption, $permission) = $parts;
                if ($classLink != '') {
                	$link = 'index_res.php?md='.$classLink.'&p='.$link;
                }
                $this->createMenuItem($name, $link, $caption, $permission);    
                break;
        }
    }
    
    //--------------------------------------------------------------------------
    
    function addMenuHeader($header) {
        $this->menu[$header['name']] = $header;
    }
    
    //--------------------------------------------------------------------------
    
    function addMenuItem($headerName, $item) {
        $this->menu[$headerName]['items'][$item['name']] = $item;
    }
    
    //--------------------------------------------------------------------------
    
    function createMenuHeader($name, $caption) {
        if($caption != '') eval("\$caption = $caption;");
        $this->setCurrentHeader($name);
        $header['name'] = $name;
        $header['caption'] = $caption;      
        $header['items'] = array();
        $this->addMenuHeader($header);
    }
    
    //--------------------------------------------------------------------------

    function createMenuHeaderNewStyle($name, $link, $caption, $permission, $image) {
        if($caption != '') eval("\$caption = $caption;");
        $this->setCurrentHeader($name);
        $header['name'] = $name;
        $header['link'] = $link;
        $header['permission'] = $permission;
        $header['caption'] = $caption;      
        $header['image'] = $image;      
        $header['items'] = array();
        $this->addMenuHeader($header);
    }
    
    //--------------------------------------------------------------------------
    
    function createMenuItem($name, $link, $caption, $permission) {
        if($permission != '' && !in_array($permission, $this->permissions)) {
            return;
        }
        
        if(strstr($caption, 'L_G')) {
            eval("\$caption = $caption;");
        }
        $item = array(
                    'name' => $name,
                    'link' => $link,
                    'caption' => $caption,
                    'permission' => $permission,
                    );
        $this->addMenuItem($this->getCurrentHeader(), $item);
    }    
    
    //--------------------------------------------------------------------------
        
    function hideMenuHeader($header) {
        if (isset($this->menu[$header])) {
            unset($this->menu[$header]);
        }
    }
    
    //--------------------------------------------------------------------------
    
    function hideMenuItem($header, $item) {
        if (isset($this->menu[$header]['items'][$item])) {
            unset($this->menu[$header]['items'][$item]);
        }
        if(count($this->menu[$header]['items']) == 0) {
            $this->hideMenuHeader($header);
        }
    }
    
    //--------------------------------------------------------------------------
    
    function getCurrentHeader() {
        return $this->currentHeader;
    }
    
    //--------------------------------------------------------------------------
            
    function setCurrentHeader($header) {
        $this->currentHeader = $header;
    }
    
    //--------------------------------------------------------------------------
    
    function getMenu() {
        return $this->menu;
    }

    //--------------------------------------------------------------------------

    function loadColorSettings() {
        $settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountId());

        $colors = array();

        foreach ($settings as $key => $value) {
            if (strstr($key, 'Aff_style_') !== false) {
                $colors[substr($key, 12)] = $value;
            }
        }

        $this->assign('a_colors', $colors);
    }

    //--------------------------------------------------------------------------

    function getContent() {
        $this->show();
        $this->loadColorSettings();

        return $this->fetch('left_menu_new');
    }
          
    //--------------------------------------------------------------------------
    
    function getHeader($headerName) {
        if(isset($this->menu[$headerName])) {
            return $this->menu[$headerName];
        }
        return false;
    }
          
    //--------------------------------------------------------------------------
    
    function getMenuItem($headerName, $itemName) {
        if(isset($this->menu[$headerName]['items'][$itemName])) {
            return $this->menu[$headerName]['items'][$itemName];
        }
        return false;        
    }
          
    //--------------------------------------------------------------------------
    
    function show() {                
        $this->assign('a_menu', $this->menu);
    }
          
    //--------------------------------------------------------------------------
    
    function clear() {
        $this->menu = array();
    }
    //--------------------------------------------------------------------------
    
    function save() {
        if(!file_exists($this->menuFile) || !is_writable($this->menuFile)) {
            return false;
        }
        $output = '';
        foreach($this->menu as $header) {
            $output .= "header|".$header['name']."|".$header['caption']."\n";
            foreach($header['items'] as $item) {                        
                $output .= "item|".implode('|', $item)."\n";
            }
            $output .= "\n";
        }
        
        $fp = fopen($this->menuFile, 'w');
        fwrite($fp, $output);
        fclose($fp);
    }    
    
                    
}
?>
