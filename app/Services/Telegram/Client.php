<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use App\Services\Telegram\Api\BotApi;
use TelegramBot\Api\Client as TelegramClient;
use TelegramBot\Api\Events\EventCollection;

class Client extends TelegramClient
{
    /** @var BotApi */
    protected $api;

    /**
     * Client constructor
     *
     * @param string $token Telegram Bot API token
     * @param string|null $trackerToken Yandex AppMetrica application api_key
     */
    public function __construct($token, $trackerToken = null)
    {
        $this->api = new BotApi($token);
        $this->events = new EventCollection($trackerToken);
    }
}
