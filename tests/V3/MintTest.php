<?php

namespace JosephOpanel\RaydiumSDK\Tests\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use JosephOpanel\RaydiumSDK\V3\Mint;
use PHPUnit\Framework\TestCase;

class MintTest extends TestCase
{
    public function testGetList(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'mints' => [
                ['address' => 'mint1', 'name' => 'Token1', 'symbol' => 'TK1'],
                ['address' => 'mint2', 'name' => 'Token2', 'symbol' => 'TK2'],
            ]
        ];
        $mockClient->method('get')
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $mint = new Mint(httpClient: $mockClient);

        $mintList = $mint->getList();

        $this->assertCount(2, $mintList);
        $this->assertEquals('mint1', $mintList[0]['address']);
        $this->assertEquals('Token1', $mintList[0]['name']);
    }

    public function testGetMintInfo(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'mints' => [
                ['id' => 'mint1', 'name' => 'Token1', 'symbol' => 'TK1', 'decimals' => 6],
                ['id' => 'mint2', 'name' => 'Token2', 'symbol' => 'TK2', 'decimals' => 8],
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/mint/ids', ['query' => ['mints' => 'mint1,mint2']])
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $mint = new Mint(httpClient: $mockClient);

        $mintInfo = $mint->getMintInfo(['mint1', 'mint2']);

        $this->assertCount(2, $mintInfo);
        $this->assertEquals('Token1', $mintInfo[0]['name']);
        $this->assertEquals(6, $mintInfo[0]['decimals']);
    }

    public function testGetMintPrice(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'prices' => [
                'mint1' => 1.25,
                'mint2' => 0.85,
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/mint/price', ['query' => ['mints' => 'mint1,mint2']])
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $mint = new Mint(httpClient: $mockClient);

        $mintPrices = $mint->getMintPrice(['mint1', 'mint2']);

        $this->assertCount(2, $mintPrices);
        $this->assertEquals(1.25, $mintPrices['mint1']);
        $this->assertEquals(0.85, $mintPrices['mint2']);
    }


}
