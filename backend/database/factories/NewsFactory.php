<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    use WithFaker;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'title' => $this->faker->title,
            'slug'  => $this->faker->unique()->colorName,
            'image' => $this->faker->hexColor,
            'summary' => $this->faker->sentence,
            'content' => $this->faker->sentence,
            'content_url' => $this->faker->imageUrl,
            'precedence' => 123,
            'featured' => true,
            'status' => true,
            'published_at' => $this->faker->date,
            // 'created_by_user_id' => User::factory()->create()->id,
            // 'updated_by_user_id' =>  User::factory()->create()->id
        ];
    }
}
