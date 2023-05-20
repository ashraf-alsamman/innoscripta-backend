<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PreferencesService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

/**
 * Class PreferenceController
 * @package App\Http\Controllers
 */
class PreferenceController extends Controller
{
    /**
     * PreferenceController constructor.
     *
     * @param PreferencesService $preferencesService
     */
    public function __construct(
        private PreferencesService $preferencesService,
    ) {
    }

    /**
     * Get preferences for the authenticated user.
     *
     * @return JsonResponse
     */
    public function getUserPreference(): JsonResponse
    {
        try {
            $user = Auth::user();
            $data = $this->preferencesService->getPreferences($user);
            return response()->json(['data' => $data, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve user preferences',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Get all preferences.
     *
     * @return JsonResponse
     */
    public function getAllPreferences(): JsonResponse
    {
        try {
            $preferences = $this->preferencesService->getAllPreferences();
            return response()->json($preferences);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Save user preferences.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveUserPreference(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'categories' => 'array',
                'sources' => 'array',
                'authors' => 'array',
            ]);

            $preferences = $request->only(['categories', 'sources', 'authors']);
            $user = Auth::user();
            $this->preferencesService->saveUserPreferences($user, $preferences);

            return response()->json(['message' => 'Preferences saved successfully', 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'message' => 'Failed to save user preferences'], 422);
        }
    }
}
