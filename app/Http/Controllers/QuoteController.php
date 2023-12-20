<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Manager\QuotesManager;
use Illuminate\Cache\CacheManager;
use Illuminate\Http\Response;

final class QuoteController extends Controller
{
    private const CACHE_KEY_QUOTES = 'quotes';

    public function __construct(
        private CacheManager $cacheManager
    ) {
    }

    public function index(QuotesManager $quotesManager): Response
    {
        if (!$quotes = $this->cacheManager->get(self::CACHE_KEY_QUOTES)) {
            $quotes = $quotesManager->getQuotes(5);
            $this->cacheManager->add(self::CACHE_KEY_QUOTES, $quotes);
        }

        return new Response(
            content: $quotes,
            status: 200,
            headers: []
        );
    }

    public function refresh(): Response
    {
        $this->cacheManager->put(self::CACHE_KEY_QUOTES, null);

        return new Response(
            content: null,
            status: 201,
            headers: [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
