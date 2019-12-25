<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

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
        $humidity = $this->responsePayloadHelper->getHumidity();
        $windSpeed = $this->responsePayloadHelper->getWindSpeed();
        $windDeg = $this->responsePayloadHelper->getWindDeg();
        $pressure = $this->responsePayloadHelper->getPressure();
        $sunrise = date('H:i:s', $this->responsePayloadHelper->getSunrise());
        $sunset = date('H:i:s', $this->responsePayloadHelper->getSunset());

        return 'The weather right now ' . self::MAP[$descr] . " (${descr})" . PHP_EOL . PHP_EOL
            . 'temperature ' . WeatherEmojies::TEMPERATURE . ': ' . $temp . 'C°, '
            . 'humidity ' . WeatherEmojies::HUMIDITY . ': ' . $humidity . '%' . PHP_EOL
            . 'wind: ' . WeatherEmojies::WIND . ': '. $windSpeed . ', ' . $windDeg . PHP_EOL
            . 'pressure ' . WeatherEmojies::PRESSURE . ': '. $pressure . 'inches' . PHP_EOL . PHP_EOL
            . 'Min and Max for today: ' . $minTemp . 'C°' . WeatherEmojies::MIN_TEMPERATURE
            . ' ' . $maxTemp . 'C°' . WeatherEmojies::MAX_TEMPERATURE . PHP_EOL . PHP_EOL
            . 'Sunrise at ' . $sunrise . ' ' . WeatherEmojies::SUNRISE . PHP_EOL
            . 'Sunset at ' . $sunset . ' ' . WeatherEmojies::SUNSET;
    }
}
