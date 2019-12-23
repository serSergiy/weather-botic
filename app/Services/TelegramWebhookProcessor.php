<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\CommandResponse;
use App\Services\OpenWeather\OpenWeatherEndpoint;
use App\Services\OpenWeather\WebhookIssueTypes;
use App\Services\OpenWeather\WebhookSourceTypes;
use TelegramBot\Api\Client as TelegramClient;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\Update;

class TelegramWebhookProcessor
{
    public const COMMANDS = [
        '/set_city' => 'setCity',
        '/set_location' => 'setLocation',
        '/get_weather' => 'getWeather',
        '/get_weather_now' => 'getWeatherNow',
        '/get_weather_5' => 'getWeatherForFiveDays',
        '/get_weather_30' => 'getWeatherForMonth'
    ];

    public const CITY_KEY = 'city';
    public const LATITUDE_KEY = 'lan';
    public const LONGITUDE_KEY = 'lon';

    /** @var Storage */
    private $storage;

    /** @var OpenWeatherEndpoint */
    private $openWeather;

    public function __construct(OpenWeatherEndpoint $openWeather, Storage $storage)
    {
        $this->storage = $storage;
        $this->openWeather = $openWeather;
    }

    public function process(array $input)
    {
        $bot = new TelegramClient(env('TG_BOT_TOKEN'));
        $update = Update::fromResponse($input);
        $message = $update->getMessage();

        $response = $this->processCommands($message);

        $bot->sendMessage($response->getChatId(), $response->getText());
    }

    private function processCommands(Message $message): CommandResponse
    {
        $messageText = $message->getText();
        $chatId = (string)$message->getChat()->getId();

        if (!empty($messageText)) {
            $exploded = explode(' ', $messageText, 2);
            $command = $exploded[0];
            $argument = $exploded[1] ?? '';

            if (array_key_exists($command, self::COMMANDS)) {
                return $this->execCommand($message, $chatId, $command, $argument);
            } else {
                $command = $this->storage->getLastCommand($chatId);
                return $this->execCommand($message, $chatId, $command, $messageText);
            }
        }

        return new CommandResponse($chatId, 'Thanks ;)');
    }

    private function execCommand(Message $message, string $chatId, string $command, string $argument): CommandResponse
    {
        return $this->{self::COMMANDS[$command]}($message, $chatId, $command, $argument);
    }

    private function setCity(Message $message, string $chatId, string $command, string $argument): CommandResponse
    {
        $stored = $this->storage->get($chatId);

        $stored['source_type'] = 'city';
        $stored['last_command'] = $command;

        if (!empty($argument)) {
            $stored['location_data']['city'] = $argument;
            $this->storage->store($chatId, $stored);
            return new CommandResponse($chatId, "Your city stored.");
        } else {
            $this->storage->store($chatId, $stored);
            return new CommandResponse($chatId, "Please, enter your city:");
        }
    }

    private function setLocation(Message $message, string $chatId, string $command, string $argument): CommandResponse
    {
        return new CommandResponse('', '');
    }

    private function getWeather(Message $message, string $chatId, string $command, string $argument): CommandResponse
    {
        return new CommandResponse('', '');
    }

    private function getWeatherNow(Message $message, string $chatId, string $command, string $argument): CommandResponse
    {
        $stored = $this->storage->get($chatId);

        $message = $this->openWeather->handle([
            'message' => [
                'from' => ['language_code' => $message->getFrom()->getLanguageCode()],
                'issue_type' => WebhookIssueTypes::WEATHER_CURRENT,
                'source_type' => WebhookSourceTypes::SOURCE_SETTLEMENT,
                'message' => [
                    'city' => $stored['city']
                ]
            ]
        ]);

        return new CommandResponse($chatId, $message);
    }

    private function getWeatherForFiveDays(Message $message, string $chatId, string $command, string $argument): CommandResponse
    {
        return new CommandResponse('', '');
    }

    private function getWeatherForMonth(Message $message, string $chatId, string $command, string $argument): CommandResponse
    {
        return new CommandResponse('', '');
    }
}
