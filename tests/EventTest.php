<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class EventTest extends ApiTestCase
{
    private const EVENT_UID = '0099740915';

    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        static::createClient()->request('GET', '/api/events');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    public function testPost(): void
    {
        static::createClient()->request('POST', 'api/events', [
            'json' => [
                'uid'  => self::EVENT_UID,
                'name' => 'TEsT event',
                'date' => '2023-07-11 01:19:36',
            ]
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

}
