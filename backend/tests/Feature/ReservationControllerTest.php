<?php

namespace Tests\Feature;

use App\Models\Color;
use App\Models\Dealer;
use App\Models\DealerGroup;
use App\Models\DealerZone;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
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
            Variant::factory()->count(2)->create();

            Color::factory()->count(2)->create();
        });

        $user = User::factory()->create([
            'dealer_id' => Dealer::latest()->first()->id
        ]);
        $this->actingAs($user);
    }
    public function auth_user_hcpi()
    {
        $group   = DealerGroup::factory()->count(2)->create();
        $zones   = DealerZone::factory()->count(5)->create();

        $group->each(function ($item, $key) use ($zones) {
            $dealers =  Dealer::factory()->count(2)->create([
                'group_id' => $item->id,
                'zone_id'  => $zones[$key]->id
            ]);
            Variant::factory()->count(2)->create();

            Color::factory()->count(2)->create();
        });

        $user = User::factory()->create();
        $this->actingAs($user);
    }


    public function test_add_online_reservation()
    {
        $this->auth_user_hcpi();

        $formData = [
            'title'                         => $this->faker()->sentence,
            'first_name'                    => $this->faker()->firstName,
            'last_name'                     => $this->faker()->lastName,
            'birthdate'                     => $this->faker()->date,
            'province'                      => $this->faker()->countryCode,
            'municipality'                  => 'mcpl ' . $this->faker()->country,
            'zipcode'                       => $this->faker()->countryCode,
            'barangay'                      => 'brgy ' . $this->faker()->sentence,
            'street'                        => 'str ' . $this->faker()->sentence,
            'mobile'                        => $this->faker()->phoneNumber,
            'preferred_communication'       => $this->faker()->sentence,
            'email'                         => $this->faker()->email,
            'dealer_id'                     => Dealer::first()->id,
            'dealer_name'                   => $this->faker()->name,
            'model_name'                    => $this->faker()->name,
            'variant_id'                    => Variant::first()->id,
            'variant_name'                  => $this->faker()->name,
            'color'                         => $this->faker()->colorName,
            'color_id'                      => Color::first()->id,
            'pending_since_date'            => $this->faker()->date,
            'payment_method'                => $this->faker()->sentence(),
            'assigned_sc_user_id'           => auth()->user()->id,
            'sc_assigned_at'                => $this->faker()->date,
            'status'                        => $this->faker()->sentence(),
            'action'                        => $this->faker()->sentence(),
            'source'                        => $this->faker()->sentence(),
            'reserved_at'                   => $this->faker()->date,
        ];
        $response = $this->post('api/v1/reservation/', $formData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('reservations', [
            'title'                   => $formData['title'],
            'first_name'              => $formData['first_name'],
            'last_name'               => $formData['last_name'],
            'birthdate'               => $formData['birthdate'],
            'province'                => $formData['province'],
            'municipality'            => $formData['municipality'],
            'zipcode'                 => $formData['zipcode'],
            'barangay'                => $formData['barangay'],
            'street'                  => $formData['street'],
            'mobile'                  => $formData['mobile'],
            'preferred_communication' => $formData['preferred_communication'],
            'email'                   => $formData['email'],
            'dealer_id'               => $formData['dealer_id'],
            'dealer_name'             => $formData['dealer_name'],
            'model_name'              => $formData['model_name'],
            'variant_name'            => $formData['variant_name'],
            'variant_id'              => $formData['variant_id'],
            'color'                   => $formData['color'],
            'color_id'                => $formData['color_id'],
            'pending_since_date'      => $formData['pending_since_date'],
            'payment_method'          => $formData['payment_method'],
            'assigned_sc_user_id'     => $formData['assigned_sc_user_id'],
            'sc_assigned_at'          => $formData['sc_assigned_at'],
            'status'                  => $formData['status'],
            'action'                  => $formData['action'],
            'source'                  => $formData['source'],
            'reserved_at'             => $formData['reserved_at'],
        ]);
    }

    public function test_update_online_reservation_dealer()
    {
        $this->auth_user();

        $reservation = Reservation::factory()->create();

        $formData = [
            'assigned_sc_user_id'           => auth()->user()->id,
            'sc_assigned_at'                => $this->faker()->date,
            'status'                        => $this->faker()->sentence(),
            'action'                        => $this->faker()->sentence(),
            'source'                        => $this->faker()->sentence(),
            'reserved_at'                   => $this->faker()->date,
        ];
        $response = $this->put("api/v1/reservation/$reservation->id", $formData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('reservations', [
            'assigned_sc_user_id'     => $formData['assigned_sc_user_id'],
            'sc_assigned_at'          => $formData['sc_assigned_at'],
            'status'                  => $formData['status'],
            'action'                  => $formData['action'],
            'source'                  => $formData['source'],
        ]);
    }

    public function test_update_online_reservation_hcpi()
    {
        $this->auth_user_hcpi();

        $reservation = Reservation::factory()->create();

        $formData = [
            'title'                         => $this->faker()->sentence,
            'first_name'                    => $this->faker()->firstName,
            'last_name'                     => $this->faker()->lastName,
            'birthdate'                     => $this->faker()->date,
            'province'                      => $this->faker()->countryCode,
            'municipality'                  => 'mcpl ' . $this->faker()->country,
            'zipcode'                       => $this->faker()->countryCode,
            'barangay'                      => 'brgy ' . $this->faker()->sentence,
            'street'                        => 'str ' . $this->faker()->sentence,
            'mobile'                        => $this->faker()->phoneNumber,
            'preferred_communication'       => $this->faker()->sentence,
            'email'                         => $this->faker()->email,
            'dealer_id'                     => Dealer::first()->id,
            'dealer_name'                   => $this->faker()->name,
            'model_name'                    => $this->faker()->name,
            'variant_id'                    => Variant::first()->id,
            'variant_name'                  => $this->faker()->name,
            'color'                         => $this->faker()->colorName,
            'color_id'                      => Color::first()->id,
            'pending_since_date'            => $this->faker()->date,
            'payment_method'                => $this->faker()->sentence(),
            'assigned_sc_user_id'           => auth()->user()->id,
            'sc_assigned_at'                => $this->faker()->date,
            'status'                        => $this->faker()->sentence(),
            'action'                        => $this->faker()->sentence(),
            'source'                        => $this->faker()->sentence(),
            'reserved_at'                   => $this->faker()->date,
        ];
        $response = $this->put("api/v1/reservation/$reservation->id", $formData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('reservations', [
            'assigned_sc_user_id'     => $formData['assigned_sc_user_id'],
            'sc_assigned_at'          => $formData['sc_assigned_at'],
            'status'                  => $formData['status'],
            'action'                  => $formData['action'],
            'source'                  => $formData['source'],
        ]);
    }


    public function test_index_online_reservation()
    {
        $this->auth_user();
        $dealer2 = User::factory()->create([
            'dealer_id' => Dealer::factory()->create()->id
        ]);


        Reservation::factory()->count(8)->create([
            'dealer_id' => auth()->user()->dealer_id
        ]);
        Reservation::factory()->count(10)->create([
            'dealer_id' => $dealer2->dealer_id
        ]);

        $response = $this->get("api/v1/reservation");
        $response->assertStatus(200);
    }
}
