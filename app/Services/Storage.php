<?php

declare(strict_types=1);

namespace App\Services;

class Storage
{
    public const STORAGE_DIR = '/data/';

    public function store(string $chatId, array $data): void
    {
        file_put_contents(base_path() . self::STORAGE_DIR . $chatId . '.json', json_encode($data));
    }

    public function get(string $chatId): array
    {
        $fileName = base_path() . self::STORAGE_DIR . $chatId . '.json';
        if (is_file($fileName)){
            return json_decode(file_get_contents(base_path() . self::STORAGE_DIR . $chatId . '.json'), true);
        }
        return [];
    }

    public function getLastCommand(string $chatId): string
    {
        $fileName = base_path() . self::STORAGE_DIR . $chatId . '.json';
        if (is_file($fileName)){
            $data = json_decode(file_get_contents(base_path() . self::STORAGE_DIR . $chatId . '.json'), true);
            return $data['last_command'] ?? '';
        }
        return '';
    }
}
