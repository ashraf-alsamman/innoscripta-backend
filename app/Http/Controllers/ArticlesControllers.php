<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArticlesService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

/**
 * Class ArticlesControllers
 * @package App\Http\Controllers
 */
class ArticlesControllers extends Controller
{
    /**
     * ArticlesControllers constructor.
     *
     * @param ArticlesService $articlesService
     */
    public function __construct(private ArticlesService $articlesService)
    {
    }

    /**
     * Get articles belonging to the authenticated user.
     *
     * @return JsonResponse
     */
    public function getMyArticles(): JsonResponse
    {
        try {
            $user = Auth::user();
            $articles = $this->articlesService->getMyArticles($user);
            return response()->json(['data' => $articles, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve articles for the user',
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get articles with the provided filter.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getArticlesWithFilter(Request $request): JsonResponse
    {
        try {
            $filter = $request->only(['keyword', 'date', 'category', 'source']);
            $articles = $this->articlesService->getArticlesWithFilter($filter);
            return response()->json(['data' => $articles, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to load articles',
                'error' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }
}
