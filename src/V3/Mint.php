<?php

namespace JosephOpanel\RaydiumSDK\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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
        try {
            $response = $this->httpClient->get("{$this->baseUrl}/mint/list");
            $data = json_decode($response->getBody()->getContents(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Invalid JSON response');
            }
            return $data['mints'] ?? [];
        } catch (RequestException $e) {
            // Log the error and return an empty array
            error_log("Error fetching mint list: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch detailed information about specific mints.
     *
     * @param array $ids An array of mint IDs to query.
     * @return array An array of mint details for the specified IDs.
     */
    public function getMintInfo(array $ids): array
    {
        try {
            $response = $this->httpClient->get("{$this->baseUrl}/mint/ids", [
                'query' => ['mints' => implode(',', $ids)]
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Invalid JSON response');
            }
            return $data['mints'] ?? [];
        } catch (RequestException $e) {
            error_log("Error fetching mint info: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch the current price information for specific mints.
     *
     * @param array $ids An array of mint IDs to query prices for.
     * @return array An associative array of mint prices indexed by mint ID.
     */
    public function getMintPrice(array $ids): array
    {
        try {
            $response = $this->httpClient->get("{$this->baseUrl}/mint/price", [
                'query' => ['mints' => implode(',', $ids)]
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Invalid JSON response');
            }
            return $data['prices'] ?? [];
        } catch (RequestException $e) {
            error_log("Error fetching mint prices: " . $e->getMessage());
            return [];
        }
    }
}
