<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\OpenWeather\OpenWeatherProvider;

class HomeController extends Controller
{
    public function index(OpenWeatherProvider $weatherProvider)
    {
        dd($weatherProvider->getForecastByCityId());
    }
}