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

    private const ISSUE_FORMATTERS_MAP = [
        WebhookIssueTypes::WEATHER_CURRENT => OpenWeatherCurrentResponseFormatter::class,
        WebhookIssueTypes::FORECAST_FIVE_DAYS => OpenWeatherFiveDaysResponseFormatter::class,
        WebhookIssueTypes::FORECAST_THIRTY_DAYS => OpenWeatherThirtyDaysResponseFormatter::class
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
            $source = ($sourceType === WebhookSourceTypes::SOURCE_SETTLEMENT)
                ? $this->handleSettlementSource(self::ISSUE_TYPE_MAP[$issueType])
                : $this->handleGeoPositionSource(self::ISSUE_TYPE_MAP[$issueType]);

            return $this->format($source, $issueType);
        }

        return "Sorry, invalid";
    }

    private function handleSettlementSource(string $issueType): array
    {
        $cityName = $this->requestPayloadHelper->getCityName();

        return $this->weatherProvider->getForecastByCityName($cityName, $issueType);
    }

    private function handleGeoPositionSource(string $issueType): array
    {
        $longitude = $this->requestPayloadHelper->getLongitude();
        $latitude = $this->requestPayloadHelper->getLatitude();

        return $this->weatherProvider->getForecastByGeoPosition($latitude, $longitude, $issueType);
    }

    private function format(array $response, string $issueType): string
    {
        /** @var ResponseFormatterInterface $responseFormatter */
        $responseFormatter = \App::make(self::ISSUE_FORMATTERS_MAP[$issueType]);
        return $responseFormatter->format($response);
    }
}
