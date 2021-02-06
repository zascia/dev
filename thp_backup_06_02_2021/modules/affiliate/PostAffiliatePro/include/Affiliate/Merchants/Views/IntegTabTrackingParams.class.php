<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_IntegTabTrackingParams extends Affiliate_Merchants_Views_TabSettings
{
    var $names;
    
    function Affiliate_Merchants_Views_IntegTabTrackingParams() {
        $this->names = array(array('id' => 'name_a_aid'   ,'name' => L_G_AFFILIATEID_REFERERID),
                             array('id' => 'name_a_bid'   ,'name' => L_G_BANNERID),
                             array('id' => 'name_data1'   ,'name' => L_G_DATA1),
                             array('id' => 'name_data2'   ,'name' => L_G_DATA2),
                             array('id' => 'name_data3'   ,'name' => L_G_DATA3),
                             array('id' => 'name_desturl' ,'name' => L_G_DESTURL) );
    }
    
    //------------------------------------------------------------------------
    
    function saveToFile($data) {
        if (GLOBAL_DB_ENABLED == 1) {
            $filename = CACHE_PATH.$GLOBALS['Auth']->getLIteAccountID().'_paramNames.php';
        } else {
            $filename = CACHE_PATH.'paramNames.php';
        }
        
        if (($fp = fopen ($filename, "w")) == false) {
            QUnit_Messager::setErrorMessage(L_G_ERROROPENINGTRACKINGPARAMSSETTINGSFILE);
            return false;
        }        
        
        fputs($fp, "<?php\n");
        
        foreach ($this->names as $name) {
            fputs($fp, "define('".strtoupper($name['id'])."', '".$data[$name['id']]."');\n");
        }
        
        fputs($fp, "?>");
        return true;
    }
    
	//------------------------------------------------------------------------

    function process($data)
    {
                       
        for ($i=0; $i<count($this->names); $i++) {
            checkCorrectness($_POST[$this->names[$i]['id']], $data[$this->names[$i]['id']], $this->names[$i]['name'], CHECK_EMPTYALLOWED);
            
            if ($data[$this->names[$i]['id']] == 'a_sbid')
                QUnit_Messager::setErrorMessage(L_G_PARAMETERNAME.' a_sbid '.L_G_ISRESERVED);
            for ($j=$i+1; $j<count($this->names); $j++) {
                if ($data[$this->names[$i]['id']] == $data[$this->names[$j]['id']]) {
                    QUnit_Messager::setErrorMessage($this->names[$i]['name']." ".L_G_AND." ".$this->names[$j]['name']." ".L_G_CANNOTBESAME);
                }
            }
        }
        
        if(QUnit_Messager::getErrorMessage() == '')
        {
            $this->saveToFile($data);
            
            $settings = array();
            foreach ($this->names as $name) {
                $settings['Aff_tracking_param_'.$name['id']] = $data[$name['id']];
            }
            
            return $settings;
        }

        return false;
    }
    
    //------------------------------------------------------------------------
    
    function show($parent)
	{
	    $settings = $GLOBALS['Auth']->getSettings();
	    
	    /*foreach ($this->names as $name) {
	        if ($_POST[$name['id']] == "") {
	           $_POST[$name['id']] = $settings['Aff_tracking_param_'.$name['id']];
	        }
	    }*/
	    if ($_POST['commited'] != "yes") {
	        $_POST['name_a_aid']   = PARAM_A_AID;
            $_POST['name_a_bid']   = PARAM_A_BID;
            $_POST['name_data1']   = PARAM_DATA1;
            $_POST['name_data2']   = PARAM_DATA2;
            $_POST['name_data3']   = PARAM_DATA3;
            $_POST['name_desturl'] = PARAM_DESTURL;
	    }
	    
		return $parent->temporaryFetch($this->template);
	}
}

?>