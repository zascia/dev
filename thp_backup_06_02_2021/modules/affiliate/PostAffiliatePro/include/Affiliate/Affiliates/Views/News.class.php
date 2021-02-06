<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================


QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Affiliates_Views_News extends QUnit_UI_TemplatePage
{
    var $blCommunications;

    function Affiliate_Affiliates_Views_News() {
        $this->blCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');
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

        $this->drawShowNews($GLOBALS['Auth']->getAccountID());    
    }

    //------------------------------------------------------------------------

    function processChangeNewsStatus()
    {
        $pmessageid = preg_replace('/[\'\"]/', '', $_POST['nid']);
        $pview_old = preg_replace('/[\'\"]/', '', $_POST['view_old']);

        $this->blCommunications->changeMessageStatus($pmessageid, $GLOBALS['Auth']->getUserID(), MESSAGESTATUS_NOT_SHOW);

        $this->myRedirect();

        return true;
    }

    //------------------------------------------------------------------------

    function drawShowNews($p_accountid)
    {
        $nid = preg_replace('/[\'\"]/', '', $_REQUEST['nid']);

/*    
        $params = array(
                        'userid' => $GLOBALS['Auth']->getUserID(),
                        'accountid' => $GLOBALS['Auth']->getAccountID()
                       );
    
        $user_news = $this->blCommunications->getUserNews($params);
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($user_news[$GLOBALS['Auth']->getUserID()]);
        $this->assign('a_list_data', $list_data);

        $this->addContent('news_list');
*/
        $_POST['header'] = L_G_NEWS;
        $_POST['action'] = 'changestatus';
        $_POST['nid'] = $nid;

        $params = array('messageid' => $nid,
                        'userid' => $GLOBALS['Auth']->getUserID(),
                        'accountid' => $GLOBALS['Auth']->getAccountID()
                       );

        $news = $this->blCommunications->getNews($params);
        $this->assign('a_news_data', $news);

        if($news['status'] == MESSAGESTATUS_NOT_READED)
            $this->blCommunications->changeMessageStatus($nid, $GLOBALS['Auth']->getUserID(), MESSAGESTATUS_SHOW);

        $this->assign_md();
        $this->addContent('aff_news');

        return true;
    }

    //------------------------------------------------------------------------
  
    function assign_md()
    {
    	$this->assign('a_md', 'Affiliate_Affiliates_Views_News');
    }
    
    //------------------------------------------------------------------------
    
    function myRedirect()
    {
    	$this->redirect('Affiliate_Affiliates_Views_MainPage&view_old='.$pview_old);
    }
    
}
?>
