<?php

namespace App\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class HttpClient
 * @package App\Http
 */
class HttpClient
{
    /**
     * HttpClient constructor.
     *
     * @param Client $client
     */
    public function __construct(private Client $client)
    {
    }

    /**
     * Perform an HTTP GET request.
     *
     * @param string $url
     * @param string $apiKey
     * @param array $headers
     * @return array
     */
    public function get(string $url, string $apiKey, array $headers = []): array
    {
        try {
            $headers = [
                'headers' => $headers,
            ];

            $response = $this->client->get($url . $apiKey, $headers);
            return json_decode($response->getBody(), true);

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $errorMessage = json_decode($response->getBody(), true)['message'] ?? 'Error occurred during the API request.';
            return [
                'error' => $errorMessage,
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}
