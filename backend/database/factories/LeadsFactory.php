<?php

namespace Database\Factories;

use App\Models\UploadStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LeadsFactory extends Factory
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
            'uploaded_at' => Carbon::now(),
            'accepted_at'  =>  Carbon::now()->addDay(2),
            'street' => $this->faker->streetAddress(),
            'status' => UploadStatus::STAT_PENDING,
            'province' => $this->faker->address(),
            'mobile' => $this->faker->phoneNumber(),
            'zipcode' => $this->faker->randomDigit(),
            'email' => $this->faker->email(),
            'sc_assigned_at' => $this->faker->date,
            'color' => $this->faker->colorName(),
            'variant_name' => $this->faker->countryCode(),
        ];
    }
}
