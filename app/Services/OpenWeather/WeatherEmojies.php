<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

interface WeatherEmojies
{
    public const NOTIFICATION = ':sound';
//    public const TEMPERATURE = ':thermometer';
    public const TEMPERATURE = "\xf0\x9f\x8c\xa1";

    public const HUMIDITY = ':droplet';
    public const WIND = ':wind_blowing_face';
    public const PRESSURE = ':small_red_triangle_down';
    public const MIN_TEMPERATURE = ':arrow_down';
    public const MAX_TEMPERATURE = ':arrow_up';
    public const SUNSET = ':sunrise_over_mountains';
    public const SUNRISE = ':sunrise';
    public const FOG = ':fog';
    public const CLOUDS = ':cloud';
    public const CLEAR = ':sun_with_face';
    public const RAIN = ':umbrella_with_rain_drops';
    public const SNOW = 'snowflake';
}
