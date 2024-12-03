<?php

namespace JosephOpanel\RaydiumSDK\Tests\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use JosephOpanel\RaydiumSDK\V3\Farms;
use PHPUnit\Framework\TestCase;

class FarmsTest extends TestCase
{
    public function testGetFarmInfoByIds(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'farms' => [
                ['id' => 'farm1', 'tvl' => 500000, 'apy' => 15.0],
                ['id' => 'farm2', 'tvl' => 750000, 'apy' => 18.5],
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/farms/info/ids', ['query' => ['ids' => 'farm1,farm2']])
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $farms = new Farms(httpClient: $mockClient);

        $farmInfo = $farms->getFarmInfoByIds(['farm1', 'farm2']);

        $this->assertCount(2, $farmInfo);
        $this->assertEquals('farm1', $farmInfo[0]['id']);
        $this->assertEquals(500000, $farmInfo[0]['tvl']);
        $this->assertEquals(15.0, $farmInfo[0]['apy']);
    }

    public function testGetFarmInfoByLP(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'farms' => [
                ['lpMint' => 'lp1', 'tvl' => 300000, 'apy' => 10.5],
                ['lpMint' => 'lp2', 'tvl' => 400000, 'apy' => 11.0],
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/farms/info/lp', ['query' => ['lp' => 'lp1,lp2']])
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $farms = new Farms(httpClient: $mockClient);

        $farmInfo = $farms->getFarmInfoByLP(['lp1', 'lp2']);

        $this->assertCount(2, $farmInfo);
        $this->assertEquals('lp1', $farmInfo[0]['lpMint']);
        $this->assertEquals(300000, $farmInfo[0]['tvl']);
        $this->assertEquals(10.5, $farmInfo[0]['apy']);
    }

    public function testGetFarmKeysByIds(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'keys' => [
                ['id' => 'farm1', 'key' => 'key1'],
                ['id' => 'farm2', 'key' => 'key2'],
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/farms/key/ids', ['query' => ['ids' => 'farm1,farm2']])
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $farms = new Farms(httpClient: $mockClient);

        $farmKeys = $farms->getFarmKeysByIds(['farm1', 'farm2']);

        $this->assertCount(2, $farmKeys);
        $this->assertEquals('farm1', $farmKeys[0]['id']);
        $this->assertEquals('key1', $farmKeys[0]['key']);
    }


}
