<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabSiteReplication extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------

    function process($data)
    {
        if ($data['sr_enable'] == '1') {
            checkCorrectness($_POST['sr_directory'], $data['sr_directory'], L_G_DIRECTORYFORREPLICATION, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['sr_directoryurl'], $data['sr_directoryurl'], L_G_URLTODIRECTORYFORREPLICATION, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['sr_template'], $data['sr_template'], L_G_SITEREPLICATIONTEMPLATE, CHECK_EMPTY);
            
            if(QUnit_Messager::getErrorMessage() == '') {
                $this->checkDirectoryWritable($data['sr_directory']);
                $this->checkTemplate($data['sr_template']);
            }
        }
                
        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_replication_enable'  => $data['sr_enable'],
                            'Aff_replication_dir'     => $data['sr_directory'], 
                            'Aff_replication_url'     => $data['sr_directoryurl'],
                            'Aff_replication_template' => $data['sr_template'],
                            );
        }
        
        return false;
    }	
    
    //------------------------------------------------------------------------
    
	function checkDirectoryWritable($dir) {
	    // temp file name
        $uniq = 'dir_writable_check.txt';

        $handle = @fopen($dir.'/'.$uniq, "wb");
        if($handle == false) {
            QUnit_Messager::setErrorMessage(L_G_SITEREPLICATIONDIRNOTWRITABLE);
            return false;
        }

        fclose($handle);
        return true;
	}
	
	//------------------------------------------------------------------------
    
	function checkTemplate($template) {
	    if(!strstr($template, '$Click_tracking_code')) {
            QUnit_Messager::setErrorMessage(L_G_SITETEMPLATE_CLICK_TRACKING_DOESNOTEXISTS);
        }
	}
    
    //------------------------------------------------------------------------
    
	function demoProcess($data)
	{
		return array();
	}
	
	//------------------------------------------------------------------------
	
	function show($parent)
	{
		$list_data = QUnit_Global::newobj('QCore_RecordSet');
		$list_data->setTemplateRS(QCore_Settings::getAvailableLangs());
        $parent->temporaryAssign('a_list_data', $list_data);
		return $parent->temporaryFetch($this->template);
	}
}

?>