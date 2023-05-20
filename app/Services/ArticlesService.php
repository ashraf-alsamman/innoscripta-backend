<?php

namespace App\Services;

use App\Services\PreferencesService;
use App\Repositories\ArticlesRepository;
use App\Repositories\LogsRepository;
use App\ArticlesProviders\ArticlesProvidersLoader;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ArticlesService
{
    /**
     * ArticlesService constructor.
     *
     * @param ArticlesProvidersLoader $articlesProvidersLoader
     * @param ArticlesRepository $articlesRepository
     * @param PreferencesService $preferencesService
     * @param LogsRepository $logsRepository
     */
    public function __construct(
        private readonly ArticlesProvidersLoader $articlesProvidersLoader,
        private readonly ArticlesRepository $articlesRepository,
        private readonly PreferencesService $preferencesService,
        private readonly LogsRepository $logsRepository
    ) {
    }

    /**
     * Get articles with filter.
     *
     * @param array $filter
     * @return Collection
     */
    public function getArticlesWithFilter(array $filter): Collection
    {
        return $this->articlesRepository->getArticlesWithFilter($filter);
    }

    /**
     * Import articles from providers.
     *
     * @return array
     * @throws \Exception
     */
    public function importArticles(): array
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
                    'class' => get_class($provider),
                    'error' => $e->getMessage(),
                ];
                continue;
            }
        }

        if (count($statuses['success']) === 0) {
            $this->logsRepository->saveLogs("Article", "All Providers failed", $statuses);
            $arrayString = print_r($statuses, true);
            throw new \Exception('All Providers failed.' . $arrayString);
        }

        return $statuses;
    }

    /**
     * Get articles based on user preferences.
     *
     * @param User $user
     * @return Collection
     */
    public function getMyArticles(User $user): Collection
    {
        $preference = $this->preferencesService->getPreferences($user);
        return $this->articlesRepository->getUserPreferredArticles($preference);
    }
}
