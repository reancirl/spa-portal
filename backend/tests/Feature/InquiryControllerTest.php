<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\DealerGroup;
use App\Models\DealerZone;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InquiryControllerTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    /**
     * Test feature for inventories.
     *
     * @return void
     */



    /**
     * REQUIREMENTS FOREIGN
     * customer id
     * dealer id - ready
     * variant_id  - ready
     * assigned_sc_user_id - user
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
            $variant = Variant::factory()->count(2)->create();
        });

        $user = User::factory()->create();
        $this->actingAs($user);
    }



    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_reservation()
    {
        $this->auth_user();
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
            'dealer_code'                   => Dealer::first()->code,
            'model_name'                    => $this->faker()->safeHexColor,
            'variant_code'                  => Variant::first()->code,
            'variant_id'                    => Variant::first()->id,
            'color_name'                    => $this->faker()->colorName,
            'inquiry_date'                  => $this->faker()->date,
            'assigned_sc_user_id'           => auth()->user()->id,
            'sc_assigned_at'                => $this->faker()->date,
            'status'                        => $this->faker()->sentence,
            'action'                        => $this->faker()->sentence,
            'source'                        => $this->faker()->sentence,
        ];


        $response = $this->post('api/v1/inquiry-add', $formData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('inquiries', [
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
            'dealer_code'             => $formData['dealer_code'],
            'model_name'              => $formData['model_name'],
            'variant_code'            => $formData['variant_code'],
            'variant_id'              => $formData['variant_id'],
            'color_name'              => $formData['color_name'],
            'inquiry_date'            => $formData['inquiry_date'],
            'assigned_sc_user_id'     => $formData['assigned_sc_user_id'],
            'sc_assigned_at'          => $formData['sc_assigned_at'],
            'status'                  => $formData['status'],
            'action'                  => $formData['action'],
            'source'                  => $formData['source'],
        ]);
    }

    public function test_update_inquiry_dealer()
    {
        $this->auth_user();
        $inquiry = Inquiry::factory()->create();

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
            'dealer_code'                   => Dealer::first()->code,
            'model_name'                    => $this->faker()->safeHexColor,
            'variant_code'                  => Variant::first()->code,
            'variant_id'                    => Variant::first()->id,
            'color_name'                    => $this->faker()->colorName,
            'inquiry_date'                  => $this->faker()->date,
            'assigned_sc_user_id'           => auth()->user()->id,
            'sc_assigned_at'                => $this->faker()->date,
            'status'                        => $this->faker()->sentence,
            'action'                        => $this->faker()->sentence,
            'source'                        => $this->faker()->sentence,
        ];

        $response = $this->put("api/v1/inquiry/$inquiry->id", $formData);
        $response->dump();
        $response->assertStatus(200);
        $this->assertDatabaseHas('inquiries', [
            'assigned_sc_user_id'     => $formData['assigned_sc_user_id'],
            'sc_assigned_at'          => $formData['sc_assigned_at'],
            'status'                  => $formData['status'],
            'action'                  => $formData['action'],
            'source'                  => $formData['source'],
        ]);
    }
    public function test_update_inquiry_hcpi()
    {
        $this->auth_user_hcpi();
        $inquiry = Inquiry::factory()->create();

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
            'dealer_code'                   => Dealer::first()->code,
            'model_name'                    => $this->faker()->safeHexColor,
            'variant_code'                  => Variant::first()->code,
            'variant_id'                    => Variant::first()->id,
            'color_name'                    => $this->faker()->colorName,
            'inquiry_date'                  => $this->faker()->date,
            'assigned_sc_user_id'           => auth()->user()->id,
            'sc_assigned_at'                => $this->faker()->date,
            'status'                        => $this->faker()->sentence,
            'action'                        => $this->faker()->sentence,
            'source'                        => $this->faker()->sentence,
        ];

        $response = $this->put("api/v1/inquiry/$inquiry->id", $formData);
        $response->dump();
        $response->assertStatus(200);
        $this->assertDatabaseHas('inquiries', [
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
            'dealer_code'             => $formData['dealer_code'],
            'model_name'              => $formData['model_name'],
            'variant_code'            => $formData['variant_code'],
            'variant_id'              => $formData['variant_id'],
            'color_name'              => $formData['color_name'],
            'inquiry_date'            => $formData['inquiry_date'],
            'assigned_sc_user_id'     => $formData['assigned_sc_user_id'],
            'sc_assigned_at'          => $formData['sc_assigned_at'],
            'status'                  => $formData['status'],
            'action'                  => $formData['action'],
            'source'                  => $formData['source'],
        ]);
    }

    public function test_index_inquiries()
    {
        $this->auth_user();
        $dealer2 = User::factory()->create([
            'dealer_id' => Dealer::factory()->create()->id
        ]);

        Inquiry::factory()->count(5)->create([
            'dealer_id' => auth()->user()->dealer_id
        ]);

        Inquiry::factory()->count(10)->create([
            'dealer_id' => $dealer2->dealer_id
        ]);

        $response = $this->get('api/v1/inquiry');
        $response->dump();
        $response->assertStatus(200);
    }
}
