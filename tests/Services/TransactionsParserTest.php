<?php

namespace Services;

use App\Model\Transaction;
use App\Services\TransactionsParser;
use PHPUnit\Framework\TestCase;

class TransactionsParserTest extends TestCase
{
    private const VALID_INPUT = '{"bin":"21231","amount":"100.00","currency":"EUR"}';

    private const INVALID_INPUT = '{"bin":"21231","ount":"100.00","currency":"EUR"}';

    public function testGetTransactions(): void
    {
        $parser = new TransactionsParser(self::VALID_INPUT);

        $transactionsList = $parser->getTransactions();

        $this->assertNotEmpty($transactionsList);
        $this->assertInstanceOf(Transaction::class, reset($transactionsList));
    }

    public function testExceptionOnGetTransactions(): void
    {
        $parser = new TransactionsParser(self::INVALID_INPUT);

        $this->expectException(\Exception::class);

        $parser->getTransactions();
    }

    public function testEmptyArrayOnGetTransactionsWithEmptyInput(): void
    {
        $parser = new TransactionsParser('');

        $this->assertEquals(
            [],
            $parser->getTransactions()
        );
    }

    /**
     * @dataProvider getRoundUpTestData
     */
    public function testRoundUp(float $number, int $numberOfDigits, float $expectedResult): void
    {
        $parser = new TransactionsParser('');

        $reflection = new \ReflectionClass($parser);
        $testMethod = $reflection->getMethod('roundUp');
        $testMethod->setAccessible(true);

        $methodResult = $testMethod->invoke($parser, $number, $numberOfDigits);

        $this->assertEquals($expectedResult, $methodResult);
    }

    public function getRoundUpTestData(): array
    {
        return [
            [
                0.46180, 2, 0.47,
            ],
            [
                3.41270, 3, 3.413,
            ],
            [
                3.41201, 3, 3.413,
            ],
            [
                3.41200, 3, 3.412,
            ],
        ];
    }
}
