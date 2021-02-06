<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Scripts_Bl_ReplicatedSite
{
    var $blSettings;
    var $replicationDir;
    var $siteTemplate;
    var $isEnabled;
    var $oldUser;

    //--------------------------------------------------------------------------

    function Affiliate_Scripts_Bl_ReplicatedSite()
    {
        $this->blSettings =& QUnit_Global::newObj('QCore_Settings');
        $settings = $this->blSettings->getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID);
        $this->replicationDir = $GLOBALS['PROJECT_ROOT_PATH'].'/merchants/'.$settings['Aff_replication_dir'];
        $this->siteTemplate = $settings['Aff_replication_template'];
        $this->isEnabled = $settings['Aff_replication_enable'];
    }

    //--------------------------------------------------------------------------
 
    function createAllFiles() {
        $sql = "SELECT * FROM wd_g_users WHERE".
               " deleted='0'".
               " AND rstatus="._q(AFFSTATUS_APPROVED).
               " AND rtype="._q(USERTYPE_USER);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        while (!$rs->EOF) {
            $this->writeFile($rs->fields);
            $rs->MoveNext();
        }
        
        if (count(QUnit_Messager::getErrorMessages()) == 0) {
            return true;        
        } else {
            return false;
        }
    }
    
    //--------------------------------------------------------------------------
    
    function createFile($userid) {
        if ($this->isEnabled != '1') return true;
        
        if (!($user = $this->getUser($userid))) return false;
        
        return $this->writeFile($user);
    }
    
	//--------------------------------------------------------------------------
    
    function deleteFile($userid) {
        if ($this->isEnabled != '1') return true;
        
        if (!($user = $this->getUser($userid, '', ''))) return false;
        
        return $this->deleteReplicatedFile($user);
    }
    
	//--------------------------------------------------------------------------
    
    function userStatusChanged($userid) {
        if ($this->isEnabled != '1') return true;
        
        if (!($user = $this->getUser($userid, ''))) return false;
        
        if ($user['rstatus'] == AFFSTATUS_APPROVED) {
            return $this->writeFile($user);
        } else {
            return $this->deleteReplicatedFile($user);
        }        
    }
    
    //--------------------------------------------------------------------------
    
    function saveOldUser($userid) {
        if ($this->isEnabled != '1') return true;
        
        if (!($user = $this->getUser($userid, ''))) return false;
        
        $this->oldUser = $user;
        
        return true;
    }
    
	//--------------------------------------------------------------------------
    
    function changeFile($userid) {
        if ($this->isEnabled != '1') return true;
        
        if (!($user = $this->getUser($userid, ''))) return false;
        
        if ($this->oldUser != '') {
            $this->deleteReplicatedFile($this->oldUser);
        }
        
        return $this->writeFile($user);
    }
    
    //--------------------------------------------------------------------------
    
    function writeFile($user) {
        $fileName = $this->getFileName($user);
        $handle = @fopen($this->replicationDir.'/'.$fileName, "wb");
        if($handle == false) {
            QUnit_Messager::setErrorMessage(L_G_SITEREPLICATIONDIRNOTWRITABLE);
            return false;
        }
    
        fputs($handle, $this->fillTemplate($user));

        fclose($handle);
    }
    
    //--------------------------------------------------------------------------
    
    function deleteReplicatedFile($user) {
        $fileName = $this->getFileName($user);
        
        return @unlink($this->replicationDir.'/'.$fileName);
    }
    
    //--------------------------------------------------------------------------
    
    function getUser($userid, $status = AFFSTATUS_APPROVED, $deleted = '0') {
        $sql = "SELECT * FROM wd_g_users WHERE".
               " rtype="._q(USERTYPE_USER).
               " AND userid="._q($userid);
        if ($status != '') {
            $sql .= " AND rstatus="._q($status);
        }
        if ($deleted != '') {
            $sql .= " AND deleted="._q($deleted);
        }
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        if ($rs->EOF) {
            return false;
        }
        
        return $rs->fields;
    }
    
    //--------------------------------------------------------------------------
    
    function getFileName($user) {
        return (($user['refid'] == '') ? $user['userid'] : $user['refid']).'.html';
    }
    
    //--------------------------------------------------------------------------
    
    function fillTemplate($user) {
        $template = $this->siteTemplate;
        
        $template = str_replace('$Affiliate_id',           $user['userid'], $template);
        $template = str_replace('$Affiliate_refid',        $user['refid'], $template);
        $template = str_replace('$Affiliate_name',         $user['name']+" "+$user['surname'], $template);
        $template = str_replace('$Affiliate_firstname',    $user['name'], $template);
        $template = str_replace('$Affiliate_lastname',     $user['surname'], $template);
        $template = str_replace('$Affiliate_username',     $user['username'], $template);
        $template = str_replace('$Affiliate_data1',        $user['data1'], $template);
        $template = str_replace('$Affiliate_data2',        $user['data2'], $template);
        $template = str_replace('$Affiliate_data3',        $user['data3'], $template);
        $template = str_replace('$Affiliate_data4',        $user['data4'], $template);
        $template = str_replace('$Affiliate_data5',        $user['data5'], $template);
        
        $template = str_replace('$Click_tracking_code',    $this->getClickTrackingCode($user['userid']), $template);
        
        return $template;
    }
    
    //--------------------------------------------------------------------------
    
    function getClickTrackingCode($userID) {
        return '<script id="pap_x2s6df8d" src="'.$this->blSettings->getSettings('Aff_scripts_url').'track.js" type="text/javascript"></script>'."\n".
               '<script type="text/javascript">'."\n".
	           '<!--'."\n".
	           'var AffiliateID=\''.$userID.'\''."\n".
               'papTrack();'."\n".
	           '//-->'."\n".
               '</script>'."\n";
    }
}
?>
