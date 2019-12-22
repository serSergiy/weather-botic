<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

use GuzzleHttp\Client;

use function json_decode;

class OpenWeatherProvider
{
    /** @var Client */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openweathermap.org/data/2.5/',
            'APPID' => '0b336f748455bd7022fb3613ec42d5cb',
        ]);
    }

    public function getForecastByCityId(int $cityZip, string $countryCode)
    {
        $response = $this->client->request('GET', 'forecast', [
            'query' => [
                'zip' => $cityZip,
                'country code' => $countryCode,
                'APPID' => '0b336f748455bd7022fb3613ec42d5cb'
            ],
        ]);

        $response = json_decode($response->getBody()->getContents(), true);

        return $response;
    }


}