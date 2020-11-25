<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookTest extends WebTestCase
{
    public function testGetBook()
    {
        $client = static::createClient();
        $client->request('GET', '/book?limit-1');
        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $this->assertResponseIsSuccessful();
    }

    public function testGetAuthor()
    {
        $client = static::createClient();
        $client->request('GET', '/author?limit=1');
        $this->assertResponseIsSuccessful();
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
    }
}
