<?php
/**
*
*   @author Juraj Sujan
*   @copyright Copyright (c) Quality Unit s.r.o.
*   @package QUnit
*   @since Version 0.1
*   $Id: Object.class.php,v 1.9 2005/03/21 18:25:58 jsujan Exp $
*/

QUnit_Global::includeClass('QUnit_Object2');

class QUnit_Net_Mail_Smtp extends QUnit_Object2 {

    var $mail;

    function _init($params) {
        parent::_init();
        $this->mail =& Mail::factory('smtp', $params);
    }

    function send($recipients, $headers, $body) {
        return $this->mail->send($recipients, $headers, $body);
    }
}

?>