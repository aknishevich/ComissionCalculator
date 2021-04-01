<?php

namespace App\Services;

class BinlistService
{
    protected const API_URL = 'https://lookup.binlist.net/%s';

    public static function getCountryByBin(int $bin): string
    {
        /**
         * I had to add this hack to not use real API during the tests running as it returns errors after several requests
         * In a Symfony it's much simpler to do it by mocking service through the configs... One more thing I Love Symfony for <3
         */
        if (defined('ENV') && ENV === 'test')
        {
            return 'country name';
        }

        $requestUrl = sprintf(static::API_URL, $bin);
        $response = @file_get_contents($requestUrl);
        $binInfo = json_decode($response, true);

        if (!isset($binInfo['country']['alpha2'])) {
            throw new \Exception(sprintf('Bad response from %s', $requestUrl));
        }

        return $binInfo['country']['alpha2'];
    }
}
