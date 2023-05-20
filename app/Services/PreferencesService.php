<?php

namespace App\Services;

use App\Repositories\ArticlesRepository;
use App\Repositories\PreferencesRepository;
use App\Models\User;

class PreferencesService
{
    /**
     * PreferencesService constructor.
     *
     * @param ArticlesRepository $articlesRepository
     * @param PreferencesRepository $preferencesRepository
     */
    public function __construct(
        private readonly ArticlesRepository $articlesRepository,
        private readonly PreferencesRepository $preferencesRepository,
    ) {
    }

    /**
     * Get all preferences.
     *
     * @return array
     */
    public function getAllPreferences(): array
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

    /**
     * Save user preferences.
     *
     * @param User $user
     * @param array $preferences
     * @return void
     */
    public function saveUserPreferences(User $user, array $preferences): void
    {
        $this->preferencesRepository->saveUserPreferences($user, $preferences);
    }

    /**
     * Get user preferences.
     *
     * @param User $user
     * @return array
     */
    public function getPreferences(User $user): array
    {
        return $this->preferencesRepository->getUserPreferences($user);
    }
}
