<?php
/**
*
*   @author Juraj Sujan
*   @copyright Copyright (c) 2005
*   @package QUnit
*   @since Version 0.1a
*   $Id: FileUpload.class.php,v 1.10 2005/07/21 20:06:58 jsujan Exp $
*/

QUnit_Global::includeClass('QUnit_Object');

class QUnit_Net_FileUpload extends QUnit_Object {

    function QUnit_Net_FileUpload($uploadDir, $fileInfo, $targetFileName = '') {
        $this->fileName = basename($fileInfo['name']);
        $this->tmpName = $fileInfo['tmp_name'];
        $this->mimeType = $fileInfo['type'];
        $this->fileSize = $fileInfo['size'];
        if(!strlen($targetFileName)) {
            $targetFileName = $this->fileName;
        }
        $this->targetFileName = $targetFileName;
        $this->uploadDir = $uploadDir;
        if(!preg_match('/.+\/$/', $this->uploadDir)) {
            $this->uploadDir = $this->uploadDir.'/';
        }
        $this->allowedTypes = array();
    }

    function setAllowedTypes($types) {
        if(is_array($types)) {
            $this->allowedTypes = $types;
        }
    }

    function handleUpload() {
        if(!is_uploaded_file($this->tmpName) || ($this->fileSize == 0)) {
            QUnit_Messager::setErrorMessage(L_G_FILEUPLOADATTACK);
            return false;
        }

        if($this->checkUploadDir() === false) {
            return false;
        }

        if($this->checkFileType() === false) {
            return false;
        }

        if(@move_uploaded_file($this->tmpName, $this->uploadDir.$this->targetFileName)) {
            @chmod($this->uploadDir.$this->targetFileName, 0644);
            return true;
        } else {
            QUnit_Messager::setErrorMessage(L_G_ERRORUPLOADINGBANNER);
        }
        return true;
    }

    function checkUploadDir() {
        if(!strlen($this->uploadDir)) {
            QUnit_Messager::setErrorMessage(L_G_SPECIFIEDBANNERSDIRDOESNOTEXISTS);
            return false;
        }
        if(!file_exists($this->uploadDir)) {
            QUnit_Messager::setErrorMessage(L_G_SPECIFIEDBANNERSDIRDOESNOTEXISTS);
            return false;
        }

        if(!is_writable($this->uploadDir)) {
            QUnit_Messager::setErrorMessage(L_G_SPECIFIEDBANNERSDIRDOESNOTEXISTS);
            return false;
        }
        return true;
    }

    function checkFileType() {
        foreach($this->allowedTypes as $type) {
            if(strlen($type)) {
                if(preg_match('/^.+\.'.$type.'$/', strtolower($this->fileName))) {
                    return true;
                }
            }
        }
        QUnit_Messager::setErrorMessage(L_G_NOTALLOWEDFILETYPE);
        return false;
    }

}
?>