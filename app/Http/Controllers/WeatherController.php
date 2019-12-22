<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\OpenWeather\OpenWeatherProvider;

class WeatherController extends Controller
{
    /** @var OpenWeatherProvider */
    private $weatherProvider;

    public function __construct(OpenWeatherProvider $weatherProvider)
    {
        $this->weatherProvider = $weatherProvider;
    }

    public function getCityForecast()
    {
        dd($this->weatherProvider->getForecastByCityId(32811, 'us'));
    }
}
