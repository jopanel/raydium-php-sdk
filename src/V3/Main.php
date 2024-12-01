<?php

namespace JosephOpanel\RaydiumSDK\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Main
{
    private Client $httpClient;
    private string $baseUrl;

    public function __construct(string $baseUrl = 'https://api-v3.raydium.io', ?Client $httpClient = null)
    {
        $this->baseUrl = $baseUrl;
        $this->httpClient = $httpClient ?? new Client();
    }

    /**
     * Fetch the UI V3 current version.
     *
     * @return string The current UI version.
     * @throws GuzzleException
     */
    public function getVersion(): string
    {
        $response = $this->httpClient->get("{$this->baseUrl}/main/version");
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['version'] ?? 'Unknown';
    }

    /**
     * Fetch the UI RPCs information.
     *
     * @return array An array of RPC details.
     * @throws GuzzleException
     */
    public function getRPCs(): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/main/rpcs");
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['rpcs'] ?? [];
    }

    /**
     * Fetch the chain time.
     *
     * @return string The current chain time in ISO 8601 format.
     * @throws GuzzleException
     */
    public function getChainTime(): string
    {
        $response = $this->httpClient->get("{$this->baseUrl}/main/chain-time");
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['chainTime'] ?? 'Unknown';
    }

    /**
     * Fetch the TVL and 24-hour volume information.
     *
     * @return array An associative array containing TVL and 24-hour volume data.
     * @throws GuzzleException
     */
    public function getInfo(): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/main/info");
        $data = json_decode($response->getBody()->getContents(), true);

        return [
            'tvl' => $data['tvl'] ?? 0,
            'volume24h' => $data['volume24h'] ?? 0,
        ];
    }

    /**
     * Fetch the RAY stake pools information.
     *
     * @return array An array of stake pool details.
     * @throws GuzzleException
     */
    public function getStakePools(): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/main/stake-pools");
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['stakePools'] ?? [];
    }

    /**
     * Fetch the Migrate LP Pool List.
     *
     * @return array An array of LP pools available for migration.
     * @throws GuzzleException
     */
    public function getMigrateLP(): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/main/migrate-lp");
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['pools'] ?? [];
    }

    /**
     * Fetch the transaction auto-fee configuration.
     *
     * @return array An associative array of fee configurations.
     * @throws GuzzleException
     */
    public function getAutoFee(): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/main/auto-fee");
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['fees'] ?? [];
    }

    /**
     * Fetch the CLMM configuration.
     *
     * @return array An associative array of CLMM configurations.
     * @throws GuzzleException
     */
    public function getClmmConfig(): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/main/clmm-config");
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['config'] ?? [];
    }

    /**
     * Fetch the CPMM configuration.
     *
     * @return array An associative array of CPMM configurations.
     * @throws GuzzleException
     */
    public function getCpmmConfig(): array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/main/cpmm-config");
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['config'] ?? [];
    }






}

