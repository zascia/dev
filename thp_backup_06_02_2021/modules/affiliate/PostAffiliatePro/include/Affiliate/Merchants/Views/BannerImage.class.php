<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_Banner');

class Affiliate_Merchants_Views_BannerImage extends Affiliate_Merchants_Views_Banner
{
    //------------------------------------------------------------------------

    function showBanner() {
        $this->assign('a_bannertemplate', 'banner_edit_image.tpl.php');
        $this->assign('a_md', 'Affiliate_Merchants_Views_BannerImage');
        $this->assign('a_hlp', L_G_IMAGEBANNERHELP);
        $this->assign('a_size_msg', '('.L_G_LOADEDFROMIMAGE.')');
        $this->assign('a_type_text', L_G_BANNERTYPE_IMAGE);

        $this->navigationAddURL(L_G_IMAGEBANNER,'index.php?md=Affiliate_Merchants_Views_BannerImage');

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

        $pvars['ptype'] = BANNERTYPE_IMAGE;

        checkCorrectness($_POST['desc'], $pvars['pdesc'], L_G_PICTUREALT, CHECK_ALLOWED);
        $pvars['pdesc'] = htmlspecialchars($pvars['pdesc'], ENT_QUOTES);

        // check file upload
        if($_FILES['sourcebanner']['name'] == '')
        {
            if($_POST['sourceurl'] != '')
            {
                checkCorrectness($_POST['sourceurl'], $pvars['psourceurl'], L_G_PICTUREURL, CHECK_EMPTYALLOWED);
            } else {
                QUnit_Messager::setErrorMessage(L_G_YOUHAVETOSELECTIMAGE);
                return false;
            }
        }
        else
        {
            // check if the file doesn't exist in the banners directory
            if(file_exists($GLOBALS['Auth']->getSetting('Aff_banners_dir').$_FILES['sourcebanner']['name']))
            {
                QUnit_Messager::setErrorMessage(L_G_SPECIFIEDIMAGENAMEALREADYEXISTS);
                return false;
            }
            else
            {
                $oUpload = QUnit_Global::newObj('QUnit_Net_FileUpload',  $GLOBALS['Auth']->getSetting('Aff_banners_dir'), $_FILES['sourcebanner']);

                $oUpload->setAllowedTypes($GLOBALS['UPLOAD_ALLOWED_FILE_TYPES']);

                if($oUpload->handleUpload() === false) {
                    return false;
                }

                $pvars['psourceurl'] = $GLOBALS['Auth']->getSetting('Aff_banners_url').$_FILES['sourcebanner']['name'];

                if ($pvars['pwindow_size_type'] == 0) {
                $size = @GetImageSize($GLOBALS['Auth']->getSetting('Aff_banners_dir').$_FILES['sourcebanner']['name']);
                    if ($size != '') {
                        $pvars['psize'] = WINDOWSIZE_OWN.'_'.$size[0].'_'.$size[1];
                    }
                }
            }
        }
        return $pvars;
    }

}
?>
