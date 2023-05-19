<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Arr;

class ArticlesRepository
{

    public function saveArticles(?array $single_provider)
    {
        return  Article::query()->upsert($single_provider, "title");
    }


    public function getByPreference(?array $preference)
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

    public function getArticlesWithFilter($filter)
    {
        $query = Article::query();

        if (isset($preferences['keyword'])) {
            $query->where('title', 'like', '%' . $filter['keyword'] . '%');
        }

        if (isset($preferences['date'])) {
            $query->whereDate('published_at', $filter['date']);
        }

        if (isset($preferences['category'])) {
            $query->where('category', $filter['category']);
        }

        if (isset($preferences['source'])) {
            $query->where('source', $filter['source']);
        }

        return $query->get();
    }

    public function getUserPreferredArticles($preferences)
    {
        $no_preferences = true;
        $query = Article::query();

        if (isset($preferences['categories'])) {
            $no_preferences = empty($categories) ?? false;
            $categories = $preferences['categories']->pluck('name')->toArray();
            $query->whereIn('category', $categories);
        }

        if (isset($preferences['authors'])) {
            $no_preferences = empty($categories) ?? false;
            $authors = $preferences['authors']->pluck('name')->toArray();
            $query->orWhereIn('author', $authors);
        }

        if (isset($preferences['sources'])) {
            $no_preferences = empty($categories) ?? false;
            $sources = $preferences['sources']->pluck('name')->toArray();
            $query->orWhereIn('source', $sources);
        }

        if ($no_preferences) {
            return [];
        }

        $articles = $query->get();

        return $articles;
    }
}
