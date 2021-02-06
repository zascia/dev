<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_BannerCategory extends QUnit_UI_TemplatePage
{
    var $blBanners;

    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Views_BannerCategory()
    {
        $this->blCategories =& QUnit_Global::newObj('Affiliate_Merchants_Bl_BannerCategories');

        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_BANNERS,'index.php?md=Affiliate_Merchants_Views_BannerManager');
        $this->navigationAddURL(L_G_BANNERCATEGORY,'index.php?md=Affiliate_Merchants_Views_BannerCategory');
    }

    //--------------------------------------------------------------------------

    function initPermissions()
    {
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if( ($_REQUEST['action'] == "edit") && ($_REQUEST['commited'] != "yes") ) {
           	$this->loadInfo();
        }

        if($_REQUEST['commited'] == "yes") {
            $this->processSave();
        }

        $this->show();
    }

    //------------------------------------------------------------------------

    function protectVariables()
    {
        $pvars = array();
        $pvars['pid'] = preg_replace('/[\'\"]/', '', $_POST['bannercategoryid']);
        $pvars['pname'] = preg_replace('/[\'\"]/', '', $_POST['name']);

        return $pvars;
    }

    //------------------------------------------------------------------------

    function checkCorrectness($pvars) {
        checkCorrectness($_POST['pid'], $pvars['bannercategoryid'], L_G_BANNERCATEGORYID, CHECK_ALLOWED);
        checkCorrectness($_POST['name'], $pvars['pname'], L_G_BANNERCATEGORYNAME, CHECK_EMPTYALLOWED);
        return $pvars;
    }

    //------------------------------------------------------------------------

    function processSave() {
        $pvars = $this->protectVariables();
        $pvars = $this->checkCorrectness($pvars);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            if ($_REQUEST['action'] == "edit") {
                if ($this->blCategories->update($pvars) === true) {
                    QUnit_UI_TemplatePage::redirect('Affiliate_Merchants_Views_BannerManager');
                }
            } else {
                // save banner to db
                if(($this->blCategories->insert($pvars)) !== false) {
                    $_POST['action'] = '';
                    QUnit_UI_TemplatePage::redirect('Affiliate_Merchants_Views_BannerManager');
                }
            }
        }

        return false;
    }

    //------------------------------------------------------------------------

    function show() {
        if ($_POST['header'] == '') {
            $_POST['header'] = L_G_ADDBANNERCATEGORY;
        }

        $this->assign('a_md', 'Affiliate_Merchants_Views_BannerCategory');
        $this->addContent('bannercategory_edit');
    }

    //------------------------------------------------------------------------

    function loadInfo() {
        $id = preg_replace('/[\'\"]/', '', $_REQUEST['bannercategoryid']);
        $sql = 'select * from wd_pa_bannercategories where bannercategoryid='._q($id);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        $_POST['bannercategoryid'] = $rs->fields['bannercategoryid'];
        $_POST['name'] = $rs->fields['name'];

        $_POST['header'] = L_G_EDITBANNERCATEGORY;

        return $rs->fields;
    }


}
?>
