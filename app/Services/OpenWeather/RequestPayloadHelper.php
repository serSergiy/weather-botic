<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

use Illuminate\Support\Arr;

class RequestPayloadHelper
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

    public function getIssueType(): string
    {
        return Arr::get($this->payload, 'message.issue_type');
    }

    public function getSourceType(): string
    {
        return Arr::get($this->payload, 'message.source_type');
    }

    public function getCityName(): string
    {
        return Arr::get($this->payload, 'message.message.city');
    }

    public function getLatitude(): float
    {
        return Arr::get($this->payload, 'message.message.lat');
    }

    public function getLongitude(): float
    {
        return Arr::get($this->payload, 'message.message.lon');
    }

    public function getLang(): string
    {
        return Arr::get($this->payload, 'message.from.language_code');
    }
}