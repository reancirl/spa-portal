<?php

namespace Tests\Feature;

use App\Models\Color;
use App\Models\Dealer;
use App\Models\DealerGroup;
use App\Models\DealerZone;
use App\Models\User;
use App\Models\Variant;
use App\Models\VariantColor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class VariantColorControllerTest extends TestCase
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

    public function test_store_variantColors()
    {
        /** if custom */
        $this->auth_user();

        $variant = Variant::factory()->create([
            'price' => 999
        ]);
        $color = Color::factory()->create();


        $form = [
            'variant_id'    => $variant->id,
            'color_id'      => $color->id,
            'name'          => $this->faker->colorName,
            'price'         => $this->faker->randomNumber(),
            'pricing'       => 'custom',
            'code'          => Str::random(5),
            'status'        => $this->faker->boolean()
        ];


        $response = $this->post('api/v1/variant/colors', $form);
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_store_variantColors_inherit()
    {
        /** if inherit */
        $this->auth_user();

        $variant = Variant::factory()->create([
            'price' => 55
        ]);
        $color = Color::factory()->create();


        $form = [
            'variant_id'    => $variant->id,
            'color_id'      => $color->id,
            'name'          => $this->faker->colorName,
            'price'         => $this->faker->randomNumber(),
            'pricing'       => 'inherit',
            'code'          => Str::random(5),
            'status'        => $this->faker->boolean()
        ];


        $response = $this->post('api/v1/variant/colors', $form);
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_put_variantColors()
    {
        /** if inherit */
        $this->auth_user();

        $variant = Variant::factory()->create([
            'price' => 55555
        ]);
        $color = Color::factory()->create();
        $variant_color = VariantColor::create([
            'variant_id'    => $variant->id,
            'color_id'      => $color->id,
            'name'          => $this->faker->colorName,
            'price'         => $this->faker->randomNumber(),
            'pricing'       => 'custom',
            'code'          => Str::random(5),
            'status'        => $this->faker->boolean()
        ]);


        $form = [
            'variant_id'    => $variant->id,
            'color_id'      => $color->id,
            'name'          => $this->faker->colorName . 'x',
            'price'         => 8888,
            'pricing'       => 'inherit',
            'code'          => Str::random(5),
            'status'        => $this->faker->boolean()
        ];


        $response = $this->put("api/v1/variant/colors/$variant_color->id", $form);
        $response->dump();
        $response->assertStatus(200);
    }
}
