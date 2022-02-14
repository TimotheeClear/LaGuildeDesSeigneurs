<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    private $client;

    public function setup() : void
    {
        $this->client = static::createClient();
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
     * Tests display
     */
    public function testDisplay()
    {
        $client = $this->client;
        $client->request('GET', '/character/display/a9399b0bd1b3cfa35cd4d2b888070cb07096aab2');

        $this->assertJsonResponse($client->getResponse());
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
        $this->client->request('PUT', '/character/modify/3');
        $this->assertJsonResponse();
    }

    /**
     * Tests delete
     */
    public function testDelete(){
        $this->client->request('DELETE', '/character/delete/3');
        $this->assertJsonResponse();
    }


    
    /**
     * Asserts that a Response is in json
     */
    public function assertJsonResponse()
    {
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }
}
