<?php

namespace JosephOpanel\RaydiumSDK\Tests\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use JosephOpanel\RaydiumSDK\V3\Mint;
use PHPUnit\Framework\TestCase;

class MintTest extends TestCase
{
    public function testGetList(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'mints' => [
                ['address' => 'mint1', 'name' => 'Token1', 'symbol' => 'TK1'],
                ['address' => 'mint2', 'name' => 'Token2', 'symbol' => 'TK2'],
            ]
        ];
        $mockClient->method('get')
            ->with(
                'https://api-v3.raydium.io/mint/list',
                [
                    'query' => [], // Include the empty 'query' key
                    'headers' => ['accept' => 'application/json']
                ]
            )
            ->willReturn(new Response(200, ['Content-Type' => 'application/json'], json_encode($mockResponse)));

        $mint = new Mint(httpClient: $mockClient);

        $mintList = $mint->getList();

        $this->assertCount(2, $mintList);
        $this->assertEquals('mint1', $mintList[0]['address']);
        $this->assertEquals('Token1', $mintList[0]['name']);
    }

    public function testGetListHandlesErrorsGracefully(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('get')
            ->willThrowException(new RequestException('Error connecting to API', new Request('GET', 'test')));

        $mint = new Mint(httpClient: $mockClient);

        $mintList = $mint->getList();

        $this->assertEmpty($mintList, 'Mint list should be empty on error');
    }

    public function testGetMintInfo(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'mints' => [
                ['id' => 'mint1', 'name' => 'Token1', 'symbol' => 'TK1', 'decimals' => 6],
                ['id' => 'mint2', 'name' => 'Token2', 'symbol' => 'TK2', 'decimals' => 8],
            ]
        ];
        $mockClient->method('get')
            ->with(
                'https://api-v3.raydium.io/mint/ids',
                ['query' => ['mints' => 'mint1,mint2'], 'headers' => ['accept' => 'application/json']]
            )
            ->willReturn(new Response(200, ['Content-Type' => 'application/json'], json_encode($mockResponse)));

        $mint = new Mint(httpClient: $mockClient);

        $mintInfo = $mint->getMintInfo(['mint1', 'mint2']);

        $this->assertCount(2, $mintInfo);
        $this->assertEquals('Token1', $mintInfo[0]['name']);
        $this->assertEquals(6, $mintInfo[0]['decimals']);
    }

    public function testGetMintInfoHandlesErrorsGracefully(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('get')
            ->willThrowException(new RequestException('Error connecting to API', new Request('GET', 'test')));

        $mint = new Mint(httpClient: $mockClient);

        $mintInfo = $mint->getMintInfo(['mint1', 'mint2']);

        $this->assertEmpty($mintInfo, 'Mint info should be empty on error');
    }

    public function testGetMintPrice(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'data' => [
                'mint1' => 1.25,
                'mint2' => 0.85,
            ]
        ];
        $mockClient->method('get')
            ->with(
                'https://api-v3.raydium.io/mint/price',
                ['query' => ['mints' => 'mint1,mint2'], 'headers' => ['accept' => 'application/json']]
            )
            ->willReturn(new Response(200, ['Content-Type' => 'application/json'], json_encode($mockResponse)));

        $mint = new Mint(httpClient: $mockClient);

        $mintPrices = $mint->getMintPrice(['mint1', 'mint2']);

        $this->assertCount(2, $mintPrices);
        $this->assertEquals(1.25, $mintPrices['mint1']);
        $this->assertEquals(0.85, $mintPrices['mint2']);
    }

    public function testGetMintPriceHandlesErrorsGracefully(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('get')
            ->willThrowException(new RequestException('Error connecting to API', new Request('GET', 'test')));

        $mint = new Mint(httpClient: $mockClient);

        $mintPrices = $mint->getMintPrice(['mint1', 'mint2']);

        $this->assertEmpty($mintPrices, 'Mint prices should be empty on error');
    }
}
