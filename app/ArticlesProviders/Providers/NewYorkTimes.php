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
        $url=  config('Articles.NewYorkTimes.URL');
        $apiKey  = config('Articles.NewYorkTimes.KEY');
        $data = $this->httpClient->get($url, $apiKey);
        return $this->transformArticles($data['response']['docs']);
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
                provider: "NewYorkTimes",
                source: $article['source'],
                title: $article['headline']['main'] ?? 'No title provided',
                category: "no title",
                description: $article['snippet'],
                url: $article['web_url'] ?? 'no url exist',
                published_at: $this->formattedDateTime($article['pub_date']) ,
                author: $article['byline']['original'] ?? 'no author exist',
                content: $article['lead_paragraph'] ?? 'no content exist'
            );
        }, $articles);
    }
}
