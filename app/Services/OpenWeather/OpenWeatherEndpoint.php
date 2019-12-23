<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

use function array_key_exists;
use function in_array;

class OpenWeatherEndpoint
{
    private const ISSUE_TYPE_MAP = [
        WebhookIssueTypes::WEATHER_CURRENT => 'weather',
        WebhookIssueTypes::FORECAST_FIVE_DAYS => 'forecast',
        WebhookIssueTypes::FORECAST_THIRTY_DAYS => 'climate/month'
    ];

    /** @var RequestPayloadHelper */
    private $requestPayloadHelper;

    /** @var OpenWeatherProvider */
    private $weatherProvider;

    public function __construct(RequestPayloadHelper $requestPayloadHelper)
    {
        $this->requestPayloadHelper = $requestPayloadHelper;
    }

    public function handle(array $payload): string
    {
        $this->requestPayloadHelper->setPayload($payload);

        $lang = $this->requestPayloadHelper->getLang();
        $lang = in_array($lang, UserLangs::LANGS) ? $lang : 'en';

        $this->weatherProvider = new OpenWeatherProvider($lang);

        $issueType = $this->requestPayloadHelper->getIssueType();
        $sourceType = $this->requestPayloadHelper->getSourceType();

        if (array_key_exists($issueType, self::ISSUE_TYPE_MAP)) {
            return ($sourceType === WebhookSourceTypes::SOURCE_SETTLEMENT)
                ? $this->handleSettlementSource(self::ISSUE_TYPE_MAP[$issueType])
                : $this->handleGeoPositionSource(self::ISSUE_TYPE_MAP[$issueType]);
        }
    }

    private function handleSettlementSource(string $issueType): string
    {
        $cityName = $this->requestPayloadHelper->getCityName();

        $response = $this->weatherProvider->getForecastByCityName($cityName, $issueType);

        return $this->format($response, $issueType);
    }

    private function handleGeoPositionSource(string $issueType): string
    {
        $longitude = $this->requestPayloadHelper->getLongitude();
        $latitude = $this->requestPayloadHelper->getLatitude();

        $response = $this->weatherProvider->getForecastByGeoPosition($latitude, $longitude, $issueType);

        return $this->format($response, $issueType);
    }

    private function format(array $response, string $issueType): string
    {
        /** @var ResponseFormatterInterface $responseFormatter */
        $responseFormatter = \App::make(self::ISSUE_TYPE_MAP[$issueType]);
        return $responseFormatter->format($response);
    }
}
