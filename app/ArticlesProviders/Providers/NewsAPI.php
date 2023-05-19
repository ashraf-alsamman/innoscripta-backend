<?php

namespace App\ArticlesProviders\Providers;

use App\ArticlesProviders\Providers\ArticlesProviderInterface;
use App\Http\HttpClient;
use App\DTO\ArticleDTO;

class NewsAPI implements ArticlesProviderInterface
{

    public function __construct(private HttpClient $httpClient)
    {
    }

    public function getArticles()
    {
        $apiKey = 'e808980ef96b4c0da93980b9980c3bab';
        $url =  'https://newsapi.org/v2/everything?q=tesla&sortBy=publishedAt&apiKey=';
        $data = $this->httpClient->get($url, $apiKey);

        return $this->transformArticles($data['articles']);
    }



    private function transformArticles(array $articles)
    {
        return array_map(function ($article) {
            return new ArticleDTO(
                 "NewsAPI",
                   $article['source']['name'],
                  $article['title'] ?? 'No title provided',
                  "no title",
                  $article['description'],
                  $article['url'],
              $article['publishedAt'],
                  $article['byline']['original'] ?? null,
                  $article['content'] ?? null
            );
        }, $articles);
    }


}
