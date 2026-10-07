<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesReturnRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_return_index_route_is_available(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('sales.returns.index'))
            ->assertOk();
    }

    public function test_sales_return_create_route_is_available(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('sales.returns.create'))
            ->assertOk();
    }
}
