<?php

// Check if sting contain unicode characters
function is_unicode($data) {
    if (strlen($data) !== strlen(utf8_decode($data))) {
        return true;
    } else {
        return false;
    }
}

?>