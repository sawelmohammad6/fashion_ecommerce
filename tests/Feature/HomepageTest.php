<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_about_page_returns_successful_response(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
    }

    public function test_contact_page_returns_successful_response(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
    }

    public function test_search_page_returns_successful_response(): void
    {
        $response = $this->get('/search');
        $response->assertStatus(200);
    }

    public function test_sitemap_returns_successful_response(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
    }
}
