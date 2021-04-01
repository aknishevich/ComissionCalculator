<?php

use App\Model\Transaction;
use App\Services\BinlistService;
use App\Services\ExchangerService;
use App\TransactionCalculator;
use App\ValidationMap;
use PHPUnit\Framework\TestCase;

class TransactionCalculatorTest extends TestCase
{
    /**
     * @dataProvider getTestData
     */
    public function testCalculate(int $bin, float $amount, string $currency): void
    {
        $transaction = new Transaction($bin, $amount, $currency);

        $calculator = new TransactionCalculator($transaction);

        $expectedResult = $this->getFixedAmount($transaction) * $this->getCommission($transaction);

        $this->assertEquals($expectedResult, $calculator->calculate());
    }

    public function getTestData(): array
    {
        return [
            [45717360, 100.00, 'EUR',],
            [516793, 50.00, 'USD',],
            [45417360, 10000.00, 'JPY',],
            [41417360, 130.00, 'USD',],
            [4745030, 2000.00, 'GBP',],
        ];
    }

    private function getFixedAmount(Transaction $transaction): float
    {
        $rates = ExchangerService::getRates();

        $currency = $transaction->getCurrency();

        if ($this->isEuroCurrency($currency) || $this->isZeroRate($rates[$currency])) {
            return $transaction->getAmount();
        }

        return $transaction->getAmount() / $rates[$currency];
    }

    private function getCommission(Transaction $transaction): float
    {
        $country = BinlistService::getCountryByBin($transaction->getBin());

        if ($this->isEuCountry($country)) {
            return 0.01;
        }

        return 0.02;
    }

    private function isEuCountry(string $country): bool
    {
        return in_array($country, ValidationMap::EU_COUNTRIES);
    }

    private function isEuroCurrency(string $currency): bool
    {
        return 'EUR' === $currency;
    }

    private function isZeroRate(float $rate)
    {
        return 0 == $rate;
    }
}
