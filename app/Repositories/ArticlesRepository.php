<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticlesRepository
{
    /**
     * Save articles to the database.
     *
     * @param array|null $single_provider
     * @return int
     */
    public function saveArticles(?array $single_provider): int
    {
        return Article::query()->upsert($single_provider, "title");
    }

    /**
     * Get articles based on user preferences.
     *
     * @param array|null $preference
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByPreference(?array $preference): Collection
    {
        $query = Article::query();

        if ($preference) {
            if ($preference['categories']) {
                $query->whereIn('category', $preference['categories']);
            }
            if ($preference['authors']) {
                $query->whereIn('author', $preference['authors']);
            }
            if ($preference['source']) {
                $query->whereIn('source', $preference['sources']);
            }
        }

        return $query->get();
    }

    /**
     * Get articles based on the provided filter.
     *
     * @param array $filter
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getArticlesWithFilter(array $filter): Collection
    {
        $query = Article::query();

        if (isset($filter['keyword'])) {
            $query->where('title', 'like', '%' . $filter['keyword'] . '%');
        }

        if (isset($filter['date'])) {
            $query->whereDate('published_at', $filter['date']);
        }

        if (isset($filter['category'])) {
            $query->where('category', $filter['category']);
        }

        if (isset($filter['source'])) {
            $query->where('source', $filter['source']);
        }

        return $query->get();
    }

    /**
     * Get articles based on user preferences.
     *
     * @param array $preferences
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserPreferredArticles(array $preferences): Collection
    {
        $no_preferences = true;
        $query = Article::query();

        if (isset($preferences['categories'])) {
            $no_preferences = empty($preferences['categories']) ?? false;
            $categories = $preferences['categories']->pluck('name')->toArray();
            $query->whereIn('category', $categories);
        }

        if (isset($preferences['authors'])) {
            $no_preferences = empty($preferences['authors']) ?? false;
            $authors = $preferences['authors']->pluck('name')->toArray();
            $query->orWhereIn('author', $authors);
        }

        if (isset($preferences['sources'])) {
            $no_preferences = empty($preferences['sources']) ?? false;
            $sources = $preferences['sources']->pluck('name')->toArray();
            $query->orWhereIn('source', $sources);
        }

        if ($no_preferences) {
            return new Collection();
        }

        return $query->get();
    }
}
