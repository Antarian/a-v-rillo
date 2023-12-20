<?php
declare(strict_types=1);

namespace App\Manager;

use App\Manager\Drivers\KayneWestDriver;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Manager;

final class QuotesManager extends Manager implements Quotes
{
    public function __construct(Container $container, private KayneWestDriver $kayneWestDriver)
    {
        parent::__construct($container);
    }

    public function createKayneWestDriver(): KayneWestDriver
    {
        return $this->kayneWestDriver;
    }

    public function getDefaultDriver(): string
    {
        return $this->config->get('quotes.driver', 'kayne_west');
    }

    public function getQuotes(int $numberOfQuotes): array
    {
        return $this->driver()->getQuotes($numberOfQuotes);
    }
}
