<?php
namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class QuoteControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();

        Http::fakeSequence('http://0.0.0.0')
            ->push(['quote' => 'quote1'], 200)
            ->push(['quote' => 'quote2'], 200)
            ->push(['quote' => 'quote3'], 200)
            ->push(['quote' => 'quote4'], 200)
            ->push(['quote' => 'quote5'], 200)

            ->push(['quote' => 'quote6'], 200)
            ->push(['quote' => 'quote7'], 200)
            ->push(['quote' => 'quote8'], 200)
            ->push(['quote' => 'quote9'], 200)
            ->push(['quote' => 'quote10'], 200)
        ;
    }

    public function test_get_quotes(): void
    {
        $response = $this->get('/api/quotes?apiKey=test_key');

        $response->assertStatus(200);
        $response->assertJson([
            'quote1', 'quote2', 'quote3', 'quote4', 'quote5',
        ]);
    }

    public function test_quotes_are_cached(): void
    {
        $response = $this->get('/api/quotes?apiKey=test_key');
        $response->assertStatus(200);
        $response->assertJson([
            'quote1', 'quote2', 'quote3', 'quote4', 'quote5',
        ]);

        $response = $this->get('/api/quotes?apiKey=test_key');
        $response->assertStatus(200);
        $response->assertJson([
            'quote1', 'quote2', 'quote3', 'quote4', 'quote5',
        ]);
    }

    public function test_refresh_quotes(): void
    {
        $response = $this->get('/api/quotes?apiKey=test_key');
        $response->assertStatus(200);
        $response->assertJson([
            'quote1', 'quote2', 'quote3', 'quote4', 'quote5',
        ]);

        $refresh = $this->get('/api/quotes/refresh?apiKey=test_key');
        $refresh->assertStatus(201);

        $response = $this->get('/api/quotes?apiKey=test_key');
        $response->assertStatus(200);
        $response->assertJson([
            'quote6', 'quote7', 'quote8', 'quote9', 'quote10',
        ]);
    }
}
