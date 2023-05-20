<?php

namespace App\ArticlesProviders;

use App\ArticlesProviders\Providers\NewsAPI;
use App\ArticlesProviders\Providers\Mediastack;
use App\ArticlesProviders\Providers\NewYorkTimes;
use App\Http\HttpClient;
use App\ArticlesProviders\Providers\ArticlesProviderInterface;

/**
 * Class ArticlesProvidersLoader
 * @package App\ArticlesProviders
 */
class ArticlesProvidersLoader
{
    /**
     * @param HttpClient $httpClient
     */
    public function __construct(private HttpClient $httpClient)
    {
    }

    /**
     * Get all articles providers.
     *
     * @return ArticlesProviderInterface[]
     */
    public function getAll(): array
    {
        return [
            new NewsAPI($this->httpClient),
            new Mediastack($this->httpClient),
            new NewYorkTimes($this->httpClient),
        ];
    }
}
