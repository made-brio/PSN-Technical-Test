<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Customer;

class CustomerTest extends TestCase
{
    use RefreshDatabase; // Resets database after each test

    /** @test */
    public function it_can_fetch_all_customers()
    {
        Customer::factory()->count(3)->create();

        $response = $this->getJson('/api/customers');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_fetch_a_single_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->getJson("/api/customers/{$customer->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $customer->id,
                'name' => $customer->name,
            ]);
    }

    /** @test */
    public function it_returns_404_if_customer_not_found()
    {
        $response = $this->getJson('/api/customers/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Customer not found']);
    }

    /** @test */
    public function it_can_create_a_customer()
    {
        $data = [
            'title' => 'Mr.',
            'name' => 'John Doe',
            'gender' => 'Male',
            'phone_number' => '123456789',
            'email' => 'john@example.com',
            'image' => 'profile.jpg',
        ];

        $response = $this->postJson('/api/customers', $data);

        $response->assertStatus(201)
            ->assertJson($data);

        $this->assertDatabaseHas('customers', ['email' => 'john@example.com']);
    }

    /** @test */
    public function it_requires_valid_data_to_create_a_customer()
    {
        $response = $this->postJson('/api/customers', []);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_can_update_a_customer()
    {
        $customer = Customer::factory()->create();

        $updatedData = ['name' => 'Updated Name'];

        $response = $this->putJson("/api/customers/{$customer->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson($updatedData);

        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'Updated Name']);
    }

    /** @test */
    public function it_returns_404_if_customer_not_found_on_update()
    {
        $response = $this->putJson('/api/customers/999', ['name' => 'Test']);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Customer not found']);
    }

    /** @test */
    public function it_can_delete_a_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->deleteJson("/api/customers/{$customer->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Customer deleted successfully']);

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }

    /** @test */
    public function it_returns_404_if_customer_not_found_on_delete()
    {
        $response = $this->deleteJson('/api/customers/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Customer not found']);
    }
}
