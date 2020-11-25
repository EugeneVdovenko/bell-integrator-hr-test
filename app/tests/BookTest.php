<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookTest extends WebTestCase
{
    public function testGetBook()
    {
        $client = static::createClient();
        $client->request('GET', 'http://localhost:8000/book?limit-1');
        $this->assertResponseIsSuccessful();
        self::assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
    }

    public function testGetAuthor()
    {
        $client = static::createClient();
        $client->request('GET', '/author?limit=1');
        $this->assertResponseIsSuccessful();
        self::assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
    }
}
