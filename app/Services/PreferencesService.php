<?php

namespace App\Services;

use App\Repositories\ArticlesRepository;
use App\Repositories\PreferencesRepository;
use App\Models\User;

class PreferencesService
{

    public function __construct(private PreferencesRepository $preferencesRepository)
    {
    }
    public function getAllPreferences()
    {
        return $this->preferencesRepository->getAllPreferences();
    }
    public function getUserPreference( $userId)
    {
        return $this->preferencesRepository->getUserPreference($userId);
    }

    public function updateUserPreference($userId, $preferenceData)
    {
        return $this->preferencesRepository->updateUserPreference($userId, $preferenceData);
    }
}
