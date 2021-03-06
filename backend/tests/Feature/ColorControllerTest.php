<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\DealerGroup;
use App\Models\DealerZone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ColorControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
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
        });

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_store_colorsxx()
    {
        $this->auth_user();
        $file =  UploadedFile::fake()->image('random.jpg');


        $form = [
            'name' => $this->faker->year(),
            'code' => $this->faker->countryCode(),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->boolean(),
            'image'   =>  $file
        ];



        $response = $this->post('api/v1/colors', $form);
        $response->dump();
        $response->assertStatus(200);


        $this->assertDatabaseHas('colors', [
            'name'                  => $form['name'],
            'code'                  => $form['code'],
            'status'                => $form['status'],
            'description'           => $form['description'],
        ]);
    }
}
