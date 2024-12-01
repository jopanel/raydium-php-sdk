<?php

namespace JosephOpanel\RaydiumSDK\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Pools
{
    private Client $httpClient;
    private string $baseUrl;

    public function __construct(string $baseUrl = 'https://api-v3.raydium.io', ?Client $httpClient = null)
    {
        $this->baseUrl = $baseUrl;
        $this->httpClient = $httpClient ?? new Client();
    }

    /**
     * Fetch information for specific pools by their IDs.
     *
     * @param array $ids An array of pool IDs to query.
     * @return array An array of pool details for the specified IDs.
     * @throws GuzzleException
     */
    public function getPoolInfoByIds(array $ids): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/pools/info/ids", [
            'query' => ['ids' => implode(',', $ids)]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['pools'] ?? [];
    }

    /**
     * Fetch pool information by LP mint addresses.
     *
     * @param array $lpMints An array of LP mint addresses to query.
     * @return array An array of pool details for the specified LP mints.
     * @throws GuzzleException
     */
    public function getPoolInfoByLPs(array $lpMints): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/pools/info/lps", [
            'query' => ['lpMints' => implode(',', $lpMints)]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['pools'] ?? [];
    }

    /**
     * Fetch information for all pools.
     *
     * @return array An array of details for all pools on the platform.
     * @throws GuzzleException
     */
    public function getAllPoolsInfo(): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/pools/info/list");
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['pools'] ?? [];
    }

    /**
     * Fetch pool information by token mint addresses.
     *
     * @param array $tokenMints An array of token mint addresses to query.
     * @return array An array of pool details for the specified token mints.
     * @throws GuzzleException
     */
    public function getPoolInfoByTokenMint(array $tokenMints): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/pools/info/mint", [
            'query' => ['tokenMints' => implode(',', $tokenMints)]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['pools'] ?? [];
    }

    /**
     * Fetch pool key information by pool IDs.
     *
     * @param array $ids An array of pool IDs to query.
     * @return array An array of pool key details for the specified pool IDs.
     * @throws GuzzleException
     */
    public function getPoolKeysByIds(array $ids): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/pools/key/ids", [
            'query' => ['ids' => implode(',', $ids)]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['keys'] ?? [];
    }

    /**
     * Fetch historical liquidity data for pools.
     *
     * @param array $ids An array of pool IDs to query.
     * @return array An array of liquidity history for the specified pools.
     * @throws GuzzleException
     */
    public function getPoolLiquidityHistory(array $ids): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/pools/line/liquidity", [
            'query' => ['ids' => implode(',', $ids)]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['liquidityHistory'] ?? [];
    }

    /**
     * Fetch historical position data for pools.
     *
     * @param array $ids An array of pool IDs to query.
     * @return array An array of position history for the specified pools.
     * @throws GuzzleException
     */
    public function getPoolPositionHistory(array $ids): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/pools/line/position", [
            'query' => ['ids' => implode(',', $ids)]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['positionHistory'] ?? [];
    }




}
