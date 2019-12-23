<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

class OpenWeatherFiveDaysResponseFormatterInterface implements ResponseFormatterInterface
{
    public function format(array $response): string
    {
        // TODO: Implement format() method.
    }
}
