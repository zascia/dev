<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_Banner');

class Affiliate_Merchants_Views_BannerHtml extends Affiliate_Merchants_Views_Banner
{
    //------------------------------------------------------------------------

    function showBanner() {
        $this->assign('a_bannertemplate', 'banner_edit_html.tpl.php');
        $this->assign('a_md', 'Affiliate_Merchants_Views_BannerHtml');
        $this->assign('a_type_text', L_G_BANNERTYPE_HTML);
        $this->assign('a_hlp', L_G_HTMLBANNERHELP);
        $this->assign('a_example', L_G_HTMLBANNEREXAMPLES);
        
        $this->navigationAddURL(L_G_HTMLBANNER,'index.php?md=Affiliate_Merchants_Views_BannerHtml');

        parent::showBanner();
    }
    
    //------------------------------------------------------------------------        
    
    function checkCorrectness($pvars)
    {
        $pvars = parent::checkCorrectness($pvars);
        
        $pvars['ptype'] = BANNERTYPE_HTML;
        checkCorrectness($_POST['desc'], $pvars['pdesc'], L_G_DESCRIPTION, CHECK_ALLOWED);
        
        return $pvars;
    }
}
?>
