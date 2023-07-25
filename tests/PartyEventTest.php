<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class PartyEventTest extends ApiTestCase
{
    private const EVENT_UID = 'test_party_event_uid';

    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        static::createClient()->request('GET', '/api/party_events');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    public function testPost(): void
    {
        $eventData = [
            'uid'  => self::EVENT_UID,
            'name' => 'TEST event',
            'date' => '2023-07-11T01:19:36+00:00',
        ];
        static::createClient()->request('POST', 'api/party_events', [
            'json' => $eventData
        ]);
        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains(
            array_merge([
                "@context" => "/api/contexts/PartyEvent",
                "@id"      => "/api/party_events/" . self::EVENT_UID,
                "@type"    => "PartyEvent"
            ], $eventData)
        );
    }

}
