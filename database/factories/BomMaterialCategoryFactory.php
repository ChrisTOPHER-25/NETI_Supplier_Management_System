<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BomMaterialCategory>
 */
class BomMaterialCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'department_id' => fake()->numberBetween(0, 10),
            'unit' => fake()->name(),
            'uses_brand' => fake()->numberBetween(0, 1),
        ];
    }
}
