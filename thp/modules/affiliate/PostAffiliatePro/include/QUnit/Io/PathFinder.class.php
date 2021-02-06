<?php

class QUnit_Io_PathFinder {

    var $searchPrefix = '';
    var $searchPath = array();
    
    //------------------------------------------------------------------------
    
    function setSearchPrefix($prefix) {
        $this->searchPrefix = $prefix;
    }
    
    //------------------------------------------------------------------------

    function addPath($path) {
        $this->searchPath[] = rtrim($path, "/");
    }
    
    //------------------------------------------------------------------------

    function getFilePath($file) {
        foreach($this->searchPath as $path) {
            if(file_exists($this->searchPrefix.'/'.$path.'/'.$file)) {
                return array(
                    'prefix' => $this->searchPrefix,
                    'path' => $path,
                    'file' => $file,                    
                );
            }
        }
        return false;
    }
        
    //------------------------------------------------------------------------

    function getTemplatePath($template, $type = 'template', $forceCustomTemplate = false) {
        $this->setSearchPrefix($GLOBALS['PROJECT_ROOT_PATH']);
        $suffix = '';
        if($type == 'image') {
            $suffix = 'images';
        }

        
        // ----------------------------------------------------------
		// custom templates for affiliate panel - only for ecommagnet
		// ----------------------------------------------------------
		/*
		if(is_object($GLOBALS['Auth']) && ($GLOBALS['Auth']->getAccountID() == '') && ($_REQUEST['aid'] != '')) {
			$GLOBALS['Auth']->setAccountID($_REQUEST['aid']);
			$unsetAccountID = true;
		}
		
        if(is_object($GLOBALS['Auth']) && method_exists($GLOBALS['Auth'], 'getProgramType')) {
            if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_ECOMMAGNET) {
                $forceCustomTemplate = true;
            }
        }
        
		if ( (($forceCustomTemplate) 
			|| (is_object($GLOBALS['Auth']) && in_array($GLOBALS['Auth']->getUserType(), array(USERTYPE_USER, null))))
		     && (strpos($_SERVER['PHP_SELF'], "merchants") === false) 
		     && (strpos($_SERVER['PHP_SELF'], "superadmins") === false) ) {
			$acctsettings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
			if($acctsettings['Glob_acct_custom_template'] == '1') {
        		$this->addPath($this->getTemplateDir($GLOBALS['Auth']->getAccountID()).'/');

                if(is_object($GLOBALS['Auth']) && method_exists($GLOBALS['Auth'], 'getProgramType')) {
                    if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_ECOMMAGNET) {
                        $this->addPath($this->getAccountsDir().'/_ecm_defaults_/');
                    } else if($GLOBALS['Auth']->getProgramType() == PROG_TYPE_PRO) {
                        $this->addPath($this->getAccountsDir().'/_defaults_/');
                    }
                }
			}
		}
        
        if ($unsetAccountID)
        	$GLOBALS['Auth']->setAccountID('');
        */
        	
        if(defined('CUSTOMER_CODE') && CUSTOMER_CODE != '') {
            $this->addPath($GLOBALS['WEB_PATH'].'/templates/'.PRODUCT.'/ext/'.CUSTOMER_CODE.'/'.$GLOBALS['default_template'].'/'.$suffix);
            $this->addPath('templates/'.PRODUCT.'/ext/'.CUSTOMER_CODE.'/'.$GLOBALS['default_template'].'/'.$suffix);
            $this->addPath($GLOBALS['WEB_PATH'].'/templates/'.DEFAULT_PRODUCT.'/ext/'.CUSTOMER_CODE.'/'.$GLOBALS['default_template'].'/'.$suffix);
            $this->addPath('templates/'.DEFAULT_PRODUCT.'/ext/'.CUSTOMER_CODE.'/'.$GLOBALS['default_template'].'/'.$suffix);
        }
        
        
        
        $this->addPath($GLOBALS['WEB_PATH'].'/templates/'.PRODUCT.'/'.$GLOBALS['default_template'].'/'.$suffix);
        $this->addPath($GLOBALS['WEB_PATH'].'/templates/'.PRODUCT.'/'.DEFAULT_TEMPLATE.'/'.$suffix);        
        $this->addPath('templates/'.PRODUCT.'/'.$GLOBALS['default_template'].'/'.$suffix);
        $this->addPath('templates/'.PRODUCT.'/'.DEFAULT_TEMPLATE.'/'.$suffix);
        
        $this->addPath($GLOBALS['WEB_PATH'].'/templates/'.DEFAULT_PRODUCT.'/'.$GLOBALS['default_template'].'/'.$suffix);
        $this->addPath($GLOBALS['WEB_PATH'].'/templates/'.DEFAULT_PRODUCT.'/'.DEFAULT_TEMPLATE.'/'.$suffix);
        
        $this->addPath('templates/'.DEFAULT_PRODUCT.'/'.$GLOBALS['default_template'].'/'.$suffix);
        $this->addPath('templates/'.DEFAULT_PRODUCT.'/'.DEFAULT_TEMPLATE.'/'.$suffix);


/*            if($this->user_type == USERTYPE_USER) {
                $settings = QCore_Settings::getGlobalSettings();
                if(isset($settings['Glob_accounts_dir']) || $settings['Glob_accounts_dir'] != '') {
                    $path = $settings['Glob_accounts_dir'];
                    $searchPath[] = ROOT_PATH.'/'.$path;
                    $searchPath[] = ROOT_PATH.'/'.$path.'/'.$GLOBALS['Auth']->getAccountID();        
                }
            }*/

        if(($path = $this->getFilePath($template)) != false) {
            switch($type) {
                case 'template':
                    return $path['prefix'].'/'.$path['path'];
                    break;
                case 'image':
                    return $GLOBALS['WEB_ROOT_PATH'].'/'.$path['path'].'/'.$path['file'];                        
                    break;
                default:
                    return $path['prefix'].'/'.$path['path'].'/'.$path['file'];
            }
        }
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function getAccountsDir() {
        $settings = QCore_Settings::getGlobalSettings();
        
        if(!isset($settings['Glob_accounts_dir']) || $settings['Glob_accounts_dir'] == '') {
            QUnit_Messager::setErrorMessage(L_G_ACCOUNTSDIRNOTCONFIGURED);
            return false;
        }  
        return $settings['Glob_accounts_dir'];
    }
    
    //--------------------------------------------------------------------------
    
    function getAccountDir() {        
        return $this->getAccountsDir().'/'.$GLOBALS['Auth']->getAccountID();  
    }
    
    //--------------------------------------------------------------------------
    
    function getTemplateDir() {
    	return $this->getAccountDir().'/templates';
    }
    
}

?>
