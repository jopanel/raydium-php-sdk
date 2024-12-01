<?php

namespace JosephOpanel\RaydiumSDK\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Farms
{
    private Client $httpClient;
    private string $baseUrl;

    public function __construct(string $baseUrl = 'https://api-v3.raydium.io', ?Client $httpClient = null)
    {
        $this->baseUrl = $baseUrl;
        $this->httpClient = $httpClient ?? new Client();
    }

    /**
     * Fetch farm pool information by farm IDs.
     *
     * @param array $ids An array of farm IDs to query.
     * @return array An array of farm pool details for the specified IDs.
     * @throws GuzzleException
     */
    public function getFarmInfoByIds(array $ids): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/farms/info/ids", [
            'query' => ['ids' => implode(',', $ids)]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['farms'] ?? [];
    }

    /**
     * Fetch farm pool information by LP mint addresses.
     *
     * @param array $lpMints An array of LP mint addresses to query.
     * @return array An array of farm pool details for the specified LP mints.
     * @throws GuzzleException
     */
    public function getFarmInfoByLP(array $lpMints): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/farms/info/lp", [
            'query' => ['lpMints' => implode(',', $lpMints)]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['farms'] ?? [];
    }

    /**
     * Fetch farm key information by farm IDs.
     *
     * @param array $ids An array of farm IDs to query.
     * @return array An array of farm key details for the specified farm IDs.
     * @throws GuzzleException
     */
    public function getFarmKeysByIds(array $ids): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/farms/key/ids", [
            'query' => ['ids' => implode(',', $ids)]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['keys'] ?? [];
    }


}
