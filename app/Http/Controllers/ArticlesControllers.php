<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Preference;
use App\Services\ArticlesService;
use Illuminate\Support\Facades\Auth;

class ArticlesControllers extends Controller
{

    public function __construct(private ArticlesService $articlesService)
    {
    }

    public function getMyArticles()
    {
        try {
            $user = Auth::user();
            $articles = $this->articlesService->getMyArticles($user);
            return response()->json(['data' => $articles, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'get Articles for user failed',
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getArticlesWithFilter(Request $request)
    {
        try {
            $filter = $request->only(['keyword', 'date', 'category', 'source']);
            $articles = $this->articlesService->getArticlesWithFilter($filter);
            return response()->json(['data' => $articles, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Articles failed to load', 'error' => $e->getMessage(), 'status' => false
            ], 500);
        }
    }
}
