<?php

namespace JosephOpanel\RaydiumSDK\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Mint
{
    private Client $httpClient;
    private string $baseUrl;

    public function __construct(string $baseUrl = 'https://api-v3.raydium.io', ?Client $httpClient = null)
    {
        $this->baseUrl = $baseUrl;
        $this->httpClient = $httpClient ?? new Client();
    }

    /**
     * Fetch the default mint list.
     *
     * @return array An array of default mint details.
     * @throws GuzzleException
     */
    public function getList(): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/mint/list");
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['mints'] ?? [];
    }

    /**
     * Fetch detailed information about specific mints.
     *
     * @param array $ids An array of mint IDs to query.
     * @return array An array of mint details for the specified IDs.
     * @throws GuzzleException
     */
    public function getMintInfo(array $ids): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/mint/ids", [
            'query' => ['mints' => implode(',', $ids)]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['mints'] ?? [];
    }

    /**
     * Fetch the current price information for specific mints.
     *
     * @param array $ids An array of mint IDs to query prices for.
     * @return array An associative array of mint prices indexed by mint ID.
     * @throws GuzzleException
     */
    public function getMintPrice(array $ids): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/mint/price", [
            'query' => ['mints' => implode(',', $ids)]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['prices'] ?? [];
    }


}
