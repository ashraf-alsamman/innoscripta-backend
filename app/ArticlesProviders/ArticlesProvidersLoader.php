<?php

namespace App\ArticlesProviders;

use App\ArticlesProviders\Providers\NewsAPI;
use App\ArticlesProviders\Providers\NewsCatcherApi;
use App\ArticlesProviders\Providers\NewYorkTimes;
use App\Http\HttpClient;

class ArticlesProvidersLoader
{
    public function __construct(private HttpClient $httpClient)
    {
    }

    /**
     * Get all Articles providers.
     *
     */
    public function getAll(): array
    {
        return [
            new NewsAPI($this->httpClient),
            new NewsCatcherApi($this->httpClient),
            new NewYorkTimes($this->httpClient),
        ];
    }
}
