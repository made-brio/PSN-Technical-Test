<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Address;
use App\Models\Customer;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    protected $customer;

    public function setUp(): void
    {
        parent::setUp();
        $this->customer = Customer::factory()->create();
    }

    /** @test */
    public function it_can_create_an_address()
    {
        $data = [
            'customer_id' => $this->customer->id,
            'address' => '123 Main St',
            'district' => 'Central',
            'city' => 'Metropolis',
            'province' => 'Somewhere',
            'postal_code' => 12345,
        ];

        $response = $this->postJson('/api/addresses', $data);

        $response->assertStatus(201)
            ->assertJson($data);

        $this->assertDatabaseHas('addresses', ['address' => '123 Main St']);
    }

    /** @test */
    public function it_requires_valid_data_to_create_an_address()
    {
        $response = $this->postJson('/api/addresses', []);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_can_update_an_address()
    {
        $address = Address::factory()->create(['customer_id' => $this->customer->id]);

        $updatedData = ['address' => '456 New St'];

        $response = $this->putJson("/api/addresses/{$address->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson($updatedData);

        $this->assertDatabaseHas('addresses', ['id' => $address->id, 'address' => '456 New St']);
    }

    /** @test */
    public function it_returns_404_if_address_not_found_on_update()
    {
        $response = $this->putJson('/api/addresses/999', ['address' => 'New Address']);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Address not found']);
    }

    /** @test */
    public function it_can_delete_an_address()
    {
        $address = Address::factory()->create(['customer_id' => $this->customer->id]);

        $response = $this->deleteJson("/api/addresses/{$address->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Address deleted successfully']);

        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }

    /** @test */
    public function it_returns_404_if_address_not_found_on_delete()
    {
        $response = $this->deleteJson('/api/addresses/999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Address not found']);
    }
}
