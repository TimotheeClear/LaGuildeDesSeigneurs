<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    // /**
    //  * Tests index
    //  */
    // public function testIndex()
    // {
    //     $client = static::createClient();
    //     $client->request('GET', '/character');

    //     $response = $client->getResponse();
    //     $this->assertEquals(200, $response->getStatusCode());
    //     $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    // }

    /**
     * Tests display
     */
    public function testDisplay()
    {
        $client = static::createClient();
        $client->request('GET', '/character/display');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Asserts that a Response is in json
     */
    public function assertJsonResponse($response)
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->headers->contains('Content-Type', 'application/json'), $response->headers);
    }
}
