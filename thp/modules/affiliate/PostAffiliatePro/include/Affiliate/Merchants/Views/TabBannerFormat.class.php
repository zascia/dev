<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_TabSettings');


class Affiliate_Merchants_Views_TabBannerFormat extends Affiliate_Merchants_Views_TabSettings
{
	//------------------------------------------------------------------------
    
    function process($data) {
        $textFormat = $data['bannerformat_textformat'];
        if(!strstr($textFormat, '$TITLE')) {
            QUnit_Messager::setErrorMessage(L_G_BANNERFORMAT_TITLEEXISTS);
        }
        if(!strstr($textFormat, '$DESCRIPTION')) {
            QUnit_Messager::setErrorMessage(L_G_BANNERFORMAT_DESCEXISTS);
        }
        if(!strstr($textFormat, '$DESTINATION')) {
            QUnit_Messager::setErrorMessage(L_G_BANNERFORMAT_DESTEXISTS);
        }
        if(!strstr($textFormat, '$IMPRESSION_TRACK')) {
            QUnit_Messager::setErrorMessage(L_G_BANNERFORMAT_TRACKEXISTS);
        }
        
        $graphicFormat = $data['bannerformat_graphicsformat'];
        if(!strstr($graphicFormat, '$DESTINATION')) {
            QUnit_Messager::setErrorMessage(L_G_GRAPHICBANNERFORMAT_DESTEXISTS);
        }
        if(!strstr($graphicFormat, '$IMAGE_SRC')) {
            QUnit_Messager::setErrorMessage(L_G_GRAPHICBANNERFORMAT_TRACKEXISTS);
        }

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
            'Aff_bannerformat_textformat'    => $data['bannerformat_textformat'],
            'Aff_bannerformat_graphicformat' => $data['bannerformat_graphicsformat'],
            );
        }

        return false;
    }
}

?>