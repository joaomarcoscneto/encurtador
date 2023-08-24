<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Factories\LinkFactory;
use App\Models\Link;

class LinkTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_list_links(): void
    {

        Link::factory()->count(2)->create();

        dd(Link::all());
        $response = $this->get('/api/links');

        $response->assertStatus(200);
    }
}
