<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

interface WeatherEmojies
{
    public const NOTIFICATION = "\xf0\x9f\x94\x89";

    public const TEMPERATURE = "\xf0\x9f\x8c\xa1";
    public const HUMIDITY = "\xf0\x9f\x92\xa7";
    public const WIND = "\xf0\x9f\x8c\xac";
    public const PRESSURE = "\xf0\x9f\x94\xbb";
    public const SUNSET = "\xF0\x9F\x8C\x84";
    public const SUNRISE = "\xF0\x9F\x8C\x85";

    public const FOG = "\xf0\x9f\x8c\xab";
    public const MIST = "\xf0\x9f\x8c\xab";
    public const CLOUDS = "\xE2\x98\x81";
    public const CLEAR = "\xF0\x9F\x8C\x9E";
    public const RAIN = "\xf0\x9f\x8c\xa7";
    public const SNOW = "\xf0\x9f\x8c\xa8";

    public const NORTH = "\xE2\xAC\x86";
    public const SOUTH = "\xE2\xAC\x87";
    public const WEST = "\xE2\xAC\x85";
    public const EAST = "\xE2\x9E\xA1";
    public const NORTH_EAST = "\xE2\x86\x97";
    public const SOUTH_EAST = "\xE2\x86\x98";
    public const SOUTH_WEST = "\xE2\x86\x99";
    public const NORTH_WEST = "\xE2\x86\x96";
}
