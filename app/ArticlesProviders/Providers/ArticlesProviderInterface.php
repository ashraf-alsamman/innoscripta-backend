<?php

namespace App\ArticlesProviders\Providers;

/**
 * Interface ArticlesProviderInterface
 * @package App\ArticlesProviders\Providers
 */
interface ArticlesProviderInterface
{
    /**
     * Get articles from the provider.
     *
     * @return array
     */
    public function getArticles(): array;
}
