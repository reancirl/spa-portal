<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\DealerGroup;
use App\Models\DealerZone;
use App\Models\ModelVehicle;
use App\Models\ModelYear;
use App\Models\User;
use App\Models\Variant;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VariantControllerTest extends TestCase
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
            // $variant = Variant::factory()->count(2)->create();
        });

        $user = User::factory()->create([
            'dealer_id' => Dealer::latest()->first()->id
        ]);
        $this->actingAs($user);
    }

    public function test_store_variant()
    {
        $this->auth_user();

        $year = ModelYear::create([
            'name'       => $this->faker->colorName(),
            'code'       => 'code-y',
            'status'     => $this->faker->boolean()
        ]);
        $model = ModelVehicle::create([
            'name'       => $this->faker->colorName,
            'code'       => 'code-v',
            'status'     => $this->faker->boolean()
        ]);


        $form = [
            'model_vehicle_id'   => $model->id,
            'year_id'            => $year->id,
            'name'               =>  $this->faker->colorName,
            'code'               => 'code-var',
            'price'              => $this->faker->randomNumber(),
            'status'             => $this->faker->boolean()
        ];


        $response = $this->post('api/v1/variants', $form);
        $response->dump();
        $response->assertStatus(200);
    }


    public function test_update_variant()
    {
        $this->auth_user();

        $year = ModelYear::create([
            'name'       => $this->faker->colorName(),
            'code'       => 'code-y',
            'status'     => $this->faker->boolean()
        ]);
        $model = ModelVehicle::create([
            'name'       => $this->faker->colorName,
            'code'       => 'code-v',
            'status'     => $this->faker->boolean()
        ]);
        $variant = Variant::factory()->create();


        $form = [
            'model_vehicle_id'   => $model->id,
            'year_id'            => $year->id,
            'name'               =>  $this->faker->colorName,
            'code'               => 'code-var',
            'price'              => $this->faker->randomNumber(),
            'status'             => $this->faker->boolean()
        ];


        $response = $this->put("api/v1/variants/$variant->id", $form);
        $response->dump();
        $response->assertStatus(200);
    }
}
