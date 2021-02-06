<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================


QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QCore_Bl_GlobalDb');

class Affiliate_Merchants_Views_News extends QUnit_UI_TemplatePage
{
    function Affiliate_Merchants_Views_News() {
    }

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['action'])
            {
                case 'changestatus':
                    if($this->processChangeNewsStatus())
                        return;
                    break;
            }
        }

        $this->drawShowNews($GLOBALS['Auth']->getLiteAccountID());    
    }

    //------------------------------------------------------------------------

    function processChangeNewsStatus()
    {
        $pmessageid = preg_replace('/[\'\"]/', '', $_POST['nid']);
        $pview_old = preg_replace('/[\'\"]/', '', $_POST['view_old']);
        
        $globalDB = QCore_Bl_GlobalDb::getInstance();
        $globalDB->changeMessageStatus($pmessageid, $GLOBALS['Auth']->getUserID(), $GLOBALS['Auth']->getLiteAccountID(), MESSAGESTATUS_NOT_SHOW);

        $this->myRedirect();

        return true;
    }

    //------------------------------------------------------------------------

    function drawShowNews($p_accountid)
    {
        $nid = preg_replace('/[\'\"]/', '', $_REQUEST['nid']);

        $_POST['header'] = L_G_NEWS;
        $_POST['action'] = 'changestatus';
        $_POST['nid'] = $nid;

        $params = array('messageid' => $nid,
                        'userid' => $GLOBALS['Auth']->getUserID(),
                        'liteaccountid' => $GLOBALS['Auth']->getLiteAccountID(),
                        'view_old' => '1'
                       );
                       
        $globalDB = QCore_Bl_GlobalDb::getInstance();
        $news = $globalDB->getMerchantNews($params);
        $this->assign('a_news_data', $news[$nid]);
        
        if(($news[$nid]['status'] == MESSAGESTATUS_NOT_READED) || ($news[$nid]['status'] == ''))
            $globalDB->changeMessageStatus($nid, $GLOBALS['Auth']->getUserID(), $GLOBALS['Auth']->getLiteAccountID(), MESSAGESTATUS_SHOW);

        $this->assign_md();
        $this->addContent('merch_news');

        return true;
    }

    //------------------------------------------------------------------------
  
    function assign_md()
    {
    	$this->assign('a_md', 'Affiliate_Merchants_Views_News');
    }
    
    //------------------------------------------------------------------------
    
    function myRedirect()
    {
    	$this->redirect('Affiliate_Merchants_Views_MerchantProfile&view_old='.$pview_old);
    }
    
}
?>
