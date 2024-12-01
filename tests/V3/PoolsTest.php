<?php

namespace JosephOpanel\RaydiumSDK\Tests\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use JosephOpanel\RaydiumSDK\V3\Pools;
use PHPUnit\Framework\TestCase;

class PoolsTest extends TestCase
{
    public function testGetPoolInfoByIds(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'pools' => [
                ['id' => 'pool1', 'tvl' => 1000000, 'apy' => 12.5],
                ['id' => 'pool2', 'tvl' => 2000000, 'apy' => 10.0],
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/pools/info/ids', ['query' => ['ids' => 'pool1,pool2']])
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $pools = new Pools(httpClient: $mockClient);

        $poolInfo = $pools->getPoolInfoByIds(['pool1', 'pool2']);

        $this->assertCount(2, $poolInfo);
        $this->assertEquals(1000000, $poolInfo[0]['tvl']);
        $this->assertEquals(12.5, $poolInfo[0]['apy']);
    }

    public function testGetPoolInfoByLPs(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'pools' => [
                ['lpMint' => 'lp1', 'tvl' => 500000, 'apy' => 8.0],
                ['lpMint' => 'lp2', 'tvl' => 750000, 'apy' => 9.5],
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/pools/info/lps', ['query' => ['lpMints' => 'lp1,lp2']])
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $pools = new Pools(httpClient: $mockClient);

        $poolInfo = $pools->getPoolInfoByLPs(['lp1', 'lp2']);

        $this->assertCount(2, $poolInfo);
        $this->assertEquals('lp1', $poolInfo[0]['lpMint']);
        $this->assertEquals(500000, $poolInfo[0]['tvl']);
        $this->assertEquals(8.0, $poolInfo[0]['apy']);
    }

    public function testGetAllPoolsInfo(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'pools' => [
                ['id' => 'pool1', 'tvl' => 100000, 'apy' => 12.5],
                ['id' => 'pool2', 'tvl' => 200000, 'apy' => 10.0],
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/pools/info/list')
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $pools = new Pools(httpClient: $mockClient);

        $allPools = $pools->getAllPoolsInfo();

        $this->assertCount(2, $allPools);
        $this->assertEquals('pool1', $allPools[0]['id']);
        $this->assertEquals(100000, $allPools[0]['tvl']);
    }

    public function testGetPoolInfoByTokenMint(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'pools' => [
                ['tokenMint' => 'mint1', 'tvl' => 300000, 'apy' => 7.0],
                ['tokenMint' => 'mint2', 'tvl' => 400000, 'apy' => 6.5],
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/pools/info/mint', ['query' => ['tokenMints' => 'mint1,mint2']])
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $pools = new Pools(httpClient: $mockClient);

        $poolInfo = $pools->getPoolInfoByTokenMint(['mint1', 'mint2']);

        $this->assertCount(2, $poolInfo);
        $this->assertEquals('mint1', $poolInfo[0]['tokenMint']);
        $this->assertEquals(300000, $poolInfo[0]['tvl']);
        $this->assertEquals(7.0, $poolInfo[0]['apy']);
    }

    public function testGetPoolKeysByIds(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'keys' => [
                ['id' => 'pool1', 'key' => 'key1'],
                ['id' => 'pool2', 'key' => 'key2'],
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/pools/key/ids', ['query' => ['ids' => 'pool1,pool2']])
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $pools = new Pools(httpClient: $mockClient);

        $poolKeys = $pools->getPoolKeysByIds(['pool1', 'pool2']);

        $this->assertCount(2, $poolKeys);
        $this->assertEquals('pool1', $poolKeys[0]['id']);
        $this->assertEquals('key1', $poolKeys[0]['key']);
    }

    public function testGetPoolLiquidityHistory(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'liquidityHistory' => [
                ['id' => 'pool1', 'date' => '2024-12-01', 'liquidity' => 100000],
                ['id' => 'pool2', 'date' => '2024-12-01', 'liquidity' => 200000],
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/pools/line/liquidity', ['query' => ['ids' => 'pool1,pool2']])
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $pools = new Pools(httpClient: $mockClient);

        $liquidityHistory = $pools->getPoolLiquidityHistory(['pool1', 'pool2']);

        $this->assertCount(2, $liquidityHistory);
        $this->assertEquals('pool1', $liquidityHistory[0]['id']);
        $this->assertEquals(100000, $liquidityHistory[0]['liquidity']);
    }

    public function testGetPoolPositionHistory(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'positionHistory' => [
                ['id' => 'pool1', 'date' => '2024-12-01', 'position' => 150],
                ['id' => 'pool2', 'date' => '2024-12-01', 'position' => 250],
            ]
        ];
        $mockClient->method('get')
            ->with('https://api-v3.raydium.io/pools/line/position', ['query' => ['ids' => 'pool1,pool2']])
            ->willReturn(new Response(200, [], json_encode($mockResponse)));

        $pools = new Pools(httpClient: $mockClient);

        $positionHistory = $pools->getPoolPositionHistory(['pool1', 'pool2']);

        $this->assertCount(2, $positionHistory);
        $this->assertEquals('pool1', $positionHistory[0]['id']);
        $this->assertEquals(150, $positionHistory[0]['position']);
    }




}
