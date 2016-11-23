<?php

namespace users\controller;

require 'models/UsersModel.php';


use users\model\UsersModel;

/**
 * Class UsersController
 * Methods to update, create, delete and show a user
 * @package users\controller
 * @version 1.0
 */

class UsersController
{

    /**
     * Insert in the DB the new user using post method
     * Get the body of post
     * The body should have email, first_name, last_name, password
     * @api
     * @return array Status of the call, new user created, the user exists, an internal error
     */
    public static function post()
    {
        //Get body content and convert into json
        $body = file_get_contents('php://input');
        $body = json_decode($body);

        //Verify that all the required variable exists
        if($body->email && $body->first_name && $body->last_name && $body->password){
            //Verify that the email doesn't exist
            $response = UsersModel::getByEmail($body->email);
            if($response["rows"]==0){
                //New user
                $response = UsersModel::insert($body->email, $body->first_name, $body->last_name, $body->password);
                if($response){

                    $res = array(
                        "message" => "OK"
                    );
                    return[
                        "status" => 200,
                        "body" => $res
                    ];
                }
                else{
                    $res = array(
                        "error"=>true,
                        "message" => "Internal Error"
                    );
                    return[
                        "status" => 500,
                        "body" => $res
                    ];
                }
            }
            else{
                //User exist
                $res = array(
                    "error"=>false,
                    "message" => "User Already Exist"
                );
                return[
                    "status" => 400,
                    "body" => $res
                ];
            }

        }
        else{
            //Not all the parameters
            $res = array(
                "error"=>false,
                "message" => "No complete params"
            );
            return[
                "status" => 400,
                "body" => $res
            ];
        }


    }

    /**
     * Get the user from the id
     * @api
     * @param $url The url from the call, to get the user id
     * @return array Status of the call, if the user exists and the data, if the user does not exist,
     * if there is an error
     */
    public static function get($url)
    {
        //Get id from URL
        $id = $url[0];
        $response = UsersModel::getById($id);
        if($response["rows"]>0){
            $res = array(
                "data" => $response["data"]
            );
            return[
                "status" => 200,
                "body" => $res
            ];
        }

        else if($response["rows"]==0){
            $res = array(
                "data" => false,
                "message" => "No user"
            );
            return[
                "status" => 400,
                "body" => $res
            ];
        }
        else{
            $res = array(
                "error"=>true,
                "message" => "Internal Error"
            );
            return[
                "status" => 500,
                "body" => $res
            ];
        }
    }

    /**
     * Update the user from the id
     * Only updates: first_name, last_name, email, password
     * @api
     * @param $url The url from the call, to get the user id
     * @return array Status of the call, if the user exists, if the user does not exist,
     * if there is an error
     */
    public static function put($url)
    {
        $id = $url[0];
        $body = file_get_contents('php://input');
        $body = json_decode($body);

        //Verify that all the required variable exists
        if($body->email && $body->first_name && $body->last_name && $body->password) {
            $response = UsersModel::updateById(
                $id,
                $body->email,
                $body->first_name,
                $body->last_name,
                $body->password
            );

            if ($response["rows"] > 0) {
                $res = array(
                    "message" => "Updated"
                );
                return [
                    "status" => 200,
                    "body" => $res
                ];
            } else if ($response["rows"] == 0) {
                $res = array(
                    "message" => "No user"
                );
                return [
                    "status" => 400,
                    "body" => $res
                ];
            } else {
                $res = array(
                    "error" => true,
                    "message" => "Internal Error"
                );
                return [
                    "status" => 500,
                    "body" => $res
                ];
            }
        }
        else{
            //Not all the parameters
            $res = array(
                "error"=>false,
                "message" => "No complete params"
            );
            return[
                "status" => 400,
                "body" => $res
            ];
        }

    }

    /**
     * Delete the user from the id
     * Softdelete
     * @api
     * @param $url The url from the call, to get the user id
     * @return array Status of the call, if the user exists and is deleted, if the user does not exist,
     * if there is an error
     */
    public static function delete($url)
    {
        $id = $url[0];

        $response = UsersModel::deleteById($id);

        if($response["rows"]>0){
            $res = array(
                "message" => "deleted"
            );
            return[
                "status" => 200,
                "body" => $res
            ];
        }

        else if($response["rows"]==0){
            $res = array(
                "message" => "No user"
            );
            return[
                "status" => 400,
                "body" => $res
            ];
        }
        else{
            $res = array(
                "error"=>true,
                "message" => "Internal Error"
            );
            return[
                "status" => 500,
                "body" => $res
            ];
        }
    }



}