<?php

declare(strict_types=1);

namespace App\Services\Telegram\Api;

use TelegramBot\Api\BotApi as TelegramBotApi;

class BotApi extends TelegramBotApi
{
    protected $customCurlOptions = [
        CURLOPT_SSL_VERIFYPEER => false
    ];
}
