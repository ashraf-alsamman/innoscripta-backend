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
        $url =  config('Articles.NewsCatcherApi.URL');
        $apiKey = config('Articles.NewsCatcherApi.KEY');
        $header =   ['x-api-key' => $apiKey,];
        $data = $this->httpClient->get($url, $apiKey, $header);
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

    private function transformArticles(array $articles)
    {
        return array_map(function ($article) {
            return new ArticleDTO(
                unique_hash: $this->unique_hash($article['title'], $article['publishedAt']),
                provider: "newscatcherapi.com",
                source: $article['rights'],
                title: $article['title'] ?? 'No title provided',
                category: $article['topic'],
                author: $article['authors']?? 'no url exist',
                description: $article['excerpt'],
                url: $article['link'] ?? 'no url exist',
                published_at: $this->formattedDateTime($article['published_date']) ,
                content: $article['summary']?? 'no url exist',
            );
        }, $articles);
    }
}
