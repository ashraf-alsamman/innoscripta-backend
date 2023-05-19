<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Author;
use App\Models\Source;
use App\Models\Category;

class PreferencesRepository
{
    public function getUserPreferences(User $user)
    {
        $user->load('categories', 'authors', 'sources');
        $categories = $user->categories;
        $authors = $user->authors;
        $sources = $user->sources;

        return [
            'categories' => $categories,
            'authors' => $authors,
            'sources' => $sources,
        ];
    }

    public function saveUserPreferences(User $user , array $preferences)
    {
        if (isset($preferences['categories'])) {
            $categories = Category::whereIn('id', $preferences['categories'])->get();
            $user->categories()->sync($categories);
        }

        if (isset($preferences['sources'])) {
            $sources = Source::whereIn('id', $preferences['sources'])->get();
            $user->sources()->sync($sources);
        }

        if (isset($preferences['authors'])) {
            $authors = Author::whereIn('id', $preferences['authors'])->get();
            $user->authors()->sync($authors);
        }
    }

    public function getAllSources()
    {
        return Source::all();
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    public function getAllAuthors()
    {
        return Author::all();
    }
}
