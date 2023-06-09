<?php

namespace App\ArticlesProviders\Providers;

use App\Http\HttpClient;
use App\ArticlesProviders\Providers\ArticlesProviderInterface;
use App\DTO\ArticleDTO;

/**
 * Class NewYorkTimes
 * @package App\ArticlesProviders\Providers
 */
class NewYorkTimes implements ArticlesProviderInterface
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
        $url = config('Articles.NewYorkTimes.URL');
        $apiKey = config('Articles.NewYorkTimes.KEY');
        $data = $this->httpClient->get($url, $apiKey);
        return $this->transformArticles($data['response']['docs']);
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
                unique_hash: $this->unique_hash($article['snippet'], $article['pub_date']),
                provider: "NewYorkTimes",
                title: $article['snippet'] ?? 'No title provided',
                content: $article['lead_paragraph'] ?? 'no content exist',
                source: $article['source'],
                category: $article['section_name'] ?? 'No category provided',
                description: $article['snippet'],
                url: $article['web_url'] ?? 'no url exist',
                published_at: $this->formattedDateTime($article['pub_date']),
                author: $article['byline']['original'] ?? 'no author exist',
            ))->toArray();
        }, $articles);
    }
}
