<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ArticlesService;

class FetchNewsCommand extends Command
{
    protected $signature = 'news:fetch';
    protected $description = 'Fetch Articles from all providers';


    public function __construct(private readonly ArticlesService $articlesService)
    {
          parent::__construct();
    }

    public function handle()
    {
        $this->articlesService->importArticles();
    }
}
