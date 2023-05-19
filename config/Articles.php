<?php

return [

    'NewsAPI' => [
        'URL' => env('NewsAPI_URL', 'https://newsapi.org/v2/everything?q=tesla&sortBy=publishedAt&apiKey='),
        'KEY' => env('NewsAP_KEY', 'e808980ef96b4c0da93980b9980c3bab'),
    ],

    'NewsCatcherApi' => [
        'URL' => env('NewsCatcherApi_URL', 'https://api.newscatcherapi.com/v2/latest_headlines?countries=US'),
        'KEY' => env('NewsCatcherApi_KEY', 'cd_u19izl2VHL1e4Gk7t2LsFH5v5DaLuPrPbiFLYbCY'),
    ],

    'NewYorkTimes' => [
        'URL' => env('NewYorkTimes_URL', 'https://api.nytimes.com/svc/search/v2/articlesearch.json?api-key='),
        'KEY' => env('NewYorkTimes_KEY', 'xIwnN0MI0C5GtUUDwIDJGFoGZluqbHfy'),
    ],

];
