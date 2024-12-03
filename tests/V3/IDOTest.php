<?php

namespace JosephOpanel\RaydiumSDK\Tests\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
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
            ->with(
                'https://api-v3.raydium.io/ido/key/ids',
                [
                    'query' => ['ids' => 'ido1,ido2'],
                    'headers' => ['accept' => 'application/json']
                ]
            )
            ->willReturn(new Response(200, ['Content-Type' => 'application/json'], json_encode($mockResponse)));

        $ido = new IDO(httpClient: $mockClient);

        $idoKeys = $ido->getIDOPoolKeys(['ido1', 'ido2']);

        $this->assertCount(2, $idoKeys);
        $this->assertEquals('ido1', $idoKeys[0]['id']);
        $this->assertEquals('key1', $idoKeys[0]['key']);
    }

    public function testGetIDOPoolKeysHandlesErrorsGracefully(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('get')
            ->willThrowException(new RequestException('Error fetching data', new Request('GET', 'test')));

        $ido = new IDO(httpClient: $mockClient);

        $idoKeys = $ido->getIDOPoolKeys(['ido1', 'ido2']);

        $this->assertEmpty($idoKeys, 'IDO pool keys should be empty on error');
    }
}
