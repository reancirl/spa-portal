<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\DealerGroup;
use App\Models\DealerZone;
use App\Models\TestDrive;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestDriveControllerTest extends TestCase
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

    public function test_index_hcpi_testDrive()
    {
        $dealer = Dealer::factory()->create();
        $this->auth_user();
        $user = User::factory()->create();
        $this->actingAs($user);

        $testDrive = TestDrive::factory()->count(7)->create();

        $response = $this->get('api/v1/test-drive');
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_index_dealer_testDrive()
    {
        $dealer = Dealer::factory()->create();
        $this->auth_user();
        $user = User::factory()->create([
            'dealer_id' =>         $dealer->id
        ]);
        $this->actingAs($user);

        TestDrive::factory()->count(7)->create();

        TestDrive::factory()->count(5)->create([
            'dealer_id' =>  $dealer->id
        ]);

        $response = $this->get('api/v1/test-drive');
        $response->dump();
        $response->assertStatus(200);
    }

    public function  test_update_dealer_testDrive()
    {
        $this->auth_user();
        $user = User::factory()->create();
        $this->actingAs($user);

        $testDrive = TestDrive::factory()->create();
        $form = TestDrive::factory()->make()->toArray();

        $response = $this->put("api/v1/test-drive/$testDrive->id", $form);
        $response->dump();
        $response->assertStatus(200);
    }
}
