<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->get('/')->assertOk()->assertSee('Nʋngʋra');
    }

    public function test_dictionary_page_loads(): void
    {
        $this->get('/dictionary')->assertOk();
    }

    public function test_admin_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect();
    }
}
