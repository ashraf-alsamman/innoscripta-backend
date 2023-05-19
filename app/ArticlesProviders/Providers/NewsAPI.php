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
        $url =  config('Articles.NewsAPI.URL');
        $apiKey = config('Articles.NewsAPI.KEY');
        $data = $this->httpClient->get($url, $apiKey);

        return $this->transformArticles($data['articles']);
    }

    private function unique_hash($title, $published_at): string
    {
        $titleSnippet = substr($title, 0, 10);
        $published_atSnippet = substr($published_at, 0, 8);
        return md5($titleSnippet . $published_atSnippet);
    }

    private function formattedDateTime($dateString): string
    {
        $carbon = \Carbon\Carbon::parse($dateString);
        return $carbon->format('Y-m-d H:i:s');;
    }

    private function transformArticles($articles)
    {
        return array_map(function ($article) {
            return (new ArticleDTO(
                unique_hash: $this->unique_hash($article['title'], $article['publishedAt']),
                provider: "NewsAPI",
                title: $article['title'] ?? 'No title provided',
                content: $article['content'] ?? 'no content exist ',
                source: $article['source']['name'],
                description: $article['description'],
                url: $article['url']?? 'no url exist',
                category: "no category",
                published_at: $this->formattedDateTime($article['publishedAt']) ,
                author: $article['byline']['original'] ?? 'no data exist',
            ))->toArray();
        }, $articles);
    }
}
