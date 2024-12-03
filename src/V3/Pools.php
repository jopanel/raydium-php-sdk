<?php

namespace JosephOpanel\RaydiumSDK\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;

class Pools
{
    private Client $httpClient;
    private string $baseUrl;
    private ?LoggerInterface $logger;

    public function __construct(string $baseUrl = 'https://api-v3.raydium.io', ?Client $httpClient = null, ?LoggerInterface $logger = null)
    {
        $this->baseUrl = rtrim($baseUrl, '/'); // Ensure no trailing slash
        $this->httpClient = $httpClient ?? new Client(['timeout' => 10]); // Add default timeout
        $this->logger = $logger; // Optional logger for error logging
    }

    /**
     * Fetch information for specific pools by their IDs.
     *
     * @param array $ids An array of pool IDs to query.
     * @return array An array of pool details for the specified IDs.
     */
    public function getPoolInfoByIds(array $ids): array
    {
        return $this->makeRequest('/pools/info/ids', ['ids' => implode(',', $ids)], 'pools', []);
    }

    /**
     * Fetch pool information by LP mint addresses.
     *
     * @param array $lpMints An array of LP mint addresses to query.
     * @return array An array of pool details for the specified LP mints.
     */
    public function getPoolInfoByLPs(array $lpMints): array
    {
        return $this->makeRequest('/pools/info/lps', ['lpMints' => implode(',', $lpMints)], 'pools', []);
    }

    /**
     * Fetch information for all pools.
     *
     * @return array An array of details for all pools on the platform.
     */
    public function getAllPoolsInfo(): array
    {
        return $this->makeRequest('/pools/info/list', [], 'pools', []);
    }

    /**
     * Fetch pool information by token mint addresses.
     *
     * @param array $tokenMints An array of token mint addresses to query.
     * @return array An array of pool details for the specified token mints.
     */
    public function getPoolInfoByTokenMint(array $tokenMints): array
    {
        return $this->makeRequest('/pools/info/mint', ['tokenMints' => implode(',', $tokenMints)], 'pools', []);
    }

    /**
     * Fetch pool key information by pool IDs.
     *
     * @param array $ids An array of pool IDs to query.
     * @return array An array of pool key details for the specified pool IDs.
     */
    public function getPoolKeysByIds(array $ids): array
    {
        return $this->makeRequest('/pools/key/ids', ['ids' => implode(',', $ids)], 'keys', []);
    }

    /**
     * Fetch historical liquidity data for pools.
     *
     * @param array $ids An array of pool IDs to query.
     * @return array An array of liquidity history for the specified pools.
     */
    public function getPoolLiquidityHistory(array $ids): array
    {
        return $this->makeRequest('/pools/line/liquidity', ['ids' => implode(',', $ids)], 'liquidityHistory', []);
    }

    /**
     * Fetch historical position data for pools.
     *
     * @param array $ids An array of pool IDs to query.
     * @return array An array of position history for the specified pools.
     */
    public function getPoolPositionHistory(array $ids): array
    {
        return $this->makeRequest('/pools/line/position', ['ids' => implode(',', $ids)], 'positionHistory', []);
    }

    /**
     * Make an HTTP GET request and return the processed response.
     *
     * @param string $endpoint The API endpoint to call.
     * @param array $queryParams Query parameters to include in the request.
     * @param string|null $key Optional key to extract from the response.
     * @param mixed $default The default value to return if the key or response is not found.
     * @return mixed The processed response or default value.
     */
    private function makeRequest(string $endpoint, array $queryParams, ?string $key, $default)
    {
        try {
            $response = $this->httpClient->get("{$this->baseUrl}{$endpoint}", [
                'query' => $queryParams,
                'headers' => ['accept' => 'application/json'],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Invalid JSON response');
            }

            return $key ? ($data[$key] ?? $default) : ($data ?? $default);
        } catch (RequestException $e) {
            $this->logError("Error fetching data from {$endpoint}: " . $e->getMessage());
            return $default;
        }
    }

    /**
     * Log an error message if a logger is available.
     *
     * @param string $message
     */
    private function logError(string $message): void
    {
        if ($this->logger) {
            $this->logger->error($message);
        } else {
            error_log($message); // Fallback to error_log
        }
    }
}
