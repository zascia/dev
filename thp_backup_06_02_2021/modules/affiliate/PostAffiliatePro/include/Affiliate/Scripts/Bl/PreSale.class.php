<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Scripts_Bl_PreSale
{
    var $blSettings;
    var $salerIndex;

    //--------------------------------------------------------------------------

    function Affiliate_Scripts_Bl_PreSale()
    {
        $this->blSettings =& QUnit_Global::newObj('QCore_Settings');
    }

    //--------------------------------------------------------------------------

    function process() {
        $this->salerIndex = $_REQUEST['salerIndex'];
        
        if ($_REQUEST['loadCookies'] == '1') {
            $this->load3rdPartyCookies();
        }
        
        $this->setCookiesToBeDeleted();
        
        $this->finishSale();
    }

    //--------------------------------------------------------------------------

    function load3rdPartyCookies() {
        if ($_COOKIE[COOKIE_NAME] != '') {
            echo "set3rdPartyCookie(".$this->salerIndex.",'".COOKIE_NAME."', '".$_COOKIE[COOKIE_NAME]."');\n";
        }

        if ($_COOKIE[TIME_COOKIE_NAME] != '') {
            echo "set3rdPartyCookie(".$this->salerIndex.",'".TIME_COOKIE_NAME."', '".$_COOKIE[TIME_COOKIE_NAME]."');\n";
        }

        if ($_COOKIE[REF_COOKIE_NAME] != '') {
            echo "set3rdPartyCookie(".$this->salerIndex.",'".REF_COOKIE_NAME."', '".$_COOKIE[REF_COOKIE_NAME]."');\n";
        }
    }

    //--------------------------------------------------------------------------

    function setCookiesToBeDeleted()
    {
        if($this->blSettings->getSettings("Aff_delete_cookie") == 1) {
             echo "setCookieToBeDeleted(".$this->salerIndex.", '".COOKIE_NAME."');\n";   
        }
    }
    
	//-------------------------------------------------------------------------

    function finishSale()
    {
        echo "finishSale(".$this->salerIndex.");\n";
    }
}
?>
