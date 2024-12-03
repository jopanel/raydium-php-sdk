<?php

namespace JosephOpanel\RaydiumSDK\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;

class Main
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
     * Fetch the UI V3 current version.
     *
     * @return string The current UI version.
     */
    public function getVersion(): string
    {
        return $this->makeRequest('/main/version', 'version', 'Unknown');
    }

    /**
     * Fetch the UI RPCs information.
     *
     * @return array An array of RPC details.
     */
    public function getRPCs(): array
    {
        return $this->makeRequest('/main/rpcs', 'rpcs', []);
    }

    /**
     * Fetch the chain time.
     *
     * @return string The current chain time in ISO 8601 format.
     */
    public function getChainTime(): string
    {
        return $this->makeRequest('/main/chain-time', 'chainTime', 'Unknown');
    }

    /**
     * Fetch the TVL and 24-hour volume information.
     *
     * @return array An associative array containing TVL and 24-hour volume data.
     */
    public function getInfo(): array
    {
        return $this->makeRequest('/main/info', null, ['tvl' => 0, 'volume24h' => 0]);
    }

    /**
     * Fetch the RAY stake pools information.
     *
     * @return array An array of stake pool details.
     */
    public function getStakePools(): array
    {
        return $this->makeRequest('/main/stake-pools', 'stakePools', []);
    }

    /**
     * Fetch the Migrate LP Pool List.
     *
     * @return array An array of LP pools available for migration.
     */
    public function getMigrateLP(): array
    {
        return $this->makeRequest('/main/migrate-lp', 'pools', []);
    }

    /**
     * Fetch the transaction auto-fee configuration.
     *
     * @return array An associative array of fee configurations.
     */
    public function getAutoFee(): array
    {
        return $this->makeRequest('/main/auto-fee', 'fees', []);
    }

    /**
     * Fetch the CLMM configuration.
     *
     * @return array An associative array of CLMM configurations.
     */
    public function getClmmConfig(): array
    {
        return $this->makeRequest('/main/clmm-config', 'config', []);
    }

    /**
     * Fetch the CPMM configuration.
     *
     * @return array An associative array of CPMM configurations.
     */
    public function getCpmmConfig(): array
    {
        return $this->makeRequest('/main/cpmm-config', 'config', []);
    }

    /**
     * Make an HTTP GET request and return the processed response.
     *
     * @param string $endpoint The API endpoint to call.
     * @param string|null $key Optional key to extract from the response.
     * @param mixed $default The default value to return if the key or response is not found.
     * @return mixed The processed response or default value.
     */
    private function makeRequest(string $endpoint, ?string $key, $default)
    {
        try {
            $response = $this->httpClient->get("{$this->baseUrl}{$endpoint}", [
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
