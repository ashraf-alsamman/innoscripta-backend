<?php

namespace App\ArticlesProviders\Providers;

use App\Http\HttpClient;
use App\ArticlesProviders\Providers\ArticlesProviderInterface;
use App\DTO\ArticleDTO;

class NewYorkTimes implements ArticlesProviderInterface
{
    public function __construct(private HttpClient $httpClient)
    {
    }

    public function getArticles()
    {
        $apiKey = 'xIwnN0MI0C5GtUUDwIDJGFoGZluqbHfy';
        $url = 'https://api.nytimes.com/svc/search/v2/articlesearch.json?api-key=';
        $data = $this->httpClient->get($url, $apiKey);
        return $this->transformArticles($data['response']['docs']);
    }


    private function transformArticles(array $articles)
    {
        return array_map(function ($article) {
            return new ArticleDTO(
                provider: "NewYorkTimes",
                source: $article['source'],
                title: $article['headline']['main'] ?? 'No title provided',
                category: "no title",
                description: $article['snippet'],
                url: $article['web_url'],
                published_at: $article['pub_date'],
                author: $article['byline']['original'] ?? null,
                content: $article['lead_paragraph'] ?? null
            );
        }, $articles);
    }
}
