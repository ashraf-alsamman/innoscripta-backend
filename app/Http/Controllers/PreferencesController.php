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
class PreferencesController extends Controller
{

    public function __construct(private PreferencesService $preferencesService)
    {
    }

    public function getAllPreferences():JsonResponse
    {
        try {
            $preference = $this->preferencesService->getAllPreferences();
            return response()->json($preference);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get All preference.'], 500);
        }
    }


    public function getUserPreference():JsonResponse
    {
        try {
            $userId = Auth::user()->id;
            $preference = $this->preferencesService->getUserPreference($userId);

            return response()->json($preference);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get user preference.'], 422);
        }
    }


    public function updateUserPreference(Request $request):JsonResponse
    {
        try {
            $userId = Auth::user()->id;
            $preferenceData = $request->only(['categories', 'sources', 'authors']);

            $preference = $this->preferencesService->updateUserPreference($userId, $preferenceData);

            return response()->json($preference);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update user preference.'], 422);
        }
    }
}
