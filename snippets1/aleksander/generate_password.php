<?php

// Generate password
function generate_password() {
    $length = rand(10, 12);
    $salt = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789";
    $len = strlen($salt);
    $makepass = '';
    mt_srand(10000000 * (double)microtime());
    for ($i = 0; $i < $length; $i++)
    $makepass .= $salt[mt_rand(0, $len - 1)];
    return $makepass;
} 

?>