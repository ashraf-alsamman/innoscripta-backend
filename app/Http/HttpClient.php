<?php

namespace App\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class HttpClient
{

    public function __construct(private Client $client)
    {
    }

    public function get(string $url,string $apiKey, array $headers = [] )
    {
        try {
            $options = [
                'headers' => $headers,
            ];

            $response = $this->client->get($url . $apiKey, $options);
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
