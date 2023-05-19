<?php

namespace App\ArticlesProviders\Providers;

use App\ArticlesProviders\Providers\ArticlesProviderInterface;
use App\Http\HttpClient;
use App\DTO\ArticleDTO;

class NewsCatcherApi implements ArticlesProviderInterface
{
    public function __construct(private HttpClient $httpClient)
    {
    }


    public function getArticles()
    {
        $apiKey = 'cd_u19izl2VHL1e4Gk7t2LsFH5v5DaLuPrPbiFLYbCY';
        $url = 'https://api.newscatcherapi.com/v2/latest_headlines?countries=US';
        $header =   ['x-api-key' => $apiKey,];
        $data = $this->httpClient->get($url, $apiKey, $header);
        return $this->transformArticles($data['articles']);
    }

    private function transformArticles(array $articles)
    {
        return array_map(function ($article) {
            return new ArticleDTO(
                provider: "newscatcherapi.com",
                source: $article['rights'],
                title: $article['title'] ?? 'No title provided',
                category: $article['topic'],
                author: $article['authors'] ?? null,
                description: $article['excerpt'],
                url: $article['link'],
                published_at: $article['published_date'],
                content: $article['summary'] ?? null
            );
        }, $articles);
    }
}
