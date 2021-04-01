<?php

namespace App;

use App\Model\Transaction;
use App\Services\BinlistService;
use App\Services\ExchangerService;

class TransactionCalculator
{
    private Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function calculate(): float
    {
        return $this->getFixedAmount() * $this->getCommission();
    }

    private function getFixedAmount(): float
    {
        $rates = ExchangerService::getRates();

        $currency = $this->transaction->getCurrency();

        if ($this->isEuroCurrency($currency) || $this->isZeroRate($rates[$currency])) {
            return $this->transaction->getAmount();
        }

        return $this->transaction->getAmount() / $rates[$currency];
    }

    private function getCommission(): float
    {
        $country = BinlistService::getCountryByBin($this->transaction->getBin());

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
