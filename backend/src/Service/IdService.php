<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 15.04.2018
 * Time: 15:33
 */

namespace App\Service;

class IdService
{

    public function generateUserId() {
        return rand(1, 1000);
    }

    public function generateGlobalId() {
        $token = $_SERVER['HTTP_HOST'];
        $token .= $_SERVER['REQUEST_URI'];
        $token .= uniqid(rand(), true);

        // GUID is 128-bit hex
        $hash  = strtoupper(md5($token));

        // Create formatted GUID
        $guid  = '';

        // GUID format is XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX for readability
        $guid .= substr($hash,  0,  4) .
            '-' .
            substr($hash,  8,  4) .
            '-' .
            substr($hash, 12,  4) .
            '-' .
            substr($hash, 16,  4) .
            '-' .
            substr($hash, 20, 4) .
            '-' .
            substr($hash, 24, 5);

        return $guid;
    }
}