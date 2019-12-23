<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

interface WebhookSourceTypes
{
    public const SOURCE_SETTLEMENT = 'settlement';
    public const SOURCE_GEO_POSITION = 'geo_position';
}