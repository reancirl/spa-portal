<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\DealerGroup;
use App\Models\DealerZone;
use App\Models\Leads;
use App\Models\UploadStatus;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeadsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function auth_user()
    {
        $group   = DealerGroup::factory()->count(2)->create();
        $zones   = DealerZone::factory()->count(5)->create();

        $group->each(function ($item, $key) use ($zones) {
            $dealers =  Dealer::factory()->count(2)->create([
                'group_id' => $item->id,
                'zone_id'  => $zones[$key]->id
            ]);
            $variant = Variant::factory()->count(2)->create();
        });
    }

    public function test_index_hcpi_leads()
    {
        $this->auth_user();
        $user = User::factory()->create([]);
        $this->actingAs($user);

        $leads = Leads::factory()->count(7)->create();

        $response = $this->get('api/v1/leads');
        $response->assertStatus(200);
    }
    public function test_index_dealer_leads()
    {
        $this->auth_user();
        $user = User::factory()->create([
            'dealer_id' => Dealer::latest()->first()->id
        ]);
        $this->actingAs($user);

        $leads = Leads::factory()->count(5)->create([
            'dealer_id' => $user->dealer_id
        ]);


        $response = $this->get('api/v1/leads');
        $response->assertStatus(200);
    }

    public function test_update_leads()
    {
        $this->auth_user();
        $user = User::factory()->create();
        $this->actingAs($user);

        $leads = Leads::factory()->create();

        $formData = [
            'assigned_sc_user_id' => 1,
            'street'              => $this->faker->address() . 'updated',
            'province'   => $this->faker->address() . 'updated',
            'municipality'   => $this->faker->address() . 'updated',
            'barangay'  => $this->faker->address() . 'updated',
            'zipcode'  => $this->faker->address() . 'updated',
            'status'    => UploadStatus::STAT_PENDING
        ];
        $response = $this->put("api/v1/leads/$leads->id", $formData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('leads', [
            'assigned_sc_user_id'     => $formData['assigned_sc_user_id'],
            'street'                  => $formData['street'],
            'province'                => $formData['province'],
            'municipality'            => $formData['municipality'],
            'barangay'                => $formData['barangay'],
            'zipcode'                 => $formData['zipcode'],
            'status'                  => $formData['status'],
        ]);
    }
}
