<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 15.04.2018
 * Time: 18:06
 */

namespace App\Service;


class RequestService
{
    public function corsHeaders() {
        $headers = [
            "Access-Control-Allow-Origin" => "*",
            "Access-Control-Allow-Headers" => "X-PINGOTHER, Content-Type, Authorization, Content-Length, X-Requested-With",
            "Access-Control-Allow-Methods" => "GET, POST, PUT, PATCH, DELETE, OPTIONS"
        ];

        return $headers;
    }
}