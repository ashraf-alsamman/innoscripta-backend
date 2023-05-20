<?php

namespace App\ArticlesProviders\Providers;

use App\ArticlesProviders\Providers\ArticlesProviderInterface;
use App\Http\HttpClient;
use App\DTO\ArticleDTO;

/**
 * Class NewsAPI
 * @package App\ArticlesProviders\Providers
 */
class Mediastack implements ArticlesProviderInterface
{
    /**
     * @param HttpClient $httpClient
     */
    public function __construct(private HttpClient $httpClient)
    {
    }

    /**
     * Get articles from the provider.
     *
     * @return array
     */
    public function getArticles(): array
    {
        $url = config('Articles.Mediastack.URL');
        $apiKey = config('Articles.Mediastack.KEY');
        $data = $this->httpClient->get($url, $apiKey);
        return $this->transformArticles($data['data']);
    }

    /**
     * Generate a unique hash for an article.
     *
     * @param string $title
     * @param string $published_at
     * @return string
     */
    private function unique_hash(string $title, string $published_at): string
    {
        $titleSnippet = substr($title, 0, 10);
        $published_atSnippet = substr($published_at, 0, 8);
        return md5($titleSnippet . $published_atSnippet);
    }

    /**
     * Format the date and time string.
     *
     * @param string $dateString
     * @return string
     */
    private function formattedDateTime(string $dateString): string
    {
        $carbon = \Carbon\Carbon::parse($dateString);
        return $carbon->format('Y-m-d H:i:s');
    }

    /**
     * Transform the articles into an array of ArticleDTO objects.
     *
     * @param array $articles
     * @return array
     */
    private function transformArticles(array $articles): array
    {
        return array_map(function ($article) {
            return (new ArticleDTO(
                unique_hash: $this->unique_hash($article['title'], $article['published_at']),
                provider: "Mediastack",
                title: $article['title'] ?? 'No title provided',
                content: $article['description'] ?? 'no content exist ',
                source: $article['source'],
                description: $article['description'],
                url: $article['url'] ?? 'no url exist',
                category: $article['category'],
                published_at: $this->formattedDateTime($article['published_at']),
                author: $article['author'] ?? 'no author exist',
            ))->toArray();
        }, $articles);
    }
}
