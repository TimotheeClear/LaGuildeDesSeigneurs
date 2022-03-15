<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    private $client;
    private $content;
    private static $identifier;
    private $intelligence;

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
            '/character/create',
            array(), //parameters
            array(), //files
            array('CONTENT_TYPE' => 'application/json'), //server
            '{"kind":"Dame", "name":"Eldalótë", "surname":"Fleur elfique", "caste":"Elfe", "knowledge":"Arts", "intelligence":120, "life":12, "image":"/images/eldalote.jpg"}');

        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
    }

    /**
     * Tests index
     */
    public function testIndex()
    {
        $this->client->request('GET', '/character/index');

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    /**
    * Tests showMinIntelligence
    */
    public function testShowMinIntelligence()
    {
        $this->client->request('GET', '/character/show_min_intelligence/110');
        $this->assertJsonResponse($this->client->getResponse(), 200);

        $this->client->request('GET', '/character/html/show_min_intelligence/110');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/character/api-html/show_min_intelligence/110');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests display
     */
    public function testDisplay()
    {
        $client = $this->client;
        $client->request('GET', '/character/display/'. self::$identifier);

        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    /**
     * Tests redirect
     */
    public function testRedirectIndex()
    {
        $this->client->request('GET', '/character');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests bad identifier
     */
    public function testBadIdentifier(){
        $this->client->request('GET', '/character/display/badIdentifier');
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
            '/character/modify/' . self::$identifier,array(), //parameters
            array(), //files
            array('CONTENT_TYPE' => 'application/json'),//server
            '{"kind":"Seigneur", "name":"Gorthol"}');
            $this->assertJsonResponse();
            $this->assertIdentifier();
            
        //Tests with whole content
        $this->client->request(
            'PUT',
            '/character/modify/' . self::$identifier,array(), //parameters
            array(), //files
            array('CONTENT_TYPE' => 'application/json'),//server
            '{"kind":"Seigneur", "name":"Gorthol", "surname":"Heaume de terreur", "caste":"Chevalier", "knowledge":"Diplomatie", "intelligence":110, "life":13, "image":"/images/gorthol.jpg"}');
            $this->assertJsonResponse();
            $this->assertIdentifier();
        }

    /**
     * Tests delete
     */
    public function testDelete(){
        $this->client->request('DELETE', '/character/delete/'. self::$identifier);
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
     * Tests images
     */
    public function testImages()
    {
        //Tests without kind
        $this->client->request('GET', '/character/images/3');
        $this->assertJsonResponse();

        //Tests with kind
        $this->client->request('GET', '/character/images/dames/3');
        $this->assertJsonResponse();
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
