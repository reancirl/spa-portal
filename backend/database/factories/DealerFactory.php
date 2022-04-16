<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dealer>
 */
class DealerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'              => $this->faker->name,
            'code'              =>$this->faker->unique->countryCode,
            'description'       => $this->faker->sentence,
            'email'             => $this->faker->email,
            'address_details'   => $this->faker->sentence,

        ];
    }
}
