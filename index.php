<?php

namespace formstack;
/**
 * Main file
 * Get the url params
 * Do actions depending of each parameter
 * Response something
 */
require 'views/ApiJson.php';
require 'controllers/UsersController.php';

use users\controller\UsersController;
use view\json\ApiJson;

//Get the url info
$url = preg_split('@/@', $_SERVER['REQUEST_URI'], NULL, PREG_SPLIT_NO_EMPTY);



//Get the first element of the URL, should be the model
$model = array_shift($url);
$valid_models = array('users');
$res = null;

//If the model is in the valid models, continue, in other case send 405
if (!in_array($model, $valid_models)) {
    $res = [
        "status" => 405,
        "body" => "Ops.."];
}

//Get the method from the header
$method = strtolower($_SERVER['REQUEST_METHOD']);

//If the model is valid and the other parameter is a number or does not exists
if($res == null &&
    (
        count($url) == 0 ||
        (
            is_array($url) && count($url) >0 &&  is_numeric($url[0])
        )
    )
){
    switch ($method) {
        case 'get':
            //Get user from specific ID
            $res = UsersController::get($url);
            break;

        case 'post':
            //Create a new user
            $res = UsersController::post();

            break;
        case 'put':
            //Update user from specific ID
            $res = UsersController::put($url);
            break;

        case 'delete':
            //Delete user from specific ID
            $res = UsersController::delete($url);
            break;
        default:
            //Another method... are not allowed
            $res = [
                "status" => 405,
                "body" => "Ops.."];

    }
}
else{
    $res = [
        "status" => 405,
        "body" => "Ops.."];
}


//Response
ApiJson::response($res["status"],$res["body"]);