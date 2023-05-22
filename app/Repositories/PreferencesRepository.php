<?php

namespace App\Repositories;
use App\Models\Preference;
use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class PreferencesRepository
{
    public function __construct(protected Preference $preference)
    {
    }

    public function getAllPreferences():array
    {
        $categories = Article::distinct('category')->pluck('category')->take(100);
        $authors = Article::distinct('author')->pluck('author')->take(100);
        $sources = Article::distinct('source')->pluck('source')->take(100);

        return [
            'categories' => $categories,
            'authors' => $authors,
            'sources' => $sources,
        ];
    }

    public function getUserPreference($userId):Preference|null
    {
        return $this->preference->where('user_id',$userId)->first();
    }

    public function updateUserPreference($userId, $preferenceData):Preference
    {
        $preference = $this->getUserPreference($userId);

        if (!$preference) {
            $preference = new Preference(['user_id' => $userId]);
        }

        $preference->fill($preferenceData);
        $preference->save();

        return $preference;
    }
}
