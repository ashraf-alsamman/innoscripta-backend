<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\NewsService;

class FetchNewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $newsService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $preferences = []; // Fetch preferences from database or config

        $articles = $this->newsService->saveNews();

        // Save articles to database
    }
}
