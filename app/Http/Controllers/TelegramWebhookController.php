<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\TelegramWebhookProcessor;
use Illuminate\Http\Request;

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
        $this->webhookProcessor->process($request->input());
    }
}
