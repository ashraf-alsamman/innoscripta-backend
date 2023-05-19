<?php

namespace App\Services;
use App\Services\PreferencesService;
use App\Repositories\ArticlesRepository;
use App\Repositories\LogsRepository;
use App\ArticlesProviders\ArticlesProvidersLoader;
use App\Models\User;

class ArticlesService
{
    public function __construct(
        private readonly ArticlesProvidersLoader $articlesProvidersLoader,
        private readonly ArticlesRepository $articlesRepository,
        private readonly PreferencesService $preferencesService,
        private readonly LogsRepository $logsRepository
    ) {
    }

    public function getArticlesWithFilter(array $filter)
    {
        return $this->articlesRepository->getArticlesWithFilter($filter);
    }

    public function importArticles():array
    {
        $statuses = [
            'success' => [],
            'error' => [],
        ];
        foreach ($this->articlesProvidersLoader->getAll() as $provider) {
            try {
                $single_provider = $provider->getArticles();
                $this->articlesRepository->saveArticles($single_provider);
                $statuses['success'][] = get_class($provider);
            } catch (\Exception $e) {
                $statuses['error'][] = [
                    'class' => get_class($provider),'error' => $e->getMessage(),
                ];
                continue;
            }
        }

        if (count($statuses['success']) === 0) {
            $this->logsRepository->saveLogs("Artical", "All Providers failed", $statuses);
            throw new \Exception('All Providers failed.');
        }
        return $statuses;
    }



    public function getMyArticles(User $user)
    {
        $preference = $this->preferencesService->getPreferences($user);
        return $this->articlesRepository->getUserPreferredArticles($preference);
    }
}
