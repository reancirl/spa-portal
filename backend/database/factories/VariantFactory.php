<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'   => $this->faker->colorName . ' variant',
            'code'   => $this->faker->unique()->safeColorName . ' variant',
            'alias'  =>$this->faker->colorName . ' variant',
            'price'  => 99,
            'status' => true
        ];
    }
}
