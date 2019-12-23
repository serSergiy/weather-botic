<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

use Illuminate\Support\Arr;

class ResponsePayloadHelper
{
    /**
     * @var array
     */
    private $payload;

    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getTemp(): float
    {
        return Arr::get($this->payload, 'main.temp');
    }

    public function getDescr(): string
    {
        return Arr::get($this->payload, 'weather.main');
    }

    public function getPressure(): float
    {
        return Arr::get($this->payload, 'main.pressure');
    }

    public function getHumidity(): int
    {
        return Arr::get($this->payload, 'main.humidity');
    }

    public function getWindSpeed(): float
    {
        return Arr::get($this->payload, 'wind.speed');
    }

    public function getWindDeg(): float
    {
        return Arr::get($this->payload, 'wind.deg');
    }

    public function getSunrise(): int
    {
        return Arr::get($this->payload, 'sys.sunrise');
    }

    public function getSunset(): int
    {
        return Arr::get($this->payload, 'sys.sunset');
    }

    public function getMinTemp(): float
    {
        return Arr::get($this->payload, 'main.temp_min');
    }

    public function getMaxTemp(): float
    {
        return Arr::get($this->payload, 'main.temp_max');
    }
}
