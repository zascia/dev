<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_Banner');

class Affiliate_Merchants_Views_BannerText extends Affiliate_Merchants_Views_Banner
{
    //------------------------------------------------------------------------

    function showBanner() {
        $this->assign('a_bannertemplate', 'banner_edit_text.tpl.php');
        $this->assign('a_md', 'Affiliate_Merchants_Views_BannerText');
        $this->assign('a_hlp', L_G_TEXTBANNERHELP);
        $this->assign('a_type_text', L_G_BANNERTYPE_TEXT);
        
        $this->navigationAddURL(L_G_TEXTBANNER,'index.php?md=Affiliate_Merchants_Views_BannerText');
        
        parent::showBanner();
    }
    
    //------------------------------------------------------------------------

    function protectVariables()
    {
        $pvars = parent::protectVariables();
        $pvars['psourceurl'] = preg_replace('/[\'\"]/', '', $_POST['sourceurl']);
        
        return $pvars;
    }
    
    //------------------------------------------------------------------------        
    
    function checkCorrectness($pvars)
    {
        $pvars = parent::checkCorrectness($pvars);
        
        checkCorrectness($_POST['sourceurl'], $pvars['psourceurl'], L_G_TITLE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['desc'], $pvars['pdesc'], L_G_DESCRIPTION, CHECK_ALLOWED);
        $pvars['ptype'] = BANNERTYPE_TEXT;
        
        return $pvars;
    }
}
?>
