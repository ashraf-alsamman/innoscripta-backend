<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Preference;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
     * @return   Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function hasPreferenceFilters($preference)
    {
        return $preference && (
            (!empty($preference['categories']) && $preference['categories'] !== null) ||
            (!empty($preference['authors']) && $preference['authors'] !== null) ||
            (!empty($preference['sources']) && $preference['sources'] !== null)
        );
    }

    public function getByPreference($preference, $perPage)
    {
        if (!$this->hasPreferenceFilters($preference)) {
            return [];
        }
            $query = Article::query();
            $query->where(function ($subQuery) use ($preference) {
                if (!empty($preference['categories'])) {
                    $subQuery->whereIn('category', $preference['categories']);
                }
                if (!empty($preference['authors'])) {
                    $subQuery->orWhereIn('author', $preference['authors']);
                }
                if (!empty($preference['sources'])) {
                    $subQuery->orWhereIn('source', $preference['sources']);
                }
               });

        $results = $query->paginate($perPage);
        return $results;
    }




    /**
     * Get articles based on the provided filter.
     *
     * @param array $filter
     * @return  Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function getArticlesWithFilter(array $filter, $perPage): LengthAwarePaginator
    {
        $query = Article::query();

        if (isset($filter['keyword'])) {
            $query->where('title', 'like', '%' . $filter['keyword'] . '%');
        }

        if (isset($filter['date'])) {
            $query->whereDate('published_at', '>', $filter['date']);
        }

        if (isset($filter['category'])) {
            $query->where('category', $filter['category']);
        }

        if (isset($filter['source'])) {
            $query->where('source', $filter['source']);
        }

        return $query->paginate($perPage);
    }
}
