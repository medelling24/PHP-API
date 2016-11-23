<?php
namespace view\json;

/**
 * Class with the response and the status
 *
 * Class ApiJson
 * @package view\json
 */
class ApiJson
{
    /**
     * Get an array, convert into json and response it, with the http response code header
     *
     * @param $status number response code
     * @param $body array response body, will be converted into json
     */
    public static function response($status, $body)
    {

        http_response_code($status);
        header('Content-Type: application/json; charset=utf8');
        echo json_encode($body, JSON_PRETTY_PRINT);
        exit;
    }
}