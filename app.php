<?php

require __DIR__.'/vendor/autoload.php';

use App\TransactionCalculator;
use App\Services\TransactionsParser;

try {
    $input = file_get_contents($argv[1]);

    $transactionsList = (new TransactionsParser($input))->getTransactions();

    foreach ($transactionsList as $transaction) {
        $transactionCalculator = new TransactionCalculator($transaction);

        print $transactionCalculator->calculate() . "\n";
    }
}
catch (Error $error)
{
    print "Something went wrong. For detailed information you need to check logs.\n";
}
catch (Exception $exception)
{
    print sprintf("Log: %s\n", $exception->getMessage());
}
