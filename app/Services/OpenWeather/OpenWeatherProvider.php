<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

use GuzzleHttp\Client;

use Psr\Http\Message\ResponseInterface;

use function json_decode;

class OpenWeatherProvider
{
    /** @var Client */
    private $client;

    /** @var string */
    private $appId;

    /** @var string */
    private $lang;

    public function __construct(string $lang = 'en')
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openweathermap.org/data/2.5/',
        ]);

        $this->appId = env('OPEN_WEATHER_APP_ID');
        $this->lang = $lang;
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

    public function getForecastByCityName(string $cityName, string $issueType): array
    {
        $response = $this->client->request('GET', $issueType, [
            'query' => [
                'q' => $cityName,
                'APPID' => $this->appId,
                'lang' => $this->lang,
            ],
        ]);

        return $this->getResponseContent($response);
    }

    public function getForecastByGeoPosition(float $latitude, float $longitude, string $issueType): array
    {
        $response = $this->client->request('GET', $issueType, [
            'query' => [
                'lat' => $latitude,
                'lon' => $longitude,
                'APPID' => $this->appId,
                'lang' => $this->lang,
            ],
        ]);

        return $this->getResponseContent($response);
    }

    private function getResponseContent(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
