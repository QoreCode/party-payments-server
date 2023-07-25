<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class UsersTest extends ApiTestCase
{
    use RefreshDatabaseTrait;
    public function testGetCollection(): void
    {
        static::createClient()->request('GET', '/api/users');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    public function testPost(): void
    {
        static::createClient()->request('POST', 'api/users', [
            'json' => [
                'uid'                => '0099740915',
                'name'               => 'Disabled User',
                'credit_card_number' => '6011167831909966',
                'is_active'          => false,
            ]
        ]);
        $this->assertResponseIsSuccessful();
        static::createClient()->request('POST', 'api/users', [
            'json' => [
                'uid'                => '65498798798',
                'name'               => 'Enabled User',
                'credit_card_number' => '6011167831909966',
                'is_active'          => true,
            ]
        ]);

        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

}
