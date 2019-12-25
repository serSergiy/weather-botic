<?php

declare(strict_types=1);

namespace App\Entities;

class CommandResponse
{
    private $chatId;

    private $text;

    /**
     * CommandResponse constructor.
     * @param $chatId
     * @param $text
     */
    public function __construct(string $chatId, string $text)
    {
        $this->chatId = $chatId;
        $this->text = $text;
    }

    public function getChatId(): string
    {
        return $this->chatId;
    }

    /**
     * @return mixed
     */
    public function getText(): string
    {
        return $this->text;
    }
}
