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
*   Generation and checking of discount coupons for qualityunit.com web site
*   Coupons have different types:
*     1 - coupon for sending tell-a-friend (valid 3 days)
*     2 - coupon for survey (valid 3 days)
*     3 - coupon for receiving tell-a-friend mail (valid 10 days)
*     So far, validity is not checked.
*   For support contact support@qualityunit.com
*/


class QUnit_SplitRun_Web_Coupons {

    var $_dbConn = null;
    
    //------------------------------------------------------------------------
    
    function setDB($dbObj) {
        $this->_dbConn =& $dbObj;
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function createUniqueCoupon() {
        if($this->_dbConn == null || !$this->_dbConn) {
            return false;
        }
        
        $maxTries = 10;
        
        while(1) {
            if($maxTries <= 0) {
                return false;
            }
            
            $uniqueCoupon = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
            $uniqueCoupon = str_replace('0', 'X', $uniqueCoupon);
            $uniqueCoupon = str_replace('O', 'Q', $uniqueCoupon);
            
            // check if this token does not exist in the table already
            $sql = "select coupon from wd_web_coupons where coupon="._q($uniqueCoupon);
            $rs =& $this->_dbConn->query($sql);
            if(!$rs) {
                echo 'Error';
                return false;
            }
            
            if(!($row = $rs->FetchRow())) {
                return $uniqueCoupon;
            }
            
            $maxTries--;
        }
        
        return false;
    }
    
    //------------------------------------------------------------------------
    
    function insertCoupon($code, $type, $ip, $validity = 0) {
        if($this->_dbConn == null || !$this->_dbConn) {
            return false;
        }

        $sql = "insert into wd_web_coupons(coupon, dategenerated, ipgenerated, rtype, validity)".
                " values("._q($code).",NOW(),"._q($ip).","._q($type).","._q($validity).")";
        $ret =& $this->_dbConn->query($sql);
        if(!$ret) {
            return false;
        }
        
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function checkIPExistsInSurvey($ip) {
        $sql = "select user_id from phpQJr_ANSWERTEXT where ip_address="._q($ip);
        $rs =& $this->_dbConn->query($sql);
        if(!$rs) {
            echo 'Error';
            return false;
        }
        
        if(!($row = $rs->FetchRow())) {
            return $false;
        }
        
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function checkCoupon($coupon) {
        $sql = "select rtype, ipused from wd_web_coupons where coupon="._q($coupon);
        $rs =& $this->_dbConn->query($sql);
        if(!$rs) {
            echo 'Error';
            return 'notexist';
        }
        
        if(($row = $rs->FetchRow())) {
            if($row['ipused'] != '') {
                return 'used';
            }
            
            return $row['rtype'];
        }
        
        return 'notexist';
    }
    
    //------------------------------------------------------------------------
    
    function setCouponUsed($coupon, $ip) {
        $sql = "update wd_web_coupons set ipused="._q($ip).", dateused=NOW() where coupon="._q($coupon);
        $ret =& $this->_dbConn->query($sql);
        if(!$ret) {
            return false;
        }
        
        return true;
    }    
}

?>
