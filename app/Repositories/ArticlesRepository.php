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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByPreference($preference, $perPage )
    {
        $query = Article::query();

        if ($preference) {
            $query->where(function ($subQuery) use ($preference) {
                if ($preference['categories']) {
                    $subQuery->whereIn('category', $preference['categories']);
                }
                if ($preference['authors']) {
                    $subQuery->orWhereIn('author', $preference['authors']);
                }
                if ($preference['sources']) {
                    $subQuery->orWhereIn('source', $preference['sources']);
                }
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Get articles based on the provided filter.
     *
     * @param array $filter
     * @return \Illuminate\Database\Eloquent\Collection
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
