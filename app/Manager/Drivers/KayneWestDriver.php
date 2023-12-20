<?php
declare(strict_types=1);

namespace App\Manager\Drivers;

use App\Manager\Quotes;
use Illuminate\Http\Client\PendingRequest;
use RuntimeException;

final class KayneWestDriver implements Quotes
{
    public function __construct(
        private PendingRequest $client,
    ) {
    }

    public function getQuotes(int $numberOfQuotes): array
    {
        $quotes = [];
        $counter = 0;
        while (count($quotes) < $numberOfQuotes) {
            $quotes[] = $this->getQuote();

            if ($numberOfQuotes * 5 < $counter) {
                throw new RuntimeException(sprintf('Unable to get %d of unique quotes.', $numberOfQuotes));
            }

            $quotes = array_unique($quotes);
            $counter++;
        }

        return $quotes;
    }

    private function getQuote(): string
    {
        $response = $this->client->get('');

        return $response->json('quote');
    }
}
