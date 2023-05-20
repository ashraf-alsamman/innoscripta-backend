<?php

namespace App\DTO;

/**
 * Class ArticleDTO
 * @package App\DTO
 */
class ArticleDTO
{
    /**
     * ArticleDTO constructor.
     *
     * @param mixed $unique_hash
     * @param string $provider
     * @param string $title
     * @param string|array|null $content
     * @param string|array|null $source
     * @param string|array|null $description
     * @param string|array|null $url
     * @param string|array|null $category
     * @param string|array|null $published_at
     * @param string|array|null $author
     */
    public function __construct(
        public mixed $unique_hash,
        public string $provider,
        public string $title,
        public string|array|null $content = null,
        public string|array|null $source,
        public string|array|null $description,
        public string|array|null $url,
        public string|array|null $category,
        public string|array|null $published_at,
        public string|array|null $author = null
    ) {}

    /**
     * Convert the ArticleDTO to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'unique_hash' => $this->unique_hash,
            'provider' => $this->provider,
            'title' => $this->title,
            'content' => $this->content,
            'source' => $this->source,
            'description' => $this->description,
            'url' => $this->url,
            'category' => $this->category,
            'published_at' => $this->published_at,
            'author' => $this->author
        ];
    }
}



















