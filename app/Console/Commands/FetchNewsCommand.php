<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ArticlesService;

/**
 * Class FetchNewsCommand
 * @package App\Console\Commands
 */
class FetchNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Articles from all providers';

    /**
     * @param ArticlesService $articlesService
     */
    public function __construct(private readonly ArticlesService $articlesService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->articlesService->importArticles();
    }
}
