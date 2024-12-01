<?php

namespace JosephOpanel\RaydiumSDK\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class IDO
{
    private Client $httpClient;
    private string $baseUrl;

    public function __construct(string $baseUrl = 'https://api-v3.raydium.io', ?Client $httpClient = null)
    {
        $this->baseUrl = $baseUrl;
        $this->httpClient = $httpClient ?? new Client();
    }

    /**
     * Fetch IDO pool keys by IDO IDs.
     *
     * @param array $ids An array of IDO pool IDs to query.
     * @return array An array of IDO pool keys for the specified IDs.
     * @throws GuzzleException
     */
    public function getIDOPoolKeys(array $ids): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/ido/key/ids", [
            'query' => ['ids' => implode(',', $ids)]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['keys'] ?? [];
    }
}
