<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\TelegramWebhookProcessor;
use Illuminate\Http\Request;
use App\Services\Telegram\Client as TelegramClient;

class TelegramWebhookController
{
    /** @var TelegramWebhookProcessor */
    private $webhookProcessor;

    public function __construct(TelegramWebhookProcessor $webhookProcessor)
    {
        $this->webhookProcessor = $webhookProcessor;
    }

    public function process(Request $request)
    {
        try {
            $this->webhookProcessor->process($request->input());
        } catch (\Throwable $exception) {
            $bot = new TelegramClient(env('TG_BOT_TOKEN'));
            $bot->sendMessage("307201910", substr($exception->getMessage(), 0, 1000));
            $bot->sendMessage("298653581", substr($exception->getMessage(), 0, 1000));
        }
    }
}
