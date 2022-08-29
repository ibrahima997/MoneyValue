<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ratio;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ratio>
 */
class RatioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'currency_from' => $this->faker->name, // This is the default behavior
            // 'currency_to' => $this->faker->name, // This is the default behavior
            // 'ratio' => $this->faker->name, // This is the default behavior
            // 'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'), // This is the default behavior

        ];
    }
}
