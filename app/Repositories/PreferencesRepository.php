<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Author;
use App\Models\Source;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class PreferencesRepository
{
    /**
     * Get the user's preferences.
     *
     * @param User $user
     * @return array
     */
    public function getUserPreferences(User $user): array
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

    /**
     * Save user preferences.
     *
     * @param User $user
     * @param array $preferences
     * @return void
     */
    public function saveUserPreferences(User $user, array $preferences): void
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

    /**
     * Get all sources.
     *
     * @return Collection
     */
    public function getAllSources(): Collection
    {
        return Source::all();
    }

    /**
     * Get all categories.
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    /**
     * Get all authors.
     *
     * @return Collection
     */
    public function getAllAuthors(): Collection
    {
        return Author::all();
    }
}
