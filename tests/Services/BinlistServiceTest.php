<?php

namespace Services;

use App\Services\BinlistService;
use PHPUnit\Framework\TestCase;

class BinlistServiceTest extends TestCase
{
    private const VALID_TEST_BIN = 45717360;

    public function testGetCountryByBin(): void
    {
        $country = BinlistService::getCountryByBin(self::VALID_TEST_BIN);
        $this->assertNotEmpty($country);
    }
}
