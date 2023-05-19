<?php
namespace App\DTO;

class ArticleDTO
{
    public function __construct(
        public  $unique_hash,
        public string $provider,
        public string $title,
        public string|array|null $content = null,
        public string|array|null  $source,
        public string|array|null  $description,
        public string|array|null  $url,
        public string|array|null  $category,
        public string|array|null  $published_at,
        public string|array|null $author = null,

    ) {}

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
            'author' => $this->author,

        ];
    }
}





















