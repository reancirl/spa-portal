<?php

namespace Tests\Feature;

use App\Models\Color;
use App\Models\Dealer;
use App\Models\DealerGroup;
use App\Models\DealerZone;
use App\Models\Quotation;
use App\Models\UploadStatus;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuotationControllerTest extends TestCase
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
        $color   = Color::factory()->count(5)->create();

        $group->each(function ($item, $key) use ($zones) {
            $dealers =  Dealer::factory()->count(2)->create([
                'group_id' => $item->id,
                'zone_id'  => $zones[$key]->id
            ]);
            $variant = Variant::factory()->count(2)->create();
        });
    }

    public function test_store_quotation()
    {
        $this->auth_user();
        $user = User::factory()->create();
        $this->actingAs($user);

        $formData = [
            'customer_id'           => $this->faker->hexColor(),
            'title'                 => $this->faker->title(),
            'first_name'            => $this->faker->firstName(),
            'last_name'             => $this->faker->lastName(),
            'birthdate'             => $this->faker->date(),
            'province'              => $this->faker->address(),
            'municipality'          => $this->faker->address(),
            'zipcode'               => $this->faker->countryCode(),
            'barangay'              => $this->faker->country(),
            'street'                => $this->faker->streetAddress(),
            'mobile'                => $this->faker->phoneNumber(),
            'email'                 => $this->faker->email(),
            'dealer_id'             => Dealer::first()->id,
            'dealer_name'           => $this->faker->name(),
            'model_name'            => $this->faker->colorName(),
            'variant_id'            => Variant::first()->id,
            'variant_name'          => $this->faker->colorName(),
            'color_name'            => $this->faker->colorName(),
            'color_id'              => Color::first()->id,
            'assigned_sc_user_id'   =>  User::first()->id,
            'status'                =>  UploadStatus::STAT_PROCESSING,
            'action'                => $this->faker->sentence(),
            'source'                => $this->faker->sentence(),
            'document'              => $this->faker->filePath(),
        ];

        $response = $this->post('api/v1/quotation', $formData);
        $response->dump();
        $response->assertStatus(200);

        $this->assertDatabaseHas('quotations', [
            'customer_id'           => $formData['customer_id'],
            'title'                 => $formData['title'],
            'first_name'            => $formData['first_name'],
            'last_name'             => $formData['last_name'],
            'birthdate'             => $formData['birthdate'],
            'province'              => $formData['province'],
            'municipality'          => $formData['municipality'],
            'zipcode'               => $formData['zipcode'],
            'barangay'              => $formData['barangay'],
            'street'                => $formData['street'],
            'mobile'                => $formData['mobile'],
            'email'                 => $formData['email'],
            'dealer_id'             => $formData['dealer_id'],
            'dealer_name'           => $formData['dealer_name'],
            'model_name'            => $formData['model_name'],
            'variant_id'            => $formData['variant_id'],
            'color_name'            => $formData['color_name'],
            'color_id'              => $formData['color_id'],
            'assigned_sc_user_id'   => $formData['assigned_sc_user_id'],
            'status'                => $formData['status'],
            'action'                => $formData['action'],
            'source'                => $formData['source'],
            'document'              => $formData['document'],
        ]);

    }

    public function test_update_quotation()
    {
        $this->auth_user();
        $user = User::factory()->create();
        $this->actingAs($user);
        $quotation = Quotation::factory()->create([
            'assigned_sc_user_id' =>auth()->user()->id
        ]);

        $user_sc =  User::factory()->create();
        $formData = [
            'customer_id'           => $this->faker->hexColor(),
            'title'                 => $this->faker->title(),
            'first_name'            => $this->faker->firstName(),
            'last_name'             => $this->faker->lastName(),
            'birthdate'             => $this->faker->date(),
            'province'              => $this->faker->address(),
            'municipality'          => $this->faker->address(),
            'zipcode'               => $this->faker->countryCode(),
            'barangay'              => $this->faker->country(),
            'street'                => $this->faker->streetAddress(),
            'mobile'                => $this->faker->phoneNumber(),
            'email'                 => $this->faker->email(),
            'dealer_id'             => Dealer::first()->id,
            'dealer_name'           => $this->faker->name(),
            'model_name'            => $this->faker->colorName(),
            'variant_id'            => Variant::first()->id,
            'variant_name'          => $this->faker->colorName(),
            'color_name'            => $this->faker->colorName(),
            'color_id'              => Color::first()->id,
            'assigned_sc_user_id'   =>  $user_sc->id,
            'status'                =>  UploadStatus::STAT_PROCESSING,
            'action'                => $this->faker->sentence(),
            'source'                => $this->faker->sentence(),
            'document'              => $this->faker->filePath(),
        ];

        $response = $this->put("api/v1/quotation/$quotation->id", $formData);
        $response->dump();
        $response->assertStatus(200);

        $this->assertDatabaseHas('quotations', [
            'assigned_sc_user_id'   => $formData['assigned_sc_user_id'],
            'status'                => $formData['status'],
            'action'                => $formData['action'],
        ]);

    }

    public function test_index_quotation()
    {
        $this->auth_user();
        $user = User::factory()->create();
        $this->actingAs($user);

        $quotation = Quotation::factory()->count(13)->create();

        $response = $this->get("api/v1/quotation");
        $response->dump();
        $response->assertStatus(200);

    }
}
