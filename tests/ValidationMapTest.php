<?php

use App\ValidationMap;
use PHPUnit\Framework\TestCase;

class ValidationMapTest extends TestCase
{
    public function testRequiredTransactionAttributes(): void
    {
        $this->assertEquals(['bin', 'amount', 'currency'], ValidationMap::REQUIRED_TRANSACTION_ATTRIBUTES);
    }

    public function testEuCountries(): void
    {
        $this->assertEquals(
            [
                'AT',
                'BE',
                'BG',
                'CY',
                'CZ',
                'DE',
                'DK',
                'EE',
                'ES',
                'FI',
                'FR',
                'GR',
                'HR',
                'HU',
                'IE',
                'IT',
                'LT',
                'LU',
                'LV',
                'MT',
                'NL',
                'PO',
                'PT',
                'RO',
                'SE',
                'SI',
                'SK',
            ],
            ValidationMap::EU_COUNTRIES
        );
    }
}
