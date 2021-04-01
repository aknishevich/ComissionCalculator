<?php

namespace App\Services;

class ExchangerService
{
    protected const API_URL = 'https://api.exchangeratesapi.io/latest';

    protected static array $rates = [];

    public static function getRates(): array
    {
        if (empty(self::$rates)) {
            $response = @file_get_contents(self::API_URL);

            static::$rates = json_decode($response, true)['rates'];
        }

        return static::$rates;
    }
}
