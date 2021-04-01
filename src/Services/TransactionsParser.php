<?php

namespace App\Services;

use App\Model\Transaction;
use App\ValidationMap;

class TransactionsParser
{
    private string $input;

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    /**
     * @return Transaction[]
     */
    public function getTransactions(): array
    {
        $transactions = [];

        $inputTransactions = explode("\n", $this->input);

        foreach ($inputTransactions as $inputTransaction) {
            if (0 === strlen($inputTransaction))
                continue;

            $parsedTransaction = json_decode($inputTransaction, true);

            if (false === $this->isTransactionValid($parsedTransaction)) {
                throw new \Exception(sprintf('Parsed transaction %s is not valid', $inputTransaction));
            }

            $transactions[] = new Transaction($parsedTransaction['bin'], $this->roundUp($parsedTransaction['amount'], 2), $parsedTransaction['currency']);
        }

        return $transactions;
    }

    private function isTransactionValid(array $transaction): bool
    {
        foreach (ValidationMap::REQUIRED_TRANSACTION_ATTRIBUTES as $requiredAttribute) {
            if (!isset($transaction[$requiredAttribute])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Actually, I've just copied this solution from stackoverflow but anyway covered it by the tests
     */
    private function roundUp(float $value, int $precision): float
    {
        $pow = pow(10, $precision);

        return (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow;
    }
}
