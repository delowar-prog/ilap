<?php

namespace Tests\Feature;

use App\Models\Campus;
use App\Models\Country;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampusTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
    }

    public function test_campus_can_be_created_and_code_is_generated_correctly(): void
    {
        // 1. Create a country with ISO2 code
        $country = Country::create([
            'name' => 'Bangladesh',
            'iso2' => 'BD',
            'status' => 'active',
        ]);

        // 2. Authenticate as a Super Admin user
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        // 3. Post to create campus
        $response = $this->actingAs($admin)->post(route('campuses.store'), [
            'name' => 'Bangla Soft',
            'country' => 'Bangladesh',
            'city' => 'Dhaka',
            'phone' => '+8801700000000',
            'email' => 'banglasoft@example.com',
            'currency' => 'BDT',
            'timezone' => 'Asia/Dhaka',
            'status' => 'active',
        ]);

        $response->assertRedirect(route('campuses.index'));
        $response->assertSessionHasNoErrors();

        // 4. Assert campus was created with the correct generated campus_code
        $this->assertDatabaseHas('campuses', [
            'name' => 'Bangla Soft',
            'campus_code' => 'BDBSTC1',
            'country' => 'Bangladesh',
            'city' => 'Dhaka',
        ]);
    }

    public function test_campus_code_generation_sequencing(): void
    {
        // Create country
        $country = Country::create([
            'name' => 'Bangladesh',
            'iso2' => 'BD',
            'status' => 'active',
        ]);

        // Authenticate
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        // Create first campus
        $this->actingAs($admin)->post(route('campuses.store'), [
            'name' => 'Bangla Soft',
            'country' => 'Bangladesh',
            'city' => 'Dhaka',
            'phone' => '+8801700000000',
            'email' => 'banglasoft1@example.com',
            'currency' => 'BDT',
            'timezone' => 'Asia/Dhaka',
            'status' => 'active',
        ]);

        // Create second campus with same name and country
        $this->actingAs($admin)->post(route('campuses.store'), [
            'name' => 'Bangla Soft',
            'country' => 'Bangladesh',
            'city' => 'Dhaka',
            'phone' => '+8801700000001',
            'email' => 'banglasoft2@example.com',
            'currency' => 'BDT',
            'timezone' => 'Asia/Dhaka',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('campuses', [
            'name' => 'Bangla Soft',
            'campus_code' => 'BDBSTC1',
        ]);

        $this->assertDatabaseHas('campuses', [
            'name' => 'Bangla Soft',
            'campus_code' => 'BDBSTC2',
        ]);
    }
}
