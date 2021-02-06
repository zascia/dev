<?php
/**
*
*   @author Juraj Sujan
*   @copyright Copyright (c) Quality Unit s.r.o.
*   @package QUnit
*   @since Version 0.1
*   $Id: DbConnectionMysql.class.php,v 1.1 2005/05/14 11:46:22 jsujan Exp $
*/

class QUnit_Sql_DbConnectionMysql {
        
    var $_dbConn = null;
    var $_dbHost = '';
    var $_dbUser = '';
    var $_dbPassword = '';
    var $_dbDatabase = '';
    var $_dbDriver = '';
    var $_connected = false;
    

    function QUnit_Sql_DbConnectionMysql($dbHost, $dbUser, $dbPassword, $dbDatabase, $dbDriver = 'mysql') {        
        $this->_dbHost = $dbHost;
        $this->_dbUser = $dbUser;
        $this->_dbPassword = $dbPassword;
        $this->_dbDatabase = $dbDatabase;
        $this->recordSet =& QUnit_Global::newObj('QUnit_Sql_RecordSetMysql');
    }
    
    function isConnected() {
        return $this->_connected;
    }
        
    function connect() {
        if(!$this->isConnected()) {
            $conn = mysql_connect($this->_dbHost, $this->_dbUser, $this->_dbPassword);
            if(!$conn) {
                return false;
            }
            if(!mysql_select_db($this->_dbDatabase, $conn)) {
                return false;
            }
            $this->_dbConn = $conn;
            $this->_connected = true;
        }
    }
    
    function &getConnection() {
        if(!$this->isConnected()) {
            $this->connect();        
        }
        return $this->_dbConn;
    }
    
    function &query($sql) {
        $result = mysql_query($sql, $this->getConnection());
        if(!$result) {
            echo mysql_error() . "\nsql was: $sql";
            return false;
        } else {
            $this->recordSet->setDataset($result);
            return $this->recordSet;
        }        
    }
    
    function &unbuffered_query($sql) {
        $result = mysql_unbuffered_query($sql, $this->getConnection());
        if(!$result) {
            echo mysql_error() . "\nsql was: $sql";
            return false;
        } else {
            return $result;
        }        
    }
    
    function disconnect() {
        if($this->isConnected()) {
            $this->_dbConn->Close();
        }
    } 
    
    function createUniqueId() {
        $uniqueId = substr(md5(uniqid(rand(), true)), 0, 8);  
        return $uniqueId;
    }
    
    function getDateString($time = '') {
        if($time === '') $time = time();
        return strftime("%Y-%m-%d %H:%M:%S", $time);
    }
    
    function getInsertID() {
        return mysql_insert_id();
    }
}

?>