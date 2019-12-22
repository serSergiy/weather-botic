<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

use GuzzleHttp\Client;

use function json_decode;

class OpenWeatherProvider
{
    /** @var Client */
    private $client;

    /** @var string */
    private $appId;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openweathermap.org/data/2.5/',
        ]);

        $this->appId = env('OPEN_WEATHER_APP_ID');
    }

    public function getForecastByCityId(int $cityZip, string $countryCode)
    {
        $response = $this->client->request('GET', 'forecast', [
            'query' => [
                'zip' => $cityZip,
                'country code' => $countryCode,
                'APPID' => $this->appId,
            ],
        ]);

        $response = json_decode($response->getBody()->getContents(), true);

        return $response;
    }
}
