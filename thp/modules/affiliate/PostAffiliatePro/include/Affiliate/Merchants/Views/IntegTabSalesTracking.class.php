<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_IntegTabSalesTracking extends Affiliate_Merchants_Views_TabSettings
{
    var $blIntegration;

    //------------------------------------------------------------------------

    function Affiliate_Merchants_Views_IntegTabSalesTracking() {
        $this->blIntegration = QUnit_Global::newObj('Affiliate_Merchants_Bl_Integration');
    }

	//------------------------------------------------------------------------

    function process($data)
    {
        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_integration_method' => $data['integration_method'],
                        );
        }

        return false;
    }

    //------------------------------------------------------------------------

    function translate($text) {
        $COOKIE_JS_CODE = COOKIE_JS_CODE;
        $SCRIPTDIR      = $GLOBALS['Auth']->getSetting('Aff_scripts_url');
        if($_POST['integration_secure'] == '1') {
            $SCRIPTDIR = preg_replace('/^http/', 'https', $SCRIPTDIR);
            $text = str_replace('papSale()', "var _sc=true;\npapSale()", $text);
            $text = str_replace('paypalSale()', "var _sc=true;\npaypalSale()", $text);
        } else {
            $SCRIPTDIR = preg_replace('/^https/', 'http', $SCRIPTDIR);
        }
        $AID            = PARAM_A_AID;
        $BID            = PARAM_A_BID;
        $DATA1          = PARAM_DATA1;
        $DATA2          = PARAM_DATA2;
        $DATA3          = PARAM_DATA3;
        if (GLOBAL_DB_ENABLED == 1) {
            $LID            = $GLOBALS['Auth']->getLiteAccountID();
            $text = str_replace('$LID_JS', 'var _lid="'.$LID.'";', $text);
            $text = str_replace('$LID_URL', 'lid='.$LID.'&', $text);
        }

        $text = str_replace('$COOKIE_JS_CODE', $COOKIE_JS_CODE, $text);
        $text = str_replace('$SCRIPTDIR',      $SCRIPTDIR, $text);
        $text = str_replace('$AID',            $AID, $text);
        $text = str_replace('$BID',            $BID, $text);
        $text = str_replace('$DATA1',          $DATA1, $text);
        $text = str_replace('$DATA2',          $DATA2, $text);
        $text = str_replace('$DATA3',          $DATA3, $text);

        return $text;
    }

	//------------------------------------------------------------------------

    function show(&$parent)
	{
	    if ($_POST['integration_method'] == "")
	       $_POST['integration_method'] = $GLOBALS['Auth']->getSetting('Aff_integration_method');
	    if ($_POST['integration_method'] == "") {
	       $_POST['integration_method'] = $this->blIntegration->getFirstIntegrationId();
	    }
        if ($_POST['integration_secure'] == "")
           $_POST['integration_secure'] = $GLOBALS['Auth']->getSetting('Aff_integration_secure');

	    $integrationRs = $this->blIntegration->getIntegrationMethodsAsRs();
        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($integrationRs);
        $parent->temporaryAssign('a_list_intmethods', $list_data);

        $integrationStepsRs = $this->blIntegration->getIntegrationStepsAsRs($_POST['integration_method']);
        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($integrationStepsRs);
        $parent->temporaryAssign('a_list_intsteps', $list_data);

        $parent->temporaryAssign('a_translator', $this);

		return parent::show($parent);
	}
}

?>