<?php

require('vendor/autoload.php');
/**
 * Test File to verify all the User REST API
 *
 */
class UsersTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://www.formstack.com.mx/'
        ]);
    }

    public function testInvalid_Model()
    {
        $response = $this->client->get('v1/test',[
            'http_errors' => false
        ]);

        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testInvalid_Method()
    {
        $response = $this->client->copy('v1/users',[
            'http_errors' => false
        ]);

        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testGet_User_ErrorString()
    {
        $response = $this->client->get('v1/users/X',[
            'http_errors' => false
        ]);

        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testGet_User_Error()
    {
        $response = $this->client->get('v1/users/0',[
            'http_errors' => false
        ]);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testPost_New_User()
    {
        $response = $this->client->post('v1/users',[
            'json' => [
                "first_name"=>"Test",
                "last_name"=>"User",
                "password"=>"12345",
                "email"=>"test".rand(0, 999)."@gmail.com".rand(0, 999)
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('data', $data);
    }

    public function testPost_New_User_Error_Params()
    {
        $response = $this->client->post('v1/users',[
            'json' => [
                "first_name"=>"Test",
                "email"=>"test".rand(0, 999)."@gmail.com".rand(0, 999)
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testGet_User()
    {
        $response = $this->client->post('v1/users',[
            'json' => [
                "first_name"=>"Test",
                "last_name"=>"User",
                "password"=>"12345",
                "email"=>"test".rand(0, 999)."@gmail.com".rand(0, 999)
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $data);

        $response = $this->client->get('v1/users/'.$data["data"]);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('first_name', $data["data"]);
        $this->assertArrayHasKey('last_name', $data["data"]);
        $this->assertArrayHasKey('email', $data["data"]);

    }

    public function testPost_Created_User_Error()
    {
        $email = "test".rand(0, 999)."@gmail.com".rand(0, 999);

        $response = $this->client->post('v1/users',[
            'json' => [
                "first_name"=>"Test",
                "last_name"=>"User",
                "password"=>"12345",
                "email"=> $email
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('data', $data);

        $response = $this->client->post('v1/users',[
            'json' => [
                "first_name"=>"Test",
                "last_name"=>"User",
                "password"=>"12345",
                "email"=> $email
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testPut_New_User()
    {
        $response = $this->client->post('v1/users',[
            'json' => [
                "first_name"=>"Test",
                "last_name"=>"User",
                "password"=>"12345",
                "email"=>"test".rand(0, 999)."@gmail.com".rand(0, 999)
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $response = $this->client->put('v1/users/'.$data["data"],[
            'json' => [
                "first_name"=>"TestPut",
                "last_name"=>"User",
                "password"=>"12345",
                "email"=>"test".rand(0, 999)."@gmail.com".rand(0, 999)
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);

    }

    public function testPut_User_Error()
    {

        $response = $this->client->put('v1/users/0',[
            'json' => [
                "first_name"=>"Test",
                "last_name"=>"User",
                "password"=>"12345",
                "email"=>"test".rand(0, 999)."@gmail.com".rand(0, 999)
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(400, $response->getStatusCode());

    }

    public function testDelete_User_Error()
    {

        $response = $this->client->delete('v1/users/0',[
            'http_errors' => false
        ]);

        $this->assertEquals(400, $response->getStatusCode());

    }

    public function testDelete_User()
    {
        $response = $this->client->post('v1/users',[
            'json' => [
                "first_name"=>"Test",
                "last_name"=>"User",
                "password"=>"12345",
                "email"=>"test".rand(0, 999)."@gmail.com".rand(0, 999)
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $data);

        $response = $this->client->delete('v1/users/'.$data['data'],[
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());

    }

}
