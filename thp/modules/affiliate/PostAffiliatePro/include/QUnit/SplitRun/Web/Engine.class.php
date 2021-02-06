<?php
/**
*
*   @author Maros Fric
*   @author Andrej Harsani
*   @copyright Copyright (c) quality unit
*   All rights reserved
*
*   @package global
*   @since Version 1.0
*
*   This class is main part of web engine that allows running multiple versions of pages
*   needed for split run tests.
*   Split run enabes running multiple versions of pages and tracking (sale) effectivenes 
*   of every version.
*   For every visitor the new version of page is chosen randomly for every new visitor. 
*   Chosen page is remembered, so always the same version is displayed to a visitor.
*   The directory structure is fixed and is as follows:
*   /web 
*       /content/
*                /language-version/
*                                 /default/
*                                 /version2/
*                                 /version3/
*                /english/
*                /deutsch/
*       /settings/
*                  settings.php
*   
*   There are some settings that should be set in settings.php file. Website content is 
*   stored in /content directory, in respective language directories. There must be always 
*   version called 'default'. Other version pages can be in subdirectories of /content. 
*   Subdirectories can have any name, in settings.php it is configured which versions are used.
*   Default version must contain all files. Other version directories must have the same 
*   directory structure, but can should only contain files and dirs that are different from 
*   default version.
*
*   settings.php has format:
*   <?php
*   define('PZ_SESSION_PREFIX', 'pzsess');
*   
*   define('PZ_CONTENT_PATH', '/content/');
*   define('PZ_CONTENT_URL', 'http://www.ecommagnet.com/web/content/');
*   define('PZ_DEFAULT_LANG', 'english');
*   define('PZ_WEB_URL', 'www.ecommagnet.com/');
*   
*   // extensions that are searched if file does not exist. For example, if url is
*   // http://www.ecommagnet.com/something, if /something directory does not exist, system 
*   // checks for files something.htm, something.html, something.php
*   $GLOBALS['PZ_extensions'] = array('htm', 'html', 'php');
*   
*   // array of versions that are chosen randomly
*   $GLOBALS['PZ_versions'] = array('default', 'version1');
*   ?>
*   
*   For support contact info@webradev.com
*/

class QUnit_SplitRun_Web_Engine {
    var $version;
    var $language;
    var $page;
    var $webSettings = array();
    var $languages;
    var $urlTransFiles = array();
    
    
    function QUnit_SplitRun_Web_Engine() {
        if(is_array($GLOBALS['PZ_languages'])) {
            $this->languages = $GLOBALS['PZ_languages'];
            if(!in_array('english', $this->languages)) {
                $this->languages['Worldwide'] = 'english';
            }
        } else {
            $this->languages = array('Worldwide' => 'english');
        }
    }
    
    /*
    * 
    */
    function handleRequest() {
        if($this->redirect()) {
            return;
        }
        $this->parseAndSetGetParams();

        $language = $this->_loadLanguageFromSession();
        if(empty($language) || $language == 'english') {
            $this->urlLanguage = 'english';
        }
        $this->urlLanguage = $language;
        
        $this->setLanguage();
        $this->setVersion();
        $this->uri = $this->_translateUrl($this->_getRequestedFile(), false);
        $this->urlLanguage = $this->language;
        $this->loadContent();
    }
    
    function redirect() {
        $uri = $this->_getRequestedFile(false);
        if(strlen($uri) && substr($uri, -1) != '/' 
            && false === strpos($this->_getLastFile($uri), '.')) {
            header('HTTP/1.0 301 OK');
            header("Status: 301 OK");
            header("Location: /$uri/");
            return true;
        }
        return false;
    }
    
    /*
    * 
    */
    function _translateUrl($url, $notBack = true) {
        $page = $url;
        $urlTransFile = $this->_getUrlTranslateFile($page);
        $this->_includeUrlTranslateFile($urlTransFile);

        if(!is_array($this->urlTransFiles[$this->urlLanguage.$urlTransFile])) {
            return $url;
        }       

        $backTrans = $this->urlTransFiles[$this->urlLanguage.$urlTransFile];
        if($notBack == false) {
            $backTrans = array_flip($backTrans);
        }
        
        $pageParts = explode('/', $page);
        foreach ($pageParts as $id => $part) {
            if(array_key_exists($part, $backTrans)) {
                $transPageParts[$id] = $backTrans[$part];
            } else {
                $transPageParts[$id] = $part;
            }
        }
        return implode('/', $transPageParts);
    }

