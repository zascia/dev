<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_FileImport extends QUnit_UI_TemplatePage
{
    var $id;
    var $fileFormat;
    var $columns;
    var $selectedFields;
    var $fieldsToDisplay;
    var $table;
    var $title;
    var $description;
    var $progressDescription;
    var $message;
    var $md;
    
    //--------------------------------------------------------------------------

    function process()
    {
        $this->assign('a_title', $this->title);
        $this->assign('a_description', $this->description);
        $this->assign('a_progress_description', $this->progressDescription);
        $this->assign('a_fieldsToDisplay', $this->fieldsToDisplay);
        
        if($_GET['action'] == 'import') {
            $this->navigationAddURL(L_G_TRANSACTION_IMPORT_RESULTS,'');
            $this->processFileImport();
            $this->assign('a_message', $this->message);
            $this->addContent('file_import_progress_popup');
            return true;
        }
        
        if($_POST['commited'] == 'yes') {
            if ($this->processSaveSettings()) {
                $this->navigationAddURL(L_G_TRANSACTION_IMPORT_RESULTS,'');
                return true;
            }
        } else {
            $this->loadFromSettings();
        }
    
        $this->showImportForm();
    }
    
    //--------------------------------------------------------------------------

    function processFileImport()
    {
        $file = QUnit_Global::newObj('Affiliate_Merchants_Bl_ImportFile');
        $settings = $GLOBALS['Auth']->getSettings();
        for ($i = 0; $i < count($this->columns); $i++) {
        	if ( ($settings['Acct_'.$this->id.'_import_field'.$i.'_type'] != '___') && ($settings['Acct_'.$this->id.'_import_field'.$i.'_type'] != '') ) {
        	    $file->addField($i, $settings['Acct_'.$this->id.'_import_field'.$i.'_type']);
        	}
        }
        switch ($settings['Acct_'.$this->id.'_import_separator']) {
            case 'other':
                $file->setSeparator($settings['Acct_'.$this->id.'_import_separator_other']);
                break;
            case 'tab':
                $file->setSeparator("\t");
                break;
            default:
                $file->setSeparator($settings['Acct_'.$this->id.'_import_separator']);
                break;
        }
        
        if (!$file->open($GLOBALS['Auth']->getSetting('Aff_export_dir').$_GET['filename'])) {
            QUnit_Messager::setErrorMessage(L_G_ERROROPENINGFILE);
        }
        
        $line = 0;
        $this->message = "";
        if ($_GET['start'] != '1') {
            $file->setPosition($_SESSION['import_offset']);
            $line = $_SESSION['import_line'];
        } else {
            $this->assign('a_line', 0);
            $_SESSION['import_offset'] = $_SESSION['import_line'] = 0;
            $_SESSION['import_lineOK'] = 0;
            $_SESSION['import_lineERROR'] = 0;
            Redirect_nomsg("index_popup.php?md=".$this->md."&action=import&filename=".$_GET['filename']);
            return;
        }
        
        $maxTimeToRun = (ini_get('max_execution_time') == '') ? 20 : ini_get('max_execution_time') - 10;
        
        // processing loop
        while (($data = $file->getNextRecord()) !== false) {
            if (($settings['Acct_'.$this->id.'_import_skipfirstrow'] == '1') && ($line == 0)) {
                $line++;
                continue;
            }
            
            QUnit_Page::end_timer();
			if (QUnit_Page::getTimeGenerated() > $maxTimeToRun) {
				$_SESSION['import_line'] = $line;
				$this->assign('a_line', $line);
				Redirect_nomsg("index_popup.php?md=".$this->md."&action=import&filename=".$_GET['filename']);
				return;
			}
			$_SESSION['import_offset'] = $file->getPosition();
            
            if (!is_array($data)) {
                $msg = "x=t.insertRow(2);\n".
                       "x.insertCell(0).innerHTML='".($line+1)."';\n".
                       "x.insertCell(1).innerHTML='".L_G_COLUMN." ".$this->columns[$data]['description']." ".L_G_ISMISSING."';\n".
                       "x.className='listrow".($line%2)."';\n";
                $this->printMessage($msg);
                $line++;
                $file->saveLineToErrorFile();
                $_SESSION['import_lineERROR']++;
                continue;
            }
            
            $msg1 = '';
            $i = 2;
            foreach ($this->fieldsToDisplay as $name) {
                $msg1 .= "x.insertCell(".$i++.").innerHTML='".$data[$name]."';\n";
            }
            
            if (!isset($data['dateinserted'])) {
                $data['dateinserted'] = date("Y-m-d H:i:s");
            }
            
            if (($errorMsg = $this->insertRow($data)) != L_G_OK) {
                $file->saveLineToErrorFile();
                $_SESSION['import_lineERROR']++;
            } else {
                $_SESSION['import_lineOK']++;
            }
            
            $msg = "x=t.insertRow(2);\n".
                   "x.insertCell(0).innerHTML='".($line+1)."';\n".
                   "x.insertCell(1).innerHTML='".$errorMsg."';\n".
                   "x.className='listrow".($line%2)."';\n";
                   
                   
            $this->printMessage($msg.$msg1);
            $line++;
        }
        
        $file->close();
        $this->assign('a_filename', $GLOBALS['Auth']->getSetting('Aff_export_dir').$_GET['filename']."_ERROR");
        $this->assign('a_line', -1);
        
        $this->afterImportFunc();
    }
    
    //--------------------------------------------------------------------------
    
    function afterImportFunc() {
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function insertRow($data) {
        $sql = "INSERT INTO ".$this->table." ".
               "(".implode(",", array_keys($data)).") ".
               "VALUES ('".implode("','", array_values($data))."')";

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs) {
            return L_G_DBERROR;
        } else {
            return L_G_OK;
        }
    }
    
    //--------------------------------------------------------------------------
    
    function printMessage($msg) {
        $this->message .= $msg;
    }

    //--------------------------------------------------------------------------

    function showImportForm()
    {
        $this->assign('a_columns', $this->columns);
        
        $this->addContent('file_import');
    }
    
    //--------------------------------------------------------------------------

    function processSaveSettings()
    {
        // protect against script injection
    	for ($i = 0; $i < count($this->columns); $i++) {
        	$data['field'.$i.'_type'] = preg_replace('/[\'\"]/', '', $_POST['field'.$i.'_type']);
        }
        $data['separator'] = preg_replace('/[\'\"]/', '', $_POST['separator']);
        $data['separator_other'] = preg_replace('/[\'\"]/', '', $_POST['separator_other']);
        $data['file_fromexport'] = preg_replace('/[\'\"]/', '', $_POST['file_fromexport']);
        $data['file_radio'] = preg_replace('/[^1-2]/', '', $_POST['file_radio']);
        $data['skipfirstrow'] = preg_replace('/[^0-1]/', '', $_POST['skipfirstrow']);
        
        if ( ($data['separator'] == 'other') && ($data['separator_other'] == '') ) {
        	QUnit_Messager::setErrorMessage(L_G_OTHERSEPARATORCANTBEBLANK);
        	return false;
        }
        
        $this->checkDuplicityAndMandatoryFields($data);
        
        if ($data['file_radio'] == '1') {
            if (($filename = $this->processFileUpload()) == false) {
                QUnit_Messager::setErrorMessage(L_G_ERRORUPLOADINGFILE);
            }
        } else {
            checkCorrectness($_POST['file_fromexport'], $data['file_fromexport'], L_G_FILEFROMEXPORTSDIR, CHECK_EMPTY);
            $filename = $data['file_fromexport'];
            if (!file_exists($GLOBALS['Auth']->getSetting('Aff_export_dir').$filename))
                QUnit_Messager::setErrorMessage(L_G_FILEDOESNOTEXIST);
        }
        
        if (QUnit_Messager::getErrorMessage() != '') {
            return false;
        }
        
        $this->saveSettings($data);
        
        if (QUnit_Messager::getErrorMessage() == '') {
            $this->assign('a_filename', $filename);
            $this->assign('a_selectedFields', $this->selectedFields);
            $this->assign('a_columns', $this->columns);
            $this->addContent('file_import_progress');
            return true;
        }   
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function processFileUpload() {
        // check file upload
        if($_FILES['file_fromupload']['name'] != '') {
            
            $filename = '_x2g68t_import_'.$this->id.'.txt';
            
            $oUpload = QUnit_Global::newObj('QUnit_Net_FileUpload',
                                            $GLOBALS['Auth']->getSetting('Aff_export_dir'),
                                            $_FILES['file_fromupload'],
                                            $filename);

            $oUpload->setAllowedTypes($GLOBALS['UPLOAD_ALLOWED_FILE_TYPES']);

            if($oUpload->handleUpload() === false) {
                return false;
            }
            
            return $filename;
        }
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function loadFromSettings() {
        $settings = $GLOBALS['Auth']->getSettings();
        for ($i = 0; $i < count($this->columns); $i++) {
        	$_POST['field'.$i.'_type'] = $settings['Acct_'.$this->id.'_import_field'.$i.'_type'];
        }
        $_POST['separator'] = $settings['Acct_'.$this->id.'_import_separator'];
        $_POST['separator_other'] = $settings['Acct_'.$this->id.'_import_separator_other'];
        $_POST['skipfirstrow'] = $settings['Acct_'.$this->id.'_import_skipfirstrow'];
        if ($settings['Acct_'.$this->id.'_import_file_fromexport'] != '') {
            $_POST['file_fromexport'] = $settings['Acct_'.$this->id.'_import_file_fromexport'];
            $_POST['file_radio'] = 2;
        }
    }
    
    //--------------------------------------------------------------------------
    
    function saveSettings($data) {
        $settings = array();
        for ($i = 0; $i < count($this->columns); $i++) {
        	$settings['Acct_'.$this->id.'_import_field'.$i.'_type'] = $data['field'.$i.'_type'];
        }
        $settings['Acct_'.$this->id.'_import_separator'] = $data['separator'];
        $settings['Acct_'.$this->id.'_import_separator_other'] = $data['separator_other'];
        $settings['Acct_'.$this->id.'_import_skipfirstrow'] = $data['skipfirstrow'];
        if ($data['file_radio'] == '2')
            $settings['Acct_'.$this->id.'_import_file_fromexport'] = $data['file_fromexport'];
        
        $error = false;
        foreach($settings as $code => $value)  {
            if(!QCore_Settings::_update($code, $value, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID()))
                $error = true;
        }
        
        if($error)
            QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);
        else
            QUnit_Messager::setOkMessage(L_G_SETTINGSSAVED);
        
        $GLOBALS['Auth']->loadSettings();
    }
    
    //--------------------------------------------------------------------------
    
    function checkDuplicityAndMandatoryFields($data)
	{
		$this->selectedFields = array();
		for ($i = 0; $i < count($this->columns); $i++) {
        	if ($data['field'.$i.'_type'] != "___") {
        		$this->selectedFields[] = $data['field'.$i.'_type'];
        	}
        }
        // duplicate fields
        if (array_unique($this->selectedFields) != $this->selectedFields) {
        	QUnit_Messager::setErrorMessage(L_G_DUPLICATEFIELDSELECTED);
        }
        // mandatory fields
        foreach ($this->columns as $name => $field) {
            if ( ($field['type'] & FIELD_MANDATORY != 0) && (!in_array($name, $this->selectedFields))) {
                QUnit_Messager::setErrorMessage(L_G_MANDATORYFIELD.' '.$field['description'].' '.L_G_NOTSELECTED);
            }
        }
	}
    
    //--------------------------------------------------------------------------
    
    function addColumn($name, $description, $type = 0) {
        $this->columns[$name] = array('description' => $description, 'type' => $type);
    }
}  
?>
