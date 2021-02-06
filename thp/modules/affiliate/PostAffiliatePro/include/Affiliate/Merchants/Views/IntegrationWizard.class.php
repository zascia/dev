<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_IntegrationWizard extends QUnit_UI_TemplatePage
{
    function Affiliate_Merchants_Views_IntegrationWizard() {
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_TOOLS,'index.php?md=Affiliate_Merchants_Views_Tools');
		$this->navigationAddURL(L_G_INTEGRATIONWIZARD,'index.php?md=Affiliate_Merchants_Views_IntegrationWizard');
        
		// create tab
		switch ($_REQUEST['integration_tab_sheet']) {
		    case 'trackingparams':
		          $this->tabs['trackingparams'] = QUnit_Global::newObj('Affiliate_Merchants_Views_IntegTabTrackingParams');
		          $this->tabs['trackingparams']->setAttributes('trackingparams', L_G_TRACKINGPARAMSNAMES, 'integration_trackingparams', 'aaaaa');
		          $this->navigationAddURL(L_G_TRACKINGPARAMSNAMES,'');
		          break;
		          
   		    case 'clickstracking':
		          $this->tabs['clickstracking'] = QUnit_Global::newObj('Affiliate_Merchants_Views_IntegTabClicksTracking');
		          $this->tabs['clickstracking']->setAttributes('clickstracking', L_G_CLICKSTRACKING, 'integration_clickstracking');
		          $this->navigationAddURL(L_G_CLICKSTRACKING,'');
		          break;
		          		          
            case 'salestracking':
		          $this->tabs['salestracking'] = QUnit_Global::newObj('Affiliate_Merchants_Views_IntegTabSalesTracking');
		          $this->tabs['salestracking']->setAttributes('salestracking', L_G_SALESTRACKING, 'integration_salestracking');
		          $this->navigationAddURL(L_G_SALESTRACKING,'');
		          break;
		          
		    default:
		          break;
		}
		
//		$this->tabs['reftracking'] = QUnit_Global::newObj('Affiliate_Merchants_Views_IntegTabOriginalReferrerTracking');
//		$this->tabs['reftracking']->setAttributes('reftracking', L_G_ORIGINALREFERRERTRACKING, 'integration_originalreferrertracking');
    }
    
    //--------------------------------------------------------------------------
    
    function initPermissions()
    {
        $this->modulePermissions['edit'] = 'aff_tool_integration_modify';
        $this->modulePermissions['view'] = 'aff_tool_integration_view';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_REQUEST['action'])) //!empty($_POST['commited'])
        {
            switch($_REQUEST['action'])
            {
                case 'edit':
                    if($this->saveSettings())
                        return;
                    break;
                    
                case 'checkversion':
                    if($this->checkUpdateVersion())
                        return;
                    break;
                    
                case 'update':
                    if($this->updateWizard())
                        return;
                    break;
            }
        }
        
		switch ($_REQUEST['integration_tab_sheet']) {
		    case 'trackingparams':
                  $this->assign('a_tab_desc', L_G_TRACKINGPARAMSDESC);
		          break;
		          
   		    case 'clickstracking':
                  $this->assign('a_tab_desc', L_G_CLICKSTRACKINGDESC);
		          break;
		          		          
            case 'salestracking':
                  $this->assign('a_tab_desc', L_G_SALESTRACKINGDESC);
		          break;
		          
		    default:
		          break;
		}
        
        $this->showSettings();    
    }
    
    //------------------------------------------------------------------------
    
    function protectData() {
        $data = array();
        
        $data['name_a_aid']   = preg_replace('/[^0-9a-zA-Z_]/', '', $_POST['name_a_aid']);
        $data['name_a_bid']   = preg_replace('/[^0-9a-zA-Z_]/', '', $_POST['name_a_bid']);
        $data['name_data1']   = preg_replace('/[^0-9a-zA-Z_]/', '', $_POST['name_data1']);
        $data['name_data2']   = preg_replace('/[^0-9a-zA-Z_]/', '', $_POST['name_data2']);
        $data['name_data3']   = preg_replace('/[^0-9a-zA-Z_]/', '', $_POST['name_data3']);
        $data['name_desturl'] = preg_replace('/[^0-9a-zA-Z_]/', '', $_POST['name_desturl']);
        
        $data['link_style'] = preg_replace('/[\"\']/', '', $_POST['link_style']);
        $data['main_site_url'] = preg_replace('/[\"\']/', '', $_POST['main_site_url']);
        
        $data['integration_method'] = preg_replace('/[\"\']/', '', $_POST['integration_method']);
        
        return $data;
    }
    
    //------------------------------------------------------------------------

    function showSettings($reload = false, $errorTabs = array())
    {
        if($_REQUEST['integration_tab_sheet'] == '') {
            $this->addContent('integration_first_screen');
            return true;
        }
        if($_REQUEST['action'] == '')
            $_REQUEST['action'] = 'edit';

        $this->initTemporaryTE();
        
        $this->assign('a_tab_content', $this->tabs[$_REQUEST['integration_tab_sheet']]->show($this));
         
        $this->addContent('integration_main');

        return true;
    }
    
    //------------------------------------------------------------------------

    function saveSettings()
    {
        if ($_REQUEST['integration_tab_sheet'] == 'salestracking') return false;
        
        if(is_array($GLOBALS['Auth']->permissions) && count($GLOBALS['Auth']->permissions) > 0)
        {
            if(!in_array('aff_tool_settings_modify', $GLOBALS['Auth']->permissions))
            {
                $this->showSettings(true); 
                return true;
            }
        }

        $data = $this->protectData();
        $errorTabs = array();
        $errorMessages = array();
        
        $processedData = array();
        foreach ($this->tabs as $tab) {
            QUnit_Messager::resetMessages();
            if (AFF_DEMO == 1) {
                $newData = $tab->demoProcess($data);
            } else {
                $newData = $tab->process($data);
            }
            $errorMessages = array_merge($errorMessages, QUnit_Messager::getErrorMessages());
            if($newData === false)
            {
                if(QUnit_Messager::getErrorMessage() == '')
                    QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);
                
                $errorTabs[] = $tab->name;
            }
            if(!is_array($newData)) $newData = array();
        	$processedData = array_merge($processedData, $newData);
        }

        if($processedData === false || QUnit_Messager::getErrorMessage() != '')
        {
            if(QUnit_Messager::getErrorMessage() == '')
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);
                
            $this->showSettings(false, $errorTabs); 
        }
        else
        {
            $this->saveProcessData($processedData);

            $this->showSettings(true); 
        }
        
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function saveProcessData($processedData)
    {
        if(is_array($processedData) && count($processedData)>0)
        {
            // save change
            $error = false;
            foreach($processedData as $code => $value)
            {
                if(!QCore_Settings::_update($code, $value, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID()))
                    $error = true;
            }
            
            if($error)
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);
            else
                QUnit_Messager::setOkMessage(L_G_SETTINGSSAVED);
            
            $GLOBALS['Auth']->loadSettings();
        }
    }
    
    //------------------------------------------------------------------------
    
    function lineExplode($text)
    {
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);
        
        $lines = explode("\n", $text);
        
        $commands = array();
        $command = '';
        foreach($lines as $line)
        {
            $command .= " ".$line;
            
            $pos = strrpos($line, ";");
            if($pos === false)
                continue;
                
            // check if there is any text after the semicolon
            if((strlen($line) - $pos)<=2)
            {
                $commands[] = $command;
                $command = '';
            }
        }
        
        return $commands;
    }      
    
    //------------------------------------------------------------------------
    
    function updateWizard() {
        $answer = $this->getPageContents(INTEGRATION_UPDATE_SERVER, INTEGRATION_UPDATE_FILE);
        
        if ($answer == false || $answer == '') {
            QUnit_Messager::setErrorMessage(L_G_UPDATECONNECTIONFAILED);
            return false;
        }
        
        if (!$this->checkUpdateScriptContent($answer)) {
            QUnit_Messager::setErrorMessage(L_G_UPDATESCRIPTCONTAINSFORBIDDENCONTENT);
            return false;
        }
        
        $sqlcommands = $this->lineExplode($answer);
        foreach($sqlcommands as $sql)
        {
            if(strlen($sql) > 20)
            {
                $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                if(!$rs) {
                    QUnit_Messager::setErrorMessage(L_G_ERRORUPDATINGINTEGRATIONWIZARD);
                    return false;
                }
            }
        }  
        
        QUnit_Messager::setOkMessage(L_G_UPDATESUCCESSFUL);
        $GLOBALS['Auth']->loadSettings();
        return false; 
    }
    
    //------------------------------------------------------------------------
    
    function checkUpdateScriptContent($content) {
        $allowedTables = array('wd_pa_integration',
                               'wd_pa_integrationsteps',
                               'wd_g_settings');
        
        $sql = "SHOW TABLE STATUS LIKE 'wd%'";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $forbiddenTables = array();
        while(!$rs->EOF) {
            $forbiddenTables[] = $rs->fields['Name'];
            $rs->MoveNext();
        }
        
        $forbiddenTables = array_diff($forbiddenTables, $allowedTables);
        
        foreach ($forbiddenTables as $table) {
            if (strpos($content, $table) !== false) return false;
        }

        return true;
    }
    
    //------------------------------------------------------------------------
    
    function checkUpdateVersion() {
        $answer = trim($this->getPageContents(INTEGRATION_UPDATE_SERVER, INTEGRATION_VERSION_FILE));
        
        $currentVersion = $GLOBALS['Auth']->getSetting('Aff_integration_version');
        
        if ((answer == false) || ($currentVersion == '')) {
            echo "true";
            return true;
        }
        
        if ($answer > $currentVersion) {
            echo "true";
            return true;
        }
        
        echo "false";
        return true;
    }
        
    //------------------------------------------------------------------------
    
    function getPageContents($host, $path) {
        $beginTag = "#= BEGIN ==================================================================#";
        $endTag   = "#= END ====================================================================#";
        
        $req = "";

        $header .= "GET $path HTTP/1.0\r\n";
        $header .= "Host: $host\r\n";        
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        
        $fp = fsockopen($host, 80, $errno, $errstr, 30);
        if (!$fp) {
            return false;
        }
        fwrite($fp, $header.$req);
        
        $answer = "";
        
        while(!feof($fp)) {
            $answer .= fgets($fp, 1024);
        }
        
        fclose($fp);
        
        if (($pos = strpos($answer, $beginTag)) === false)
            return false;
        
        $answer = substr($answer, $pos+strlen($beginTag));
        
        if (($pos = strpos($answer, $endTag)) === false)
            return false;
            
        $answer = substr($answer, 0, $pos);
        
        return $answer;
    }
}

?>
