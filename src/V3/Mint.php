<?php

namespace JosephOpanel\RaydiumSDK\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Mint
{
    private Client $httpClient;
    private string $baseUrl;

    public function __construct(string $baseUrl = 'https://api-v3.raydium.io', ?Client $httpClient = null)
    {
        $this->baseUrl = rtrim($baseUrl, '/'); // Ensure no trailing slash
        $this->httpClient = $httpClient ?? new Client(['timeout' => 10]); // Add default timeout
    }

    /**
     * Fetch the default mint list.
     *
     * @return array An array of default mint details.
     */
    public function getList(): array
    {
        return $this->makeRequest('/mint/list', [], 'mints', []);
    }

    /**
     * Fetch detailed information about specific mints.
     *
     * @param array $ids An array of mint IDs to query.
     * @return array An array of mint details for the specified IDs.
     */
    public function getMintInfo(array $ids): array
    {
        return $this->makeRequest('/mint/ids', ['mints' => implode(',', $ids)], 'mints', []);
    }

    /**
     * Fetch the current price information for specific mints.
     *
     * @param array $ids An array of mint IDs to query prices for.
     * @return array An associative array of mint prices indexed by mint ID.
     */
    public function getMintPrice(array $ids): array
    {
        return $this->makeRequest('/mint/price', ['mints' => implode(',', $ids)], 'data', []);
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
     * Log an error message for debugging.
     *
     * @param string $message The error message to log.
     */
    private function logError(string $message): void
    {
        error_log($message);
    }
}
