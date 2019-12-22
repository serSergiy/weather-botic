<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

use GuzzleHttp\Client;

use Psr\Http\Message\ResponseInterface;
use Exception;
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
            'lang' => 'ua',
        ]);

        $this->appId = env('OPEN_WEATHER_APP_ID');
    }

    public function getForecastByZip(int $cityZip, string $countryCode): array
    {
        $response = $this->client->request('GET', 'forecast', [
            'query' => [
                'zip' => $cityZip,
                'country code' => $countryCode,
                'APPID' => $this->appId,
            ],
        ]);

        return $this->getResponseContent($response);
    }

    public function getForecastByCityId(int $cityId): array
    {
        $response = $this->client->request('GET', 'weather', [
            'query' => [
                'id' => $cityId,
                'APPID' => $this->appId,
            ],
        ]);

        return $this->getResponseContent($response);
    }

    public function getForecastByCityName(string $cityName): array
    {
        $response = $this->client->request('GET', 'weather', [
            'query' => [
                'q' => $cityName,
                'APPID' => $this->appId,
                'lang' => 'ua',
            ],
        ]);

        return $this->getResponseContent($response);
    }

    public function getForecastByGeoPosition(float $latitude, float $longitude): array
    {
        $response = $this->client->request('GET', 'weather', [
            'query' => [
                'lat' => $latitude,
                'lon' => $longitude,
                'APPID' => $this->appId,
            ],
        ]);

        return $this->getResponseContent($response);
    }

    private function getResponseContent(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
