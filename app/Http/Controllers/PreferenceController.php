<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\PreferencesService;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{

    public function __construct(
        private PreferencesService $preferencesService,
    ) {
    }

    public function getUserPreference()
    {
        try {
            $user = Auth::user();
            $data = $this->preferencesService->getPreferences($user);
            return response()->json(['data' => $data, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false, 'message' => 'User Preferences failed', 'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAllPreferences()
    {
        try {
            $preferences = $this->preferencesService->getAllPreferences();
            return response()->json($preferences);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function saveUserPreference(Request $request)
    {
        try {
            $request->validate([
                'categories' => 'array',
                'sources' => 'array',
                'authors' => 'array',
            ]);

            $preferences = $request->only(['categories', 'sources', 'authors']);
            $user= Auth::user();
            $this->preferencesService->saveUserPreferences($user ,$preferences);

            return response()->json(['message' => 'Preferences saved successfully', 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(),'message' => 'User Preferences failed to save',], 500);
        }
    }
}
