<?php

return [

    'NewsAPI' => [
        'URL' => env('NewsAPI_URL', 'https://newsapi.org/v2/everything?q=tesla&sortBy=publishedAt&apiKey='),
        'KEY' => env('NewsAP_KEY', 'e808980ef96b4c0da93980b9980c3bab'),
    ],

    'Mediastack' => [
        'URL' => env('Mediastack_URL', 'api.mediastack.com/v1/news?limit=40&access_key='),
        'KEY' => env('Mediastack_KEY', '8ec91a496cc7be440c0cdb601b634f83'),
    ],

    'NewYorkTimes' => [
        'URL' => env('NewYorkTimes_URL', 'https://api.nytimes.com/svc/search/v2/articlesearch.json?api-key='),
        'KEY' => env('NewYorkTimes_KEY', 'xIwnN0MI0C5GtUUDwIDJGFoGZluqbHfy'),
    ],

];

