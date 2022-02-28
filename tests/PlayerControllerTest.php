<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    private $client;
    private $content;
    private static $identifier;

    public function setup() : void
    {
        $this->client = static::createClient();
    }

    /**
     * Tests create
     */
    public function testCreate(){
        $this->client->request(
            'POST',
            '/player/create',
            array(), //parameters
            array(), //files
            array('CONTENT_TYPE' => 'application/json'), //server
            '{"firstname":"Tim","lastname":"Cléar","email":"truc@machin.fr","mirian":14}');
        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
    }

    /**
     * Tests index
     */
    public function testIndex()
    {
        $this->client->request('GET', '/player/index');

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    /**
     * Tests display
     */
    public function testDisplay()
    {
        $client = $this->client;
        $client->request('GET', '/player/display/'. self::$identifier);

        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    /**
     * Tests redirect
     */
    public function testRedirectIndex()
    {
        $this->client->request('GET', '/player');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests bad identifier
     */
    public function testBadIdentifier(){
        $this->client->request('GET', '/player/display/badIdentifier');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /**
     * Assert that Response returns 404
     */
    public function assertError404($statusCode){
        $this->assertEquals(404, $statusCode);
    }

    /**
     * Tests modify
     */
    public function testModify(){
                //Tests with partial data array
                $this->client->request(
                    'PUT',
                    '/player/modify/' . self::$identifier,array(), //parameters
                    array(), //files
                    array('CONTENT_TYPE' => 'application/json'),//server
                    '{"firstname":"Truc", "lastname":"Muche"}');
                    $this->assertJsonResponse();
                    $this->assertIdentifier();
                    
                //Tests with whole content
                $this->client->request(
                    'PUT',
                    '/player/modify/' . self::$identifier,array(), //parameters
                    array(), //files
                    array('CONTENT_TYPE' => 'application/json'),//server
                    '{"firstname":"Truc", "lastname":"Muche", "email":"truc@muche.com", "mirian":28}');
                    $this->assertJsonResponse();
                    $this->assertIdentifier();
    }

    /**
     * Tests delete
     */
    public function testDelete(){
        $this->client->request('DELETE', '/player/delete/'. self::$identifier);
        $this->assertJsonResponse();
    }

    /**
     * Asserts that 'identifier' is present in the Response 
     */
    public function assertIdentifier()
    {
        $this->assertArrayHasKey('identifier', $this->content);
    }

    /**
     * Defines identifier
    */
    public function defineIdentifier()
    {
        self::$identifier = $this->content['identifier'];
    }



    
    /**
     * Asserts that a Response is in json
     */
    public function assertJsonResponse()
    {
        $response = $this->client->getResponse();
        $this->content = json_decode($response->getContent(), true, 50);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }
}
