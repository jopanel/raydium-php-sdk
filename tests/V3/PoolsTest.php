<?php

namespace JosephOpanel\RaydiumSDK\Tests\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use JosephOpanel\RaydiumSDK\V3\Pools;
use PHPUnit\Framework\TestCase;

class PoolsTest extends TestCase
{
    public function testGetPoolInfoByIds(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'pools' => [
                ['id' => 'pool1', 'tvl' => 1000000, 'apy' => 12.5],
                ['id' => 'pool2', 'tvl' => 2000000, 'apy' => 10.0],
            ]
        ];

        $mockClient->method('get')
            ->with(
                'https://api-v3.raydium.io/pools/info/ids',
                ['query' => ['ids' => 'pool1,pool2'], 'headers' => ['accept' => 'application/json']]
            )
            ->willReturn(new Response(200, ['Content-Type' => 'application/json'], json_encode($mockResponse)));

        $pools = new Pools(httpClient: $mockClient);

        $poolInfo = $pools->getPoolInfoByIds(['pool1', 'pool2']);

        $this->assertCount(2, $poolInfo);
        $this->assertEquals(1000000, $poolInfo[0]['tvl']);
        $this->assertEquals(12.5, $poolInfo[0]['apy']);
    }

    public function testGetPoolInfoByIdsHandlesErrorsGracefully(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('get')
            ->willThrowException(new RequestException('Error fetching data', new Request('GET', 'test')));

        $pools = new Pools(httpClient: $mockClient);

        $poolInfo = $pools->getPoolInfoByIds(['pool1', 'pool2']);

        $this->assertEmpty($poolInfo, 'Pool info should be empty on error');
    }

    public function testGetPoolInfoByLPs(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'pools' => [
                ['lpMint' => 'lp1', 'tvl' => 500000, 'apy' => 8.0],
                ['lpMint' => 'lp2', 'tvl' => 750000, 'apy' => 9.5],
            ]
        ];

        $mockClient->method('get')
            ->with(
                'https://api-v3.raydium.io/pools/info/lps',
                ['query' => ['lpMints' => 'lp1,lp2'], 'headers' => ['accept' => 'application/json']]
            )
            ->willReturn(new Response(200, ['Content-Type' => 'application/json'], json_encode($mockResponse)));

        $pools = new Pools(httpClient: $mockClient);

        $poolInfo = $pools->getPoolInfoByLPs(['lp1', 'lp2']);

        $this->assertCount(2, $poolInfo);
        $this->assertEquals('lp1', $poolInfo[0]['lpMint']);
        $this->assertEquals(500000, $poolInfo[0]['tvl']);
    }

    public function testGetPoolInfoByLPsHandlesErrorsGracefully(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('get')
            ->willThrowException(new RequestException('Error fetching data', new Request('GET', 'test')));

        $pools = new Pools(httpClient: $mockClient);

        $poolInfo = $pools->getPoolInfoByLPs(['lp1', 'lp2']);

        $this->assertEmpty($poolInfo, 'Pool info by LPs should be empty on error');
    }

    public function testGetAllPoolsInfo(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockResponse = [
            'pools' => [
                ['id' => 'pool1', 'tvl' => 100000, 'apy' => 12.5],
                ['id' => 'pool2', 'tvl' => 200000, 'apy' => 10.0],
            ]
        ];

        $mockClient->method('get')
            ->with(
                'https://api-v3.raydium.io/pools/info/list',
                [
                    'query' => [], // Include this to account for an empty query array
                    'headers' => ['accept' => 'application/json']
                ]
            )
            ->willReturn(new Response(200, ['Content-Type' => 'application/json'], json_encode($mockResponse)));

        $pools = new Pools(httpClient: $mockClient);

        $allPools = $pools->getAllPoolsInfo();

        $this->assertCount(2, $allPools);
        $this->assertEquals('pool1', $allPools[0]['id']);
    }

    public function testGetAllPoolsInfoHandlesErrorsGracefully(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('get')
            ->willThrowException(new RequestException('Error fetching data', new Request('GET', 'test')));

        $pools = new Pools(httpClient: $mockClient);

        $allPools = $pools->getAllPoolsInfo();

        $this->assertEmpty($allPools, 'All pools info should be empty on error');
    }

    public function testGetPoolKeysByIdsHandlesErrorsGracefully(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('get')
            ->willThrowException(new RequestException('Error fetching data', new Request('GET', 'test')));

        $pools = new Pools(httpClient: $mockClient);

        $poolKeys = $pools->getPoolKeysByIds(['pool1', 'pool2']);

        $this->assertEmpty($poolKeys, 'Pool keys should be empty on error');
    }

    // Add similar error handling test cases for other methods if needed.
}
