<?php

namespace Tests\Feature;

use App\Models\Color;
use App\Models\Dealer;
use App\Models\DealerGroup;
use App\Models\DealerZone;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InventoryControllerTest extends TestCase
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

            Inventory::create([
                'dealer_id'    => $dealers[$key]->id,
                'dealer_code'    => $dealers[$key]->code,
                'dealer_name'   =>  $dealers[$key]->name,
                'variant_id'       => $variant[$key]->id,
                'variant_name' => $variant[$key]->name
            ]);
        });

        $user = User::factory()->create([
            // 'dealer_id' => Dealer::latest()->first()->id
        ]);
        $this->actingAs($user);
    }


    public function test_dealers_inventories()
    {
        $this->auth_user();
        $response = $this->get('/api/v1/inventory');
        $response->assertStatus(200);
        $response->dump();
    }

    public function test_index_inventories()
    {
        $this->auth_user();
        $response = $this->get('/api/v1/inventory');
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_add_inventory()
    {
        $this->auth_user();

        $formData = [
            'variant_code'          => 'DD189LL',
            'variant_name'          => 'BRIO 1.2RS CVT',
            'dealer_code'           => 'D506',
            'dealer_name'           => 'HCZM',
            'model_name'            => $this->faker->countryCode(),
            'model_year'            => '2022',
            'color_name'            => 'Color-1',
            'color_code'            => 'NH-797M',
        ];

        $dealer = \DB::table('dealers')
            ->where('code', $formData['dealer_code'])
            ->first();

        $variant = \DB::table('variants')
            ->where('code', $formData['variant_code'])
            ->first();

        $color = \DB::table('colors')
            ->where('code', $formData['color_code'])
            ->first();

        $response = $this->post('api/v1/inventory-add', $formData);
        $response->dump();
        $response->assertStatus(200);

        $this->assertDatabaseHas('inventories', [
            'variant_code' => $formData['variant_code'],
            'variant_id'   => $variant->id,
            'variant_name' => $formData['variant_name'],
            'dealer_id'    => $dealer->id,
            'dealer_code'  => $formData['dealer_code'],
            'dealer_name'  => $formData['dealer_name'],
            'model_name'   => $formData['model_name'],
            'model_year'   => $formData['model_year'],
            'color_name'   => $formData['color_name'],
            'color_code'   => $formData['color_code'],
            'color_id'     => $color->id,
        ]);
    }

    public function test_add_inventory_validation_required()
    {
        $this->auth_user();

        $response = $this->post('api/v1/inventory-add', [], ['Accept' => 'application/json']);
        $response->dump();
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'variant_name'  => 'The variant name field is required.',
            'variant_code'  => 'The variant code field is required.',
            'dealer_code'   => 'The dealer code field is required.',
            'dealer_name'   => 'The dealer name field is required.',
            'model_name'    => 'The model name field is required.',
            'model_year'    => 'The model year field is required.',
            'color_code'    => 'The color code field is required.',
        ]);
    }

    public function test_add_inventory_validation_code_doesnt_exists()
    {
        $this->auth_user();

        $formData = [
            'variant_code'          => 'abc',
            'variant_name'          => 'BRIO 1.2RS CVT',
            'dealer_code'           => 'qwe',
            'dealer_name'           => 'HCZM',
            'model_name'            => $this->faker->countryCode(),
            'model_year'            => '2022',
            'color_name'            => 'Color-1',
            'color_code'            => 'xzc',
        ];


        $response = $this->post('api/v1/inventory-add', $formData, ['Accept' => 'application/json']);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'color_code'    => 'The selected color code is invalid.',
            'variant_code'  => 'The selected variant code is invalid.',
            'dealer_code'   => 'The selected dealer code is invalid.',
        ]);
    }

    public function test_update_inventory()
    {
        $this->auth_user();

        $inventory = Inventory::latest()->first();

        $formData = [
            'variant_code'          => 'RU583ML',
            'variant_name'          => 'HR-V 1.8E CVT',
            'dealer_code'           => 'B307',
            'dealer_name'           => 'HCZM',
            'model_name'            => $this->faker->countryCode(),
            'model_year'            => '2044',
            'color_name'            => 'Color-Test',
            'color_code'            => 'NH-830M',
            'quantity'              => 2
        ];

        $response = $this->put("api/v1/inventory/$inventory->id", $formData);
        $response->dump();
        $response->assertStatus(200);
    }
}
