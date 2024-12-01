<?php

namespace JosephOpanel\RaydiumSDK\Tests\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use JosephOpanel\RaydiumSDK\V3\IDO;
use PHPUnit\Framework\TestCase;

class IDOTest extends TestCase
{
    public function testGetIDOPoolKeys(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'keys' => [
                ['id' => 'ido1', 'key' => 'key1'],
                ['id' => 'ido2', 'key' => 'key2'],
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/ido/key/ids', ['query' => ['ids' => 'ido1,ido2']])
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $ido = new IDO(httpClient: $mockClient);

        $idoKeys = $ido->getIDOPoolKeys(['ido1', 'ido2']);

        $this->assertCount(2, $idoKeys);
        $this->assertEquals('ido1', $idoKeys[0]['id']);
        $this->assertEquals('key1', $idoKeys[0]['key']);
    }
}
