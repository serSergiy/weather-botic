<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

interface ResponseFormatterInterface
{
    public function format(array $response): string;
}
