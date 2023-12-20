<?php

namespace Tests\Unit;

use App\Manager\Drivers\KayneWestDriver;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class KayneWestDriverTest extends TestCase
{
    private KayneWestDriver $driver;

    protected function setUp(): void
    {
        $returnValues = ['quote1', 'quote2', 'quote3', 'quote4', 'quote5', 'quote6'];
        $response = $this->createMock(Response::class);
        $response->method('json')->willReturnCallback(
            function () use (&$returnValues) {
                if (count($returnValues) > 1) {
                    return array_shift($returnValues);
                } else {
                    return reset($returnValues);
                }
            }
        );

        $pendingRequest = $this->createMock(PendingRequest::class);
        $pendingRequest->method('get')->willReturn(
            $response
        );
        $this->driver = new KayneWestDriver($pendingRequest);
    }

    public function test_get_five_quotes(): void
    {
        $this->assertSame(
            expected: ['quote1', 'quote2','quote3','quote4','quote5'],
            actual: $this->driver->getQuotes(5),
        );
    }

    public function test_get_one_quote(): void
    {
        $this->assertSame(
            expected: ['quote1'],
            actual: $this->driver->getQuotes(1),
        );
    }

    public function test_get_infinite_quotes(): void
    {
        $this->expectException(RuntimeException::class);
        $this->driver->getQuotes(8);
    }
}