    /*
    * 
    */
    function _includeUrlTranslateFile($urlTransFile) {
        $versionPath = $this->urlLanguage . '/' . $this->version . $urlTransFile;
        if(array_key_exists($urlTransFile, $this->urlTransFiles)) {
            return;
        }
        if($this->_contentFileExists($versionPath)) {
            include($this->_getContentFilePath($versionPath));
            $this->urlTransFiles[$this->urlLanguage.$urlTransFile] = $GLOBALS['pzUrlTrans'];
            return;

        }
        $versionPath = $this->urlLanguage . '/default' . $urlTransFile;
        if(array_key_exists($urlTransFile, $this->urlTransFiles)) {
            return;
        }
        if($this->_contentFileExists($versionPath)) {
            include($this->_getContentFilePath($versionPath));
            $this->urlTransFiles[$this->urlLanguage.$urlTransFile] = $GLOBALS['pzUrlTrans'];
            return;
        }
    }
    
    /*
    * 
    */
    function _getUrlTranslateFile($page) {
        $pos = strrpos($page, '/');
        if($pos === false) {
            return '/_url_trans.php';
        }
        $page = substr($page, 0, $pos);
        return '/' . $page . '/_url_trans.php';
    }
    
    /*
    * 
    */
    function parseAndSetGetParams() {
        $getParameters = $this->_getGetParams($_SERVER['REQUEST_URI']);
        
        $urlParamsPairs = explode('&', $getParameters);

        foreach($urlParamsPairs as $param) {
            $oneSet = explode('=', $param);
            if(is_array($oneSet) && count($oneSet) == 2) {
                $_GET[$oneSet[0]] = urldecode($oneSet[1]);
                $_REQUEST[$oneSet[0]] = urldecode($oneSet[1]);
            }
        }
    }
    
    /*
    * 
    */

    function setLanguage() {
        if(isset($_REQUEST['lng']) 
           && !empty($_REQUEST['lng'])
           && (strpos($this->_getRequestedFile(), 'index.html') !== false)) {
            $language = $_REQUEST['lng']; 

            if($this->_languageExists($language)) {
                $this->_saveLanguageToSession($language);
                $this->_saveLanguageToCookie($language);
                return;
            }
        }

        $language = $this->_loadLanguageFromSession();       
        if($this->_languageExists($language)) {
            $this->language = $language;
            return;
        }

        $language = $this->_loadLanguageFromCookie();       
        if($this->_languageExists($language)) {
            $this->_saveLanguageToSession($language);
            $this->_saveLanguageToCookie($language);
            return;
        }

        $language = $this->_getBrowserLanguage();       
        if($this->_languageExists($language)) {
            $this->_saveLanguageToSession($language);
            return;
        }
        
        $this->_saveLanguageToSession('english');
    }

    /*
    * 
    */
    function _languageExists($language) {
        //:TODO: PZ_ContentPath
        return !empty($language) 
            && $this->_contentFileExists($language . '/');
    }

    /*
    * 
    */
    function _saveLanguageToCookie($language) {
        $this->language = $language;
        setcookie('pzLng', $language, time() + 3650*86400, '/');
    }

    /*
    * 
    */
    function _loadLanguageFromCookie() {
        return $_COOKIE['pzLng'];
    }

    /*
    * 
    */
    function _saveLanguageToSession($language) {
        $this->language = $language;
        $_SESSION[PZ_SESSION_PREFIX . 'pzLng'] = $language;
    }

    /*
    * 
    */
    function _loadLanguageFromSession() {
        return $_SESSION[PZ_SESSION_PREFIX . 'pzLng'];
    }

    function _getBrowserLanguage() {
        $acceptLanguages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $pos = strpos($acceptLanguages, ';');
        if($pos !== false) {
            $acceptLanguages = substr($acceptLanguages, 0, $pos);
        }
        $acceptLanguages = explode(',', $acceptLanguages);
        
        foreach ($acceptLanguages as $lang) {
            $langParts = explode('-', $lang);
            if(in_array($langParts[0], $this->languages)) {
                return $langParts[0];
            }
        }
        return 'english';
    }
    
    /*
    * 
    */
    function getLanguage() {
        if($this->language == 'english') {
            return 'en';
        }
        return $this->language;
    }
    
    /*
    * 
    */
    function setVersion() {
        $version = $_REQUEST['pv'];
        if($this->_versionExists($version)) {
            return $this->_saveVersion($version);
        }
        
        $version = $_SESSION[PZ_SESSION_PREFIX.'pzVersion'];
        if($this->_versionExists($version)) {
            return $this->_saveVersion($version);
        }

        $version = $_COOKIE['pzVersion'];
        if($this->_versionExists($version)) {
            return $this->_saveVersion($version);
        }
        $this->_saveVersion($this->_getRandomVersion());
    }
    
