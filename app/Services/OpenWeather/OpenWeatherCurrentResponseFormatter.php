<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

use function str_repeat;
use function implode;

class OpenWeatherCurrentResponseFormatter implements ResponseFormatterInterface
{
    private const MAP = [
        'Fog' => WeatherEmojies::FOG,
        'Clouds' => WeatherEmojies::CLOUDS,
        'Clear' => WeatherEmojies::CLEAR,
        'Rain' => WeatherEmojies::RAIN,
        'Snow' => WeatherEmojies::SNOW,
        'Mist' => WeatherEmojies::MIST,
    ];

    /** @var ResponsePayloadHelper */
    private $responsePayloadHelper;

    public function __construct(ResponsePayloadHelper $responsePayloadHelper)
    {
        $this->responsePayloadHelper = $responsePayloadHelper;
    }

    public function format(array $response): string
    {
        $this->responsePayloadHelper->setPayload($response);

        $temp = $this->responsePayloadHelper->getTemp();
        $minTemp = $this->responsePayloadHelper->getMinTemp();
        $maxTemp = $this->responsePayloadHelper->getMaxTemp();

        $descriptions = collect($this->responsePayloadHelper->getWeather())->pluck('main')->toArray();
        $expandedDescriptions =
            collect($this->responsePayloadHelper->getWeather())->pluck('description')->toArray();

        $humidity = $this->responsePayloadHelper->getHumidity();
        $windSpeed = $this->responsePayloadHelper->getWindSpeed();
        $windDeg = $this->responsePayloadHelper->getWindDeg();
        $pressure = $this->responsePayloadHelper->getPressure();
        $sunrise = date('H:i:s', $this->responsePayloadHelper->getSunrise());
        $sunset = date('H:i:s', $this->responsePayloadHelper->getSunset());

        $header = 'The weather right now: ' . implode(' & ', $expandedDescriptions) . ' ' .
            implode(
                ' ',
                collect($descriptions)->map(function ($description) {
                    return self::MAP[$description];
                })->toArray());

        return $header . ' ' . PHP_EOL . PHP_EOL
            . 'Temperature ' . WeatherEmojies::TEMPERATURE . ': ' . $temp . ' C°' . PHP_EOL
            . $this->itemName('Humidity', WeatherEmojies::HUMIDITY) . $humidity . '%' . PHP_EOL
            . $this->itemName('Wind', WeatherEmojies::WIND) . $windSpeed . ' km/h, '
            . $this->calcWindDirection($windDeg) . PHP_EOL
            . $this->itemName('Pressure', WeatherEmojies::PRESSURE)
            . $pressure . ' millibars' . PHP_EOL . PHP_EOL
            . $this->itemName('Minimum', WeatherEmojies::TEMPERATURE) . $minTemp . ' C°' . PHP_EOL
            . $this->itemName('Maximum', WeatherEmojies::TEMPERATURE) . $maxTemp . ' C°' . PHP_EOL . PHP_EOL
            . WeatherEmojies::SUNRISE . ' ' . $this->itemName('Sunrise at') . $sunrise . PHP_EOL
            . WeatherEmojies::SUNSET . ' ' . $this->itemName('Sunset at') . $sunset;
    }

    private function itemName(string $item, string $emoji = null): string
    {
        $spacesDiff = strlen('Temperature ') - (strlen($item));
        return $item . ' ' . $emoji . ':' . str_repeat(' ', $spacesDiff);
    }

    private function calcWindDirection(float $degrees)
    {
        $directions = [
            'N' . ' ' . WeatherEmojies::NORTH,
            'NNE' . ' ' . WeatherEmojies::NORTH_EAST,
            'NE' . ' ' . WeatherEmojies::NORTH_EAST,
            'ENE' . ' ' . WeatherEmojies::NORTH_EAST,
            'E' . ' ' . WeatherEmojies::EAST,
            'ESE' . ' ' . WeatherEmojies::SOUTH_EAST,
            'SE' . ' ' . WeatherEmojies::SOUTH_EAST,
            'SSE' . ' ' . WeatherEmojies::SOUTH_EAST,
            'S' . ' ' . WeatherEmojies::SOUTH,
            'SSW' . ' ' . WeatherEmojies::SOUTH_WEST,
            'SW' . ' ' . WeatherEmojies::SOUTH_WEST,
            'WSW' . ' ' . WeatherEmojies::SOUTH_WEST,
            'W' . ' ' . WeatherEmojies::WEST,
            'WNW' . ' ' . WeatherEmojies::NORTH_WEST,
            'NW' . ' ' . WeatherEmojies::NORTH_WEST,
            'NNW' . ' ' . WeatherEmojies::NORTH_WEST,
            'N2'
        ];

        $cardinal = $directions[(int)round($degrees / 22.5)];
        if ($cardinal == 'N2') {
            $cardinal = 'N';
        }

        return $cardinal;
    }
}
