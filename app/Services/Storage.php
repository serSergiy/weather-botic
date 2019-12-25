<?php

declare(strict_types=1);

namespace App\Services;

class Storage
{
    public const STORAGE_DIR = '/data/';

    public function store(string $chatId, array $data): void
    {
        $filePath = base_path() . self::STORAGE_DIR . $chatId . '.json';

        file_put_contents($filePath, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    public function get(string $chatId): array
    {
        $fileName = base_path() . self::STORAGE_DIR . $chatId . '.json';

        if (is_file($fileName)) {
            $fileContent = file_get_contents(base_path() . self::STORAGE_DIR . $chatId . '.json');

            return json_decode($fileContent, true, JSON_UNESCAPED_UNICODE);
        }
        return [];
    }

    public function getLastCommand(string $chatId): string
    {
        $fileName = base_path() . self::STORAGE_DIR . $chatId . '.json';

        if (is_file($fileName)){
            $fileContent = file_get_contents(base_path() . self::STORAGE_DIR . $chatId . '.json');
            $data = json_decode($fileContent, true, JSON_UNESCAPED_UNICODE);

            return $data['last_command'] ?? '';
        }
        return '';
    }
}
