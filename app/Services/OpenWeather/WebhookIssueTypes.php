<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

interface WebhookIssueTypes
{
    public const WEATHER_CURRENT = 'current';
    public const FORECAST_FIVE_DAYS = 'five_days';
    public const FORECAST_THIRTY_DAYS = 'thirty_days';
}