<?php

namespace Database\Factories;

use App\Models\Dealer;
use App\Models\UploadStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestDrive>
 */
class TestDriveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name'  => $this->faker->lastName(),
            'first_name'            => $this->faker->firstName(),
            'last_name'             => $this->faker->lastName(),
            'assigned_sc_user_id'   => User::first()->id,
            'dealer_code'           => Dealer::factory()->create()->id,
            'status'                => UploadStatus::STAT_PENDING,
            'action'                => $this->faker->sentence()
        ];
    }
}