    function loadContent() {
        $this->_includeWebSettings();
        
        $page = $this->_getPageToLoad();
        
        if($page == false) {
            return $this->_show404File();
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
    * 
    */
    function _getPageToLoad() {
        $page = strtolower($_REQUEST['p']);
        if(!empty($page)) {
            if(isset($GLOBALS['pzPageTranslations'][$page])) {
                $page = $GLOBALS['pzPageTranslations'][$page];
            }
            
            foreach ($GLOBALS['PZ_extensions'] as $extension) {
                $newPage = $page . '.' . $extension; 
                if(false !== $this->getFile($newPage)) {
                    return $newPage;
                }
            }
        }        
        
        $page = strtolower($_REQUEST['pp']);
        if(!empty($page)) {
            foreach ($GLOBALS['PZ_extensions'] as $extension) {
                $newPage = $page . '.' . $extension; 
                if(false !== $this->getFile($newPage)) {
                    return $newPage;
                }
            }
        }        

        $page = $this->_getRequestedFile();
        if($page == '') {
            $page = 'index.html';
        }
        if(substr($page, -1) == '/') {
            $page .= 'index.html';
        }
        
        
        if(false !== $this->getFile($page)) {
            return $page;
        }
        return false;
    }
    
    /*
    * 
    */
    function _generatePage() {
        $this->_sendHeaders();
        $template = $this->_findTemplateForPage();
        $this->includeFile($template);
    }
    
    /*
    * 
    */
    function _sendHeaders() {
        if(!headers_sent()) {
            header('HTTP/1.0 200 OK');
            header("Status: 200 OK");
        } else {
            echo 'Cannot send headers, headers already sent. Check your configuration';
        }
    }
    
    /*
    * 
    */
    function _findTemplateForPage() {
        if($this->webSettings['template'] == '') {
            return '/templates/template.php';
        }
        return $this->webSettings['template'];
    }

    /*
    * 
    */
    function _show404File() {
        $p404 = '404.php';
        
        if($this->_getSearchRelativeFilePath($p404)) {
            echo $this->_loadPath($p404);
        } else {
            echo '404 page does not exist';
            return false;
        }
        return true;
    }
    
    /*
    * 
    */
    function _loadPath($path) {
        ob_start();
        $this->includeFile($path);
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    
    /*
    * 
    */
    function _getWebSettingFile($page) {
        $pos = strrpos($page, '/');
        if($pos === false) {
            return '/_web_settings.php';
        }
        $page = substr($page, 0, $pos);
        
        if(!$this->_contentFileWithVersionExists('/' . $page . '/_web_settings.php')) {
            return $this->_getWebSettingFile($page);
        }
        return '/' . $page . '/_web_settings.php';
    }
    
    /*
    * 
    */
    function _includeWebSettings() {
        $page = $this->_getRequestedFile();
        $webSettingFile = $this->_getWebSettingFile($page);
        $this->includeFile($webSettingFile);
    }
        
    /*
    * 
    */
    function _getLastFile($path) {
        $pos = strrpos($path, '/');
        if($pos !== false) {
            return substr($path, $pos + 1, strlen($path) - $pos);
        }
        return $path;
    }
    
    /*
    * 
    */
    function _loadWebSettings($page) {
        $settingsForPage = '';
        
        $pageWithPath = $this->_removeFileExtension($page);
        $page = $this->_removeFileExtension($this->_getLastFile($page));
        
        if(isset($GLOBALS['pzWebSettingsForPage']) 
           && is_array($GLOBALS['pzWebSettingsForPage'])) {
            if(isset($GLOBALS['pzWebSettingsForPage'][$pageWithPath])) {
                $settingsForPage = $GLOBALS['pzWebSettingsForPage'][$pageWithPath];
            } else if(isset($GLOBALS['pzWebSettingsForPage'][$page])) {
                $settingsForPage = $GLOBALS['pzWebSettingsForPage'][$page];
            }
        }
        if($settingsForPage == '') {
            $settingsForPage = '_default';
        }
        
        if(isset($GLOBALS['pzWebSettings'][$settingsForPage]) 
           && is_array($GLOBALS['pzWebSettings'][$settingsForPage]) 
           && count($GLOBALS['pzWebSettings'][$settingsForPage]) > 0) {
            $GLOBALS['pzWebSettingsForCurrentPage'] = $GLOBALS['pzWebSettings'][$settingsForPage];
            
            foreach($GLOBALS['pzWebSettings'][$settingsForPage] as $key => $value) {
                $this->webSettings[$key] = $value;
            }
        }        
    }
    
    /*
    * 
    */
    function _getGetParams($uri) {
        $pos = strpos($uri, '?');
        if($pos !== false) {
            return substr($uri, $pos + 1);
        }
        return '';
    }

    
    /*
    * 
    */
    function _versionExists($version) {
        if(empty($version)) {
            return false;
        }
        return $this->_contentFileExists($this->language .'/' . $version . '/');
    }

    /*
    * 
    */
    function _saveVersion($version) {
        setcookie('pzVersion', $version, time() + 3650*86400, '/');
        $this->version = $version;
    }

    /*
    * 
    */
    function _contentFileExists($path) {
        return file_exists($this->_getContentFilePath($path));
    }

    /*
    * 
    */
    function _getSearchRelativeFilePath($path) {
        if('/' !== substr($path, 0, 1)) {
            $path = '/' . $path;
        }
        $versionPath = $this->language . '/' . $this->version . $path;
        if($this->_contentFileExists($versionPath)) {
            return $versionPath;
        }
        
        if($this->version != 'default') {
            $versionPath = $this->language . '/default' . $path;
            if($this->_contentFileExists($versionPath)) {
                return $versionPath;
            }
        }

        if($this->language != 'english') {
            $versionPath = 'english/' . $this->version . $path;
            if($this->_contentFileExists($versionPath)) {
                return $versionPath;
            }
        }

        if($this->version != 'default' && $this->language != 'english') {
            $versionPath = 'english/default' . $path;
            if($this->_contentFileExists($versionPath)) {
                return $versionPath;
            }
        }
        
        return false;
    }

    /*
    * 
    */
    function _contentFileWithVersionExists($path) {
        return $this->_getSearchRelativeFilePath($path) !== false; 
    }

    /*
    * 
    */
    function _getContentFilePath($path) {
        return $GLOBALS['PZ_ContentPath'] . $path;
    }

    /*
    * 
    */
    function _getRandomVersion() {   
        //:TODO: PZ_versions
        srand((float) microtime() * 10000000);
        return $GLOBALS['PZ_versions'][array_rand($GLOBALS['PZ_versions'])];
    }

    /*
    * 
    */
    function _getRequestedFile($cache = true) {
        if($this->uri) {
            return $this->uri;
        }
        $uri = $_SERVER['REQUEST_URI'];
        $pos = strpos($uri, '?');
        
        if($pos !== false) {
            $uri = substr($uri, 1, $pos - 1);
        } else {
            $uri = substr($uri, 1);
        }

        if(defined('PZ_REMOVE_FROM_URL') && PZ_REMOVE_FROM_URL != '') {
            if(0 === strpos($uri, PZ_REMOVE_FROM_URL)) {
                $uri = substr($uri, strlen(PZ_REMOVE_FROM_URL));
            }
        }
        $pos = strpos($uri, '/');
        if(false !== $pos) {
            $lang = substr($uri, 0, $pos);
        }
        if(in_array($lang, $this->languages)) {
            $uri = substr($uri, $pos + 1);
            $this->_saveLanguageToCookie($lang);
            $this->_saveLanguageToSession($lang);
        }
        if($cache) {
            $this->uri = $uri;
        }
        return $uri;
    }

    /*
    * 
    */
    function _removeFileExtension($file) {
        $pos = strrpos($file, '.');
        
        if($pos == false) {
            return $file;
        }
        return substr($file, 0, $pos);
    }
    
    /*
    * 
    */
    function includeFile($path) {
        include($this->_getContentFilePath($this->getFile($path)));
    }

    /*
    * 
    */
    function getFile($file) {
        if($file == '') {
            return false;
        }

        if(isset($GLOBALS['pzIncludePrefix']) && $GLOBALS['pzIncludePrefix'] != '') {
            $path = $this->_getSearchRelativeFilePath($GLOBALS['pzIncludePrefix'] . $file);
            if(false !== $path) {
                return $path;
            }
        }
        
        return $this->_getSearchRelativeFilePath($file);
    }

    function getImage($file) {
        return PZ_CONTENT_URL . $this->getFile($file);
    }

    function getWebSetting($key) {
        if(isset($this->webSettings[$key])) {
            return $this->webSettings[$key];
        } else {
            return '';
        }
    }

    function getLink($url) {
        $language = '';
        if($this->language != 'english') {
            $language = $this->language . '/';
        }
        return WEB_URL . PZ_REMOVE_FROM_URL 
               . $language . $this->_translateUrl($url);
    }
}

function pzGetWebSetting($key) {
    global $e;
    return $e->getWebSetting($key);
}

function pzImage($file) {
    global $e;
    return $e->getImage($file);
}

function pzInclude($file) {
    global $e;
    return $e->includeFile($file);
}

function pzLink($url = '') {
    global $e;
    return $e->getLink($url);
}

function pzGetContentLanguage() {
    global $e;
    return $e->getLanguage();
}
?>
