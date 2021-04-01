<?php

namespace Model;

use App\Model\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testModelProperties()
    {
        $bin = 45717360;
        $amount = 100.00;
        $currency = 'EUR';
        $transaction = new Transaction($bin, $amount, $currency);

        $this->assertEquals($bin, $transaction->getBin());
        $this->assertEquals($amount, $transaction->getAmount());
        $this->assertEquals($currency, $transaction->getCurrency());
    }
}
