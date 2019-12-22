<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

use GuzzleHttp\Client;

class OpenWeatherProvider
{
    /** @var Client */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openweathermap.org/data/2.5/'
        ]);

        http://api.openweathermap.org/data/2.5/forecast?id=524901&APPID={APIKEY}
    }

    public function getForecastByCityId()
    {
        return $this->client->request('GET', 'forecast', [
            'query' => [
                'zip' => '32811',
                'country code' => 'us',
                'APPID' => '0b336f748455bd7022fb3613ec42d5cb'
            ],
        ]);
    }


}