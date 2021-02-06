<?php
/**
*
*   @author Juraj Sujan
*   @copyright Copyright (c) Quality Unit s.r.o.
*   @package QUnit
*   @since Version 0.1
*   $Id: RecordSetMysql.class.php,v 1.1 2005/05/14 11:46:22 jsujan Exp $
*/

class QUnit_Sql_RecordSetMysql {

   var $dataset;

   function QUnit_Sql_RecordSetMysql() {
   }

// public
   function &getDataset() {
      return $this->dataset;
   }

   function setDataset(&$dataset) {
      $this->dataset =& $dataset;
   }
         
   function FetchRow() {
      return mysql_fetch_assoc($this->getDataset());
   }
   
   function RecordCount() {
      return mysql_num_rows($this->getDataset());
   }
      
}
?>