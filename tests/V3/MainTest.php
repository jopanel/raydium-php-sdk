<?php

namespace JosephOpanel\RaydiumSDK\Tests\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use JosephOpanel\RaydiumSDK\V3\Main;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    public function testGetVersion(): void
    {
        // Mock the Guzzle client
        $mockClient = $this->createMock(Client::class);
        $mockClient->method('get')
            ->willReturn(new Response(200, [], json_encode(['version' => '3.0.0'])));

        $main = new Main(httpClient: $mockClient);

        $version = $main->getVersion();

        $this->assertEquals('3.0.0', $version);
    }

    public function testGetRPCs(): void
	{
	    // Mock the Guzzle client
	    $mockClient = $this->createMock(Client::class);
	    $mockResponse = [
	        'rpcs' => [
	            ['url' => 'https://rpc-mainnet.raydium.io', 'status' => 'online'],
	            ['url' => 'https://rpc-devnet.raydium.io', 'status' => 'offline']
	        ]
	    ];
	    $mockClient->method('get')
	        ->willReturn(new Response(200, [], json_encode($mockResponse)));

	    $main = new Main(httpClient: $mockClient);

	    $rpcs = $main->getRPCs();

	    $this->assertCount(2, $rpcs);
	    $this->assertEquals('https://rpc-mainnet.raydium.io', $rpcs[0]['url']);
	    $this->assertEquals('online', $rpcs[0]['status']);
	}

	public function testGetChainTime(): void
	{
	    // Mock the Guzzle client
	    $mockClient = $this->createMock(Client::class);
	    $mockResponse = ['chainTime' => '2024-12-01T12:00:00Z'];
	    $mockClient->method('get')
	        ->willReturn(new Response(200, [], json_encode($mockResponse)));

	    $main = new Main(httpClient: $mockClient);

	    $chainTime = $main->getChainTime();

	    $this->assertEquals('2024-12-01T12:00:00Z', $chainTime);
	}

	public function testGetInfo(): void
	{
	    // Mock the Guzzle client
	    $mockClient = $this->createMock(Client::class);
	    $mockResponse = ['tvl' => 1000000000, 'volume24h' => 50000000];
	    $mockClient->method('get')
	        ->willReturn(new Response(200, [], json_encode($mockResponse)));

	    $main = new Main(httpClient: $mockClient);

	    $info = $main->getInfo();

	    $this->assertEquals(1000000000, $info['tvl']);
	    $this->assertEquals(50000000, $info['volume24h']);
	}

	public function testGetStakePools(): void
	{
	    // Mock the Guzzle client
	    $mockClient = $this->createMock(Client::class);
	    $mockResponse = [
	        'stakePools' => [
	            ['id' => 'pool1', 'tvl' => 100000, 'apy' => 12.5],
	            ['id' => 'pool2', 'tvl' => 200000, 'apy' => 10.0],
	        ]
	    ];
	    $mockClient->method('get')
	        ->willReturn(new Response(200, [], json_encode($mockResponse)));

	    $main = new Main(httpClient: $mockClient);

	    $stakePools = $main->getStakePools();

	    $this->assertCount(2, $stakePools);
	    $this->assertEquals('pool1', $stakePools[0]['id']);
	    $this->assertEquals(12.5, $stakePools[0]['apy']);
	}

	public function testGetMigrateLP(): void
	{
	    // Mock the Guzzle client
	    $mockClient = $this->createMock(Client::class);
	    $mockResponse = [
	        'pools' => [
	            ['id' => 'lp1', 'source' => 'oldPool', 'destination' => 'newPool'],
	            ['id' => 'lp2', 'source' => 'oldPool2', 'destination' => 'newPool2'],
	        ]
	    ];
	    $mockClient->method('get')
	        ->willReturn(new Response(200, [], json_encode($mockResponse)));

	    $main = new Main(httpClient: $mockClient);

	    $migrateLP = $main->getMigrateLP();

	    $this->assertCount(2, $migrateLP);
	    $this->assertEquals('lp1', $migrateLP[0]['id']);
	    $this->assertEquals('oldPool', $migrateLP[0]['source']);
	}

	public function testGetAutoFee(): void
	{
	    // Mock the Guzzle client
	    $mockClient = $this->createMock(Client::class);
	    $mockResponse = [
	        'fees' => [
	            ['type' => 'transaction', 'amount' => 0.0005],
	            ['type' => 'withdrawal', 'amount' => 0.002],
	        ]
	    ];
	    $mockClient->method('get')
	        ->willReturn(new Response(200, [], json_encode($mockResponse)));

	    $main = new Main(httpClient: $mockClient);

	    $autoFee = $main->getAutoFee();

	    $this->assertCount(2, $autoFee);
	    $this->assertEquals('transaction', $autoFee[0]['type']);
	    $this->assertEquals(0.0005, $autoFee[0]['amount']);
	}

	public function testGetClmmConfig(): void
	{
	    // Mock the Guzzle client
	    $mockClient = $this->createMock(Client::class);
	    $mockResponse = [
	        'config' => [
	            'tickSpacing' => 64,
	            'maxLiquidity' => 1000000000,
	            'minLiquidity' => 1000
	        ]
	    ];
	    $mockClient->method('get')
	        ->willReturn(new Response(200, [], json_encode($mockResponse)));

	    $main = new Main(httpClient: $mockClient);

	    $clmmConfig = $main->getClmmConfig();

	    $this->assertEquals(64, $clmmConfig['tickSpacing']);
	    $this->assertEquals(1000000000, $clmmConfig['maxLiquidity']);
	    $this->assertEquals(1000, $clmmConfig['minLiquidity']);
	}

	public function testGetCpmmConfig(): void
	{
	    // Mock the Guzzle client
	    $mockClient = $this->createMock(Client::class);
	    $mockResponse = [
	        'config' => [
	            'feeRate' => 0.003,
	            'minLiquidity' => 100,
	            'maxLiquidity' => 10000000
	        ]
	    ];
	    $mockClient->method('get')
	        ->willReturn(new Response(200, [], json_encode($mockResponse)));

	    $main = new Main(httpClient: $mockClient);

	    $cpmmConfig = $main->getCpmmConfig();

	    $this->assertEquals(0.003, $cpmmConfig['feeRate']);
	    $this->assertEquals(100, $cpmmConfig['minLiquidity']);
	    $this->assertEquals(10000000, $cpmmConfig['maxLiquidity']);
	}








}
