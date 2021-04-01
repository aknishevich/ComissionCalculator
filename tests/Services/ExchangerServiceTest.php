<?php

namespace Services;

use App\Services\ExchangerService;
use PHPUnit\Framework\TestCase;

class ExchangerServiceTest extends TestCase
{
    public function testGetRates(): void
    {
        $this->assertNotEmpty(ExchangerService::getRates());
    }
}
