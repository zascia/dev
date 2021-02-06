<?php
/**
*
*   @author Juraj Sujan
*   @copyright Copyright (c) Quality Unit s.r.o.
*   @package QUnit
*   @since Version 0.1
*   $Id: DbConnection.class.php,v 1.1.1.1 2005/04/22 10:13:37 jsujan Exp $
*/

//require_once(BASEDIR . '/adodb/adodb.inc.php');
QUnit_Global::includeFile("Adodb/adodb.inc.php");
//QUnit_Global::includeFile("adodb_lite/adodb.inc.php");

class QUnit_Sql_DbConnection {

    var $_dbConn = null;
    var $_dbHost = '';
    var $_dbUser = '';
    var $_dbPassword = '';
    var $_dbDatabase = '';
    var $_dbDriver = '';


    function QUnit_Sql_DbConnection($dbHost, $dbUser, $dbPassword, $dbDatabase, $dbDriver = 'mysql') {
        $this->_dbHost = $dbHost;
        $this->_dbUser = $dbUser;
        $this->_dbPassword = $dbPassword;
        $this->_dbDatabase = $dbDatabase;
        $this->_dbConn =& NewADOConnection($dbDriver);
    }

    function isConnected() {
        return $this->_dbConn->isConnected();
    }

    function connect() {
        if(!$this->isConnected()) {
            if(!$this->_dbConn->Connect($this->_dbHost, $this->_dbUser,
                $this->_dbPassword, $this->_dbDatabase)) {
                echo $this->_dbConn->ErrorMsg();
                return false;
            }
        }
        return true;
    }

    function &getConnection() {
        if(!$this->isConnected()) {
            $this->connect();
        }
        return $this->_dbConn;
    }

    function &query($sql, $asArray = false) {
        //echo "SQL: ".$sql."<br>\n<br>\n";
        $db =& $this->getConnection();
        $rs =& $db->Execute($sql);
        if(!$rs) {
            echo $this->getErrorMsg() . "\nsql was: $sql";
            die;
        } else {
            if($asArray) {
                return $rs->getArray();
            }
            return $rs;
        }
    }

    function getErrorMsg() {
        return $this->_dbConn->ErrorMsg();
    }

    function getCurrentDbDate($time = '') {
        if(empty($time)) {
            $time = time();
        }
        $db =& $this->getConnection();
        return $db->DBTimeStamp($time);
    }

    function strToTimeStamp($str) {
        $db =& $this->getConnection();
        return $db->UnixTimeStamp($str);
    }

    function genId($seqName) {
        $db =& $this->getConnection();
        return $db->GenID($seqName);
    }

    function disconnect() {
        if($this->isConnected()) {
            $this->_dbConn->Close();
        }
    }
}

?>