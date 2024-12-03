<?php

namespace JosephOpanel\RaydiumSDK\V3;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;

class IDO
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
     * Fetch IDO pool keys by IDO IDs.
     *
     * @param array $ids An array of IDO pool IDs to query.
     * @return array An array of IDO pool keys for the specified IDs.
     */
    public function getIDOPoolKeys(array $ids): array
    {
        return $this->makeRequest('/ido/key/ids', ['ids' => implode(',', $ids)], 'keys', []);
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
