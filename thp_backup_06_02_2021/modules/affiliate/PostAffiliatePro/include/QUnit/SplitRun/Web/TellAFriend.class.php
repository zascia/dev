<?php
/**
*
*   @author Maros Fric
*   @copyright Copyright (c) quality unit
*   All rights reserved
*
*   @package global
*   @since Version 1.0
*
*   Tell A Friend logging script
*   
*   For support contact support@qualityunit.com
*/


class QUnit_SplitRun_Web_TellAFriend {

    var $_dbConn = null;
    
    //------------------------------------------------------------------------
    
    function setDB($dbObj) {
        $this->_dbConn =& $dbObj;
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function log($params) {
        if($this->_dbConn == null || !$this->_dbConn) {
            return false;
        }
        
        $params['receivecopy'] = ($params['receivecopy'] == '' ? 0 : $params['receivecopy']);
        
        $sql = "insert into wd_web_tellafriend(fromname, fromemail, dateinserted, ip, fromcoupon, coupontype, receivecopy, message)".
                " values("._q($params['fromname']).","._q($params['fromemail']).",NOW(),"._q($params['ip']).","._q($params['fromcoupon']).
                ","._q($params['t']).","._q($params['receivecopy']).","._q($params['message']).")";
        
        $ret =& $this->_dbConn->query($sql);
        
        if(!$ret) {
            return false;
        }
        
        $tafID = $this->_dbConn->createUniqueId();
        
        for($i=1; $i<=$params['count']; $i++) {
            $val = $params['toemail'.$i];
            
            if($val != '') {
                $sql = "insert into wd_web_tellafriendemail(tafid, toemail, dateinserted, tocoupon, coupontype)".
                " values("._q($tafID).","._q($val).",NOW(),"._q($params['tocoupon'.$i]).",3)";
                $ret =& $this->_dbConn->query($sql);
                if(!$ret) {
                    return false;
                }
            }
        }
        
        return true;
    }
}

?>
