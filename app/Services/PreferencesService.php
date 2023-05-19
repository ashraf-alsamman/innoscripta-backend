<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Repositories\ArticlesRepository;
use App\Repositories\PreferencesRepository;
use App\Models\Preference;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\Category;
use App\Models\Author;
use App\Models\Source;
use Illuminate\Support\Facades\Auth;
class PreferencesService
{

    public function __construct(
        private readonly ArticlesRepository $articlesRepository,
        private readonly PreferencesRepository $preferencesRepository,
    ) {
    }

    public function getAllPreferences()
    {
        $sources = $this->preferencesRepository->getAllSources();
        $categories = $this->preferencesRepository->getAllCategories();
        $authors = $this->preferencesRepository->getAllAuthors();

        return [
            'sources' => $sources,
            'categories' => $categories,
            'authors' => $authors,
        ];
    }

    public function saveUserPreferences(User $user, array $preferences)
    {
        return $this->preferencesRepository->saveUserPreferences($user, $preferences);
    }

    public function getPreferences(User $user)
    {
        return $this->preferencesRepository->getUserPreferences($user);
    }
}
