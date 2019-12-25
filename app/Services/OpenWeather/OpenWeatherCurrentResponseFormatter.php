<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

use function str_repeat;

class OpenWeatherCurrentResponseFormatter implements ResponseFormatterInterface
{
    private const MAP = [
        'Fog' => WeatherEmojies::FOG,
        'Clouds' => WeatherEmojies::CLOUDS,
        'Clear' => WeatherEmojies::CLEAR,
        'Rain' => WeatherEmojies::RAIN,
        'Snow' => WeatherEmojies::SNOW
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

        $descr = $this->responsePayloadHelper->getDescr() ?? 'Clear';
        $expandedDescr = $this->responsePayloadHelper->getExpandedDescr();
        $humidity = $this->responsePayloadHelper->getHumidity();
        $windSpeed = $this->responsePayloadHelper->getWindSpeed();
        $windDeg = $this->responsePayloadHelper->getWindDeg();
        $pressure = $this->responsePayloadHelper->getPressure();
        $sunrise = date('H:i:s', $this->responsePayloadHelper->getSunrise());
        $sunset = date('H:i:s', $this->responsePayloadHelper->getSunset());

        return 'The weather right now: ' . "$expandedDescr " . self::MAP[$descr] . PHP_EOL . PHP_EOL
            . 'Temperature ' . WeatherEmojies::TEMPERATURE . ': ' . $temp . ' C°' . PHP_EOL
            . $this->itemName('Humidity') . WeatherEmojies::HUMIDITY . ': ' . $humidity . '%' . PHP_EOL
            . $this->itemName('Wind') . WeatherEmojies::WIND . ': ' . $windSpeed . ' mph, ' . $windDeg . PHP_EOL
            . $this->itemName('Pressure') . WeatherEmojies::PRESSURE . ': ' . $pressure . ' inches' . PHP_EOL . PHP_EOL
            . 'Min and Max for today: ' . $minTemp . ' C°' . WeatherEmojies::MIN_TEMPERATURE
            . ' ' . $maxTemp . ' C°' . WeatherEmojies::MAX_TEMPERATURE . PHP_EOL . PHP_EOL
            . $this->itemName('Sunrise at') . $sunrise . ' ' . WeatherEmojies::SUNRISE . PHP_EOL
            . $this->itemName('Sunset at') . $sunset . ' ' . WeatherEmojies::SUNSET;
    }

    private function itemName(string $item): string
    {
        $spacesDiff = strlen('Temperature ') - strlen($item);
        return $item . str_repeat(' ', $spacesDiff);
    }
}
